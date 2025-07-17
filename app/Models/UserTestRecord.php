<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserTestRecord extends Model
{
    //tabla de registro del progreso de los candidatos en cada evaluacion
    use HasFactory;
    protected $table = 'psico_alobri_candidate_test_records';
    protected $fillable = ['user_id', 'test_id','token_id','completed_sections_ids','started_at','finished_at'];
    public $timestamps = false;

    #casts para que Laravel convierta datos en php
    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'completed_sections_ids' => 'array' //JSON, con id de las secciones
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function previouslyDonetest()
    {
        return $this->belongsTo(Test::class);
    }

    public static function userCompletedSections($userId)
    {
        return self::where('user_id', $userId)
            ->pluck('completed_sections_ids')
            ->flatten()
            ->unique()
            ->toArray();
    }

    public function token()
    {
        return $this->belongsTo(TokenEvaluacion::class);
    }
}
