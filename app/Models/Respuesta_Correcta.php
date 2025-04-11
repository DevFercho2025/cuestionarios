<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta_Correcta extends Model
{
    use HasFactory;

    protected $table = "pregunta_y_respuesta_correcta";
    protected $fillable = ['pregunta_id', 'respuestas_id'];
    public $timestamps = false; 

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id', 'pregunta_id');
    }

    public function respuesta()
    {
        return $this->belongsTo(Respuesta::class, 'respuestas_id', 'respuesta_id');
    }
}
