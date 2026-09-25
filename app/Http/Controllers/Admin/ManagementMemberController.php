<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagementMemberRequest;
use App\Models\ManagementDesignation;
use App\Models\ManagementMember;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * School Management: committee, trustees and institutional leadership profiles.
 */
class ManagementMemberController extends Controller
{
    protected array $sortable = ['name', 'designation', 'sort_order', 'is_active', 'created_at'];

    protected array $perPageOptions = [10, 25, 50, 100];

    public function index(Request $request)
    {
        $search  = trim((string) $request->query('q', ''));
        $sortBy  = $request->query('sort', 'sort_order');
        $sortDir = strtolower((string) $request->query('dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $perPage = (int) $request->query('per_page', 10);

        if (! in_array($sortBy, $this->sortable, true)) {
            $sortBy = 'sort_order';
        }
        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        $query = ManagementMember::query()
            ->with('designation')
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('name', 'like', "%{$search}%")
                      ->orWhereHas('designation', fn ($d) => $d->where('name', 'like', "%{$search}%"));
                });
            });

        // "Designation" column sorts by the designation NAME (the column only holds the id)
        if ($sortBy === 'designation') {
            $query->orderBy(
                ManagementDesignation::withTrashed()->select('name')
                    ->whereColumn('management_designations.id', 'management_members.designation_id'),
                $sortDir
            );
        } else {
            $query->orderBy($sortBy, $sortDir);
        }

        $members = $query
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.school-management.index', [
            'members'        => $members,
            'search'         => $search,
            'sortBy'         => $sortBy,
            'sortDir'        => $sortDir,
            'perPage'        => $perPage,
            'perPageOptions' => $this->perPageOptions,
        ]);
    }

    public function create()
    {
        return view('admin.school-management.form', [
            'member'       => new ManagementMember(),
            'designations' => $this->designationOptions(),
        ]);
    }

    public function store(ManagementMemberRequest $request)
    {
        $data = $this->payload($request);
        $data['is_active'] = true; // new profiles are visible; hide them from the list toggle

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('management', 'public');
        }

        $member = ManagementMember::create($data);

        return $this->respond($request, 'Profile added successfully.', $member);
    }

    public function edit(ManagementMember $member)
    {
        return view('admin.school-management.form', [
            'member'       => $member,
            'designations' => $this->designationOptions($member),
        ]);
    }

    public function update(ManagementMemberRequest $request, ManagementMember $member)
    {
        $data = $this->payload($request); // is_active is not touched: the list toggle controls it

        if ($request->hasFile('photo')) {
            $this->deletePhoto($member->photo);
            $data['photo'] = $request->file('photo')->store('management', 'public');
        } elseif ($request->boolean('remove_photo')) {
            $this->deletePhoto($member->photo);
            $data['photo'] = null;
        }

        $member->update($data);

        return $this->respond($request, 'Profile updated successfully.', $member);
    }

    /** Soft delete. The photo is kept so the profile can be restored. */
    public function destroy(Request $request, ManagementMember $member)
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $member->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Profile removed successfully.']);
        }

        return redirect()
            ->route('admin.school-management', $request->only(['q', 'per_page', 'sort', 'dir']))
            ->with('success', 'Profile removed successfully.');
    }

    /** Show / hide on website (AJAX from the list). */
    public function toggle(ManagementMember $member)
    {
        $member->update(['is_active' => ! $member->is_active]);

        return response()->json([
            'message'   => $member->is_active ? 'Profile is now visible on the website.' : 'Profile hidden from the website.',
            'is_active' => $member->is_active,
        ]);
    }

    /* ---------- helpers ---------- */

    /** name, designation_id, bio + automatic order from the designation (Chairman first, ...). */
    private function payload(ManagementMemberRequest $request): array
    {
        $data = $request->safe()->only(['name', 'designation_id', 'bio']);

        $designationName    = ManagementDesignation::withTrashed()->whereKey($data['designation_id'])->value('name');
        $data['sort_order'] = ManagementMember::rankOf($designationName) + 1;

        return $data;
    }

    /** Active designations for the dropdown, plus the profile's current one if it was deleted later. */
       /**
     * Designations for the School Management dropdown:
     * only type = management and not deleted,
     * plus the profile's current one (so editing an old profile still shows its designation).
     */
    private function designationOptions(?ManagementMember $member = null): Collection
    {
        $current = $member?->designation_id;

        return ManagementDesignation::withTrashed()
            ->where(function ($q) use ($current) {
                $q->where(function ($w) {
                    $w->whereNull('deleted_at')
                      ->where('type', 'management');     // ← only Management designations
                });
                if ($current) {
                    $q->orWhere('id', $current);         // keep the saved one selectable on edit
                }
            })
            ->orderBy('name')
            ->get(['id', 'name', 'type', 'deleted_at']);
    }

    private function deletePhoto(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function respond(Request $request, string $message, ManagementMember $member)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message'  => $message,
                'member'   => $member,
                'redirect' => route('admin.school-management'),
            ]);
        }

        return redirect()->route('admin.school-management')->with('success', $message);
    }
}
