<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cat = [
            ['nombre' => 'Software'],
            ['nombre' => 'Hardware'],
        ];

        foreach ($cat as $ca) {
            Categoria::create($ca);
        }
    }
}
