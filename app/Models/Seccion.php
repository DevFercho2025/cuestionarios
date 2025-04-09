<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;
    protected $table = "secciones"; #título tabla
    protected $fillable = ["titulo", "bloque", "cuestionario", "time_at"]; #columnas, 
    public $timestamps = true; #laravel crea automáticamente "created_at, updated_at" pero esta tabla no tiene esos campos.

}
