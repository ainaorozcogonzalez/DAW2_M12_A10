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
        $clientes = User::whereHas('rol', function($query) {
            $query->where('nombre', 'cliente');
        })->get();

        $tecnicos = User::whereHas('rol', function($query) {
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

        return redirect()->back()->with('success', 'Incidencia creada exitosamente');
    }
} 