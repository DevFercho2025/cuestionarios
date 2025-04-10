<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplicacion extends Model
{
    protected $fillable = ['user_id', 'vacante', 'codigo'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

