<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Rol;
use App\Models\Sede;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $roles = Rol::all();
        $sedes = Sede::all();
        return view('admin.dashboard', compact('roles', 'sedes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'
            ],
            'rol_id' => 'required|exists:roles,id',
            'sede_id' => 'required|exists:sedes,id',
            'estado' => 'required|in:activo,inactivo'
        ], [
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'email.regex' => 'El formato del email no es válido.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula y un número.'
        ]);

        User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'sede_id' => $request->sede_id,
            'estado' => $request->estado,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Usuario creado exitosamente');
    }
} 