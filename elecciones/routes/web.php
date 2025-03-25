<?php

use Illuminate\Support\Facades\Route; # Addition
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\AuthController;

// Rutas sin restricción de acceso
Route::get('/', [PaginaController::class, 'landing'])->name('landing');
Route::get('/inicio', [PaginaController::class, 'inicio'])->name('inicio'); // Mostrar formulario de login
Route::post('/login', [AuthController::class, 'login'])->name('login'); // Procesar inicio de sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Cerrar sesión
Route::get('/registro', [PaginaController::class, 'registro'])->name('registro'); // Mostrar formulario de registro
//Route::post('/reader', [AuthController::class, 'datasetReader'])->name('reader');

// Rutas protegidas con middleware 'auth' (NO FUNCIONA, HAY QUE REVISAR EL INICIO DE SESIÓN)
Route::get('/voto', [PaginaController::class, 'voto'])->name('voto');
Route::get('/encuestas', [PaginaController::class, 'encuestas'])->name('encuestas');
Route::get('/resultados', [PaginaController::class, 'resultados'])->name('resultados');
Route::get('/administracion', [PaginaController::class, 'administracion'])->name('administracion');
Route::get('/usuario', [PaginaController::class, 'usuario'])->name('usuario');
