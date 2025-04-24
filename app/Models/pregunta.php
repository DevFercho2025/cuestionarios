<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pregunta extends Model
{
    use HasFactory;

    #define qué tabla es preguntas
    protected $table = "psico_alobri_preguntas"; #título tabla
    protected $fillable = ["pregunta", "cuestionario", "required","seccion_id"]; #columnas, 
    protected $primaryKey = "pregunta_id"; #se especifica si la llave primaria no se llama solo "id" en la bd.

    public $timestamps = false; #laravel crea automáticamente "created_at, updated_at" pero esta tabla no tiene esos campos.

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'pregunta_id', 'pregunta_id');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'seccion_id', 'id');
    }
}
