<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    // use HasFactory;

    public $table = "inventario.articulo";
    protected $fillable = ['nombre','descripcion','precio_unitario','precio_venta','id_imagen','codigo','id_categoria','id_usuario'];
            
}
