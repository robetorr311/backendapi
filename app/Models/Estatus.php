<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estatus extends Model
{
    // use HasFactory;

    public $table = "comun.estatus";

    protected $fillable = ['nombre','tipo_estatus'];
            
}