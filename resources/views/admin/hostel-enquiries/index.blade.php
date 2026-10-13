@extends('admin.layout')
@section('title', 'Hostel Enquiries')
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
        <b>Hostel Enquiries</b>
    </div>

    <div class="header">
        <div>
            <h1>Hostel Enquiries</h1>
            <p>Hostel applications submitted from the public website.</p>
        </div>
    </div>

    @php
        $sortLink = function (string $column, string $label) use ($sortBy, $sortDir, $search, $status, $gender, $perPage) {
            $nextDir = ($sortBy === $column && $sortDir === 'asc') ? 'desc' : 'asc';
            $url = route('admin.hostel-enquiries', array_filter([
                'q'         => $search,
                'status'    => $status,
                'gender'    => $gender,
                'sort'      => $column,
                'dir'       => $nextDir,
                'per_page'  => $perPage !== 10 ? $perPage : null,
            ]));
            $icon = 'bi-arrow-down-up';
            if ($sortBy === $column) {
                $icon = $sortDir === 'asc' ? 'bi-sort-up' : 'bi-sort-down';
            }
            return '<a href="' . e($url) . '" class="sort-link' . ($sortBy === $column ? ' active' : '') . '">'
                . e($label) . ' <i class="bi ' . $icon . '"></i></a>';
        };
    @endphp

    <div class="toolbar">
        <form action="{{ route('admin.hostel-enquiries') }}" method="GET" class="search-form" id="heSearchForm">
            @if (filled($status)) <input type="hidden" name="status" value="{{ $status }}"> @endif
            @if (filled($gender)) <input type="hidden" name="gender" value="{{ $gender }}"> @endif
            @if ($sortBy !== 'created_at') <input type="hidden" name="sort" value="{{ $sortBy }}"> @endif
            @if ($sortDir !== 'desc') <input type="hidden" name="dir" value="{{ $sortDir }}"> @endif
            @if ($perPage !== 10) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
            <i class="bi bi-search search-ico"></i>
            <input type="text" name="q" id="heSearchInput" value="{{ $search }}"
                   placeholder="Search student, parent, phone, email, class..." autocomplete="off">
            @if ($search !== '')
                <a href="{{ route('admin.hostel-enquiries', array_filter(['status' => $status ?: null, 'gender' => $gender ?: null])) }}" class="search-clear">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </form>

        <div class="toolbar-right">
            {{-- Status filter --}}
            <form action="{{ route('admin.hostel-enquiries') }}" method="GET" class="filter-form">
                @if ($search !== '') <input type="hidden" name="q" value="{{ $search }}"> @endif
                @if (filled($gender)) <input type="hidden" name="gender" value="{{ $gender }}"> @endif
                <select name="status" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $key => $label)
                        <option value="{{ $key }}" {{ $status === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </form>

            {{-- Gender filter --}}
            <form action="{{ route('admin.hostel-enquiries') }}" method="GET" class="filter-form">
                @if ($search !== '') <input type="hidden" name="q" value="{{ $search }}"> @endif
                @if (filled($status)) <input type="hidden" name="status" value="{{ $status }}"> @endif
                <select name="gender" onchange="this.form.submit()">
                    <option value="">All Genders</option>
                    <option value="male" {{ $gender === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $gender === 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </form>

            <div class="toolbar-meta">
                {{ $items->total() }} {{ Str::plural('enquiry', $items->total()) }}
            </div>

            <form action="{{ route('admin.hostel-enquiries') }}" method="GET" class="perpage-form">
                @if ($search !== '') <input type="hidden" name="q" value="{{ $search }}"> @endif
                @if (filled($status)) <input type="hidden" name="status" value="{{ $status }}"> @endif
                @if (filled($gender)) <input type="hidden" name="gender" value="{{ $gender }}"> @endif
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
        @if ($items->isEmpty())
            <div class="empty-state">
                <div class="ico-circle" style="width:52px;height:52px;margin:0 auto 12px;">
                    <i class="bi bi-house-door" style="color:#AEB4C4;font-size:22px;"></i>
                </div>
                @if ($search !== '' || filled($status) || filled($gender))
                    <p>No hostel enquiries match your filter.</p>
                    <a href="{{ route('admin.hostel-enquiries') }}" class="choose-btn" style="display:inline-block;width:auto;padding:9px 20px;text-decoration:none;">Clear filters</a>
                @else
                    <p>No hostel enquiries yet.</p>
                @endif
            </div>
        @else
            <div class="table-scroll">
                <table class="news-table">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>{!! $sortLink('student_name', 'Student') !!}</th>
                            <th>{!! $sortLink('age', 'Age') !!}</th>
                            <th>Class</th>
                            <th>Gender</th>
                            <th>{!! $sortLink('parent_name', 'Parent') !!}</th>
                            <th>Phone</th>
                            <th>{!! $sortLink('status', 'Status') !!}</th>
                            <th>{!! $sortLink('created_at', 'Submitted') !!}</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td data-label="Sl No">{{ $items->firstItem() + $loop->index }}</td>
                                <td data-label="Student"><b>{{ $item->student_name }}</b></td>
                                <td data-label="Age">{{ $item->age ?? '—' }}</td>
                                <td data-label="Class">{{ $item->class_name_snapshot ?? '—' }}</td>
                                <td data-label="Gender">{{ ucfirst($item->gender ?? '—') }}</td>
                                <td data-label="Parent">{{ $item->parent_name ?? '—' }}</td>
                                <td data-label="Phone">
                                    @if ($item->parent_phone)
                                        <a href="tel:{{ $item->parent_phone }}" class="link">{{ $item->parent_phone }}</a>
                                    @else — @endif
                                </td>
                                <td data-label="Status">
                                    <span class="badge badge-{{ $item->status }}">{{ $statuses[$item->status] ?? ucfirst($item->status) }}</span>
                                </td>
                                <td data-label="Submitted">{{ $item->created_at?->format('d M Y, h:i A') }}</td>
                                <td data-label="Actions" style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('admin.hostel-enquiries.show', $item) }}" class="icon-btn" title="View details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.hostel-enquiries.destroy', $item) }}" method="POST"
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

    @if ($items->hasPages())
        {{ $items->appends(request()->query())->links() }}
    @endif
</div>

<script>
(function () {
    const input = document.getElementById('heSearchInput');
    const form  = document.getElementById('heSearchForm');
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
            icon: 'warning', title: 'Delete this enquiry?',
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
        font-size:12.5px; background:#fff; cursor:pointer; min-width:140px;
    }
    .perpage-form{ display:flex; align-items:center; gap:8px; font-size:12.5px; color: var(--muted,#667085); }
    .perpage-form select{ min-width:auto; }

    .sort-link{ display:inline-flex; align-items:center; gap:5px; color:inherit; text-decoration:none; }
    .sort-link.active{ color: var(--ink,#171B2C); }
    .sort-link i{ font-size:11px; color: var(--faint,#9AA1B2); }
    .sort-link.active i{ color: var(--orange,#BF0001); }

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

    .badge{
        display:inline-block; font-size:11.5px; font-weight:600; padding:4px 10px;
        border-radius:999px; letter-spacing:.02em;
    }
    .badge-pending   { background:#FFF8E8; color:#B7791F; }
    .badge-in_review { background:#E7ECF1; color:#002F5F; }
    .badge-approved  { background:#E9F8EF; color:#12875A; }
    .badge-rejected  { background:#FFF5F5; color:#B91C1C; }

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

    @media (max-width: 900px){ .toolbar{ flex-direction:column; align-items:stretch; } }
    @media (max-width: 640px){
        .table-scroll{ overflow-x:visible; }
        .news-table thead{ display:none; }
        .news-table, .news-table tbody, .news-table tr, .news-table td{ display:block; width:100%; }
        .news-table tr{ padding:14px 16px; border-bottom:1px solid var(--line,#E9EBF2); }
        .news-table td{ padding:4px 0; border:none; }
        .news-table td[data-label]::before{ content: attr(data-label) ": "; color: var(--faint,#9AA1B2); font-weight:600; font-size:11.5px; }
    }
</style>

@endsection
