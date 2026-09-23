<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    /** Logs only have created_at. */
    public const UPDATED_AT = null;

    public const ACTIONS = [
        'created'      => 'Created',
        'updated'      => 'Edited',
        'deleted'      => 'Deleted',
        'restored'     => 'Restored',
        'login'        => 'Logged in',
        'logout'       => 'Logged out',
        'login_failed' => 'Failed login',
    ];

    public const ACTION_ICONS = [
        'created'      => 'bi-plus-circle-fill',
        'updated'      => 'bi-pencil-fill',
        'deleted'      => 'bi-trash-fill',
        'restored'     => 'bi-arrow-counterclockwise',
        'login'        => 'bi-box-arrow-in-right',
        'logout'       => 'bi-box-arrow-right',
        'login_failed' => 'bi-shield-exclamation',
    ];

    /** Actions that are about signing in/out rather than content changes. */
    public const AUTH_ACTIONS = ['login', 'logout', 'login_failed'];

    protected $fillable = [
        'user_id', 'user_name', 'user_email', 'user_role',
        'action', 'module', 'subject_type', 'subject_id', 'subject_label',
        'properties', 'description', 'ip_address', 'user_agent', 'url', 'created_at',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];

    /* ---------- Relations ---------- */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** The record that was changed (null if it was permanently deleted). */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /* ---------- Filters ---------- */

    public function scopeFilter(Builder $q, array $f): Builder
    {
        return $q
            ->when($f['q'] ?? null, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('subject_label', 'like', "%{$search}%")
                      ->orWhere('user_name', 'like', "%{$search}%")
                      ->orWhere('user_email', 'like', "%{$search}%")
                      ->orWhere('module', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('ip_address', 'like', "%{$search}%");

                    if (ctype_digit((string) $search)) {
                        $q->orWhere('subject_id', (int) $search);
                    }
                });
            })
            ->when($f['user'] ?? null, fn ($q, $v) => $q->where('user_id', $v))
            ->when($f['module'] ?? null, fn ($q, $v) => $q->where('module', $v))
            ->when($f['action'] ?? null, fn ($q, $v) => $q->where('action', $v))
            ->when($f['from'] ?? null, fn ($q, $v) => $q->where('created_at', '>=', $v . ' 00:00:00'))
            ->when($f['to'] ?? null, fn ($q, $v) => $q->where('created_at', '<=', $v . ' 23:59:59'));
    }

    /* ---------- Accessors ---------- */

    public function getActionLabelAttribute(): string
    {
        return self::ACTIONS[$this->action] ?? ucfirst($this->action);
    }

    public function getActionIconAttribute(): string
    {
        return self::ACTION_ICONS[$this->action] ?? 'bi-dot';
    }

    public function getIsAuthActionAttribute(): bool
    {
        return in_array($this->action, self::AUTH_ACTIONS, true);
    }

    public function getChangeCountAttribute(): int
    {
        return is_array($this->properties) ? count($this->properties) : 0;
    }

    /** Human sentence: "Raju edited Facilities › Physics Lab" */
    public function getSummaryAttribute(): string
    {
        $who = $this->user_name ?: 'System';

        if ($this->action === 'login_failed') {
            return 'Failed login attempt for ' . ($this->subject_label ?: 'unknown email');
        }

        if ($this->is_auth_action) {
            return "{$who} " . strtolower($this->action_label);
        }

        $which = $this->subject_label ? " › {$this->subject_label}" : '';

        return "{$who} " . strtolower($this->action_label) . " {$this->module}{$which}";
    }
}