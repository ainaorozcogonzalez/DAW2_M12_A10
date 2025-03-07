<?php

namespace Database\Seeders;

use App\Models\Sede;
use Illuminate\Database\Seeder;

class SedesSeeder extends Seeder
{
    public function run(): void
    {
        $sedes = [
            ['nombre' => 'Barcelona', 'direccion' => 'Carrer de la Innovació, 1'],
            ['nombre' => 'Berlín', 'direccion' => 'Innovationstraße 2'],
            ['nombre' => 'Montreal', 'direccion' => 'Rue de l\'Innovation 3'],
        ];

        foreach ($sedes as $sede) {
            Sede::create($sede);
        }
    }
} 