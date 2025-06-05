<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use HasFactory;

    #define qué tabla es preguntas
    protected $table = "psico_alobri_question_types";
    protected $fillable = ["name", "description"];

    public $timestamps = false;

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'question_type_id');
    }
}
