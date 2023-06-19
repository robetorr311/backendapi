<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metodospago extends Model
{
    // use HasFactory;

    public $table = "ventas.metodospago";
    protected $fillable = ['nombre','descripcion'];
            
}
