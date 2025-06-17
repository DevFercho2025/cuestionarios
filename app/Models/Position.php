<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Position extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'company_id'];
    public $timestamps = true;

    public function post()
    {
        return $this->hasMany(PositionPost::class);
    }
}
