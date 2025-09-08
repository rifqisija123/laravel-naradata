<?php

use App\Http\Middleware\RedirectIfNotAuthenticated;
use App\Http\Middleware\RestrictAccessByEmail;
use App\Http\Middleware\UpdateLastSeen;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => RedirectIfNotAuthenticated::class,
            'restrict.email' => RestrictAccessByEmail::class,
            'update.last.seen' => UpdateLastSeen::class,
        ]);
        
        $middleware->web(append: [
            UpdateLastSeen::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
