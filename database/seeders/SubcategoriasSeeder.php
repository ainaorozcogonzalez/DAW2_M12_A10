<?php

namespace Database\Seeders;

use App\Models\Subcategoria;
use Illuminate\Database\Seeder;

class SubcategoriasSeeder extends Seeder
{
    public function run(): void
    {
        $subcategorias = [
            ['categoria_id' => 1, 'nombre' => 'Aplicació gestió administrativa.'],
            ['categoria_id' => 1, 'nombre' => 'Accés remot.'],
            ['categoria_id' => 1, 'nombre' => 'Aplicació de videoconferència.'],
            ['categoria_id' => 1, 'nombre' => 'Imatge de projector defectuosa.'],
            ['categoria_id' => 2, 'nombre' => 'Problema amb el teclat.'],
            ['categoria_id' => 2, 'nombre' => 'El ratolí no funciona.'],
            ['categoria_id' => 2, 'nombre' => "Monitor no s'encén."],
            ['categoria_id' => 2, 'nombre' => 'Imatge de projector defectuosa.'],
        ];

        foreach ($subcategorias as $subcategoria) {
            Subcategoria::create($subcategoria);
        }
    }
}
