<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostrar el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('inicio');
    }

    // Procesar el inicio de sesión
    public function login(Request $request)
    {
        $request->validate([
            'nif' => 'required|string',
            'password' => 'required|string',
        ]);

        // Buscar al usuario en la base de datos usando el NIF (primero comprobamos si es administrador)
        $admin = DB::table('administrador')->where('NIF', $request->nif)->first();

        if ($admin && $admin->CONTRASENYA === $request->password) {
            // Si el usuario existe y la contraseña es correcta, se autentica manualmente
            Auth::loginUsingId($admin->NIF);  // Usamos NIF como identificador
            session()->put('tipo_usuario', 'admin'); // Guardamos el tipo de usuario en sesión
            return redirect()->route('administracion'); // Redirige a la página que elijas
        }

        // Si no, comprobamos si es usuario
        $user = DB::table('usuario')->where('NIF', $request->nif)->first();

        if ($user && $user->CONTRASENYA === $request->password) {
            // Si el usuario existe y la contraseña es correcta, se autentica manualmente
            Auth::loginUsingId($user->NIF);  // Usamos NIF como identificador
            session()->put('tipo_usuario', 'user'); // Guardamos el tipo de usuario en sesión
            return redirect()->route('voto'); // Redirige a la página que elijas
        }

        // Si no se encuentra el usuario o la contraseña es incorrecta
        return back()->withErrors([
            'nif' => 'El NIF o la contraseña son incorrectos.',
        ]);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('inicio');
    }

}