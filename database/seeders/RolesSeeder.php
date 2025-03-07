<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'administrador'],
            ['nombre' => 'cliente'],
            ['nombre' => 'gestor'],
            ['nombre' => 'tecnico'],
        ];

        foreach ($roles as $rol) {
            Rol::create($rol);
        }
    }
} 