<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicRequest;
use App\Models\Academic;
use Illuminate\Http\Request;

/**
 * File: app/Http/Controllers/Admin/AcademicController.php
 *
 * Handles CRUD for Academic levels shown on the website.
 */
class AcademicController extends Controller
{
    /**
     * List academics with search, sort, pagination.
     * Route: GET  /admin/academics            name: admin.academics
     */
    public function index(Request $request)
    {
        $search  = trim((string) $request->get('q', ''));
        $sortBy  = $request->get('sort', 'sort_order');
        $sortDir = $request->get('dir', 'asc') === 'desc' ? 'desc' : 'asc';
        $perPage = (int) $request->get('per_page', 10);

        $perPageOptions = [10, 25, 50, 100];
        if (!in_array($perPage, $perPageOptions, true)) {
            $perPage = 10;
        }

        $allowedSorts = ['name', 'sort_order', 'created_at'];
        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'sort_order';
        }

        $items = Academic::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('name', 'like', "%{$search}%")
                       ->orWhere('subtitle', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.academics.index', compact(
            'items', 'search', 'sortBy', 'sortDir', 'perPage', 'perPageOptions'
        ));
    }

    /**
     * Show form to create a new academic.
     * Route: GET  /admin/academics/create     name: admin.academics.create
     */
    public function create()
    {
        $item = new Academic([
            'is_active'  => true,
            'sort_order' => 0,
        ]);

        return view('admin.academics.form', compact('item'));
    }

    /**
     * Store a newly created academic.
     * Route: POST /admin/academics            name: admin.academics.store
     */
    public function store(AcademicRequest $request)
    {
        Academic::create($request->validated());

        return redirect()
            ->route('admin.academics')
            ->with('success', 'Academic level created successfully.');
    }

    /**
     * Show form to edit an academic.
     * Route: GET  /admin/academics/{academic}/edit    name: admin.academics.edit
     */
    public function edit(Academic $academic)
    {
        $item = $academic;
        return view('admin.academics.form', compact('item'));
    }

    /**
     * Update an existing academic.
     * Route: PUT  /admin/academics/{academic}         name: admin.academics.update
     */
    public function update(AcademicRequest $request, Academic $academic)
    {
        $academic->update($request->validated());

        return redirect()
            ->route('admin.academics')
            ->with('success', 'Academic level updated successfully.');
    }

    /**
     * Delete an academic.
     * Route: DELETE /admin/academics/{academic}       name: admin.academics.destroy
     */
    public function destroy(Academic $academic)
    {
        $academic->delete();

        return redirect()
            ->route('admin.academics')
            ->with('success', 'Academic level deleted successfully.');
    }
}
