<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class configPack extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pack_id',
        'included_tests_ids',
        'expiration_date',
    ];

    protected $casts = [
        'included_tests_ids' => 'array',
        'expiration_date' => 'datetime',
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
