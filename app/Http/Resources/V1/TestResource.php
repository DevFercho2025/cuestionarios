<?php

namespace App\Http\Resources\V1;

use App\Models\ApiTestTokenCost;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $tokenCost = ApiTestTokenCost::where('test_id', $this->id)->value('token_cost');

        return [
            'id' => $this->id,
            'title' => $this->test_title,
            'type' => $this->type?->name ?? null,
            'type_id' => $this->type_id,
            'time' => $this->time_at,
            'instructions' => $this->instructions,
            'token_cost' => $tokenCost ?? 1,
            'sections_count' => $this->sections_count ?? $this->sections()->count(),
            'questions_count' => $this->questions_count ?? $this->questions()->count(),
        ];
    }
}
