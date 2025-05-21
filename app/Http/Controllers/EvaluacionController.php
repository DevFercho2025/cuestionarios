<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\usuarios_categoria;
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

    public function listarCategorias()
    {
        $categorias = Categoria::select('id', 'titulo_cuestionario')->get();
        return response()->json($categorias);
    }

    public function asignarCategorias(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', //usuario al que se le asignan evaluaciones
            'categorias' => 'required|array',
            'categorias.*' => 'exists:psico_alobri_categorias,id',
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

            if ($contador->pruebas_disponibles == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes pruebas disponibles para asignar evaluaciones. Adquiere más pruebas'
                ], 403);
            }

            foreach ($request->categorias as $categoriaId) {
                Usuarios_categoria::firstOrCreate([
                    'user_id' => $request->user_id,
                    'categorias_id' => $categoriaId,
                ]);
            }

            #Actualiza el contador para el asignador de evaluaciones (el usuario logueado)
            $contador->decrement('pruebas_disponibles');
            $contador->increment('pruebas_usadas');
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
        $evaluaciones = Usuarios_categoria::where('user_id', $user_id)
            ->with('categoria:id,titulo_cuestionario')
            ->get()
            ->pluck('categoria');

        return response()->json($evaluaciones);
    }

    public function eliminarAsignacion(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'categorias' => 'required|array',
            'categorias.*' => 'exists:psico_alobri_categorias,id',
        ]);
    
        Usuarios_categoria::where('user_id', $request->user_id)
            ->whereIn('categorias_id', $request->categorias)
            ->delete();
    
        return response()->json(['success' => true, 'message' => 'Evaluaciones eliminadas']);
    }
    

}
