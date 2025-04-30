<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Suponiendo que el usuario tiene una propiedad 'is_admin'
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        return redirect()->route('inicio')->with('error', 'Acceso restringido a administradores.');
    }
}
