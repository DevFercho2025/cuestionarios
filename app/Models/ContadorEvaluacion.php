<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContadorEvaluacion extends Model
{
    protected $table = 'psico_alobri_contador_evaluaciones';

    protected $fillable = [
        'user_id',
        'pruebas_disponibles',
        'pruebas_usadas',
        'num_pruebasPsicometricas',
        'num_pruebas_socioeconómicas',
    ];

    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
