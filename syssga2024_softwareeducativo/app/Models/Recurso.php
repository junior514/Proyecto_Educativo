<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    use HasFactory;
    protected $table = 'recursos';
    protected $primaryKey = 'idRecurso';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'fechaInicio',
        'horaInicio',
        'fechaFin',
        'horaFin',
        'fechaCreacion',
        'tipo',
        'idLeccion',
        'archivo'
    ];
}
