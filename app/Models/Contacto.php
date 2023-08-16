<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    // use HasFactory;

    public $table = "comun.contacto";
    protected $fillable = ['nombre','email','telefono','mensaje'];
            
}