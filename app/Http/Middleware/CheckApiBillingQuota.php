<?php

namespace App\Http\Middleware;

use App\Models\ApiClient;
use App\Models\ApiTestTokenCost;
use App\Services\ApiBillingService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiBillingQuota
{
    public function __construct(
        protected ApiBillingService $billingService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $client = $request->get('api_client');

        if (!$client instanceof ApiClient) {
            return response()->json([
                'success' => false,
                'message' => 'API client not authenticated.',
            ], 401);
        }

        if ($client->isGovernment()) {
            return $next($request);
        }

        $testIds = $request->input('test_ids', []);

        if (empty($testIds)) {
            return $next($request);
        }

        if (!$this->billingService->hasQuota($client, $testIds)) {
            $message = $client->isToken()
                ? 'Insufficient token balance.'
                : 'Subscription evaluation limit reached.';

            return response()->json([
                'success' => false,
                'message' => $message,
                'error' => 'quota_exceeded',
            ], 402);
        }

        return $next($request);
    }
}
