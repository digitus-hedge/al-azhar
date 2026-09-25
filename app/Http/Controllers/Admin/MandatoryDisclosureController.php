<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MandatoryDisclosureRequest;
use App\Models\DisclosureCategory;
use App\Models\MandatoryDisclosure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class MandatoryDisclosureController extends Controller
{
    /** Columns allowed to be sorted on from the URL. */
    protected array $sortable = ['id', 'title', 'category', 'valid_until', 'sort_order', 'is_active', 'created_at'];

    /** Allowed "per page" choices. */
    protected array $perPageOptions = [10, 25, 50, 100];

    /**
     * List all disclosure documents.
     */
    public function index(Request $request)
    {
        $search   = trim((string) $request->query('q', ''));
        $category = $request->integer('category') ?: null;   // disclosure_categories.id
        $sortBy   = $request->query('sort', 'id');
        $sortDir  = strtolower($request->query('dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        $perPage  = (int) $request->query('per_page', 10);

        if (! in_array($sortBy, $this->sortable, true)) {
            $sortBy  = 'id';
            $sortDir = 'desc';
        }

        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        $query = MandatoryDisclosure::query()
            ->with('disclosureCategory');   // load category names in one query, not one per row

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('issued_by', 'like', "%{$search}%")
                  ->orWhereHas('disclosureCategory', fn ($c) => $c->where('name', 'like', "%{$search}%"));
            });
        }

        $query->inCategory($category);

        // Sort "Category" by the category NAME (the column itself only holds the id)
        if ($sortBy === 'category') {
            $query->orderBy(
                DisclosureCategory::withTrashed()
                    ->select('name')
                    ->whereColumn('disclosure_categories.id', 'mandatory_disclosures.category'),
                $sortDir
            );
        } else {
            $query->orderBy($sortBy, $sortDir);
        }

        if ($sortBy !== 'id') {
            $query->orderBy('id', 'desc');
        }

        $disclosures = $query->paginate($perPage)->appends($request->query());

        // Counts for the warning strip at the top of the list.
        $expiredCount  = MandatoryDisclosure::active()->whereDate('valid_until', '<', today())->count();
        $expiringCount = MandatoryDisclosure::active()
            ->whereDate('valid_until', '>=', today())
            ->whereDate('valid_until', '<=', today()->addDays(30))
            ->count();

        return view('admin.mandatory-disclosures.index', [
            'disclosures'    => $disclosures,
            'search'         => $search,
            'category'       => $category,
            'categories'     => DisclosureCategory::orderBy('name')->pluck('name', 'id'),   // [id => name]
            'sortBy'         => $sortBy,
            'sortDir'        => $sortDir,
            'perPage'        => $perPage,
            'perPageOptions' => $this->perPageOptions,
            'expiredCount'   => $expiredCount,
            'expiringCount'  => $expiringCount,
        ]);
    }

    /**
     * Show the "Add Document" form.
     */
    public function create()
    {
        $disclosure = new MandatoryDisclosure(['is_active' => true, 'sort_order' => 0]);

        return view('admin.mandatory-disclosures.form', [
            'disclosure' => $disclosure,
            'categories' => $this->categoryOptions(),
        ]);
    }

    /**
     * Save a new document.
     */
    public function store(MandatoryDisclosureRequest $request)
    {
        $validated = $request->validated();   // 'category' is the disclosure_categories id

        $file = $request->file('file');
        $validated['file']          = $file->store('mandatory-disclosures', 'public');
        $validated['original_name'] = $file->getClientOriginalName();
        $validated['file_size']     = $file->getSize();
        $validated['is_active']     = $request->boolean('is_active');
        $validated['sort_order']    = (int) ($validated['sort_order'] ?? 0);

        $disclosure = MandatoryDisclosure::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message'    => 'Document added successfully.',
                'disclosure' => $disclosure,
            ]);
        }

        return redirect()
            ->route('admin.mandatory-disclosures')
            ->with('success', 'Document added successfully.');
    }

    /**
     * Show the edit form.
     */
    public function edit(MandatoryDisclosure $disclosure)
    {
        return view('admin.mandatory-disclosures.form', [
            'disclosure' => $disclosure,
            'categories' => $this->categoryOptions($disclosure),
        ]);
    }

    /**
     * Update an existing document. Uploading a new PDF replaces the old one.
     */
    public function update(MandatoryDisclosureRequest $request, MandatoryDisclosure $disclosure)
    {
        $validated = $request->validated();

        if ($request->hasFile('file')) {
            if ($disclosure->file) {
                Storage::disk('public')->delete($disclosure->file);
            }

            $file = $request->file('file');
            $validated['file']          = $file->store('mandatory-disclosures', 'public');
            $validated['original_name'] = $file->getClientOriginalName();
            $validated['file_size']     = $file->getSize();
        } else {
            unset($validated['file']); // keep current PDF
        }

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $disclosure->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message'    => 'Document updated successfully.',
                'disclosure' => $disclosure,
            ]);
        }

        return redirect()
            ->route('admin.mandatory-disclosures')
            ->with('success', 'Document updated successfully.');
    }

    /**
     * Soft delete a document. The PDF is kept on disk so it can be restored.
     */
    public function destroy(Request $request, MandatoryDisclosure $disclosure)
    {
        $disclosure->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Document removed successfully.']);
        }

        return redirect()
            ->route('admin.mandatory-disclosures')
            ->with('success', 'Document removed successfully.');
    }

    /**
     * Quick on/off switch from the list page (AJAX).
     */
    public function toggle(MandatoryDisclosure $disclosure)
    {
        $disclosure->update(['is_active' => ! $disclosure->is_active]);

        return response()->json([
            'message'   => $disclosure->is_active ? 'Document is now visible on the website.' : 'Document hidden from the website.',
            'is_active' => $disclosure->is_active,
        ]);
    }

    /**
     * Categories for the form dropdown: all active ones, plus this document's
     * current category if it has since been deleted (shown as "(deleted)").
     */
    private function categoryOptions(?MandatoryDisclosure $disclosure = null): Collection
    {
        $current = $disclosure?->category;

        return DisclosureCategory::withTrashed()
            ->where(function ($q) use ($current) {
                $q->whereNull('deleted_at');
                if ($current) {
                    $q->orWhere('id', $current);
                }
            })
            ->orderBy('name')
            ->get(['id', 'name', 'deleted_at']);
    }
}