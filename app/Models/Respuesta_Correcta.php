<?php

namespace App\Models;
use App\Models\Respuesta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta_Correcta extends Model
{
    use HasFactory;

    protected $table = "psico_alobri_pregunta_y_respuesta_correcta";
    protected $fillable = ['pregunta_id', 'respuesta_id'];
    public $timestamps = false; 

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id', 'pregunta_id');
    }

    public function respuesta()
    {
        return $this->belongsTo(Respuesta::class, 'respuesta_id', 'respuesta_id');
    }
}
