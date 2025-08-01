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
        'pack_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class, 'pack_id');
    }
}
