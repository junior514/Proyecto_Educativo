<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Docente extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'docentes';
    protected $primaryKey = 'idDocente';
    public $timestamps = false;
    protected $fillable = ['nroDoc', 'nomDoc', 'telDoc', 'dirDoc', 'espDoc', 'email', 'password'];
    protected $guarded = [];

}
