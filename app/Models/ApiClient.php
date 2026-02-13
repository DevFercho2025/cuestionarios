<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class ApiClient extends Model
{
    use HasApiTokens, SoftDeletes;

    protected $table = 'api_clients';

    protected $fillable = [
        'name',
        'slug',
        'contact_email',
        'contact_phone',
        'company_id',
        'client_type',
        'rate_limit_per_minute',
        'webhook_url',
        'webhook_secret',
        'is_active',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'rate_limit_per_minute' => 'integer',
            'webhook_secret' => 'encrypted',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function billing()
    {
        return $this->hasOne(ApiClientBilling::class, 'api_client_id');
    }

    public function usageLogs()
    {
        return $this->hasMany(ApiUsageLog::class, 'api_client_id');
    }

    public function webhookDeliveries()
    {
        return $this->hasMany(ApiWebhookDelivery::class, 'api_client_id');
    }

    public function candidateMappings()
    {
        return $this->hasMany(ApiCandidateMapping::class, 'api_client_id');
    }

    public function isGovernment(): bool
    {
        return $this->client_type === 'government';
    }

    public function isToken(): bool
    {
        return $this->client_type === 'token';
    }

    public function isSubscription(): bool
    {
        return $this->client_type === 'subscription';
    }
}
