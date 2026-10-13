<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerRequest;
use App\Models\Career;
use Illuminate\Http\Request;

/**
 * File: app/Http/Controllers/Admin/CareerController.php
 */
class CareerController extends Controller
{
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

        $allowedSorts = ['title', 'sort_order', 'created_at'];
        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'sort_order';
        }

        $items = Career::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.careers.index', compact(
            'items', 'search', 'sortBy', 'sortDir', 'perPage', 'perPageOptions'
        ));
    }

    public function create()
    {
        $item = new Career([
            'is_active'  => true,
            'sort_order' => 0,
        ]);

        return view('admin.careers.form', compact('item'));
    }

    public function store(CareerRequest $request)
    {
        Career::create($request->validated());

        return redirect()
            ->route('admin.careers')
            ->with('success', 'Career created successfully.');
    }

    public function edit(Career $career)
    {
        $item = $career;
        return view('admin.careers.form', compact('item'));
    }

    public function update(CareerRequest $request, Career $career)
    {
        $career->update($request->validated());

        return redirect()
            ->route('admin.careers')
            ->with('success', 'Career updated successfully.');
    }

    public function destroy(Career $career)
    {
        $career->delete();

        return redirect()
            ->route('admin.careers')
            ->with('success', 'Career deleted successfully.');
    }
}
