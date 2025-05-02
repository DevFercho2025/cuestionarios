<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Respuesta_Usuario;
use App\Models\TokenEvaluacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use App\Models\Aplicacion;
use Dompdf\Dompdf;

class ResultadosController extends Controller
{
    public function index()
    {
        return view('resultados.index');
    }

    public function buscarResultados(Request $request)
    {
        $tokenStr = $request->input('token');

        $token = TokenEvaluacion::where('token', $tokenStr)->first();
        if (!$token) {
            // Retorno en JSON con error
            return response()->json([
                'status'  => 'error',
                'message' => 'Token no encontrado.'
            ], 404);
        }

        $usuario = User::find($token->user_id);
        if (!$usuario) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Usuario no encontrado.'
            ], 404);
        }

        $aplicacion = Aplicacion::where('user_id', $usuario->id)->first();

        $respuestas = Respuesta_Usuario::with([
            'pregunta',
            'respuesta',
            'respuestaCorrecta.respuesta'
        ])
            ->where('user_id', $usuario->id)
            ->where('token_id', $token->id)
            ->get();

        return response()->json([
            'status'      => 'success',
            'usuario'     => $usuario,
            'aplicacion'  => $aplicacion,
            'respuestas'  => $respuestas,
            'tokenStr'    => $tokenStr,
            'token'       => $token
        ]);
    }

    
    

    public function exportarPDF($id)
    {
        $token = TokenEvaluacion::findOrFail($id);
        $usuario = User::findOrFail($token->user_id);
        $aplicacion = Aplicacion::where('user_id', $usuario->id)->first();

        $respuestas = Respuesta_Usuario::with([
            'pregunta',
            'respuesta',
            'respuestaCorrecta.respuesta'
        ])
            ->where('user_id', $usuario->id)
            ->where('token_id', $token->id)
            ->get();

        $puntuaciones = [
            'Veracidad' => 75,
            'Robo' => 60,
            'Normas' => 75,
            'Drogas y alcohol' => 75,
        ];

        $metricas = [
            [
                'titulo' => 'Veracidad',
                'puntuacion' => $puntuaciones['Veracidad'],
                'etiqueta_izq' => 'Tiende a falsear informes',
                'etiqueta_der' => 'Dice la verdad',
                'descripcion' => $this->obtenerDescripcion('Veracidad', $puntuaciones['Veracidad'])
            ],
            [
                'titulo' => 'Robo',
                'puntuacion' => $puntuaciones['Robo'],
                'etiqueta_izq' => 'Tiende a cometer robos de bienes/dinero',
                'etiqueta_der' => 'Respeta los bienes de la organización',
                'descripcion' => $this->obtenerDescripcion('Robo', $puntuaciones['Robo'])
            ],
            [
                'titulo' => 'Normas',
                'puntuacion' => $puntuaciones['Normas'],
                'etiqueta_izq' => 'Tiende a violar normas, leyes y reglamentos',
                'etiqueta_der' => 'Respeta normas, leyes y reglamentos',
                'descripcion' => $this->obtenerDescripcion('Normas', $puntuaciones['Normas'])
            ],
            [
                'titulo' => 'Drogas y alcohol',
                'puntuacion' => $puntuaciones['Drogas y alcohol'],
                'etiqueta_izq' => 'Tiende a trabajar bajo la influencia de drogas',
                'etiqueta_der' => 'No tiende a trabajar bajo la influencia de drogas',
                'descripcion' => $this->obtenerDescripcion('Drogas y alcohol', $puntuaciones['Drogas y alcohol'])
            ]
        ];

        $html = view('pdf.resultados', compact('usuario', 'aplicacion', 'respuestas', 'metricas'));
        //agregar tras lo último de la vista
        $dompdf = PDF::loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();

        return $dompdf->download("Resultados_token_{$token->token}.pdf");

        //$pdf = Pdf::loadView('pdf.resultados', compact('usuario', 'aplicacion', 'respuestas'));
        //$pdf = PDF::loadHTML($html);
        //$pdf->render();
        //return $pdf->download("resultados_token_{$token->id}.pdf");
        //return view('pdf.resultados', compact('usuario', 'aplicacion', 'respuestas', 'metricas'));
    }

    function obtenerDescripcion($titulo, $puntuacion){
        #Contenido por cambiar
        switch ($titulo) {
            case 'Veracidad':
                if ($puntuacion >= 80) return 'Muy veraz, alta confiabilidad.';
                if ($puntuacion >= 60) return 'Moderadamente veraz.';
                if ($puntuacion >= 40) return 'Puede falsear información ocasionalmente.';
                return 'Alta tendencia a falsear informes.';
    
            case 'Robo':
                if ($puntuacion >= 80) return 'Respeta completamente los bienes ajenos.';
                if ($puntuacion >= 60) return 'Bajo riesgo de conductas indebidas.';
                if ($puntuacion >= 40) return 'Riesgo moderado de conductas inapropiadas.';
                return 'Alta probabilidad de actos indebidos.';
    
            case 'Normas':
                if ($puntuacion >= 80) return 'Respeta leyes y normas.';
                if ($puntuacion >= 60) return 'Cumple normas en su mayoría.';
                if ($puntuacion >= 40) return 'Puede quebrantar normas.';
                return 'Tiende a violar reglamentos.';
    
            case 'Drogas y alcohol':
                if ($puntuacion >= 80) return 'No hay señales de consumo problemático.';
                if ($puntuacion >= 60) return 'Riesgo bajo de consumo.';
                if ($puntuacion >= 40) return 'Riesgo moderado de uso en el trabajo.';
                return 'Probabilidad alta de trabajar bajo influencias.';
    
            default:
                return 'Sin seccion disponible.';
        }
    }
}
