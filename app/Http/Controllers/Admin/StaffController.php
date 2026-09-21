<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Columns that are allowed to be sorted on from the URL.
     */
    protected array $sortable = [
        'name', 'designation', 'department', 'is_head_of_staff', 'created_at',
    ];

    /**
     * Allowed "per page" choices for the listing.
     */
    protected array $perPageOptions = [5, 10, 25, 50, 100];

    /**
     * Display a listing of staff members.
     */
    public function index(Request $request)
    {
        $search  = trim((string) $request->query('q', ''));
        $sortBy  = $request->query('sort', 'sort_order');
        $sortDir = strtolower($request->query('dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $perPage = (int) $request->query('per_page', 5);

        if (! in_array($sortBy, $this->sortable, true)) {
            $sortBy = 'sort_order';
        }

        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 5;
        }

        $query = Staff::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        $query->orderBy($sortBy, $sortDir);
        if ($sortBy !== 'name') {
            $query->orderBy('name');
        }

        $staff = $query->paginate($perPage)->appends($request->query());

        return view('admin.staff.index', [
            'staff'          => $staff,
            'search'         => $search,
            'sortBy'         => $sortBy,
            'sortDir'        => $sortDir,
            'perPage'        => $perPage,
            'perPageOptions' => $this->perPageOptions,
        ]);
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create()
    {
        $staffMember = new Staff();

        return view('admin.staff.form', compact('staffMember'));
    }

    /**
     * Store a newly created staff member.
     */
    public function store(StoreStaffRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('staff', 'public');
        }

        $validated['is_head_of_staff'] = $request->boolean('is_head_of_staff');

        $staff = Staff::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Staff member added successfully.',
                'staff'   => $staff,
            ]);
        }

        return redirect()
            ->route('admin.staff')
            ->with('success', 'Staff member added successfully.');
    }

    /**
     * Show the form for editing a staff member.
     */
    public function edit(Staff $staffMember)
    {
        return view('admin.staff.form', compact('staffMember'));
    }

    /**
     * Update an existing staff member.
     */
    public function update(UpdateStaffRequest $request, Staff $staffMember)
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            if ($staffMember->photo) {
                Storage::disk('public')->delete($staffMember->photo);
            }
            $validated['photo'] = $request->file('photo')->store('staff', 'public');
        } elseif ($request->boolean('remove_photo')) {
            if ($staffMember->photo) {
                Storage::disk('public')->delete($staffMember->photo);
            }
            $validated['photo'] = null;
        }

        $validated['is_head_of_staff'] = $request->boolean('is_head_of_staff');

        $staffMember->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Staff member updated successfully.',
                'staff'   => $staffMember,
            ]);
        }

        return redirect()
            ->route('admin.staff')
            ->with('success', 'Staff member updated successfully.');
    }

    /**
     * Soft delete a staff member.
     */
    public function destroy(Request $request, Staff $staffMember)
    {
        $staffMember->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Staff member removed successfully.']);
        }

        return redirect()
            ->route('admin.staff')
            ->with('success', 'Staff member removed successfully.');
    }
}
