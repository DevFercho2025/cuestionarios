<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdateWebhookRequest;
use App\Services\ApiWebhookService;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class WebhookConfigController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected ApiWebhookService $webhookService
    ) {}

    public function show(Request $request)
    {
        $client = $request->get('api_client');

        return $this->successResponse([
            'webhook_url' => $client->webhook_url,
            'has_secret' => !empty($client->webhook_secret),
        ], 'Webhook configuration retrieved.');
    }

    public function update(UpdateWebhookRequest $request)
    {
        $client = $request->get('api_client');

        $client->update([
            'webhook_url' => $request->webhook_url,
            'webhook_secret' => $request->webhook_secret ?? $client->webhook_secret,
        ]);

        return $this->successResponse([
            'webhook_url' => $client->webhook_url,
            'has_secret' => !empty($client->webhook_secret),
        ], 'Webhook configuration updated.');
    }

    public function test(Request $request)
    {
        $client = $request->get('api_client');
        $result = $this->webhookService->sendTestWebhook($client);

        $code = $result['success'] ? 200 : 422;

        return $result['success']
            ? $this->successResponse($result, 'Test webhook sent.')
            : $this->errorResponse($result['message'], $code, $result);
    }
}
