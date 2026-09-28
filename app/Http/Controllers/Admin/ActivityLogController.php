<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Audit trail — Super Admin only (routes sit inside the admin.only group).
 * Read-only: logs can be viewed and exported, never edited or deleted here.
 */
class ActivityLogController extends Controller
{
    protected array $perPageOptions = [10,25, 50, 100, 200];

    public function index(Request $request): View
    {
        $filters = $this->filters($request);
        $perPage = (int) $request->query('per_page', 10);
        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        $logs = ActivityLog::query()
            ->filter($filters)
            ->latest('created_at')
            ->latest('id')
            ->paginate($perPage)
            ->appends($request->query());

        // Dropdown options come from the logs themselves, so deleted users
        // and old modules still appear.
        $users = ActivityLog::query()
            ->whereNotNull('user_id')
            ->selectRaw('user_id, MAX(user_name) as user_name, MAX(user_role) as user_role')
            ->groupBy('user_id')
            ->orderBy('user_name')
            ->get();

        $modules = ActivityLog::query()
            ->select('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module');

        // Summary numbers for the current filter
        $summary = ActivityLog::query()
            ->filter($filters)
            ->selectRaw('action, COUNT(*) as total')
            ->groupBy('action')
            ->pluck('total', 'action');

        return view('admin.activity-logs.index', [
            'logs'           => $logs,
            'filters'        => $filters,
            'users'          => $users,
            'modules'        => $modules,
            'actions'        => ActivityLog::ACTIONS,
            'summary'        => $summary,
            'perPage'        => $perPage,
            'perPageOptions' => $this->perPageOptions,
            'hasFilters'     => collect($filters)->filter()->isNotEmpty(),
        ]);
    }

    public function show(ActivityLog $activityLog): View
    {
        // Other activity on the same record (its history)
        $history = collect();
        if ($activityLog->subject_type && $activityLog->subject_id) {
            $history = ActivityLog::query()
                ->where('subject_type', $activityLog->subject_type)
                ->where('subject_id', $activityLog->subject_id)
                ->latest('created_at')
                ->latest('id')
                ->limit(20)
                ->get();
        }

        return view('admin.activity-logs.show', [
            'log'     => $activityLog,
            'history' => $history,
        ]);
    }

    /**
     * CSV download of the currently filtered logs.
     */
    public function export(Request $request): StreamedResponse
    {
        $filters  = $this->filters($request);
        $filename = 'activity-logs-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($filters) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel shows Malayalam/Arabic text correctly

            fputcsv($out, ['Date & Time', 'User', 'Email', 'Role', 'Action', 'Module', 'Record',  'Changed Fields']);

            ActivityLog::query()
                ->filter($filters)
                ->orderByDesc('id')
                ->chunkById(500, function ($rows) use ($out) {
                    foreach ($rows as $log) {
                        fputcsv($out, [
                            $log->created_at?->format('d-m-Y h:i:s A'),
                            $log->user_name ?: 'System',
                            $log->user_email,
                            $log->user_role,
                            $log->action_label,
                            $log->module,
                            $log->subject_label,
                            // $log->subject_id,
                            is_array($log->properties) ? implode(', ', array_keys($log->properties)) : '',
                            // $log->ip_address,
                        ]);
                    }
                });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /* ------------------------------------------------------------------ */

    /** Read + clean the filter values from the query string. */
    protected function filters(Request $request): array
    {
        $action = (string) $request->query('action', '');

        return [
            'q'      => trim((string) $request->query('q', '')) ?: null,
            'user'   => ctype_digit((string) $request->query('user')) ? (int) $request->query('user') : null,
            'module' => trim((string) $request->query('module', '')) ?: null,
            'action' => array_key_exists($action, ActivityLog::ACTIONS) ? $action : null,
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
