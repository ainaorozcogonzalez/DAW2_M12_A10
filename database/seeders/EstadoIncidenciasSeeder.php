<?php

namespace Database\Seeders;

use App\Models\EstadoIncidencia;
use Illuminate\Database\Seeder;

class EstadoIncidenciasSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['nombre' => 'Sin asignar'],
            ['nombre' => 'Asignada'],
            ['nombre' => 'En trabajo'],
            ['nombre' => 'Resuelta'],
            ['nombre' => 'Cerrada'],
        ];

        foreach ($estados as $estado) {
            EstadoIncidencia::create($estado);
        }
    }
} 