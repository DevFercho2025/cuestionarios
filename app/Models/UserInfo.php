<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'psico_alobri_users_info';

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'postal_code',
        'phone',
        'country',
    ];

    public $timestamps = false;

    protected $dates = ['date_of_birth', 'created_at'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
