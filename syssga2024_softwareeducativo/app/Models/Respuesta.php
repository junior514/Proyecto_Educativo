<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;
    protected $table = 'pregunta_respuestas';
    protected $primaryKey = 'idRespuesta';
    public $timestamps = false;

    protected $fillable = [
        'enumerarTD',
        'opcionRespTD',
        'fechaCreacion',
        'respuestaTD',
        'idPregunta'
        
    ];
}
