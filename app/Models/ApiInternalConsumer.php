<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiInternalConsumer extends Model
{
    protected $table = 'api_internal_consumers';

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'secret',
        'is_active',
        'last_used_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_used_at' => 'datetime',
        ];
    }

    protected $hidden = [
        'secret',
    ];
}
