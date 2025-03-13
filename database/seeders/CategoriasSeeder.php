<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Hardware'],
            ['nombre' => 'Software'],
            ['nombre' => 'Redes'],
            ['nombre' => 'Impresión'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
} 