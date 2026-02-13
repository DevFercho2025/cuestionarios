<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ApiBillingService;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected ApiBillingService $billingService
    ) {}

    public function usage(Request $request)
    {
        $client = $request->get('api_client');
        $summary = $this->billingService->getUsageSummary($client);

        return $this->successResponse($summary, 'Billing usage retrieved.');
    }

    public function history(Request $request)
    {
        $client = $request->get('api_client');

        $logs = $client->usageLogs()
            ->orderByDesc('created_at')
            ->paginate($request->input('per_page', 25));

        return $this->paginatedResponse($logs, 'Billing history retrieved.');
    }
}
