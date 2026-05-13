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

    protected $casts = [
        'institucion_id' => 'integer',
        'dias_habiles'   => 'integer',
        'activo'         => 'boolean',
    ];

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }
}
