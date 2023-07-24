<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terapiarespiratoria extends Model
{
    // use HasFactory;

    public $table = "consultorio.terapiarespiratoria";
    protected $fillable = ['id_documento', 'fecha', 'id_paciente', 'id_medico', 'id_examenfisico', 'diagnostico', 'fisio_terapia_torax', 'espirometria_incentiva', 'inhalo_terapia', 'tecnicas_relajacion', 'entrenamiento_fisico', 'sugerencias'];
                 
}