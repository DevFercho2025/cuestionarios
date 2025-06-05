<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriasTiposEvController extends Controller
{
    public function index()
    {
        return view('categorias_y_tipos.index');
    }

    public function datatable(Request $request)
    {
        $categories = Category::with('testTypes')->get();

        $data = [];

        foreach ($categories as $category) {
            // Si no tiene tipos, igual mostrar la categoría con datos vacíos para tipo
            if ($category->testTypes->isEmpty()) {
                $data[] = [
                    'category_id' => $category->id,
                    'category_name' => $category->category_name,
                    'type_id' => null,
                    'type_name' => null,
                ];
            } else {
                // Por cada tipo, agregar una fila
                foreach ($category->testTypes as $type) {
                    $data[] = [
                        'category_id' => $category->id,
                        'category_name' => $category->category_name,
                        'type_id' => $type->id,
                        'type_name' => $type->type_name,
                    ];
                }
            }
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'tipos' => 'required|array|min:1',
            'tipos.*' => 'required|string|max:255',
        ]);

        try {
            // Crear la categoría
            $category = Category::create([
                'category_name' => $request->category_name,
            ]);

            // Crear los tipos asociados
            foreach ($request->tipos as $typeName) {
                $category->testTypes()->create([
                    'type_name' => $typeName,
                ]);
            }

            return response()->json([
                'message' => 'Categoría y tipos creados con éxito.',
                'category' => $category,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear categoría y tipos.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $category = Category::with('testTypes')->findOrFail($id);

        return response()->json([
            'category_id' => $category->id,
            'category_name' => $category->category_name,
            'tipos' => $category->testTypes->pluck('type_name')->toArray()
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'tipos' => 'required|array|min:1',
            'tipos.*' => 'required|string|max:255'
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'category_name' => $request->category_name
        ]);

        // Elimina tipos antiguos
        $category->testTypes()->delete();

        // Inserta los nuevos
        foreach ($request->tipos as $tipo) {
            $category->testTypes()->create([
                'type_name' => $tipo
            ]);
        }

        return response()->json(['message' => 'Categoría actualizada correctamente']);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->testTypes()->delete();
        $category->delete();

        return response()->json(['message' => 'Categoría eliminada correctamente']);
    }

}
