<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuestionario extends Model
{
    use HasFactory;
    protected $table = 'cuestionarios';
    protected $primaryKey = 'idCuestionario';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'fechaCreacion',
        'tipo',
        'idLeccion',
        'restringir_fecha',
        'fechaInicio',
        'horaInicio',
        'fechaFin',
        'horaFin',
        'timeDisponible',
        'intentoDisponible',
        'preguntaPagina',
        'revisarPreguntas',
        'verResultados',
        'preguntasAleatoria'
    ];
}
