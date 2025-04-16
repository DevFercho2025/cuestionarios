<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\usuarios_categoria;
use Illuminate\Http\Request;

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
            'user_id' => 'required|exists:users,id',
            'categorias' => 'required|array',
            'categorias.*' => 'exists:psico_alobri_categorias,id',
        ]);
    
        try {
            foreach ($request->categorias as $catId) {
                Usuarios_categoria::firstOrCreate([
                    'user_id' => $request->user_id,
                    'categorias_id' => $catId,
                ]);
            }
    
            return response()->json(['success' => true, 'message' => 'Evaluaciones asignadas']);
        } catch (\Exception $e) {
            
            return response()->json(['success' => false, 'message' => 'Error al asignar evaluaciones'], 500);
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
            'categorias.*' => 'exists:categorias,id',
        ]);
    
        Usuarios_categoria::where('user_id', $request->user_id)
            ->whereIn('categorias_id', $request->categorias)
            ->delete();
    
        return response()->json(['success' => true, 'message' => 'Evaluaciones eliminadas']);
    }

}
