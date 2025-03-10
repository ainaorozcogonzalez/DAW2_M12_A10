<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre'
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio',
            'nombre.max' => 'El nombre no puede exceder los 255 caracteres',
            'nombre.unique' => 'Ya existe una categoría con este nombre'
        ]);

        Categoria::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->back()->with('success', 'Categoría creada exitosamente');
    }
} 