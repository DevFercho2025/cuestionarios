<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ImagenUsuario;
use App\Models\Aplicacion;
use App\Models\Respuesta_Usuario;
use App\Models\pregunta;
use App\Models\Seccion;
use App\Models\TokenEvaluacion;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class FormularioController extends Controller
{

    public function index()
    {
        return view('formulario.index');
    }

    public function mostrarPermisos(Request $request)
    {
        $categoria_id = $request->query('categoria_id'); 
        
        return view('candidate.permisos', compact('categoria_id'));
    }

    public function guardarCandidato(Request $request)
    {
        return view('public.permisos');
    }
    public function cargarFormulario(Request $request)
    {
        try {
            
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['error' => 'Usuario no autenticado'], 401); // Si no está autenticado, retorna un error
            }
            $rango_inicio = $request->input('rango_inicio', 1);
            $rango_fin = $request->input('rango_fin', 35);
            
    
            // Si ya está todo respondido, pasa al siguiente rango
            if ($request->isMethod('post')) {
                $rango_inicio += 35;
                $rango_fin += 35;
            }
    
            $categoriaIds = $user->categorias->pluck('id');
            $seccionIds = Seccion::whereIn('categoria_id', $categoriaIds)->pluck('id');
            
            $preguntas = Pregunta::with([
                'respuestas' => function ($query) {
                    $query->select('respuesta_id', 'pregunta_id', 'respuesta', 'opcion');
                }
            ])->whereIn('seccion_id', $seccionIds)
              ->whereBetween('pregunta_id', [$rango_inicio, $rango_fin])
              ->get()->groupBy('seccion_id')
              ->map(function ($grupo) {
                return $grupo->shuffle();
              })->collapse();
    
            $cantidadRepeticiones = intval($preguntas->count() * 0.06);
            $preguntasRepetidas = $preguntas->random($cantidadRepeticiones);
    
            $preguntas = $preguntas->concat($preguntasRepetidas)->shuffle();
    
            $secciones = Seccion::with([
                'seccion' => function ($query) {
                    $query->select('id', 'bloque', 'titulo', 'cuestionario', 'time_at');
                }
            ]);
    
            foreach ($preguntas as $pregunta) {
                $pregunta->tiempoRestante = gmdate("i:s", strtotime($pregunta->seccion->time_at) - strtotime('00:00:00'));
            }
    
            $candidato = $user;
            return view('candidate.formulario.parcial', compact('preguntas', 'secciones', 'candidato', 'rango_inicio', 'rango_fin'));
    
        } catch (\Exception $e) {
            // Esto te ayudará a identificar si hay algún error en el código
            return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
        }
    }

    public function guardarFoto(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        #Valida que se recibe una cadena (Base64)
        $request->validate([
            'image' => 'required|string'
        ]);

        #Recibe la imagen
        $img = $request->image;

        #Extraer los datos Base64
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;

        #Guarda en `storage/app/private/`
        $pathImg = "private/uploads/" . $fileName;
        Storage::put($pathImg, $image_base64);

        #crea un nuevo registro para la BD que referencia la imagen creada
        $imagenUsuario = new ImagenUsuario();
        $imagenUsuario->id_usuario = $user_id;
        $imagenUsuario->file_name = $fileName;
        $imagenUsuario->file_path = $pathImg;
        $imagenUsuario->created_at = Carbon::now();
        $imagenUsuario->save();

        return response()->json([
            'message' => 'Imagen guardada correctamente',
            'file_name' => $fileName //solo devuelve el nombre de la img y no la url para que no sea accesible desde el navegador.
        ]);
    }

    public function guardarRespuestas(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $usuarioIp = \Illuminate\Support\Facades\Request::getClientIp(true);

        $tiempoAgotado = $request->input('tiempo_agotado', 0);

        if ($tiempoAgotado != 1) {
            #Obtener las preguntas requeridas dentro del rango actual
            $preguntasRequeridas = Pregunta::whereBetween('pregunta_id', [$request->input('rango_inicio', 1), $request->input('rango_fin', 35)])
                ->where('required', true)
                ->pluck('pregunta_id')
                ->toArray();

            #Verificar si todas las preguntas requeridas fueron respondidas
            $respuestasEnviadas = array_map('intval', array_keys($request->respuestas ?? []));

            $faltantes = array_diff($preguntasRequeridas, $respuestasEnviadas);

            if (!empty($faltantes)) {
                return back()->withErrors(['error' => 'Debe responder todas las preguntas requeridas antes de continuar.']);
            }
        }
        $respuestas = $request->input('respuestas', []) ?? []; //Toma el valor del campo respuestas del request. Si no existe, usa un array vacío como valor predeterminado. Si por alguna razón sigue siendo null, entonces lo reemplazará con otro array vacío.

        foreach ($respuestas as $pregunta_id => $respuesta_id) {
            $respuesta = new Respuesta_Usuario();
            $respuesta->user_id = $user_id;
            $respuesta->pregunta_id = $pregunta_id;
            $respuesta->respuesta_id = $respuesta_id;
            $respuesta->ip_usuario = $usuarioIp;

            $respuesta->save();
        }

        #Avanzar al siguiente conjunto de preguntas
        $rango_inicio = $request->input('rango_inicio', 1) + 35;
        $rango_fin = $request->input('rango_fin', 35) + 35;

        if ($rango_fin > 265) {
            $rango_fin = 265;
        }
        if ($rango_inicio > 265) {
            return redirect()->route('gracias');
        }

        if ($rango_inicio > 35) {
        }

        return view('public.permisos', ['rango_inicio' => $rango_inicio, 'rango_fin' => $rango_fin]);
    }

    public function generarToken(Request $request)
    {
        try {
            $user = Auth::user();
            $user_id = $user->id;

            if (!$user_id) {
                return response()->json(['error' => 'user_id vacío'], 500);
            }

            $token = bcrypt(Str::random(64));

            $tokenEv = TokenEvaluacion::create([
                'token' => $token,
                'user_id' => $user_id,
                'created_at' => now(),
            ]);

            #Obtener respuestas del usuario que no tienen un token asociado
            Respuesta_Usuario::where('user_id', $user_id)
                ->whereNull('token_id')
                ->update(['token_id' => $tokenEv->id]);

            #Obtener imágenes del usuario que no tienen un token asociado
            $imagenes = ImagenUsuario::where('id_usuario', $user_id)
                ->whereNull('token_id')
                ->get();

            #a todas esas imagenes se les añade el id del token generado
            foreach ($imagenes as $imagen) {
                $imagen->token_id = $tokenEv->id;
                $imagen->save();
            }

            return response()->json(['token' => $tokenEv->token]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function verResultados(Request $request)
    {
        return view('buscador.index');
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

        $pdf = Pdf::loadView('pdf.resultados', compact('usuario', 'aplicacion', 'respuestas'));
        return $pdf->download("resultados_token_{$token->id}.pdf");
    }

}
