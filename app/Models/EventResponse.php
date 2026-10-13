<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventResponse extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected string $activityModule = 'Event Responses';
    protected string $activityLabel  = 'name';
    protected array  $activityIgnore = ['ip_address'];

    protected $fillable = [
        'event_id',
        'name',
        'phone',
        'comment',
        'ip_address',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}