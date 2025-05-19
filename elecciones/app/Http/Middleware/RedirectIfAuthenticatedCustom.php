<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedCustom
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('web')->check() || Auth::guard('admin')->check()) {
            return redirect()->route('usuario'); // o a donde quieras redirigir al usuario ya logueado
        }

        return $next($request);
    }
}
