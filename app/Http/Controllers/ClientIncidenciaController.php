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
        $subcategorias = Subcategoria::all();
        
        // Obtener las incidencias filtradas
        $incidencias = $this->getFilteredIncidencias();

        // Contadores de incidencias
        $contadorTotal = Incidencia::where('cliente_id', auth()->id())->count();
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
            
        $contadorPendientes = $contadorTotal - $contadorCerradas;

        if (request()->ajax()) {
            return view('cliente.partials.incidencia-list', compact('incidencias'));
        }

        return view('cliente.dashboard', compact(
            'estados',
            'incidencias',
            'prioridades',
            'sedes',
            'categorias',
            'subcategorias',
            'contadorTotal',
            'contadorResueltas',
            'contadorCerradas',
            'contadorPendientes'
        ));
    }

    private function getFilteredIncidencias()
    {
        $query = Incidencia::where('cliente_id', auth()->id());

        // Filtro por estado
        if (request('estado_id')) {
            $query->where('estado_id', request('estado_id'));
        }

        // Filtro por prioridad
        if (request('prioridad_id')) {
            $query->where('prioridad_id', request('prioridad_id'));
        }

        // Excluir incidencias cerradas
        if (request('excluir_cerradas')) {
            $query->whereHas('estado', function($q) {
                $q->where('nombre', '!=', 'Cerrada');
            });
        }

        // Ordenar por fecha de creación
        if (request('sort_by')) {
            switch (request('sort_by')) {
                case 'fecha_creacion_asc':
                    $query->orderBy('fecha_creacion', 'asc');
                    break;
                case 'fecha_creacion_desc':
                    $query->orderBy('fecha_creacion', 'desc');
                    break;
            }
        } else {
            $query->latest('fecha_creacion');
        }

        return $query->get();
    }

    public function create()
    {
        $prioridades = Prioridad::all();
        return view('cliente.incidencias.create', compact('prioridades'));
    }

    public function store(Request $request)
    {
        \Log::info('Starting store method');
        \Log::info('Request data:', $request->all());
        \Log::info('Authenticated user:', auth()->user() ? auth()->user()->toArray() : 'No user');

        // Validación de campos
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'descripcion' => 'required|string|min:10|max:1000'
        ], [
            'categoria_id.required' => 'Seleccione una categoría',
            'subcategoria_id.required' => 'Seleccione una subcategoría',
            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
            'descripcion.max' => 'La descripción no puede exceder los 1000 caracteres'
        ]);

        try {
            \Log::info('Creating incidencia');
            $estadoSinAsignar = EstadoIncidencia::where('nombre', 'Sin asignar')->first();
            if (!$estadoSinAsignar) {
                \Log::error('Estado "Sin asignar" no encontrado');
                throw new \Exception('Estado "Sin asignar" no encontrado');
            }
            \Log::info('Estado Sin asignar:', $estadoSinAsignar->toArray());

            $incidencia = Incidencia::create([
                'cliente_id' => auth()->id(),
                'tecnico_id' => null,
                'sede_id' => auth()->user()->sede_id,
                'categoria_id' => $request->categoria_id,
                'subcategoria_id' => $request->subcategoria_id,
                'descripcion' => $request->descripcion,
                'estado_id' => $estadoSinAsignar->id,
                'prioridad_id' => null,
                'fecha_creacion' => now(),
            ]);

            \Log::info('Incidencia created:', $incidencia->toArray());

            return redirect()->route('client.dashboard')->with('success', 'Incidencia creada exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error creating incidencia: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al crear la incidencia: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $incidencia = Incidencia::findOrFail($id);
        return view('cliente.incidencias.show', compact('incidencia'));
    }
} 