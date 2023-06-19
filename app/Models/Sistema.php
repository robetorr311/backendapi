<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sistema extends Model
{
    // use HasFactory;

    public $table = "comun.sistema";
    protected $fillable = ['nombre'];
            
}