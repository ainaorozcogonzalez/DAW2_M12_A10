<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subcategoria;
use App\Models\Categoria;

class SubcategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255|unique:subcategorias,nombre'
        ], [
            'categoria_id.required' => 'Seleccione una categoría',
            'nombre.required' => 'El nombre de la subcategoría es obligatorio',
            'nombre.max' => 'El nombre no puede exceder los 255 caracteres',
            'nombre.unique' => 'Ya existe una subcategoría con este nombre'
        ]);

        Subcategoria::create([
            'categoria_id' => $request->categoria_id,
            'nombre' => $request->nombre
        ]);

        return redirect()->back()->with('success', 'Subcategoría creada exitosamente');
    }
} 