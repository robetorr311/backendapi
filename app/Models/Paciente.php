<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    // use HasFactory;

    public $table = "consultorio.pacientes";
    protected $fillable = ['cedula', 'nombre', 'fechadenacimiento', 'sexo', 'email', 'telefono_domicilio', 'telefono_movil', 'direccion', 'id_estado', 'id_municipio', 'id_parroquia', 'id_localidad', 'id_herencia', 'id_profesion', 'id_estadocivil', 'id_estatus', 'id_antecedentes', 'id_usuario'];

                 
}
