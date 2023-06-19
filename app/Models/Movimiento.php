<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    // use HasFactory;

    public $table = "inventario.movimiento";
    protected $fillable = ['id_tipomovimiento','id_articulo','cantidad','valor','id_entrada','id_salida','fecha','id_usuario'];
            
}
