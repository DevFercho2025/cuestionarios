<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Test;
use App\Models\Respuesta_Usuario;
use App\Models\Pregunta;
use App\Models\UserTestRecord;
use App\Models\UserAssignedTest;
use App\Models\ContadorEvaluacion;

use App\Mail\EvaluacionesAsignadas;
use App\Models\AccessCode;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EvaluacionController extends Controller
{
    public function index()
    {
        return view('evaluaciones.index');
    }

    public function listarCategorias(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'access_code_id' => 'required|integer',
        ]);

        $userId = $request->user_id;
        $accessCodeId = $request->access_code_id;

        #Buscar las evaluaciones ya asignadas al usuario en este código
        $testsYaAsignados = UserAssignedTest::where('user_id', $userId)
            ->where('application_access_code_id', $accessCodeId)
            ->pluck('test_id');

        #Mostrar las evalauciones que aún no están asignadas en ese código
        $testsDisponibles = Test::whereNotIn('id', $testsYaAsignados)
            ->select('id', 'test_title')
            ->get();

        return response()->json($testsDisponibles);
    }

    public function verificarEvaluacionesPrevias(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pruebas' => 'required|array',
            'pruebas.*' => 'exists:psico_alobri_tests,id',
        ]);

        $userId = $request->user_id;
        $pruebas = $request->pruebas;

        $hace6Meses = Carbon::now()->subMonths(6);
        $testsRecientes = [];

        foreach ($pruebas as $testId) {
            $registroReciente = UserTestRecord::where('user_id', $userId)
                ->where('test_id', $testId)
                ->whereNotNull('finished_at')
                ->where('finished_at', '>=', $hace6Meses)
                ->first();

            if ($registroReciente) {
                $testsRecientes[] = [
                    'test_title' => Test::find($testId)->test_title,
                    'finished_at' => $registroReciente->finished_at->toDateTimeString(),
                ];
            }
        }

        if (count($testsRecientes) > 0) {
            return response()->json([
                'has_previous' => true,
                'tests' => $testsRecientes,
            ]);
        } else {
            return response()->json([
                'has_previous' => false
            ]);
        }
    }

    public function asignarEvaluacion(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // usuario al que se le asignan evaluaciones
            'pruebas' => 'required|array',
            'pruebas.*' => 'exists:psico_alobri_tests,id',
            'force' => 'sometimes|boolean|in:true,false,1,0,TRUE,FALSE',
            'access_code_id' => 'required|exists:psico_alobri_application_access_codes,id',
        ]);

        try {
            $asignadorId = Auth::id();  // usuario que asigna las evaluaciones
            $companyId = Auth::user()->config?->Company?->id;

            $contador = ContadorEvaluacion::where('user_id', $asignadorId)->first();

            if (!$contador) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay un contador de evaluaciones para su usuario. Contacte a Soporte.'
                ], 400);
            }

            if ($contador->available_tests == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes pruebas disponibles para asignar evaluaciones. Adquiere más pruebas'
                ], 403);
            }

            $userId = $request->user_id;
            $pruebas = $request->pruebas;
            $borrarRespuestas = $request->boolean('force', false);

            foreach ($pruebas as $testId) {

                //si se borran respuestas anteriores
                if ($borrarRespuestas) {

                    $preguntasIds = Pregunta::where('test_id', $testId)->pluck('id');
                    $tokens = UserTestRecord::where('user_id', $userId)
                        ->where('test_id', $testId)
                        ->pluck('token_id');

                    Respuesta_Usuario::where('user_id', $userId)
                        ->whereIn('question_id', $preguntasIds)
                        ->whereIn('token_id', $tokens)
                        ->delete();

                    UserTestRecord::where('user_id', $userId)
                        ->where('test_id', $testId)
                        ->delete();
                }

                // Asignar prueba
                $created = UserAssignedTest::firstOrCreate([
                    'user_id' => $userId,
                    'test_id' => $testId,
                    'application_access_code_id' => $request->access_code_id,
                ]);

                if ($created->wasRecentlyCreated) {
                    $contador->decrement('available_tests');
                    $contador->increment('used_tests');
                }
            }

            //prueba para ver correo tras asignar
            /*return redirect()->route('enviar.correo', [
                'userId' => $userId,
                'codeId' => $request->access_code_id
            ]);*/

            return response()->json([
                'success' => true,
                'message' => $borrarRespuestas
                    ? 'Evaluaciones asignadas y respuestas anteriores eliminadas.'
                    : 'Evaluaciones asignadas sin borrar respuestas anteriores.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al asignar evaluaciones: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado al asignar las evaluaciones. Por favor, intenta nuevamente o contacta a soporte.'
            ], 500);
        }
    }

    public function correoEvaluacionesAsignadas($user_id, $code_id)
    {
        $candidate = User::findOrFail($user_id);
        $code = AccessCode::with('company')->findOrFail($code_id);
        $loginURL = route('login') . '#tab-candidate';

        return new EvaluacionesAsignadas($candidate, $code, $loginURL);

    }

    public function evaluacionesPorUsuario(Request $request, $user_id)
    {
        $request->validate([
            'code_id' => 'required|exists:psico_alobri_application_access_codes,id',
        ]);

        $codeId = $request->input('code_id');

         $evaluaciones = UserAssignedTest::with('test')
                ->where('user_id', $user_id)
                ->where('application_access_code_id', $codeId)
                ->with('test:id,test_title')
                ->get()
                ->pluck('test');

        return response()->json($evaluaciones);
    }

    public function eliminarAsignacion(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'tests' => 'required|array',
            'tests.*' => 'exists:psico_alobri_tests,id',
        ]);

        UserAssignedTest::where('user_id', $request->user_id)
            ->whereIn('test_id', $request->tests)
            ->delete();

        return response()->json(['success' => true, 'message' => 'Evaluaciones eliminadas']);
    }


}
