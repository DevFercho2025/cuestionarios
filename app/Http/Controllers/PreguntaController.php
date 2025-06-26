<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Test;
use App\Models\QuestionType;
use App\Services\RespuestaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PreguntaController extends Controller
{
    public function index()
    {
        return view('preguntas.index');
    }

    public function datatable(Request $request)
    {
        $preguntas = Pregunta::with(['seccion', 'test', 'questionType'])->get()->map(function ($p) {
            return [
                'pregunta_id' => $p->id,
                'question'    => $p->question,
                'test_id'     => $p->test_id,
                'test'        => [
                    'titulo'=> $p->test ? $p->test->test_title : null
                ],
                'required'    => $p->required,
                'seccion'     => [
                    'title' => $p->seccion ? $p->seccion->title : null
                ],
                'tipo'        => $p->questionType ? $p->questionType->name : 'Sin tipo asignado'
            ];
        });
        Log::info('Preguntas para datatable:', $preguntas->toArray());
        return response()->json($preguntas);
    }

    public function store(Request $request,  RespuestaService $respuestaService)
    {
        $data = $request->validate([
            'question'          => 'required|string',
            'test_id'           => 'required|exists:psico_alobri_tests,id',
            'section_id'        => 'required|exists:psico_alobri_sections,id',
            'required'          => 'nullable|boolean',
            'question_type_id'  => 'required|exists:psico_alobri_question_types,id',
        ]);

        $data['required'] = $data['required'] ?? 0;

        Log::info('Creando pregunta con datos:', $data);

        $question = Pregunta::create($data);

        if ($request->has('answers')) {
            Log::info("Guardando respuestas para pregunta ID {$question->id}", [
                'answers' => $request->answers
            ]);

            $respuestaService->saveAnswers($request->answers, $question->id);
        } else {
            Log::warning("No se recibieron respuestas para la pregunta ID {$question->id}");
        }

        Log::info("Pregunta creada correctamente", ['pregunta_id' => $question->id]);
        return response()->json([
            'status'   => 'success',
            'message'  => 'Pregunta creada exitosamente.',
            'pregunta' => $question
        ]);
    }


    public function show($id)
    {
        // Devuelve la pregunta en formato JSON para fines de edición
        $pregunta = Pregunta::findOrFail($id);
        return response()->json($pregunta);
    }

    public function update(Request $request, $id)
    {
        try {
            $pregunta = Pregunta::findOrFail($id);

            $data = $request->validate([
                'question'    => 'required|string',
                'test_id'     => 'required|exists:psico_alobri_tests,id',
                'section_id'  => 'required|exists:psico_alobri_secciones,id',
            ]);

            $pregunta->update($data);

            return response()->json([
                'status'  => 'success',
                'message' => 'Pregunta actualizada exitosamente.',
                'pregunta' => $pregunta
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar pregunta: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Hubo un problema al actualizar la pregunta.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function destroy(Request $request, $id)
    {
        $pregunta = Pregunta::findOrFail($id);
        $pregunta->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Pregunta eliminada exitosamente.'
        ]);
    }

    public function categorias()
    {
        try {
            $categorias = Test::all();
            Log::info('Pruebas obtenidas con éxito', ['categorias' => $categorias]);
            return response()->json($categorias);
        } catch (\Exception $e) {
            Log::error('Error al obtener pruebas', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Error al obtener pruebas'], 500);
        }
    }

    public function allQuestionTypes()
    {
        $types = QuestionType::select('id', 'name','description')->get();

        return response()->json($types);
    }

    public function preguntasBySection($sectionId)
    {
        $questions = Pregunta::where('section_id', $sectionId)->get();
        return response()->json($questions);
    }
}
