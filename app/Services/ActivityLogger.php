<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Writes rows to activity_logs.
 *
 * Automatic logging comes from the LogsActivity trait on models.
 * For anything else, call it directly:
 *
 *   ActivityLogger::log('updated', 'Settings', null, 'Site settings', description: 'Changed logo');
 */
class ActivityLogger
{
    /** Set to false temporarily to stop logging (e.g. in seeders / imports). */
    public static bool $enabled = true;

    public static function log(
        string $action,
        string $module,
        ?Model $subject = null,
        ?string $label = null,
        ?array $changes = null,
        ?string $description = null,
        ?Authenticatable $user = null,
    ): ?ActivityLog {
        if (! static::$enabled) {
            return null;
        }

        try {
            $user ??= auth()->user();

            // Don't log artisan commands / seeders that run without a logged-in user
            if (! $user && app()->runningInConsole()) {
                return null;
            }

            $request = app()->runningInConsole() ? null : request();

            return ActivityLog::create([
                'user_id'       => $user?->getAuthIdentifier(),
                'user_name'     => $user->name ?? null,
                'user_email'    => $user->email ?? null,
                'user_role'     => $user->role ?? null,
                'action'        => $action,
                'module'        => $module,
                'subject_type'  => $subject ? $subject->getMorphClass() : null,
                'subject_id'    => $subject?->getKey(),
                'subject_label' => $label !== null ? mb_substr($label, 0, 255) : null,
                'properties'    => $changes ?: null,
                'description'   => $description !== null ? mb_substr($description, 0, 500) : null,
                'ip_address'    => $request?->ip(),
                'user_agent'    => $request ? mb_substr((string) $request->userAgent(), 0, 500) : null,
                'url'           => $request ? mb_substr($request->fullUrl(), 0, 1000) : null,
                'created_at'    => now(),
            ]);
        } catch (Throwable $e) {
            // Logging must never break the actual save.
            report($e);

            return null;
        }
    }

    /** Run a callback without writing any logs. */
    public static function withoutLogging(callable $callback): mixed
    {
        $previous = static::$enabled;
        static::$enabled = false;

        try {
            return $callback();
        } finally {
            static::$enabled = $previous;
        }
    }
}
