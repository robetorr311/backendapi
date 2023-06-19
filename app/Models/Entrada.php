<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    // use HasFactory;

    public $table = "inventario.entrada";
    protected $fillable = 'nroorden','factura','id_articulo','precio_unitario','precio_venta','cantidad','unidades','id_presentacion','fecha'];
            
}
