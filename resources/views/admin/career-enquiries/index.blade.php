@extends('admin.layout')
@section('title', 'Career Enquiries')
@section('content')

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <b>Career Enquiries</b>
    </div>

    <div class="header">
        <div>
            <h1>Career Enquiries</h1>
            <p>Applications submitted from the public Careers page.</p>
        </div>
    </div>

    @php
        $sortLink = function (string $column, string $label) use ($sortBy, $sortDir, $search, $careerId, $perPage) {
            $nextDir = ($sortBy === $column && $sortDir === 'asc') ? 'desc' : 'asc';
            $url = route('admin.career-enquiries', array_filter([
                'q'          => $search,
                'career_id'  => $careerId,
                'sort'       => $column,
                'dir'        => $nextDir,
                'per_page'   => $perPage !== 10 ? $perPage : null,
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
        <form action="{{ route('admin.career-enquiries') }}" method="GET" class="search-form" id="ceSearchForm">
            @if (filled($careerId)) <input type="hidden" name="career_id" value="{{ $careerId }}"> @endif
            @if ($sortBy !== 'created_at') <input type="hidden" name="sort" value="{{ $sortBy }}"> @endif
            @if ($sortDir !== 'desc') <input type="hidden" name="dir" value="{{ $sortDir }}"> @endif
            @if ($perPage !== 10) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
            <i class="bi bi-search search-ico"></i>
            <input type="text" name="q" id="ceSearchInput" value="{{ $search }}"
                   placeholder="Search by name, email, phone, position..." autocomplete="off">
            @if ($search !== '')
                <a href="{{ route('admin.career-enquiries', array_filter(['career_id' => $careerId ?: null])) }}" class="search-clear" title="Clear search">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </form>

        <div class="toolbar-right">
            <form action="{{ route('admin.career-enquiries') }}" method="GET" class="filter-form">
                @if ($search !== '') <input type="hidden" name="q" value="{{ $search }}"> @endif
                @if ($sortBy !== 'created_at') <input type="hidden" name="sort" value="{{ $sortBy }}"> @endif
                @if ($sortDir !== 'desc') <input type="hidden" name="dir" value="{{ $sortDir }}"> @endif
                @if ($perPage !== 10) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
                <select name="career_id" onchange="this.form.submit()">
                    <option value="">All Careers</option>
                    @foreach ($careers as $career)
                        <option value="{{ $career->id }}" {{ (string) $careerId === (string) $career->id ? 'selected' : '' }}>
                            {{ $career->title }}
                        </option>
                    @endforeach
                </select>
            </form>

            <div class="toolbar-meta">
                {{ $items->total() }} {{ Str::plural('enquiry', $items->total()) }}
                @if ($search !== '') for "<b>{{ $search }}</b>" @endif
            </div>

            <form action="{{ route('admin.career-enquiries') }}" method="GET" class="perpage-form">
                @if ($search !== '') <input type="hidden" name="q" value="{{ $search }}"> @endif
                @if (filled($careerId)) <input type="hidden" name="career_id" value="{{ $careerId }}"> @endif
                @if ($sortBy !== 'created_at') <input type="hidden" name="sort" value="{{ $sortBy }}"> @endif
                @if ($sortDir !== 'desc') <input type="hidden" name="dir" value="{{ $sortDir }}"> @endif
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
                    <i class="bi bi-envelope-paper" style="color:#AEB4C4;font-size:22px;"></i>
                </div>
                @if ($search !== '' || filled($careerId))
                    <p>No enquiries match your filter.</p>
                    <a href="{{ route('admin.career-enquiries') }}" class="choose-btn" style="display:inline-block;width:auto;padding:9px 20px;text-decoration:none;">Clear filters</a>
                @else
                    <p>No career enquiries yet.</p>
                @endif
            </div>
        @else
            <div class="table-scroll">
                <table class="news-table">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>{!! $sortLink('name', 'Name') !!}</th>
                            <th>{!! $sortLink('email', 'Email') !!}</th>
                            <th>Phone</th>
                            <th>{!! $sortLink('apply_for', 'Apply For') !!}</th>
                            <th>Nationality</th>
                            <th>CV</th>
                            <th>{!! $sortLink('created_at', 'Submitted') !!}</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td data-label="Sl No">{{ $items->firstItem() + $loop->index }}</td>
                                <td data-label="Name"><b>{{ $item->name }}</b></td>
                                <td data-label="Email">
                                    <a href="mailto:{{ $item->email }}" class="link">{{ $item->email }}</a>
                                </td>
                                <td data-label="Phone">
                                    @if ($item->phone)
                                        <a href="tel:{{ $item->phone }}" class="link">{{ $item->phone }}</a>
                                    @else — @endif
                                </td>
                                <td data-label="Apply For">{{ $item->apply_for ?? '—' }}</td>
                                <td data-label="Nationality">{{ $item->nationality ?? '—' }}</td>
                                <td data-label="CV">
                                    @if ($item->cv)
                                        <a href="{{ asset('storage/'.$item->cv) }}" target="_blank" class="link">
                                            <i class="bi bi-file-earmark-arrow-down"></i> View
                                        </a>
                                    @else — @endif
                                </td>
                                <td data-label="Submitted">{{ $item->created_at?->format('d M Y, h:i A') }}</td>
                                <td data-label="Actions" style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('admin.career-enquiries.show', $item) }}" class="icon-btn" title="View details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ============== PAGINATION ============== --}}
    @if ($items->hasPages())
        @php
            $pageUrl = function (int $page) use ($search, $careerId, $sortBy, $sortDir, $perPage) {
                return route('admin.career-enquiries', array_filter([
                    'q'         => $search ?: null,
                    'career_id' => $careerId ?: null,
                    'sort'      => $sortBy !== 'created_at' ? $sortBy : null,
                    'dir'       => $sortDir !== 'desc' ? $sortDir : null,
                    'per_page'  => $perPage !== 10 ? $perPage : null,
                    'page'      => $page > 1 ? $page : null,
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
                    <span class="pager-btn pager-btn-disabled"><i class="bi bi-chevron-left"></i></span>
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
                    <span class="pager-btn pager-btn-disabled"><i class="bi bi-chevron-right"></i></span>
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
    const input = document.getElementById('ceSearchInput');
    const form  = document.getElementById('ceSearchForm');
    if (!input || !form) return;
    let timer = null;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () { form.submit(); }, 450);
    });
})();
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
        padding:10px 36px; font-size:13.5px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; background:#fff;
    }
    .search-clear{
        position:absolute; right:10px; width:22px; height:22px; border-radius:999px; background:#EEF0F6;
        display:flex; align-items:center; justify-content:center; color: var(--muted,#667085); font-size:10px;
        text-decoration:none;
    }

    .toolbar-right{ display:flex; align-items:center; gap:14px; flex-wrap:wrap; }
    .toolbar-meta{ font-size:12.5px; color: var(--faint,#9AA1B2); white-space:nowrap; }
    .toolbar-meta b{ color: var(--ink,#171B2C); font-weight:600; }

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

    .icon-btn{
        display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px;
        border-radius:8px; border:1px solid var(--line,#E9EBF2); background:#fff; color: var(--muted,#667085);
        cursor:pointer; margin-left:6px; text-decoration:none;
    }
    .icon-btn:hover{ background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); }

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

    @media (max-width: 900px){
        .toolbar{ flex-direction:column; align-items:stretch; }
    }
    @media (max-width: 640px){
        .table-scroll{ overflow-x:visible; }
        .news-table thead{ display:none; }
        .news-table, .news-table tbody, .news-table tr, .news-table td{ display:block; width:100%; }
        .news-table tr{ padding:14px 16px; border-bottom:1px solid var(--line,#E9EBF2); }
        .news-table td{ padding:4px 0; border:none; }
        .news-table td[data-label]::before{ content: attr(data-label) ": "; color: var(--faint,#9AA1B2); font-weight:600; font-size:11.5px; }

        /* Pagination mobile */
        .pager{ flex-direction:column; align-items:center; gap:12px; }
        .pager-links{ flex-wrap:wrap; justify-content:center; }
        .pager-btn{ min-width:36px; height:36px; }
    }
</style>

@endsection