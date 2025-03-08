<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaginaController extends Controller
{
    public function landing() {
        return view('landing');
    }
    
    public function inicio() {
        return view('inicio');
    }

    public function registro() {
        return view('registro');
    }

    public function voto() {
        return view('voto');
    }

    public function encuestas() {
        return view('encuestas');
    }

    public function resultados() {
        return view('resultados');
    }

    public function administracion() {
        return view('administracion');
    }

    public function usuario() {
        return view('usuario');
    }
}