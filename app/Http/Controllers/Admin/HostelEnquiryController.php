<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HostelApplication;
use Illuminate\Http\Request;

/**
 * File: app/Http/Controllers/Admin/HostelEnquiryController.php
 *
 * Listing + view only (plus optional status/notes update + delete).
 */
class HostelEnquiryController extends Controller
{
    public function index(Request $request)
    {
        $search   = trim((string) $request->get('q', ''));
        $status   = $request->get('status', '');
        $gender   = $request->get('gender', '');
        $sortBy   = $request->get('sort', 'created_at');
        $sortDir  = $request->get('dir', 'desc') === 'asc' ? 'asc' : 'desc';
        $perPage  = (int) $request->get('per_page', 10);

        $perPageOptions = [10, 25, 50, 100];
        if (!in_array($perPage, $perPageOptions, true)) {
            $perPage = 10;
        }

        $allowedSorts = ['student_name', 'age', 'parent_name', 'status', 'created_at'];
        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'created_at';
        }

        $items = HostelApplication::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('student_name', 'like', "%{$search}%")
                       ->orWhere('parent_name', 'like', "%{$search}%")
                       ->orWhere('parent_phone', 'like', "%{$search}%")
                       ->orWhere('parent_email', 'like', "%{$search}%")
                       ->orWhere('class_name_snapshot', 'like', "%{$search}%");
                });
            })
            ->when(filled($status), fn ($q) => $q->where('status', $status))
            ->when(filled($gender), fn ($q) => $q->where('gender', $gender))
            ->orderBy($sortBy, $sortDir)
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        $statuses = HostelApplication::STATUSES;

        return view('admin.hostel-enquiries.index', compact(
            'items', 'search', 'status', 'gender',
            'sortBy', 'sortDir', 'perPage', 'perPageOptions', 'statuses'
        ));
    }

    public function show(HostelApplication $hostelEnquiry)
    {
        $statuses = HostelApplication::STATUSES;

        return view('admin.hostel-enquiries.show', [
            'item'     => $hostelEnquiry,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Update status + admin_notes (used on the show page).
     */
    public function updateStatus(Request $request, HostelApplication $hostelEnquiry)
    {
        $data = $request->validate([
            'status'      => ['required', 'in:' . implode(',', array_keys(HostelApplication::STATUSES))],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $hostelEnquiry->update($data);

        return back()->with('success', 'Hostel enquiry updated.');
    }

    public function destroy(HostelApplication $hostelEnquiry)
    {
        $hostelEnquiry->delete();

        return redirect()
            ->route('admin.hostel-enquiries')
            ->with('success', 'Hostel enquiry deleted.');
    }
}
