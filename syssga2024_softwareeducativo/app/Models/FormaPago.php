<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    use HasFactory;
    protected $table = 'formas_pago';
    protected $primaryKey = 'idFormaPago';
    protected $fillable = ['nombreFP'];
    public $timestamps = false; // Desactivar los timestamps
}
