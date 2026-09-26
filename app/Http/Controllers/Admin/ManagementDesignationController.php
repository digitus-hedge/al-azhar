<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagementDesignationRequest;
use App\Models\ManagementDesignation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Master > Designations
 * One list for both forms, split by type:
 *   - management → School Management profile form (Chairman, Secretary, Trustee, ...)
 *   - staff      → Staff form (Principal, PGT, TGT, Librarian, ...)
 * Delete is a soft delete (deleted_at), so it can be restored from "Trash".
 */
class ManagementDesignationController extends Controller
{
    protected array $perPageOptions = [10, 25, 50, 100];

    protected array $sortable = ['name', 'type', 'created_at', 'updated_at'];

    public function index(Request $request): View
    {
        $search  = trim((string) $request->query('q', ''));
        $trashed = $request->boolean('trashed');

        // Type filter tabs: All / Management / Staff
        $type = $request->query('type');
        $type = array_key_exists((string) $type, ManagementDesignation::TYPES) ? $type : null;

        $sortBy = $request->query('sort', 'name');
        if (! in_array($sortBy, $this->sortable, true)) {
            $sortBy = 'name';
        }
        $sortDir = $request->query('dir') === 'desc' ? 'desc' : 'asc';

        $perPage = (int) $request->query('per_page', 10);
        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        $designations = ManagementDesignation::query()
            ->when($trashed, fn($q) => $q->onlyTrashed())
            ->ofType($type)
            ->search($search)
            ->orderBy($sortBy, $sortDir)
            ->orderBy('id')
            ->paginate($perPage)
            ->withQueryString();

        // How many School Management profiles / Staff use each designation (shown in the list)
        $designations->getCollection()->loadCount(['members', 'staff']);

        // Counts for the type tabs (respecting the Active / Trash view)
        $typeCounts = ManagementDesignation::query()
            ->when($trashed, fn($q) => $q->onlyTrashed())
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        return view('admin.designations.index', [
            'designations'   => $designations,
            'search'         => $search,
            'trashed'        => $trashed,
            'type'           => $type,
            'types'          => ManagementDesignation::TYPES,
            'typeCounts'     => $typeCounts,
            'sortBy'         => $sortBy,
            'sortDir'        => $sortDir,
            'perPage'        => $perPage,
            'perPageOptions' => $this->perPageOptions,
            'activeCount'    => ManagementDesignation::count(),
            'trashedCount'   => ManagementDesignation::onlyTrashed()->count(),
        ]);
    }

    public function create(Request $request): View
    {
        // Pre-select the type when coming from a filtered tab (?type=staff)

        // $type = array_key_exists((string) $request->query('type'), ManagementDesignation::TYPES)
        //     ? $request->query('type')
        //     : 'management';

        // return view('admin.designations.form', [
        //     'designation' => new ManagementDesignation(['type' => $type]),
        // ]);

        $type = array_key_exists((string) $request->query('type'), ManagementDesignation::TYPES)
            ? $request->query('type')
            : null;

        return view('admin.designations.form', [
            'designation' => new ManagementDesignation(['type' => $type]),
        ]);
    }

    public function store(ManagementDesignationRequest $request): RedirectResponse
    {
        $designation = ManagementDesignation::create($request->validated()); // name + type

        if ($request->input('action') === 'save_new') {
            return redirect()
                ->route('admin.designations.create', ['type' => $designation->type])
                ->with('success', 'Designation added. You can add another one.');
        }

        return redirect()
            ->route('admin.designations', ['type' => $designation->type])
            ->with('success', $designation->type_label . ' added successfully.');
    }

    public function edit(ManagementDesignation $designation): View
    {
        return view('admin.designations.form', [
            'designation' => $designation,
        ]);
    }

    public function update(ManagementDesignationRequest $request, ManagementDesignation $designation): RedirectResponse
    {
        // Type change while in use is blocked in ManagementDesignationRequest::after()
        $designation->update($request->validated());

        return redirect()
            ->route('admin.designations', ['type' => $designation->type])
            ->with('success', 'Designation updated successfully.');
    }

    /** Soft delete: fills deleted_at, row stays in the table. */
    public function destroy(ManagementDesignation $designation): RedirectResponse
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        // Block the delete while School Management profiles or Staff still use this designation
        if ($designation->members()->exists()) {
            return back()->with('error', 'This designation is used by School Management profiles. Change those profiles first.');
        }
        if ($designation->staff()->exists()) {
            return back()->with('error', 'This designation is used by staff members. Change those staff first.');
        }

        $designation->delete();

        return redirect()
            ->route('admin.designations', request()->only(['q', 'type', 'per_page', 'sort', 'dir']))
            ->with('success', 'Designation removed.');
    }

    /** Bring a soft-deleted designation back. */
    public function restore(int $id): RedirectResponse
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $designation = ManagementDesignation::onlyTrashed()->findOrFail($id);

        // Only a clash within the SAME type blocks the restore
        $exists = ManagementDesignation::where('name', $designation->name)
            ->where('type', $designation->type)
            ->exists();

        if ($exists) {
            return back()->with('error', "An active {$designation->type_label} named \"{$designation->name}\" already exists, so this one can't be restored.");
        }

        $designation->restore();

        return redirect()
            ->route('admin.designations', ['trashed' => 1, 'type' => $designation->type])
            ->with('success', 'Designation restored.');
    }
}
