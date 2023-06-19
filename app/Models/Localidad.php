<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    // use HasFactory;

    public $table = "comun.localidad";

    protected $fillable = ['nombre','id_estado','id_municipio','id_parroquia'];
            
}