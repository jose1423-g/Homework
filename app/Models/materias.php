<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class materias extends Model
{
    protected $table = 'materias'; 

    protected $fillable = [
        'name',
        'profesor',
        'dificultad_id',
    ];
}
