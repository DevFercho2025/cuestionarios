<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ResultResource;
use App\Jobs\SendPdfWebhookJob;
use App\Models\ApiCandidateMapping;
use App\Models\UserAssignedTest;
use App\Services\ApiBillingService;
use App\Services\ResultadosService;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected ResultadosService $resultadosService,
        protected ApiBillingService $billingService
    ) {}

    public function results(Request $request, int $evaluationId)
    {
        $client = $request->get('api_client');
        $evaluation = $this->findEvaluation($client->id, $evaluationId);

        if (!$evaluation) {
            return $this->notFoundResponse('Evaluation not found.');
        }

        $results = $this->resultadosService->getResultsByUserId($evaluation->user_id);

        if ($results['status'] === 'error') {
            return $this->errorResponse($results['message'], $results['code']);
        }

        $this->billingService->logUsage(
            $client, 'result_queried', 0,
            $evaluation->test_id, $evaluation->user_id,
            $evaluation->application_access_code_id, $request->ip()
        );

        return $this->successResponse(
            new ResultResource($results),
            'Results retrieved.'
        );
    }

    public function pdf(Request $request, int $evaluationId)
    {
        $client = $request->get('api_client');
        $evaluation = $this->findEvaluation($client->id, $evaluationId);

        if (!$evaluation) {
            return $this->notFoundResponse('Evaluation not found.');
        }

        $user = $evaluation->user;
        $tokenEval = $user?->tokensEvaluaciones()->orderByDesc('created_at')->first();

        if (!$tokenEval) {
            return $this->errorResponse('No evaluation token found for this candidate.', 404);
        }

        $pdfContent = $this->resultadosService->generatePdf($tokenEval->id);

        $this->billingService->logUsage(
            $client, 'pdf_downloaded', 0,
            $evaluation->test_id, $evaluation->user_id,
            $evaluation->application_access_code_id, $request->ip()
        );

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="results_' . $evaluationId . '.pdf"',
        ]);
    }

    public function webhookPdf(Request $request, int $evaluationId)
    {
        $client = $request->get('api_client');
        $evaluation = $this->findEvaluation($client->id, $evaluationId);

        if (!$evaluation) {
            return $this->notFoundResponse('Evaluation not found.');
        }

        if (!$client->webhook_url) {
            return $this->errorResponse('No webhook URL configured for this client.', 422);
        }

        SendPdfWebhookJob::dispatch($client->id, $evaluationId, $evaluation->user_id);

        $this->billingService->logUsage(
            $client, 'pdf_webhook_sent', 0,
            $evaluation->test_id, $evaluation->user_id,
            $evaluation->application_access_code_id, $request->ip()
        );

        return $this->successResponse(null, 'PDF webhook delivery queued.');
    }

    protected function findEvaluation(int $clientId, int $evaluationId): ?UserAssignedTest
    {
        $candidateIds = ApiCandidateMapping::where('api_client_id', $clientId)
            ->pluck('user_id');

        return UserAssignedTest::with(['test', 'user'])
            ->whereIn('user_id', $candidateIds)
            ->where('id', $evaluationId)
            ->first();
    }
}
