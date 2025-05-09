<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public $timestamps = true;

    public function config()
    {
        return $this->hasOne(ConfigUser::class, 'user_id');
    }

    public function info()
    {
        return $this->hasOne(UserInfo::class, 'user_id');
    }

    public function isTalentinaUser()
    {
        return $this->config && $this->config->is_talentina_user;
    }


    public function aplicaciones()
    {
        return $this->hasMany(Aplicacion::class);
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'psico_alobri_usuarios_categorias', 'user_id', 'categorias_id');
    }



}
