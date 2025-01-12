<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leccion extends Model
{
    use HasFactory;
    protected $table = 'lecciones';
    protected $primaryKey = 'idLeccion';
    public $timestamps = false;

    protected $fillable = [
        'nombreLeccion',
        'nroModulo',
        'idGrupo',
        'tipo',
    ];
}
