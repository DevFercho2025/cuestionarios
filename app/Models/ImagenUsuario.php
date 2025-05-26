<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenUsuario extends Model
{
    use HasFactory;

    protected $table = 'psico_alobri_test_photos';
    protected $fillable = ['user_id', 'file_name', 'file_path', 'created_at','token_id'];
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tokenEv()
    {
        return $this->belongsTo(TokenEvaluacion::class, 'token_id');
    }
}
