@extends('admin.layout')
@section('title', 'Event Responses')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success', title: 'Done!',
            text: @json(session('success')),
            confirmButtonColor: '#002F5F', timer: 2200, timerProgressBar: true
        });
    });
</script>
@endif

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <b>Event Responses</b>
    </div>

    <div class="header">
        <div>
            <h1>Event Responses</h1>
            <p>Visitor responses submitted for events from the public website.</p>
        </div>
    </div>

    <div class="toolbar">
        <form action="{{ route('admin.event-responses.index') }}" method="GET" class="search-form" id="erSearchForm">
            @if (request()->filled('event_id')) <input type="hidden" name="event_id" value="{{ request('event_id') }}"> @endif
            @if ($perPage !== 10) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
            <i class="bi bi-search search-ico"></i>
            <input type="text" name="search" id="erSearchInput" value="{{ request('search') }}"
                   placeholder="Search name, phone, comment, event..." autocomplete="off">
            @if (request('search'))
                <a href="{{ route('admin.event-responses.index', array_filter(['event_id' => request('event_id') ?: null, 'per_page' => $perPage !== 10 ? $perPage : null])) }}" class="search-clear">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </form>

        <div class="toolbar-right">
            {{-- Event filter --}}
            <form action="{{ route('admin.event-responses.index') }}" method="GET" class="filter-form">
                @if (request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                @if ($perPage !== 10) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
                <select name="event_id" onchange="this.form.submit()">
                    <option value="">All Events</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                    @endforeach
                </select>
            </form>

            <div class="toolbar-meta">
                {{ $responses->total() }} {{ Str::plural('response', $responses->total()) }}
            </div>

            <form action="{{ route('admin.event-responses.index') }}" method="GET" class="perpage-form">
                @if (request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                @if (request('event_id')) <input type="hidden" name="event_id" value="{{ request('event_id') }}"> @endif
                <label>Show</label>
                <select name="per_page" onchange="this.form.submit()">
                    @foreach ($perPageOptions as $option)
                        <option value="{{ $option }}" {{ $perPage == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
                <span>per page</span>
            </form>
        </div>
    </div>

    <div class="card" style="padding:0;overflow:hidden;">
        @if ($responses->isEmpty())
            <div class="empty-state">
                <div class="ico-circle" style="width:52px;height:52px;margin:0 auto 12px;">
                    <i class="bi bi-calendar-check" style="color:#AEB4C4;font-size:22px;"></i>
                </div>
                @if (request('search') || request('event_id'))
                    <p>No event responses match your filter.</p>
                    <a href="{{ route('admin.event-responses.index') }}" class="choose-btn"
                       style="display:inline-block;width:auto;padding:9px 20px;text-decoration:none;">
                       Clear filters
                    </a>
                @else
                    <p>No event responses yet.</p>
                @endif
            </div>
        @else
            <div class="table-scroll">
                <table class="news-table">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Event</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Comment</th>
                            <th>Submitted</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($responses as $r)
                            <tr>
                                <td data-label="Sl No">{{ $responses->firstItem() + $loop->index }}</td>
                                <td data-label="Event">
                                    <b>{{ $r->event->title ?? 'N/A' }}</b>
                                </td>
                                <td data-label="Name"><b>{{ $r->name }}</b></td>
                                <td data-label="Phone">
                                    @if ($r->phone)
                                        <a href="tel:{{ $r->phone }}" class="link">{{ $r->phone }}</a>
                                    @else — @endif
                                </td>
                                <td data-label="Comment" style="max-width:260px;color:var(--muted,#667085);">
                                    {{ \Illuminate\Support\Str::limit($r->comment, 60) ?: '—' }}
                                </td>
                                <td data-label="Submitted">{{ $r->created_at?->format('d M Y, h:i A') }}</td>
                                <td data-label="Actions" style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('admin.event-responses.show', $r->id) }}" class="icon-btn" title="View details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.event-responses.destroy', $r->id) }}" method="POST"
                                          class="delete-form" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="icon-btn icon-btn-danger delete-btn" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ============== PAGINATION (same style as Events page) ============== --}}
    @if ($responses->hasPages())
        @php
            $pageUrl = function (int $page) use ($perPage) {
                return route('admin.event-responses.index', array_filter([
                    'search'   => request('search') ?: null,
                    'event_id' => request('event_id') ?: null,
                    'per_page' => $perPage !== 10 ? $perPage : null,
                    'page'     => $page > 1 ? $page : null,
                ]));
            };

            $current = $responses->currentPage();
            $last    = $responses->lastPage();
            $start   = max(1, $current - 2);
            $end     = min($last, $start + 4);
            $start   = max(1, min($start, $end - 4));
        @endphp

        <nav class="pager" role="navigation" aria-label="Pagination">
            <div class="pager-status">
                Showing <b>{{ $responses->firstItem() }}</b> to <b>{{ $responses->lastItem() }}</b>
                of <b>{{ $responses->total() }}</b> {{ Str::plural('result', $responses->total()) }}
            </div>

            <div class="pager-links">
                @if ($current <= 1)
                    <span class="pager-btn pager-btn-disabled" aria-disabled="true"><i class="bi bi-chevron-left"></i></span>
                @else
                    <a href="{{ $pageUrl($current - 1) }}" class="pager-btn" rel="prev"><i class="bi bi-chevron-left"></i></a>
                @endif

                @if ($start > 1)
                    <a href="{{ $pageUrl(1) }}" class="pager-btn">1</a>
                    @if ($start > 2)<span class="pager-dots">&hellip;</span>@endif
                @endif

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $current)
                        <span class="pager-btn pager-btn-active">{{ $page }}</span>
                    @else
                        <a href="{{ $pageUrl($page) }}" class="pager-btn">{{ $page }}</a>
                    @endif
                @endfor

                @if ($end < $last)
                    @if ($end < $last - 1)<span class="pager-dots">&hellip;</span>@endif
                    <a href="{{ $pageUrl($last) }}" class="pager-btn">{{ $last }}</a>
                @endif

                @if ($current >= $last)
                    <span class="pager-btn pager-btn-disabled" aria-disabled="true"><i class="bi bi-chevron-right"></i></span>
                @else
                    <a href="{{ $pageUrl($current + 1) }}" class="pager-btn" rel="next"><i class="bi bi-chevron-right"></i></a>
                @endif
            </div>
        </nav>
    @endif
    {{-- ============== END PAGINATION ============== --}}

</div>

<script>
(function () {
    const input = document.getElementById('erSearchInput');
    const form  = document.getElementById('erSearchForm');
    if (!input || !form) return;
    let timer = null;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(() => form.submit(), 450);
    });
})();

document.querySelectorAll('.delete-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const form = btn.closest('.delete-form');
        Swal.fire({
            icon: 'warning', title: 'Delete this response?',
            text: 'This cannot be undone.', showCancelButton: true,
            confirmButtonText: 'Yes, delete it', cancelButtonText: 'Cancel',
            confirmButtonColor: '#002F5F', cancelButtonColor: '#667085',
            reverseButtons: true
        }).then(function (result) {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span:first-child{ cursor:pointer; }
    .crumbs span:first-child:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:560px; line-height:1.55; }

    .toolbar{ display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:16px; flex-wrap:wrap; }
    .search-form{ position:relative; display:flex; align-items:center; flex:1; min-width:240px; max-width:380px; }
    .search-ico{ position:absolute; left:14px; color: var(--faint,#9AA1B2); font-size:14px; pointer-events:none; }
    .search-form input[type=text]{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:10px 36px; font-size:13.5px; color: var(--ink,#171B2C); outline:none; background:#fff;
    }
    .search-clear{
        position:absolute; right:10px; width:22px; height:22px; border-radius:999px; background:#EEF0F6;
        display:flex; align-items:center; justify-content:center; color: var(--muted,#667085); font-size:10px;
        text-decoration:none;
    }

    .toolbar-right{ display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
    .toolbar-meta{ font-size:12.5px; color: var(--faint,#9AA1B2); white-space:nowrap; }

    .filter-form select, .perpage-form select{
        border:1px solid var(--input-border,#DBDFEA); border-radius:8px; padding:7px 28px 7px 10px;
        font-size:12.5px; background:#fff; cursor:pointer; min-width:160px;
        appearance:none;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23667085' stroke-width='1.5' fill='none' fill-rule='evenodd'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:right 10px center;
    }
    .perpage-form{
        display:flex; align-items:center; gap:8px;
        font-size:12.5px; color: var(--muted,#667085); white-space:nowrap;
    }
    .perpage-form select{ min-width:auto; }

    .table-scroll{ overflow-x:auto; }
    .news-table{ width:100%; border-collapse:collapse; }
    .news-table th{
        text-align:left; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;
        color: var(--faint,#9AA1B2); padding:14px 16px; border-bottom:1px solid var(--line,#E9EBF2); background:#FAFBFD;
        white-space:nowrap;
    }
    .news-table td{ padding:12px 16px; border-bottom:1px solid var(--line,#E9EBF2); font-size:13px; color: var(--ink,#171B2C); vertical-align:middle; }
    .news-table tbody tr:last-child td{ border-bottom:none; }
    .news-table tbody tr:hover{ background:#FAFBFD; }

    .link{ color:#002F5F; text-decoration:none; }
    .link:hover{ text-decoration:underline; }

    .icon-btn{
        display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px;
        border-radius:8px; border:1px solid var(--line,#E9EBF2); background:#fff; color: var(--muted,#667085);
        cursor:pointer; margin-left:6px; text-decoration:none;
    }
    .icon-btn:hover{ background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); }
    .icon-btn-danger:hover{ background:#FFF5F5; color:#e74c3c; border-color:#F5C6C6; }

    .empty-state{ text-align:center; padding:60px 20px; }
    .empty-state p{ font-size:13.5px; color: var(--muted,#667085); margin:0 0 16px; }
    .ico-circle{ border-radius:999px; background:#EEF0F6; display:flex; align-items:center; justify-content:center; }
    .choose-btn{
        font-size:12px; font-weight:600; color: var(--orange,#BF0001);
        background:#fff; border:1px solid var(--orange-border,#F3D8C2); border-radius:8px; padding:7px 0;
    }

    /* ================= PAGINATION ================= */
    .pager{
        display:flex; align-items:center; justify-content:space-between;
        gap:16px; flex-wrap:wrap; margin-top:20px;
    }
    .pager-status{ font-size:12.5px; color: var(--faint,#9AA1B2); }
    .pager-status b{ color: var(--ink,#171B2C); font-weight:600; }
    .pager-links{ display:flex; align-items:center; gap:4px; }
    .pager-btn{
        display:inline-flex; align-items:center; justify-content:center;
        min-width:32px; height:32px; padding:0 8px; border-radius:8px;
        border:1px solid var(--line,#E9EBF2); background:#fff;
        font-size:12.5px; font-weight:600; color: var(--muted,#667085);
        text-decoration:none; cursor:pointer;
        transition:background .15s, color .15s, border-color .15s;
    }
    .pager-btn:hover{ background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); }
    .pager-btn-active{
        background:linear-gradient(135deg, #0F1526, #1D2439);
        border-color:transparent; color:#fff;
    }
    .pager-btn-active:hover{ color:#fff; }
    .pager-btn-disabled{ opacity:.4; cursor:not-allowed; }
    .pager-btn-disabled:hover{ background:#fff; color: var(--muted,#667085); }
    .pager-dots{ padding:0 4px; color: var(--faint,#9AA1B2); font-size:12.5px; }

    @media (max-width: 900px){ .toolbar{ flex-direction:column; align-items:stretch; } }
    @media (max-width: 640px){
        .table-scroll{ overflow-x:visible; }
        .news-table thead{ display:none; }
        .news-table, .news-table tbody, .news-table tr, .news-table td{ display:block; width:100%; }
        .news-table tr{ padding:14px 16px; border-bottom:1px solid var(--line,#E9EBF2); }
        .news-table td{ padding:4px 0; border:none; }
        .news-table td[data-label]::before{ content: attr(data-label) ": "; color: var(--faint,#9AA1B2); font-weight:600; font-size:11.5px; }

        .pager{ flex-direction:column; align-items:center; gap:12px; }
        .pager-links{ flex-wrap:wrap; justify-content:center; }
        .pager-btn{ min-width:36px; height:36px; }
    }
</style>

@endsection