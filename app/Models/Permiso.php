<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    // use HasFactory;

    public $table = "comun.permisos";
    protected $fillable = ['id_sistema','id_menu','id_usuario'];
            
}