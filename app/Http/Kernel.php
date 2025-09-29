<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global HTTP middleware executados em toda requisição.
     */
    protected $middleware = [
        // Ordem clássica do Laravel para apps web
        \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
    ];

    /**
     * Grupos de middleware.
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // Se usar autenticação baseada em sessão, isso mantém a sessão auth sincronizada:
            \Illuminate\Session\Middleware\AuthenticateSession::class,

            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            // Inertia (projeto Breeze/Inertia geralmente usa esse middleware)
            \App\Http\Middleware\HandleInertiaRequests::class,

        ],

        'api' => [
            // Rate limiting padrão da API
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Aliases (nome => classe) para usar nas rotas.
     * No Laravel 11/12 isso substitui o antigo $routeMiddleware.
     */
    protected $middlewareAliases = [
        // Auth & sessão
        'auth.basic'      => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session'    => \Illuminate\Session\Middleware\AuthenticateSession::class,

        // Segurança & utilidades
        'cache.headers'   => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can'             => \Illuminate\Auth\Middleware\Authorize::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'throttle'        => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified'        => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Seus middlewares de acesso ao admin
        // (certifique-se que os arquivos existem em App\Http\Middleware)
        'admin.only'      => \App\Http\Middleware\AdminOnly::class,
        'superadmin.only' => \App\Http\Middleware\SuperAdminOnly::class,   // apenas superadmin
    ];
}
