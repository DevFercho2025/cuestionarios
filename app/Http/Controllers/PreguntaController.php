<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Categoria;
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
        $preguntas = Pregunta::with('seccion')->get();
        return response()->json($preguntas);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pregunta'     => 'required|string',
            'cuestionario' => 'required|string',
            'seccion_id'   => 'required|exists:psico_alobri_secciones,id',
            'required'     => 'nullable|boolean', 
        ]);


        $data['required'] = $data['required'] ?? 0;

        $pregunta = Pregunta::create($data);

        return response()->json([
            'status'   => 'success',
            'message'  => 'Pregunta creada exitosamente.',
            'pregunta' => $pregunta
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
                'pregunta'     => 'required|string',
                'cuestionario' => 'required|string',
                'seccion_id'   => 'required|exists:psico_alobri_secciones,id'
            ]);

            //Verifica si los valores son diferentes y los actualiza si es necesario
            $pregunta->pregunta = $data['pregunta'] !== $pregunta->pregunta ? $data['pregunta'] : $pregunta->pregunta;
            $pregunta->cuestionario = $data['cuestionario'] !== $pregunta->cuestionario ? $data['cuestionario'] : $pregunta->cuestionario;
            $pregunta->seccion_id = $data['seccion_id'] !== $pregunta->seccion_id ? $data['seccion_id'] : $pregunta->seccion_id;

            $pregunta->save();

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
            $categorias = Categoria::all();
            Log::info('Categorías obtenidas con éxito', ['categorias' => $categorias]);
            return response()->json($categorias);
        } catch (\Exception $e) {
            Log::error('Error al obtener categorías', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Error al obtener categorías'], 500);
        }
    }
}
