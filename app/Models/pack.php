<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pack extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'content',
        'included_tests_ids',
        'adquirable_tests_quantity',
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
