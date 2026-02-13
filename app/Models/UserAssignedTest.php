<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAssignedTest extends Model
{
    //tabla donde se registra quiénes asignan tests, a qué candidatos y con qué código.
    use HasFactory;
    protected $table = 'psico_alobri_user_assigned_tests';
    protected $fillable = ['user_id', 'test_id','application_access_code_id','company_user_id','test_record_id'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function accessCode()
    {
        return $this->belongsTo(AccessCode::class, 'application_access_code_id');
    }

    public function companyUser()
    {
        return $this->belongsTo(User::class, 'company_user_id');
    }

    public function testRecord()
    {
        return $this->belongsTo(UserTestRecord::class, 'test_record_id');
    }

}


