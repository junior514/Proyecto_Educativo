<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAsistencia extends Model
{
    use HasFactory;
    protected $table = 'detalle_asistencias';
    protected $primaryKey = 'idDetalleAsistencia';
    public $timestamps = false;
    protected $fillable = [
        'idEstudiante',
        'estado',
        'observacion',
        'idAsistencia',
    ];
    protected $guarded = [];
}
