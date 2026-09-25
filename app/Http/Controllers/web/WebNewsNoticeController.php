<?php

namespace App\Http\Controllers\Web;   // match your real folder name casing (web / Web)

use App\Http\Controllers\Controller;
use App\Models\NewsNotice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WebNewsNoticeController extends Controller
{
    /**
     * Searchable archive: ?q=exam&type=circular&year=2026
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $type   = (string) $request->query('type', '');
        $year   = (int) $request->query('year', 0);

        if (! array_key_exists($type, NewsNotice::TYPES)) {
            $type = '';
        }

        $query = $this->published()
            ->when($search !== '', function (Builder $q) use ($search) {
                $q->where(function (Builder $q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($type !== '', fn (Builder $q) => $q->where('type', $type))
            ->when($year > 0, fn (Builder $q) => $q->whereYear('published_at', $year));

        $notices = $this->sorted($query)->paginate(10)->withQueryString();

        $filtering = $search !== '' || $type !== '' || $year > 0;

        // Pinned / urgent strip — only on the unfiltered first page
        $highlights = (! $filtering && $notices->currentPage() === 1)
            ? $this->sorted($this->published()->where(fn ($q) => $q->where('is_pinned', true)->orWhere('priority', 'urgent')))
                ->limit(3)->get()
            : collect();

        return view('web.news-notices', array_merge($this->sidebar(), [
            'notice'     => null,
            'notices'    => $notices,
            'highlights' => $highlights,
            'search'     => $search,
            'type'       => $type,
            'year'       => $year,
            'filtering'  => $filtering,
        ]));
    }

    /**
     * Single notice.
     */
    public function show(NewsNotice $newsNotice, ?string $slug = null): View
    {
        abort_unless(
            $newsNotice->is_active && (! $newsNotice->published_at || $newsNotice->published_at->lte(today())),
            404
        );

        $date = $newsNotice->published_at ?? $newsNotice->created_at;

        $newer = $this->published()->where('id', '!=', $newsNotice->id)
            ->where('published_at', '>', $date)->orderBy('published_at')->first();

        $older = $this->published()->where('id', '!=', $newsNotice->id)
            ->where('published_at', '<', $date)->orderByDesc('published_at')->first();

        return view('web.news-notices', array_merge($this->sidebar($newsNotice->id), [
            'notice' => $newsNotice,
            'newer'  => $newer,
            'older'  => $older,
        ]));
    }

    /* ------------------------------------------------------------------ */

    /** Active and already published (future-dated notices stay hidden). */
    protected function published(): Builder
    {
        return NewsNotice::query()
            ->active()
            ->where(fn ($q) => $q->whereNull('published_at')->orWhereDate('published_at', '<=', today()));
    }

    /** Pinned → urgent → important → normal → newest. */
    protected function sorted(Builder $q): Builder
    {
        return $q->orderByDesc('is_pinned')
            ->orderByRaw("FIELD(priority, 'urgent', 'important', 'normal')")
            ->orderByDesc('published_at')
            ->orderByDesc('id');
    }

    /** Data for the sidebar (categories, archive years, latest). */
    protected function sidebar(?int $exceptId = null): array
    {
        return [
            'typeCounts' => $this->published()
                ->selectRaw('type, COUNT(*) as total')->groupBy('type')->pluck('total', 'type'),
            'years' => $this->published()
                ->whereNotNull('published_at')
                ->selectRaw('YEAR(published_at) as y, COUNT(*) as total')
                ->groupBy('y')->orderByDesc('y')->pluck('total', 'y'),
            'recent' => $this->published()
                ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
                ->orderByDesc('published_at')->orderByDesc('id')->limit(4)->get(),
            'totalPublished' => $this->published()->count(),
        ];
    }
}