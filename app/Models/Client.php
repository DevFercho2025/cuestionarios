<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clients';

    protected $fillable = [
        'industry_sector',
        'postal_code',
        'neighborhood',
        'registration',
        'brochure_studies',
        'software_experience',
        'industry',
        'employee_count',
        'website',
        'state',
        'city',
        'country',
        'notes',
        'name',
        'email',
        'phone',
        'company_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];



    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function clientLocations()
    {
        return $this->hasMany(ClientLocation::class, 'client_id');
    }
}
