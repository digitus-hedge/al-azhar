@extends('admin.layout')
@section('title', 'Facilities')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@php
    $isAdmin = auth()->user()?->role === 'admin';

    // Sortable column header link
    $sortLink = function (string $column, string $label) use ($sortBy, $sortDir) {
        $active = $sortBy === $column;
        $dir    = ($active && $sortDir === 'asc') ? 'desc' : 'asc';
        $url    = request()->fullUrlWithQuery(['sort' => $column, 'dir' => $dir, 'page' => null]);
        $icon   = $active ? ($sortDir === 'asc' ? 'bi-caret-up-fill' : 'bi-caret-down-fill') : 'bi-arrow-down-up';

        return '<a href="' . e($url) . '" class="sort-link' . ($active ? ' active' : '') . '">'
             . e($label) . ' <i class="bi ' . $icon . '"></i></a>';
    };

    // Category tab link (keeps search + per page, resets page)
    $tabUrl = fn (string $key) => request()->fullUrlWithQuery(['category' => $key ?: null, 'page' => null]);
@endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <b>Facilities</b>
    </div>

    <div class="header">
        <div>
            <h1>Facilities</h1>
            <p>Showcase school infrastructure — labs, library, sports, transport and more. Each facility has its own photos and description.</p>
        </div>
        <a href="{{ route('admin.facilities.create', $category ? ['category' => $category] : []) }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Add Facility
        </a>
    </div>

    {{-- Category tabs --}}
    <div class="cat-tabs">
        <a href="{{ $tabUrl('') }}" class="cat-tab {{ $category === '' ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap"></i> All
            <span class="cat-count">{{ $totalCount }}</span>
        </a>
        @foreach ($categories as $key => $label)
            <a href="{{ $tabUrl($key) }}" class="cat-tab {{ $category === $key ? 'active' : '' }}">
                <i class="bi {{ $categoryIcons[$key] ?? 'bi-grid' }}"></i> {{ $label }}
                <span class="cat-count">{{ $counts[$key] ?? 0 }}</span>
            </a>
        @endforeach
    </div>

    <div class="card list-card">
        {{-- Toolbar --}}
  <form method="GET" action="{{ route('admin.facilities') }}" class="toolbar" id="facSearchForm">
            @if ($category)
                <input type="hidden" name="category" value="{{ $category }}">
            @endif
            <input type="hidden" name="sort" value="{{ $sortBy }}">
            <input type="hidden" name="dir" value="{{ $sortDir }}">

            <div class="search-box">
                <i class="bi bi-search"></i>
              <input type="text" name="q" id="facSearchInput" value="{{ $search }}"
       placeholder="Search title, description, location…" autocomplete="off">
                @if ($search !== '')
                    <a href="{{ request()->fullUrlWithQuery(['q' => null, 'page' => null]) }}" class="clear-search" title="Clear">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>

            <div class="per-page">
                <label>Show</label>
                <select name="per_page" onchange="this.form.submit()">
                    @foreach ($perPageOptions as $n)
                        <option value="{{ $n }}" @selected($perPage === $n)>{{ $n }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        @if ($facilities->isEmpty())
            <div class="empty">
                <div class="empty-ico"><i class="bi bi-building"></i></div>
                <h3>No facilities found</h3>
                <p>
                    @if ($search !== '')
                        Nothing matches “{{ $search }}”. Try a different search.
                    @else
                        Add your first {{ $category ? strtolower($categories[$category]) : '' }} facility to show it on the website.
                    @endif
                </p>
                <a href="{{ route('admin.facilities.create', $category ? ['category' => $category] : []) }}" class="btn-add">
                    <i class="bi bi-plus-lg"></i> Add Facility
                </a>
            </div>
        @else
            <div class="table-scroll">
                <table class="fac-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>{!! $sortLink('title', 'Title') !!}</th>
                            <th>{!! $sortLink('category', 'Category') !!}</th>
                            <th>Photos</th>
                            <!-- <th>{!! $sortLink('show_on_home', 'Home') !!}</th>
                            <th>{!! $sortLink('is_active', 'Status') !!}</th>
                            <th>{!! $sortLink('sort_order', 'Order') !!}</th> -->
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($facilities as $facility)
                            <tr>
                                <td>
                                    @if ($facility->image_url)
                                        <img src="{{ $facility->image_url }}" alt="{{ $facility->title }}" class="row-thumb">
                                    @elseif (! empty($facility->gallery_urls))
                                        <img src="{{ $facility->gallery_urls[0] }}" alt="{{ $facility->title }}" class="row-thumb">
                                    @else
                                        <div class="row-thumb row-thumb-placeholder">
                                            <i class="bi {{ $facility->category_icon }}"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <b class="fac-title">{{ $facility->title }}</b>
                                    @if ($facility->short_description)
                                        <div class="fac-sub">{{ \Illuminate\Support\Str::limit($facility->short_description, 80) }}</div>
                                    @endif
                                    @if ($facility->location)
                                        <div class="fac-meta"><i class="bi bi-geo-alt"></i> {{ $facility->location }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="cat-pill cat-{{ $facility->category }}">
                                        <i class="bi {{ $categoryIcons[$facility->category] ?? 'bi-grid' }}"></i>
                                        {{ $facility->category_label }}
                                    </span>
                                </td>
                                <td>
                                    <span class="photo-count"><i class="bi bi-images"></i> {{ $facility->photo_count }}</span>
                                </td>
                               
                                <!-- <td>
                                    @if ($facility->show_on_home)
                                        <span class="badge-yes"><i class="bi bi-house-check"></i> Yes</span>
                                    @else
                                        <span class="badge-muted">&mdash;</span>
                                    @endif
                                </td> -->

                                <!-- <td>
                                    @if ($facility->is_active)
                                        <span class="badge-active"><i class="bi bi-check-circle-fill"></i> Active</span>
                                    @else
                                        <span class="badge-hidden"><i class="bi bi-eye-slash"></i> Hidden</span>
                                    @endif
                                </td> -->

                                <!-- <td>{{ $facility->sort_order }}</td> -->
                                <td style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('admin.facilities.edit', $facility) }}" class="icon-btn" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    @if ($isAdmin)
                                        <button type="button" class="icon-btn icon-btn-danger" title="Delete"
                                                onclick="confirmDeleteFacility({{ $facility->id }}, @js($facility->title))">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $facility->id }}"
                                              action="{{ route('admin.facilities.destroy', $facility) }}"
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

            <div class="list-footer">
                <span class="showing">
                    Showing {{ $facilities->firstItem() }}–{{ $facilities->lastItem() }} of {{ $facilities->total() }}
                </span>
                {{ $facilities->links() }}
            </div>
        @endif
    </div>
</div>

<script>

    // Search as you type (same as the other list pages)
(function () {
    const input = document.getElementById('facSearchInput');
    const form  = document.getElementById('facSearchForm');
    if (!input || !form) return;

    // Keep the cursor at the end of the text after the page reloads
    if (input.value) {
        input.focus();
        const len = input.value.length;
        input.setSelectionRange(len, len);
    }

    let timer = null;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () { form.submit(); }, 450);
    });
})();

function confirmDeleteFacility(id, title) {
    Swal.fire({
        icon: 'warning',
        title: 'Delete facility?',
        html: `<b>${title.replace(/</g, '&lt;')}</b> will be removed from the website.`,
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#BF0001',
        cancelButtonColor: '#667085',
        reverseButtons: true
    }).then(result => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

@if (session('success'))
    Swal.fire({
        icon: 'success',
        title: @js(session('success')),
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true
    });
@endif
</script>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span{ cursor:pointer; transition:color .15s; }
    .crumbs span:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; line-height:1.55; }

    .btn-add{
        display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none; text-decoration:none;
        padding:11px 20px; border-radius:9px; cursor:pointer;
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4); transition:transform .12s, box-shadow .12s;
    }
    .btn-add:hover{ transform:translateY(-1px); box-shadow:0 8px 18px -6px rgba(15,21,38,0.5); color:#fff; }

    /* Category tabs */
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

    /* Toolbar */
    .list-card{ padding:0; overflow:hidden; }
    .toolbar{ display:flex; align-items:center; justify-content:space-between; gap:12px; padding:16px 18px; border-bottom:1px solid var(--line,#E9EBF2); flex-wrap:wrap; }
    .search-box{ position:relative; flex:1; max-width:380px; min-width:200px; }
    .search-box > i{ position:absolute; left:12px; top:50%; transform:translateY(-50%); color: var(--faint,#9AA1B2); font-size:14px; }
    .search-box input{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:9px 34px 9px 36px; font-size:13.5px; font-family:inherit; outline:none; background:#fff;
    }
    .search-box input:focus{ border-color: var(--orange,#BF0001); box-shadow:0 0 0 4px var(--orange-tint-strong,#FFE9D8); }
    .clear-search{ position:absolute; right:10px; top:50%; transform:translateY(-50%); color: var(--faint,#9AA1B2); font-size:12px; }
    .per-page{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--muted,#667085); }
    .per-page select{ border:1px solid var(--input-border,#DBDFEA); border-radius:8px; padding:7px 10px; font-size:13px; background:#fff; }

    /* Table */
    .table-scroll{ overflow-x:auto; }
    .fac-table{ width:100%; border-collapse:collapse; font-size:13.5px; }
    .fac-table th{
        text-align:left; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;
        color: var(--faint,#9AA1B2); padding:12px 16px; background: var(--canvas,#F6F7FB); white-space:nowrap;
    }
    .fac-table td{ padding:12px 16px; border-top:1px solid var(--line,#E9EBF2); vertical-align:middle; color: var(--ink,#171B2C); }
    .fac-table tbody tr:hover{ background:#FAFBFD; }
    .sort-link{ color:inherit; text-decoration:none; display:inline-flex; align-items:center; gap:4px; }
    .sort-link i{ font-size:10px; opacity:.5; }
    .sort-link.active{ color: var(--ink,#171B2C); }
    .sort-link.active i{ opacity:1; color: var(--orange,#BF0001); }

    .row-thumb{ width:64px; height:44px; border-radius:8px; object-fit:cover; display:block; }
    .row-thumb-placeholder{ display:flex; align-items:center; justify-content:center; background:#EEF0F6; color:#AEB4C4; font-size:18px; }
    .fac-title{ font-weight:600; }
    .fac-sub{ font-size:12.5px; color: var(--muted,#667085); margin-top:3px; max-width:360px; }
    .fac-meta{ font-size:12px; color: var(--faint,#9AA1B2); margin-top:3px; }

    .cat-pill{ display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600; white-space:nowrap; }
    .cat-lab       { background:#EEF4FF; color:#2F5BD3; }
    .cat-library   { background:#FFF4E5; color:#B25E00; }
    .cat-sports    { background:#E6F6EC; color:#1E8E4E; }
    .cat-transport { background:#FDF0E6; color:#C2410C; }
    .cat-other     { background:#F2F3F7; color:#555D70; }

    .photo-count{ display:inline-flex; align-items:center; gap:5px; font-size:12.5px; color: var(--muted,#667085); }
    .badge-active, .badge-hidden, .badge-yes{
        display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; white-space:nowrap;
    }
    .badge-active{ background:#E6F6EC; color:#1E8E4E; }
    .badge-hidden{ background:#F2F3F7; color:#667085; }
    .badge-yes{ background:#EEF4FF; color:#2F5BD3; }
    .badge-muted{ color: var(--faint,#9AA1B2); }

    .icon-btn{
        display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px;
        border-radius:8px; border:1px solid var(--line,#E9EBF2); background:#fff; color: var(--muted,#667085);
        cursor:pointer; text-decoration:none; transition:all .15s; margin-left:4px;
    }
    .icon-btn:hover{ color: var(--ink,#171B2C); border-color:#C9CEDA; }
    .icon-btn-danger:hover{ color:#C62828; border-color:#F3C4C4; background:#FFF6F6; }

    .list-footer{ display:flex; align-items:center; justify-content:space-between; gap:12px; padding:14px 18px; border-top:1px solid var(--line,#E9EBF2); flex-wrap:wrap; }
    .showing{ font-size:12.5px; color: var(--faint,#9AA1B2); }
    .list-footer nav{ margin:0; }

    .empty{ text-align:center; padding:56px 20px; }
    .empty-ico{ width:56px; height:56px; border-radius:999px; background:#EEF0F6; display:inline-flex; align-items:center; justify-content:center; font-size:24px; color:#AEB4C4; margin-bottom:12px; }
    .empty h3{ font-size:16px; margin:0 0 6px; color: var(--ink,#171B2C); }
    .empty p{ font-size:13px; color: var(--muted,#667085); margin:0 0 18px; }
</style>

@endsection
