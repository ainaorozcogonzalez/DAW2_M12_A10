<?php

namespace Database\Seeders;

use App\Models\Subcategoria;
use Illuminate\Database\Seeder;

class SubcategoriasSeeder extends Seeder
{
    public function run(): void
    {
        $subcategorias = [
            ['categoria_id' => 1, 'nombre' => 'Pantalla'],
            ['categoria_id' => 1, 'nombre' => 'Teclado'],
            ['categoria_id' => 2, 'nombre' => 'Sistema Operativo'],
            ['categoria_id' => 2, 'nombre' => 'Aplicación'],
            ['categoria_id' => 3, 'nombre' => 'Conexión WiFi'],
            ['categoria_id' => 3, 'nombre' => 'Cableado'],
            ['categoria_id' => 4, 'nombre' => 'Atascos de papel'],
            ['categoria_id' => 4, 'nombre' => 'Falta de tinta'],
        ];

        foreach ($subcategorias as $subcategoria) {
            Subcategoria::create($subcategoria);
        }
    }
} 