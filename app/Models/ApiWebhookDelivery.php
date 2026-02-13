<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiWebhookDelivery extends Model
{
    protected $table = 'api_webhook_deliveries';

    protected $fillable = [
        'api_client_id',
        'event_type',
        'payload',
        'url',
        'status',
        'attempts',
        'http_status_code',
        'response_body',
        'next_retry_at',
        'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'attempts' => 'integer',
            'http_status_code' => 'integer',
            'next_retry_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    public function apiClient()
    {
        return $this->belongsTo(ApiClient::class, 'api_client_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }
}
