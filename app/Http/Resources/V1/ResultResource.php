<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->resource['usuario']->id ?? null,
            'user_name' => $this->resource['usuario']->name ?? null,
            'token' => $this->resource['token']->token ?? null,
            'application' => $this->resource['aplicacion'] ? [
                'id' => $this->resource['aplicacion']->id,
                'vacancy' => $this->resource['aplicacion']->vacancy,
                'code' => $this->resource['aplicacion']->code,
            ] : null,
            'responses_count' => isset($this->resource['respuestas']) ? $this->resource['respuestas']->count() : 0,
            'assigned_tests' => isset($this->resource['assigned_tests'])
                ? $this->resource['assigned_tests']->map(fn($at) => [
                    'test_id' => $at->test_id,
                    'test_title' => $at->test?->test_title,
                ]) : [],
        ];
    }
}
