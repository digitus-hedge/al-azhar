<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * File: app/Models/Curriculum.php
 *
 * @property int    $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string|null $image
 * @property bool   $is_active
 */
class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Auto-generate a unique slug from the title.
     */
    protected static function booted(): void
    {
        static::saving(function (Curriculum $curriculum) {
            if (empty($curriculum->slug)) {
                $curriculum->slug = static::uniqueSlug($curriculum->title, $curriculum->id);
            }
        });
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'curriculum';
        $slug = $base;
        $i = 1;

        while (
            static::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-" . (++$i);
        }

        return $slug;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
