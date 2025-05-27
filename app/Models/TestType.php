<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestType extends Model
{
    use HasFactory;

    protected $table = "psico_alobri_test_types";
    protected $fillable = ["type_name","category_id"];
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'type_id');
    }

}
