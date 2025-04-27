<?php

namespace Database\Seeders;

use App\Models\Archivo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ArchivosSeeder extends Seeder
{
    public function run(): void
    {
        $archivos = [
            // Archivos para comentarios de la incidencia 1
            [
                'comentario_id' => 1,
                'url_archivo' => 'storage/archivos/error_log_sistema.pdf',
                'tipo' => 'pdf',
                'created_at' => Carbon::now()->subDays(4)->addHours(2),
            ],
            [
                'comentario_id' => 3,
                'url_archivo' => 'storage/archivos/instructivo_acceso_temporal.pdf',
                'tipo' => 'pdf',
                'created_at' => Carbon::now()->subDays(4)->addHours(4),
            ],
            
            // Archivos para comentarios de la incidencia 2
            [
                'comentario_id' => 4,
                'url_archivo' => 'storage/archivos/foto_cable_defectuoso.jpg',
                'tipo' => 'imagen',
                'created_at' => Carbon::now()->subDays(9),
            ],
            
            // Archivos para comentarios de la incidencia 5
            [
                'comentario_id' => 8,
                'url_archivo' => 'storage/archivos/informe_actualizacion.pdf',
                'tipo' => 'pdf',
                'created_at' => Carbon::now()->subDays(6),
            ],
            
            // Archivos para comentarios de la incidencia 7
            [
                'comentario_id' => 10,
                'url_archivo' => 'storage/archivos/error_servidor_archivos.png',
                'tipo' => 'imagen',
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'comentario_id' => 12,
                'url_archivo' => 'storage/archivos/procedimiento_carga_manual.pdf',
                'tipo' => 'pdf',
                'created_at' => Carbon::now()->subDays(3)->addHours(2),
            ],
            
            // Archivos para comentarios de la incidencia 8
            [
                'comentario_id' => 13,
                'url_archivo' => 'storage/archivos/receptor_usb_danado.jpg',
                'tipo' => 'imagen',
                'created_at' => Carbon::now()->subDays(14)->addHours(3),
            ],
            
            // Archivos para comentarios de la incidencia 10
            [
                'comentario_id' => 15,
                'url_archivo' => 'storage/archivos/diagnostico_touchpad.pdf',
                'tipo' => 'pdf',
                'created_at' => Carbon::now()->subDays(1)->addHours(12),
            ],
            
            // Archivos para comentarios de la incidencia 13
            [
                'comentario_id' => 17,
                'url_archivo' => 'storage/archivos/configuracion_audio.png',
                'tipo' => 'imagen',
                'created_at' => Carbon::now()->subDays(5),
            ],
            
            // Archivos para comentarios de la incidencia 15
            [
                'comentario_id' => 20,
                'url_archivo' => 'storage/archivos/error_impresora_virtual.log',
                'tipo' => 'pdf',
                'created_at' => Carbon::now()->subHours(24),
            ],
            [
                'comentario_id' => 22,
                'url_archivo' => 'storage/archivos/plan_instalacion.pdf',
                'tipo' => 'pdf',
                'created_at' => Carbon::now()->subHours(22),
            ],
        ];

        foreach ($archivos as $archivo) {
            Archivo::create($archivo);
        }
    }
} 