<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplicacion extends Model
{
    protected $table = 'aplicaciones';
    protected $fillable = ['user_id', 'vacante', 'codigo'];
    public $timestamps = false;
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

