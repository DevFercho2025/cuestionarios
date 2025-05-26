<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $table = "psico_alobri_answers"; 
    protected $fillable = ["answer", "option", "question_id"];
    protected $primaryKey = "id";

    public $timestamps = false; 

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'question_id', 'id');
    }
}
