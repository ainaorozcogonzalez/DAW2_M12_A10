<?php

namespace Database\Seeders;

use App\Models\Prioridad;
use Illuminate\Database\Seeder;

class PrioridadesSeeder extends Seeder
{
    public function run(): void
    {
        $prioridades = [
            ['nombre' => 'Alta'],
            ['nombre' => 'Media'],
            ['nombre' => 'Baja'],
        ];

        foreach ($prioridades as $prioridad) {
            Prioridad::create($prioridad);
        }
    }
} 