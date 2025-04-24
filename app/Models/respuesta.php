<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $table = "psico_alobri_respuestas"; 
    protected $fillable = ["respuesta", "opcion", "pregunta_id"];
    protected $primaryKey = "respuesta_id";

    public $timestamps = false; 

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id', 'pregunta_id');
    }
}
