<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parroquia extends Model
{
    // use HasFactory;

    public $table = "comun.parroquia";

    protected $fillable = ['nombre','id_estado','id_municipio'];
            
}