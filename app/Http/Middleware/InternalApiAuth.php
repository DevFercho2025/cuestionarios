<?php

namespace App\Http\Middleware;

use App\Models\ApiInternalConsumer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InternalApiAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $provided = $request->header('X-Internal-Secret');

        if (!$provided) {
            return response()->json([
                'success' => false,
                'message' => 'Internal API secret required.',
            ], 401);
        }

        $consumer = ApiInternalConsumer::where('secret', $provided)
            ->where('is_active', true)
            ->first();

        if (!$consumer) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 401);
        }

        // Registrar último uso
        $consumer->update(['last_used_at' => now()]);

        // Pasar el consumer al request para que los controllers sepan quién llama
        $request->merge(['internal_consumer' => $consumer]);

        return $next($request);
    }
}
