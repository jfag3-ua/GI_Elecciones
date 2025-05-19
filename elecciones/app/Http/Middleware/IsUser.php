<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsUser
{
    public function handle($request, Closure $next)
    {
        // Verifica que esté logueado y que NO sea admin
        if (Auth::guard('web')->check() && session('tipo_usuario') === 'user') {
            return $next($request);
        }

        return redirect()->route('login')->withErrors('error', 'Acceso denegado.');
    }
}

