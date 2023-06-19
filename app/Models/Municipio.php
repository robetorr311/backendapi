<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    // use HasFactory;

    public $table = "comun.municipio";

    protected $fillable = ['nombre','id_estado'];
            
}