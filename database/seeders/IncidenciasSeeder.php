<?php

namespace Database\Seeders;

use App\Models\Incidencia;
use Illuminate\Database\Seeder;

class IncidenciasSeeder extends Seeder
{
    public function run(): void
    {
        $incidencias = [
            [
                'cliente_id' => 2,
                'tecnico_id' => 4,
                'sede_id' => 1,
                'categoria_id' => 1,
                'subcategoria_id' => 1,
                'descripcion' => 'La pantalla no enciende',
                'estado_id' => 2,
                'prioridad_id' => 1,
                'fecha_creacion' => now(),
            ],
            [
                'cliente_id' => 2,
                'tecnico_id' => 4,
                'sede_id' => 1,
                'categoria_id' => 2,
                'subcategoria_id' => 3,
                'descripcion' => 'El sistema operativo no arranca',
                'estado_id' => 3,
                'prioridad_id' => 2,
                'fecha_creacion' => now(),
            ],
            [
                'cliente_id' => 2,
                'tecnico_id' => 4,
                'sede_id' => 1,
                'categoria_id' => 3,
                'subcategoria_id' => 5,
                'descripcion' => 'No hay conexión WiFi',
                'estado_id' => 4,
                'prioridad_id' => 3,
                'fecha_creacion' => now(),
            ],
        ];

        foreach ($incidencias as $incidencia) {
            Incidencia::create($incidencia);
        }
    }
} 