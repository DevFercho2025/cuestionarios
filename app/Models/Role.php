<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'description',
        'type',
        'company_id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function isSuperAdmin(){
        return $this->id == 1;
    }

    public function isAdmin(){
        return $this->id == 2;
    }

    public function isCandidate(){
        return $this->id ==0;
    }

    public function users(){
        return $this->hasMany(ConfigUser::class, 'role_id');
    }

}