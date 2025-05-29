<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    protected $table = 'autos';

    // Habilitar asignacion masiva
    protected $fillable = [
        'marca',
        'modelo',
        'anio',
        'color',
        'tipoTransmision',
        'km',
        'imagen',
        'precio',
    ];
}
