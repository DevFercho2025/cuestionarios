<?php

namespace App\Http\Controllers;

use App\Models\Aplicacion;
use App\Models\User;
use Illuminate\Http\Request;

class AplicacionController extends Controller
{
    // Vista principal
    public function index()
    {
        return view('aplicaciones.index');
    }

    // DataTable
    public function datatable()
    {
        $aplicaciones = \App\Models\Aplicacion::with('usuario')->get();

        $data = $aplicaciones->map(function ($aplicacion) {
            return [
                'id' => $aplicacion->id,
                'user_id' => $aplicacion->user_id,
                'nombre' => $aplicacion->usuario->name,
                'email' => $aplicacion->usuario->email,
                'vacante' => $aplicacion->vacante,
                'codigo' => $aplicacion->codigo,
            ];
        });

        return response()->json(['data' => $data]);
    }

    // Guardar nueva aplicación
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vacante' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
        ]);

        $aplicacion = Aplicacion::create($request->all());

        return response()->json([
            'message' => 'Aplicación creada correctamente.',
            'aplicacion' => $aplicacion
        ]);
    }

    // Obtener una aplicación específica (para editar)
    public function show($id)
    {
        $aplicacion = Aplicacion::findOrFail($id);

        return response()->json($aplicacion);
    }

    // Actualizar una aplicación
    public function update(Request $request, $id)
    {
        $aplicacion = Aplicacion::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vacante' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
        ]);

        $aplicacion->update($request->all());

        return response()->json([
            'message' => 'Aplicación actualizada correctamente.'
        ]);
    }

    // Eliminar aplicación
    public function destroy($id)
    {
        $aplicacion = Aplicacion::findOrFail($id);
        $aplicacion->delete();

        return response()->json([
            'message' => 'Aplicación eliminada correctamente.'
        ]);
    }

    public function usuarios()
    {
        $usuarios = User::select('id', 'nombre')->get();
        return response()->json($usuarios);
    }

    public function vacantes()
    {
        $vacantes = Aplicacion::select('vacante')->distinct()->get();
        return response()->json($vacantes);
    }

    public function obtenerConfiguracion($id)
    {
        $aplicacion = Aplicacion::findOrFail($id);
        return response()->json([
            'camera' => $aplicacion->camera,
            'location' => $aplicacion->location,
        ]);
    }

    public function configurar(Request $request)
    {
        $request->validate([
            'aplicacion_id' => 'required|exists:psico_alobri_aplicaciones,id',  // Ajusta si el nombre de tabla es distinto
            'camera' => 'required|boolean',
            'location' => 'required|boolean',
        ]);

        $aplicacion = Aplicacion::findOrFail($request->aplicacion_id);
        $aplicacion->camera = $request->camera;
        $aplicacion->location = $request->location;
        $aplicacion->save();

        return response()->json([
            'success' => true,
            'message' => 'Configuración guardada correctamente.'
        ]);
    }
}
