<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Estudiante extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'estudiantes';
    protected $primaryKey = 'idEstudiante';
    public $timestamps = false;
    protected $fillable = ['nroDoc', 'nomEst', 'telEst', 'dirEst', 'generoEst', 'fotoEst', 'f_nacimiento', 'email', 'password', 'fecCre'];
    protected $guarded = [];
}
