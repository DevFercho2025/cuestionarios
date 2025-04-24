<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Seccion extends Model
{
    use HasFactory;
    protected $table = "psico_alobri_secciones"; #título tabla
    protected $fillable = ["titulo", "bloque", "categoria_id", "time_at"]; #columnas, 
    public $timestamps = true; #laravel crea automáticamente "created_at, updated_at" pero esta tabla no tiene esos campos.

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }

    public function getTiempoEvaluacionAttribute()
    {
        $tiempo = Carbon::parse($this->time_at);

        $minutos = $tiempo->minute;
        $segundos = $tiempo->second;
    
        return "{$minutos} minutos, {$segundos} segundos";
    }
}
