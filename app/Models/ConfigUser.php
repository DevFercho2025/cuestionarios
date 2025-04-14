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
        'is_admin',
        'is_super_admin',
        'role_id',
        'is_talentina_user',
        'user_id',
        'is_psico_ser',
        'active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id'); // Relación con el modelo Company
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * Método para comprobar si el usuario es super admin
     */
    public function isSuperAdmin()
    {
        return $this->is_super_admin;
    }

    /**
     * Método para comprobar si el usuario es de Talentina
     */
    public function isTalentinaUser()
    {
        return $this->is_talentina_user;
    }

    /**
     * Método para comprobar si el usuario es psico ser
     */
    public function isPsicoSer()
    {
        return $this->is_psico_ser;
    }
}
