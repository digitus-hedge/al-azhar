<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * File: app/Http/Controllers/Admin/BlogController.php
 */
class BlogController extends Controller
{
    protected array $sortable = ['title', 'published_at', 'sort_order', 'created_at'];
    protected array $perPageOptions = [10, 25, 50, 100];

    public function index(Request $request)
    {
        $search  = trim((string) $request->query('q', ''));
        $sortBy  = $request->query('sort', 'published_at');
        $sortDir = strtolower($request->query('dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        $perPage = (int) $request->query('per_page', 10);

        if (!in_array($sortBy, $this->sortable, true)) {
            $sortBy = 'published_at';
            $sortDir = 'desc';
        }
        if (!in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        $items = Blog::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDir)
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.blogs.index', [
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
        $item = new Blog([
            'is_active'    => true,
            'sort_order'   => 0,
            'published_at' => now(),
        ]);

        return view('admin.blogs.form', compact('item'));
    }

    public function store(BlogRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        unset($data['remove_image']);

        Blog::create($data);

        return redirect()
            ->route('admin.blogs')
            ->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        $item = $blog;
        return view('admin.blogs.form', compact('item'));
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $data['image'] = $request->file('image')->store('blogs', 'public');
        } elseif ($request->boolean('remove_image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $data['image'] = null;
        }

        unset($data['remove_image']);

        $blog->update($data);

        return redirect()
            ->route('admin.blogs')
            ->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()
            ->route('admin.blogs')
            ->with('success', 'Blog deleted successfully.');
    }
}
