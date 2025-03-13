<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            CategoriasSeeder::class,
            SubcategoriasSeeder::class,
            UsersSeeder::class,
            IncidenciasSeeder::class,
            ComentariosSeeder::class,
            ArchivosSeeder::class,
        ]);
    }
}
