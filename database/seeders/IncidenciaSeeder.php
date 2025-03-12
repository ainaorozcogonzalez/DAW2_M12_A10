<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Incidencia;


class IncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incidencias = [
            [
                'cliente_id' => 2,
                'tecnico_id' => 3,
                'sede_id' => 1,
                'categoria_id' => 1,
                'subcategoria_id' => 2,
                'descripcion' => 'no funciona',
                'estado_id' => 1,
                'prioridad_id' => 1,
                'fecha_creacion' => '2025-03-10 16:45:20',
            ],
            [
                'cliente_id' => 2,
                'tecnico_id' => 3,
                'sede_id' => 2,
                'categoria_id' => 1,
                'subcategoria_id' => 2,
                'descripcion' => 'no funciona',
                'estado_id' => 1,
                'prioridad_id' => 1,
                'fecha_creacion' => '2025-03-10 16:45:20',
            ],
            [
                'cliente_id' => 2,
                'tecnico_id' => 3,
                'sede_id' => 3,
                'categoria_id' => 1,
                'subcategoria_id' => 2,
                'descripcion' => 'no funciona',
                'estado_id' => 1,
                'prioridad_id' => 1,
                'fecha_creacion' => '2025-03-10 16:45:20',
            ],
            [
                'cliente_id' => 2,
                'tecnico_id' => 3,
                'sede_id' => 1,
                'categoria_id' => 1,
                'subcategoria_id' => 2,
                'descripcion' => 'no funciona',
                'estado_id' => 1,
                'prioridad_id' => 1,
                'fecha_creacion' => '2025-03-10 16:45:20',
            ]
        ];

        foreach ($incidencias as $incidencia) {
            Incidencia::create($incidencia);
        }
    }
}
