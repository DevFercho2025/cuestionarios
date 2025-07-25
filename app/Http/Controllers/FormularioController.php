<?php

namespace App\Http\Controllers;

use App\Models\AccessCode;
use Illuminate\Support\Facades\Auth;
use App\Models\ImagenUsuario;
use App\Models\Respuesta_Usuario;
use App\Models\UserTestRecord;
use App\Models\UserAssignedTest;
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

        $seccion = Seccion::find($section_id);
        $test_id = $seccion?->test_id;
        
        $user = Auth::user();
        $aplicacion = AccessCode::where('user_id', $user->id)->first();
        $cameraRequired = $aplicacion->camera;
        $locationRequired = $aplicacion->location;
        
        return view('candidate.permisos', compact('categoria_id', 'section_id', 'cameraRequired', 'locationRequired','test_id'));
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
            $test_id = $request->query('test_id');

            $cameraRequired = $request->query('cameraRequired');
            $locationRequired = $request->query('locationRequired');

            // Obtener la sección con preguntas, respuestas, y tipo de pregunta
            $seccion = Seccion::with([
                'test:id,test_title,instructions',
                'questions' => function ($query) {
                    $query->select('id', 'section_id', 'question', 'test_id', 'required', 'question_type_id','picture')
                    ->with([
                        'respuestas:id,question_id,answer,option,is_correct,extra_data',
                        'questionType:id,name,slug',
                        'seccion:id,title,instructions'
                    ]);
                }
            ])->findOrFail($seccion_id);

            // Obtener preguntas y aplicar lógica de repetición aleatoria
            $preguntas = $seccion->questions->shuffle();
            $cantidadRepetidas = min(intval($preguntas->count() * 0.06), 5);
            $preguntasRepetidas = $preguntas->random($cantidadRepetidas);
            $preguntas = $preguntas->concat($preguntasRepetidas)->shuffle();

            // Separar preguntas abiertas (id 10), normales, y pares (id 3)
            $preguntasAbiertas = $preguntas->filter(fn($p) => $p->question_type_id == 10);
            $preguntasNormales = $preguntas->filter(fn($p) => $p->question_type_id != 10 && $p->question_type_id != 3);
            $preguntasPares = $preguntas->filter(fn($p) => $p->question_type_id == 3);

            $preguntas = $preguntasAbiertas
                ->concat($preguntasNormales)
                ->concat($preguntasPares)
                ->values();

            // Agregar campo de tiempo restante para cada pregunta (con base en la sección)
            $tiempoSeccion = strtotime($seccion->time_at) - strtotime('00:00:00');
            foreach ($preguntas as $pregunta) {
                foreach ($pregunta->respuestas as $respuesta) {
                    if ($respuesta->extra_data) {
                        if (is_string($respuesta->extra_data)) {
                            $respuesta->extra_data = json_decode($respuesta->extra_data, true);
                        } elseif (!is_array($respuesta->extra_data)) {
                            $respuesta->extra_data = [];
                        }
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
                'locationRequired' => $locationRequired,
                'test_id' => $test_id
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
        $ip = \Illuminate\Support\Facades\Request::getClientIp(true);
        $respuestas = $request->input('respuestas', []);

        foreach ($respuestas as $question_id => $respuesta_data) {
            // Pregunta normal
            if (is_scalar($respuesta_data)) {
                Respuesta_Usuario::updateOrCreate(
                    ['user_id' => $user_id, 'question_id' => $question_id],
                    [
                        'answer_id' => $respuesta_data,
                        'ip_address' => $ip,
                        'extra_data' => null
                    ]
                );
            }
            elseif (is_array($respuesta_data) && array_key_exists('texto', $respuesta_data) && array_key_exists('respuesta_id', $respuesta_data)) {
                Respuesta_Usuario::updateOrCreate(
                    ['user_id' => $user_id, 'question_id' => $question_id],
                    [
                        'answer_id' => $respuesta_data['respuesta_id'],
                        'ip_address' => $ip,
                        'extra_data' => json_encode(['texto' => $respuesta_data['texto']])
                    ]
                );
            }
            //pdq-varias características
            elseif (is_array($respuesta_data) && array_key_exists('pdq', $respuesta_data)) {
                foreach ($respuesta_data['pdq'] as $answer_id) {
                    Respuesta_Usuario::create([
                        'user_id' => $user_id,
                        'question_id' => $question_id,
                        'answer_id' => $answer_id,
                        'ip_address' => $ip,
                        'extra_data' => null
                    ]);
                }
            }
            // Pregunta compuesta tipo Cleaver
            elseif (is_array($respuesta_data)) {
                foreach ($respuesta_data as $bloque => $tipos) {
                    foreach ($tipos as $tipo => $answer_id) {
                        // Buscar si ya existe esa combinación
                        $respuestaExistente = Respuesta_Usuario::where('user_id', $user_id)
                            ->where('question_id', $question_id)
                            ->where('extra_data->bloque', $bloque)
                            ->where('extra_data->tipo', $tipo)
                            ->first();

                        if ($respuestaExistente) {
                            // Actualizar
                            $respuestaExistente->answer_id = $answer_id;
                            $respuestaExistente->ip_address = $ip;
                            $respuestaExistente->save();
                        } else {
                            // Crear nueva
                            Respuesta_Usuario::create([
                                'user_id' => $user_id,
                                'question_id' => $question_id,
                                'answer_id' => $answer_id,
                                'ip_address' => $ip,
                                'extra_data' => json_encode([
                                    'bloque' => $bloque,
                                    'tipo' => $tipo
                                ])
                            ]);
                        }
                    }
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Respuesta guardada correctamente.']);
    }

    public function tokenRecord(Request $request)
    {
        try {
            $user = Auth::user();
            $user_id = $user->id;
            if (!$user_id) {
                return response()->json(['error' => 'Este usuario no tiene un Id'], 500);
            }

            $test_id = $request->get('test_id');
            $section_id = $request->get('section_id');

            if (!$test_id || !$section_id) {
                return response()->json(['error' => 'Falta el identificador de test o sección'], 400);
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
            $imagenes = ImagenUsuario::where('user_id', $user_id)
                ->whereNull('token_id')
                ->get();

            #a todas esas imagenes se les añade el id del token generado
            foreach ($imagenes as $imagen) {
                $imagen->token_id = $tokenEv->id;
                $imagen->save();
            }

            //Buscar o crear el registro del candidato
            $record = UserTestRecord::firstOrNew([
                'user_id' => $user_id,
                'test_id' => $test_id,
                'token_id' => $tokenEv->id,
            ]);

            $completedSections = $record->completed_sections_ids ?? [];
            if (!is_array($completedSections)) {
                $completedSections = [];
            }
            if (!in_array($section_id, $completedSections)) {
                $completedSections[] = $section_id;
            }

            $record->completed_sections_ids = $completedSections;

            // Obtener todas las secciones del test
            $allSectionIds = Seccion::where('test_id', $test_id)
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();

            $completedIds = array_map('strval', $completedSections);

            sort($allSectionIds);
            sort($completedIds);

            // Comparar
            if ($allSectionIds === $completedIds) {
                $record->finished_at = now();
            } else {
                $record->finished_at = null;
            }

            $record->save();
            $assignedTest = UserAssignedTest::where('user_id', $user_id)
            ->where('test_id', $test_id)
            ->first();

            $assignedTest->test_record_id = $record->id;
            $assignedTest->save();

            return redirect()->route('candidate.dashboard')->with('success', 'Formulario enviado correctamente.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
