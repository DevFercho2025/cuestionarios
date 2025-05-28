<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Seccion extends Model
{
    use HasFactory;
    protected $table = "psico_alobri_sections"; #título tabla
    protected $fillable = ["title", "block", "test_id", "time_at"]; #columnas, 
    public $timestamps = true;

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function getTiempoSeccionAttribute()
    {
        $tiempo = Carbon::parse($this->time_at);

        $minutos = $tiempo->minute;
        $segundos = $tiempo->second;
    
        return "{$minutos} minutos, {$segundos} segundos";
    }
}
