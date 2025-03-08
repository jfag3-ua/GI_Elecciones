<?php

use App\Http\Controllers\PaginaController;

Route::get('/', [PaginaController::class, 'landing'])->name('landing');
Route::get('/inicio', [PaginaController::class, 'inicio'])->name('inicio');
Route::get('/registro', [PaginaController::class, 'registro'])->name('registro');
Route::get('/voto', [PaginaController::class, 'voto'])->name('voto');
Route::get('/encuestas', [PaginaController::class, 'encuestas'])->name('encuestas');
Route::get('/resultados', [PaginaController::class, 'resultados'])->name('resultados');
Route::get('/administracion', [PaginaController::class, 'administracion'])->name('administracion');
Route::get('/usuario', [PaginaController::class, 'usuario'])->name('usuario');
