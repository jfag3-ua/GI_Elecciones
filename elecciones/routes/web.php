<?php

use Illuminate\Support\Facades\Route; # Addition
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistroController;

use App\Http\Controllers\ResultadosController;

Route::get('/resultados/{year?}', [ResultadosController::class, 'index'])->name('resultados');


// Rutas sin restricción de acceso
Route::get('/', [PaginaController::class, 'landing'])->name('landing');
Route::get('/inicio', [PaginaController::class, 'inicio'])->name('inicio'); // Mostrar formulario de login
Route::post('/login', [AuthController::class, 'login'])->name('login'); // Procesar inicio de sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Cerrar sesión

Route::get('/registro', [PaginaController::class, 'registro'])->name('registro');
Route::post('/registro', [RegistroController::class, 'register'])->name('registro2');
Route::get('/registro', [RegistroController::class, 'showRegisterForm'])->name('registro2.form');

Route::get('/login', [PaginaController::class, 'inicio'])->name('login.form');




// Rutas protegidas con middleware 'auth'
Route::get('/predicciones', [PaginaController::class, 'predicciones'])->middleware('auth')->name('predicciones');
Route::get('/voto', [PaginaController::class, 'voto'])->middleware('auth')->name('voto');
Route::get('/usuario', [PaginaController::class, 'usuario'])->middleware('auth')->name('usuario');
Route::get('/administracion', [PaginaController::class, 'administracion'])->middleware(['auth', 'isAdmin'])->name('administracion');


/*Route::get('/resultados', [PaginaController::class, 'resultados'])->name('resultados');*/