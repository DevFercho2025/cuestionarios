<?php

namespace App\Http\Controllers;

use App\Models\Respuesta;
use App\Models\Pregunta;
use App\Models\Test;
use Illuminate\Http\Request;
use App\Services\RespuestaService;
use Illuminate\Support\Facades\Log;

class RespuestaController extends Controller
    {
    public function index()
    {
        $pruebas = \App\Models\Test::all();
        return view('respuestas.index', compact('pruebas'));
    }

    public function datatable(Request $request)
    {
        $query = Respuesta::with('pregunta.test');

        if ($request->has('test_id') && $request->test_id != '') {
            $query->whereHas('pregunta', function ($q) use ($request) {
                $q->where('test_id', $request->test_id);
            });
        }

        return response()->json($query->get());
    }

    public function store(Request $request, RespuestaService $respuestaService)
    {
        $data = $request->validate([
            'question_id' => 'required|exists:psico_alobri_questions,id',
            'respuestas'  => 'required|array|min:1',
        ]);

        $respuestaService->saveAnswers($request->respuestas, $request->question_id);

        $savedRespuestas = Respuesta::where('question_id', $request->question_id)->get();

        return response()->json([
            'status'    => 'success',
            'message'   => 'Respuestas creadas correctamente.',
            'respuestas' => $savedRespuestas
        ]);
    }

    public function show($id)
    {
        $respuesta = Respuesta::with('pregunta.test')->findOrFail($id);
        return response()->json($respuesta);
    }

    public function update(Request $request, $id)
    {
        $respuesta = Respuesta::findOrFail($id);

        // Validar solo los campos que vienen en la petición
        $campos = [];

        //cuando se edita con doble clic
        if ($request->has('answer')) {
            $campos['answer'] = 'required|string';
        }
        if ($request->has('option')) {
            $campos['option'] = 'required|string';
        }
        if ($request->has('is_correct')) {
            $campos['is_correct'] = 'required|boolean';
        }

        //cuando se edita con botón de editar
        if ($request->has('question_id')) {
            $campos['question_id'] = 'required|exists:psico_alobri_questions,id';
        }

        $data = $request->validate($campos);

        $respuesta->update($data);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Respuesta actualizada exitosamente.',
            'respuesta' => $respuesta
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $respuesta = Respuesta::findOrFail($id);
        $respuesta->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Respuesta eliminada exitosamente.'
        ]);
    }

    public function obtenerPreguntasSeccionesPrueba()
    {
        $tests = Test::with(['sections' => function($query) {
            $query->with('questions');
        }])->get();

        return response()->json($tests);
    }

    public function conRespuestas($id)
    {
        $pregunta = Pregunta::with('respuestas')->findOrFail($id);
        return response()->json([
            'pregunta' => $pregunta,
            'respuestas' => $pregunta->respuestas,
        ]);
    }

    public function actualizarRespuestas(Request $request, $id)
    {

        return response()->json(['message' => 'Respuestas actualizadas correctamente.']);
    }

}
