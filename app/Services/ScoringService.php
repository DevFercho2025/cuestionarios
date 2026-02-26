<?php

namespace App\Services;

use App\Models\ImagenUsuario;
use App\Models\Respuesta_Usuario;
use App\Models\Test;
use App\Models\UserAssignedTest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ScoringService
{
    /**
     * Calcula los scores de todos los tests asignados a un usuario para un token dado.
     * Retorna un array con los resultados por test.
     */
    public function calculateForUser(int $userId, int $tokenId): array
    {
        $assignedTests = UserAssignedTest::with('test.type')
            ->where('user_id', $userId)
            ->get();

        $allAnswers = Respuesta_Usuario::with(['pregunta.questionType', 'pregunta.seccion', 'respuesta'])
            ->where('user_id', $userId)
            ->where('token_id', $tokenId)
            ->get();

        $results = [];

        foreach ($assignedTests as $assigned) {
            $test = $assigned->test;
            if (!$test) continue;

            $testAnswers = $allAnswers->filter(fn($a) => $a->pregunta && $a->pregunta->test_id == $test->id);

            if ($testAnswers->isEmpty()) continue;

            $testResult = $this->scoreTest($test, $testAnswers);
            $testResult['test_id'] = $test->id;
            $testResult['test_title'] = $test->test_title;
            $testResult['type_name'] = $test->type->type_name ?? 'desconocido';
            $results[] = $testResult;
        }

        return $results;
    }

    /**
     * Determina el metodo de scoring segun los tipos de pregunta del test.
     * Si el test tiene tipos mixtos, agrupa por tipo y combina resultados.
     */
    protected function scoreTest(Test $test, Collection $answers): array
    {
        // Agrupar por question_type_id para detectar tipos mixtos
        $byType = $answers->groupBy(fn($a) => $a->pregunta?->question_type_id ?? 0);

        // Si todos son del mismo tipo, usar routing simple
        if ($byType->count() === 1) {
            $firstAnswer = $answers->first();
            $slug = $firstAnswer?->pregunta?->questionType?->slug ?? null;
            $questionTypeId = $firstAnswer?->pregunta?->question_type_id;
            return $this->routeScoring($slug, $questionTypeId, $answers, $test);
        }

        // Tipos mixtos: scoring por grupo y combinar metricas
        $combinedMetricas = [];
        $combinedData = [
            'scoring_method' => 'mixed',
            'sub_results' => [],
        ];

        foreach ($byType as $typeId => $typeAnswers) {
            $firstOfType = $typeAnswers->first();
            $slug = $firstOfType?->pregunta?->questionType?->slug ?? null;
            $result = $this->routeScoring($slug, $typeId, $typeAnswers, $test);
            $combinedData['sub_results'][] = $result;

            if (isset($result['metricas'])) {
                foreach ($result['metricas'] as $metrica) {
                    $combinedMetricas[] = $metrica;
                }
            }
        }

        $combinedData['metricas'] = $combinedMetricas;
        return $combinedData;
    }

    /**
     * Enruta a la funcion de scoring correcta segun slug o question_type_id.
     */
    protected function routeScoring(?string $slug, ?int $questionTypeId, Collection $answers, Test $test): array
    {
        return match (true) {
            $slug === 'likert' || $questionTypeId == 2
                => $this->scoreLikert($answers, $test),
            $slug === 'cleaver' || $questionTypeId == 14
                => $this->scoreCleaver($answers),
            $slug === 'zavik' || $questionTypeId == 15
                => $this->scoreZavic($answers),
            $slug === 'lifo'
                => $this->scoreLifo($answers),
            $slug === 'nego' || $questionTypeId == 23
                => $this->scoreNego($answers),
            $slug === 'beck'
                => $this->scoreBeck($answers),
            $slug === 'moss' || $questionTypeId == 19
                => $this->scoreCorrectAnswers($answers, 'MOSS'),
            $slug === 'pares' || $questionTypeId == 3
                => $this->scorePares($answers),
            $slug === 'patron_num'
                => $this->scorePatronNumerico($answers),
            $slug === 'figuras_incompletas'
                => $this->scoreDominos($answers),
            $slug === 'verdadero_falso'
                => $this->scoreCorrectAnswers($answers, 'Verdadero/Falso'),
            $slug === 'seleccion_multiple'
                => $this->scoreCorrectAnswers($answers, 'Selección Múltiple'),
            $slug === 'comparar_palabras'
                => $this->scoreCompararPalabras($answers),
            $slug === 'reaccion_forzada' || $questionTypeId == 8
                => $this->scoreCorrectAnswers($answers, 'Reacción Forzada'),
            $slug === 'pdq'
                => $this->scorePDQ($answers),
            $slug === 'doble_opcion'
                => $this->scoreCorrectAnswers($answers, 'Doble Opción'),
            $slug === 'bender'
                => $this->scoreBender($answers),
            $slug === 'pregunta_abierta' || $questionTypeId == 10
                => $this->scorePreguntaAbierta($answers),
            $slug === 'dibujo_libre'
                => $this->scorePreguntaAbierta($answers),
            $slug === 'laminas'
                => $this->scoreLaminas($answers),
            $slug === 'mancha'
                => $this->scoreLaminas($answers),
            $slug === 'escala_cualitativa'
                => $this->scoreCorrectAnswers($answers, 'Escala Cualitativa'),
            $slug === 'patrones_multiple'
                => $this->scoreCorrectAnswers($answers, 'Patrones Múltiple'),
            default => $this->scoreGeneric($answers),
        };
    }

    // ─── LIKERT (BFQ, BAI, Rathus, Hereford, IPP, Rosemberg, 16PF, etc.) ───

    protected function scoreLikert(Collection $answers, Test $test): array
    {
        $scaleType = null;
        $sectionScores = [];
        $sectionCounts = [];
        $totalScore = 0;
        $totalQuestions = 0;

        foreach ($answers as $answer) {
            $respuesta = $answer->respuesta;
            if (!$respuesta) continue;

            $extraData = is_string($respuesta->extra_data)
                ? json_decode($respuesta->extra_data, true) ?? []
                : ($respuesta->extra_data ?? []);

            $labelIndex = $extraData['label_index'] ?? null;
            $currentScale = $extraData['scale_type'] ?? null;
            if ($scaleType === null && $currentScale) $scaleType = $currentScale;

            if ($labelIndex !== null) {
                $sectionTitle = $answer->pregunta?->seccion?->title ?? 'General';
                $sectionScores[$sectionTitle] = ($sectionScores[$sectionTitle] ?? 0) + intval($labelIndex);
                $sectionCounts[$sectionTitle] = ($sectionCounts[$sectionTitle] ?? 0) + 1;
                $totalScore += intval($labelIndex);
                $totalQuestions++;
            }
        }

        $scaleNames = [
            1 => 'Likert 4 puntos',
            2 => 'Likert 5 puntos',
            3 => 'BFQ (Big Five)',
            4 => 'BAI (Ansiedad de Beck)',
            5 => 'Hereford',
            6 => 'IPP',
            7 => 'IPP Vocacional',
            8 => 'Rathus (Asertividad)',
            9 => 'Likert Frecuencia',
        ];

        $maxPerQuestion = $scaleType ?? 5;
        $maxTotal = $totalQuestions * $maxPerQuestion;
        $percentage = $maxTotal > 0 ? round(($totalScore / $maxTotal) * 100) : 0;

        $metricas = [];

        if (!empty($sectionScores)) {
            foreach ($sectionScores as $seccion => $score) {
                $seccionQuestions = $sectionCounts[$seccion] ?? 0;
                $seccionMax = $seccionQuestions * $maxPerQuestion;
                $seccionPct = $seccionMax > 0 ? round(($score / $seccionMax) * 100) : 0;

                $metricas[] = [
                    'titulo' => $seccion,
                    'puntuacion' => $seccionPct,
                    'puntaje_bruto' => $score,
                    'maximo' => $seccionMax,
                    'etiqueta_izq' => 'Bajo',
                    'etiqueta_der' => 'Alto',
                    'descripcion' => $this->interpretarPorcentaje($seccionPct),
                ];
            }
        }

        // Si no hay secciones multiples, mostrar score global
        if (count($metricas) <= 1) {
            $metricas = [[
                'titulo' => $scaleNames[$scaleType] ?? $test->test_title,
                'puntuacion' => $percentage,
                'puntaje_bruto' => $totalScore,
                'maximo' => $maxTotal,
                'etiqueta_izq' => 'Bajo',
                'etiqueta_der' => 'Alto',
                'descripcion' => $this->interpretarPorcentaje($percentage),
            ]];
        }

        return [
            'scoring_method' => 'likert',
            'scale_type' => $scaleType,
            'scale_name' => $scaleNames[$scaleType] ?? 'Likert',
            'total_score' => $totalScore,
            'max_score' => $maxTotal,
            'percentage' => $percentage,
            'total_questions' => $totalQuestions,
            'metricas' => $metricas,
        ];
    }

    // ─── CLEAVER / DISC ───

    protected function scoreCleaver(Collection $answers): array
    {
        // Mapeo de posicion dentro del bloque a dimension DISC
        // Posicion 0 (a) = D, 1 (b) = I, 2 (c) = S, 3 (d) = C
        $positionToDisc = [0 => 'D', 1 => 'I', 2 => 'S', 3 => 'C'];

        $dimensionsM = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];
        $dimensionsL = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];
        $blocks = [];

        // Pre-cargar las respuestas de las preguntas cleaver para mapear posicion
        // Agrupamos todas las respuestas de la BD por question_id + option (bloque)
        $answerPositionCache = [];
        foreach ($answers as $answer) {
            $pregunta = $answer->pregunta;
            if (!$pregunta) continue;
            $qId = $pregunta->id;
            if (!isset($answerPositionCache[$qId])) {
                // Cargar todas las respuestas de esta pregunta, agrupadas por option (bloque)
                $allRespuestas = $pregunta->respuestas()->orderBy('id')->get();
                $byOption = $allRespuestas->groupBy('option');
                foreach ($byOption as $opt => $grupo) {
                    $pos = 0;
                    foreach ($grupo as $resp) {
                        $answerPositionCache[$qId][$resp->id] = $pos;
                        $pos++;
                    }
                }
            }
        }

        foreach ($answers as $answer) {
            $extraData = is_string($answer->extra_data)
                ? json_decode($answer->extra_data, true) ?? []
                : ($answer->extra_data ?? []);

            if (!isset($extraData['bloque'], $extraData['tipo'])) continue;

            $bloque = $extraData['bloque'];
            $tipo = $extraData['tipo']; // M o L
            $answerId = $answer->answer_id;
            $questionId = $answer->question_id;

            $blocks[$bloque][$tipo] = $answerId;

            // Determinar la posicion DISC del answer seleccionado dentro de su bloque
            $position = $answerPositionCache[$questionId][$answerId] ?? null;
            $dimension = ($position !== null) ? ($positionToDisc[$position] ?? null) : null;

            if ($dimension) {
                if ($tipo === 'M') {
                    $dimensionsM[$dimension]++;
                } elseif ($tipo === 'L') {
                    $dimensionsL[$dimension]++;
                }
            }
        }

        // Calcular scores netos DISC: M - L por dimension
        $dimensionsNet = [];
        foreach (['D', 'I', 'S', 'C'] as $dim) {
            $dimensionsNet[$dim] = $dimensionsM[$dim] - $dimensionsL[$dim];
        }

        $totalBlocks = count($blocks);

        // Escala: rango teorico es -24 a +24 por dimension
        // Normalizamos a 0-100 donde 50 = neutro
        $discLabels = [
            'D' => ['Dominancia', 'Pasivo', 'Dominante'],
            'I' => ['Influencia', 'Reservado', 'Influyente'],
            'S' => ['Estabilidad', 'Dinámico', 'Estable'],
            'C' => ['Cumplimiento', 'Independiente', 'Cumplidor'],
        ];

        $metricas = [];
        foreach (['D', 'I', 'S', 'C'] as $dim) {
            $raw = $dimensionsNet[$dim];
            // Normalizar: raw va de -24 a 24, mapear a 0-100
            $pct = round((($raw + 24) / 48) * 100);
            $pct = max(0, min(100, $pct));

            $metricas[] = [
                'titulo' => $discLabels[$dim][0] . " ($dim)",
                'puntuacion' => $pct,
                'puntaje_bruto' => $raw,
                'maximo' => 24,
                'etiqueta_izq' => $discLabels[$dim][1],
                'etiqueta_der' => $discLabels[$dim][2],
                'descripcion' => "M=$dimensionsM[$dim], L=$dimensionsL[$dim], Neto=$raw",
            ];
        }

        return [
            'scoring_method' => 'cleaver',
            'dimensions_m' => $dimensionsM,
            'dimensions_l' => $dimensionsL,
            'dimensions_net' => $dimensionsNet,
            'total_blocks' => $totalBlocks,
            'total_questions' => $answers->count(),
            'metricas' => $metricas,
        ];
    }

    // ─── ZAVIC ───

    protected function scoreZavic(Collection $answers): array
    {
        $categories = [];

        foreach ($answers as $answer) {
            $extraData = is_string($answer->extra_data)
                ? json_decode($answer->extra_data, true) ?? []
                : ($answer->extra_data ?? []);

            $score = intval($extraData['importance_score'] ?? 0);
            $sectionTitle = $answer->pregunta?->seccion?->title ?? 'General';

            $categories[$sectionTitle] = ($categories[$sectionTitle] ?? 0) + $score;
        }

        $metricas = [];
        $maxPerCategory = 40; // Tipico en Zavic

        foreach ($categories as $cat => $score) {
            $pct = $maxPerCategory > 0 ? round(($score / $maxPerCategory) * 100) : 0;
            $pct = min(100, $pct);

            $metricas[] = [
                'titulo' => $cat,
                'puntuacion' => $pct,
                'puntaje_bruto' => $score,
                'maximo' => $maxPerCategory,
                'etiqueta_izq' => 'Bajo',
                'etiqueta_der' => 'Alto',
                'descripcion' => $this->interpretarPorcentaje($pct),
            ];
        }

        return [
            'scoring_method' => 'zavic',
            'categories' => $categories,
            'total_questions' => $answers->count(),
            'metricas' => $metricas,
        ];
    }

    // ─── LIFO ───

    protected function scoreLifo(Collection $answers): array
    {
        $rankings = [];

        foreach ($answers as $answer) {
            $extraData = is_string($answer->extra_data)
                ? json_decode($answer->extra_data, true) ?? []
                : ($answer->extra_data ?? []);

            $score = intval($extraData['importance_score'] ?? 0);
            $answerText = $answer->respuesta?->answer ?? 'Item';

            $rankings[$answerText] = ($rankings[$answerText] ?? 0) + $score;
        }

        arsort($rankings);

        $metricas = [];
        $maxScore = !empty($rankings) ? max($rankings) : 1;

        foreach ($rankings as $item => $score) {
            $pct = $maxScore > 0 ? round(($score / $maxScore) * 100) : 0;
            $metricas[] = [
                'titulo' => $item,
                'puntuacion' => $pct,
                'puntaje_bruto' => $score,
                'maximo' => $maxScore,
                'etiqueta_izq' => 'Menor preferencia',
                'etiqueta_der' => 'Mayor preferencia',
                'descripcion' => "Puntaje de orientación: $score",
            ];
        }

        return [
            'scoring_method' => 'lifo',
            'rankings' => $rankings,
            'total_questions' => $answers->count(),
            'metricas' => $metricas,
        ];
    }

    // ─── BECK (Depresion) ───

    protected function scoreBeck(Collection $answers): array
    {
        $totalScore = 0;
        $totalQuestions = 0;

        foreach ($answers as $answer) {
            $respuesta = $answer->respuesta;
            if (!$respuesta) continue;

            // Beck: cada respuesta tiene un valor 0-3 al inicio del texto
            $answerText = $respuesta->answer ?? '';
            if (preg_match('/^(\d+)/', $answerText, $matches)) {
                $totalScore += intval($matches[1]);
            } else {
                // Fallback: usar option como indice (a=0, b=1, c=2, d=3)
                $option = strtolower($respuesta->option ?? 'a');
                $totalScore += max(0, ord($option) - ord('a'));
            }
            $totalQuestions++;
        }

        // Interpretacion Beck Depression Inventory
        $maxScore = $totalQuestions * 3;
        $percentage = $maxScore > 0 ? round(($totalScore / $maxScore) * 100) : 0;

        if ($totalScore <= 13) {
            $nivel = 'Mínima';
            $descripcion = 'Depresión mínima o ausente.';
        } elseif ($totalScore <= 19) {
            $nivel = 'Leve';
            $descripcion = 'Nivel leve de depresión.';
        } elseif ($totalScore <= 28) {
            $nivel = 'Moderada';
            $descripcion = 'Nivel moderado de depresión.';
        } else {
            $nivel = 'Severa';
            $descripcion = 'Nivel severo de depresión.';
        }

        return [
            'scoring_method' => 'beck',
            'total_score' => $totalScore,
            'max_score' => $maxScore,
            'percentage' => $percentage,
            'nivel' => $nivel,
            'total_questions' => $totalQuestions,
            'metricas' => [[
                'titulo' => "Depresión de Beck ($nivel)",
                'puntuacion' => $percentage,
                'puntaje_bruto' => $totalScore,
                'maximo' => $maxScore,
                'etiqueta_izq' => 'Mínima',
                'etiqueta_der' => 'Severa',
                'descripcion' => "$descripcion Puntaje: $totalScore/$maxScore",
            ]],
        ];
    }

    // ─── NEGO ───

    protected function scoreNego(Collection $answers): array
    {
        $totalQuestions = $answers->count();
        $comentarios = [];
        $respuestas = [];

        foreach ($answers as $answer) {
            $extraData = is_string($answer->extra_data)
                ? json_decode($answer->extra_data, true) ?? []
                : ($answer->extra_data ?? []);

            $respuestas[] = [
                'question' => $answer->pregunta?->question ?? '',
                'answer' => $answer->respuesta?->answer ?? '',
                'comentarios' => $extraData['comentarios'] ?? [],
            ];

            if (!empty($extraData['comentarios'])) {
                foreach ($extraData['comentarios'] as $comentario) {
                    if (!empty($comentario)) $comentarios[] = $comentario;
                }
            }
        }

        return [
            'scoring_method' => 'nego',
            'total_questions' => $totalQuestions,
            'total_comentarios' => count($comentarios),
            'respuestas_detalle' => $respuestas,
            'metricas' => [[
                'titulo' => 'NEGO - Evaluación',
                'puntuacion' => $totalQuestions > 0 ? 100 : 0,
                'puntaje_bruto' => $totalQuestions,
                'maximo' => $totalQuestions,
                'etiqueta_izq' => 'Sin respuestas',
                'etiqueta_der' => 'Completo',
                'descripcion' => "$totalQuestions preguntas respondidas con " . count($comentarios) . " comentarios.",
            ]],
        ];
    }

    // ─── CORRECTAS (MOSS, Wonderlic, Barsit, Doble Opción, etc.) ───

    protected function scoreCorrectAnswers(Collection $answers, string $testName = 'Test'): array
    {
        $correct = 0;
        $total = 0;

        foreach ($answers as $answer) {
            $total++;
            if ($answer->respuesta?->is_correct) {
                $correct++;
            }
        }

        $percentage = $total > 0 ? round(($correct / $total) * 100) : 0;

        return [
            'scoring_method' => 'correct_answers',
            'correct' => $correct,
            'total' => $total,
            'percentage' => $percentage,
            'metricas' => [[
                'titulo' => $testName,
                'puntuacion' => $percentage,
                'puntaje_bruto' => $correct,
                'maximo' => $total,
                'etiqueta_izq' => '0 aciertos',
                'etiqueta_der' => "$total aciertos",
                'descripcion' => "$correct de $total respuestas correctas ($percentage%)",
            ]],
        ];
    }

    // ─── PARES ───

    protected function scorePares(Collection $answers): array
    {
        $correct = 0;
        $total = 0;

        foreach ($answers as $answer) {
            $total++;
            if ($answer->respuesta?->is_correct) {
                $correct++;
            }
        }

        $percentage = $total > 0 ? round(($correct / $total) * 100) : 0;

        return [
            'scoring_method' => 'pares',
            'correct' => $correct,
            'total' => $total,
            'percentage' => $percentage,
            'metricas' => [[
                'titulo' => 'Pares (Emparejamiento)',
                'puntuacion' => $percentage,
                'puntaje_bruto' => $correct,
                'maximo' => $total,
                'etiqueta_izq' => 'Ninguno correcto',
                'etiqueta_der' => 'Todos correctos',
                'descripcion' => "$correct de $total pares correctos",
            ]],
        ];
    }

    // ─── PATRON NUMERICO ───

    protected function scorePatronNumerico(Collection $answers): array
    {
        $correct = 0;
        $total = 0;

        foreach ($answers as $answer) {
            $extraData = is_string($answer->extra_data)
                ? json_decode($answer->extra_data, true) ?? []
                : ($answer->extra_data ?? []);

            if (!isset($extraData['number_written'])) continue;
            $total++;

            $written = trim($extraData['number_written']);
            $correctAnswer = $answer->respuesta?->answer ?? '';

            if ($written === trim($correctAnswer)) {
                $correct++;
            }
        }

        $percentage = $total > 0 ? round(($correct / $total) * 100) : 0;

        return [
            'scoring_method' => 'patron_numerico',
            'correct' => $correct,
            'total' => $total,
            'percentage' => $percentage,
            'metricas' => [[
                'titulo' => 'Patrón Numérico',
                'puntuacion' => $percentage,
                'puntaje_bruto' => $correct,
                'maximo' => $total,
                'etiqueta_izq' => '0 aciertos',
                'etiqueta_der' => "$total aciertos",
                'descripcion' => "$correct de $total patrones correctos",
            ]],
        ];
    }

    // ─── DOMINOS / FIGURAS INCOMPLETAS ───

    protected function scoreDominos(Collection $answers): array
    {
        $correct = 0;
        $total = 0;

        foreach ($answers as $answer) {
            $extraData = is_string($answer->extra_data)
                ? json_decode($answer->extra_data, true) ?? []
                : ($answer->extra_data ?? []);

            if (!isset($extraData['top']) && !isset($extraData['bottom'])) {
                // No es domino, es figuras incompletas normal
                $total++;
                if ($answer->respuesta?->is_correct) $correct++;
                continue;
            }

            $total++;

            $correctData = is_string($answer->respuesta?->extra_data)
                ? json_decode($answer->respuesta->extra_data, true) ?? []
                : ($answer->respuesta?->extra_data ?? []);

            $correctTop = $correctData['top'] ?? null;
            $correctBottom = $correctData['bottom'] ?? null;

            if ($correctTop !== null && $correctBottom !== null) {
                if (intval($extraData['top']) === intval($correctTop) &&
                    intval($extraData['bottom']) === intval($correctBottom)) {
                    $correct++;
                }
            }
        }

        $percentage = $total > 0 ? round(($correct / $total) * 100) : 0;

        return [
            'scoring_method' => 'dominos',
            'correct' => $correct,
            'total' => $total,
            'percentage' => $percentage,
            'metricas' => [[
                'titulo' => 'Dominós',
                'puntuacion' => $percentage,
                'puntaje_bruto' => $correct,
                'maximo' => $total,
                'etiqueta_izq' => '0 aciertos',
                'etiqueta_der' => "$total aciertos",
                'descripcion' => "$correct de $total fichas correctas",
            ]],
        ];
    }

    // ─── COMPARAR PALABRAS (Terman) ───

    protected function scoreCompararPalabras(Collection $answers): array
    {
        $correct = 0;
        $total = 0;

        foreach ($answers as $answer) {
            $extraData = is_string($answer->extra_data)
                ? json_decode($answer->extra_data, true) ?? []
                : ($answer->extra_data ?? []);

            if (!isset($extraData['comparison'])) continue;
            $total++;

            if ($answer->respuesta?->is_correct) {
                $correct++;
            }
        }

        $percentage = $total > 0 ? round(($correct / $total) * 100) : 0;

        return [
            'scoring_method' => 'comparar_palabras',
            'correct' => $correct,
            'total' => $total,
            'percentage' => $percentage,
            'metricas' => [[
                'titulo' => 'Comparar Palabras',
                'puntuacion' => $percentage,
                'puntaje_bruto' => $correct,
                'maximo' => $total,
                'etiqueta_izq' => '0 aciertos',
                'etiqueta_der' => "$total aciertos",
                'descripcion' => "$correct de $total comparaciones correctas",
            ]],
        ];
    }

    // ─── PDQ ───

    protected function scorePDQ(Collection $answers): array
    {
        $totalSelected = $answers->count();
        $byQuestion = $answers->groupBy('question_id');

        return [
            'scoring_method' => 'pdq',
            'total_selected' => $totalSelected,
            'total_questions' => $byQuestion->count(),
            'metricas' => [[
                'titulo' => 'PDQ - Evaluación',
                'puntuacion' => 50,
                'puntaje_bruto' => $totalSelected,
                'maximo' => $totalSelected,
                'etiqueta_izq' => 'Menos rasgos',
                'etiqueta_der' => 'Más rasgos',
                'descripcion' => "$totalSelected características seleccionadas en " . $byQuestion->count() . " preguntas.",
            ]],
        ];
    }

    // ─── BENDER (evaluación visual-motriz, scoring por completitud) ───

    protected function scoreBender(Collection $answers): array
    {
        $totalQuestions = $answers->count();

        // Buscar fotos asociadas al usuario y token
        $firstAnswer = $answers->first();
        $userId = $firstAnswer?->user_id;
        $tokenId = $firstAnswer?->token_id;

        $fotos = 0;
        if ($userId && $tokenId) {
            $fotos = ImagenUsuario::where('user_id', $userId)
                ->where('token_id', $tokenId)
                ->count();
        }

        return [
            'scoring_method' => 'bender',
            'total_questions' => $totalQuestions,
            'total_fotos' => $fotos,
            'metricas' => [[
                'titulo' => 'Bender - Gestalt Visual Motor',
                'puntuacion' => $totalQuestions > 0 ? 100 : 0,
                'puntaje_bruto' => $fotos,
                'maximo' => $totalQuestions,
                'etiqueta_izq' => 'Sin captura',
                'etiqueta_der' => 'Capturado',
                'descripcion' => "$fotos figuras capturadas. Requiere evaluación clínica manual.",
            ]],
        ];
    }

    // ─── PREGUNTA ABIERTA (captura respuestas texto, sin score numérico automatizado) ───

    protected function scorePreguntaAbierta(Collection $answers): array
    {
        $totalQuestions = $answers->count();
        $respondidas = 0;
        $respuestas = [];

        foreach ($answers as $answer) {
            $extraData = is_string($answer->extra_data)
                ? json_decode($answer->extra_data, true) ?? []
                : ($answer->extra_data ?? []);

            $texto = $extraData['texto'] ?? '';

            if (!empty(trim($texto))) {
                $respondidas++;
            }

            $respuestas[] = [
                'question' => $answer->pregunta?->question ?? '',
                'response' => $texto,
            ];
        }

        $pct = $totalQuestions > 0 ? round(($respondidas / $totalQuestions) * 100) : 0;

        return [
            'scoring_method' => 'pregunta_abierta',
            'total_questions' => $totalQuestions,
            'total_respondidas' => $respondidas,
            'respuestas_detalle' => $respuestas,
            'metricas' => [[
                'titulo' => 'Preguntas Abiertas',
                'puntuacion' => $pct,
                'puntaje_bruto' => $respondidas,
                'maximo' => $totalQuestions,
                'etiqueta_izq' => 'Sin responder',
                'etiqueta_der' => 'Respondidas',
                'descripcion' => "$respondidas de $totalQuestions preguntas respondidas. Requiere evaluación cualitativa.",
            ]],
        ];
    }

    // ─── LÁMINAS / MANCHA (pueden tener respuestas abiertas o de selección) ───

    protected function scoreLaminas(Collection $answers): array
    {
        // Detectar si hay respuestas con texto (abierta) o con is_correct (selección)
        $hasText = $answers->contains(fn($a) => !empty(
            is_string($a->extra_data) ? (json_decode($a->extra_data, true)['texto'] ?? '') : ($a->extra_data['texto'] ?? '')
        ));

        if ($hasText) {
            // Modo abierto: contar respondidas
            $total = $answers->count();
            $respondidas = 0;

            foreach ($answers as $answer) {
                $extraData = is_string($answer->extra_data)
                    ? json_decode($answer->extra_data, true) ?? []
                    : ($answer->extra_data ?? []);
                if (!empty(trim($extraData['texto'] ?? ''))) {
                    $respondidas++;
                }
            }

            $pct = $total > 0 ? round(($respondidas / $total) * 100) : 0;

            return [
                'scoring_method' => 'laminas_abierta',
                'total_questions' => $total,
                'total_respondidas' => $respondidas,
                'metricas' => [[
                    'titulo' => 'Láminas - Interpretación',
                    'puntuacion' => $pct,
                    'puntaje_bruto' => $respondidas,
                    'maximo' => $total,
                    'etiqueta_izq' => 'Sin responder',
                    'etiqueta_der' => 'Respondidas',
                    'descripcion' => "$respondidas de $total láminas interpretadas. Requiere evaluación cualitativa.",
                ]],
            ];
        }

        // Modo selección: contar correctas
        $correct = 0;
        $total = $answers->count();
        foreach ($answers as $answer) {
            if ($answer->respuesta?->is_correct) $correct++;
        }
        $pct = $total > 0 ? round(($correct / $total) * 100) : 0;

        return [
            'scoring_method' => 'laminas_seleccion',
            'correct' => $correct,
            'total' => $total,
            'percentage' => $pct,
            'metricas' => [[
                'titulo' => 'Láminas',
                'puntuacion' => $pct,
                'puntaje_bruto' => $correct,
                'maximo' => $total,
                'etiqueta_izq' => '0 aciertos',
                'etiqueta_der' => "$total aciertos",
                'descripcion' => "$correct de $total respuestas correctas ($pct%)",
            ]],
        ];
    }

    // ─── GENERICO (fallback) ───

    protected function scoreGeneric(Collection $answers): array
    {
        $firstAnswer = $answers->first();
        Log::warning('ScoringService: usando scoring genérico (fallback)', [
            'question_type_id' => $firstAnswer?->pregunta?->question_type_id,
            'slug' => $firstAnswer?->pregunta?->questionType?->slug,
            'test_id' => $firstAnswer?->pregunta?->test_id,
            'answers_count' => $answers->count(),
        ]);

        $total = $answers->count();
        $correct = $answers->filter(fn($a) => $a->respuesta?->is_correct)->count();
        $percentage = $total > 0 ? round(($correct / $total) * 100) : 0;

        return [
            'scoring_method' => 'generic',
            'total' => $total,
            'correct' => $correct,
            'percentage' => $percentage,
            'metricas' => [[
                'titulo' => 'Resultado General',
                'puntuacion' => $percentage,
                'puntaje_bruto' => $correct,
                'maximo' => $total,
                'etiqueta_izq' => 'Bajo',
                'etiqueta_der' => 'Alto',
                'descripcion' => "$correct de $total respuestas ($percentage%)",
            ]],
        ];
    }

    // ─── UTILIDADES ───

    protected function interpretarPorcentaje(int $pct): string
    {
        if ($pct >= 80) return 'Nivel alto.';
        if ($pct >= 60) return 'Nivel moderado-alto.';
        if ($pct >= 40) return 'Nivel moderado.';
        if ($pct >= 20) return 'Nivel moderado-bajo.';
        return 'Nivel bajo.';
    }
}
