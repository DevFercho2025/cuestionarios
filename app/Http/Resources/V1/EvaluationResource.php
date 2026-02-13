<?php

namespace App\Http\Resources\V1;

use App\Models\UserTestRecord;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvaluationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $record = UserTestRecord::where('user_id', $this->user_id)
            ->where('test_id', $this->test_id)
            ->latest('id')
            ->first();

        $totalSections = Seccion::where('test_id', $this->test_id)->count();
        $completedSections = $record ? count($record->completed_sections_ids ?? []) : 0;

        if ($record && $record->finished_at) {
            $status = 'completed';
        } elseif ($completedSections > 0) {
            $status = 'in_progress';
        } else {
            $status = 'pending';
        }

        $accessCode = $this->accessCode;

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'test' => [
                'id' => $this->test?->id,
                'title' => $this->test?->test_title,
            ],
            'access_code' => $accessCode?->code,
            'status' => $status,
            'progress' => [
                'sections_completed' => $completedSections,
                'sections_total' => $totalSections,
            ],
            'finished_at' => $record?->finished_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
