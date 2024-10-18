<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDescuento extends Model
{
    use HasFactory;
    protected $table = 'tipos_descuento';
    protected $primaryKey = 'idTipoDescuento';
    protected $fillable = ['nombreTP', 'valorPorcentaje'];
    public $timestamps = false; // Desactivar los timestamps
}
