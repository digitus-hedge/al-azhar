<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Public (website) events pages.
 * The admin CRUD stays in App\Http\Controllers\Admin\EventController.
 */
class EventController extends Controller
{
    /**
     * /events           → all events (upcoming first, then past)
     * /events?type=upcoming | past
     */
    public function index(Request $request): View
    {
        $type  = in_array($request->query('type'), ['upcoming', 'past'], true) ? $request->query('type') : 'all';
        $today = now()->toDateString();

        $query = Event::query()->where('is_active', true);

        if ($type === 'upcoming') {
            $query->whereDate('event_date', '>=', $today)
                  ->orderBy('event_date')->orderBy('event_time');
        } elseif ($type === 'past') {
            $query->whereDate('event_date', '<', $today)
                  ->orderByDesc('event_date')->orderByDesc('event_time');
        } else {
            // upcoming events first (soonest first), then past events (latest first)
            $query->orderByRaw('CASE WHEN event_date >= ? THEN 0 ELSE 1 END', [$today])
                  ->orderByRaw('CASE WHEN event_date >= ? THEN event_date END ASC', [$today])
                  ->orderByRaw('CASE WHEN event_date < ? THEN event_date END DESC', [$today])
                  ->orderBy('sort_order');
        }

        $events = $query->paginate(9)->withQueryString();

        return view('web.event', compact('events', 'type'));
    }

    /**
     * /events/{event} → one event with a few others below it.
     */
    public function show(Event $event): View
    {
        abort_unless($event->is_active, 404);

        $moreEvents = Event::where('is_active', true)
            ->whereKeyNot($event->getKey())
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->take(3)
            ->get();

        // not enough upcoming? fill with the latest past ones
        if ($moreEvents->count() < 3) {
            $moreEvents = $moreEvents->concat(
                Event::where('is_active', true)
                    ->whereKeyNot($event->getKey())
                    ->whereNotIn('id', $moreEvents->pluck('id'))
                    ->orderByDesc('event_date')
                    ->take(3 - $moreEvents->count())
                    ->get()
            );
        }

        return view('web.event_details', compact('event', 'moreEvents'));
    }
}