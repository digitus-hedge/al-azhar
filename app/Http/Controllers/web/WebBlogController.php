<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WebBlogController extends Controller
{
    /**
     * GET /blogs — list of all published blog posts.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $blogs = Blog::query()
            ->active()
            ->published()
            ->when($search !== '', fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->latestFirst()
            ->paginate(9)
            ->withQueryString();

        $recent = Blog::active()->published()->latestFirst()->limit(4)->get();

        return view('web.blogs.index', compact('blogs', 'recent', 'search'));
    }

    /**
     * GET /blogs/{slug} — single blog detail page.
     */
    public function show(string $slug): View
    {
        $blog = Blog::active()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $recent = Blog::active()
            ->published()
            ->where('id', '!=', $blog->id)
            ->latestFirst()
            ->limit(5)
            ->get();

        $related = Blog::active()
            ->published()
            ->where('id', '!=', $blog->id)
            ->latestFirst()
            ->limit(3)
            ->get();

        return view('web.blogs.show', compact('blog', 'recent', 'related'));
    }
}