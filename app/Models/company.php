<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class company extends Model
{
    use HasFactory;
    protected $table = "company";
    protected $fillable = ["nombre","created_at","updated_at","time_at",""];
    public $timestamps = true;
}
