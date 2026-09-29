<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Staff;
use Illuminate\Support\Collection;
use Illuminate\View\View;

/**
 * Public (website) departments page.
 *
 * Shows two sections built from the staff "head_type" field:
 *   HOD = Head of Department
 *   HOS = Head of Staff
 * Ordinary staff (head_type = null) are not shown.
 *
 * The admin CRUD stays in App\Http\Controllers\Admin\DepartmentController;
 * this controller only reads data for visitors.
 * Both methods use the same view: resources/views/web/department.blade.php
 */
class DepartmentController extends Controller
{
    /**
     * /departments — all HODs and HOSs across the school.
     */
    public function index(): View
    {
        return view('web.department', [
            'pageName'   => 'Our Departments',
            'department' => null,
            'groups'     => $this->headGroups(),
        ]);
    }

    /**
     * /departments/{department} — the HOD / HOS of one department.
     */
    public function show(Department $department): View
    {
        return view('web.department', [
            'pageName'   => $department->name,
            'department' => $department,
            'groups'     => $this->headGroups($department->id),
        ]);
    }

    /**
     * Staff with a head type, grouped as HOD then HOS.
     * Each group: ['key' => 'HOD', 'label' => 'Head of Department', 'people' => Collection]
     */
    protected function headGroups(?int $departmentId = null): Collection
    {
        $heads = Staff::query()
            ->whereIn('head_type', array_keys(Staff::HEAD_TYPES))
            ->when($departmentId, fn ($q) => $q->where('department_id', $departmentId))
            ->with(['staffDesignation', 'department'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return collect(Staff::HEAD_TYPES)
            ->map(fn ($label, $key) => [
                'key'    => $key,
                'label'  => $label,
                'people' => $heads->where('head_type', $key)->values(),
            ])
            ->values();
    }
}