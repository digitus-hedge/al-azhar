@extends('admin.layout')
@section('title', 'Admission Enquiries')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@php
    $isAdmin = auth()->user()?->role === 'admin';
    $today   = now()->format('Y-m-d');

    $sortLink = function (string $column, string $label) use ($sortBy, $sortDir) {
        $active = $sortBy === $column;
        $dir    = ($active && $sortDir === 'asc') ? 'desc' : 'asc';
        $url    = request()->fullUrlWithQuery(['sort' => $column, 'dir' => $dir, 'page' => null]);
        $icon   = $active ? ($sortDir === 'asc' ? 'bi-caret-up-fill' : 'bi-caret-down-fill') : 'bi-arrow-down-up';

        return '<a href="' . e($url) . '" class="sort-link' . ($active ? ' active' : '') . '">'
             . e($label) . ' <i class="bi ' . $icon . '"></i></a>';
    };

    $tabUrl = fn (?string $key) => request()->fullUrlWithQuery(['status' => $key, 'page' => null]);
@endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <b>Admission Enquiries</b>
    </div>

    <div class="header">
        <div>
            <h1>Admission Enquiries</h1>
            <p>Enquiries submitted from the website admission form. Call or WhatsApp the parent, then update the status.</p>
        </div>
        <a href="{{ route('admin.admission-enquiries.export', request()->except('page')) }}" class="btn-outline">
            <i class="bi bi-download"></i> Export CSV
        </a>
    </div>

    {{-- Status tabs --}}
    <div class="cat-tabs">
        <a href="{{ $tabUrl(null) }}" class="cat-tab {{ ! $filters['status'] ? 'active' : '' }}">
            <i class="bi bi-inbox"></i> All <span class="cat-count">{{ $totalCount }}</span>
        </a>
        @foreach ($statuses as $key => $label)
            <a href="{{ $tabUrl($key) }}" class="cat-tab st-{{ $key }} {{ $filters['status'] === $key ? 'active' : '' }}">
                <i class="bi {{ \App\Models\AdmissionEnquiry::STATUS_ICONS[$key] }}"></i> {{ $label }}
                <span class="cat-count">{{ $counts[$key] ?? 0 }}</span>
            </a>
        @endforeach
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.admission-enquiries') }}" class="card filters">
        @if ($filters['status'])
            <input type="hidden" name="status" value="{{ $filters['status'] }}">
        @endif
        <input type="hidden" name="sort" value="{{ $sortBy }}">
        <input type="hidden" name="dir" value="{{ $sortDir }}">
        <input type="hidden" name="per_page" value="{{ $perPage }}">

        <div class="f-grid">
            <div class="f-field f-search">
                <label>Search</label>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Student, parent, phone, email, message…">
                </div>
            </div>
            <div class="f-field">
                <label>Grade</label>
                <select name="grade">
                    <option value="">All grades</option>
                    @foreach ($grades as $g)
                        <option value="{{ $g }}" @selected($filters['grade'] === $g)>{{ $g }}</option>
                    @endforeach
                </select>
            </div>
            <div class="f-field">
                <label>Hostel</label>
                <select name="hostel">
                    <option value="">Any</option>
                    <option value="yes" @selected($filters['hostel'] === 'yes')>Needs hostel</option>
                    <option value="no" @selected($filters['hostel'] === 'no')>No hostel</option>
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
            @if ($hasFilters)
                <a href="{{ route('admin.admission-enquiries', array_filter(['status' => $filters['status']])) }}" class="btn-cancel"><i class="bi bi-x-lg"></i> Reset</a>
            @endif
            <button type="submit" class="btn-save"><i class="bi bi-funnel"></i> Apply</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="card list-card">
        @if ($enquiries->isEmpty())
            <div class="empty">
                <div class="empty-ico"><i class="bi bi-envelope-open"></i></div>
                <h3>No enquiries {{ $hasFilters || $filters['status'] ? 'found' : 'yet' }}</h3>
                <p>
                    @if ($hasFilters || $filters['status'])
                        Nothing matches these filters.
                    @else
                        When a parent submits the admission form on the website, it will appear here.
                    @endif
                </p>
            </div>
        @else
            <div class="table-scroll">
                <table class="enq-table">
                    <thead>
                        <tr>
                            <th>{!! $sortLink('created_at', 'Received') !!}</th>
                            <th>{!! $sortLink('student_name', 'Student') !!}</th>
                            <th>{!! $sortLink('parent_name', 'Parent / Contact') !!}</th>
                            <th>{!! $sortLink('needs_hostel', 'Hostel') !!}</th>
                            <th>{!! $sortLink('status', 'Status') !!}</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enquiries as $e)
                            <tr class="{{ $e->status === 'new' ? 'is-new' : '' }}">
                                <td class="nowrap">
                                    <div class="when">{{ $e->created_at->format('d M Y') }}</div>
                                    <div class="sub">{{ $e->created_at->format('h:i A') }} &middot; {{ $e->created_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.admission-enquiries.show', $e) }}" class="name-link">
                                        @if ($e->status === 'new')<span class="dot-new" title="New"></span>@endif
                                        <b>{{ $e->student_name }}</b>
                                    </a>
                                    <div class="sub">Grade: {{ $e->grade }}</div>
                                    @if ($e->message)
                                        <div class="msg" title="{{ $e->message }}"><i class="bi bi-chat-left-text"></i> {{ \Illuminate\Support\Str::limit($e->message, 50) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $e->parent_name }}</div>
                                    <div class="contact">
                                        <a href="tel:{{ $e->parent_phone }}" title="Call"><i class="bi bi-telephone"></i> {{ $e->parent_phone }}</a>
                                        <a href="https://wa.me/{{ $e->whatsapp_number }}" target="_blank" rel="noopener" class="wa" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                                    </div>
                                    @if ($e->parent_email)
                                        <div class="sub"><a href="mailto:{{ $e->parent_email }}" class="mail">{{ $e->parent_email }}</a></div>
                                    @endif
                                </td>
                                <td>
                                    @if ($e->needs_hostel)
                                        <span class="badge-yes"><i class="bi bi-house-door-fill"></i> Yes</span>
                                    @else
                                        <span class="badge-muted">No</span>
                                    @endif
                                </td>
                                <td>
                                    <select class="status-select st-{{ $e->status }}" data-url="{{ route('admin.admission-enquiries.status', $e) }}"
                                            data-current="{{ $e->status }}" onchange="changeStatus(this)">
                                        @foreach ($statuses as $key => $label)
                                            <option value="{{ $key }}" @selected($e->status === $key)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('admin.admission-enquiries.show', $e) }}" class="icon-btn" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if ($isAdmin)
                                        <button type="button" class="icon-btn icon-btn-danger" title="Delete"
                                                onclick="confirmDeleteEnquiry({{ $e->id }}, @js($e->student_name))">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $e->id }}" action="{{ route('admin.admission-enquiries.destroy', $e) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="list-footer">
                <div class="per-page">
                    <span class="showing">Showing {{ $enquiries->firstItem() }}–{{ $enquiries->lastItem() }} of {{ $enquiries->total() }}</span>
                    <form method="GET" action="{{ route('admin.admission-enquiries') }}">
                        @foreach (request()->except(['per_page', 'page']) as $k => $v)
                            @if (is_string($v))
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endif
                        @endforeach
                        <select name="per_page" onchange="this.form.submit()">
                            @foreach ($perPageOptions as $n)
                                <option value="{{ $n }}" @selected($perPage === $n)>{{ $n }} / page</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                {{ $enquiries->links() }}
            </div>
        @endif
    </div>
</div>

<script>
const CSRF = '{{ csrf_token() }}';

function changeStatus(select) {
    const previous = select.dataset.current;
    select.disabled = true;

    const body = new FormData();
    body.append('_token', CSRF);
    body.append('_method', 'PATCH');
    body.append('status', select.value);

    fetch(select.dataset.url, {
        method: 'POST',
        body,
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(async r => {
        const data = await r.json().catch(() => ({}));
        if (!r.ok) throw new Error(data.message || 'Could not change status.');

        select.className = 'status-select st-' + select.value;
        select.dataset.current = select.value;
        select.closest('tr').classList.toggle('is-new', select.value === 'new');
        const dot = select.closest('tr').querySelector('.dot-new');
        if (dot && select.value !== 'new') dot.remove();

        Swal.fire({ icon: 'success', title: data.message || 'Saved', toast: true, position: 'top-end',
                    showConfirmButton: false, timer: 1800, timerProgressBar: true });
    })
    .catch(err => {
        select.value = previous;
        Swal.fire({ icon: 'error', title: 'Error', text: err.message, confirmButtonColor: '#002F5F' });
    })
    .finally(() => { select.disabled = false; });
}

function confirmDeleteEnquiry(id, name) {
    Swal.fire({
        icon: 'warning',
        title: 'Delete enquiry?',
        html: `The enquiry for <b>${String(name).replace(/</g, '&lt;')}</b> will be removed.`,
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        confirmButtonColor: '#BF0001',
        cancelButtonColor: '#667085',
        reverseButtons: true
    }).then(r => { if (r.isConfirmed) document.getElementById('delete-form-' + id).submit(); });
}

@if (session('success'))
    Swal.fire({ icon: 'success', title: @js(session('success')), toast: true, position: 'top-end',
                showConfirmButton: false, timer: 2500, timerProgressBar: true });
@endif
</script>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span{ cursor:pointer; }
    .crumbs span:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:22px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; line-height:1.55; }
    .btn-outline{
        display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:600; text-decoration:none;
        color: var(--ink,#171B2C); background:#fff; border:1px solid var(--input-border,#DBDFEA); padding:10px 16px; border-radius:9px;
    }
    .btn-outline:hover{ border-color: var(--ink,#171B2C); }

    .cat-tabs{ display:flex; gap:8px; flex-wrap:wrap; margin-bottom:16px; }
    .cat-tab{
        display:inline-flex; align-items:center; gap:7px; padding:8px 14px; border-radius:999px;
        font-size:13px; font-weight:600; color: var(--muted,#667085); background:#fff;
        border:1px solid var(--line,#E9EBF2); text-decoration:none; transition:all .15s;
    }
    .cat-tab:hover{ border-color: var(--orange,#BF0001); color: var(--orange,#BF0001); }
    .cat-tab.active{ background: var(--ink,#171B2C); border-color: var(--ink,#171B2C); color:#fff; }
    .cat-count{ font-size:11px; font-weight:700; background:#EEF0F6; color: var(--muted,#667085); padding:1px 7px; border-radius:999px; }
    .cat-tab.active .cat-count{ background:rgba(255,255,255,0.18); color:#fff; }
    .cat-tab.st-new:not(.active) .cat-count{ background:#FFE9D8; color:#BF0001; }

    .filters{ margin-bottom:16px; }
    .f-grid{ display:grid; grid-template-columns:2fr 1fr 1fr 1fr 1fr; gap:12px; }
    @media (max-width:1000px){ .f-grid{ grid-template-columns:1fr 1fr; } .f-search{ grid-column:1 / -1; } }
    @media (max-width:560px){ .f-grid{ grid-template-columns:1fr; } }
    .f-field label{ display:block; font-size:12px; font-weight:600; color: var(--muted,#667085); margin-bottom:6px; }
    .f-field select, .f-field input[type=date], .search-box input{
        width:100%; box-sizing:border-box; border:1px solid var(--input-border,#DBDFEA); border-radius:9px;
        padding:9px 12px; font-size:13.5px; font-family:inherit; background:#fff; color: var(--ink,#171B2C); outline:none;
    }
    .f-field select:focus, .f-field input:focus{ border-color: var(--orange,#BF0001); box-shadow:0 0 0 4px var(--orange-tint-strong,#FFE9D8); }
    .search-box{ position:relative; }
    .search-box i{ position:absolute; left:11px; top:50%; transform:translateY(-50%); color: var(--faint,#9AA1B2); font-size:13px; }
    .search-box input{ padding-left:32px; }
    .f-actions{ display:flex; align-items:center; justify-content:flex-end; gap:10px; margin-top:14px; }
    .btn-cancel{ display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:600; color: var(--muted,#667085); padding:9px 14px; border-radius:8px; text-decoration:none; }
    .btn-cancel:hover{ background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); }
    .btn-save{
        display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none; padding:10px 18px; border-radius:9px; cursor:pointer;
    }

    .list-card{ padding:0; overflow:hidden; }
    .table-scroll{ overflow-x:auto; }
    .enq-table{ width:100%; border-collapse:collapse; font-size:13.5px; }
    .enq-table th{
        text-align:left; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;
        color: var(--faint,#9AA1B2); padding:12px 16px; background: var(--canvas,#F6F7FB); white-space:nowrap;
    }
    .enq-table td{ padding:12px 16px; border-top:1px solid var(--line,#E9EBF2); vertical-align:top; color: var(--ink,#171B2C); }
    .enq-table tbody tr:hover{ background:#FAFBFD; }
    .enq-table tr.is-new{ background:#FFFBF7; }
    .sort-link{ color:inherit; text-decoration:none; display:inline-flex; align-items:center; gap:4px; }
    .sort-link i{ font-size:10px; opacity:.5; }
    .sort-link.active{ color: var(--ink,#171B2C); }
    .sort-link.active i{ opacity:1; color: var(--orange,#BF0001); }

    .nowrap{ white-space:nowrap; }
    .when{ font-weight:600; }
    .sub{ font-size:12px; color: var(--faint,#9AA1B2); margin-top:2px; }
    .name-link{ color: var(--ink,#171B2C); text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
    .name-link:hover b{ color: var(--orange,#BF0001); }
    .dot-new{ width:8px; height:8px; border-radius:999px; background:#BF0001; display:inline-block; }
    .msg{ font-size:12px; color: var(--muted,#667085); margin-top:4px; max-width:280px; }
    .contact{ display:flex; align-items:center; gap:8px; margin-top:3px; font-size:12.5px; }
    .contact a{ color: var(--muted,#667085); text-decoration:none; }
    .contact a:hover{ color: var(--ink,#171B2C); }
    .contact a.wa{ color:#1E8E4E; font-size:15px; }
    .mail{ color: var(--faint,#9AA1B2); text-decoration:none; }
    .mail:hover{ text-decoration:underline; }

    .badge-yes{ display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; background:#EEF4FF; color:#2F5BD3; }
    .badge-muted{ font-size:12.5px; color: var(--faint,#9AA1B2); }

    .status-select{
        border:none; border-radius:20px; padding:5px 26px 5px 12px; font-size:12px; font-weight:700; cursor:pointer;
        font-family:inherit; appearance:none; -webkit-appearance:none;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23667085'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:right 10px center;
    }
    .status-select:disabled{ opacity:.6; cursor:wait; }
    .st-new       { background-color:#FFE9D8; color:#BF0001; }
    .st-contacted { background-color:#EEF4FF; color:#2F5BD3; }
    .st-admitted  { background-color:#E6F6EC; color:#1E8E4E; }
    .st-rejected  { background-color:#F2F3F7; color:#555D70; }
    .cat-tab.st-new, .cat-tab.st-contacted, .cat-tab.st-admitted, .cat-tab.st-rejected{ background-color:#fff; color: var(--muted,#667085); }
    .cat-tab.active.st-new, .cat-tab.active.st-contacted, .cat-tab.active.st-admitted, .cat-tab.active.st-rejected{ background: var(--ink,#171B2C); color:#fff; }

    .icon-btn{
        display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px;
        border:1px solid var(--line,#E9EBF2); background:#fff; color: var(--muted,#667085); cursor:pointer; text-decoration:none; margin-left:4px;
    }
    .icon-btn:hover{ color: var(--ink,#171B2C); border-color:#C9CEDA; }
    .icon-btn-danger:hover{ color:#C62828; border-color:#F3C4C4; background:#FFF6F6; }

    .list-footer{ display:flex; align-items:center; justify-content:space-between; gap:12px; padding:14px 18px; border-top:1px solid var(--line,#E9EBF2); flex-wrap:wrap; }
    .per-page{ display:flex; align-items:center; gap:12px; }
    .per-page select{ border:1px solid var(--input-border,#DBDFEA); border-radius:8px; padding:6px 10px; font-size:12.5px; background:#fff; }
    .showing{ font-size:12.5px; color: var(--faint,#9AA1B2); }
    .list-footer nav{ margin:0; }

    .empty{ text-align:center; padding:56px 20px; }
    .empty-ico{ width:56px; height:56px; border-radius:999px; background:#EEF0F6; display:inline-flex; align-items:center; justify-content:center; font-size:24px; color:#AEB4C4; margin-bottom:12px; }
    .empty h3{ font-size:16px; margin:0 0 6px; color: var(--ink,#171B2C); }
    .empty p{ font-size:13px; color: var(--muted,#667085); margin:0; }
</style>

@endsection
