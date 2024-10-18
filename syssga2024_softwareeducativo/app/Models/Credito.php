<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    use HasFactory;
    protected $table = 'creditos';
    protected $primaryKey = 'idCredito';
    public $timestamps = false;
    protected $fillable = ['fechaCre', 'valorCre', 'pagoAnticipado', 'fechaPrimCuota', 'periodoCuotas', 'nroCuotas', 'observacionesCre', 'idMatricula'];
    protected $guarded = [];
}
