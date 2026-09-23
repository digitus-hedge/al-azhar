<?php

namespace App\Models\Concerns;

use App\Services\ActivityLogger;
use Illuminate\Support\Str;

/**
 * Add `use LogsActivity;` to any CMS model and every
 * create / edit / delete / restore is written to activity_logs.
 *
 * Optional properties on the model:
 *
 *   protected string $activityModule = 'News & Notices';   // name shown in the log
 *   protected string $activityLabel  = 'title';            // column used as the record name
 *   protected array  $activityIgnore = ['views'];          // extra columns to skip
 */
trait LogsActivity
{
    /** Columns that are never logged. */
    protected static array $activityAlwaysIgnore = [
        'id', 'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at',
    ];

    public static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            ActivityLogger::log(
                'created',
                $model->getActivityModule(),
                $model,
                $model->getActivityLabel(),
                $model->activityValues($model->getAttributes(), 'new'),
            );
        });

        static::updated(function ($model) {
            $changes = [];

            foreach ($model->getChanges() as $key => $new) {
                if ($model->isActivityIgnored($key)) {
                    continue;
                }

                $old = $model->getOriginal($key);
                $new = $model->getAttribute($key);

                if ($old == $new) {
                    continue;
                }

                $changes[$key] = [
                    'old' => $model->activityValue($key, $old),
                    'new' => $model->activityValue($key, $new),
                ];
            }

            // Only updated_at (or an ignored column) changed → nothing to log
            if (empty($changes)) {
                return;
            }

            ActivityLogger::log(
                'updated',
                $model->getActivityModule(),
                $model,
                $model->getActivityLabel(),
                $changes,
            );
        });

        static::deleted(function ($model) {
            $permanent = ! method_exists($model, 'isForceDeleting') || $model->isForceDeleting();

            ActivityLogger::log(
                'deleted',
                $model->getActivityModule(),
                $model,
                $model->getActivityLabel(),
                $model->activityValues($model->getAttributes(), 'old'),
                $permanent ? 'Permanently deleted' : 'Moved to trash',
            );
        });

        if (method_exists(static::class, 'restored')) {
            static::restored(function ($model) {
                ActivityLogger::log(
                    'restored',
                    $model->getActivityModule(),
                    $model,
                    $model->getActivityLabel(),
                );
            });
        }
    }

    /* ------------------------------------------------------------------ */

    public function getActivityModule(): string
    {
        return property_exists($this, 'activityModule')
            ? $this->activityModule
            : Str::of(class_basename($this))->headline()->plural()->toString();
    }

    public function getActivityLabel(): string
    {
        if (property_exists($this, 'activityLabel') && filled($this->{$this->activityLabel})) {
            return (string) $this->{$this->activityLabel};
        }

        foreach (['title', 'name', 'heading', 'student_name', 'route_name', 'subject', 'email'] as $column) {
            if (filled($this->getAttribute($column))) {
                return (string) $this->getAttribute($column);
            }
        }

        return '#' . $this->getKey();
    }

    protected function isActivityIgnored(string $key): bool
    {
        $extra = property_exists($this, 'activityIgnore') ? $this->activityIgnore : [];

        return in_array($key, array_merge(static::$activityAlwaysIgnore, $extra, $this->getHidden()), true);
    }

    /** Snapshot of all (non-ignored, non-empty) values for created / deleted rows. */
    protected function activityValues(array $attributes, string $side): array
    {
        $out = [];

        foreach (array_keys($attributes) as $key) {
            if ($this->isActivityIgnored($key)) {
                continue;
            }

            $value = $this->getAttribute($key);
            if ($value === null || $value === '' || $value === []) {
                continue;
            }

            $out[$key] = [
                'old' => $side === 'old' ? $this->activityValue($key, $value) : null,
                'new' => $side === 'new' ? $this->activityValue($key, $value) : null,
            ];
        }

        return $out;
    }

    /** Make a value safe and short for storage. */
    protected function activityValue(string $key, mixed $value): mixed
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }

        if ($value instanceof \BackedEnum) {
            return $value->value;
        }

        if (is_array($value) || is_object($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        if (is_string($value) && mb_strlen($value) > 1000) {
            return mb_substr($value, 0, 1000) . '…';
        }

        return $value;
    }
}
