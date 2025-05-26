<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplicacion extends Model
{
    protected $table = 'psico_alobri_application_access_codes';
    protected $fillable = ['user_id', 'vacancy', 'code', 'camera', 'location'];
    public $timestamps = false;
    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

