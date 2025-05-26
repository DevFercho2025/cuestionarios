<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class usuarios_categoria extends Model
{
    use HasFactory;
    protected $table = 'psico_alobri_user_assigned_tests';
    protected $fillable = ['user_id', 'test_id'];
    public $timestamps = false;


    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'test_id');
    }

}


