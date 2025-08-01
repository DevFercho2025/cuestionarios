<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPaymentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'used_tests_summary',
    ];

        public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function getUsedTestsSummaryAttribute()
    {
        $ids = json_decode($this->used_tests_summary, true);

        if (!is_array($ids) || empty($ids)) {
            return collect();
        }

        return Test::whereIn('id', $ids)->get();

        /*Estructura del json:
        {
            id del test: veces usado
            "12": 3,
            "18": 7,
        }*/
    }
}
