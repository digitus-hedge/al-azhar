<?php

namespace App\Http\Controllers\Web;   // match your real folder name casing (web / Web)

use App\Http\Controllers\Controller;
use App\Models\ManagementMember;
use Illuminate\View\View;

class WebManagementController extends Controller
{
    /**
     * Public School Management page.
     * Profiles switched "visible on website" in admin, in designation order
     * (Chairman first, ...) — sort_order is set automatically from the designation.
     */
   public function index(): View
    {
        $members = ManagementMember::query()
            ->with('designation')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Pick the Chairman and Manager (case-insensitive, matches the designation name).
        $chairman = $members->first(fn ($m) => strcasecmp(trim((string) $m->designation?->name), 'Chairman') === 0);
        $manager  = $members->first(fn ($m) => strcasecmp(trim((string) $m->designation?->name), 'Manager')  === 0);

        // Build the leaders collection in the required order: Chairman, Manager.
        $leaders = collect([$chairman, $manager])->filter()->values();

        // Remove the chosen leaders from the rest.
        $leaderIds = $leaders->pluck('id');
        $others    = $members->reject(fn ($m) => $leaderIds->contains($m->id))->values();

        return view('web.school-management', [
            'leaders' => $leaders,   // Chairman + Manager, side-by-side at the top
            'members' => $others,    // everyone else as cards below
        ]);
    }
}