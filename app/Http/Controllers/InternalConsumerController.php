<?php

namespace App\Http\Controllers;

use App\Models\ApiInternalConsumer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InternalConsumerController extends Controller
{
    public function index()
    {
        $consumers = ApiInternalConsumer::orderBy('name')->get();
        return response()->json(['success' => true, 'data' => $consumers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'nullable|string|max:255',
        ]);

        $slug = Str::slug($request->name);

        if (ApiInternalConsumer::where('slug', $slug)->exists()) {
            return response()->json([
                'success' => false,
                'message' => "Ya existe un consumer con slug '{$slug}'.",
            ], 422);
        }

        $secret = bin2hex(random_bytes(32));

        $consumer = ApiInternalConsumer::create([
            'name' => $request->name,
            'slug' => $slug,
            'domain' => $request->domain,
            'secret' => $secret,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Consumer creado.',
            'data' => [
                'id' => $consumer->id,
                'name' => $consumer->name,
                'slug' => $consumer->slug,
                'domain' => $consumer->domain,
                'secret' => $secret, // Solo se muestra una vez
                'is_active' => $consumer->is_active,
            ],
        ]);
    }

    public function show(int $id)
    {
        $consumer = ApiInternalConsumer::find($id);
        if (!$consumer) {
            return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);
        }
        return response()->json(['success' => true, 'data' => $consumer]);
    }

    public function update(Request $request, int $id)
    {
        $consumer = ApiInternalConsumer::find($id);
        if (!$consumer) {
            return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'domain' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        $consumer->update($request->only(['name', 'domain', 'is_active']));

        return response()->json([
            'success' => true,
            'message' => 'Consumer actualizado.',
            'data' => $consumer,
        ]);
    }

    public function regenerateSecret(int $id)
    {
        $consumer = ApiInternalConsumer::find($id);
        if (!$consumer) {
            return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);
        }

        $newSecret = bin2hex(random_bytes(32));
        $consumer->update(['secret' => $newSecret]);

        return response()->json([
            'success' => true,
            'message' => 'Secret regenerado. El anterior ya no funciona.',
            'data' => [
                'id' => $consumer->id,
                'name' => $consumer->name,
                'secret' => $newSecret,
            ],
        ]);
    }

    public function destroy(int $id)
    {
        $consumer = ApiInternalConsumer::find($id);
        if (!$consumer) {
            return response()->json(['success' => false, 'message' => 'No encontrado.'], 404);
        }

        $consumer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Consumer eliminado.',
        ]);
    }
}
