<?php

namespace App\Http\Controllers;

use App\Models\Respuesta;
use App\Models\Pregunta;
use App\Models\Test;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $data = $request->validate([
            'question_id' => 'required|exists:psico_alobri_questions,id',
            'respuestas'  => 'required|array|min:1',
        ]);

        $question = Pregunta::findOrFail($data['question_id']);

        $savedRespuestas = [];

        foreach ($data['respuestas'] as $respuesta) {
            $answer     = $respuesta['answer'] ?? null;
            $option     = $respuesta['option'] ?? null;
            $is_correct = $respuesta['is_correct'] ?? null;
            $extra_data = $respuesta['extra_data'] ?? null;

            if ($question->type == 3) {
                //pares
                $pairId = $extra_data['pair_id'] ?? uniqid('pair_', true);

                $savedRespuestas[] = Respuesta::create([
                    'question_id' => $data['question_id'],
                    'answer'      => $answer,
                    'option'      => null,
                    'is_correct'  => null,
                    'extra_data'  => json_encode(['pair_id' => $pairId]),
                ]);

                continue;
            } elseif ($question->type == 2) {
                //likert
                $escala = intval($respuesta['escala'] ?? 5);

                $labelsMap = [
                    4 => [
                        1 => "Totalmente en desacuerdo",
                        2 => "En desacuerdo",
                        3 => "De acuerdo",
                        4 => "Totalmente de acuerdo"
                    ],
                    5 => [
                        1 => "Totalmente en desacuerdo",
                        2 => "En desacuerdo",
                        3 => "Neutral",
                        4 => "De acuerdo",
                        5 => "Totalmente de acuerdo"
                    ],
                ];

                $labels = $labelsMap[$escala] ?? [];

                for ($i = 1; $i <= $escala; $i++) {
                    $savedRespuestas[] = Respuesta::create([
                        'question_id' => $data['question_id'],
                        'answer'      => $labels[$i] ?? "Punto $i",
                        'option'      => chr(96 + $i), // 'a', 'b', ...
                        'is_correct'  => null,
                        'extra_data'  => json_encode([
                            'scale_type' => $escala,
                            'label_index' => $i
                        ]),
                    ]);
                }
                            
                break;
            } else {

                $is_correct = $respuesta['is_correct'] ?? null;

                if ($question->type == 8) {
                    $is_correct = null;
                }
                // Abierta, Verdadero/Falso, Múltiple, doble opción
                $savedRespuestas[] = Respuesta::create([
                    'question_id' => $data['question_id'],
                    'answer'      => $answer,
                    'option'      => $option,
                    'is_correct'  => $is_correct === '' ? null : $is_correct,
                    'extra_data'  => $extra_data ? json_encode($extra_data) : null,
                ]);
            }
        }

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