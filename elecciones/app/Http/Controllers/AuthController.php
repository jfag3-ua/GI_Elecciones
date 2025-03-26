<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\User; // Asumiendo tu modelo se llama User

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'NombreUsuario' => 'required|string',
            'password' => 'required|string',
        ]);

        // Intentar loguear como admin
        $admin = Admin::where('NOMBREUSUARIO', $request->NombreUsuario)->first();
        if ($admin && Hash::check($request->password,$admin->CONTRASENYA)){
            \Log::info('Entró en la validación del administrador con Nombre de Usuario: ' . $admin->NombreUsuario);
            // o si usas hashing => Hash::check($request->password, $admin->CONTRASENYA)
            Auth::guard('admin')->login($admin); // o ->loginUsingId($admin->NIF);
            \Log::info('Auth::guard("admin")->check(): ' . (Auth::guard('admin')->check() ? 'true' : 'false'));
            session()->put('tipo_usuario', 'admin');
            return redirect()->route('administracion');
        }

        // Si no es admin, intentar como user
        $user = User::where('NOMBREUSUARIO', $request->NombreUsuario)->first();
        if ($user && Hash::check($request->password,$user->CONTRASENYA)) {
            Auth::guard('web')->login($user);
            \Log::info('Redirigió a la página de administración. Auth::check: ' . (Auth::check() ? 'true' : 'false'));
            session()->put('tipo_usuario', 'user');
            return redirect()->route('voto');
        }

        // Si no coincide con ninguno
        return back()->withErrors(['NombreUsuario' => 'El nombreUsuario o la contraseña son incorrectos.']);
    }

    public function logout()
    {
        // Dependiendo de a quién quieras desloguear
        //  - Auth::guard('web')->logout();
        //  - Auth::guard('admin')->logout();
        // O ambos:
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();

        session()->forget('tipo_usuario');
        return redirect()->route('inicio');
    }
}