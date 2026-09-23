<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Department;
use App\Models\Staff;
use App\Models\Stat;

class HomeController extends Controller
{
    /**
     * Show the public homepage: hero/banner, stats, departments and featured instructors.
     */
    public function index()
    {
        $banner = Banner::first();
        $stats  = Stat::first()?->items ?? [];

        // "Our Departments" section — active departments (max 8)
        $homeDepartments = Department::active()
            ->orderBy('name')
            ->take(8)
            ->get();

        // "Featured Instructor" section — staff ticked "Show on Home" in admin (max 4).
        // If nobody is ticked yet, fall back to the heads of department, then anyone.
        $featuredStaff = Staff::with('department')->shownOnHome()->ordered()->take(4)->get();

        if ($featuredStaff->isEmpty()) {
            $featuredStaff = Staff::with('department')
                ->orderByDesc('is_head_of_staff')
                ->ordered()
                ->take(4)
                ->get();
        }

        return view('web.home', compact('banner', 'stats', 'homeDepartments', 'featuredStaff'));
    }
}