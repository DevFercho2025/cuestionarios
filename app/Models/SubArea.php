<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubArea extends Model
{
    use HasFactory;
    protected $table = 'sub_areas';
    protected $fillable = ['company_id', 'name', 'description', 'active'];
    public $timestamps = true;

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'area_sub_area', 'sub_area_id', 'area_id');
    }

    public function positionPosts()
    {
        return $this->hasMany(PositionPost::class, 'subarea_id');
    }
}






