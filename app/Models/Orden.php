<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    // use HasFactory;

    public $table = "ventas.orden";
    protected $fillable = ['numero','fecha','id_pago','id_usuario','id_articulo','cantidad','precio','id_estatus','total','id_entrega'];
            
}

            