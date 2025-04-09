<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aplicacion extends Model
{
    use HasFactory;

    protected $table = 'aplicaciones';

    protected $fillable = [
        'user_id',
        'cargo_aplicado',
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
