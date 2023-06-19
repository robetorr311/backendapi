<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    // use HasFactory;

    public $table = "inventario.salida";
    protected $fillable = ['nroorden','referencia','id_articulo','precio_venta','cantidad','id_venta','id_usuario','fecha'];
            
}
