<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\CategoriaController;

// Redirigir la ruta raíz al login
Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard routes
    Route::get('/admin/dashboard', [UserController::class, 'create'])->name('admin.dashboard');

    // User routes
    Route::prefix('users')->group(function () {
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
    });

    // Incidencia routes
    Route::prefix('incidencias')->group(function () {
        Route::get('/create', [IncidenciaController::class, 'create'])->name('incidencias.create');
        Route::post('/', [IncidenciaController::class, 'store'])->name('incidencias.store');
    });

    // Report routes
    Route::prefix('reportes')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('reportes.index');
    });

    // Configuration routes
    Route::prefix('configuracion')->group(function () {
        Route::get('/', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    });

    Route::get('/client/dashboard', function () {
        return view('client.dashboard');
    })->name('client.dashboard');

    Route::get('/manager/dashboard', function () {
        return view('manager.dashboard');
    })->name('manager.dashboard');

    Route::get('/tech/dashboard', function () {
        return view('tech.dashboard');
    })->name('tech.dashboard');

    // Categoría routes
    Route::prefix('categorias')->group(function () {
        Route::post('/', [CategoriaController::class, 'store'])->name('categorias.store');
    });
});
