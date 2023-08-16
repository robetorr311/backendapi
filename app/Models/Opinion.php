<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    // use HasFactory;

    public $table = "comun.opinion";
    protected $fillable = ['nombre','email','mensaje','id_post'];
            
}