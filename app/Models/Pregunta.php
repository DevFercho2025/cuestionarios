<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pregunta extends Model
{
    use HasFactory;

    #define qué tabla es preguntas
    protected $table = "psico_alobri_questions"; #título tabla
    protected $fillable = ["question", "test_id", "required","section_id","question_type_id"]; #columnas, 
    protected $primaryKey = "id"; #se especifica si la llave primaria no se llama solo "id" en la bd.

    public $timestamps = false; #laravel crea automáticamente "created_at, updated_at" pero esta tabla no tiene esos campos.

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'question_id', 'id');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'section_id', 'id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function questionType()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($pregunta) {
            $pregunta->respuestas()->delete();//eliminar respuestas asociadas
        });
    }
}
