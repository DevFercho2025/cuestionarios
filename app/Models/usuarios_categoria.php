<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class usuarios_categoria extends Model
{
    use HasFactory;
    protected $table = 'psico_alobri_usuarios_categorias';
    protected $fillable = ['user_id', 'categorias_id'];
    public $timestamps = false;


    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categorias_id');
    }

}


