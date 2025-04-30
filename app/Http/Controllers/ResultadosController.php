<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Respuesta_Usuario;
use App\Models\TokenEvaluacion;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Aplicacion;

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

        //$pdf = Pdf::loadView('pdf.resultados', compact('usuario', 'aplicacion', 'respuestas'));
        $html = view('pdf.resultados', compact('usuario', 'aplicacion', 'respuestas'))->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download("resultados_token_{$token->id}.pdf");
        //return view('pdf.resultados', compact('usuario', 'aplicacion', 'respuestas'));
    }
}
