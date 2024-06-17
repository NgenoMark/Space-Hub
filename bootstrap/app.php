<?php

use App\Http\Middleware\CheckIfLocked;
use App\Http\Middleware\SuperAdmin;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Client;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(CheckIfLocked::class);
        $middleware->alias([
            'superadmin'=>SuperAdmin::class,
            'admin'=>Admin::class,
            'client'=>Client::class

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();