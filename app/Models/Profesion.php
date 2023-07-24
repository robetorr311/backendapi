<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesion extends Model
{
    // use HasFactory;

    public $table = "comun.profesion";
    protected $fillable = ['nombre'];
            
}