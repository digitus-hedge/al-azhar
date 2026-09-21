@if ($paginator->hasPages())
    <nav class="pager" role="navigation" aria-label="Pagination">
        <div class="pager-status">
            Showing <b>{{ $paginator->firstItem() }}</b> to <b>{{ $paginator->lastItem() }}</b>
            of <b>{{ $paginator->total() }}</b> {{ Str::plural('result', $paginator->total()) }}
        </div>

        <div class="pager-links">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="pager-btn pager-btn-disabled" aria-disabled="true">
                    <i class="bi bi-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pager-btn" rel="prev">
                    <i class="bi bi-chevron-left"></i>
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="pager-dots">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pager-btn pager-btn-active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pager-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pager-btn" rel="next">
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <span class="pager-btn pager-btn-disabled" aria-disabled="true">
                    <i class="bi bi-chevron-right"></i>
                </span>
            @endif
        </div>
    </nav>

    <style>
        .pager{
            display:flex; align-items:center; justify-content:space-between; gap:16px;
            flex-wrap:wrap; margin-top:20px;
        }
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
        .pager-btn-active{
            background:linear-gradient(135deg, #0F1526, #1D2439); border-color:transparent; color:#fff;
        }
        .pager-btn-active:hover{ color:#fff; }
        .pager-btn-disabled{ opacity:.4; cursor:not-allowed; }
        .pager-btn-disabled:hover{ background:#fff; color: var(--muted,#667085); }
        .pager-dots{ padding:0 4px; color: var(--faint,#9AA1B2); font-size:12.5px; }
    </style>
@endif
