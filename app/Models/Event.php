<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\LogsActivity;   // ← this import
use Illuminate\Database\Eloquent\Relations\HasMany;
class Event extends Model
{
    use HasFactory, SoftDeletes,LogsActivity;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'event_time',
        'response_date',
        'venue',
        'image',
        'link',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'event_date' => 'date',
            'response_date' => 'date',   // ← THIS is what's missing

        'event_time' => 'datetime:H:i',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
 * Comments / responses submitted for this event.
 */
public function responses(): HasMany
{
    return $this->hasMany(EventResponse::class);
}

    /**
 * The response window is open as long as:
 *   - a response_date is set
 *   - response_date (end of day) is still in the future
 *
 * This lets admins open responses before OR after the event.
 */
public function getIsOpenForResponseAttribute(): bool
{
    if (empty($this->response_date)) {
        return false;
    }

    return \Illuminate\Support\Carbon::parse($this->response_date)
        ->endOfDay()
        ->isFuture();
}
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
