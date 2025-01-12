<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;
    protected $table = 'asistencias';
    protected $primaryKey = 'idAsistencia';
    public $timestamps = false;
    protected $fillable = [
        'idGrupo',
        'nroModulo',
        'observacion',
        'fecha',
    ];
    protected $guarded = [];
}
