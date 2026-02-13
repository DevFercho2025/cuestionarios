<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiClientBilling extends Model
{
    protected $table = 'api_client_billing';

    protected $fillable = [
        'api_client_id',
        'token_balance',
        'subscription_plan',
        'subscription_eval_limit',
        'subscription_evals_used',
        'subscription_starts_at',
        'subscription_ends_at',
        'subscription_auto_renew',
    ];

    protected function casts(): array
    {
        return [
            'token_balance' => 'integer',
            'subscription_eval_limit' => 'integer',
            'subscription_evals_used' => 'integer',
            'subscription_auto_renew' => 'boolean',
            'subscription_starts_at' => 'datetime',
            'subscription_ends_at' => 'datetime',
        ];
    }

    public function apiClient()
    {
        return $this->belongsTo(ApiClient::class, 'api_client_id');
    }
}
