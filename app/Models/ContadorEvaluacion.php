<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContadorEvaluacion extends Model
{
    protected $table = 'psico_alobri_test_assignment_counter';

    protected $fillable = [
        'user_id',
        'available_tests',
        'used_tests',
        'num_psychometric_tests',
        'num_socioeconomic_tests',
    ];

    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
