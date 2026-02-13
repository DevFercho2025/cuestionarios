<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreEvaluationRequest;
use App\Http\Resources\V1\EvaluationResource;
use App\Models\ApiCandidateMapping;
use App\Models\UserAssignedTest;
use App\Services\ApiBillingService;
use App\Services\CandidatoService;
use App\Services\EvaluacionService;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EvaluationController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected EvaluacionService $evaluacionService,
        protected CandidatoService $candidatoService,
        protected ApiBillingService $billingService
    ) {}

    public function store(StoreEvaluationRequest $request)
    {
        $client = $request->get('api_client');
        $testIds = $request->input('test_ids');
        $externalCandidateId = $request->input('external_candidate_id');

        // Find or create candidate
        $user = $this->candidatoService->findByExternalId($client->id, $externalCandidateId);

        if (!$user && $request->has('candidate')) {
            $user = $this->candidatoService->createCandidate(
                $request->input('candidate'),
                $client->company_id
            );
            $this->candidatoService->findOrCreateMapping($client->id, $externalCandidateId, $user);
        }

        if (!$user) {
            return $this->errorResponse('Candidate not found. Provide candidate data or create the candidate first.', 422);
        }

        // Consume quota
        $this->billingService->consumeQuota(
            $client,
            $testIds,
            $user->id,
            null,
            $request->ip()
        );

        // Assign evaluations (companyUserId = candidate's own id since API has no logged-in admin)
        $result = $this->evaluacionService->assignForApiClient($user->id, $testIds, $user->id);
        $accessCode = $result['access_code'];

        $evaluations = UserAssignedTest::with('test')
            ->where('user_id', $user->id)
            ->whereIn('test_id', $testIds)
            ->get();

        $baseUrl = rtrim(config('app.url'), '/');

        return $this->createdResponse([
            'access_code' => $accessCode->code,
            'evaluation_url' => "{$baseUrl}/login#tab-candidate",
            'evaluations' => EvaluationResource::collection($evaluations),
        ], 'Evaluations assigned successfully.');
    }

    public function index(Request $request)
    {
        $client = $request->get('api_client');

        $candidateIds = ApiCandidateMapping::where('api_client_id', $client->id)
            ->pluck('user_id');

        $evaluations = UserAssignedTest::with('test')
            ->whereIn('user_id', $candidateIds)
            ->paginate($request->input('per_page', 25));

        return $this->paginatedResponse(
            $evaluations->through(fn($item) => new EvaluationResource($item)),
            'Evaluations retrieved.'
        );
    }

    public function show(Request $request, int $id)
    {
        $client = $request->get('api_client');

        $candidateIds = ApiCandidateMapping::where('api_client_id', $client->id)
            ->pluck('user_id');

        $evaluation = UserAssignedTest::with('test')
            ->whereIn('user_id', $candidateIds)
            ->where('id', $id)
            ->first();

        if (!$evaluation) {
            return $this->notFoundResponse('Evaluation not found.');
        }

        return $this->successResponse(
            new EvaluationResource($evaluation),
            'Evaluation retrieved.'
        );
    }
}
