<?php

namespace App\Http\Controllers;

use App\Models\Respuesta_Correcta; // O RespCorrecta, según convención
use Illuminate\Http\Request;

class RespuestaCorrectaController extends Controller
{
    public function index()
    {
        $data = Respuesta_Correcta::with(['pregunta', 'respuesta'])->get();
        return view('respuestas_correctas.index', compact('data'));
    }

    public function datatable(Request $request)
    {
        $data = Respuesta_Correcta::with(['pregunta', 'respuesta'])->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pregunta_id'   => 'required|exists:preguntas,pregunta_id',
            'respuestas_id' => 'required|exists:respuestas,respuesta_id'
        ]);

        $relacion = Respuesta_Correcta::create($data);
        return response()->json([
            'status'  => 'success',
            'message' => 'Relación creada correctamente.',
            'data'    => $relacion
        ]);
    }

    public function show($id)
    {
        $relacion = Respuesta_Correcta::findOrFail($id);
        return response()->json($relacion);
    }

    public function update(Request $request, $id)
    {
        $relacion = Respuesta_Correcta::findOrFail($id);
        $data = $request->validate([
            'pregunta_id'   => 'required|exists:preguntas,pregunta_id',
            'respuestas_id' => 'required|exists:respuestas,respuesta_id'
        ]);
        $relacion->update($data);
        return response()->json([
            'status'  => 'success',
            'message' => 'Relación actualizada correctamente.',
            'data'    => $relacion
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $relacion = Respuesta_Correcta::findOrFail($id);
        $relacion->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'Relación eliminada correctamente.'
        ]);
    }
}
