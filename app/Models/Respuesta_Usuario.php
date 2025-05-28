<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta_Usuario extends Model
{
    use HasFactory;

    protected $table = "psico_alobri_user_answers";
    protected $fillable = ['user_id','question_id', 'answer_id','ip_address','token_id'];
    public $timestamps = false; 

    public function tokenEv(){
        return $this->belongsTo(TokenEvaluacion::class, 'id');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'question_id');
    }

    public function respuesta()
    {
        return $this->belongsTo(Respuesta::class, 'answer_id');
    }

    public function getIsCorrectAttribute()
    {
        return $this->respuesta?->is_correct ?? false;
    }
}
