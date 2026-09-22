<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolClassRequest;
use App\Models\Department;
use App\Models\SchoolClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request; 

class ClassController extends Controller
{
    /**
     * Listing page.
     */
  protected array $sortable = ['name', 'department', 'created_at'];
 
/**
 * Allowed "per page" choices for the listing.
 */
protected array $perPageOptions = [5, 10, 25, 50, 100];
 
/**
 * Listing page — search, department filter, sort, per-page.
 */
public function index(Request $request): View
{
    $search       = trim((string) $request->query('q', ''));
    $departmentId = $request->query('department_id', '');
    $sortBy       = $request->query('sort', 'name');
    $sortDir      = strtolower($request->query('dir', 'asc')) === 'desc' ? 'desc' : 'asc';
    $perPage      = (int) $request->query('per_page', 10);
 
    if (! in_array($sortBy, $this->sortable, true)) {
        $sortBy = 'name';
    }
 
    if (! in_array($perPage, $this->perPageOptions, true)) {
        $perPage = 10;
    }
 
    $query = SchoolClass::query()->with('department');
 
    if ($search !== '') {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhereHas('department', function ($dq) use ($search) {
                  $dq->where('name', 'like', "%{$search}%");
              });
        });
    }
 
    if ($departmentId !== '') {
        $query->where('department_id', $departmentId);
    }
 
    if ($sortBy === 'department') {
        $query->select('classes.*')
              ->leftJoin('departments', 'departments.id', '=', 'classes.department_id')
              ->orderBy('departments.name', $sortDir);
    } else {
        $query->orderBy($sortBy, $sortDir);
    }
 
    if ($sortBy !== 'name') {
        $query->orderBy('classes.name');
    }
 
    $items = $query->paginate($perPage)->appends($request->query());
 
    return view('admin.classes.index', [
        'items'          => $items,
        'departments'    => Department::orderBy('name')->get(),
        'search'         => $search,
        'departmentId'   => $departmentId,
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
        $item = new SchoolClass();
        $departments = Department::active()->get();

        return view('admin.classes.form', compact('item', 'departments'));
    }

    /**
     * Store a newly created class.
     */
    public function store(SchoolClassRequest $request): JsonResponse|RedirectResponse
    {
        SchoolClass::create($request->validated());

        $message = 'Class created successfully.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('admin.classes')->with('success', $message);
    }

    /**
     * Show the edit form.
     */
    public function edit(SchoolClass $class): View
    {
        $item = $class;
        $departments = Department::active()->get();

        return view('admin.classes.form', compact('item', 'departments'));
    }

    /**
     * Update the specified class.
     */
    public function update(SchoolClassRequest $request, SchoolClass $class): JsonResponse|RedirectResponse
    {
        $class->update($request->validated());

        $message = 'Class updated successfully.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('admin.classes')->with('success', $message);
    }

    /**
     * Remove the specified class.
     */
    public function destroy(SchoolClass $class): RedirectResponse
    {
        $class->delete();

        return redirect()
            ->route('admin.classes')
            ->with('success', 'Class deleted.');
    }
}
