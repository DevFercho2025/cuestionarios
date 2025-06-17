<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $table = 'areas';

    protected $fillable = ['company_id', 'name', 'description', 'active'];
    public $timestamps = true;

    public function subAreas()
    {
        return $this->belongsToMany(SubArea::class, 'area_sub_area', 'area_id', 'sub_area_id');
    }
}
