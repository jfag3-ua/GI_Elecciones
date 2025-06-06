<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check() || Auth::guard('admin')->check()) {
            return $next($request);
        }

        return redirect()->route('login.form')->with('error', 'Debes iniciar sesión para acceder.');
    }
}
