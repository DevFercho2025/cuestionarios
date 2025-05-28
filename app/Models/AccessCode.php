<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessCode extends Model
{
    protected $table = 'psico_alobri_application_access_codes';
    protected $fillable = ['user_id', 'vacancy', 'code', 'camera', 'location'];
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}