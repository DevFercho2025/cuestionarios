<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $this->user ?? $this->resource;
        $mapping = $this->external_candidate_id ? $this : null;

        return [
            'external_id' => $mapping?->external_candidate_id,
            'id' => $user->id ?? null,
            'name' => $user->name ?? null,
            'email' => $user->email ?? null,
            'phone' => $user->info?->phone ?? null,
            'date_of_birth' => $user->info?->date_of_birth ? substr($user->info->date_of_birth, 0, 10) : null,
            'gender' => $user->info?->gender ?? null,
            'country' => $user->info?->country ?? null,
            'created_at' => $user->created_at?->toIso8601String(),
        ];
    }
}
