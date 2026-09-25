@extends('admin.layout')
@section('title', 'Activity Logs')
@section('content')

@php
    $today = now()->format('Y-m-d');
    $preset = fn (int $days) => route('admin.activity-logs', array_merge(
        request()->except(['from', 'to', 'page']),
        ['from' => now()->subDays($days - 1)->format('Y-m-d'), 'to' => $today]
    ));
@endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <b>Activity Logs</b>
    </div>

    <div class="header">
        <div>
            <h1>Activity Logs</h1>
            <p>Full audit trail of every CMS action: who did it, what they did, which record, and when.</p>
        </div>
        <a href="{{ route('admin.activity-logs.export', request()->except('page')) }}" class="btn-outline">
            <i class="bi bi-download"></i> Export CSV
        </a>
    </div>

    {{-- Summary for the current filter --}}
    <div class="summary">
        <div class="sum-card">
            <span class="sum-num">{{ number_format($logs->total()) }}</span>
            <span class="sum-lbl">{{ $hasFilters ? 'Matching entries' : 'Total entries' }}</span>
        </div>
        @foreach (['created', 'updated', 'deleted'] as $a)
            <a class="sum-card act-{{ $a }} {{ ($filters['action'] ?? '') === $a ? 'on' : '' }}"
               href="{{ route('admin.activity-logs', array_merge(request()->except('page'), ['action' => ($filters['action'] ?? '') === $a ? null : $a])) }}">
                <span class="sum-num"><i class="bi {{ \App\Models\ActivityLog::ACTION_ICONS[$a] }}"></i> {{ number_format($summary[$a] ?? 0) }}</span>
                <span class="sum-lbl">{{ $actions[$a] }}</span>
            </a>
        @endforeach
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.activity-logs') }}" class="card filters">
        <div class="f-grid">
            <div class="f-field f-search">
                <label>Search</label>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Record, user, module, IP or record ID…">
                </div>
            </div>

            <div class="f-field">
                <label>User</label>
                <select name="user">
                    <option value="">All users</option>
                    @foreach ($users as $u)
                        <option value="{{ $u->user_id }}" @selected($filters['user'] === (int) $u->user_id)>
                            {{ $u->user_name ?: 'User #' . $u->user_id }}{{ $u->user_role ? ' (' . ucfirst($u->user_role) . ')' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="f-field">
                <label>Module</label>
                <select name="module">
                    <option value="">All modules</option>
                    @foreach ($modules as $m)
                        <option value="{{ $m }}" @selected($filters['module'] === $m)>{{ $m }}</option>
                    @endforeach
                </select>
            </div>

            <div class="f-field">
                <label>Action</label>
                <select name="action">
                    <option value="">All actions</option>
                    @foreach ($actions as $key => $label)
                        <option value="{{ $key }}" @selected($filters['action'] === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="f-field">
                <label>From</label>
                <input type="date" name="from" value="{{ $filters['from'] }}" max="{{ $today }}">
            </div>

            <div class="f-field">
                <label>To</label>
                <input type="date" name="to" value="{{ $filters['to'] }}" max="{{ $today }}">
            </div>
        </div>

        <div class="f-actions">
            <div class="presets">
                <span>Quick:</span>
                <a href="{{ $preset(1) }}">Today</a>
                <a href="{{ $preset(7) }}">Last 7 days</a>
                <a href="{{ $preset(30) }}">Last 30 days</a>
            </div>
            <div class="f-buttons">
                <input type="hidden" name="per_page" value="{{ $perPage }}">
                @if ($hasFilters)
                    <a href="{{ route('admin.activity-logs') }}" class="btn-cancel"><i class="bi bi-x-lg"></i> Reset</a>
                @endif
                <button type="submit" class="btn-save"><i class="bi bi-funnel"></i> Apply filters</button>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="card list-card">
        @if ($logs->isEmpty())
            <div class="empty">
                <div class="empty-ico"><i class="bi bi-journal-text"></i></div>
                <h3>No activity found</h3>
                <p>{{ $hasFilters ? 'Nothing matches these filters. Try widening the date range.' : 'Actions will appear here as soon as anyone adds, edits or deletes content.' }}</p>
            </div>
        @else
            <div class="table-scroll">
                <table class="log-table">
                    <thead>
                        <tr>
                            <th>When</th>
                            <th>Who</th>
                            <th>Action</th>
                            <th>Module</th>
                            <th>Record</th>
                            <th>Changes</th>
                            <!-- <th>IP</th> -->
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr onclick="window.location='{{ route('admin.activity-logs.show', $log) }}'">
                                <td class="nowrap">
                                    <div class="when">{{ $log->created_at->format('d M Y') }}</div>
                                    <div class="sub">{{ $log->created_at->format('h:i:s A') }} &middot; {{ $log->created_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <div class="who">
                                        <span class="avatar">{{ strtoupper(mb_substr($log->user_name ?: 'S', 0, 1)) }}</span>
                                        <div>
                                            <b>{{ $log->user_name ?: 'System' }}</b>
                                            @if ($log->user_role)
                                                <div class="sub">{{ ucfirst($log->user_role) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="act-pill act-{{ $log->action }}">
                                        <i class="bi {{ $log->action_icon }}"></i> {{ $log->action_label }}
                                    </span>
                                </td>
                                <td class="nowrap">{{ $log->module }}</td>
                                <td>
                                    <div class="record">{{ \Illuminate\Support\Str::limit($log->subject_label ?? '—', 60) }}</div>
                                    @if ($log->subject_id)
                                        <div class="sub">ID #{{ $log->subject_id }}</div>
                                    @endif
                                </td>
                                <td class="nowrap">
                                    @if ($log->action === 'updated' && $log->change_count)
                                        <span class="chg">{{ $log->change_count }} field{{ $log->change_count > 1 ? 's' : '' }}</span>
                                        <div class="sub">{{ \Illuminate\Support\Str::limit(collect(array_keys($log->properties))->map(fn ($k) => \Illuminate\Support\Str::headline($k))->implode(', '), 40) }}</div>
                                    @elseif ($log->description)
                                        <span class="sub">{{ $log->description }}</span>
                                    @else
                                        <span class="sub">&mdash;</span>
                                    @endif
                                </td>
                                <!-- <td class="nowrap sub">{{ $log->ip_address ?? '—' }}</td> -->
                                <td style="text-align:right;">
                                    <a href="{{ route('admin.activity-logs.show', $log) }}" class="icon-btn" title="View details" onclick="event.stopPropagation()">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Pagination (same design as Events) --}}
    @if ($logs->total() > 0)
        @php
            $current = $logs->currentPage();
            $last    = $logs->lastPage();
            $start   = max(1, $current - 2);
            $end     = min($last, $start + 4);
            $start   = max(1, min($start, $end - 4));
        @endphp

        <nav class="pager" role="navigation" aria-label="Pagination">
            <div class="pager-left">
                <div class="pager-status">
                    Showing <b>{{ $logs->firstItem() }}</b> to <b>{{ $logs->lastItem() }}</b>
                    of <b>{{ number_format($logs->total()) }}</b> {{ \Illuminate\Support\Str::plural('result', $logs->total()) }}
                </div>

                <form method="GET" action="{{ route('admin.activity-logs') }}" class="perpage-form">
                    @foreach (request()->except(['per_page', 'page']) as $k => $v)
                        @if (is_string($v) && $v !== '')
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endif
                    @endforeach
                    <label for="logPerPageSelect">Show</label>
                    <select name="per_page" id="logPerPageSelect" onchange="this.form.submit()">
                        @foreach ($perPageOptions as $n)
                            <option value="{{ $n }}" @selected($perPage === $n)>{{ $n }}</option>
                        @endforeach
                    </select>
                    <span>per page</span>
                </form>
            </div>

            @if ($logs->hasPages())
                <div class="pager-links">
                    @if ($current <= 1)
                        <span class="pager-btn pager-btn-disabled" aria-disabled="true"><i class="bi bi-chevron-left"></i></span>
                    @else
                        <a href="{{ $logs->url($current - 1) }}" class="pager-btn" rel="prev"><i class="bi bi-chevron-left"></i></a>
                    @endif

                    @if ($start > 1)
                        <a href="{{ $logs->url(1) }}" class="pager-btn">1</a>
                        @if ($start > 2)<span class="pager-dots">&hellip;</span>@endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $current)
                            <span class="pager-btn pager-btn-active">{{ $page }}</span>
                        @else
                            <a href="{{ $logs->url($page) }}" class="pager-btn">{{ $page }}</a>
                        @endif
                    @endfor

                    @if ($end < $last)
                        @if ($end < $last - 1)<span class="pager-dots">&hellip;</span>@endif
                        <a href="{{ $logs->url($last) }}" class="pager-btn">{{ $last }}</a>
                    @endif

                    @if ($current >= $last)
                        <span class="pager-btn pager-btn-disabled" aria-disabled="true"><i class="bi bi-chevron-right"></i></span>
                    @else
                        <a href="{{ $logs->url($current + 1) }}" class="pager-btn" rel="next"><i class="bi bi-chevron-right"></i></a>
                    @endif
                </div>
            @endif
        </nav>
    @endif
</div>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span{ cursor:pointer; }
    .crumbs span:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:22px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:560px; line-height:1.55; }

    .btn-outline{
        display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:600; text-decoration:none;
        color: var(--ink,#171B2C); background:#fff; border:1px solid var(--input-border,#DBDFEA);
        padding:10px 16px; border-radius:9px; transition:all .15s;
    }
    .btn-outline:hover{ border-color: var(--ink,#171B2C); }

    /* Summary */
    .summary{ display:grid; grid-template-columns:repeat(4, 1fr); gap:12px; margin-bottom:16px; }
    @media (max-width:760px){ .summary{ grid-template-columns:repeat(2, 1fr); } }
    .sum-card{
        display:flex; flex-direction:column; gap:4px; padding:14px 16px; border-radius:12px; background:#fff;
        border:1px solid var(--line,#E9EBF2); text-decoration:none; color: var(--ink,#171B2C); transition:all .15s;
    }
    a.sum-card:hover{ border-color:#C9CEDA; }
    .sum-card.on{ box-shadow:0 0 0 2px currentColor inset; }
    .sum-num{ font-size:20px; font-weight:700; display:flex; align-items:center; gap:7px; }
    .sum-num i{ font-size:14px; }
    .sum-lbl{ font-size:12px; color: var(--muted,#667085); }
    .sum-card.act-created{ color:#1E8E4E; }
    .sum-card.act-updated{ color:#2F5BD3; }
    .sum-card.act-deleted{ color:#C62828; }

    /* Filters */
    .filters{ margin-bottom:16px; }
    .f-grid{ display:grid; grid-template-columns:2fr 1fr 1fr 1fr 1fr 1fr; gap:12px; }
    @media (max-width:1100px){ .f-grid{ grid-template-columns:1fr 1fr 1fr; } .f-search{ grid-column:1 / -1; } }
    @media (max-width:600px){ .f-grid{ grid-template-columns:1fr; } }
    .f-field label{ display:block; font-size:12px; font-weight:600; color: var(--muted,#667085); margin-bottom:6px; }
    .f-field select, .f-field input[type=date], .search-box input{
        width:100%; box-sizing:border-box; border:1px solid var(--input-border,#DBDFEA); border-radius:9px;
        padding:9px 12px; font-size:13.5px; font-family:inherit; background:#fff; color: var(--ink,#171B2C); outline:none;
    }
    .f-field select:focus, .f-field input:focus{ border-color: var(--orange,#BF0001); box-shadow:0 0 0 4px var(--orange-tint-strong,#FFE9D8); }
    .search-box{ position:relative; }
    .search-box i{ position:absolute; left:11px; top:50%; transform:translateY(-50%); color: var(--faint,#9AA1B2); font-size:13px; }
    .search-box input{ padding-left:32px; }
    .f-actions{ display:flex; align-items:center; justify-content:space-between; gap:12px; margin-top:14px; flex-wrap:wrap; }
    .presets{ display:flex; align-items:center; gap:6px; font-size:12.5px; color: var(--faint,#9AA1B2); flex-wrap:wrap; }
    .presets a{ color: var(--muted,#667085); text-decoration:none; padding:4px 10px; border-radius:999px; border:1px solid var(--line,#E9EBF2); background:#fff; }
    .presets a:hover{ color: var(--orange,#BF0001); border-color: var(--orange,#BF0001); }
    .f-buttons{ display:flex; align-items:center; gap:10px; }
    .btn-cancel{
        display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:600; color: var(--muted,#667085);
        padding:9px 14px; border-radius:8px; text-decoration:none;
    }
    .btn-cancel:hover{ background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); }
    .btn-save{
        display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none; padding:10px 18px; border-radius:9px; cursor:pointer;
    }

    /* Table */
    .list-card{ padding:0; overflow:hidden; }
    .table-scroll{ overflow-x:auto; }
    .log-table{ width:100%; border-collapse:collapse; font-size:13.5px; }
    .log-table th{
        text-align:left; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;
        color: var(--faint,#9AA1B2); padding:12px 16px; background: var(--canvas,#F6F7FB); white-space:nowrap;
    }
    .log-table td{ padding:12px 16px; border-top:1px solid var(--line,#E9EBF2); vertical-align:middle; color: var(--ink,#171B2C); }
    .log-table tbody tr{ cursor:pointer; }
    .log-table tbody tr:hover{ background:#FAFBFD; }
    .nowrap{ white-space:nowrap; }
    .sub{ font-size:12px; color: var(--faint,#9AA1B2); margin-top:2px; }
    .when{ font-weight:600; }
    .who{ display:flex; align-items:center; gap:10px; }
    .avatar{
        width:30px; height:30px; border-radius:999px; background:#EEF0F6; color: var(--muted,#667085);
        display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex-shrink:0;
    }
    .record{ font-weight:500; }
    .chg{ font-size:12.5px; font-weight:600; color:#2F5BD3; }

    .act-pill{ display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600; white-space:nowrap; }
    .act-pill.act-created { background:#E6F6EC; color:#1E8E4E; }
    .act-pill.act-updated { background:#EEF4FF; color:#2F5BD3; }
    .act-pill.act-deleted { background:#FDECEC; color:#C62828; }
    .act-pill.act-restored{ background:#FFF4E5; color:#B25E00; }
    .act-pill.act-login, .act-pill.act-logout{ background:#F2F3F7; color:#555D70; }

    .icon-btn{
        display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:8px;
        border:1px solid var(--line,#E9EBF2); background:#fff; color: var(--muted,#667085); text-decoration:none;
    }
    .icon-btn:hover{ color: var(--ink,#171B2C); border-color:#C9CEDA; }

    /* Pager — same as Events */
    .pager{ display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-top:20px; }
    .pager-left{ display:flex; align-items:center; gap:18px; flex-wrap:wrap; }
    .pager-status{ font-size:12.5px; color: var(--faint,#9AA1B2); }
    .pager-status b{ color: var(--ink,#171B2C); font-weight:600; }
    .pager-links{ display:flex; align-items:center; gap:4px; flex-wrap:wrap; }
    .pager-btn{
        display:inline-flex; align-items:center; justify-content:center;
        min-width:32px; height:32px; padding:0 8px; border-radius:8px;
        border:1px solid var(--line,#E9EBF2); background:#fff;
        font-size:12.5px; font-weight:600; color: var(--muted,#667085);
        text-decoration:none; cursor:pointer; transition:background .15s, color .15s, border-color .15s;
    }
    .pager-btn:hover{ background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); }
    .pager-btn-active{ background:linear-gradient(135deg, #0F1526, #1D2439); border-color:transparent; color:#fff; }
    .pager-btn-active:hover{ color:#fff; }
    .pager-btn-disabled{ opacity:.4; cursor:not-allowed; }
    .pager-btn-disabled:hover{ background:#fff; color: var(--muted,#667085); }
    .pager-dots{ padding:0 4px; color: var(--faint,#9AA1B2); font-size:12.5px; }

    .perpage-form{ display:flex; align-items:center; gap:8px; font-size:12.5px; color: var(--muted,#667085); white-space:nowrap; }
    .perpage-form select{
        border:1px solid var(--input-border,#DBDFEA); border-radius:8px; padding:6px 28px 6px 10px;
        font-size:12.5px; font-family:inherit; color: var(--ink,#171B2C); background:#fff;
        outline:none; cursor:pointer; appearance:none;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23667085' stroke-width='1.5' fill='none' fill-rule='evenodd'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:right 10px center;
        transition:border-color .15s;
    }
    .perpage-form select:focus{ border-color: var(--orange,#BF0001); }

    .empty{ text-align:center; padding:56px 20px; }
    .empty-ico{ width:56px; height:56px; border-radius:999px; background:#EEF0F6; display:inline-flex; align-items:center; justify-content:center; font-size:24px; color:#AEB4C4; margin-bottom:12px; }
    .empty h3{ font-size:16px; margin:0 0 6px; color: var(--ink,#171B2C); }
    .empty p{ font-size:13px; color: var(--muted,#667085); margin:0; }
</style>

@endsection