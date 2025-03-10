<?php

namespace Database\Seeders;

use App\Models\Archivo;
use Illuminate\Database\Seeder;

class ArchivosSeeder extends Seeder
{
    public function run(): void
    {
        $archivos = [
            [
                'comentario_id' => 1,
                'url_archivo' => 'http://localhost:8000/storage/archivos/pantalla.jpg',
                'tipo' => 'imagen',
            ],
            [
                'comentario_id' => 2,
                'url_archivo' => 'http://localhost:8000/storage/archivos/pantalla2.jpg',
                'tipo' => 'pdf',
            ],
        ];

        foreach ($archivos as $archivo) {
            Archivo::create($archivo);
        }
    }
} 