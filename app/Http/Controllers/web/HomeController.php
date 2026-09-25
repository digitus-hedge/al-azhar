<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AdmissionEnquiry;
use App\Models\Banner;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\NewsNotice;
use App\Models\PrincipalDesk;
use App\Models\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Public homepage: hero carousel, stats, about, principal's desk,
     * admission CTA, news & notices, gallery and events.
     */
    public function index(): View
    {
        return view('web.home', $this->sections() + [
            'banner' => Banner::first(),
            'stats'  => Stat::first()?->items ?? [],
        ]);
    }

    /**
     * About Us page: same sections as the home page, without the hero banner.
     */
    public function about(): View
    {
        return view('web.about', $this->sections());
    }

    /* ------------------------------------------------------------------ */

    /** Data shared by the home and About pages. */
    protected function sections(): array
    {
        return [
            'about'        => About::first(),
            'principal'    => PrincipalDesk::active()->first(),
            'admSession'   => $this->admissionSession(),
            'homeNotices'  => $this->notices(),
            'galleryItems' => $this->gallery(),
            'homeEvents'   => $this->events(),
        ];
    }

    /** e.g. "2026-27" */
    protected function admissionSession(): string
    {
        if (method_exists(AdmissionEnquiry::class, 'currentSession')) {
            return AdmissionEnquiry::currentSession();
        }

        $start = now()->month >= 10 ? now()->year + 1 : now()->year;

        return $start . '-' . substr((string) ($start + 1), -2);
    }

    /** Pinned → urgent → important → newest. Future-dated notices stay hidden. */
    protected function notices(): Collection
    {
        return NewsNotice::query()
            ->where('is_active', 1)
            ->where(fn ($q) => $q->whereNull('published_at')->orWhereDate('published_at', '<=', today()))
            ->orderByDesc('is_pinned')
            ->orderByRaw("FIELD(priority, 'urgent', 'important', 'normal')")
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->take(6)
            ->get();
    }

    /** Latest 8 items that have a file or a video link (status not checked). */
    protected function gallery(): Collection
    {
        return Gallery::query()
            ->where(fn ($q) => $q->whereNotNull('media')->orWhereNotNull('video_id'))
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->take(8)
            ->get();
    }

    /** 3 events: upcoming (soonest first), then most recent past ones. */
    protected function events(): Collection
    {
        $query = Event::query();

        if ((new Event)->hasNamedScope('active')) {
            $query->active();
        }

        return $query->latest('id')->take(30)->get()
            ->each(function (Event $e) {
                $e->home_date  = $this->eventDate($e);
                $e->home_image = $this->eventImage($e);
            })
            ->sortBy(function (Event $e) {
                $d = $e->home_date;
                if (! $d) {
                    return PHP_INT_MAX;
                }

                return $d->isFuture() || $d->isToday()
                    ? $d->timestamp                    // upcoming: soonest first
                    : PHP_INT_MAX / 2 - $d->timestamp; // past: most recent first
            })
            ->take(3)
            ->values();
    }

    protected function eventDate(Event $e): ?Carbon
    {
        $raw = $e->event_date ?? $e->start_date ?? $e->date ?? $e->starts_at ?? $e->created_at;

        return $raw ? Carbon::parse($raw) : null;
    }

    protected function eventImage(Event $e): ?string
    {
        if (! empty($e->image_url)) {
            return $e->image_url;
        }

        $path = $e->image ?? $e->thumbnail ?? $e->banner ?? null;

        return $path ? Storage::url($path) : null;
    }
}