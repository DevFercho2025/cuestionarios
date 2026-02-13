<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiUsageLog extends Model
{
    public $timestamps = false;

    protected $table = 'api_usage_log';

    protected $fillable = [
        'api_client_id',
        'action',
        'tokens_consumed',
        'test_id',
        'candidate_user_id',
        'access_code_id',
        'ip_address',
        'request_metadata',
    ];

    protected function casts(): array
    {
        return [
            'tokens_consumed' => 'integer',
            'request_metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function apiClient()
    {
        return $this->belongsTo(ApiClient::class, 'api_client_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_user_id');
    }

    public function accessCode()
    {
        return $this->belongsTo(AccessCode::class, 'access_code_id');
    }
}
