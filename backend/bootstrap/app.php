<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Fruitcake\Cors\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->add(HandleCors::class); // CORSミドルウェアを追加  
    })
    ->withExceptions(function (Exceptions $exceptions) {Exceptions(function (Exceptions $exceptions) {
        //
    })->create();    })->create();

