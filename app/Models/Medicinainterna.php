<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicinainterna extends Model
{
    // use HasFactory;

    public $table = "consultorio.medicinainterna";

    protected $fillable = ['id_documento', 'fecha', 'id_paciente', 'id_medico', 'id_examenfisico', 'motivo', 'diagnostico', 'enfermedad', 'tratamiento'];

}