<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Concerns\LogsActivity;   // ← this import
/**
 * File: app/Models/Blog.php
 *
 * @property int    $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property string|null $image
 * @property int    $sort_order
 * @property bool   $is_active
 */
class Blog extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'journal_link',   // NEW
        'published_at',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'sort_order'   => 'integer',
        'is_active'    => 'boolean',
    ];

    /**
     * Auto-generate a unique slug from the title whenever one isn't provided.
     */
    protected static function booted(): void
    {
        static::saving(function (Blog $blog) {
            if (empty($blog->slug)) {
                $blog->slug = static::uniqueSlug($blog->title, $blog->id);
            }
        });
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'blog';
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

    /* ----- Scopes ----- */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderByDesc('published_at')->orderByDesc('id');
    }
}
