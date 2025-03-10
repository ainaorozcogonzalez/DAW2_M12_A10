<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definir las categorías que deseas insertar
        $categorias = [
            ['nombre' => 'Software'],
            ['nombre' => 'Hardware'],
        ];

        // Insertar las categorías en la base de datos
        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}