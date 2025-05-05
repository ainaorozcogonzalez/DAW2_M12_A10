<?php

namespace Database\Seeders;

use App\Models\Comentario;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ComentariosSeeder extends Seeder
{
    public function run(): void
    {
        $comentarios = [
            // Comentarios para la incidencia 1
            [
                'incidencia_id' => 1,
                'usuario_id' => 8, // TécnicoBarcelona
                'mensaje' => 'He revisado el problema y parece ser un conflicto con la última actualización del sistema. Estoy trabajando en solucionarlo.',
                'created_at' => Carbon::now()->subDays(4)->addHours(2),
            ],
            [
                'incidencia_id' => 1,
                'usuario_id' => 2, // ClienteBarcelona
                'mensaje' => 'Gracias por la información. ¿Tienes alguna idea de cuándo podría estar solucionado? Necesito acceder a varios documentos urgentes.',
                'created_at' => Carbon::now()->subDays(4)->addHours(3),
            ],
            [
                'incidencia_id' => 1,
                'usuario_id' => 8, // TécnicoBarcelona
                'mensaje' => 'Estoy aplicando un parche provisional que debería resolver el problema momentáneamente. Te avisaré cuando puedas intentar acceder de nuevo.',
                'created_at' => Carbon::now()->subDays(4)->addHours(4),
            ],
            
            // Comentarios para la incidencia 2
            [
                'incidencia_id' => 2,
                'usuario_id' => 8, // TécnicoBarcelona
                'mensaje' => 'He revisado el monitor y he detectado que el cable DisplayPort estaba defectuoso. Lo he reemplazado y ahora funciona correctamente.',
                'created_at' => Carbon::now()->subDays(9),
            ],
            [
                'incidencia_id' => 2,
                'usuario_id' => 2, // ClienteBarcelona
                'mensaje' => 'Perfecto, muchas gracias por la rápida solución.',
                'created_at' => Carbon::now()->subDays(9)->addHours(1),
            ],
            
            // Comentarios para la incidencia 4
            [
                'incidencia_id' => 4,
                'usuario_id' => 9, // TécnicoBerlin
                'mensaje' => 'Verificaré el teclado mañana a primera hora. Por favor, deja el equipo encendido al finalizar tu jornada.',
                'created_at' => Carbon::now()->subDays(2),
            ],
            [
                'incidencia_id' => 4,
                'usuario_id' => 3, // ClienteBerlin
                'mensaje' => 'De acuerdo, dejaré el equipo encendido. Gracias por la atención.',
                'created_at' => Carbon::now()->subDays(2)->addHours(1),
            ],
            
            // Comentarios para la incidencia 5
            [
                'incidencia_id' => 5,
                'usuario_id' => 9, // TécnicoBerlin
                'mensaje' => 'He actualizado la aplicación de videoconferencia a la última versión y he comprobado que el problema está resuelto. Por favor, confirma que todo funciona correctamente.',
                'created_at' => Carbon::now()->subDays(6),
            ],
            [
                'incidencia_id' => 3, // ClienteBerlin
                'usuario_id' => 3,
                'mensaje' => 'He probado la aplicación y ahora funciona perfectamente. Gracias por la solución.',
                'created_at' => Carbon::now()->subDays(6)->addHours(2),
            ],
            
            // Comentarios para la incidencia 7
            [
                'incidencia_id' => 7,
                'usuario_id' => 10, // TécnicoMontreal
                'mensaje' => 'Estoy analizando el problema con el departamento de desarrollo. Parece ser un error en la configuración del servidor de archivos.',
                'created_at' => Carbon::now()->subDays(3),
            ],
            [
                'incidencia_id' => 7,
                'usuario_id' => 4, // ClienteMontreal
                'mensaje' => '¿Hay alguna manera de seguir trabajando mientras se soluciona el problema? Tenemos varios proyectos con plazos muy ajustados.',
                'created_at' => Carbon::now()->subDays(3)->addHours(1),
            ],
            [
                'incidencia_id' => 7,
                'usuario_id' => 10, // TécnicoMontreal
                'mensaje' => 'Puedes enviarme los archivos por correo electrónico y yo los subiré manualmente. No es lo ideal, pero te permitirá continuar trabajando.',
                'created_at' => Carbon::now()->subDays(3)->addHours(2),
            ],
            
            // Comentarios para la incidencia 8
            [
                'incidencia_id' => 8,
                'usuario_id' => 10, // TécnicoMontreal
                'mensaje' => 'He comprobado el ratón y el receptor USB estaba dañado. He instalado uno nuevo y ahora funciona sin problemas.',
                'created_at' => Carbon::now()->subDays(14)->addHours(3),
            ],
            [
                'incidencia_id' => 8,
                'usuario_id' => 4, // ClienteMontreal
                'mensaje' => 'Excelente, muchas gracias por la solución.',
                'created_at' => Carbon::now()->subDays(14)->addHours(4),
            ],
            
            // Comentarios para la incidencia 10
            [
                'incidencia_id' => 10,
                'usuario_id' => 8, // TécnicoBarcelona
                'mensaje' => 'Estoy realizando un diagnóstico completo del touchpad. ¿Has intentado conectar un ratón externo mientras tanto?',
                'created_at' => Carbon::now()->subDays(1)->addHours(12),
            ],
            [
                'incidencia_id' => 10,
                'usuario_id' => 2, // ClienteBarcelona
                'mensaje' => 'Sí, estoy usando un ratón USB por ahora, pero necesito poder usar el portátil en reuniones sin accesorios adicionales.',
                'created_at' => Carbon::now()->subDays(1)->addHours(13),
            ],
            
            // Comentarios para la incidencia 13
            [
                'incidencia_id' => 13,
                'usuario_id' => 8, // TécnicoBarcelona
                'mensaje' => 'He instalado los drivers actualizados para tu micrófono y he realizado ajustes en la configuración de audio. Por favor, realiza una prueba y confirma si ha mejorado.',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'incidencia_id' => 13,
                'usuario_id' => 2, // ClienteBarcelona
                'mensaje' => 'Acabo de realizar una videoconferencia de prueba y la calidad del audio ha mejorado significativamente. Muchas gracias.',
                'created_at' => Carbon::now()->subDays(5)->addHours(2),
            ],
            [
                'incidencia_id' => 13,
                'usuario_id' => 8, // TécnicoBarcelona
                'mensaje' => 'Perfecto. Voy a cerrar la incidencia. Si vuelves a tener problemas, no dudes en contactarnos de nuevo.',
                'created_at' => Carbon::now()->subDays(4),
            ],
            
            // Comentarios para la incidencia 15
            [
                'incidencia_id' => 15,
                'usuario_id' => 10, // TécnicoMontreal
                'mensaje' => 'He identificado el problema. La aplicación está intentando acceder a una impresora virtual que no está correctamente configurada. Estoy trabajando en la solución.',
                'created_at' => Carbon::now()->subHours(24),
            ],
            [
                'incidencia_id' => 15,
                'usuario_id' => 4, // ClienteMontreal
                'mensaje' => 'Entiendo. ¿Tienes alguna estimación de cuándo podría estar resuelto? Necesitamos generar varios informes para el cierre mensual.',
                'created_at' => Carbon::now()->subHours(23),
            ],
            [
                'incidencia_id' => 15,
                'usuario_id' => 10, // TécnicoMontreal
                'mensaje' => 'Estoy instalando los componentes necesarios y realizando pruebas. Espero tenerlo resuelto para mañana a primera hora.',
                'created_at' => Carbon::now()->subHours(22),
            ],
        ];

        foreach ($comentarios as $comentario) {
            Comentario::create($comentario);
        }
    }
} 