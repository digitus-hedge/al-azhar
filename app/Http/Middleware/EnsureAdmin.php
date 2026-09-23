<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Route middleware: ->middleware('admin.only')
 *
 * For sections a "staff" role user should never reach regardless of their
 * permission checkboxes — Staff management, Departments/Classes, Home
 * (banner/stats), About/Principal's Desk — i.e. "Cannot manage users or
 * site settings".
 */
class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('admin.login');
        }

        if (! $user->isAdmin()) {
            abort(403, 'This section is restricted to administrators.');
        }

        return $next($request);
    }
}
