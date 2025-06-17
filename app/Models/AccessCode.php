<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessCode extends Model
{
    protected $table = 'psico_alobri_application_access_codes';
    protected $fillable = ['user_id', 'vacancy', 'code', 'camera', 'location','company_id','user_company_id'];
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function userCompany()
    {
        return $this->belongsTo(User::class, 'user_company_id');
    }

    public function assignedTests()
    {
        return $this->hasMany(userAssignedTest::class, 'application_access_code_id');
    }
}