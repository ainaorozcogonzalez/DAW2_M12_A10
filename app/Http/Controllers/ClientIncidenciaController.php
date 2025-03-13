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
        if (request()->wantsJson()) {
            $incidencias = Incidencia::where('cliente_id', auth()->id())->get();
            $contadores = [
                'total' => Incidencia::where('cliente_id', auth()->id())->count(),
                'pendientes' => Incidencia::where('cliente_id', auth()->id())->where('estado_id', '!=', 5)->count(),
                'cerradas' => Incidencia::where('cliente_id', auth()->id())->where('estado_id', 5)->count(),
            ];
            
            $html = view('cliente.partials.lista-incidencias', compact('incidencias'))->render();
            
            return response()->json([
                'html' => $html,
                'contadores' => $contadores
            ]);
        }

        $estados = EstadoIncidencia::all();
        $prioridades = Prioridad::all();
        $sedes = Sede::all();
        $categorias = Categoria::all();
        
        // Obtener las incidencias filtradas con las relaciones cargadas
        $incidencias = Incidencia::where('cliente_id', auth()->id())
            ->with(['estado', 'categoria', 'subcategoria', 'sede', 'prioridad']) // Cargar las relaciones
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
        try {
            $request->validate([
                'descripcion' => 'required|string|min:10',
                'categoria_id' => 'required|exists:categorias,id',
                'subcategoria_id' => 'required|exists:subcategorias,id',
            ]);

            $incidencia = Incidencia::create([
                'cliente_id' => auth()->id(),
                'descripcion' => $request->descripcion,
                'categoria_id' => $request->categoria_id,
                'subcategoria_id' => $request->subcategoria_id,
                'sede_id' => auth()->user()->sede_id,
                'estado_id' => 1, // ID del estado inicial
                'prioridad_id' => null, // Prioridad null por defecto
            ]);

            // Cargar las relaciones necesarias
            $incidencia->load(['estado', 'categoria', 'subcategoria', 'sede', 'prioridad']);

            // Obtener los contadores actualizados
            $contadores = [
                'total' => Incidencia::where('cliente_id', auth()->id())->count(),
                'pendientes' => Incidencia::where('cliente_id', auth()->id())->where('estado_id', '!=', 5)->count(),
                'cerradas' => Incidencia::where('cliente_id', auth()->id())->where('estado_id', 5)->count(),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Incidencia creada correctamente',
                'incidencia' => $incidencia,
                'contadores' => $contadores
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la incidencia: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $incidencia = Incidencia::findOrFail($id);
        return view('cliente.incidencias.show', compact('incidencia'));
    }
} 