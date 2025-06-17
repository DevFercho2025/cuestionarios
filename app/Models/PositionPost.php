<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PositionPost extends Model
{
    use HasFactory;
    protected $table = "position_posts";
    protected $fillable = ['position_id', 'area_id', 'subarea_id','company_id'];
    public $timestamps = true;

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    //no se crea ni edita en psicometricas
    public function save(array $options = [])
    {
        throw new \Exception('No puede editar la información de vacantes externas desde Psicométricas.');
    }

    public function delete()
    {
        throw new \Exception('No puede eliminar vacantes externas desde Psicométricas.');
    }
}
