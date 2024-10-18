<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;
    protected $table = 'comprobantes';
    protected $primaryKey = 'idComprobante';
    public $timestamps = false;
    protected $fillable = [
        'idEstudiante',
        'idPago',
        'tipoDoc',
        'tipoOperacion',
        'serieComprobante',
        'numComprobante',
        'fechaHora',
        'tipoPago',
        'monedaPago',
        'igv',
        'totalComprobante',
        'descuentoComprobante',
        'sunat_estado',
        'sunat_descripcion',
        'sunat_cdr',
        'sunat_xml',
    ];
    protected $guarded = [];
}
