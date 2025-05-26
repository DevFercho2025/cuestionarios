<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'psico_alobri_user_tokens';
    protected $fillable = ['token', 'user_id'];
    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
