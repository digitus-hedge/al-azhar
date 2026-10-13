<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\StoreEventResponseRequest;
use App\Models\EventResponse;
use Illuminate\Http\RedirectResponse;

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

        $query = Event::query();

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

public function storeResponse(StoreEventResponseRequest $request): RedirectResponse
{
    // Honeypot: bot, pretend success
    if ($request->filled('website')) {
        return redirect()
            ->route('events.index')
            ->with('response_success', 'Thank you! Your response has been recorded.');
    }

    $event = Event::find($request->input('event_id'));

    // Event missing or inactive
    if (!$event) {
        return redirect()
            ->route('events.index')
            ->with('response_error', 'Sorry, this event could not be found.');
    }

    if (!$event->is_active) {
        return redirect()
            ->route('events.index')
            ->with('response_error', 'Sorry, this event is no longer available.');
    }

    // Response window closed
    if (!$event->is_open_for_response) {
        $reason = empty($event->response_date)
            ? 'no response window is set for this event'
            : 'the response window closed on ' . \Illuminate\Support\Carbon::parse($event->response_date)->format('d M Y');

        return redirect()
            ->route('events.index')
            ->with('response_error', "Sorry, responses for this event are closed ({$reason}).");
    }

    EventResponse::create([
        'event_id'   => $event->id,
        'name'       => $request->validated()['name'],
        'phone'      => $request->validated()['phone'],
        'comment'    => $request->validated()['comment'] ?? null,
        'ip_address' => $request->ip(),
    ]);

    return redirect()
        ->route('events.index')
        ->with('response_success', 'Thank you! Your response has been recorded.')
        ->withFragment('event-' . $event->id);
}
}