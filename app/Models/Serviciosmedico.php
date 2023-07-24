<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serviciosmedico extends Model
{
    // use HasFactory;

    public $table = "consultorio.serviciosmedico";

    protected $fillable = ['id_medico', 'id_servicio', 'id_horario', 'id_turno' ];

             
}