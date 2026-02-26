<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pack_id',
        'amount',
        'status',
        'payer_email',
        'payer_name',
        'payment_type',
        'stripe_payment_method_id',
        'stripe_payment_intent_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }
}
