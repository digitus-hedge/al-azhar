@extends('admin.layout')
@section('title', 'Activity Log #' . $log->id)
@section('content')

@php
    $changes = is_array($log->properties) ? $log->properties : [];
    $mode = match ($log->action) {
        'created' => 'new',     // only "value" column
        'deleted' => 'old',     // only "value before delete" column
        default   => 'diff',    // before → after
    };

    $show = function ($value) {
        if ($value === null || $value === '') return '<span class="empty-val">empty</span>';
        if ($value === true)  return 'Yes';
        if ($value === false) return 'No';
        return nl2br(e(is_scalar($value) ? (string) $value : json_encode($value)));
    };
@endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <span onclick="window.location='{{ route('admin.activity-logs') }}'">Activity Logs</span>
        <span>&rsaquo;</span>
        <b>#{{ $log->id }}</b>
    </div>

    <div class="header">
        <div>
            <span class="act-pill act-{{ $log->action }}"><i class="bi {{ $log->action_icon }}"></i> {{ $log->action_label }}</span>
            <h1>{{ $log->summary }}</h1>
            <p>{{ $log->created_at->format('l, d M Y \a\t h:i:s A') }} &middot; {{ $log->created_at->diffForHumans() }}</p>
        </div>
        <a href="{{ route('admin.activity-logs') }}" class="btn-outline"><i class="bi bi-arrow-left"></i> All logs</a>
    </div>

    {{-- Who / What / Which / When --}}
    <div class="facts">
        <div class="card fact">
            <span class="fact-lbl"><i class="bi bi-person"></i> Who</span>
            <b>{{ $log->user_name ?: 'System' }}</b>
            <span class="sub">{{ $log->user_email }}{{ $log->user_role ? ' · ' . ucfirst($log->user_role) : '' }}</span>
            @if ($log->user_id && ! $log->user)
                <span class="sub warn">This user account has since been deleted</span>
            @endif
        </div>
        <div class="card fact">
            <span class="fact-lbl"><i class="bi bi-lightning"></i> What</span>
            <b>{{ $log->action_label }}</b>
            <span class="sub">{{ $log->description ?: ($log->action === 'updated' ? count($changes) . ' field(s) changed' : '—') }}</span>
        </div>
        <div class="card fact">
            <span class="fact-lbl"><i class="bi bi-folder2"></i> Which</span>
            <b>{{ $log->module }}</b>
            <span class="sub">{{ $log->subject_label ?? '—' }}{{ $log->subject_id ? ' · ID #' . $log->subject_id : '' }}</span>
        </div>
        <div class="card fact">
            <span class="fact-lbl"><i class="bi bi-clock"></i> When</span>
            <b>{{ $log->created_at->format('d M Y') }}</b>
            <span class="sub">{{ $log->created_at->format('h:i:s A') }}</span>
        </div>
    </div>

    <div class="cols">
        {{-- Changes --}}
        <div class="card changes-card">
            <div class="section-title">
                <h2>
                    <span class="icon"><i class="bi bi-list-check"></i></span>
                    @if ($mode === 'diff') Changes
                    @elseif ($mode === 'new') Values saved
                    @else Values at the time of deletion
                    @endif
                </h2>
            </div>

            @if (empty($changes))
                <p class="sub" style="margin:0;">No field details were recorded for this action.</p>
            @else
                <div class="table-scroll">
                    <table class="diff-table">
                        <thead>
                            <tr>
                                <th style="width:24%;">Field</th>
                                @if ($mode === 'diff')
                                    <th>Before</th>
                                    <th>After</th>
                                @else
                                    <th>Value</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($changes as $field => $change)
                                <tr>
                                    <td class="field-name">{{ \Illuminate\Support\Str::headline($field) }}</td>
                                    @if ($mode === 'diff')
                                        <td class="val old">{!! $show($change['old'] ?? null) !!}</td>
                                        <td class="val new">{!! $show($change['new'] ?? null) !!}</td>
                                    @else
                                        <td class="val">{!! $show($mode === 'new' ? ($change['new'] ?? null) : ($change['old'] ?? null)) !!}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- <div class="side">
            {{-- Request details --}}
            <div class="card">
                <div class="section-title">
                    <h2><span class="icon"><i class="bi bi-globe2"></i></span> Request</h2>
                </div>
                <dl class="meta">
                    <dt>IP address</dt>
                    <dd>{{ $log->ip_address ?? '—' }}</dd>
                    <dt>Browser / device</dt>
                    <dd class="small">{{ $log->user_agent ?? '—' }}</dd>
                    <dt>URL</dt>
                    <dd class="small break">{{ $log->url ?? '—' }}</dd>
                    <dt>Log ID</dt>
                    <dd>#{{ $log->id }}</dd>
                </dl>
            </div>

            {{-- Record history --}}
            @if ($history->count() > 1)
                <div class="card">
                    <div class="section-title">
                        <h2><span class="icon"><i class="bi bi-clock-history"></i></span> History of this record</h2>
                    </div>
                    <ul class="timeline">
                        @foreach ($history as $h)
                            <li class="{{ $h->id === $log->id ? 'current' : '' }}">
                                <span class="dot act-{{ $h->action }}"></span>
                                <a href="{{ route('admin.activity-logs.show', $h) }}">
                                    <b>{{ $h->action_label }}</b> by {{ $h->user_name ?: 'System' }}
                                    <span class="sub">{{ $h->created_at->format('d M Y, h:i A') }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div> -->
    </div>
</div>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span{ cursor:pointer; }
    .crumbs span:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:22px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:22px; font-weight:700; letter-spacing:-0.02em; margin:10px 0 0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:6px 0 0; }
    .btn-outline{
        display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:600; text-decoration:none;
        color: var(--ink,#171B2C); background:#fff; border:1px solid var(--input-border,#DBDFEA); padding:10px 16px; border-radius:9px;
    }
    .btn-outline:hover{ border-color: var(--ink,#171B2C); }

    .act-pill{ display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600; }
    .act-created { background:#E6F6EC; color:#1E8E4E; }
    .act-updated { background:#EEF4FF; color:#2F5BD3; }
    .act-deleted { background:#FDECEC; color:#C62828; }
    .act-restored{ background:#FFF4E5; color:#B25E00; }
    .act-login, .act-logout{ background:#F2F3F7; color:#555D70; }

    .facts{ display:grid; grid-template-columns:repeat(4, 1fr); gap:12px; margin-bottom:16px; }
    @media (max-width:900px){ .facts{ grid-template-columns:repeat(2, 1fr); } }
    @media (max-width:520px){ .facts{ grid-template-columns:1fr; } }
    .fact{ display:flex; flex-direction:column; gap:4px; margin:0; }
    .fact b{ font-size:15px; color: var(--ink,#171B2C); word-break:break-word; }
    .fact-lbl{ font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; color: var(--faint,#9AA1B2); display:flex; align-items:center; gap:6px; margin-bottom:2px; }
    .sub{ font-size:12.5px; color: var(--faint,#9AA1B2); }
    .warn{ color:#B7791F; }

    .cols{ display:grid; grid-template-columns:minmax(0, 2fr) minmax(0, 1fr); gap:16px; align-items:start; }
    @media (max-width:980px){ .cols{ grid-template-columns:1fr; } }
    .side .card{ margin-bottom:16px; }

    .section-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .icon{ display:inline-flex; color: var(--orange,#BF0001); }

    .table-scroll{ overflow-x:auto; }
    .diff-table{ width:100%; border-collapse:collapse; font-size:13px; table-layout:fixed; }
    .diff-table th{ text-align:left; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; color: var(--faint,#9AA1B2); padding:10px 12px; background: var(--canvas,#F6F7FB); }
    .diff-table td{ padding:10px 12px; border-top:1px solid var(--line,#E9EBF2); vertical-align:top; word-break:break-word; }
    .field-name{ font-weight:600; color: var(--ink,#171B2C); }
    .val.old{ background:#FFF6F6; color:#9B1C1C; }
    .val.new{ background:#F3FBF6; color:#14632F; }
    .empty-val{ font-style:italic; color: var(--faint,#9AA1B2); }

    .meta{ margin:0; display:grid; grid-template-columns:auto 1fr; gap:8px 14px; font-size:13px; }
    .meta dt{ color: var(--faint,#9AA1B2); font-weight:600; }
    .meta dd{ margin:0; color: var(--ink,#171B2C); }
    .meta .small{ font-size:12px; color: var(--muted,#667085); }
    .meta .break{ word-break:break-all; }

    .timeline{ list-style:none; margin:0; padding:0; }
    .timeline li{ position:relative; padding:0 0 14px 22px; border-left:2px solid var(--line,#E9EBF2); margin-left:5px; }
    .timeline li:last-child{ border-left-color:transparent; padding-bottom:0; }
    .timeline .dot{ position:absolute; left:-7px; top:2px; width:12px; height:12px; border-radius:999px; border:2px solid #fff; }
    .timeline .dot.act-created{ background:#1E8E4E; }
    .timeline .dot.act-updated{ background:#2F5BD3; }
    .timeline .dot.act-deleted{ background:#C62828; }
    .timeline .dot.act-restored{ background:#B25E00; }
    .timeline a{ text-decoration:none; color: var(--ink,#171B2C); font-size:13px; display:block; }
    .timeline a .sub{ display:block; margin-top:2px; }
    .timeline li.current a b{ color: var(--orange,#BF0001); }
</style>

@endsection
