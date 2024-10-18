<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuotaPagar extends Model
{
    use HasFactory;
    protected $table = 'cuotas_a_pagar';
    protected $primaryKey = 'idCuotaAPagar';
    public $timestamps = false;
    protected $fillable = ['fechAPagar', 'montoAPagar', 'idCredito'];
    protected $guarded = [];
}
