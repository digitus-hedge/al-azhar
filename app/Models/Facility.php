<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Facility extends Model
{
    use SoftDeletes;

    /** Category key => label */
    public const CATEGORIES = [
        'lab'       => 'Labs',
        'library'   => 'Library',
        'sports'    => 'Sports',
        'transport' => 'Transport',
        'other'     => 'Other',
    ];

    /** Category key => Bootstrap icon */
    public const CATEGORY_ICONS = [
        'lab'       => 'bi-cpu',
        'library'   => 'bi-book',
        'sports'    => 'bi-trophy',
        'transport' => 'bi-bus-front',
        'other'     => 'bi-grid',
    ];

    protected $fillable = [
        'category', 'title', 'slug', 'short_description', 'description',
        'image', 'gallery', 'icon', 'features', 'capacity', 'location',
        'timings', 'contact_person', 'contact_phone',
        'meta_title', 'meta_description',
        'show_on_home', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'gallery'      => 'array',
        'features'     => 'array',
        'capacity'     => 'integer',
        'show_on_home' => 'boolean',
        'is_active'    => 'boolean',
        'sort_order'   => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Facility $facility) {
            if (blank($facility->slug) || $facility->isDirty('title')) {
                $facility->slug = static::uniqueSlug($facility->title, $facility->id);
            }
        });
    }

    /** "Science Lab" → science-lab, science-lab-2, ... (checks soft-deleted rows too) */
    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'facility';
        $slug = $base;
        $i    = 2;

        while (static::withTrashed()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    /* ---------- Scopes ---------- */

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true)->orderBy('sort_order')->orderBy('title');
    }

    public function scopeCategory(Builder $q, string $category): Builder
    {
        return $q->where('category', $category);
    }

    /* ---------- Accessors ---------- */

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst((string) $this->category);
    }

    public function getCategoryIconAttribute(): string
    {
        return $this->icon ?: (self::CATEGORY_ICONS[$this->category] ?? 'bi-grid');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    /** @return array<int, string> public URLs of gallery photos */
    public function getGalleryUrlsAttribute(): array
    {
        return collect($this->gallery ?? [])
            ->map(fn ($path) => Storage::url($path))
            ->all();
    }

    public function getPhotoCountAttribute(): int
    {
        return count($this->gallery ?? []) + ($this->image ? 1 : 0);
    }
}
