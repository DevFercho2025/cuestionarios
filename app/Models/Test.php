<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class Test extends Model
{
    use HasFactory;

    protected $table = "psico_alobri_tests";
    protected $fillable = ["test_title","created_at","updated_at","time_at", "type_id"];
    public $timestamps = true;

    public function type()
    {
        return $this->belongsTo(TestType::class, 'type_id');
    }

    public function sections()
    {
        return $this->hasMany(Seccion::class, 'test_id');
    }
    
    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'psico_alobri_user_assigned_tests', 'test_id', 'user_id');
    }

    #time_at es la sumatoria de todos los tiempos de las secciones del test
    public function recalculateTotalTime()
    {
        $totalSeg = 0;

        foreach ($this->sections as $section) {
            $tiempo = Carbon::parse($section->time_at);
            $totalSeg += ($tiempo->hour * 3600) + ($tiempo->minute * 60) + $tiempo->second;
        }

        $intervalo = CarbonInterval::seconds($totalSeg)->cascade(); //cascade convierte total de segundos a tiempo estandar en h, m y s.
        $this->time_at = sprintf('%02d:%02d:%02d', $intervalo->hours, $intervalo->minutes, $intervalo->seconds);
        $this->save();
        #sprintf asegura guardado con HH:MM:SS
    }

    //cuando se elimina
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($test) {
            foreach ($test->sections as $section) {
                $section->delete(); //eliminar sus secciones
            }
        });
    }
}
