<?php

namespace App\Jobs;

use App\Models\ApiClient;
use App\Models\ApiClientBilling;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ResetSubscriptionCountersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $billings = ApiClientBilling::whereHas('apiClient', function ($q) {
            $q->where('client_type', 'subscription')
              ->where('is_active', true);
        })
        ->where('subscription_ends_at', '<=', now())
        ->where('subscription_auto_renew', true)
        ->get();

        foreach ($billings as $billing) {
            $billing->subscription_evals_used = 0;

            // Renew: extend period by the same duration
            $duration = $billing->subscription_starts_at->diffInDays($billing->subscription_ends_at);
            $billing->subscription_starts_at = now();
            $billing->subscription_ends_at = now()->addDays($duration);
            $billing->save();

            Log::info("Subscription reset for client #{$billing->api_client_id}. New period: {$billing->subscription_starts_at} - {$billing->subscription_ends_at}");
        }

        Log::info("ResetSubscriptionCountersJob completed. {$billings->count()} subscriptions renewed.");
    }
}
