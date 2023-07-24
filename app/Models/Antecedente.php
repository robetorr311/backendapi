<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antecedente extends Model
{
    // use HasFactory;

    public $table = "consultorio.antecedentes";
    protected $fillable = ['diabetes','dislipidemias','tabaquismo','sedentarismo','obesidad','diagnosticoeac','angina','cf','im','angioplastia','cirugia','arritmias','sv','bloqueoav','mpd','acv','enfcaritidea','enfperiferica','cardreumatica','id_paciente','observaciones'];              
}
