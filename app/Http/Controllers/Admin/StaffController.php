<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Columns that are allowed to be sorted on from the URL.
     */
    protected array $sortable = [
        'name', 'designation', 'department_id', 'is_head_of_staff', 'created_at',
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

        $query = Staff::query()->with('department');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhereHas('department', function ($dq) use ($search) {
                      $dq->where('name', 'like', "%{$search}%");
                  });
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
        $departments = Department::active()->get();
        $classes     = SchoolClass::active()->get();

        return view('admin.staff.form', compact('staffMember', 'departments', 'classes'));
    }

    /**
     * Store a newly created staff member.
     */
    public function store(StaffRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('staff', 'public');
        }

        $validated['is_head_of_staff'] = $request->boolean('is_head_of_staff');
        $validated['show_on_home']     = $request->boolean('show_on_home');
        $validated['has_login']        = $request->boolean('has_login');

        $loginEmail       = $validated['login_email'] ?? null;
        $loginPassword    = $validated['login_password'] ?? null;
        $loginRole        = $validated['login_role'] ?? 'staff';
        $loginPermissions = $validated['login_permissions'] ?? [];
        unset($validated['login_email'], $validated['login_password'], $validated['login_role'], $validated['login_permissions']);

        $staff = Staff::create($validated);

        $this->syncLoginAccount($staff, $validated['has_login'], $loginEmail, $loginPassword, $loginRole, $loginPermissions);

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
        $departments = Department::active()->get();
        $classes     = SchoolClass::active()->get();

        return view('admin.staff.form', compact('staffMember', 'departments', 'classes'));
    }

    /**
     * Update an existing staff member.
     */
    public function update(StaffRequest $request, Staff $staffMember)
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
        $validated['show_on_home']     = $request->boolean('show_on_home');
        $validated['has_login']        = $request->boolean('has_login');

        $loginEmail       = $validated['login_email'] ?? null;
        $loginPassword    = $validated['login_password'] ?? null;
        $loginRole        = $validated['login_role'] ?? 'staff';
        $loginPermissions = $validated['login_permissions'] ?? [];
        unset($validated['login_email'], $validated['login_password'], $validated['login_role'], $validated['login_permissions']);

        $staffMember->update($validated);

        $this->syncLoginAccount($staffMember, $validated['has_login'], $loginEmail, $loginPassword, $loginRole, $loginPermissions);

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

    /**
     * Create, update, or remove the login (users table) account tied to a
     * staff member, based on the "Login Access" toggle in the form —
     * including that account's role and, for a "staff" role, which
     * modules it's allowed into.
     *
     * - Toggle ON, no account yet  -> create a new User (name = staff name).
     * - Toggle ON, account exists  -> keep name/email/role/permissions in
     *                                 sync, update the password only if a
     *                                 new one was typed.
     * - Toggle OFF, account exists -> unlink and delete the User account.
     */
    protected function syncLoginAccount(
        Staff $staff,
        bool $hasLogin,
        ?string $email,
        ?string $password,
        string $role = 'staff',
        array $permissions = []
    ): void {
        // Only "staff" role users are restricted by the permission
        // checkboxes; an "admin" account ignores $permissions entirely.
        $permissions = $role === 'staff' ? array_values($permissions) : [];

        if ($hasLogin) {
            if ($staff->user_id) {
                $user = User::find($staff->user_id);
                if ($user) {
                    $user->name        = $staff->name;
                    $user->email       = $email;
                    $user->role        = $role;
                    $user->permissions = $permissions;
                    if ($password) {
                        $user->password = Hash::make($password);
                    }
                    $user->save();
                }
            } else {
                $user = User::create([
                    'name'        => $staff->name,
                    'email'       => $email,
                    'password'    => Hash::make($password),
                    'role'        => $role,
                    'permissions' => $permissions,
                ]);

                $staff->update(['user_id' => $user->id]);
            }
        } elseif ($staff->user_id) {
            $userId = $staff->user_id;
            $staff->update(['user_id' => null]);
            User::whereKey($userId)->delete();
        }
    }
}
