<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Seccion extends Model
{
    use HasFactory;
    protected $table = "psico_alobri_sections"; #título tabla
    protected $fillable = ["tittle", "bloock", "test_id", "time_at"]; #columnas, 
    public $timestamps = true;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'test_id', 'id');
    }

    public function getTiempoEvaluacionAttribute()
    {
        $tiempo = Carbon::parse($this->time_at);

        $minutos = $tiempo->minute;
        $segundos = $tiempo->second;
    
        return "{$minutos} minutos, {$segundos} segundos";
    }
}
