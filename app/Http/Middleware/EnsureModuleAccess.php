<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Route middleware: ->middleware('module:news-notices')
 *
 * Lets admins through unconditionally. For a "staff" role user, checks
 * that the module key is present in their `permissions` array (set via
 * the Login Access card on the Staff form) — otherwise aborts with 403.
 */
class EnsureModuleAccess
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('admin.login');
        }

        if (! $user->hasModule($module)) {
            abort(403, 'You do not have access to this section.');
        }

        return $next($request);
    }
}
