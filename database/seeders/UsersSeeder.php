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
                'nombre' => 'ClienteBarcelona',
                'email' => 'clientebarcelona@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 2, // cliente
                'sede_id' => 1, // Barcelona
                'estado' => 'activo'
            ],
            [
                'nombre' => 'ClienteBerlin',
                'email' => 'clienteberlin@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 2, // cliente
                'sede_id' => 2, // Berlin
                'estado' => 'activo'
            ],
            [
                'nombre' => 'ClienteMontreal',
                'email' => 'clientemontreal@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 2, // cliente
                'sede_id' => 3, // Montreal
                'estado' => 'activo'
            ],
            [
                'nombre' => 'GestorBarcelona',
                'email' => 'gestorbarcelona@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 3, // gestor
                'sede_id' => 1, // Barcelona
                'estado' => 'activo'
            ],
            [
                'nombre' => 'GestorBerlin',
                'email' => 'gestorberlin@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 3, // gestor
                'sede_id' => 2, // Berlin
                'estado' => 'activo'
            ],
            [
                'nombre' => 'GestorMontreal',
                'email' => 'gestormontreal@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 3, // gestor
                'sede_id' => 3, // Montreal
                'estado' => 'activo'
            ],
            [
                'nombre' => 'TécnicoBarcelona',
                'email' => 'tecnicobarcelona@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 4, // tecnico
                'sede_id' => 1, // Barcelona
                'estado' => 'activo'
            ],
            [
                'nombre' => 'TécnicoBerlin',
                'email' => 'tecnicoberlin@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 4, // tecnico
                'sede_id' => 2, // Berlin
                'estado' => 'activo'
            ],
            [
                'nombre' => 'TécnicoMontreal',
                'email' => 'tecnicomontreal@incidencias.com',
                'password' => bcrypt('qweQWE123'),
                'rol_id' => 4, // tecnico
                'sede_id' => 3, // Montreal
                'estado' => 'activo'
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
