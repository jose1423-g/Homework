<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tareas extends Model
{
    protected $table = 'tareas'; 

    protected $fillable = [
        'titulo',
        'fechaentrega',
        'descripcion',
        'materias_id',
        'dificultad_id',
        'estatus_id',
        'user_id',
    ];
}
