<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurriculumRequest;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * File: app/Http/Controllers/Admin/CurriculumController.php
 */
class CurriculumController extends Controller
{
    protected array $sortable = ['title', 'created_at'];
    protected array $perPageOptions = [10, 25, 50, 100];

    public function index(Request $request)
    {
        $search  = trim((string) $request->query('q', ''));
        $sortBy  = $request->query('sort', 'created_at');
        $sortDir = strtolower($request->query('dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        $perPage = (int) $request->query('per_page', 10);

        if (!in_array($sortBy, $this->sortable, true)) {
            $sortBy  = 'created_at';
            $sortDir = 'desc';
        }
        if (!in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        $items = Curriculum::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDir)
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.curriculums.index', [
            'items'          => $items,
            'search'         => $search,
            'sortBy'         => $sortBy,
            'sortDir'        => $sortDir,
            'perPage'        => $perPage,
            'perPageOptions' => $this->perPageOptions,
        ]);
    }

    public function create()
    {
        $item = new Curriculum([
            'is_active' => true,
        ]);

        return view('admin.curriculums.form', compact('item'));
    }

    public function store(CurriculumRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('curriculums', 'public');
        }

        unset($data['remove_image']);

        Curriculum::create($data);

        return redirect()
            ->route('admin.curriculums')
            ->with('success', 'Curriculum created successfully.');
    }

    public function edit(Curriculum $curriculum)
    {
        $item = $curriculum;
        return view('admin.curriculums.form', compact('item'));
    }

    public function update(CurriculumRequest $request, Curriculum $curriculum)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($curriculum->image) {
                Storage::disk('public')->delete($curriculum->image);
            }
            $data['image'] = $request->file('image')->store('curriculums', 'public');
        } elseif ($request->boolean('remove_image')) {
            if ($curriculum->image) {
                Storage::disk('public')->delete($curriculum->image);
            }
            $data['image'] = null;
        }

        unset($data['remove_image']);

        $curriculum->update($data);

        return redirect()
            ->route('admin.curriculums')
            ->with('success', 'Curriculum updated successfully.');
    }

    public function destroy(Curriculum $curriculum)
    {
        if ($curriculum->image) {
            Storage::disk('public')->delete($curriculum->image);
        }

        $curriculum->delete();

        return redirect()
            ->route('admin.curriculums')
            ->with('success', 'Curriculum deleted successfully.');
    }
}
