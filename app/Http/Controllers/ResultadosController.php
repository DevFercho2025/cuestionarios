<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Respuesta_Usuario;
use App\Models\TokenEvaluacion;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Aplicacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResultadosController extends Controller
{
    public function index()
    {
        return view('resultados.index');
    }

    public function datatable(){
        try{
            $companyId = Auth::user()->config->company_id;
            $user = Auth::user();
            $isSuperAdmin = $user->config->role->isSuperAdmin() ?? false;

            $candidatos = User::with(['info', 'config.role', 'config.company'])
            ->whereHas('config.role', function ($q) {
                $q->where('id','=', 0);
            })
            ->when(!$isSuperAdmin, function ($query) use ($companyId) {
                $query->whereHas('config', function ($q) use ($companyId) {
                    $q->where('company_id', $companyId);
                });
            })->get();

            $candidatosData = $candidatos->map(function ($user) use ($isSuperAdmin) {
                 $data = [
                    'id_candidato' => $user->id,
                    'nombre' => $user->name,
                    'cuestionario' => $user->email,
                    'secciones_completadas' => optional($user->info)->fecha_nacimiento ? \Carbon\Carbon::parse($user->info->fecha_nacimiento)->toDateString() : null, // Formato de fecha
                    'token' => optional($user->info)->genero,
                    'estado' => optional($user->info)->codigo_postal,
                ];

                if ($isSuperAdmin) {
                    $data['company_name'] = $user->config->company->name ?? 'Sin compañía';
                }
                return $data;
            });
            return response()->json(['data' => $candidatosData]);

        }catch (\Exception $e) {
            return response()->json([
                'error' => 'Hubo un problema al obtener los tokens de evaluaciones.',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
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

    public function renderizarMetricas($id)
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

        return view('pdf.imagenes_reporte', compact('metricas'))->render(); #vista parcial con las gráficas
    }

    public function recibirImagenes(Request $request, $id)
    {
        $imagenesBase64 = $request->input('imagenes', []);

        session(["imagenes_pdf_{$id}" => $imagenesBase64]);
        return response()->json(['ok' => true]);
    }
    
    public function exportarPDF($id)
    {
        $token = TokenEvaluacion::findOrFail($id);
        $imagenesBase64 = session("imagenes_pdf_{$id}", []);
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

        $html = view('pdf.resultados', compact('usuario', 'aplicacion', 'respuestas', 'metricas', 'imagenesBase64'));
        $dompdf = PDF::loadHtml($html);
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();
        //return view('pdf.resultados', compact('usuario', 'aplicacion', 'respuestas', 'metricas', 'imagenesBase64'));
        return $dompdf->stream(); //ver en el navegador
        //return $dompdf->download("Resultados_token_{$token->token}.pdf");
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
