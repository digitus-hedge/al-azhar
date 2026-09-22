<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request; // add this import if not already present

class DepartmentController extends Controller
{
    /**
     * Listing page.
     */
    protected array $sortable = ['name', 'created_at'];
 
/**
 * Allowed "per page" choices for the listing.
 */
protected array $perPageOptions = [5, 10, 25, 50, 100];
 
/**
 * Listing page — search, sort, per-page.
 */
public function index(Request $request): View
{
    $search  = trim((string) $request->query('q', ''));
    $sortBy  = $request->query('sort', 'name');
    $sortDir = strtolower($request->query('dir', 'asc')) === 'desc' ? 'desc' : 'asc';
    $perPage = (int) $request->query('per_page', 10);
 
    if (! in_array($sortBy, $this->sortable, true)) {
        $sortBy = 'name';
    }
 
    if (! in_array($perPage, $this->perPageOptions, true)) {
        $perPage = 10;
    }
 
    $query = Department::query();
 
    if ($search !== '') {
        $query->where('name', 'like', "%{$search}%");
    }
 
    $query->orderBy($sortBy, $sortDir);
    if ($sortBy !== 'name') {
        $query->orderBy('name');
    }
 
    $items = $query->paginate($perPage)->appends($request->query());
 
    return view('admin.departments.index', [
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
        $item = new Department();

        return view('admin.departments.form', compact('item'));
    }

    /**
     * Store a newly created department.
     */
    public function store(DepartmentRequest $request): JsonResponse|RedirectResponse
    {
        Department::create($request->validated());

        $message = 'Department created successfully.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('admin.departments')->with('success', $message);
    }

    /**
     * Show the edit form.
     */
    public function edit(Department $department): View
    {
        $item = $department;

        return view('admin.departments.form', compact('item'));
    }

    /**
     * Update the specified department.
     */
    public function update(DepartmentRequest $request, Department $department): JsonResponse|RedirectResponse
    {
        $department->update($request->validated());

        $message = 'Department updated successfully.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('admin.departments')->with('success', $message);
    }

    /**
     * Remove the specified department.
     */
    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();

        return redirect()
            ->route('admin.departments')
            ->with('success', 'Department deleted.');
    }
}
