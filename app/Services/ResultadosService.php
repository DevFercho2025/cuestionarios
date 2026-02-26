<?php

namespace App\Services;

use App\Models\AccessCode;
use App\Models\Respuesta_Usuario;
use App\Models\TokenEvaluacion;
use App\Models\User;
use App\Models\UserAssignedTest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Log;

class ResultadosService
{
    protected ScoringService $scoringService;

    public function __construct(ScoringService $scoringService)
    {
        $this->scoringService = $scoringService;
    }

    public function getResultsByToken(string $tokenStr): array
    {
        $token = TokenEvaluacion::where('token', $tokenStr)->first();

        if (!$token) {
            return ['status' => 'error', 'message' => 'Token no encontrado.', 'code' => 404];
        }

        $usuario = User::find($token->user_id);
        if (!$usuario) {
            return ['status' => 'error', 'message' => 'Usuario no encontrado.', 'code' => 404];
        }

        $aplicacion = AccessCode::where('user_id', $usuario->id)->first();

        $respuestas = Respuesta_Usuario::with(['pregunta', 'respuesta'])
            ->where('user_id', $usuario->id)
            ->where('token_id', $token->id)
            ->get();

        $scores = $this->scoringService->calculateForUser($usuario->id, $token->id);

        return [
            'status' => 'success',
            'usuario' => $usuario,
            'aplicacion' => $aplicacion,
            'respuestas' => $respuestas,
            'scores' => $scores,
            'tokenStr' => $tokenStr,
            'token' => $token,
            'code' => 200,
        ];
    }

    public function getResultsByUserId(int $userId): array
    {
        $usuario = User::findOrFail($userId);

        $tokenEval = TokenEvaluacion::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->first();

        if (!$tokenEval) {
            return ['status' => 'error', 'message' => 'No evaluation token found.', 'code' => 404];
        }

        $aplicacion = AccessCode::where('user_id', $userId)->first();

        $respuestas = Respuesta_Usuario::with(['pregunta', 'respuesta'])
            ->where('user_id', $userId)
            ->where('token_id', $tokenEval->id)
            ->get();

        $assignedTests = UserAssignedTest::with('test')
            ->where('user_id', $userId)
            ->get();

        $scores = $this->scoringService->calculateForUser($userId, $tokenEval->id);

        return [
            'status' => 'success',
            'usuario' => $usuario,
            'aplicacion' => $aplicacion,
            'respuestas' => $respuestas,
            'scores' => $scores,
            'token' => $tokenEval,
            'assigned_tests' => $assignedTests,
            'code' => 200,
        ];
    }

    public function generatePdf(int $tokenId): string
    {
        $token = TokenEvaluacion::findOrFail($tokenId);
        $usuario = User::findOrFail($token->user_id);
        $aplicacion = AccessCode::where('user_id', $usuario->id)->first();

        $scores = $this->scoringService->calculateForUser($usuario->id, $token->id);
        $metricas = $this->buildMetricasFromScores($scores);
        $imagenesBase64 = session("imagenes_pdf_{$tokenId}", []);

        $html = view('pdf.resultados', compact('usuario', 'aplicacion', 'metricas', 'scores', 'imagenesBase64'));
        $dompdf = PDF::loadHtml($html);
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isPhpEnabled', false);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    /**
     * Convierte los resultados del ScoringService en el formato de metricas del PDF.
     */
    public function buildMetricasFromScores(array $scores): array
    {
        $metricas = [];

        foreach ($scores as $testResult) {
            if (!isset($testResult['metricas'])) continue;

            foreach ($testResult['metricas'] as $metrica) {
                $metricas[] = [
                    'titulo' => $metrica['titulo'],
                    'puntuacion' => $metrica['puntuacion'],
                    'etiqueta_izq' => $metrica['etiqueta_izq'],
                    'etiqueta_der' => $metrica['etiqueta_der'],
                    'descripcion' => $metrica['descripcion'],
                    'test_title' => $testResult['test_title'] ?? '',
                ];
            }
        }

        return $metricas;
    }
}
