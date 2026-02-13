<?php

namespace App\Services;

use App\Models\User;
use App\Models\History;
use App\Models\ApiCandidateMapping;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CandidatoService
{
    public function createCandidate(array $data, int $companyId, ?int $creatorUserId = null): User
    {
        $nombreCompleto = $data['firstname'] . ' ' . $data['lastname'];

        $user = User::firstOrNew(['email' => $data['email']]);
        if (!$user->exists) {
            $user->password = bcrypt(Str::random(10));
        }
        $user->name = $nombreCompleto;
        $user->save();

        $user->config()->updateOrCreate(
            ['company_id' => $companyId],
            [
                'active' => 1,
                'role_id' => 0,
                'is_pisco_user' => 1,
            ]
        );

        $infoData = array_filter([
            'date_of_birth' => $data['nacimiento'] ?? $data['date_of_birth'] ?? null,
            'gender' => $data['genero_legal'] ?? $data['gender'] ?? null,
            'postal_code' => $data['codigo_postal'] ?? $data['postal_code'] ?? null,
            'phone' => $data['telefono'] ?? $data['phone'] ?? null,
            'country' => $data['pais'] ?? $data['country'] ?? null,
        ], fn($v) => $v !== null);

        if (!empty($infoData)) {
            $infoData['created_at'] = Carbon::now();
            $user->info()->updateOrCreate([], $infoData);
        }

        if ($creatorUserId) {
            History::create([
                'user_id' => $creatorUserId,
                'comment' => "Se creó el candidato con ID {$user->id}.",
            ]);
        }

        return $user;
    }

    public function findOrCreateMapping(int $apiClientId, string $externalCandidateId, User $user): ApiCandidateMapping
    {
        return ApiCandidateMapping::firstOrCreate(
            [
                'api_client_id' => $apiClientId,
                'external_candidate_id' => $externalCandidateId,
            ],
            [
                'user_id' => $user->id,
            ]
        );
    }

    public function findByExternalId(int $apiClientId, string $externalCandidateId): ?User
    {
        $mapping = ApiCandidateMapping::where('api_client_id', $apiClientId)
            ->where('external_candidate_id', $externalCandidateId)
            ->first();

        return $mapping?->user;
    }

    public function listCandidates(int $apiClientId)
    {
        return ApiCandidateMapping::where('api_client_id', $apiClientId)
            ->with('user.info')
            ->get();
    }
}
