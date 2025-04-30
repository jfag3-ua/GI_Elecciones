<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        // Verifica que esté logueado y que sea admin
        if (Auth::check() && Auth::user()->ESADMIN == 1) {
            return $next($request);
        }

        // Si no es admin, redirige a alguna otra página
        return redirect()->route('login')->with('error', 'Acceso denegado. No eres administrador.');
    }
}
