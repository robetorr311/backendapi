<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    // use HasFactory;

    public $table = "comun.perfil";

    protected $fillable = ['id_usuario','direccion','id_estado','id_municipio','id_parroquia','id_localidad','twitter','instagram', 'facebook', 'cedula','id_tipousuario'];
            
}