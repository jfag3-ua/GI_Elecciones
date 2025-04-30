<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('usuario')) {
            return redirect()->route('login.form'); // Redirige a la ruta GET /login
        }

        return $next($request);
    }
}
