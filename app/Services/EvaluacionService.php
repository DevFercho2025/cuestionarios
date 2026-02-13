<?php

namespace App\Services;

use App\Models\AccessCode;
use App\Models\History;
use App\Models\Pregunta;
use App\Models\Respuesta_Usuario;
use App\Models\Test;
use App\Models\UserAssignedTest;
use App\Models\UserTestRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EvaluacionService
{
    public function listAvailableTests(int $userId, int $accessCodeId): \Illuminate\Support\Collection
    {
        $testsYaAsignados = UserAssignedTest::where('user_id', $userId)
            ->where('application_access_code_id', $accessCodeId)
            ->pluck('test_id');

        return Test::whereNotIn('id', $testsYaAsignados)
            ->select('id', 'test_title')
            ->get();
    }

    public function checkRecentEvaluations(int $userId, array $testIds): array
    {
        $hace6Meses = Carbon::now()->subMonths(6);
        $testsRecientes = [];

        foreach ($testIds as $testId) {
            $registroReciente = UserTestRecord::where('user_id', $userId)
                ->where('test_id', $testId)
                ->whereNotNull('finished_at')
                ->where('finished_at', '>=', $hace6Meses)
                ->first();

            if ($registroReciente) {
                $testsRecientes[] = [
                    'test_title' => Test::find($testId)->test_title,
                    'finished_at' => $registroReciente->finished_at->toDateTimeString(),
                ];
            }
        }

        return $testsRecientes;
    }

    public function assignEvaluations(int $userId, array $testIds, int $accessCodeId, int $assignerUserId, bool $force = false): array
    {
        $assigned = [];

        foreach ($testIds as $testId) {
            if ($force) {
                $this->clearPreviousResponses($userId, $testId, $assignerUserId);
            }

            $record = UserAssignedTest::firstOrCreate([
                'user_id' => $userId,
                'test_id' => $testId,
                'application_access_code_id' => $accessCodeId,
                'company_user_id' => $assignerUserId,
            ]);

            $assigned[] = [
                'test_id' => $testId,
                'was_new' => $record->wasRecentlyCreated,
            ];
        }

        History::create([
            'user_id' => $assignerUserId,
            'comment' => "Se asignaron evaluaciones (IDs: " . implode(', ', $testIds) . ") al candidato con ID {$userId}.",
        ]);

        return $assigned;
    }

    public function assignForApiClient(int $userId, array $testIds, int $companyUserId): array
    {
        $codigo = strtoupper(Str::random(10));

        $accessCode = AccessCode::create([
            'user_id' => $userId,
            'vacancy' => 'API Evaluation',
            'company_id' => null,
            'user_company_id' => $companyUserId,
            'code' => $codigo,
        ]);

        $assigned = $this->assignEvaluations($userId, $testIds, $accessCode->id, $companyUserId);

        return [
            'assigned' => $assigned,
            'access_code' => $accessCode,
        ];
    }

    public function getEvaluationsByUser(int $userId, ?int $accessCodeId = null)
    {
        $query = UserAssignedTest::with('test')
            ->where('user_id', $userId);

        if ($accessCodeId) {
            $query->where('application_access_code_id', $accessCodeId);
        }

        return $query->get();
    }

    protected function clearPreviousResponses(int $userId, int $testId, int $assignerUserId): void
    {
        $preguntasIds = Pregunta::where('test_id', $testId)->pluck('id');
        $tokens = UserTestRecord::where('user_id', $userId)
            ->where('test_id', $testId)
            ->pluck('token_id');

        Respuesta_Usuario::where('user_id', $userId)
            ->whereIn('question_id', $preguntasIds)
            ->whereIn('token_id', $tokens)
            ->delete();

        UserTestRecord::where('user_id', $userId)
            ->where('test_id', $testId)
            ->delete();

        History::create([
            'user_id' => $assignerUserId,
            'comment' => "Se borraron las respuestas pasadas del candidato con ID {$userId} al test con ID {$testId}.",
        ]);
    }
}
