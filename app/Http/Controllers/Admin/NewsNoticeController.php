<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsNoticeRequest;
use App\Models\NewsNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsNoticeController extends Controller
{
    /**
     * Columns that are allowed to be sorted on from the URL.
     */
    protected array $sortable = [
        'title', 'type', 'priority','published_at', 'is_pinned', 'is_active', 'created_at',
    ];

    /**
     * Allowed "per page" choices for the listing.
     */
    protected array $perPageOptions = [10, 25, 50, 100];

    /**
     * Display a listing of news & notices.
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

    $query = NewsNotice::query();

    if ($search !== '') {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('type', 'like', "%{$search}%");
        });
    }

    if ($sortBy === 'priority') {
        // Sort by importance, not alphabetically (normal → important → urgent)
        $query->orderByRaw(
            "CASE priority WHEN 'urgent' THEN 3 WHEN 'important' THEN 2 ELSE 1 END {$sortDir}"
        );
    } else {
        $query->orderBy($sortBy, $sortDir);
    }

    // Tie-breaker: newest first when values are equal
    if ($sortBy !== 'id') {
        $query->orderByDesc('id');
    }

    $newsNotices = $query->paginate($perPage)->appends($request->query());

    return view('admin.news-notice.index', [
        'newsNotices'    => $newsNotices,
        'search'         => $search,
        'sortBy'         => $sortBy,
        'sortDir'        => $sortDir,
        'perPage'        => $perPage,
        'perPageOptions' => $this->perPageOptions,
        'types'          => NewsNotice::TYPES,
    ]);
}

    /**
     * Show the form for creating a new notice.
     */
    public function create()
    {
        $newsNotice = new NewsNotice();

        return view('admin.news-notice.form', [
            'newsNotice' => $newsNotice,
            'types'      => NewsNotice::TYPES,
        ]);
    }

    /**
     * Store a newly created notice.
     */
    public function store(NewsNoticeRequest $request)
    {
        $validated = $request->validated();
        unset($validated['remove_image'], $validated['remove_attachment']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news-notices/images', 'public');
        }

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('news-notices', 'public');
        }

        $validated['is_pinned'] = $request->boolean('is_pinned');
        $validated['is_active'] = $request->boolean('is_active', true);

        $newsNotice = NewsNotice::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message'    => 'Notice added successfully.',
                'newsNotice' => $newsNotice,
            ]);
        }

        return redirect()
            ->route('admin.news-notices')
            ->with('success', 'Notice added successfully.');
    }

    /**
     * Show the form for editing a notice.
     */
    public function edit(NewsNotice $newsNotice)
    {
        return view('admin.news-notice.form', [
            'newsNotice' => $newsNotice,
            'types'      => NewsNotice::TYPES,
        ]);
    }

    /**
     * Update an existing notice.
     */
    public function update(NewsNoticeRequest $request, NewsNotice $newsNotice)
    {
        $validated = $request->validated();
        unset($validated['remove_image'], $validated['remove_attachment']);

        // Cover image: replace, remove, or keep
        if ($request->hasFile('image')) {
            if ($newsNotice->image) {
                Storage::disk('public')->delete($newsNotice->image);
            }
            $validated['image'] = $request->file('image')->store('news-notices/images', 'public');
        } elseif ($request->boolean('remove_image')) {
            if ($newsNotice->image) {
                Storage::disk('public')->delete($newsNotice->image);
            }
            $validated['image'] = null;
        } else {
            unset($validated['image']); // keep current image
        }

        if ($request->hasFile('attachment')) {
            if ($newsNotice->attachment) {
                Storage::disk('public')->delete($newsNotice->attachment);
            }
            $validated['attachment'] = $request->file('attachment')->store('news-notices', 'public');
        } elseif ($request->boolean('remove_attachment')) {
            if ($newsNotice->attachment) {
                Storage::disk('public')->delete($newsNotice->attachment);
            }
            $validated['attachment'] = null;
        } else {
            unset($validated['attachment']); // keep current attachment
        }

        // Only change pin / visibility when the form actually sends them
        // (the Visibility card is hidden, so otherwise editing would unpublish the notice).
        if ($request->has('is_pinned')) {
            $validated['is_pinned'] = $request->boolean('is_pinned');
        }
        if ($request->has('is_active')) {
            $validated['is_active'] = $request->boolean('is_active');
        }

        $newsNotice->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message'    => 'Notice updated successfully.',
                'newsNotice' => $newsNotice,
            ]);
        }

        return redirect()
            ->route('admin.news-notices')
            ->with('success', 'Notice updated successfully.');
    }

    /**
     * Soft delete a notice.
     */
    public function destroy(Request $request, NewsNotice $newsNotice)
    {
        $newsNotice->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Notice removed successfully.']);
        }

        return redirect()
            ->route('admin.news-notices')
            ->with('success', 'Notice removed successfully.');
    }
}
