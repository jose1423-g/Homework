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
            ['name' => 'Dificultad alta']            
        );

        dificultad::create(            
            ['name' => 'Dificultad media']
        );

        dificultad::create(            
            ['name' => 'Dificultad baja']
        );
    }
}
