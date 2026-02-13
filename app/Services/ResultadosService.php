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

        return [
            'status' => 'success',
            'usuario' => $usuario,
            'aplicacion' => $aplicacion,
            'respuestas' => $respuestas,
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

        return [
            'status' => 'success',
            'usuario' => $usuario,
            'aplicacion' => $aplicacion,
            'respuestas' => $respuestas,
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

        $puntuaciones = [
            'Veracidad' => 75,
            'Robo' => 60,
            'Normas' => 75,
            'Drogas y alcohol' => 75,
        ];

        $metricas = $this->buildMetricas($puntuaciones);
        $imagenesBase64 = session("imagenes_pdf_{$tokenId}", []);

        $html = view('pdf.resultados', compact('usuario', 'aplicacion', 'metricas', 'imagenesBase64'));
        $dompdf = PDF::loadHtml($html);
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    protected function buildMetricas(array $puntuaciones): array
    {
        $metricas = [];
        $config = [
            'Veracidad' => ['Tiende a falsear informes', 'Dice la verdad'],
            'Robo' => ['Tiende a cometer robos de bienes/dinero', 'Respeta los bienes de la organización'],
            'Normas' => ['Tiende a violar normas, leyes y reglamentos', 'Respeta normas, leyes y reglamentos'],
            'Drogas y alcohol' => ['Tiende a trabajar bajo la influencia de drogas', 'No tiende a trabajar bajo la influencia de drogas'],
        ];

        foreach ($puntuaciones as $titulo => $puntuacion) {
            $labels = $config[$titulo] ?? ['', ''];
            $metricas[] = [
                'titulo' => $titulo,
                'puntuacion' => $puntuacion,
                'etiqueta_izq' => $labels[0],
                'etiqueta_der' => $labels[1],
                'descripcion' => $this->obtenerDescripcion($titulo, $puntuacion),
            ];
        }

        return $metricas;
    }

    protected function obtenerDescripcion(string $titulo, int $puntuacion): string
    {
        $descripciones = [
            'Veracidad' => [
                80 => 'Muy veraz, alta confiabilidad.',
                60 => 'Moderadamente veraz.',
                40 => 'Puede falsear información ocasionalmente.',
                0  => 'Alta tendencia a falsear informes.',
            ],
            'Robo' => [
                80 => 'Respeta completamente los bienes ajenos.',
                60 => 'Bajo riesgo de conductas indebidas.',
                40 => 'Riesgo moderado de conductas inapropiadas.',
                0  => 'Alta probabilidad de actos indebidos.',
            ],
            'Normas' => [
                80 => 'Respeta leyes y normas.',
                60 => 'Cumple normas en su mayoría.',
                40 => 'Puede quebrantar normas.',
                0  => 'Tiende a violar reglamentos.',
            ],
            'Drogas y alcohol' => [
                80 => 'No hay señales de consumo problemático.',
                60 => 'Riesgo bajo de consumo.',
                40 => 'Riesgo moderado de uso en el trabajo.',
                0  => 'Probabilidad alta de trabajar bajo influencias.',
            ],
        ];

        $umbrales = $descripciones[$titulo] ?? [];
        foreach ($umbrales as $umbral => $desc) {
            if ($puntuacion >= $umbral) {
                return $desc;
            }
        }

        return 'Sin descripción disponible.';
    }
}
