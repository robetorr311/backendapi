<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipoentrega extends Model
{
    // use HasFactory;

    public $table = "ventas.tipoentrega";
    protected $fillable = ['nombre'];
            
}
