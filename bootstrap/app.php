<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UsuarioNormalMiddleware;
use App\Http\Middleware\LogUserActivity;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'usuario.normal' => UsuarioNormalMiddleware::class,
            'log.activity' => LogUserActivity::class,
        ]);
        
        // Aplicar el middleware de logs globalmente a las rutas web
        $middleware->appendToGroup('web', LogUserActivity::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
