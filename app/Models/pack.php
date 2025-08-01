<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pack extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'content',
        'adquirable_tests',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function configPacks()
    {
        return $this->hasMany(ConfigPack::class);
    }
}
