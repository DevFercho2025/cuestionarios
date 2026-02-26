<?php

namespace App\Http\Controllers;
use App\Models\Test;
use App\Models\Category;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


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
        $tests = Test::with(['type.category', 'sections', 'questions'])->get();

        $data = $tests->map(function ($test) {
            return [
                'id' => $test->id,
                'titulo' => $test->test_title,
                'tipo' => $test->type?->type_name,
                'tipo_id' => $test->type?->id,
                'categoria' => $test->type?->category?->category_name,
                'categoria_id' => $test->type?->category?->id,
                'preguntas' => $test->questions->count(),
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

        return redirect()->route('pruebas.index')->with('success', 'Test actualizado exitosamente.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'       => 'required|string|max:255',
            'categoria_id' => 'required|integer|exists:psico_alobri_categories,id',
            'tipo_id'      => 'nullable|integer|exists:psico_alobri_test_types,id',
            'instrucciones'=> 'nullable|string'
        ]);

        $test = new Test();
        $test->test_title = $data['titulo'];
        $test->instructions = $data['instrucciones'];
        $test->type_id = $data['tipo_id'];

        $test->save();

        History::create([
            'user_id' => Auth::user()->id,
            'comment' => "Se creó una nueva evaluación llamada $test->test_title, con ID $test->id.",
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Test creado exitosamente.',
                'test'    => $test
            ]);
        }

        return redirect()->route('pruebas.index')->with('success', 'Test creado exitosamente.');
    }

    public function destroy($id)
    {
        $test = Test::find($id);

        if (!$test) {
            return response()->json([
                'status' => 'error',
                'message' => 'Test no encontrado.'
            ], 404);
        }

        $testName = $test->test_title;

        try {
            $test->delete();

            History::create([
                'user_id' => Auth::user()->id,
                'comment' => "Se eliminó la evaluación $testName, con ID $id.",
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Test eliminado correctamente, puedes restaurarlo en "Ver Eliminadas"'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se pudo eliminar el test. ' . $e->getMessage()
            ], 500);
        }
    }

    public function trash()
    {
        $tests = Test::onlyTrashed()
            ->with(['type.category'])
            ->get();

        $data = $tests->map(function ($test) {
            return [
                'id' => $test->id,
                'titulo' => $test->test_title,
                'tipo' => $test->type?->type_name,
                'categoria' => $test->type?->category?->category_name,
                'deleted_at' => $test->deleted_at?->format('Y-m-d H:i:s'),
            ];
        });
        $html = view('partials.deleted-tests-table', ['tests' => $data])->render();
        return response()->json(['html' => $html]);
    }

    public function restore($id)
    {
        $test = Test::onlyTrashed()->find($id);
        if (!$test) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo restaurar el test: no existe o no está en la papelera.'
            ], 404);
        }

        $test->restore();

         return response()->json([
            'success' => true,
            'message' => 'Test restaurado correctamente.'
        ]);
    }

    public function forceDelete($id)
    {
        $test = Test::onlyTrashed()->find($id);
        $test->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Test eliminado definitivamente.'
        ]);
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
