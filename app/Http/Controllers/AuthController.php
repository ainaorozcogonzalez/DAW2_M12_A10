<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirección basada en el rol
            $user = Auth::user();
            
            // Accedemos al nombre del rol a través de la relación
            switch ($user->rol->nombre) {
                case 'administrador':
                    return redirect()->route('admin.dashboard');
                case 'cliente':
                    return redirect()->route('client.dashboard');
                case 'gestor':
                    return redirect()->route('manager.dashboard');
                case 'tecnico':
                    return redirect()->route('tech.dashboard');
                default:
                    Auth::logout();
                    return back()->withErrors([
                        'general' => 'Rol de usuario no válido.',
                    ])->withInput($request->only('email'));
            }
        }

        return back()->withErrors([
            'general' => 'Correo o contraseña incorrectos.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
} 