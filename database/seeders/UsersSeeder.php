<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nombre' => 'Admin',
                'email' => 'admin@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 1, // administrador
                'sede_id' => 1, // Barcelona
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Cliente',
                'email' => 'cliente@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 2, // cliente
                'sede_id' => 1, // Barcelona
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Gestor',
                'email' => 'gestor@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 3, // gestor
                'sede_id' => 1, // Barcelona
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Técnico',
                'email' => 'tecnico@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 4, // tecnico
                'sede_id' => 1, // Barcelona
                'estado' => 'activo'
            ],
            [
                'nombre' => 'pruebas',
                'email' => 'pruebas@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 4, // tecnico
                'sede_id' => 1, // Barcelona
                'estado' => 'activo'
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
