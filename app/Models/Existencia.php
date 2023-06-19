<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Existencia extends Model
{
    // use HasFactory;

    public $table = "inventario.existencia";
    protected $fillable = ['cantidad','valor','id_articulo','id_presentacion'];
            
}
