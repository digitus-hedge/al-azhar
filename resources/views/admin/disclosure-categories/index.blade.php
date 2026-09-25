@extends('admin.layout')
@section('title', 'Disclosure Categories')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: @json(session('success')),
            confirmButtonColor: '#002F5F',
            timer: 2500,
            timerProgressBar: true
        });
    });
</script>
@endif

@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({ icon: 'error', title: 'Not allowed', text: @json(session('error')), confirmButtonColor: '#002F5F' });
    });
</script>
@endif

@php
    // Builds a URL for this page, keeping current state and dropping defaults
    $listUrl = function (array $overrides = []) use ($search, $sortBy, $sortDir, $perPage, $trashed) {
        $params = array_merge([
            'q'        => $search,
            'trashed'  => $trashed ? 1 : null,
            'sort'     => $sortBy !== 'name' ? $sortBy : null,
            'dir'      => $sortDir !== 'asc' ? $sortDir : null,
            'per_page' => $perPage !== 10 ? $perPage : null,
        ], $overrides);

        return route('admin.disclosure-categories', array_filter($params, fn ($v) => $v !== null && $v !== ''));
    };

    $sortLink = function (string $column, string $label) use ($sortBy, $sortDir, $listUrl) {
        $nextDir = ($sortBy === $column && $sortDir === 'asc') ? 'desc' : 'asc';
        $url = $listUrl(['sort' => $column, 'dir' => $nextDir, 'page' => null]);
        $icon = 'bi-arrow-down-up';
        if ($sortBy === $column) {
            $icon = $sortDir === 'asc' ? 'bi-sort-up' : 'bi-sort-down';
        }
        return '<a href="' . e($url) . '" class="sort-link' . ($sortBy === $column ? ' active' : '') . '">'
            . e($label) . ' <i class="bi ' . $icon . '"></i></a>';
    };

    $isAdmin = auth()->user()->role === 'admin';
@endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <span class="plain">Master</span>
        <span>&rsaquo;</span>
        <b>Disclosure Categories</b>
    </div>

    <div class="header">
        <div>
            <h1>Disclosure Categories</h1>
            <p>Categories used to group Mandatory Disclosure documents, such as CBSE Affiliation, NOC, Trust Deed and Safety Certificates.</p>
        </div>
        <a href="{{ route('admin.disclosure-categories.create') }}" class="btn-save" style="text-decoration:none;">
            <i class="bi bi-plus-lg"></i>
            Add Category
        </a>
    </div>

    

    <div class="toolbar">
        <form action="{{ route('admin.disclosure-categories') }}" method="GET" class="search-form" id="catSearchForm">
            @if ($trashed) <input type="hidden" name="trashed" value="1"> @endif
            @if ($sortBy !== 'name') <input type="hidden" name="sort" value="{{ $sortBy }}"> @endif
            @if ($sortDir !== 'asc') <input type="hidden" name="dir" value="{{ $sortDir }}"> @endif
            @if ($perPage !== 10) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
            <i class="bi bi-search search-ico"></i>
            <input type="text" name="q" id="catSearchInput" value="{{ $search }}"
                   placeholder="Search categories..." autocomplete="off">
            @if ($search !== '')
                <a href="{{ $listUrl(['q' => null]) }}" class="search-clear" title="Clear search">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </form>

              <div class="toolbar-right">
            <div class="toolbar-meta">
                {{ $categories->total() }} {{ \Illuminate\Support\Str::plural('category', $categories->total()) }}
                @if ($search !== '') for "<b>{{ $search }}</b>" @endif
            </div>

            <form action="{{ route('admin.disclosure-categories') }}" method="GET" class="perpage-form" id="catPerPageForm">
                @if ($search !== '') <input type="hidden" name="q" value="{{ $search }}"> @endif
                @if ($trashed) <input type="hidden" name="trashed" value="1"> @endif
                @if ($sortBy !== 'name') <input type="hidden" name="sort" value="{{ $sortBy }}"> @endif
                @if ($sortDir !== 'asc') <input type="hidden" name="dir" value="{{ $sortDir }}"> @endif
                <label for="catPerPageSelect">Show</label>
                <select name="per_page" id="catPerPageSelect" onchange="this.form.submit()">
                    @foreach ($perPageOptions as $option)
                        <option value="{{ $option }}" @selected($perPage === $option)>{{ $option }}</option>
                    @endforeach
                </select>
                <span>per page</span>
            </form>
        </div>

    </div>

    <div class="card" style="padding:0;overflow:hidden;">
        @if ($categories->isEmpty())
            <div class="empty-state">
                <div class="ico-circle" style="width:52px;height:52px;margin:0 auto 12px;">
                    <i class="bi bi-folder2-open" style="color:#AEB4C4;font-size:22px;"></i>
                </div>
                @if ($search !== '')
                    <p>No categories match "<b>{{ $search }}</b>".</p>
                    <a href="{{ $listUrl(['q' => null]) }}" class="choose-btn">Clear search</a>
                @elseif ($trashed)
                    <p>Trash is empty.</p>
                @else
                    <p>No disclosure categories added yet.</p>
                    <a href="{{ route('admin.disclosure-categories.create') }}" class="choose-btn">Add the first category</a>
                @endif
            </div>
        @else
            <table class="news-table">
                <thead>
                    <tr>
                        <th style="width:70px;">#</th>
                        <th>{!! $sortLink('name', 'Category Name') !!}</th>
                        @if ($trashed)
                            <th>Deleted On</th>
                        @else
                            <th>{!! $sortLink('updated_at', 'Last Updated') !!}</th>
                        @endif
                        <th style="width:130px;text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td class="muted-sub">{{ $categories->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="cat-name">
                                    <span class="cat-ico"><i class="bi bi-folder2"></i></span>
                                    <b>{{ $category->name }}</b>
                                </div>
                            </td>
                            <td>
                                @if ($trashed)
                                    {{ optional($category->deleted_at)->format('d M Y') }}
                                    <br><span class="muted-sub">{{ optional($category->deleted_at)->format('h:i A') }}</span>
                                @else
                                    {{ optional($category->updated_at)->format('d M Y') }}
                                    <br><span class="muted-sub">{{ optional($category->updated_at)->diffForHumans() }}</span>
                                @endif
                            </td>
                            <td style="text-align:right;white-space:nowrap;">
                                @if ($trashed)
                                    <button type="button" class="icon-btn" title="Restore"
                                            onclick="confirmRestore({{ $category->id }}, @js($category->name))">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                    <form id="restore-form-{{ $category->id }}"
                                          action="{{ route('admin.disclosure-categories.restore', $category->id) }}"
                                          method="POST" style="display:none;">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @else
                                    <a href="{{ route('admin.disclosure-categories.edit', $category) }}" class="icon-btn" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    @if ($isAdmin)
                                        <button type="button" class="icon-btn icon-btn-danger" title="Delete"
                                                onclick="confirmDelete({{ $category->id }}, @js($category->name))">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $category->id }}"
                                              action="{{ route('admin.disclosure-categories.destroy', $category) }}"
                                              method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Pagination (same design as Events) --}}
    @if ($categories->total() > 0)
        @php
            $current = $categories->currentPage();
            $last    = $categories->lastPage();
            $start   = max(1, $current - 2);
            $end     = min($last, $start + 4);
            $start   = max(1, min($start, $end - 4));
        @endphp

      
    @endif
</div>

<script>
(function () {
    const input = document.getElementById('catSearchInput');
    const form = document.getElementById('catSearchForm');
    if (!input || !form) return;

    let timer = null;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () { form.submit(); }, 450);
    });
})();

function confirmDelete(id, name) {
    Swal.fire({
        icon: 'warning',
        title: 'Remove category?',
        text: `"${name}" will be moved to Trash. You can restore it later.`,
        showCancelButton: true,
        confirmButtonText: 'Yes, remove',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#002F5F',
        cancelButtonColor: '#667085'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById(`delete-form-${id}`).submit();
    });
}

function confirmRestore(id, name) {
    Swal.fire({
        icon: 'question',
        title: 'Restore category?',
        text: `"${name}" will be active again.`,
        showCancelButton: true,
        confirmButtonText: 'Yes, restore',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#002F5F',
        cancelButtonColor: '#667085'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById(`restore-form-${id}`).submit();
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
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4);
        transition:transform .12s ease, box-shadow .12s ease;
    }
    .btn-save:hover{ transform:translateY(-1px); box-shadow:0 8px 18px -6px rgba(15,21,38,0.5); }

    .tabs{ display:flex; gap:6px; margin-bottom:16px; border-bottom:1px solid var(--line,#E9EBF2); }
    .tab{
        display:inline-flex; align-items:center; gap:7px; padding:10px 14px; font-size:13px; font-weight:600;
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
    .search-clear:hover{ background:#E2E5EE; color: var(--ink,#171B2C); }

    .toolbar-right{ display:flex; align-items:center; gap:18px; flex-wrap:wrap; }
    .toolbar-meta{ font-size:12.5px; color: var(--faint,#9AA1B2); white-space:nowrap; }
    .toolbar-meta b{ color: var(--ink,#171B2C); font-weight:600; }

    .sort-link{ display:inline-flex; align-items:center; gap:5px; color:inherit; text-decoration:none; transition:color .15s; }
    .sort-link:hover{ color: var(--orange,#BF0001); }
    .sort-link.active{ color: var(--ink,#171B2C); }
    .sort-link i{ font-size:11px; color: var(--faint,#9AA1B2); }
    .sort-link.active i{ color: var(--orange,#BF0001); }

    .news-table{ width:100%; border-collapse:collapse; }
    .news-table th{
        text-align:left; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;
        color: var(--faint,#9AA1B2); padding:14px 20px; border-bottom:1px solid var(--line,#E9EBF2); background:#FAFBFD;
    }
    .news-table td{ padding:12px 20px; border-bottom:1px solid var(--line,#E9EBF2); font-size:13.5px; color: var(--ink,#171B2C); vertical-align:middle; }
    .news-table tbody tr:last-child td{ border-bottom:none; }
    .news-table tbody tr:hover{ background:#FAFBFD; }
    .muted-sub{ font-size:12px; color: var(--faint,#9AA1B2); }

    .cat-name{ display:flex; align-items:center; gap:10px; }
    .cat-ico{ width:32px; height:32px; border-radius:8px; background:#EEF0F6; color:#8A92A6; display:flex; align-items:center; justify-content:center; font-size:14px; flex-shrink:0; }

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
    }
    .perpage-form select:focus{ border-color: var(--orange,#BF0001); }
</style>

@endsection
