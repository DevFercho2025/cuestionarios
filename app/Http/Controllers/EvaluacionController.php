<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\User;
use App\Models\userAssignedTest;
use App\Models\ContadorEvaluacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EvaluacionController extends Controller
{
    public function index()
    {
        return view('Evaluaciones.index'); // Asegúrate que la ruta del archivo sea esta
    }

    public function listarCategorias(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);

        $asignadas = $user->assignedTests()->pluck('test_id');

        $pruebasDisponibles = Test::whereNotIn('id', $asignadas)
                                ->select('id', 'test_title')
                                ->get();

        return response()->json($pruebasDisponibles);
        $pruebas = Test::select('id', 'test_title')->get();
        return response()->json($pruebas);
    }

    public function asignarCategorias(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', //usuario al que se le asignan evaluaciones
            'pruebas' => 'required|array',
            'pruebas.*' => 'exists:psico_alobri_tests,id',
        ]);
    
        try {
            $asignadorId = Auth::id();  //usuario que asigna las evaluaciones
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

            foreach ($request->pruebas as $pruebaId) {
                $created = userAssignedTest::firstOrCreate([
                    'user_id' => $request->user_id,
                    'test_id' => $pruebaId,
                ]);

                #Actualiza el contador para el asignador de evaluaciones (el usuario logueado)
                if ($created->wasRecentlyCreated) {
                    $contador->decrement('available_tests');
                    $contador->increment('used_tests');
                }
            }

            return response()->json(['success' => true, 'message' => 'Evaluaciones asignadas']);

        } catch (\Exception $e) {
            Log::error('Error al asignar evaluaciones: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
            ]);
        }
    }

    public function evaluacionesPorUsuario($user_id)
    {
        $evaluaciones = userAssignedTest::where('user_id', $user_id)
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
    
        userAssignedTest::where('user_id', $request->user_id)
            ->whereIn('test_id', $request->tests)
            ->delete();
    
        return response()->json(['success' => true, 'message' => 'Evaluaciones eliminadas']);
    }
    

}
