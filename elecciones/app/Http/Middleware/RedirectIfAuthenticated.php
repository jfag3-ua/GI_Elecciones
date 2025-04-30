<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            // Redirigir a la página principal si ya está logueado
            return redirect()->route('usuario'); // O cualquier otra ruta
        }

        return $next($request);
    }
}
