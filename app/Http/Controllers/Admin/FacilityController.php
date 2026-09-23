<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FacilityRequest;
use App\Models\Facility;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FacilityController extends Controller
{
    /**
     * Columns that are allowed to be sorted on from the URL.
     */
    protected array $sortable = [
        'title', 'category', 'is_active', 'show_on_home', 'sort_order', 'created_at',
    ];

    /**
     * Allowed "per page" choices for the listing.
     */
    protected array $perPageOptions = [5, 10, 25, 50, 100];

    /**
     * Listing page — category tabs, search, sort, per-page.
     */
    public function index(Request $request): View
    {
        $search   = trim((string) $request->query('q', ''));
        $category = (string) $request->query('category', '');
        $sortBy   = $request->query('sort', 'sort_order');
        $sortDir  = strtolower($request->query('dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $perPage  = (int) $request->query('per_page', 10);

        if (! in_array($sortBy, $this->sortable, true)) {
            $sortBy = 'sort_order';
        }

        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        if (! array_key_exists($category, Facility::CATEGORIES)) {
            $category = '';
        }

        $query = Facility::query();

        if ($category !== '') {
            $query->where('category', $category);
        }

        if ($search !== '') {
            // Let "labs", "bus", "library" etc. also match by category
            $categoryMatches = collect(Facility::CATEGORIES)
                ->filter(fn ($label, $key) => str_contains(strtolower($label), strtolower($search))
                    || str_contains($key, strtolower($search)))
                ->keys()
                ->all();

            $query->where(function ($q) use ($search, $categoryMatches) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");

                if (! empty($categoryMatches)) {
                    $q->orWhereIn('category', $categoryMatches);
                }
            });
        }

        $query->orderBy($sortBy, $sortDir);
        if ($sortBy !== 'title') {
            $query->orderBy('title');
        }

        $facilities = $query->paginate($perPage)->appends($request->query());

        // Counts for the category tabs
        $counts = Facility::query()
            ->selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('admin.facilities.index', [
            'facilities'     => $facilities,
            'search'         => $search,
            'category'       => $category,
            'categories'     => Facility::CATEGORIES,
            'categoryIcons'  => Facility::CATEGORY_ICONS,
            'counts'         => $counts,
            'totalCount'     => $counts->sum(),
            'sortBy'         => $sortBy,
            'sortDir'        => $sortDir,
            'perPage'        => $perPage,
            'perPageOptions' => $this->perPageOptions,
        ]);
    }

    /**
     * Show the create form. ?category=transport pre-selects the category.
     */
    public function create(Request $request): View
    {
        $category = (string) $request->query('category', 'lab');

        $facility = new Facility([
            'category'   => array_key_exists($category, Facility::CATEGORIES) ? $category : 'lab',
            'is_active'  => true,
            'sort_order' => 0,
        ]);

        return view('admin.facilities.form', [
            'facility'   => $facility,
            'categories' => Facility::CATEGORIES,
        ]);
    }

    /**
     * Store a newly created facility.
     */
    public function store(FacilityRequest $request): JsonResponse|RedirectResponse
    {
        $facility = Facility::create($this->buildData($request));

        return $this->respond($request, 'Facility added successfully.', $facility);
    }

    /**
     * Show the edit form.
     */
    public function edit(Facility $facility): View
    {
        return view('admin.facilities.form', [
            'facility'   => $facility,
            'categories' => Facility::CATEGORIES,
        ]);
    }

    /**
     * Update the specified facility.
     */
    public function update(FacilityRequest $request, Facility $facility): JsonResponse|RedirectResponse
    {
        $facility->update($this->buildData($request, $facility));

        return $this->respond($request, 'Facility updated successfully.', $facility);
    }

    /**
     * Soft delete — admins only (staff can add/edit but not delete).
     */
    public function destroy(Facility $facility): RedirectResponse
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Only admins can delete facilities.');
        }

        $facility->delete();

        return redirect()
            ->route('admin.facilities')
            ->with('success', 'Facility deleted.');
    }

    /* ------------------------------------------------------------------ */

    /**
     * Turn the validated request into columns, handling all file uploads.
     */
    protected function buildData(FacilityRequest $request, ?Facility $facility = null): array
    {
        $data = collect($request->validated())
            ->except(['image', 'remove_image', 'gallery', 'remove_gallery'])
            ->all();

        // Highlights: drop empty rows, trim, re-index
        $data['features'] = collect($request->input('features', []))
            ->map(fn ($v) => trim((string) $v))
            ->filter()
            ->values()
            ->all();

        $data['show_on_home'] = $request->boolean('show_on_home');
        $data['is_active']    = $request->boolean('is_active', true);
        $data['sort_order']   = (int) $request->input('sort_order', 0);

        // ---- Cover image ----
        if ($request->hasFile('image')) {
            if ($facility?->image) {
                Storage::disk('public')->delete($facility->image);
            }
            $data['image'] = $request->file('image')->store('facilities', 'public');
        } elseif ($facility && $request->boolean('remove_image') && $facility->image) {
            Storage::disk('public')->delete($facility->image);
            $data['image'] = null;
        }

        // ---- Gallery ----
        $gallery = $facility?->gallery ?? [];

        // Only remove paths that really belong to this facility
        $toRemove = array_values(array_intersect($gallery, (array) $request->input('remove_gallery', [])));
        if (! empty($toRemove)) {
            Storage::disk('public')->delete($toRemove);
            $gallery = array_values(array_diff($gallery, $toRemove));
        }

        foreach (array_filter((array) $request->file('gallery', [])) as $file) {
            $gallery[] = $file->store('facilities/gallery', 'public');
        }

        $data['gallery'] = $gallery;

        return $data;
    }

    protected function respond(Request $request, string $message, Facility $facility): JsonResponse|RedirectResponse
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message'  => $message,
                'facility' => $facility->fresh(),
            ]);
        }

        return redirect()->route('admin.facilities')->with('success', $message);
    }
}
