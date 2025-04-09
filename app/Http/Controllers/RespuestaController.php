<?php

namespace App\Http\Controllers;

use App\Models\Respuesta;
use Illuminate\Http\Request;

class RespuestaController extends Controller
{
    public function index()
    {
        return view('respuestas.index');
    }

    public function datatable(Request $request)
    {
        $respuestas = Respuesta::with('pregunta')->get();
        return response()->json($respuestas);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'respuesta'   => 'required|string',
            'opcion'      => 'required|string',
            'pregunta_id' => 'required|exists:preguntas,pregunta_id'
        ]);

        $respuesta = Respuesta::create($data);
        return response()->json([
            'status'   => 'success',
            'message'  => 'Respuesta creada exitosamente.',
            'respuesta'=> $respuesta
        ]);
    }

    public function show($id)
    {
        $respuesta = Respuesta::findOrFail($id);
        return response()->json($respuesta);
    }

    public function update(Request $request, $id)
    {
        $respuesta = Respuesta::findOrFail($id);
        $data = $request->validate([
            'respuesta'   => 'required|string',
            'opcion'      => 'required|string',
            'pregunta_id' => 'required|exists:preguntas,pregunta_id'
        ]);
        $respuesta->update($data);
        return response()->json([
            'status'   => 'success',
            'message'  => 'Respuesta actualizada exitosamente.',
            'respuesta'=> $respuesta
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
}
