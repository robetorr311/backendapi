<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    // use HasFactory;

    public $table = "ventas.entrega";
    protected $fillable = ['nombre','id_tipoentrega','id_courier'];
            
}
