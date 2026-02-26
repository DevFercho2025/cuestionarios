<?php

namespace App\Services;

use App\Models\ApiClient;
use App\Models\ApiClientBilling;
use App\Models\ApiTestTokenCost;
use App\Models\ApiUsageLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiBillingService
{
    public function hasQuota(ApiClient $client, array $testIds): bool
    {
        if ($client->isGovernment()) {
            return true;
        }

        $billing = $client->billing;

        if (!$billing) {
            return false;
        }

        if ($client->isToken()) {
            $configuredCost = ApiTestTokenCost::whereIn('test_id', $testIds)->sum('token_cost');
            $unconfiguredCount = count($testIds) - ApiTestTokenCost::whereIn('test_id', $testIds)->count();
            $totalCost = $configuredCost + $unconfiguredCount; // unconfigured = 1 each, matching consumeQuota
            return $billing->token_balance >= $totalCost;
        }

        if ($client->isSubscription()) {
            if (!$billing->subscription_ends_at || now()->greaterThan($billing->subscription_ends_at)) {
                return false;
            }
            return ($billing->subscription_evals_used + count($testIds)) <= $billing->subscription_eval_limit;
        }

        return false;
    }

    public function consumeQuota(ApiClient $client, array $testIds, ?int $candidateUserId = null, ?int $accessCodeId = null, ?string $ipAddress = null): void
    {
        DB::transaction(function () use ($client, $testIds, $candidateUserId, $accessCodeId, $ipAddress) {
            if ($client->isGovernment()) {
                foreach ($testIds as $testId) {
                    $this->logUsage($client, 'evaluation_assigned', 0, $testId, $candidateUserId, $accessCodeId, $ipAddress);
                }
                return;
            }

            $billing = $client->billing()->lockForUpdate()->first();

            if ($client->isToken()) {
                foreach ($testIds as $testId) {
                    $cost = ApiTestTokenCost::where('test_id', $testId)->value('token_cost') ?? 1;
                    if ($billing->token_balance < $cost) {
                        throw new \RuntimeException('Insufficient token balance after lock.');
                    }
                    $billing->token_balance -= $cost;
                    $this->logUsage($client, 'evaluation_assigned', $cost, $testId, $candidateUserId, $accessCodeId, $ipAddress);
                }
                $billing->save();
            }

            if ($client->isSubscription()) {
                $billing->subscription_evals_used += count($testIds);
                $billing->save();

                foreach ($testIds as $testId) {
                    $this->logUsage($client, 'evaluation_assigned', 0, $testId, $candidateUserId, $accessCodeId, $ipAddress);
                }
            }
        });
    }

    public function logUsage(ApiClient $client, string $action, int $tokensConsumed = 0, ?int $testId = null, ?int $candidateUserId = null, ?int $accessCodeId = null, ?string $ipAddress = null, ?array $metadata = null): ApiUsageLog
    {
        return ApiUsageLog::create([
            'api_client_id' => $client->id,
            'action' => $action,
            'tokens_consumed' => $tokensConsumed,
            'test_id' => $testId,
            'candidate_user_id' => $candidateUserId,
            'access_code_id' => $accessCodeId,
            'ip_address' => $ipAddress,
            'request_metadata' => $metadata,
        ]);
    }

    public function getUsageSummary(ApiClient $client): array
    {
        $data = [
            'client_type' => $client->client_type,
        ];

        $billing = $client->billing;

        if ($client->isToken() && $billing) {
            $data['token_balance'] = $billing->token_balance;
            $data['tokens_consumed_total'] = $client->usageLogs()->sum('tokens_consumed');
        }

        if ($client->isSubscription() && $billing) {
            $data['subscription_plan'] = $billing->subscription_plan;
            $data['subscription_eval_limit'] = $billing->subscription_eval_limit;
            $data['subscription_evals_used'] = $billing->subscription_evals_used;
            $data['subscription_evals_remaining'] = max(0, $billing->subscription_eval_limit - $billing->subscription_evals_used);
            $data['subscription_starts_at'] = $billing->subscription_starts_at?->toIso8601String();
            $data['subscription_ends_at'] = $billing->subscription_ends_at?->toIso8601String();
            $data['subscription_auto_renew'] = $billing->subscription_auto_renew;
        }

        if ($client->isGovernment()) {
            $data['access'] = 'unlimited';
            $data['evaluations_assigned_total'] = $client->usageLogs()
                ->where('action', 'evaluation_assigned')
                ->count();
        }

        return $data;
    }
}
