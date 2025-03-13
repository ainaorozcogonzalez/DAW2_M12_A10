<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\EstadoIncidencia;
use App\Models\Prioridad;
use App\Models\Sede;
use App\Models\Categoria;
use App\Models\Subcategoria;

class ClientIncidenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->rol->nombre !== 'cliente') {
                abort(403, 'No tienes permiso para acceder a esta página');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $estados = EstadoIncidencia::all();
        $prioridades = Prioridad::all();
        $sedes = Sede::all();
        $categorias = Categoria::all();
        
        // Obtener las incidencias filtradas
        $incidencias = Incidencia::where('cliente_id', auth()->id())
            ->when(request('estado_id'), function($query, $estado_id) {
                return $query->where('estado_id', $estado_id);
            })
            ->when(request('excluir_cerradas'), function($query) {
                $estadoCerrada = EstadoIncidencia::where('nombre', 'Cerrada')->first();
                if ($estadoCerrada) {
                    return $query->where('estado_id', '!=', $estadoCerrada->id);
                }
            })
            ->when(request('sort') == 'fecha_creacion', function($query) {
                return $query->orderBy('fecha_creacion', request('direction', 'asc'));
            })
            ->get();

        // Contadores de incidencias
        $contadorResueltas = Incidencia::where('cliente_id', auth()->id())
            ->whereHas('estado', function($query) {
                $query->where('nombre', 'Resuelta');
            })
            ->count();

        $contadorCerradas = Incidencia::where('cliente_id', auth()->id())
            ->whereHas('estado', function($query) {
                $query->where('nombre', 'Cerrada');
            })
            ->count();

        return view('cliente.dashboard', compact(
            'estados',
            'incidencias',
            'prioridades',
            'sedes',
            'categorias',
            'contadorResueltas',
            'contadorCerradas'
        ));
    }

    public function create()
    {
        $prioridades = Prioridad::all();
        return view('cliente.incidencias.create', compact('prioridades'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'descripcion' => 'required|string|min:10|max:1000',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
        ]);

        try {
            // Crear la incidencia
            $incidencia = Incidencia::create([
                'cliente_id' => auth()->id(), // ID del cliente autenticado
                'tecnico_id' => null, // Inicialmente no hay técnico asignado
                'sede_id' => auth()->user()->sede_id, // Sede del cliente
                'categoria_id' => $request->categoria_id,
                'subcategoria_id' => $request->subcategoria_id,
                'descripcion' => $request->descripcion,
                'estado_id' => EstadoIncidencia::where('nombre', 'Sin asignar')->first()->id, // Estado inicial
                'prioridad_id' => null, // Inicialmente no hay prioridad asignada
                'fecha_creacion' => now(), // Fecha actual
            ]);

            // Redirigir con mensaje de éxito
            return redirect()->route('client.dashboard')->with('success', 'Incidencia creada exitosamente');
        } catch (\Exception $e) {
            // Registrar el error y redirigir con mensaje de error
            \Log::error('Error creating incidencia: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al crear la incidencia: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $incidencia = Incidencia::findOrFail($id);
        return view('cliente.incidencias.show', compact('incidencia'));
    }
} 