<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionEnquiry;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdmissionEnquiryController extends Controller
{
    protected array $sortable = [
        'created_at', 'student_name', 'parent_name', 'grade', 'status', 'needs_hostel',
    ];

    protected array $perPageOptions = [10, 25, 50, 100];

    /**
     * List with status tabs, search, filters, sort, per-page.
     */
    public function index(Request $request): View
    {
        $filters = $this->filters($request);
        $sortBy  = in_array($request->query('sort'), $this->sortable, true) ? $request->query('sort') : 'created_at';
        $sortDir = strtolower((string) $request->query('dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        $perPage = (int) $request->query('per_page', 25);
        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 25;
        }

        $enquiries = AdmissionEnquiry::query()
            ->filter($filters)
            ->orderBy($sortBy, $sortDir)
            ->orderByDesc('id')
            ->paginate($perPage)
            ->appends($request->query());

        // Tab counts ignore the status filter itself so every tab shows its own number
        $counts = AdmissionEnquiry::query()
            ->filter(array_merge($filters, ['status' => null]))
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $grades = AdmissionEnquiry::query()
            ->whereNotNull('grade')
            ->distinct()
            ->orderBy('grade')
            ->pluck('grade');

        return view('admin.admission-enquiries.index', [
            'enquiries'      => $enquiries,
            'filters'        => $filters,
            'counts'         => $counts,
            'totalCount'     => $counts->sum(),
            'statuses'       => AdmissionEnquiry::STATUSES,
            'grades'         => $grades,
            'sortBy'         => $sortBy,
            'sortDir'        => $sortDir,
            'perPage'        => $perPage,
            'perPageOptions' => $this->perPageOptions,
            'hasFilters'     => collect($filters)->except('status')->filter(fn ($v) => $v !== null)->isNotEmpty(),
        ]);
    }

    public function show(AdmissionEnquiry $admissionEnquiry): View
    {
        $enquiry = $admissionEnquiry;

        // Previous enquiries from the same parent (by phone or email)
        $related = AdmissionEnquiry::query()
            ->where('id', '!=', $enquiry->id)
            ->where(function ($q) use ($enquiry) {
                $q->where('parent_phone', $enquiry->parent_phone);
                if ($enquiry->parent_email) {
                    $q->orWhere('parent_email', $enquiry->parent_email);
                }
            })
            ->latest()
            ->limit(10)
            ->get();

        $prevId = AdmissionEnquiry::where('id', '<', $enquiry->id)->max('id');
        $nextId = AdmissionEnquiry::where('id', '>', $enquiry->id)->min('id');

        return view('admin.admission-enquiries.show', [
            'enquiry'  => $enquiry,
            'related'  => $related,
            'statuses' => AdmissionEnquiry::STATUSES,
            'prevId'   => $prevId,
            'nextId'   => $nextId,
        ]);
    }

    /**
     * Change status and/or save admin notes.
     */
    public function update(Request $request, AdmissionEnquiry $admissionEnquiry): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'status'      => ['required', Rule::in(array_keys(AdmissionEnquiry::STATUSES))],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ], [
            'status.required' => 'Please choose a status.',
            'status.in'       => 'Please choose a valid status.',
        ]);

        // First time it leaves "new", remember when the parent was contacted
        if ($data['status'] !== 'new' && ! $admissionEnquiry->contacted_at) {
            $data['contacted_at'] = now();
        }

        $admissionEnquiry->update($data);

        $message = 'Enquiry updated.';

        if ($request->wantsJson()) {
            return response()->json([
                'message' => $message,
                'status'  => $admissionEnquiry->status,
                'label'   => $admissionEnquiry->status_label,
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Quick status change from the list (one click).
     */
    public function updateStatus(Request $request, AdmissionEnquiry $admissionEnquiry): JsonResponse|RedirectResponse
    {
        $status = $request->validate([
            'status' => ['required', Rule::in(array_keys(AdmissionEnquiry::STATUSES))],
        ])['status'];

        $data = ['status' => $status];
        if ($status !== 'new' && ! $admissionEnquiry->contacted_at) {
            $data['contacted_at'] = now();
        }

        $admissionEnquiry->update($data);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Status changed to ' . $admissionEnquiry->status_label . '.']);
        }

        return back()->with('success', 'Status changed to ' . $admissionEnquiry->status_label . '.');
    }

    /**
     * Soft delete — admins only.
     */
    public function destroy(AdmissionEnquiry $admissionEnquiry): RedirectResponse
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Only admins can delete enquiries.');
        }

        $admissionEnquiry->delete();

        return redirect()
            ->route('admin.admission-enquiries')
            ->with('success', 'Enquiry deleted.');
    }

    /**
     * CSV of the currently filtered list.
     */
    public function export(Request $request): StreamedResponse
    {
        $filters  = $this->filters($request);
        $filename = 'admission-enquiries-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($filters) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel

            fputcsv($out, [
                'ID', 'Received On', 'Student Name', 'Parent Name', 'Phone / WhatsApp', 'Email',
                'Grade', 'Hostel Needed', 'Message', 'Status', 'Contacted On', 'Admin Notes',
            ]);

            AdmissionEnquiry::query()
                ->filter($filters)
                ->orderByDesc('id')
                ->chunkById(500, function ($rows) use ($out) {
                    foreach ($rows as $e) {
                        fputcsv($out, [
                            $e->id,
                            $e->created_at?->format('d-m-Y h:i A'),
                            $e->student_name,
                            $e->parent_name,
                            $e->parent_phone,
                            $e->parent_email,
                            $e->grade,
                            $e->needs_hostel ? 'Yes' : 'No',
                            $e->message,
                            $e->status_label,
                            $e->contacted_at?->format('d-m-Y h:i A'),
                            $e->admin_notes,
                        ]);
                    }
                });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /* ------------------------------------------------------------------ */

    protected function filters(Request $request): array
    {
        $status = (string) $request->query('status', '');
        $hostel = (string) $request->query('hostel', '');

        return [
            'q'      => trim((string) $request->query('q', '')) ?: null,
            'status' => array_key_exists($status, AdmissionEnquiry::STATUSES) ? $status : null,
            'hostel' => in_array($hostel, ['yes', 'no'], true) ? $hostel : null,
            'grade'  => trim((string) $request->query('grade', '')) ?: null,
            'from'   => $this->date($request->query('from')),
            'to'     => $this->date($request->query('to')),
        ];
    }

    protected function date(mixed $value): ?string
    {
        if (! is_string($value) || $value === '') {
            return null;
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }
}
