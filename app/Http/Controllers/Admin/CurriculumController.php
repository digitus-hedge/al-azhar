<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurriculumRequest;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            'images'    => [],
        ]);

        return view('admin.curriculums.form', compact('item'));
    }

    public function store(CurriculumRequest $request)
    {
        $data = $request->validated();

        // Upload any new images and build the images array
        $uploaded = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $uploaded[] = $file->store('curriculums', 'public');
                }
            }
        }

        // Clean up non-column fields before saving
        unset($data['removed_images'], $data['images']);

        // Create the row first, then force-set images with a separate update
        // so a missing `$fillable` or wrong `$casts` can be spotted easily.
        $curriculum = Curriculum::create($data);

        $curriculum->images = $uploaded;
        $curriculum->save();

        Log::info('Curriculum created', [
            'id'            => $curriculum->id,
            'images_count'  => count($uploaded),
            'images_saved'  => $curriculum->fresh()->images,
        ]);

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

        // Start with the images already saved on the record
        $existing = is_array($curriculum->images) ? $curriculum->images : [];

        // Remove any images the user chose to delete (sent as JSON in `removed_images`)
        $removed = json_decode($request->input('removed_images', '[]'), true) ?: [];
        if (!empty($removed)) {
            foreach ($removed as $path) {
                if (in_array($path, $existing, true)) {
                    Storage::disk('public')->delete($path);
                }
            }
            $existing = array_values(array_diff($existing, $removed));
        }

        // Append any newly uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $existing[] = $file->store('curriculums', 'public');
                }
            }
        }

        // Clean up before saving
        unset($data['removed_images'], $data['images']);

        $curriculum->update($data);

        // Force-set the images column separately so fillable/cast issues become obvious
        $curriculum->images = $existing;
        $curriculum->save();

        Log::info('Curriculum updated', [
            'id'            => $curriculum->id,
            'images_count'  => count($existing),
            'images_saved'  => $curriculum->fresh()->images,
        ]);

        return redirect()
            ->route('admin.curriculums')
            ->with('success', 'Curriculum updated successfully.');
    }

    public function destroy(Curriculum $curriculum)
    {
        // Delete all images belonging to this record
        if (is_array($curriculum->images)) {
            foreach ($curriculum->images as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $curriculum->delete();

        return redirect()
            ->route('admin.curriculums')
            ->with('success', 'Curriculum deleted successfully.');
    }
}