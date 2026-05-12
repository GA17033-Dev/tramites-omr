<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;

    protected $table = 'instituciones';

    protected $fillable = [
        'nombre',
        'tipo',
        'activo',
    ];

    public function tramites()
    {
        return $this->hasMany(Tramite::class, 'institucion_id');
    }



}
