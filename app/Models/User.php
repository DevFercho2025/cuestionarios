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
        return $this->belongsToMany(Test::class, 'psico_alobri_user_assigned_tests', 'user_id', 'test_id')->withPivot(['application_access_code_id','company_user_id', 'test_record_id']);
    }

    public function assignedTestsPorCodigo($codigoId)
    {
        return  $this->assignedTests()->wherePivot('application_access_code_id', $codigoId);
    }

    public function userTestsAcessCodes()
    {
        return $this->hasMany(AccessCode::class);
    }

    public function isTalentinaUser()
    {
        return $this->config && $this->config->is_talentina_user;
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

    
    public function vacante()
    {
        return $this->hasOneThrough(
            AccessCode::class,               // Modelo final (donde está vacante)
            UserAssignedTest::class,         // Tabla intermedia
            'user_id',                       // Clave foránea en userAssignedTest (hacia User)
            'id',                            // Clave foránea en AccessCode (usada por userAssignedTest)
            'id',                            // Clave local en User
            'application_access_code_id'     // Clave local en userAssignedTest que conecta a AccessCode
        );
    }

    public function TestCounter(){
        return $this->hasOne(ContadorEvaluacion::class, 'user_id');
    }

    #El historial de acciones del usuario
    public function history()
    {
        return $this->hasMany(History::class, 'user_id');
    }
}
