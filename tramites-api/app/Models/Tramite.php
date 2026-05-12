<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    use HasFactory;

    protected $table = 'tramites';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'institucion_id',
        'dias_habiles',
        'activo',
    ];


    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }
    
}
