<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;
    protected $table = 'modulos';
    protected $primaryKey = 'idModulo';
    public $timestamps = false;
    protected $fillable = ['idMatricula', 'nota1', 'nota2', 'nota3', 'notaExamen', 'notaRecuperacion'];
    protected $guarded = [];
}
