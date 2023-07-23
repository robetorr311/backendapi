<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    // use HasFactory;

    public $table = "ventas.pagos";
    protected $fillable = ['referencia','fecha','id_orden','id_usuario','monto','id_estatus','id_metodo'];
            
}
