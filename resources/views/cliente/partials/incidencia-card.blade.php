<div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
    <div class="p-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <span class="text-sm text-gray-500">{{ $incidencia->fecha_creacion?->format('d/m/Y H:i') ?? 'N/A' }}</span>
                <h3 class="text-lg font-semibold mt-1">{{ Str::limit($incidencia->descripcion, 40) }}</h3>
            </div>
            <div class="flex space-x-2">
                @php
                    $estadoColors = [
                        'Resuelta' => 'bg-green-100 text-green-800',
                        'Pendiente' => 'bg-yellow-100 text-yellow-800',
                        'En progreso' => 'bg-blue-100 text-blue-800',
                        'Baja' => 'bg-gray-100 text-gray-800',
                        'Urgente' => 'bg-red-100 text-red-800',
                        'default' => 'bg-gray-100 text-gray-800'
                    ];
                    $estadoColor = $estadoColors[$incidencia->estado->nombre] ?? $estadoColors['default'];
                @endphp
                <span class="px-2 py-1 text-xs rounded-full {{ $estadoColor }}">
                    {{ $incidencia->estado->nombre }}
                </span>
            </div>
        </div>
        
        <div class="text-sm text-gray-600 mb-4">
            <div class="flex items-center space-x-2 mb-2">
                <i class="fas fa-tag text-gray-400"></i>
                <span>{{ $incidencia->categoria->nombre }}</span>
            </div>
            <div class="flex items-center space-x-2">
                <i class="fas fa-map-marker-alt text-gray-400"></i>
                <span>{{ $incidencia->sede->nombre }}</span>
            </div>
        </div>

        <div class="flex justify-between items-center">
            <div class="flex space-x-2">
                @php
                    $prioridadColors = [
                        'Alta' => 'text-red-500',
                        'Media' => 'text-yellow-500',
                        'Baja' => 'text-gray-500',
                        'default' => 'text-gray-500'
                    ];
                    $prioridadColor = $prioridadColors[$incidencia->prioridad->nombre] ?? $prioridadColors['default'];
                @endphp
                <span class="{{ $prioridadColor }}">
                    <i class="fas fa-exclamation-circle"></i>
                </span>
                <span class="text-sm {{ $prioridadColor }}">
                    {{ $incidencia->prioridad->nombre }}
                </span>
            </div>
            <div class="flex space-x-2">
                <a href="#" class="text-green-500 hover:text-green-700 transition duration-200" title="Chat">
                    <i class="fas fa-comments"></i>
                </a>
                <button onclick="confirmarCierre({{ $incidencia->id }})" class="text-red-500 hover:text-red-700 transition duration-200" title="Cerrar incidencia" {{ $incidencia->estado_id == 5 ? 'disabled' : '' }}>
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
        </div>
    </div>
    @if($incidencia->fecha_resolucion)
        <div class="bg-green-50 px-6 py-3 border-t">
            <div class="text-sm text-green-700 flex items-center space-x-2">
                <i class="fas fa-check-circle"></i>
                <span>Resuelta el {{ $incidencia->fecha_resolucion->format('d/m/Y') }}</span>
            </div>
        </div>
    @endif
</div>
