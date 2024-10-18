<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaTarea extends Model
{
    use HasFactory;
    protected $table = 'entrega_tareas';
    protected $primaryKey = 'idEntregaTarea';
    public $timestamps = false;
    protected $fillable = [
        'fechaEntrega',
        'comentarioEstudiante',
        'archivoEntega',
        'fechaRevision',
        'nota',
        'comentarioDocente',
        'idRecurso',
        'idEstudiante',
    ];
}
