<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Concerns\LogsActivity;
class Boarding extends Model
{
    use HasFactory,LogsActivity;
    protected $fillable = [
        'title',
        'description',
        'images',
        'videos',
        'fees_title',
        'fees_qr',
        'qr_caption',
    ];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
    ];

    /** The single Boarding record (created empty on first use). */
    public static function current(): self
    {
        return static::first() ?? new static();
    }

    /** Public URLs of the uploaded images. */
    public function getImageUrlsAttribute(): array
    {
        return collect($this->images ?? [])
            ->map(fn ($path) => Storage::url($path))
            ->values()
            ->all();
    }

    /** Public URL of the fees QR code. */
    public function getQrUrlAttribute(): ?string
    {
        return $this->fees_qr ? Storage::url($this->fees_qr) : null;
    }

    /**
     * Videos ready for display:
     *  ['type' => 'file',  'url' => '/storage/...mp4']
     *  ['type' => 'embed', 'url' => 'https://www.youtube.com/embed/...', 'original' => '...']
     */
    public function getVideoItemsAttribute(): array
    {
        return collect($this->videos ?? [])
            ->map(function ($v) {
                if (($v['type'] ?? '') === 'file') {
                    return ['type' => 'file', 'url' => Storage::url($v['src'])];
                }
                $embed = static::embedUrl($v['src'] ?? '');
                return $embed ? ['type' => 'embed', 'url' => $embed, 'original' => $v['src']] : null;
            })
            ->filter()
            ->values()
            ->all();
    }

    /** Turn a YouTube / Vimeo page link into an embeddable URL. */
    public static function embedUrl(string $url): ?string
    {
        $url = trim($url);

        // YouTube: watch?v=, youtu.be/, shorts/, embed/
        if (preg_match('~(?:youtube\.com/(?:watch\?v=|shorts/|embed/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        // Vimeo: vimeo.com/123456789
        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }

        return null;
    }
}