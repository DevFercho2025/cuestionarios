<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'description',
        'logo',
        'active',
        'is_pisco_alobri'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    public function assignedTests()
    {
        return $this->hasMany(userAssignedTest::class, 'company_id');
    }

}
