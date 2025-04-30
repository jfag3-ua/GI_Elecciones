<?php

use Illuminate\Support\Facades\Route; # Addition
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\CandidaturaController;
use App\Http\Controllers\CandidatoController;

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
Route::get('/voto', [CandidaturaController::class, 'votar'])->middleware('auth')->name('voto');
Route::post('/guardar-voto', [CandidaturaController::class, 'guardarVoto'])->middleware('auth')->name('guardar.voto');
Route::get('/predicciones', [PaginaController::class, 'predicciones'])->middleware('auth')->name('predicciones');
Route::get('/administracion', [PaginaController::class, 'administracion'])->middleware(['auth', 'isAdmin'])->name('administracion');
Route::get('/usuario', [PaginaController::class, 'usuario'])->middleware('auth')->name('usuario');

// Formulario de edición de candidatura
Route::get('/administracion/candidatura/editar/{id}', [CandidaturaController::class, 'editar'])->middleware(['auth', 'isAdmin'])->name('candidatura.editar');
// Actualizar candidatura
Route::post('/administracion/candidatura/editar/{id}', [CandidaturaController::class, 'actualizar'])->middleware(['auth', 'isAdmin'])->name('candidatura.actualizar');

// Mostrar formulario para añadir candidatura
Route::get('/administracion/candidatura/crear', [CandidaturaController::class, 'crear'])->middleware(['auth', 'isAdmin'])->name('candidatura.crear');
// Guardar candidatura
Route::post('/administracion/candidatura/crear', [CandidaturaController::class, 'guardar'])->middleware(['auth', 'isAdmin'])->name('candidatura.guardar');

// Borrar candidatura
Route::delete('administracion/candidatura/borrar/{id}', [CandidaturaController::class, 'eliminar'])->middleware(['auth', 'isAdmin'])->name('candidatura.eliminar');

// Rutas de candidato (también protegidas con isAdmin)
Route::get('/administracion/candidato/editar/{id}', [CandidatoController::class, 'editar'])->middleware(['auth', 'isAdmin'])->name('candidato.editar');
Route::post('/administracion/candidato/actualizar/{id}', [CandidatoController::class, 'actualizar'])->middleware(['auth', 'isAdmin'])->name('candidato.actualizar');

// Mostrar formulario
Route::get('/administracion/candidato/crear', [CandidatoController::class, 'crear'])->middleware(['auth', 'isAdmin'])->name('candidato.crear');
// Guardar candidato
Route::post('/administracion/candidato/guardar', [CandidatoController::class, 'guardar'])->middleware(['auth', 'isAdmin'])->name('candidato.guardar');
Route::delete('/administracion/candidato/borrar/{id}', [CandidatoController::class, 'borrar'])->middleware(['auth', 'isAdmin'])->name('candidato.borrar');

