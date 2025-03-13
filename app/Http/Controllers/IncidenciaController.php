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

class IncidenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $clientes = User::whereHas('rol', function ($query) {
            $query->where('nombre', 'cliente');
        })->get();

        $tecnicos = User::whereHas('rol', function ($query) {
            $query->where('nombre', 'tecnico');
        })->get();

        $sedes = Sede::all();
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $estados = EstadoIncidencia::all();
        $prioridades = Prioridad::all();

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

    public function store(Request $request)
    {
        // $request->validate([
        //     'cliente_id' => 'required|exists:users,id',
        //     'tecnico_id' => 'nullable|exists:users,id',
        //     'sede_id' => 'required|exists:sedes,id',
        //     'categoria_id' => 'required|exists:categorias,id',
        //     'subcategoria_id' => 'required|exists:subcategorias,id',
        //     'descripcion' => 'required|string|min:10|max:1000',
        //     'estado_id' => 'required|exists:estado_incidencias,id',
        //     'prioridad_id' => 'required|exists:prioridades,id'
        // ], [
        //     'cliente_id.required' => 'Seleccione un cliente',
        //     'sede_id.required' => 'Seleccione una sede',
        //     'categoria_id.required' => 'Seleccione una categoría',
        //     'subcategoria_id.required' => 'Seleccione una subcategoría',
        //     'descripcion.required' => 'La descripción es obligatoria',
        //     'descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
        //     'descripcion.max' => 'La descripción no puede exceder los 1000 caracteres',
        //     'estado_id.required' => 'Seleccione un estado',
        //     'prioridad_id.required' => 'Seleccione una prioridad'
        // ]);


        try {
            Incidencia::create([
                'cliente_id' => $request->cliente_id,
                'tecnico_id' => $request->tecnico_id,
                'sede_id' => $request->sede_id,
                'categoria_id' => $request->categoria_id,
                'subcategoria_id' => $request->subcategoria_id,
                'descripcion' => $request->descripcion,
                'estado_id' => $request->estado_id,
                'prioridad_id' => $request->prioridad_id
            ]);

            echo "Creado Incidencia: " . $request->descripcion . " creada correctamente";
            die();
        } catch (\PDOException $e) {
            echo "Error No se pudo crear la incidencia: " . $request->descripcion;
            die();
        }
        echo "Invalido Intentelo mas tarde";
        // return redirect()->back()->with('success', 'Incidencia creada exitosamente');
    }

    public function edit(Incidencia $incidencia)
    {
        return response()->json([
            'id' => $incidencia->id,
            'titulo' => $incidencia->titulo,
            'descripcion' => $incidencia->descripcion,
            'estado' => $incidencia->estado,
            'prioridad' => $incidencia->prioridad,
            'cliente_id' => $incidencia->cliente_id,
            'tecnico_id' => $incidencia->tecnico_id,
        ]);
    }

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

        // Obtener las incidencias filtradas
        $incidencias = $query->get();

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

    public function destroy(Incidencia $incidencia)
    {
        $incidencia->delete();
        return redirect()->route('incidencias.index')->with('success', 'Incidencia eliminada exitosamente');
    }
}
