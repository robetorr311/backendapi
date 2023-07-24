<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    // use HasFactory;

    public $table = "consultorio.documento";
    protected $fillable = ['numero', 'id_origen', 'id_destino', 'id_tipodocumento', 'id_estatus', 'fecha', 'id_serviciosmedico', 'id_usuario'];
}