<?php

namespace App\Http\Controllers\Web;   // match your real folder name casing (web / Web)

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WebFacilityController extends Controller
{
    /**
     * All active facilities with category tabs.
     * ?category=lab opens that tab directly.
     */
    public function index(Request $request): View
    {
        $facilities = Facility::active()->get();

        $counts = $facilities->countBy('category');

        $active = (string) $request->query('category', '');
        if (! array_key_exists($active, Facility::CATEGORIES) || ! $counts->has($active)) {
            $active = '';
        }

        return view('web.facility-card', [
            'facilities' => $facilities,
            'categories' => Facility::CATEGORIES,
            'counts'     => $counts,
            'active'     => $active,
        ]);
    }

    /**
     * Single facility (looked up by slug).
     */
    public function show(Facility $facility): View
    {
        abort_unless($facility->is_active, 404);

        // Same-category facilities first, then others
        $related = Facility::query()
            ->where('is_active', true)
            ->whereKeyNot($facility->getKey())
            ->orderByRaw('category = ? DESC', [$facility->category])
            ->orderBy('sort_order')
            ->orderBy('title')
            ->limit(4)
            ->get();

        return view('web.facility-details', compact('facility', 'related'));
    }
}