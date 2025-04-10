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
        $aplicaciones = Aplicacion::with('usuario')->get();

        return response()->json([
            'data' => $aplicaciones
        ]);
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

    // Para llenar el select de usuarios (si lo necesitas)
    public function usuarios()
    {
        $usuarios = User::select('id', 'nombre')->get(); // o name si usás inglés
        return response()->json($usuarios);
    }

    // (Opcional) Lista de vacantes si son fijas
    public function vacantes()
    {
        $vacantes = Aplicacion::select('vacante')->distinct()->get(); // O podrías tener una tabla vacantes
        return response()->json($vacantes);
    }
}
