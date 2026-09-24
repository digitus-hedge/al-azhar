<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\LogsActivity;

class NewsNotice extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'news_notices';

    public const TYPE_NOTICE       = 'notice';
    public const TYPE_CIRCULAR     = 'circular';
    public const TYPE_ANNOUNCEMENT = 'announcement';

    public const PRIORITIES = [
        'normal'    => 'Normal',
        'important' => 'Important',
        'urgent'    => 'Urgent',
    ];

    public const TYPES = [
        self::TYPE_NOTICE       => 'Notice',
        self::TYPE_CIRCULAR     => 'Circular',
        self::TYPE_ANNOUNCEMENT => 'Announcement',
    ];

    protected $fillable = [
        'title',
        'description',
        'type',
        'attachment',
        'link',
        'published_at',
        'is_pinned',
        'priority',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_pinned'    => 'boolean',
        'is_active'    => 'boolean',
        'sort_order'   => 'integer',
    ];

    /**
     * Scope: only active (published) notices.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: default display order — pinned first, then most recently published.
     */
    public function scopeOrdered($query)
    {
        return $query->orderByDesc('is_pinned')
            ->orderBy('sort_order')
            ->orderByDesc('published_at');
    }

    public function getPriorityLabelAttribute(): string
    {
        return self::PRIORITIES[$this->priority] ?? 'Normal';
    }

    /** Urgent first, then Important, then Normal. */
    public function scopeByPriority($q)
    {
        return $q->orderByRaw("FIELD(priority, 'urgent', 'important', 'normal')");
    }
    
}
