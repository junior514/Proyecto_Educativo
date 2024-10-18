<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptoCredito extends Model
{
    use HasFactory;
    protected $table = 'concepto_creditos';
    protected $primaryKey = 'idConceptoCredito ';
    public $timestamps = false;
    protected $fillable = ['valorUnidad', 'cantidad', 'porcenDescuento', 'valorDescontado', 'valorTotal', 'idProducto', 'idCredito'];
    protected $guarded = [];
}
