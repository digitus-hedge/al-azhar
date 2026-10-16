<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * File: app/Models/Curriculum.php
 */
class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',       // keep for legacy if your old column still exists
        'images',      // multi-image JSON array
        'is_active',
    ];

    protected $casts = [
        'images'    => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Scope: only active curriculums.
     * Enables Curriculum::active()->get() usage.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Auto-generate a unique slug from the title whenever a record
     * is created or updated with no slug supplied.
     */
    protected static function booted(): void
    {
        static::saving(function (Curriculum $curriculum) {
            if (empty($curriculum->slug) && !empty($curriculum->title)) {
                $curriculum->slug = static::makeUniqueSlug($curriculum->title, $curriculum->id);
            }
        });
    }

    /**
     * Build a URL-safe slug from the title and guarantee it is unique
     * across the table (appending -2, -3, ... if a collision exists).
     */
    protected static function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'curriculum';
        $slug = $base;
        $i    = 2;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}