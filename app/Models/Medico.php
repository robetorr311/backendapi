<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    // use HasFactory;

    public $table = "consultorio.medicos";
    protected $fillable = ['cedula', 'nombre', 'mpps', 'colegio', 'fechadenacimiento', 'sexo', 'email', 'telefono_domicilio', 'telefono_movil', 'direccion', 'id_estado', 'id_municipio', 'id_parroquia', 'id_localidad', 'id_usuario'];
}
