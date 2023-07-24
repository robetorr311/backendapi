<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herencia extends Model
{
    // use HasFactory;

    public $table = "consultorio.herencia";
    protected $fillable = ['id_paciente', 'padre', 'madre', 'hermanos', 'observaciones'];              
}
