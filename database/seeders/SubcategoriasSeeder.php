<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategoria;

class SubCategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcat = [
            ['categoria_id' => 1, 'nombre' => 'Aplicació gestió administrativa.'],
            ['categoria_id' => 1, 'nombre' => 'Accés remot.'],
            ['categoria_id' => 1, 'nombre' => 'Aplicació de videoconferència.'],
            ['categoria_id' => 1, 'nombre' => 'Imatge de projector defectuosa.'],


            ['categoria_id' => 2, 'nombre' => 'Problema amb el teclat.'],
            ['categoria_id' => 2, 'nombre' => 'El ratolí no funciona.'],
            ['categoria_id' => 2, 'nombre' => "Monitor no s'encén."],
            ['categoria_id' => 2, 'nombre' => 'Imatge de projector defectuosa.'],
        ];

        foreach ($subcat as $sub) {
            Subcategoria::create($sub);
        }
    }
}
