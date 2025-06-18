<?php

namespace App\Http\Controllers;

use App\Models\AccessCode;
use Illuminate\Support\Facades\Auth;
use App\Models\ImagenUsuario;
use App\Models\Respuesta_Usuario;
use App\Models\pregunta;
use App\Models\Seccion;
use App\Models\TokenEvaluacion;
use Illuminate\Support\Facades\Log;
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
        $section_id = $request->query('section_id'); 
        
        $user = Auth::user();
        $aplicacion = AccessCode::where('user_id', $user->id)->first();
        $cameraRequired = $aplicacion->camera;
        $locationRequired = $aplicacion->location;
        
        return view('candidate.permisos', compact('categoria_id', 'section_id', 'cameraRequired', 'locationRequired'));
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

            $seccion_id = $request->query('section_id');
            if (!$seccion_id) {
                return response()->json(['error' => 'El parámetro seccion_id es obligatorio'], 400);
            }

            $cameraRequired = $request->query('cameraRequired');
            $locationRequired = $request->query('locationRequired');

            // Obtener la sección con preguntas, respuestas, y tipo de pregunta
            $seccion = Seccion::with([
                'test:id,test_title',
                'questions' => function ($query) {
                    $query->select('id', 'section_id', 'question', 'test_id', 'required', 'question_type_id')
                    ->with([
                        'respuestas:id,question_id,answer,option,is_correct,extra_data',
                        'questionType:id,name,slug',
                        'seccion:id,title'
                    ]);
                }
            ])->findOrFail($seccion_id);

            // Obtener preguntas y aplicar lógica de repetición aleatoria
            $preguntas = $seccion->questions->shuffle();
            $cantidadRepetidas = min(intval($preguntas->count() * 0.06), 5);
            $preguntasRepetidas = $preguntas->random($cantidadRepetidas);
            $preguntas = $preguntas->concat($preguntasRepetidas)->shuffle();
            $preguntasNormales = $preguntas->filter(fn($p) => $p->question_type_id != 3);
            $preguntasPares = $preguntas->filter(fn($p) => $p->question_type_id == 3);

            $preguntas = $preguntasNormales->concat($preguntasPares)->values();

            // Agregar campo de tiempo restante para cada pregunta (con base en la sección)
            $tiempoSeccion = strtotime($seccion->time_at) - strtotime('00:00:00');
            foreach ($preguntas as $pregunta) {
                foreach ($pregunta->respuestas as $respuesta) {
                    if ($respuesta->extra_data) {
                        $respuesta->extra_data = json_decode($respuesta->extra_data, true);
                    }
                }
                $pregunta->tiempoRestante = gmdate("i:s", $tiempoSeccion);
                $pregunta->tipo_slug = $pregunta->questionType->slug ?? null;
            }

            return view('candidate.formulario.parcial', [
                'preguntas' => $preguntas,
                'seccion' => $seccion,
                'testTitulo' => $seccion->test->test_title,
                'candidato' => $user,
                'seccion_id' => $seccion_id,
                'cameraRequired' => $cameraRequired,
                'locationRequired' => $locationRequired
            ]);
    
        } catch (\Exception $e) {
            Log::error("Error en cargarFormulario: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
        
            return response()->json(['error' => 'Ocurrió un error inesperado. Intenta nuevamente más tarde.'], 500);
        }
    }

    public function guardarFoto(Request $request)
    {
        try{
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
        }catch (\Exception $e) {
            // En caso de error, registrar y devolver un error JSON
            Log::error('Error al guardar la foto: ' . $e->getMessage());
            return response()->json(['error' => 'Hubo un error al procesar la imagen'], 500);
        }
        
    }

    public function guardarRespuestas(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $usuarioIp = \Illuminate\Support\Facades\Request::getClientIp(true);

        $tiempoAgotado = $request->input('tiempo_agotado', 0);
        $seccion_id = $request->input('seccion_id');

        $seccionesCompletadas = session('secciones_completadas', []);
        if (!in_array($seccion_id, $seccionesCompletadas)) {
            $seccionesCompletadas[] = $seccion_id;
        }

        if ($tiempoAgotado != 1) {
            #Obtener las preguntas requeridas dentro del rango actual
            $preguntasRequeridas = Pregunta::where('seccion_id', $seccion_id)
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
            // Buscar respuesta existente
            $respuesta = Respuesta_Usuario::where('user_id', $user_id)
                ->where('pregunta_id', $pregunta_id)
                ->first();
        
            if ($respuesta) {
                // Si existe, actualiza la respuesta_id y la IP
                $respuesta->respuesta_id = $respuesta_id;
                $respuesta->ip_usuario = $usuarioIp;
            } else {
                // Si no existe, crea una nueva
                $respuesta = new Respuesta_Usuario();
                $respuesta->user_id = $user_id;
                $respuesta->pregunta_id = $pregunta_id;
                $respuesta->respuesta_id = $respuesta_id;
                $respuesta->ip_usuario = $usuarioIp;
            }
        
            $respuesta->save();
        }

        $this->generarToken($user_id);

        
        $seccionesRespondidas = Respuesta_Usuario::where('user_id', $user_id) //respuestas con el id del usuario
        ->join('psico_alobri_preguntas', 'psico_alobri_respuestas_usuario.pregunta_id', '=', 'psico_alobri_preguntas.pregunta_id')
        ->pluck('psico_alobri_preguntas.seccion_id')  //Muestra solo el seccion_id de las preguntas del join.
        ->unique() //Elimina duplicados
        ->toArray();

        session(['secciones_completadas' => $seccionesRespondidas]);

        return redirect()->route('candidate.dashboard');
    }

    public function generarToken($user_id)
    {
        try {
            /*$user = Auth::user();
            $user_id = $user->id;*/
            if (!$user_id) {
                return response()->json(['error' => 'user_id vacío'], 500);
            }

            $tokenEv = TokenEvaluacion::where('user_id', $user_id)->first();

            if(!$tokenEv){
                $token = bcrypt(Str::random(64));

                $tokenEv = TokenEvaluacion::create([
                    'token' => $token,
                    'user_id' => $user_id,
                    'created_at' => now(),
                ]);
            }
            
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
}
