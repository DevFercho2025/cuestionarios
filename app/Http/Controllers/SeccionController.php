<?php

namespace App\Http\Controllers;

use App\Models\Seccion;
use Illuminate\Http\Request;

class SeccionController extends Controller
{
    // Muestra la vista principal
    public function index()
    {
        return view('secciones.index');
    }

    // Retorna los datos en JSON para DataTables
    public function datatable(Request $request)
    {
        // Cargar secciones con la relación 'categoria'
        $secciones = Seccion::with('categoria')->get(); 
        
        $secciones = $secciones->map(function ($seccion) {
            // Agregar el título del cuestionario (categoría)
            $seccion->cuestionario = $seccion->categoria ? $seccion->categoria->titulo_cuestionario : 'No disponible';
            return $seccion;
        });
    
        return response()->json($secciones);
    }

    public function store(Request $request)
    {
        // Validamos
        $data = $request->validate([
            'titulo'       => 'required|string|max:255',
            'bloque'       => 'required|string',
            'categoria_id' => 'required|exists:psico_alobri_categorias,id',
            'time_at'      => 'nullable|date_format:H:i:s'
        ]);

        $seccion = Seccion::create($data);

        // Si es AJAX, retorna JSON
        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Sección creada exitosamente.',
                'seccion' => $seccion
            ]);
        }

        return redirect()->route('secciones.index')->with('success', 'Sección creada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $seccion = Seccion::findOrFail($id);
        $data = $request->validate([
            'titulo'       => 'required|string|max:255',
            'bloque'       => 'required|string',
            'categoria_id' => 'required|string',
            'time_at'      => 'nullable|date_format:H:i:s'
        ]);

        $seccion->update($data);

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Sección actualizada exitosamente.',
                'seccion' => $seccion
            ]);
        }

        return redirect()->route('secciones.index')->with('success', 'Sección actualizada exitosamente.');
    }

    public function destroy(Request $request, $id)
    {
        $seccion = Seccion::findOrFail($id);
        $seccion->delete();

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Sección eliminada exitosamente.'
            ]);
        }

        return redirect()->route('secciones.index')->with('success', 'Sección eliminada exitosamente.');
    }
    public function all()
    {
        $secciones = Seccion::all();
        return response()->json($secciones);
    }
}
