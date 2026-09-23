<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Support\VideoUrl;
use App\Models\Concerns\LogsActivity;

class Gallery extends Model
{
    use SoftDeletes,LogsActivity;



    protected $fillable = [
        'title',
        'media',
        'media_type',
        'video_url',
        'video_provider',
        'video_id',
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

    public function getIsEmbedAttribute(): bool
    {
        return in_array($this->media_type, ['youtube', 'vimeo'], true);
    }

    public function getEmbedUrlAttribute(): ?string
    {
        return $this->is_embed ? VideoUrl::embedUrl($this->video_provider, $this->video_id) : null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->is_embed) {
            return VideoUrl::thumbnail($this->video_provider, $this->video_id);
        }
        return $this->media_type === 'image' ? $this->media_url : null;
    }
}
