<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Respuesta extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = "psico_alobri_answers"; 
    protected $fillable = ["answer", "option", "question_id", "is_correct","extra_data"];

    public $timestamps = true;

    protected $casts = [
        'extra_data' => 'json',
    ];

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'question_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::forceDeleted(function ($respuesta) {
            $extraData = $respuesta->extra_data;

            if (!empty($extraData['file_path']) && Storage::disk('public')->exists($extraData['file_path'])) {
                Storage::disk('public')->delete($extraData['file_path']);
            }
        });

        static::deleting(function ($respuesta) {
            $extraData = $respuesta->extra_data;

            if (!empty($extraData['file_path']) && Storage::disk('public')->exists($extraData['file_path'])) {
                Storage::disk('public')->delete($extraData['file_path']);
            }
        });
    }
}
