<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class materias extends Model
{
    protected $table = 'materias'; 

    protected $fillable = [
        'name',
        'user_id',
        'profesor',
        'dificultad_id',
    ];
}
