<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'media',
        'media_type',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id', 'desc');
    }

    public function getMediaUrlAttribute(): ?string
    {
        return $this->media ? Storage::url($this->media) : null;
    }

    public function getIsVideoAttribute(): bool
    {
        return $this->media_type === 'video';
    }
}
