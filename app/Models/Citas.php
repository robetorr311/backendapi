<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    // use HasFactory;

    public $table = "consultorio.citas";

    protected $fillable = ['id_documento','id_paciente','id_medico','id_servicio','id_horario','id_turno'];

}