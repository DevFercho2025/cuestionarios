<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiCandidateMapping extends Model
{
    protected $table = 'api_candidate_mappings';

    protected $fillable = [
        'api_client_id',
        'user_id',
        'external_candidate_id',
    ];

    public function apiClient()
    {
        return $this->belongsTo(ApiClient::class, 'api_client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
