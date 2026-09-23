<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\View\View;

/**
 * Public (website) departments page.
 *
 * The admin CRUD stays in App\Http\Controllers\Admin\DepartmentController;
 * this controller only reads data for visitors.
 * Both methods use the same view: resources/views/web/department.blade.php
 */
class DepartmentController extends Controller
{
    /**
     * How many members (besides the head) to show per department
     * on the listing page. "View All" shows everyone.
     */
    protected int $membersPerDepartment = 6;

    /**
     * /departments — every active department with its head + a few members.
     */
    public function index(): View
    {
        $departments = Department::active()
            ->with(['staff' => fn ($q) => $this->orderStaff($q)])
            ->get()
            // hide departments that have nobody assigned yet
            ->filter(fn (Department $department) => $department->staff->isNotEmpty())
            ->values();

        return view('web.department', [
            'departments' => $departments,
            'limit'       => $this->membersPerDepartment,
        ]);
    }

    /**
     * /departments/{department} — one department with all of its staff.
     */
    public function show(Department $department): View
    {
        $department->load(['staff' => fn ($q) => $this->orderStaff($q)]);

        return view('web.department', [
            'departments' => collect([$department]),
            'limit'       => null, // null = show everyone
        ]);
    }

    /**
     * Head of department first, then the admin's sort order, then name.
     */
    protected function orderStaff($query)
    {
        return $query
            ->orderByDesc('is_head_of_staff')
            ->orderBy('sort_order')
            ->orderBy('name');
    }
}