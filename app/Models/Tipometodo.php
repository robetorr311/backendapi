<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipometodo extends Model
{
    // use HasFactory;

    public $table = "ventas.tiposmetodo";
    protected $fillable = ['nombre','descripcion'];
            
}
