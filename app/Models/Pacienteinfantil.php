<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pacienteinfantil extends Model
{
    // use HasFactory;

    public $table = "consultorio.pacienteinfantil";
    protected $fillable = ['cedula', 'nombre', 'fechadenacimiento', 'sexo', 'email', 'telefono_domicilio', 'telefono_movil', 'direccion', 'id_estado', 'id_municipio', 'id_parroquia', 'id_localidad', 'id_herencia', 'padre', 'madre', 'id_estatus', 'id_antecedentes', 'id_usuario'];

                 
}
