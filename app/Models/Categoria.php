<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = "psico_alobri_tests";
    protected $fillable = ["test_title","created_at","updated_at","time_at"];
    public $timestamps = true;

    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'id');
    }
}
