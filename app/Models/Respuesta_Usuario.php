<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta_Usuario extends Model
{
    use HasFactory;

    protected $table = "respuestas_usuario";
    protected $fillable = ['user_id','pregunta_id', 'respuesta_id','ip_usuario','token_id'];
    public $timestamps = false; 

    public function tokenEv(){
        return $this->belongsTo(TokenEvaluacion::class, 'token_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id');
    }

    public function respuesta()
    {
        return $this->belongsTo(Respuesta::class, 'respuesta_id');
    }

    public function respuestaCorrecta()
    {
        return $this->hasOne(Respuesta_Correcta::class, 'pregunta_id', 'pregunta_id');
    }

}
