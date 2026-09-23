<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Support\VideoUrl;

class GalleryController extends Controller
{
    /**
     * Video file extensions — anything else uploaded is treated as an image.
     */
    protected array $videoMimes = ['mp4', 'mov', 'webm', 'avi', 'quicktime'];

    /**
     * Columns that are allowed to be sorted on from the URL.
     */
    protected array $sortable = [
        'title',
        'media_type',
        'is_active',
        'sort_order',
        'created_at',
    ];

    /**
     * Allowed "per page" choices for the listing.
     */
    protected array $perPageOptions = [5, 10, 25, 50, 100];

    /**
     * Listing page — search, sort, per-page (same pattern as Staff).
     */
    public function index(Request $request): View
    {
        $search  = trim((string) $request->query('q', ''));
        $sortBy  = $request->query('sort', 'sort_order');
        $sortDir = strtolower($request->query('dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $perPage = (int) $request->query('per_page', 10);

        if (! in_array($sortBy, $this->sortable, true)) {
            $sortBy = 'sort_order';
        }

        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        $query = Gallery::query();

         if ($search !== '') {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('media_type', 'like', "%{$search}%");
        });
    }

        $query->orderBy($sortBy, $sortDir);
        if ($sortBy !== 'title') {
            $query->orderBy('title');
        }

        $items = $query->paginate($perPage)->appends($request->query());

        return view('admin.gallery.index', [
            'items'          => $items,
            'search'         => $search,
            'sortBy'         => $sortBy,
            'sortDir'        => $sortDir,
            'perPage'        => $perPage,
            'perPageOptions' => $this->perPageOptions,
        ]);
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        $item = new Gallery();

        return view('admin.gallery.form', compact('item'));
    }

    /**
     * Store a newly created gallery item.
     */
    public function store(GalleryRequest $request): JsonResponse|RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('media')) {
            $data['media']      = $request->file('media')->store('gallery', 'public');
            $data['media_type'] = $this->detectMediaType($request->file('media'));
            $data += ['video_url' => null, 'video_provider' => null, 'video_id' => null];
        } elseif ($video = VideoUrl::parse($request->input('video_url'))) {
            $data['media']          = null;
            $data['media_type']     = $video['provider'];
            $data['video_provider'] = $video['provider'];
            $data['video_id']       = $video['id'];
        }

        $data['is_active'] = $request->boolean('is_active', true);

        Gallery::create($data);

        $message = 'Gallery item added successfully.';

        return $request->wantsJson()
            ? response()->json(['message' => $message])
            : redirect()->route('admin.gallery')->with('success', $message);
    }

    /**
     * Show the edit form.
     */
    public function edit(Gallery $gallery): View
    {
        $item = $gallery;

        return view('admin.gallery.form', compact('item'));
    }

    /**
     * Update the specified gallery item.
     */
   public function update(GalleryRequest $request, Gallery $gallery): JsonResponse|RedirectResponse
{
    $data = $request->validated();
    unset($data['media']);

    if ($request->hasFile('media')) {
        // New file replaces whatever was there (file or link)
        if ($gallery->media) {
            Storage::disk('public')->delete($gallery->media);
        }
        $data['media']          = $request->file('media')->store('gallery', 'public');
        $data['media_type']     = $this->detectMediaType($request->file('media'));
        $data['video_url']      = null;
        $data['video_provider'] = null;
        $data['video_id']       = null;
    } elseif (filled($request->input('video_url'))) {
        // New/changed link replaces the old file
        $video = VideoUrl::parse($request->input('video_url'));
        if ($gallery->media) {
            Storage::disk('public')->delete($gallery->media);
        }
        $data['media']          = null;
        $data['media_type']     = $video['provider'];
        $data['video_provider'] = $video['provider'];
        $data['video_id']       = $video['id'];
    } else {
        // Nothing new — keep current file/link as it is
        unset($data['video_url']);
    }

    $data['is_active'] = $request->boolean('is_active', true);

    $gallery->update($data);

    $message = 'Gallery item updated successfully.';

    return $request->wantsJson()
        ? response()->json(['message' => $message])
        : redirect()->route('admin.gallery')->with('success', $message);
}

    /**
     * Soft delete the specified gallery item.
     */
    public function destroy(Gallery $gallery): RedirectResponse
    {
        $gallery->delete();

        return redirect()
            ->route('admin.gallery')
            ->with('success', 'Gallery item deleted.');
    }

    protected function detectMediaType(UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());

        return in_array($ext, $this->videoMimes, true) ? 'video' : 'image';
    }
}
