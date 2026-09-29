<?php

use Illuminate\Foundation\Application;
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
            'module'     => \App\Http\Middleware\EnsureModuleAccess::class,
            'admin.only' => \App\Http\Middleware\EnsureAdmin::class,
        ]);

        // Guests hitting an 'auth' route go to the admin login
        $middleware->redirectGuestsTo(fn () => route('admin.login'));

        // Logged-in users hitting a 'guest' route go to the dashboard
        $middleware->redirectUsersTo(fn () => route('admin.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();