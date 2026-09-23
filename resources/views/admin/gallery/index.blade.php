@extends('admin.layout')
@section('title', 'Gallery')
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

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <b>Gallery</b>
    </div>

    <div class="header">
        <div>
            <h1>Gallery</h1>
            <p>Manage the photos and videos shown in your site's gallery.</p>
        </div>
        <a href="{{ route('admin.gallery.create') }}" class="btn-save" style="text-decoration:none;">
            <i class="bi bi-plus-lg"></i>
            Add Gallery Item
        </a>
    </div>

    @php
        $sortLink = function (string $column, string $label) use ($sortBy, $sortDir, $search, $perPage) {
            $nextDir = ($sortBy === $column && $sortDir === 'asc') ? 'desc' : 'asc';
            $url = route('admin.gallery', array_filter([
                'q'        => $search,
                'sort'     => $column,
                'dir'      => $nextDir,
                'per_page' => $perPage !== 10 ? $perPage : null,
            ]));
            $icon = 'bi-arrow-down-up';
            if ($sortBy === $column) {
                $icon = $sortDir === 'asc' ? 'bi-sort-up' : 'bi-sort-down';
            }
            return '<a href="' . $url . '" class="sort-link' . ($sortBy === $column ? ' active' : '') . '">'
                . e($label) . ' <i class="bi ' . $icon . '"></i></a>';
        };
    @endphp

    <div class="toolbar">
        <form action="{{ route('admin.gallery') }}" method="GET" class="search-form" id="gallerySearchForm">
            @if ($sortBy !== 'sort_order') <input type="hidden" name="sort" value="{{ $sortBy }}"> @endif
            @if ($sortDir !== 'asc') <input type="hidden" name="dir" value="{{ $sortDir }}"> @endif
            @if ($perPage !== 10) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
            <i class="bi bi-search search-ico"></i>
            <input type="text" name="q" id="gallerySearchInput" value="{{ $search }}"
                   placeholder="Search by title..." autocomplete="off">
            @if ($search !== '')
                <a href="{{ route('admin.gallery', array_filter(['sort' => $sortBy !== 'sort_order' ? $sortBy : null, 'dir' => $sortDir !== 'asc' ? $sortDir : null, 'per_page' => $perPage !== 10 ? $perPage : null])) }}" class="search-clear" title="Clear search">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </form>

        <div class="toolbar-right">
            <div class="toolbar-meta">
                {{ $items->total() }} {{ Str::plural('item', $items->total()) }}
                @if ($search !== '') for "<b>{{ $search }}</b>" @endif
            </div>

            <form action="{{ route('admin.gallery') }}" method="GET" class="perpage-form" id="galleryPerPageForm">
                @if ($search !== '') <input type="hidden" name="q" value="{{ $search }}"> @endif
                @if ($sortBy !== 'sort_order') <input type="hidden" name="sort" value="{{ $sortBy }}"> @endif
                @if ($sortDir !== 'asc') <input type="hidden" name="dir" value="{{ $sortDir }}"> @endif
                <label for="galleryPerPageSelect">Show</label>
                <select name="per_page" id="galleryPerPageSelect" onchange="this.form.submit()">
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
                    <i class="bi bi-images" style="color:#AEB4C4;font-size:22px;"></i>
                </div>
                @if ($search !== '')
                    <p>No gallery items match "<b>{{ $search }}</b>".</p>
                    <a href="{{ route('admin.gallery') }}" class="choose-btn" style="display:inline-block;width:auto;padding:9px 20px;text-decoration:none;">Clear search</a>
                @else
                    <p>No gallery items added yet.</p>
                    <a href="{{ route('admin.gallery.create') }}" class="choose-btn" style="display:inline-block;width:auto;padding:9px 20px;text-decoration:none;">Add the first item</a>
                @endif
            </div>
        @else
            <table class="news-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>{!! $sortLink('title', 'Title') !!}</th>
                        <th>{!! $sortLink('media_type', 'Type') !!}</th>
                        <!-- <th>{!! $sortLink('is_active', 'Status') !!}</th> -->
                        <th style="width:130px;text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                          <td>
    @if ($item->is_embed)
        <div class="row-thumb-wrap">
            @if ($item->thumbnail_url)
                <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="row-thumb">
            @else
                <div class="row-thumb row-thumb-placeholder">
                    <i class="bi bi-vimeo"></i>
                </div>
            @endif
            <span class="thumb-badge {{ $item->video_provider }}">
                <i class="bi bi-{{ $item->video_provider === 'youtube' ? 'youtube' : 'vimeo' }}"></i>
            </span>
        </div>
    @elseif ($item->is_video)
        <div class="row-thumb-wrap">
            <video src="{{ $item->media_url }}" class="row-thumb" muted preload="metadata"></video>
            <span class="thumb-badge video"><i class="bi bi-play-fill"></i></span>
        </div>
    @elseif ($item->media)
        <img src="{{ $item->media_url }}" alt="{{ $item->title }}" class="row-thumb">
    @else
        <div class="row-thumb row-thumb-placeholder">
            <i class="bi bi-image"></i>
        </div>
    @endif
</td>
                            <td>
                                <b>{{ $item->title }}</b>
                            </td>
                            <td>
                                <span class="badge-type {{ $item->is_video ? 'badge-type-video' : 'badge-type-image' }}">
                                    <i class="bi bi-{{ $item->is_video ? 'camera-video' : 'image' }}"></i>
                                    {{ ucfirst($item->media_type) }}
                                </span>
                            </td>
                            <!-- <td>
                                @if ($item->is_active)
                                    <span class="badge-active"><i class="bi bi-check-circle-fill"></i> Active</span>
                                @else
                                    <span class="badge-muted">Inactive</span>
                                @endif
                            </td> -->
                            <td style="text-align:right;">
                                <a href="{{ route('admin.gallery.edit', $item) }}" class="icon-btn" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                              
                                 @if(auth()->user()->role === 'admin')
        <button type="button" class="icon-btn icon-btn-danger" title="Delete"
                onclick="confirmDeleteGalleryItem({{ $item->id }}, '{{ addslashes($item->title) }}')">
            <i class="bi bi-trash"></i>
        </button>
        <form id="delete-form-{{ $item->id }}"
              action="{{ route('admin.gallery.destroy', $item) }}"
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
        @endif
    </div>

    @if ($items->hasPages())
        @php
            $pageUrl = function (int $page) use ($search, $sortBy, $sortDir, $perPage) {
                return route('admin.gallery', array_filter([
                    'q'        => $search,
                    'sort'     => $sortBy !== 'sort_order' ? $sortBy : null,
                    'dir'      => $sortDir !== 'asc' ? $sortDir : null,
                    'per_page' => $perPage !== 10 ? $perPage : null,
                    'page'     => $page > 1 ? $page : null,
                ]));
            };

            $current = $items->currentPage();
            $last    = $items->lastPage();
            $start   = max(1, $current - 2);
            $end     = min($last, $start + 4);
            $start   = max(1, min($start, $end - 4));
        @endphp

        <nav class="pager" role="navigation" aria-label="Pagination">
            <div class="pager-status">
                Showing <b>{{ $items->firstItem() }}</b> to <b>{{ $items->lastItem() }}</b>
                of <b>{{ $items->total() }}</b> {{ Str::plural('result', $items->total()) }}
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
</div>

<script>
(function () {
    const input = document.getElementById('gallerySearchInput');
    const form = document.getElementById('gallerySearchForm');
    if (!input || !form) return;

    let timer = null;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () { form.submit(); }, 450);
    });
})();

function confirmDeleteGalleryItem(id, title) {
    Swal.fire({
        icon: 'warning',
        title: 'Remove gallery item?',
        text: `"${title}" will be removed.`,
        showCancelButton: true,
        confirmButtonText: 'Yes, remove',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#002F5F',
        cancelButtonColor: '#667085'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
}
</script>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span:first-child{ cursor:pointer; transition:color .15s; }
    .crumbs span:first-child:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:560px; line-height:1.55; }

    .btn-save{
        display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none;
        padding:11px 22px; border-radius:9px; cursor:pointer;
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4);
        transition:transform .12s ease, box-shadow .12s ease;
    }
    .btn-save:hover{ transform:translateY(-1px); box-shadow:0 8px 18px -6px rgba(15,21,38,0.5); }

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
        display:flex; align-items:center; justify-content:center; color: var(--muted,#667085); font-size:10px;
        text-decoration:none; transition:background .15s, color .15s;
    }
    .search-clear:hover{ background:#E2E5EE; color: var(--ink,#171B2C); }

    .toolbar-right{ display:flex; align-items:center; gap:18px; flex-wrap:wrap; }
    .toolbar-meta{ font-size:12.5px; color: var(--faint,#9AA1B2); white-space:nowrap; }
    .toolbar-meta b{ color: var(--ink,#171B2C); font-weight:600; }

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

    .row-thumb{ width:45px; height:45px; border-radius:8px; object-fit:cover; display:block; background:#0F1220; }

    .badge-type{ display:inline-flex; align-items:center; gap:5px; font-size:11.5px; font-weight:600; padding:3px 10px; border-radius:999px; }
    .badge-type-image{ background:#EAF1FF; color:#2B5FD9; }
    .badge-type-video{ background:#FDEAF5; color:#C4247E; }

    .badge-active{ display:inline-flex; align-items:center; gap:5px; font-size:11.5px; font-weight:700; color:#16A34A; }
    .badge-muted{ color: var(--faint,#9AA1B2); font-size:11.5px; }

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
        font-size:12px; font-weight:600; color: var(--orange,#BF0001);
        background:#fff; border:1px solid var(--orange-border,#F3D8C2); border-radius:8px;
        padding:7px 0; cursor:pointer; transition:background .15s;
    }
    .choose-btn:hover{ background: var(--orange-tint,#FFF8F3); }

    .pager{ display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; margin-top:20px; }
    .pager-status{ font-size:12.5px; color: var(--faint,#9AA1B2); }
    .pager-status b{ color: var(--ink,#171B2C); font-weight:600; }
    .pager-links{ display:flex; align-items:center; gap:4px; }
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

    .row-thumb-wrap { position: relative; display: inline-block; }

.row-thumb-placeholder {
    display: flex; align-items: center; justify-content: center;
    background: #EEF0F6; color: #AEB4C4; font-size: 18px;
}

.thumb-badge {
    position: absolute; bottom: 4px; right: 4px;
    width: 20px; height: 20px; border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; color: #fff;
}
.thumb-badge.youtube { background: #FF0000; }
.thumb-badge.vimeo   { background: #1AB7EA; }
.thumb-badge.video   { background: rgba(0,0,0,0.65); }
</style>

@endsection
