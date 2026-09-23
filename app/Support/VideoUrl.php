<?php

namespace App\Support;

class VideoUrl
{
    /**
     * Returns ['provider' => 'youtube'|'vimeo', 'id' => '...'] or null.
     */
    public static function parse(?string $url): ?array
    {
        $url = trim((string) $url);
        if ($url === '') {
            return null;
        }

        // YouTube: watch, youtu.be, shorts, embed, live, v/, m./music./nocookie
        $yt = '~^(?:https?://)?(?:www\.|m\.|music\.)?(?:youtube\.com|youtube-nocookie\.com|youtu\.be)/'
            . '(?:watch\?(?:.*&)?v=|shorts/|embed/|live/|v/|)([A-Za-z0-9_-]{11})~i';

        if (preg_match($yt, $url, $m)) {
            return ['provider' => 'youtube', 'id' => $m[1]];
        }

        // Vimeo: vimeo.com/123, /channels/x/123, /groups/x/videos/123, player.vimeo.com/video/123, unlisted /123/abcdef
        $vm = '~^(?:https?://)?(?:www\.|player\.)?vimeo\.com/(?:.*?/)?(?:video/)?(\d+)(?:/([a-z0-9]+))?~i';

        if (preg_match($vm, $url, $m)) {
            $id = $m[1] . (! empty($m[2]) ? '?h=' . $m[2] : '');
            return ['provider' => 'vimeo', 'id' => $id];
        }

        return null;
    }

    public static function embedUrl(string $provider, string $id): string
    {
        return $provider === 'youtube'
            ? "https://www.youtube-nocookie.com/embed/{$id}?rel=0"
            : "https://player.vimeo.com/video/{$id}";
    }

    public static function thumbnail(string $provider, string $id): ?string
    {
        return $provider === 'youtube'
            ? "https://img.youtube.com/vi/{$id}/hqdefault.jpg"
            : null; // Vimeo needs an API call; show a play-icon placeholder instead
    }
}