<?php

namespace App\Http\Middleware;

use App\Models\ApiClient;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiClientAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'API token required.',
            ], 401);
        }

        $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API token.',
            ], 401);
        }

        $client = $accessToken->tokenable;

        if (!$client instanceof ApiClient) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token type.',
            ], 401);
        }

        if (!$client->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'API client is deactivated.',
            ], 403);
        }

        if ($client->trashed()) {
            return response()->json([
                'success' => false,
                'message' => 'API client not found.',
            ], 401);
        }

        $accessToken->forceFill(['last_used_at' => now()])->save();

        $request->merge(['api_client' => $client]);
        $request->setUserResolver(fn () => $client);

        return $next($request);
    }
}
