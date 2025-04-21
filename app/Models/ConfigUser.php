<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConfigUser extends Model
{
    use HasFactory;
    protected $table = 'config_users';
    protected $fillable = [
        'company_id',
        'role_id',
        'is_talentina_user',
        'user_id',
        'is_psico_ser',
        'active',
    ];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id'); // Relación con el modelo Company
    }

    public function isTalentinaUser(){
        return $this->is_talentina_user;
    }

    public function isPsicoSer(){
        return $this->is_psico_ser;
    }
}
