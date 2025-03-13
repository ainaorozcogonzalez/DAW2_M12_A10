<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Subcategoria;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            SedesSeeder::class,
            EstadoIncidenciasSeeder::class,
            PrioridadesSeeder::class,
            UsersSeeder::class,
            CategoriasSeeder::class,
            SubCategoriasSeeder::class,
            IncidenciasSeeder::class,
            ComentariosSeeder::class,
            ArchivosSeeder::class,
        ]);
    }
}
