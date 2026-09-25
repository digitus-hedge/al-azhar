@extends('admin.layout')
@section('title', 'School Management')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({ icon: 'success', title: 'Saved!', text: @json(session('success')),
                    confirmButtonColor: '#002F5F', timer: 2500, timerProgressBar: true });
    });
</script>
@endif

@php
    // URL for this page keeping the current state; defaults are dropped to keep URLs short
    $listUrl = function (array $overrides = []) use ($search, $sortBy, $sortDir, $perPage) {
        $params = array_merge([
            'q'        => $search,
            'sort'     => $sortBy !== 'sort_order' ? $sortBy : null,
            'dir'      => $sortDir !== 'asc' ? $sortDir : null,
            'per_page' => $perPage !== 10 ? $perPage : null,
        ], $overrides);

        return route('admin.school-management', array_filter($params, fn ($v) => $v !== null && $v !== ''));
    };

    $sortLink = function (string $column, string $label) use ($sortBy, $sortDir, $listUrl) {
        $isCurrent = $sortBy === $column;
        $nextDir   = $isCurrent && $sortDir === 'asc' ? 'desc' : 'asc';
        $icon      = $isCurrent ? ($sortDir === 'asc' ? 'bi-sort-up' : 'bi-sort-down') : 'bi-arrow-down-up';

        return '<a href="' . e($listUrl(['sort' => $column, 'dir' => $nextDir, 'page' => null])) . '" class="sort-link'
             . ($isCurrent ? ' active' : '') . '">' . e($label) . ' <i class="bi ' . $icon . '"></i></a>';
    };

    $isAdmin = auth()->user()->role === 'admin';
@endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <b>School Management</b>
    </div>

    <div class="header">
        <div>
            <h1>School Management</h1>
            <p>Profiles of the school committee, trustees and institutional leadership shown on the website.</p>
        </div>
        <a href="{{ route('admin.school-management.create') }}" class="btn-save" style="text-decoration:none;">
            <i class="bi bi-plus-lg"></i> Add Profile
        </a>
    </div>

    {{-- Toolbar: search left, count + per page right --}}
    <div class="toolbar">
        <form action="{{ route('admin.school-management') }}" method="GET" class="search-form" id="mmSearchForm">
            @if ($sortBy !== 'sort_order') <input type="hidden" name="sort" value="{{ $sortBy }}"> @endif
            @if ($sortDir !== 'asc') <input type="hidden" name="dir" value="{{ $sortDir }}"> @endif
            @if ($perPage !== 10) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
            <i class="bi bi-search search-ico"></i>
            <input type="text" name="q" id="mmSearchInput" value="{{ $search }}"
                   placeholder="Search by name or designation..." autocomplete="off">
            @if ($search !== '')
                <a href="{{ $listUrl(['q' => null]) }}" class="search-clear" title="Clear search"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>

        <div class="toolbar-right">
            <div class="toolbar-meta">
                {{ $members->total() }} {{ \Illuminate\Support\Str::plural('profile', $members->total()) }}
                @if ($search !== '') for "<b>{{ $search }}</b>" @endif
            </div>

            <form action="{{ route('admin.school-management') }}" method="GET" class="perpage-form">
                @if ($search !== '') <input type="hidden" name="q" value="{{ $search }}"> @endif
                    @if ($sortBy !== 'sort_order') <input type="hidden" name="sort" value="{{ $sortBy }}"> @endif
                @if ($sortDir !== 'asc') <input type="hidden" name="dir" value="{{ $sortDir }}"> @endif
                <label for="mmPerPage">Show</label>
                <select name="per_page" id="mmPerPage" onchange="this.form.submit()">
                    @foreach ($perPageOptions as $n)
                        <option value="{{ $n }}" @selected($perPage === $n)>{{ $n }}</option>
                    @endforeach
                </select>
                <span>per page</span>
            </form>
        </div>
    </div>

    <div class="card" style="padding:0;overflow:hidden;">
        @if ($members->isEmpty())
            <div class="empty-state">
                <div class="ico-circle" style="width:52px;height:52px;margin:0 auto 12px;">
                    <i class="bi bi-people" style="color:#AEB4C4;font-size:22px;"></i>
                </div>
                @if ($search !== '')
                    <p>No profiles match "<b>{{ $search }}</b>".</p>
                    <a href="{{ $listUrl(['q' => null]) }}" class="choose-btn">Clear search</a>
                @else
                    <p>No profiles added yet.</p>
                    <a href="{{ route('admin.school-management.create') }}" class="choose-btn">Add the first profile</a>
                @endif
            </div>
        @else
            <div class="table-scroll">
                <table class="news-table">
                    <thead>
                        <tr>
                            <th>{!! $sortLink('name', 'Name') !!}</th>
                            <th>{!! $sortLink('designation', 'Designation') !!}</th>
                            <!-- <th>{!! $sortLink('is_active', 'Visible') !!}</th> -->
                            <th style="width:110px;text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $m)
                            <tr>
                                <td>
                                    <div class="person">
                                        @if ($m->photo_url)
                                            <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" class="avatar">
                                        @else
                                            <span class="avatar avatar-initials">{{ $m->initials }}</span>
                                        @endif
                                        <div class="person-meta">
                                            <b>{{ $m->name }}</b>
                                            @if ($m->bio)
                                                <small>{{ \Illuminate\Support\Str::limit($m->bio, 60) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="{{ $m->designation?->trashed() ? 'is-deleted' : '' }}">{{ $m->designation_name }}</span>
                                </td>

                                <!-- <td>
                                    <label class="mini-toggle" title="Show / hide on website">
                                        <input type="checkbox" @checked($m->is_active)
                                               onchange="toggleMember(this, '{{ route('admin.school-management.toggle', $m) }}')">
                                        <span></span>
                                    </label>
                                </td> -->

                                <td style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('admin.school-management.edit', $m) }}" class="icon-btn" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if ($isAdmin)
                                        <button type="button" class="icon-btn icon-btn-danger" title="Delete"
                                                onclick="confirmDeleteMember({{ $m->id }}, @js($m->name))">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $m->id }}" action="{{ route('admin.school-management.destroy', $m) }}"
                                              method="POST" style="display:none;">
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
        @endif
    </div>

    {{-- Pagination (same design as Events) --}}
    @if ($members->total() > 0)
        @php
            $current = $members->currentPage();
            $last    = $members->lastPage();
            $start   = max(1, $current - 2);
            $end     = min($last, $start + 4);
            $start   = max(1, min($start, $end - 4));
        @endphp

        <nav class="pager" role="navigation" aria-label="Pagination">
            <div class="pager-status">
                Showing <b>{{ $members->firstItem() }}</b> to <b>{{ $members->lastItem() }}</b>
                of <b>{{ $members->total() }}</b> {{ \Illuminate\Support\Str::plural('result', $members->total()) }}
            </div>

            @if ($members->hasPages())
                <div class="pager-links">
                    @if ($current <= 1)
                        <span class="pager-btn pager-btn-disabled"><i class="bi bi-chevron-left"></i></span>
                    @else
                        <a href="{{ $members->url($current - 1) }}" class="pager-btn" rel="prev"><i class="bi bi-chevron-left"></i></a>
                    @endif

                    @if ($start > 1)
                        <a href="{{ $members->url(1) }}" class="pager-btn">1</a>
                        @if ($start > 2)<span class="pager-dots">&hellip;</span>@endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $current)
                            <span class="pager-btn pager-btn-active">{{ $page }}</span>
                        @else
                            <a href="{{ $members->url($page) }}" class="pager-btn">{{ $page }}</a>
                        @endif
                    @endfor

                    @if ($end < $last)
                        @if ($end < $last - 1)<span class="pager-dots">&hellip;</span>@endif
                        <a href="{{ $members->url($last) }}" class="pager-btn">{{ $last }}</a>
                    @endif

                    @if ($current >= $last)
                        <span class="pager-btn pager-btn-disabled"><i class="bi bi-chevron-right"></i></span>
                    @else
                        <a href="{{ $members->url($current + 1) }}" class="pager-btn" rel="next"><i class="bi bi-chevron-right"></i></a>
                    @endif
                </div>
            @endif
        </nav>
    @endif
</div>

<script>
(function () {
    const input = document.getElementById('mmSearchInput');
    const form  = document.getElementById('mmSearchForm');
    if (!input || !form) return;
    let timer = null;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () { form.submit(); }, 450);
    });
})();

function confirmDeleteMember(id, name) {
    Swal.fire({
        icon: 'warning',
        title: 'Remove profile?',
        text: `"${name}" will be removed from the website.`,
        showCancelButton: true,
        confirmButtonText: 'Yes, remove',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#002F5F',
        cancelButtonColor: '#667085'
    }).then((r) => { if (r.isConfirmed) document.getElementById(`delete-form-${id}`).submit(); });
}

function toggleMember(checkbox, url) {
    fetch(url, {
        method: 'PATCH',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.ok ? r.json() : Promise.reject())
    .then(data => {
        checkbox.checked = data.is_active;
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: data.message, showConfirmButton: false, timer: 1800 });
    })
    .catch(() => {
        checkbox.checked = !checkbox.checked;
        Swal.fire({ icon: 'error', title: 'Error', text: 'Could not update visibility.', confirmButtonColor: '#002F5F' });
    });
}
</script>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span:first-child{ cursor:pointer; transition:color .15s; }
    .crumbs span:first-child:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0;  line-height:1.55; }

    .btn-save{
        display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none;
        padding:11px 22px; border-radius:9px; cursor:pointer;
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4); transition:transform .12s ease, box-shadow .12s ease;
    }
    .btn-save:hover{ transform:translateY(-1px); box-shadow:0 8px 18px -6px rgba(15,21,38,0.5); }

    .tabs{ display:flex; gap:4px; margin-bottom:16px; border-bottom:1px solid var(--line,#E9EBF2); overflow-x:auto; }
    .tab{
        display:inline-flex; align-items:center; gap:7px; padding:10px 14px; font-size:13px; font-weight:600; white-space:nowrap;
        color: var(--muted,#667085); text-decoration:none; border-bottom:2px solid transparent; margin-bottom:-1px;
    }
    .tab:hover{ color: var(--ink,#171B2C); }
    .tab.on{ color: var(--ink,#171B2C); border-bottom-color: var(--orange,#BF0001); }
    .tab-count{ font-size:11px; font-weight:700; background:#EEF0F6; color: var(--muted,#667085); padding:2px 7px; border-radius:999px; }

    .toolbar{ display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:16px; flex-wrap:wrap; }
    .search-form{ position:relative; display:flex; align-items:center; flex:1; min-width:240px; max-width:380px; }
    .search-ico{ position:absolute; left:14px; color: var(--faint,#9AA1B2); font-size:14px; pointer-events:none; }
    .search-form input[type=text]{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:10px 36px; font-size:13.5px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; background:#fff; transition:box-shadow .15s, border-color .15s;
    }
    .search-form input[type=text]:focus{ border-color: var(--orange,#BF0001); box-shadow: 0 0 0 4px var(--orange-tint-strong,#FFE9D8); }
    .search-clear{
        position:absolute; right:10px; width:22px; height:22px; border-radius:999px; background:#EEF0F6;
        display:flex; align-items:center; justify-content:center; color: var(--muted,#667085); font-size:10px; text-decoration:none;
    }
    .toolbar-right{ display:flex; align-items:center; gap:18px; flex-wrap:wrap; }
    .toolbar-meta{ font-size:12.5px; color: var(--faint,#9AA1B2); white-space:nowrap; }
    .toolbar-meta b{ color: var(--ink,#171B2C); font-weight:600; }

    .perpage-form{ display:flex; align-items:center; gap:8px; font-size:12.5px; color: var(--muted,#667085); white-space:nowrap; }
    .perpage-form select{
        border:1px solid var(--input-border,#DBDFEA); border-radius:8px; padding:6px 28px 6px 10px;
        font-size:12.5px; font-family:inherit; color: var(--ink,#171B2C); background:#fff; outline:none; cursor:pointer; appearance:none;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23667085' stroke-width='1.5' fill='none' fill-rule='evenodd'/%3E%3C/svg%3E");
        background-repeat:no-repeat; background-position:right 10px center;
    }
    .perpage-form select:focus{ border-color: var(--orange,#BF0001); }

    .sort-link{ display:inline-flex; align-items:center; gap:5px; color:inherit; text-decoration:none; }
    .sort-link:hover{ color: var(--orange,#BF0001); }
    .sort-link.active{ color: var(--ink,#171B2C); }
    .sort-link i{ font-size:11px; color: var(--faint,#9AA1B2); }
    .sort-link.active i{ color: var(--orange,#BF0001); }

    .table-scroll{ overflow-x:auto; }
    .news-table{ width:100%; border-collapse:collapse; }
    .news-table th{
        text-align:left; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; white-space:nowrap;
        color: var(--faint,#9AA1B2); padding:14px 20px; border-bottom:1px solid var(--line,#E9EBF2); background:#FAFBFD;
    }
    .news-table td{ padding:12px 20px; border-bottom:1px solid var(--line,#E9EBF2); font-size:13.5px; color: var(--ink,#171B2C); vertical-align:middle; }
    .news-table tbody tr:last-child td{ border-bottom:none; }
    .news-table tbody tr:hover{ background:#FAFBFD; }
    .muted-sub{ font-size:12.5px; color: var(--muted,#667085); }

    .is-deleted{ color:#8A92A6; text-decoration:line-through; }
    .person{ display:flex; align-items:center; gap:12px; min-width:220px; }
    .avatar{ width:40px; height:40px; border-radius:999px; object-fit:cover; flex-shrink:0; display:block; }
    .avatar-initials{ background:#EEF0F6; color:#5B6378; font-size:13px; font-weight:700; display:flex; align-items:center; justify-content:center; }
    .person-meta{ display:flex; flex-direction:column; min-width:0; }
    .person-meta small{ font-size:12px; color: var(--faint,#9AA1B2); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:320px; }

    .badge-group{ display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:600; padding:4px 10px; border-radius:999px; white-space:nowrap; }
    .badge-group.g-committee { background:#EEF2FF; color:#3538CD; }
    .badge-group.g-trustee   { background:#ECFDF3; color:#067647; }
    .badge-group.g-leadership{ background:#FFF4E5; color:#B25E00; }

    .mini-toggle{ position:relative; display:inline-block; width:36px; height:20px; cursor:pointer; }
    .mini-toggle input{ position:absolute; opacity:0; width:0; height:0; }
    .mini-toggle span{ position:absolute; inset:0; border-radius:999px; background:#DBDFEA; transition:background .15s; }
    .mini-toggle span::after{ content:''; position:absolute; top:2px; left:2px; width:16px; height:16px; border-radius:999px;
                              background:#fff; box-shadow:0 1px 2px rgba(0,0,0,.2); transition:transform .15s; }
    .mini-toggle input:checked + span{ background: var(--orange,#BF0001); }
    .mini-toggle input:checked + span::after{ transform:translateX(16px); }

    .icon-btn{
        display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px;
        border-radius:8px; border:1px solid var(--line,#E9EBF2); background:#fff; color: var(--muted,#667085);
        cursor:pointer; margin-left:6px; text-decoration:none; transition:background .15s, color .15s, border-color .15s;
    }
    .icon-btn:hover{ background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); }
    .icon-btn-danger:hover{ background:#FFF5F5; color:#e74c3c; border-color:#F5C6C6; }

    .empty-state{ text-align:center; padding:60px 20px; }
    .empty-state p{ font-size:13.5px; color: var(--muted,#667085); margin:0 0 16px; }
    .ico-circle{ border-radius:999px; background:#EEF0F6; display:flex; align-items:center; justify-content:center; }
    .choose-btn{
        display:inline-block; font-size:12px; font-weight:600; color: var(--orange,#BF0001); text-decoration:none;
        background:#fff; border:1px solid var(--orange-border,#F3D8C2); border-radius:8px; padding:9px 20px;
    }
    .choose-btn:hover{ background: var(--orange-tint,#FFF8F3); }

    /* Pager — same as Events */
    .pager{ display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-top:20px; }
    .pager-status{ font-size:12.5px; color: var(--faint,#9AA1B2); }
    .pager-status b{ color: var(--ink,#171B2C); font-weight:600; }
    .pager-links{ display:flex; align-items:center; gap:4px; flex-wrap:wrap; }
    .pager-btn{
        display:inline-flex; align-items:center; justify-content:center; min-width:32px; height:32px; padding:0 8px; border-radius:8px;
        border:1px solid var(--line,#E9EBF2); background:#fff; font-size:12.5px; font-weight:600; color: var(--muted,#667085);
        text-decoration:none; transition:background .15s, color .15s;
    }
    .pager-btn:hover{ background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); }
    .pager-btn-active{ background:linear-gradient(135deg, #0F1526, #1D2439); border-color:transparent; color:#fff; }
    .pager-btn-active:hover{ color:#fff; }
    .pager-btn-disabled{ opacity:.4; cursor:not-allowed; }
    .pager-dots{ padding:0 4px; color: var(--faint,#9AA1B2); font-size:12.5px; }
</style>

@endsection
