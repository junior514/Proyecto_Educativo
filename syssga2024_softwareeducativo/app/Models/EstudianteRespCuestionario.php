<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudianteRespCuestionario extends Model
{
    use HasFactory;
    protected $table = 'estudiante_respuestacuestionario';
    protected $primaryKey = 'idRespCuestionario';
    public $timestamps = false;

    protected $fillable = [
        'fechaCreacion',
        'idEstCuestionario',
        'idPregunta',
        'idRespuesta'
        
    ];
}
