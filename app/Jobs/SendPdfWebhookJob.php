<?php

namespace App\Jobs;

use App\Models\ApiClient;
use App\Models\ApiCandidateMapping;
use App\Models\UserAssignedTest;
use App\Services\ApiWebhookService;
use App\Services\ResultadosService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendPdfWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public array $backoff = [30, 120, 600, 3600, 7200];

    public function __construct(
        public int $clientId,
        public int $evaluationId,
        public int $userId
    ) {}

    public function handle(ApiWebhookService $webhookService, ResultadosService $resultadosService): void
    {
        $client = ApiClient::find($this->clientId);

        if (!$client || !$client->webhook_url) {
            Log::warning("SendPdfWebhookJob: Client #{$this->clientId} not found or no webhook URL.");
            return;
        }

        $user = \App\Models\User::find($this->userId);
        $tokenEval = $user?->tokensEvaluaciones()->orderByDesc('created_at')->first();

        if (!$tokenEval) {
            Log::warning("SendPdfWebhookJob: No token found for user #{$this->userId}.");
            return;
        }

        $pdfContent = $resultadosService->generatePdf($tokenEval->id);
        $pdfBase64 = base64_encode($pdfContent);

        $mapping = ApiCandidateMapping::where('api_client_id', $this->clientId)
            ->where('user_id', $this->userId)
            ->first();

        $payload = [
            'event' => 'pdf.ready',
            'evaluation_id' => $this->evaluationId,
            'external_candidate_id' => $mapping?->external_candidate_id,
            'candidate_name' => $user?->name,
            'pdf_base64' => $pdfBase64,
            'generated_at' => now()->toIso8601String(),
        ];

        $delivery = $webhookService->dispatch($client, 'pdf.ready', $payload);

        if ($delivery) {
            $webhookService->deliver($delivery);
        }
    }
}
