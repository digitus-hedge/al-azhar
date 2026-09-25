<?php

namespace App\Http\Controllers\Web;   // match your real folder name casing (web / Web)

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class WebGalleryController extends Controller
{
    /**
     * Public gallery: albums grouped by event (album column) or by year.
     */
    public function index(): View
    {
        $items = Gallery::active()->ordered()->get();

        $albums = $items
            ->groupBy(fn (Gallery $item) => $this->albumKey($item))
            ->map(function (Collection $group, string $key) {
                $first = $group->first();

                return (object) [
                    'key'    => \Illuminate\Support\Str::slug($key) ?: 'album',
                    'title'  => $key,
                    'year'   => optional($group->max('created_at'))->format('Y'),
                    'latest' => $group->max('created_at'),
                    'items'  => $group->values(),
                    'photos' => $group->where('media_type', 'image')->count(),
                    'videos' => $group->where('media_type', '!=', 'image')->count(),
                ];
            })
            ->sortByDesc('latest')
            ->values();

        return view('web.gallery', [
            'albums'      => $albums,
            'totalCount'  => $items->count(),
            'photoCount'  => $items->where('media_type', 'image')->count(),
            'videoCount'  => $items->where('media_type', '!=', 'image')->count(),
            'years'       => $albums->pluck('year')->filter()->unique()->sortDesc()->values(),
        ]);
    }

    /**
     * Album name if the optional "album" column is filled, otherwise the year.
     */
    protected function albumKey(Gallery $item): string
    {
        $album = trim((string) ($item->album ?? ''));

        return $album !== '' ? $album : ($item->created_at?->format('Y') ?? 'Gallery');
    }
}