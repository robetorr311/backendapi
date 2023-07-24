<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electrocardiograma extends Model
{
    // use HasFactory;

    public $table = "consultorio.electrocardiogramas";
    protected $fillable = ['nombrearchivo', 'url', 'id_paciente', 'id_usuario'];

}
