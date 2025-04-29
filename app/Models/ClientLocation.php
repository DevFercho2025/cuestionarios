<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_locations_sede';

    protected $fillable = [
        'client_id',
        'place',
        'country',
        'postal_code',
        'neighborhood',
        'state',
        'maps',
        'address',
        'latitude',
        'longitude',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
