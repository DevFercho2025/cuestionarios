<?php

namespace App\Services;

use App\Models\ApiClient;
use App\Models\ApiWebhookDelivery;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiWebhookService
{
    public function dispatch(ApiClient $client, string $eventType, array $payload): ?ApiWebhookDelivery
    {
        if (!$client->webhook_url) {
            return null;
        }

        return ApiWebhookDelivery::create([
            'api_client_id' => $client->id,
            'event_type' => $eventType,
            'payload' => $payload,
            'url' => $client->webhook_url,
            'status' => 'pending',
            'attempts' => 0,
        ]);
    }

    public function deliver(ApiWebhookDelivery $delivery): bool
    {
        $client = $delivery->apiClient;
        $delivery->increment('attempts');

        try {
            $headers = [
                'Content-Type' => 'application/json',
                'X-Webhook-Event' => $delivery->event_type,
                'X-Webhook-Delivery' => (string) $delivery->id,
            ];

            if ($client->webhook_secret) {
                $signature = hash_hmac('sha256', json_encode($delivery->payload), $client->webhook_secret);
                $headers['X-Webhook-Signature'] = $signature;
            }

            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->post($delivery->url, $delivery->payload);

            $delivery->http_status_code = $response->status();
            $delivery->response_body = mb_substr($response->body(), 0, 5000);

            if ($response->successful()) {
                $delivery->status = 'delivered';
                $delivery->delivered_at = now();
                $delivery->save();
                return true;
            }

            $this->scheduleRetry($delivery);
            return false;

        } catch (\Exception $e) {
            Log::error("Webhook delivery failed for delivery #{$delivery->id}", [
                'error' => $e->getMessage(),
            ]);

            $delivery->response_body = $e->getMessage();
            $this->scheduleRetry($delivery);
            return false;
        }
    }

    protected function scheduleRetry(ApiWebhookDelivery $delivery): void
    {
        $retryDelays = [30, 120, 600, 3600, 7200]; // 30s, 2m, 10m, 1h, 2h
        $attemptIndex = $delivery->attempts - 1;

        if ($attemptIndex < count($retryDelays)) {
            $delivery->status = 'retrying';
            $delivery->next_retry_at = now()->addSeconds($retryDelays[$attemptIndex]);
        } else {
            $delivery->status = 'failed';
        }

        $delivery->save();
    }

    public function sendTestWebhook(ApiClient $client): array
    {
        $testPayload = [
            'event' => 'webhook.test',
            'timestamp' => now()->toIso8601String(),
            'client_id' => $client->id,
            'message' => 'This is a test webhook delivery.',
        ];

        $delivery = $this->dispatch($client, 'webhook.test', $testPayload);

        if (!$delivery) {
            return ['success' => false, 'message' => 'No webhook URL configured.'];
        }

        $delivered = $this->deliver($delivery);

        return [
            'success' => $delivered,
            'delivery_id' => $delivery->id,
            'http_status' => $delivery->http_status_code,
            'message' => $delivered ? 'Webhook delivered successfully.' : 'Webhook delivery failed.',
        ];
    }
}
