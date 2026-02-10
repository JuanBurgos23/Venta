<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckSuscripcionVigente;
use App\Http\Middleware\CheckPantallaAccess;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'suscripcion.vigente' => CheckSuscripcionVigente::class,
            'pantalla' => CheckPantallaAccess::class,
        ]);

        $middleware->appendToGroup('web', CheckPantallaAccess::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
