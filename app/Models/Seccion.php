<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Seccion extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = "psico_alobri_sections"; #título tabla
    protected $fillable = ["title", "block", "test_id", "time_at"]; #columnas, 
    public $timestamps = true;

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function questions()
    {
        return $this->hasMany(Pregunta::class, 'section_id', 'id');
    }

    public function getTiempoSeccionAttribute()
    {
        $tiempo = Carbon::parse($this->time_at);

        $minutos = $tiempo->minute;
        $segundos = $tiempo->second;
    
        return "{$minutos} minutos, {$segundos} segundos";
    }

    protected static function boot()
    {
        parent::boot();

        static::forceDeleted(function ($section) {
            foreach ($section->questions()->withTrashed()->get() as $question) {
                $question->forceDelete();
            }
        });

        static::deleting(function ($section) {
            foreach ($section->questions as $pregunta) {
                $pregunta->delete();
            }
        });

        static::restored(function ($section) {
            foreach ($section->questions()->withTrashed()->get() as $question) {
                $question->restore();
            }
        });
    }
}
