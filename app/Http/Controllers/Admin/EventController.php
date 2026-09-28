<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class EventController extends Controller
{
    /**
     * Columns that are allowed to be sorted on from the URL.
     */
    protected array $sortable = ['id',
        'title', 'event_date', 'venue', 'is_active', 'created_at',
    ];

    /**
     * Allowed "per page" choices for the listing.
     */
    protected array $perPageOptions = [10, 25, 50, 100];

    /**
     * Display a listing of events.
     */
   public function index(Request $request)
{
    $search  = trim((string) $request->query('q', ''));
    $sortBy  = $request->query('sort', 'id');
    $sortDir = strtolower($request->query('dir', $sortBy === 'id' ? 'desc' : 'asc')) === 'desc' ? 'desc' : 'asc';
    $perPage = (int) $request->query('per_page', 10);

    if (! in_array($sortBy, $this->sortable, true)) {
        $sortBy  = 'id';
        $sortDir = 'desc';
    }

    if (! in_array($perPage, $this->perPageOptions, true)) {
        $perPage = 10;
    }

    $query = Event::query();

    if ($search !== '') {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('venue', 'like', "%{$search}%");
        });
    }

    if ($sortBy === 'event_date') {
        $query->orderBy('event_date', $sortDir)->orderBy('event_time', $sortDir);
    } else {
        $query->orderBy($sortBy, $sortDir);
    }

    // Tie-breaker: newest first when values are equal
    if ($sortBy !== 'id') {
        $query->orderByDesc('id');
    }

    $events = $query->paginate($perPage)->appends($request->query());

    return view('admin.event.index', [
        'events'         => $events,
        'search'         => $search,
        'sortBy'         => $sortBy,
        'sortDir'        => $sortDir,
        'perPage'        => $perPage,
        'perPageOptions' => $this->perPageOptions,
    ]);
}
    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $event = new Event();

        return view('admin.event.form', [
            'event' => $event,
        ]);
    }

    /**
     * Store a newly created event.
     */
    public function store(EventRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $this->processAndStoreImage($request->file('image'));
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        unset($validated['remove_image']);

        $event = Event::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Event added successfully.',
                'event'   => $event,
            ]);
        }

        return redirect()
            ->route('admin.events')
            ->with('success', 'Event added successfully.');
    }

    /**
     * Show the form for editing an event.
     */
    public function edit(Event $event)
    {
        return view('admin.event.form', [
            'event' => $event,
        ]);
    }

    /**
     * Update an existing event.
     */
    public function update(EventRequest $request, Event $event)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $this->processAndStoreImage($request->file('image'));
        } elseif ($request->boolean('remove_image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = null;
        }

        unset($validated['remove_image']);
        $validated['is_active'] = $request->boolean('is_active');

        $event->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Event updated successfully.',
                'event'   => $event,
            ]);
        }

        return redirect()
            ->route('admin.events')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Soft delete an event.
     */
    public function destroy(Request $request, Event $event)
    {
        $event->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Event removed successfully.']);
        }

        return redirect()
            ->route('admin.events')
            ->with('success', 'Event removed successfully.');
    }

    /**
     * Resize/convert the uploaded event image and store it on the public disk.
     */
    protected function processAndStoreImage($file): string
    {
        $manager = new ImageManager(new Driver());

        $image = $manager->read($file->getRealPath())
            ->cover(800, 500)
            ->toWebp(80);

        $filename = 'events/' . uniqid('event_', true) . '.webp';

        Storage::disk('public')->put($filename, (string) $image);

        return $filename;
    }
}
