<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCandidateRequest;
use App\Http\Resources\V1\CandidateResource;
use App\Services\CandidatoService;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected CandidatoService $candidatoService
    ) {}

    public function store(StoreCandidateRequest $request)
    {
        $client = $request->get('api_client');

        $user = $this->candidatoService->createCandidate(
            $request->validated(),
            $client->company_id
        );

        $mapping = $this->candidatoService->findOrCreateMapping(
            $client->id,
            $request->external_candidate_id,
            $user
        );

        return $this->createdResponse(
            new CandidateResource($mapping->load('user.info')),
            'Candidate created.'
        );
    }

    public function index(Request $request)
    {
        $client = $request->get('api_client');
        $mappings = $this->candidatoService->listCandidates($client->id);

        return $this->successResponse(
            CandidateResource::collection($mappings),
            'Candidates retrieved.'
        );
    }

    public function show(Request $request, string $externalId)
    {
        $client = $request->get('api_client');
        $user = $this->candidatoService->findByExternalId($client->id, $externalId);

        if (!$user) {
            return $this->notFoundResponse('Candidate not found.');
        }

        $mapping = $user->load('info');

        $candidateMapping = \App\Models\ApiCandidateMapping::where('api_client_id', $client->id)
            ->where('external_candidate_id', $externalId)
            ->with('user.info')
            ->first();

        return $this->successResponse(
            new CandidateResource($candidateMapping),
            'Candidate retrieved.'
        );
    }
}
