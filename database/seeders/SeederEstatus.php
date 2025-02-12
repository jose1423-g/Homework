<?php

namespace Database\Seeders;
use App\Models\estatus;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeederEstatus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        estatus::create(
            ['name' => 'Pendiente']            
        );

        estatus::create(
            ['name' => 'En proceso']            
        );

        estatus::create(
            ['name' => 'Finalizado']
        );
    }
}
