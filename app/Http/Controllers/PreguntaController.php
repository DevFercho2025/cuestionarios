<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use Illuminate\Http\Request;

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
            'seccion_id'   => 'required|exists:secciones,id'
        ]);

        $pregunta = Pregunta::create($data);
        return response()->json([
            'status'  => 'success',
            'message' => 'Pregunta creada exitosamente.',
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
        $pregunta = Pregunta::findOrFail($id);
        $data = $request->validate([
            'pregunta'     => 'required|string',
            'cuestionario' => 'required|string',
            'seccion_id'   => 'required|exists:secciones,id'
        ]);
        $pregunta->update($data);
        return response()->json([
            'status'  => 'success',
            'message' => 'Pregunta actualizada exitosamente.',
            'pregunta' => $pregunta
        ]);
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
}
