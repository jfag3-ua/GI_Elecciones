<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function showRegisterForm()
    {
        return view('registro');
    }

    public function register(Request $request)
    {
        $request->validate([
            'NIF' => 'required|exists:censo,NIF|unique:usuario,NIF',
            'nombreUsuario' => 'required|string|unique:usuario,NOMBREUSUARIO',
            'password' => 'required|string|min:6',
        ]);

        DB::table('usuario')->insert([
            'NIF' => $request->NIF,
            'NOMBREUSUARIO' => $request->nombreUsuario,
            'CONTRASENYA' => Hash::make($request->password),
            'ESADMIN' => $request->esadmin ?? 0,
        ]);

        return redirect()->route('inicio')->with('success', 'Registro exitoso.');
    }
}