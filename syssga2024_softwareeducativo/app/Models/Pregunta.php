<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;
    protected $table = 'cuestionario_preguntas';
    protected $primaryKey = 'idPregunta';
    public $timestamps = false;

    protected $fillable = [
        'preguntaEnunciadoTD',
        'tipoPreg',
        'fechaCreacion',
        'puntajeTD',
        'idCuestionario'
        
    ];
}
