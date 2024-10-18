<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;
    protected $table = 'matriculas';
    protected $primaryKey = 'idMatricula';
    public $timestamps = false;
    protected $fillable = ['idCurso', 'idEstudiante', 'fecMat', 'precioMat', 'precioMod', 'nroCuotas', 'fechaPrimeraCuota', 'id'];
    protected $guarded = [];
}
