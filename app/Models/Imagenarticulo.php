<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagenarticulo extends Model
{
    // use HasFactory;

    public $table = "inventario.imagenarticulo";
    protected $fillable = ['nombre','url','alt','id_articulo','id_usuario'];
            
}
