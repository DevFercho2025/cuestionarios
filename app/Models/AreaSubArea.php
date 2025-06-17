<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AreaSubArea extends Model
{
    use HasFactory;
    protected $table = 'area_sub_area';

    protected $fillable = ['area_id', 'sub_area_id', 'company_id'];
    public $timestamps = true;
}
