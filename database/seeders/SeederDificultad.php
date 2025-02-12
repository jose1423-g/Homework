<?php

namespace Database\Seeders;

use App\Models\dificultad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeederDificultad extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        dificultad::create(
            ['name' => 'Alta Dificultad']            
        );

        dificultad::create(            
            ['name' => 'Dificultad media']
        );

        dificultad::create(            
            ['name' => 'Baja Dificultad']
        );
    }
}
