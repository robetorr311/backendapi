<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examenfisico extends Model
{
    // use HasFactory;

    public $table = "consultorio.examenfisico";
    protected $fillable = ['id_paciente', 'fecha', 'sistolica', 'diastolica', 'pulso', 'frecuencia_cardiaca', 'frecuencia_respiratoria', 'peso', 'talla', 'temperatura', 'id_electrocardiograma', 'id_hematologia', 'aspecto', 'id_documento', 'id_servicio', 'id_cita'];
}