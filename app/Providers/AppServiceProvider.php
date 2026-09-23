<?php

namespace App\Providers;

use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // ---- Activity log: login / logout / failed login ----

        Event::listen(Login::class, function (Login $event) {
            ActivityLogger::log(
                'login',
                'Authentication',
                $event->user,
                $event->user->name ?? null,
                user: $event->user,
            );
        });

        Event::listen(Logout::class, function (Logout $event) {
            if ($event->user) {
                ActivityLogger::log(
                    'logout',
                    'Authentication',
                    $event->user,
                    $event->user->name ?? null,
                    user: $event->user,
                );
            }
        });

        Event::listen(Failed::class, function (Failed $event) {
            ActivityLogger::log(
                'login_failed',
                'Authentication',
                null,
                $event->credentials['email'] ?? 'unknown',
                description: $event->user ? 'Wrong password' : 'Unknown email',
                user: $event->user,
            );
        });
    }
}