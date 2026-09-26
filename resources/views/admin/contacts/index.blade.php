@extends('admin.layout')
@section('title', 'Contact Messages')
@section('content')

@php
    // URL for this page keeping the current state; defaults are dropped to keep URLs short
    $listUrl = function (array $overrides = []) use ($search, $sortBy, $sortDir, $perPage) {
        $params = array_merge([
            'q'        => $search,
            'sort'     => $sortBy !== 'created_at' ? $sortBy : null,
            'dir'      => $sortDir !== 'desc' ? $sortDir : null,
            'per_page' => $perPage !== 10 ? $perPage : null,
        ], $overrides);

        return route('admin.contacts', array_filter($params, fn ($v) => $v !== null && $v !== ''));
    };

    $sortLink = function (string $column, string $label) use ($sortBy, $sortDir, $listUrl) {
        $isCurrent = $sortBy === $column;
        $nextDir   = $isCurrent && $sortDir === 'asc' ? 'desc' : 'asc';
        $icon      = $isCurrent ? ($sortDir === 'asc' ? 'bi-sort-up' : 'bi-sort-down') : 'bi-arrow-down-up';

        return '<a href="' . e($listUrl(['sort' => $column, 'dir' => $nextDir, 'page' => null])) . '" class="sort-link'
             . ($isCurrent ? ' active' : '') . '">' . e($label) . ' <i class="bi ' . $icon . '"></i></a>';
    };
@endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <b>Contact Messages</b>
    </div>

    <div class="header">
        <div>
            <h1>Contact Messages</h1>
            <p>Messages sent from the "Contact Us" form on the website.</p>
        </div>
    </div>

    {{-- Toolbar: search left, count + per page right --}}
    <div class="toolbar">
        <form action="{{ route('admin.contacts') }}" method="GET" class="search-form" id="contactSearchForm">
            @if ($sortBy !== 'created_at') <input type="hidden" name="sort" value="{{ $sortBy }}"> @endif
            @if ($sortDir !== 'desc') <input type="hidden" name="dir" value="{{ $sortDir }}"> @endif
            @if ($perPage !== 10) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
            <i class="bi bi-search search-ico"></i>
            <input type="text" name="q" id="contactSearchInput" value="{{ $search }}"
                   placeholder="Search name, email, phone, subject or message..." autocomplete="off">
            @if ($search !== '')
                <a href="{{ $listUrl(['q' => null]) }}" class="search-clear" title="Clear search"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>

        <div class="toolbar-right">
            <div class="toolbar-meta">
                {{ $contacts->total() }} {{ \Illuminate\Support\Str::plural('message', $contacts->total()) }}
                @if ($search !== '') for "<b>{{ $search }}</b>" @endif
            </div>

            <form action="{{ route('admin.contacts') }}" method="GET" class="perpage-form">
                @if ($search !== '') <input type="hidden" name="q" value="{{ $search }}"> @endif
                @if ($sortBy !== 'created_at') <input type="hidden" name="sort" value="{{ $sortBy }}"> @endif
                @if ($sortDir !== 'desc') <input type="hidden" name="dir" value="{{ $sortDir }}"> @endif
                <label for="contactPerPage">Show</label>
                <select name="per_page" id="contactPerPage" onchange="this.form.submit()">
                    @foreach ($perPageOptions as $n)
                        <option value="{{ $n }}" @selected($perPage === $n)>{{ $n }}</option>
                    @endforeach
                </select>
                <span>per page</span>
            </form>
        </div>
    </div>

    <div class="card" style="padding:0;overflow:hidden;">
        @if ($contacts->isEmpty())
            <div class="empty-state">
                <div class="ico-circle" style="width:52px;height:52px;margin:0 auto 12px;">
                    <i class="bi bi-envelope" style="color:#AEB4C4;font-size:22px;"></i>
                </div>
                @if ($search !== '')
                    <p>No messages match "<b>{{ $search }}</b>".</p>
                    <a href="{{ $listUrl(['q' => null]) }}" class="choose-btn">Clear search</a>
                @else
                    <p>No contact messages yet. Messages sent from the website's Contact Us form will appear here.</p>
                @endif
            </div>
        @else
            <div class="table-scroll">
                <table class="news-table">
                    <thead>
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>{!! $sortLink('name', 'Name') !!}</th>
                            <th>{!! $sortLink('email', 'Email') !!}</th>
                            <th>{!! $sortLink('phone', 'Phone') !!}</th>
                            <th>{!! $sortLink('subject', 'Subject') !!}</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $c)
                            <tr>
                                <td class="muted-sub">{{ $contacts->firstItem() + $loop->index }}</td>
                                <td class="nowrap"><b>{{ $c->name }}</b></td>
                                <td class="nowrap">
                                 {{ $c->email }}
                                </td>
                                <td class="nowrap">
                                    @if ($c->phone)
                                   {{ $c->phone }}
                                    @else
                                        <span class="muted-sub">—</span>
                                    @endif
                                </td>
                                <td class="subject-cell">{{ $c->subject ?: '—' }}</td>
                                <td class="msg-cell">
                                    <div class="msg-text" onclick="this.classList.toggle('open')" title="Click to show the full message">{{ $c->message }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Pagination (same design as Events) --}}
    @if ($contacts->total() > 0)
        @php
            $current = $contacts->currentPage();
            $last    = $contacts->lastPage();
            $start   = max(1, $current - 2);
            $end     = min($last, $start + 4);
            $start   = max(1, min($start, $end - 4));
        @endphp

        <nav class="pager" role="navigation" aria-label="Pagination">
            <div class="pager-status">
                Showing <b>{{ $contacts->firstItem() }}</b> to <b>{{ $contacts->lastItem() }}</b>
                of <b>{{ $contacts->total() }}</b> {{ \Illuminate\Support\Str::plural('result', $contacts->total()) }}
            </div>

            @if ($contacts->hasPages())
                <div class="pager-links">
                    @if ($current <= 1)
                        <span class="pager-btn pager-btn-disabled"><i class="bi bi-chevron-left"></i></span>
                    @else
                        <a href="{{ $contacts->url($current - 1) }}" class="pager-btn" rel="prev"><i class="bi bi-chevron-left"></i></a>
                    @endif

                    @if ($start > 1)
                        <a href="{{ $contacts->url(1) }}" class="pager-btn">1</a>
                        @if ($start > 2)<span class="pager-dots">&hellip;</span>@endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $current)
                            <span class="pager-btn pager-btn-active">{{ $page }}</span>
                        @else
                            <a href="{{ $contacts->url($page) }}" class="pager-btn">{{ $page }}</a>
                        @endif
                    @endfor

                    @if ($end < $last)
                        @if ($end < $last - 1)<span class="pager-dots">&hellip;</span>@endif
                        <a href="{{ $contacts->url($last) }}" class="pager-btn">{{ $last }}</a>
                    @endif

                    @if ($current >= $last)
                        <span class="pager-btn pager-btn-disabled"><i class="bi bi-chevron-right"></i></span>
                    @else
                        <a href="{{ $contacts->url($current + 1) }}" class="pager-btn" rel="next"><i class="bi bi-chevron-right"></i></a>
                    @endif
                </div>
            @endif
        </nav>
    @endif
</div>

<script>
(function () {
    const input = document.getElementById('contactSearchInput');
    const form  = document.getElementById('contactSearchForm');
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
    .crumbs span:first-child{ cursor:pointer; transition:color .15s; }
    .crumbs span:first-child:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; line-height:1.55; }

    .toolbar{ display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:16px; flex-wrap:wrap; }
    .search-form{ position:relative; display:flex; align-items:center; flex:1; min-width:240px; max-width:420px; }
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
    .news-table td{ padding:12px 20px; border-bottom:1px solid var(--line,#E9EBF2); font-size:13.5px; color: var(--ink,#171B2C); vertical-align:top; }
    .news-table tbody tr:last-child td{ border-bottom:none; }
    .news-table tbody tr:hover{ background:#FAFBFD; }
    .nowrap{ white-space:nowrap; }
    .muted-sub{ font-size:12px; color: var(--faint,#9AA1B2); }
    .muted-link{ font-size:13px; color: var(--muted,#667085); text-decoration:none; }
    .muted-link:hover{ color: var(--orange,#BF0001); text-decoration:underline; }

    .subject-cell{ min-width:160px; max-width:240px; font-weight:600; }
    .msg-cell{ min-width:260px; max-width:460px; }
    .msg-text{
        font-size:13px; color: var(--muted,#667085); line-height:1.55; white-space:pre-line; cursor:pointer;
        display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
    }
    .msg-text.open{ display:block; -webkit-line-clamp:unset; color: var(--ink,#171B2C); }

    .empty-state{ text-align:center; padding:60px 20px; }
    .empty-state p{ font-size:13.5px; color: var(--muted,#667085); margin:0 0 16px; }
    .ico-circle{ border-radius:999px; background:#EEF0F6; display:flex; align-items:center; justify-content:center; }
    .choose-btn{
        display:inline-block; font-size:12px; font-weight:600; color: var(--orange,#BF0001); text-decoration:none;
        background:#fff; border:1px solid var(--orange-border,#F3D8C2); border-radius:8px; padding:9px 20px;
    }

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
