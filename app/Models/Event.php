<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\LogsActivity;   // ← this import

class Event extends Model
{
    use HasFactory, SoftDeletes,LogsActivity;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'event_time',
        'venue',
        'image',
        'link',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'datetime:H:i',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Only active events.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Only events that haven't happened yet (today or later).
     */
    public function scopeUpcoming($query)
    {
        return $query->whereDate('event_date', '>=', now()->toDateString());
    }

    /**
     * Default ordering: nearest event first, then manual sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('event_date')->orderBy('event_time')->orderBy('sort_order');
    }
}
