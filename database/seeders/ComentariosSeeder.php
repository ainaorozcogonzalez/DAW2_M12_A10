<?php

namespace Database\Seeders;

use App\Models\Comentario;
use Illuminate\Database\Seeder;

class ComentariosSeeder extends Seeder
{
    public function run(): void
    {
        $comentarios = [
            [
                'incidencia_id' => 1,
                'usuario_id' => 4,
                'mensaje' => 'He revisado la pantalla y parece que el cable está suelto',
            ],
            [
                'incidencia_id' => 1,
                'usuario_id' => 2,
                'mensaje' => 'Gracias, ¿cuándo podrías arreglarlo?',
            ],
            [
                'incidencia_id' => 2,
                'usuario_id' => 4,
                'mensaje' => 'He reinstalado el sistema operativo y ahora funciona correctamente',
            ],
        ];

        foreach ($comentarios as $comentario) {
            Comentario::create($comentario);
        }
    }
} 