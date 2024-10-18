<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudianteCuestionario extends Model
{
    use HasFactory;
    protected $table = 'estudiante_cuestionarios';
    protected $primaryKey = 'idEstCuestionario';
    public $timestamps = false;
    protected $fillable = [
        'idEstudiante',
        'idCuestionario',
        'fechaCreacion',
        'nota',
        'comentario',
        'fechaEntrega'
        
    ];
}
