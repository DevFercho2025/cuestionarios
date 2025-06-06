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

    public function assignedTests()
    {
        return $this->belongsToMany(Test::class, 'psico_alobri_user_assigned_tests', 'user_id', 'test_id');
    }

    public function assignedTestsPorCodigo($codigoId)
    {
        return $this->assignedTests()
            ->withPivot(['application_access_code_id', 'company_id'])//trae info de la compañía
            ->wherePivot('application_access_code_id', $codigoId);//filtra por código
    }

    public function isTalentinaUser()
    {
        return $this->config && $this->config->is_talentina_user;
    }

    public function userTestsAcessCodes()
    {
        return $this->hasMany(AccessCode::class);
    }
    
    #cambiar a userTokens()
    public function tokensEvaluaciones()
    {
        return $this->hasMany(TokenEvaluacion::class, 'user_id');
    }

    #cambiar a userAnswers()
    public function respuestasUsuario()
    {
        return $this->hasMany(Respuesta_Usuario::class, 'user_id');
    }
}
