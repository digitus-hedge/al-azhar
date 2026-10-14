<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventResponse;
use App\Models\Event;
use Illuminate\Http\Request;

class EventResponseController extends Controller
{
    public function index(Request $request)
    {
        // Per-page options
        $perPageOptions = [10, 25, 50, 100];
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, $perPageOptions)) {
            $perPage = 10;
        }

        $query = EventResponse::with('event')
            ->orderBy('created_at', 'desc');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%")
                  ->orWhereHas('event', function ($qe) use ($search) {
                      $qe->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // Event filter
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        $responses = $query->paginate($perPage)->withQueryString();

        $events = Event::orderBy('title')->get(['id', 'title']);

        return view('admin.event_responses.index', compact(
            'responses', 'events', 'perPage', 'perPageOptions'
        ));
    }

    public function show($id)
    {
        $response = EventResponse::with('event')->findOrFail($id);
        return view('admin.event_responses.show', compact('response'));
    }

    public function destroy($id)
    {
        $response = EventResponse::findOrFail($id);
        $response->delete();

        return redirect()->route('admin.event-responses.index')
            ->with('success', 'Event response deleted successfully.');
    }
}