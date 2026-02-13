<?php

namespace App\Http\Middleware;

use App\Models\ApiClient;
use App\Models\ApiTestTokenCost;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTestAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $client = $request->get('api_client');

        if (!$client instanceof ApiClient) {
            return response()->json([
                'success' => false,
                'message' => 'API client not authenticated.',
            ], 401);
        }

        // Government clients have unrestricted access
        if ($client->isGovernment()) {
            return $next($request);
        }

        $testIds = $request->input('test_ids', []);

        if (empty($testIds)) {
            return $next($request);
        }

        // Verify all requested tests have a configured token cost
        $configuredTests = ApiTestTokenCost::whereIn('test_id', $testIds)->pluck('test_id')->toArray();
        $unconfigured = array_diff($testIds, $configuredTests);

        if (!empty($unconfigured)) {
            return response()->json([
                'success' => false,
                'message' => 'Some tests are not available via API.',
                'unavailable_test_ids' => array_values($unconfigured),
            ], 422);
        }

        return $next($request);
    }
}
