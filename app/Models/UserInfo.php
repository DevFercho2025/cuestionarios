<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'psico_alobri_users_info';

    protected $fillable = [
        'user_id',
        'fecha_nacimiento',
        'genero',
        'codigo_postal',
        'celular',
    ];

    public $timestamps = false;

    protected $dates = ['fecha_nacimiento', 'created_at'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
