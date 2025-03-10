<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\Models\User;
use App\Models\Sede;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\EstadoIncidencia;
use App\Models\Prioridad;

class IncidenciaClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra el formulario para crear una nueva incidencia.
     */
    public function create()
    {
        // Obtener clientes (usuarios con rol 'cliente')
        $clientes = User::whereHas('rol', function($query) {
            $query->where('nombre', 'cliente');
        })->get();

        // Obtener técnicos (usuarios con rol 'tecnico')
        $tecnicos = User::whereHas('rol', function($query) {
            $query->where('nombre', 'tecnico');
        })->get();

        // Obtener sedes, categorías, subcategorías, estados y prioridades
        $sedes = Sede::all();
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $estados = EstadoIncidencia::all();
        $prioridades = Prioridad::all();

        // Pasar los datos a la vista
        return view('incidencias.create', compact(
            'clientes',
            'tecnicos',
            'sedes',
            'categorias',
            'subcategorias',
            'estados',
            'prioridades'
        ));
    }

    /**
     * Almacena una nueva incidencia en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'cliente_id' => 'required|exists:users,id',
            'tecnico_id' => 'nullable|exists:users,id',
            'sede_id' => 'required|exists:sedes,id',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'descripcion' => 'required|string|min:10|max:1000',
            'estado_id' => 'required|exists:estado_incidencias,id',
            'prioridad_id' => 'required|exists:prioridades,id'
        ], [
            'cliente_id.required' => 'Seleccione un cliente',
            'sede_id.required' => 'Seleccione una sede',
            'categoria_id.required' => 'Seleccione una categoría',
            'subcategoria_id.required' => 'Seleccione una subcategoría',
            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
            'descripcion.max' => 'La descripción no puede exceder los 1000 caracteres',
            'estado_id.required' => 'Seleccione un estado',
            'prioridad_id.required' => 'Seleccione una prioridad'
        ]);

        // Crear la incidencia
        Incidencia::create([
            'cliente_id' => $request->cliente_id,
            'tecnico_id' => $request->tecnico_id,
            'sede_id' => $request->sede_id,
            'categoria_id' => $request->categoria_id,
            'subcategoria_id' => $request->subcategoria_id,
            'descripcion' => $request->descripcion,
            'estado_id' => $request->estado_id,
            'prioridad_id' => $request->prioridad_id,
            'fecha_creacion' => now(), // Asignar la fecha de creación automáticamente
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->back()->with('success', 'Incidencia creada exitosamente');
    }

    /**
     * Muestra el formulario para editar una incidencia existente.
     */
    public function edit(Incidencia $incidencia)
    {
        // Devolver los datos de la incidencia en formato JSON
        return response()->json([
            'id' => $incidencia->id,
            'cliente_id' => $incidencia->cliente_id,
            'tecnico_id' => $incidencia->tecnico_id,
            'sede_id' => $incidencia->sede_id,
            'categoria_id' => $incidencia->categoria_id,
            'subcategoria_id' => $incidencia->subcategoria_id,
            'descripcion' => $incidencia->descripcion,
            'estado_id' => $incidencia->estado_id,
            'prioridad_id' => $incidencia->prioridad_id,
        ]);
    }

    /**
     * Muestra una lista de incidencias con opciones de filtrado.
     */
    public function index(Request $request)
    {
        // Obtener listas para los selectores del formulario
        $clientes = User::where('rol_id', 2)->get(); // Suponiendo que el rol 2 es para clientes
        $tecnicos = User::where('rol_id', 4)->get(); // Suponiendo que el rol 4 es para técnicos
        $sedes = Sede::all();
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $estados = EstadoIncidencia::all();
        $prioridades = Prioridad::all();

        // Construir la consulta base
        $query = Incidencia::with(['cliente', 'tecnico', 'estado', 'prioridad']);

        // Aplicar filtros si están presentes en la solicitud
        if ($request->has('estado_id') && $request->estado_id) {
            $query->where('estado_id', $request->estado_id);
        }

        if ($request->has('prioridad_id') && $request->prioridad_id) {
            $query->where('prioridad_id', $request->prioridad_id);
        }

        if ($request->has('cliente_id') && $request->cliente_id) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->has('tecnico_id') && $request->tecnico_id) {
            $query->where('tecnico_id', $request->tecnico_id);
        }

        if ($request->has('sede_id') && $request->sede_id) {
            $query->where('sede_id', $request->sede_id);
        }

        if ($request->has('categoria_id') && $request->categoria_id) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->has('subcategoria_id') && $request->subcategoria_id) {
            $query->where('subcategoria_id', $request->subcategoria_id);
        }

        // Obtener las incidencias filtradas y paginadas
        $incidencias = $query->paginate(10); // Paginar con 10 incidencias por página

        // Pasar los datos a la vista
        return view('admin.incidencias.index', compact(
            'incidencias',
            'clientes',
            'tecnicos',
            'sedes',
            'categorias',
            'subcategorias',
            'estados',
            'prioridades'
        ));
    }

    /**
     * Elimina una incidencia existente.
     */
    public function destroy(Incidencia $incidencia)
    {
        // Verificar si la incidencia existe
        if (!$incidencia) {
            return redirect()->route('incidencias.index')->with('error', 'Incidencia no encontrada');
        }

        // Eliminar la incidencia
        $incidencia->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('incidencias.index')->with('success', 'Incidencia eliminada exitosamente');
    }
}