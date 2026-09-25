<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MandatoryDisclosure;
use Illuminate\View\View;

class WebMandatoryDisclosureController extends Controller
{
    public function index(): View
    {
        $documents = MandatoryDisclosure::query()
            ->whereNotNull('file')
            ->where('file', '!=', '')
            ->with('disclosureCategory')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        $groups = $documents
            ->groupBy(fn ($doc) => $doc->disclosureCategory?->name ?: 'Other Documents')
            ->sortKeys(SORT_NATURAL | SORT_FLAG_CASE);

        // Shown on the page only when APP_DEBUG=true and nothing is listed
        $debug = null;
        if (config('app.debug') && $documents->isEmpty()) {
            $debug = [
                'All documents (not deleted)' => MandatoryDisclosure::count(),
                'Marked Active'               => MandatoryDisclosure::where('is_active', 1)->count(),
                'Active with a file'          => MandatoryDisclosure::where('is_active', 1)->whereNotNull('file')->where('file', '!=', '')->count(),
                'Database'                    => config('database.connections.' . config('database.default') . '.database'),
            ];
        }

        return view('web.mandatory-disclosure', [
            'groups'      => $groups,
            'total'       => $documents->count(),
            'lastUpdated' => $documents->max('updated_at'),
            'debug'       => $debug,
        ]);
    }
}