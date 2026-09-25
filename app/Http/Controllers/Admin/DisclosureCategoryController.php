<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisclosureCategoryRequest;
use App\Models\DisclosureCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Master > Disclosure Categories
 * Categories used to group Mandatory Disclosure documents
 * (CBSE Affiliation, NOC, Trust Deed, Safety Certificates, ...).
 * Delete is a soft delete (deleted_at), so it can be restored from "Trash".
 */
class DisclosureCategoryController extends Controller
{
    protected array $perPageOptions = [10, 25, 50, 100];

    protected array $sortable = ['name', 'created_at', 'updated_at'];

    public function index(Request $request): View
    {
        $search  = trim((string) $request->query('q', ''));
        $trashed = $request->boolean('trashed');

        $sortBy = $request->query('sort', 'name');
        if (! in_array($sortBy, $this->sortable, true)) {
            $sortBy = 'name';
        }
        $sortDir = $request->query('dir') === 'desc' ? 'desc' : 'asc';

        $perPage = (int) $request->query('per_page', 10);
        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        $categories = DisclosureCategory::query()
            ->when($trashed, fn ($q) => $q->onlyTrashed())
            ->search($search)
            ->orderBy($sortBy, $sortDir)
            ->orderBy('id')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.disclosure-categories.index', [
            'categories'     => $categories,
            'search'         => $search,
            'trashed'        => $trashed,
            'sortBy'         => $sortBy,
            'sortDir'        => $sortDir,
            'perPage'        => $perPage,
            'perPageOptions' => $this->perPageOptions,
            'activeCount'    => DisclosureCategory::count(),
            'trashedCount'   => DisclosureCategory::onlyTrashed()->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.disclosure-categories.form', [
            'category' => new DisclosureCategory(),
        ]);
    }

    public function store(DisclosureCategoryRequest $request): RedirectResponse
    {
        DisclosureCategory::create($request->validated());

        if ($request->input('action') === 'save_new') {
            return redirect()
                ->route('admin.disclosure-categories.create')
                ->with('success', 'Category added. You can add another one.');
        }

        return redirect()
            ->route('admin.disclosure-categories')
            ->with('success', 'Disclosure category added successfully.');
    }

    public function edit(DisclosureCategory $category): View
    {
        return view('admin.disclosure-categories.form', [
            'category' => $category,
        ]);
    }

    public function update(DisclosureCategoryRequest $request, DisclosureCategory $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()
            ->route('admin.disclosure-categories')
            ->with('success', 'Disclosure category updated successfully.');
    }

    /** Soft delete: fills deleted_at, row stays in the table. */
    public function destroy(DisclosureCategory $category): RedirectResponse
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        // If documents are linked, block the delete (enable once the relation exists):
        // if ($category->documents()->exists()) {
        //     return back()->with('error', 'This category has documents. Move them to another category first.');
        // }

        $category->delete();

        return redirect()
            ->route('admin.disclosure-categories', request()->only(['q', 'per_page', 'sort', 'dir']))
            ->with('success', 'Disclosure category removed.');
    }

    /** Bring a soft-deleted category back. */
    public function restore(int $id): RedirectResponse
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $category = DisclosureCategory::onlyTrashed()->findOrFail($id);

        $exists = DisclosureCategory::where('name', $category->name)->exists();
        if ($exists) {
            return back()->with('error', "An active category named \"{$category->name}\" already exists, so this one can't be restored.");
        }

        $category->restore();

        return redirect()
            ->route('admin.disclosure-categories', ['trashed' => 1])
            ->with('success', 'Disclosure category restored.');
    }
}
