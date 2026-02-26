<?php

namespace App\Services;
use App\Models\Respuesta;
use App\Models\pregunta;
use Illuminate\Support\Facades\Log;

class RespuestaService
{
    public function saveAnswers(array $answers, int $questionId):void
    {
        $question = Pregunta::findOrFail($questionId);
        Log::info("Entro a servicio. respuestas para pregunta: {$questionId}", [
            'question_type_id' => $question->question_type_id,
            'answers_count' => count($answers),
        ]);
        

        $savedRespuestas = [];

        foreach ($answers as $index => $respuesta) {
            try{
                $answer     = $respuesta['answer'] ?? null;
                $option     = $respuesta['option'] ?? null;
                $is_correct = $respuesta['is_correct'] ?? null;
                $extra_data = $respuesta['extra_data'] ?? null;

                if ($question->question_type_id == 3) {
                    //pares
                    $pairId = $extra_data['pair_id'] ?? uniqid('pair_', true);

                    $savedRespuestas[] = Respuesta::create([
                        'question_id' => $questionId,
                        'answer'      => $answer,
                        'option'      => null,
                        'is_correct'  => null,
                        'extra_data'  => ['pair_id' => $pairId],
                    ]);

                    continue;
                } else if ($question->question_type_id == 2) {
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
                        6 => [
                            1 => "Me gusta",
                            2 => "Me es indiferente o tengo dudas",
                            3 => "No me gusta",
                            4 => "No conozco esa actividad o profesión"
                        ],
                        7 => [
                            1 => "Mucho",
                            2 => "Poco",
                            3 => "Nada"
                        ],
                    ];

                    $labels = $labelsMap[$escala] ?? [];

                    for ($i = 1; $i <= $escala; $i++) {
                        $savedRespuestas[] = Respuesta::create([
                            'question_id' => $questionId,
                            'answer'      => $labels[$i] ?? "Punto $i",
                            'option'      => chr(96 + $i), // 'a', 'b', ...
                            'is_correct'  => null,
                            'extra_data'  => [
                                'scale_type' => $escala,
                                'label_index' => $i
                            ],
                        ]);
                    }

                    break;
                } else {
                
                    //Reacción forzada, Cleaver, o zavik
                    if (in_array($question->question_type_id, [8, 14, 15])) {
                        $is_correct = null;
                    }
                    Log::debug("Extra data antes de guardar", [
                        'index' => $index,
                        'extra_data' => $extra_data,
                        'tipo' => gettype($extra_data),
                    ]);

                    // Abierta, Verdadero/Falso, Múltiple, doble opción
                    $savedRespuestas[] = Respuesta::create([
                        'question_id' => $questionId,
                        'answer'      => $answer,
                        'option'      => $option,
                        'is_correct'  => $is_correct === '' ? null : $is_correct,
                        'extra_data'  => $extra_data ?: null,
                    ]);
                }

            } catch (\Exception $e) {
                Log::error("Error guardando respuesta #{$index} para pregunta ID {$questionId}", [
                    'respuesta' => $respuesta,
                    'exception' => $e->getMessage()
                ]);
            }
        }
    }
}