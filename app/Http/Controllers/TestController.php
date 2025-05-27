<?php

namespace App\Http\Controllers;
use App\Models\Test;
use App\Models\Category;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function all()
    {
        return response()->json(Test::select('id', 'test_title')->get());
    }

    public function index()
    {
        return view('pruebas.index');
    }

    public function datatable(Request $request)
    {
        $tests = Test::with(['type.category', 'sections'])->get();

        $data = $tests->map(function ($test) {
            return [
                'id' => $test->id,
                'titulo' => $test->test_title,
                'tipo' => $test->type?->type_name,
                'tipo_id' => $test->type?->id,
                'categoria' => $test->type->category->category_name,
                'categoria_id' => $test->type->category->id,
                'secciones' => $test->sections->count(),
                'time_at' => $test->time_at,
            ];
        });

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $test = Test::findOrFail($id);

        $data = $request->validate([
            'titulo'       => 'required|string|max:255',
            'categoria_id' => 'required|integer|exists:psico_alobri_categories,id',
            'tipo_id'      => 'nullable|integer|exists:psico_alobri_test_types,id',
        ]);

        // Actualizar los campos que corresponden en el modelo Test
        $test->test_title = $data['titulo'];

        // Asumiendo que el Test tiene relación con TestType a través de tipo_id o similar
        $test->type_id = $data['tipo_id'];

        $test->save();

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Test actualizado exitosamente.',
                'test'    => $test
            ]);
        }

        return redirect()->route('tests.index')->with('success', 'Test actualizado exitosamente.');
    }

    public function show($id)
    {
        $test = Test::findOrFail($id);
        return response()->json($test);
    }

    public function categoriaConTipos()
    {
        $categories = Category::with('testTypes')->get();
        return response()->json($categories);
    }
}
