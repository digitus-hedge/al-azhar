<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomePopup extends Model
{
    protected $fillable = ['title', 'image', 'link', 'is_active', 'starts_on', 'ends_on'];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_on' => 'date',
        'ends_on'   => 'date',
    ];

    /** The single settings row (created empty on first use). */
    public static function settings(): self
    {
        return static::firstOrCreate([], ['is_active' => false]);
    }

    /**
     * The popup to show on the home page right now, or null.
     * Needs: switched on, an image, and today within the optional dates.
     */
    public static function current(): ?self
    {
        $p = static::first();

        if (! $p || ! $p->is_active || ! $p->image) {
            return null;
        }
        if ($p->starts_on && $p->starts_on->isFuture()) {
            return null;
        }
        if ($p->ends_on && $p->ends_on->endOfDay()->isPast()) {
            return null;
        }

        return $p;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    /** Where a click goes: custom link, or the admission form. */
    public function getTargetUrlAttribute(): string
    {
        return $this->link ?: route('admission') . '#admission-form';
    }
}
