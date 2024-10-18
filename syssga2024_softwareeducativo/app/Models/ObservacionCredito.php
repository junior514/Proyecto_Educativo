<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacionCredito extends Model
{
    use HasFactory;
    protected $table = 'observaciones_creditos';

    protected $primaryKey = 'idObservacion';

    protected $fillable = [
        'fechaObs',
        'detalleObs',
        'idCredito',
        'id',
    ];

    public $timestamps = false; 
}
