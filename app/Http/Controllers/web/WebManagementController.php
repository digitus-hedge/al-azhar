<?php

namespace App\Http\Controllers\web;   // match your real folder name casing (web / Web)

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

        return view('web.school-management', [
            'leader'  => $members->first(),           // shown large at the top
            'members' => $members->slice(1)->values(),
        ]);
    }
}