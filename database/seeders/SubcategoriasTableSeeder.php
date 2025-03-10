<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subcategoria;
use App\Models\Categoria;

class SubcategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener las categorías existentes
        $categoriaSoftware = Categoria::where('nombre', 'Software')->first();
        $categoriaHardware = Categoria::where('nombre', 'Hardware')->first();

        // Definir las subcategorías que deseas insertar
        $subcategorias = [
            // Subcategorías para Software
            ['categoria_id' => $categoriaSoftware->id, 'nombre' => 'Aplicació gestió administrativa'],
            ['categoria_id' => $categoriaSoftware->id, 'nombre' => 'Accés remot'],
            ['categoria_id' => $categoriaSoftware->id, 'nombre' => 'Aplicació de videoconferència'],
            ['categoria_id' => $categoriaSoftware->id, 'nombre' => 'Imatge de projector defectuosa'],

            // Subcategorías para Hardware
            ['categoria_id' => $categoriaHardware->id, 'nombre' => 'Problema amb el teclat'],
            ['categoria_id' => $categoriaHardware->id, 'nombre' => 'El ratolí no funciona'],
            ['categoria_id' => $categoriaHardware->id, 'nombre' => 'Monitor no s\'encén'],
            ['categoria_id' => $categoriaHardware->id, 'nombre' => 'Imatge de projector defectuosa'],
        ];

        // Insertar las subcategorías en la base de datos
        foreach ($subcategorias as $subcategoria) {
            Subcategoria::create($subcategoria);
        }
    }
}