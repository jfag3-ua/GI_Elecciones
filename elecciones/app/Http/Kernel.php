<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Middleware global (para todas las rutas).
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        /*\Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,*/
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Middleware por grupo.
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            /*\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,*/
            \App\Http\Middleware\VerifyCsrfToken::class,
            /*\Illuminate\Routing\Middleware\SubstituteBindings::class,*/
        ],
        /*
        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],*/
    ];

    /**
     * Middleware individuales asignables por nombre.
     */
    protected $routeMiddleware = [
        'is_admin' => \App\Http\Middleware\AuthenticatedUser::class,
        'is_user' => \App\Http\Middleware\IsUser::class,
        'guest_only' => \App\Http\Middleware\RedirectIfAuthenticatedCustom::class,
        /*'auth' => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        /*'isAdmin' => \App\Http\Middleware\PruebaAdmin::class,*/
        /*'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,*/
    ];
}
