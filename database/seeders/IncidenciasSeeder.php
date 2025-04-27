<?php

namespace Database\Seeders;

use App\Models\Incidencia;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class IncidenciasSeeder extends Seeder
{
    public function run(): void
    {
        $incidencias = [
            // Incidencias en Barcelona
            [
                'cliente_id' => 2, // ClienteBarcelona
                'tecnico_id' => 8, // TécnicoBarcelona
                'sede_id' => 1, // Barcelona
                'categoria_id' => 1, // Software
                'subcategoria_id' => 1, // Aplicació gestió administrativa
                'descripcion' => 'No puedo acceder al sistema de gestión de documentos. Me muestra un error al iniciar sesión indicando "credenciales inválidas" aunque estoy seguro de que son correctas.',
                'estado_id' => 3, // En trabajo
                'prioridad_id' => 1, // Alta
                'fecha_creacion' => Carbon::now()->subDays(5),
            ],
            [
                'cliente_id' => 2, // ClienteBarcelona
                'tecnico_id' => 8, // TécnicoBarcelona
                'sede_id' => 1, // Barcelona
                'categoria_id' => 2, // Hardware
                'subcategoria_id' => 7, // Monitor no s'encén
                'descripcion' => 'El monitor de mi estación de trabajo no enciende. He comprobado los cables y la conexión eléctrica y todo parece estar correcto. La torre del ordenador funciona normalmente.',
                'estado_id' => 4, // Resuelta
                'prioridad_id' => 2, // Media
                'fecha_creacion' => Carbon::now()->subDays(10),
                'fecha_resolucion' => Carbon::now()->subDays(8),
            ],
            [
                'cliente_id' => 2, // ClienteBarcelona
                'tecnico_id' => null,
                'sede_id' => 1, // Barcelona
                'categoria_id' => 1, // Software
                'subcategoria_id' => 2, // Accés remot
                'descripcion' => 'No puedo conectarme mediante VPN desde mi domicilio. He seguido todos los pasos del manual pero no logro establecer conexión.',
                'estado_id' => 1, // Sin asignar
                'prioridad_id' => 3, // Baja
                'fecha_creacion' => Carbon::now()->subHours(12),
            ],
            
            // Incidencias en Berlín
            [
                'cliente_id' => 3, // ClienteBerlin
                'tecnico_id' => 9, // TécnicoBerlin
                'sede_id' => 2, // Berlin
                'categoria_id' => 2, // Hardware
                'subcategoria_id' => 5, // Problema con el teclado
                'descripcion' => 'Varios botones del teclado no funcionan correctamente (A, S, D, F). He probado a conectarlo en otro equipo y ocurre lo mismo.',
                'estado_id' => 2, // Asignada
                'prioridad_id' => 3, // Baja
                'fecha_creacion' => Carbon::now()->subDays(3),
            ],
            [
                'cliente_id' => 3, // ClienteBerlin
                'tecnico_id' => 9, // TécnicoBerlin
                'sede_id' => 2, // Berlin
                'categoria_id' => 1, // Software
                'subcategoria_id' => 3, // Aplicació de videoconferència
                'descripcion' => 'La aplicación de videoconferencia no permite compartir pantalla. Al intentarlo se queda bloqueada y hay que reiniciar la aplicación.',
                'estado_id' => 4, // Resuelta
                'prioridad_id' => 1, // Alta
                'fecha_creacion' => Carbon::now()->subDays(7),
                'fecha_resolucion' => Carbon::now()->subDays(5),
            ],
            [
                'cliente_id' => 3, // ClienteBerlin
                'tecnico_id' => 9, // TécnicoBerlin
                'sede_id' => 2, // Berlin
                'categoria_id' => 2, // Hardware
                'subcategoria_id' => 8, // Imagen de proyector defectuosa
                'descripcion' => 'El proyector de la sala de reuniones principal muestra la imagen con un tinte verdoso. Hemos intentado calibrarlo pero sigue igual.',
                'estado_id' => 5, // Cerrada
                'prioridad_id' => 2, // Media
                'fecha_creacion' => Carbon::now()->subMonths(1),
                'fecha_resolucion' => Carbon::now()->subDays(25),
            ],
            
            // Incidencias en Montreal
            [
                'cliente_id' => 4, // ClienteMontreal
                'tecnico_id' => 10, // TécnicoMontreal
                'sede_id' => 3, // Montreal
                'categoria_id' => 1, // Software
                'subcategoria_id' => 1, // Aplicació gestió administrativa
                'descripcion' => 'La aplicación de gestión de proyectos no permite adjuntar archivos. Al intentarlo muestra "Error 404 - Ruta no encontrada".',
                'estado_id' => 3, // En trabajo
                'prioridad_id' => 2, // Media
                'fecha_creacion' => Carbon::now()->subDays(4),
            ],
            [
                'cliente_id' => 4, // ClienteMontreal
                'tecnico_id' => 10, // TécnicoMontreal
                'sede_id' => 3, // Montreal
                'categoria_id' => 2, // Hardware
                'subcategoria_id' => 6, // El ratón no funciona
                'descripcion' => 'El ratón inalámbrico deja de responder intermitentemente. He cambiado las pilas pero sigue ocurriendo.',
                'estado_id' => 4, // Resuelta
                'prioridad_id' => 3, // Baja
                'fecha_creacion' => Carbon::now()->subDays(15),
                'fecha_resolucion' => Carbon::now()->subDays(14),
            ],
            [
                'cliente_id' => 4, // ClienteMontreal
                'tecnico_id' => null,
                'sede_id' => 3, // Montreal
                'categoria_id' => 1, // Software
                'subcategoria_id' => 4, // Imagen de proyector defectuosa
                'descripcion' => 'Necesitamos instalar una nueva aplicación para el departamento de diseño. Requiere permisos de administrador.',
                'estado_id' => 1, // Sin asignar
                'prioridad_id' => 1, // Alta
                'fecha_creacion' => Carbon::now()->subHours(2),
            ],
            
            // Más incidencias variadas
            [
                'cliente_id' => 2, // ClienteBarcelona
                'tecnico_id' => 8, // TécnicoBarcelona
                'sede_id' => 1, // Barcelona
                'categoria_id' => 2, // Hardware
                'subcategoria_id' => 6, // El ratón no funciona
                'descripcion' => 'El touchpad del portátil corporativo ha dejado de funcionar completamente. He reiniciado el equipo pero sigue sin responder.',
                'estado_id' => 3, // En trabajo
                'prioridad_id' => 2, // Media
                'fecha_creacion' => Carbon::now()->subDays(2),
            ],
            [
                'cliente_id' => 3, // ClienteBerlin
                'tecnico_id' => 9, // TécnicoBerlin
                'sede_id' => 2, // Berlin
                'categoria_id' => 1, // Software
                'subcategoria_id' => 2, // Accés remot
                'descripcion' => 'No puedo acceder a las carpetas compartidas de la red estando en la oficina. Otros compañeros pueden acceder sin problemas.',
                'estado_id' => 2, // Asignada
                'prioridad_id' => 2, // Media
                'fecha_creacion' => Carbon::now()->subDays(1),
            ],
            [
                'cliente_id' => 4, // ClienteMontreal
                'tecnico_id' => 10, // TécnicoMontreal
                'sede_id' => 3, // Montreal
                'categoria_id' => 2, // Hardware
                'subcategoria_id' => 5, // Problema con el teclado
                'descripcion' => 'Necesito un teclado con distribución francesa AZERTY. Actualmente tengo uno con distribución española.',
                'estado_id' => 5, // Cerrada
                'prioridad_id' => 3, // Baja
                'fecha_creacion' => Carbon::now()->subDays(20),
                'fecha_resolucion' => Carbon::now()->subDays(18),
            ],
            [
                'cliente_id' => 2, // ClienteBarcelona
                'tecnico_id' => 8, // TécnicoBarcelona
                'sede_id' => 1, // Barcelona
                'categoria_id' => 1, // Software
                'subcategoria_id' => 3, // Aplicació de videoconferència
                'descripcion' => 'La calidad del audio en las videoconferencias es muy baja. Los participantes se quejan de que no se me escucha bien.',
                'estado_id' => 4, // Resuelta
                'prioridad_id' => 1, // Alta
                'fecha_creacion' => Carbon::now()->subDays(6),
                'fecha_resolucion' => Carbon::now()->subDays(4),
            ],
            [
                'cliente_id' => 3, // ClienteBerlin
                'tecnico_id' => null,
                'sede_id' => 2, // Berlin
                'categoria_id' => 2, // Hardware
                'subcategoria_id' => 7, // Monitor no s'encén
                'descripcion' => 'Uno de los monitores duales que utilizo parpadea constantemente. A veces se estabiliza pero luego vuelve a parpadear.',
                'estado_id' => 1, // Sin asignar
                'prioridad_id' => 2, // Media
                'fecha_creacion' => Carbon::now()->subHours(6),
            ],
            [
                'cliente_id' => 4, // ClienteMontreal
                'tecnico_id' => 10, // TécnicoMontreal
                'sede_id' => 3, // Montreal
                'categoria_id' => 1, // Software
                'subcategoria_id' => 1, // Aplicació gestió administrativa
                'descripcion' => 'No puedo generar informes PDF desde la aplicación de gestión financiera. El proceso comienza pero nunca termina.',
                'estado_id' => 3, // En trabajo
                'prioridad_id' => 1, // Alta
                'fecha_creacion' => Carbon::now()->subHours(36),
            ],
        ];

        foreach ($incidencias as $incidencia) {
            Incidencia::create($incidencia);
        }
    }
} 