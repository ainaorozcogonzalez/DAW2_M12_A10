<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategoria;

class SubCategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */    public function run(): void
    {
        $subcat = [
            ['categoria_id' => 1, 'nombre' => 'Aplicación gestión administrativa.'],
            ['categoria_id' => 1, 'nombre' => 'Acceso remoto.'],
            ['categoria_id' => 1, 'nombre' => 'Aplicación de videoconferencias.'],
            ['categoria_id' => 1, 'nombre' => 'Imagen de projector defectuosa.'],


            ['categoria_id' => 2, 'nombre' => 'Problema cone el teclado.'],
            ['categoria_id' => 2, 'nombre' => 'El ratón no funciona.'],
            ['categoria_id' => 2, 'nombre' => "Monitor no se enciende."],
            ['categoria_id' => 2, 'nombre' => 'Imagen de projector defectuosa.'],
        ];

        foreach ($subcat as $sub) {
            Subcategoria::create($sub);
        }
    }
}
