<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiTestTokenCost extends Model
{
    protected $table = 'api_test_token_costs';

    protected $fillable = [
        'test_id',
        'token_cost',
    ];

    protected function casts(): array
    {
        return [
            'token_cost' => 'integer',
        ];
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
}
