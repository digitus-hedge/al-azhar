@extends('admin.layout')
@section('title', 'Fees')
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
        <b>Fees</b>
    </div>

    <div class="header">
        <div>
            <h1>Fees</h1>
            <p>Class-wise school fees. Each fee is paid in instalments; the yearly total is calculated automatically.</p>
        </div>
        <a href="{{ route('admin.fees.create') }}" class="btn-save" style="text-decoration:none;">
            <i class="bi bi-plus-lg"></i>
            Add Fee
        </a>
    </div>

    <div class="toolbar">
        <form action="{{ route('admin.fees') }}" method="GET" class="search-form" id="feeSearchForm">
            @if ($perPage !== 10) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
            <i class="bi bi-search search-ico"></i>
            <input type="text" name="search" id="feeSearchInput" value="{{ $search }}"
                   placeholder="Search by class..." autocomplete="off">
            @if ($search !== '')
                <a href="{{ route('admin.fees', $perPage !== 10 ? ['per_page' => $perPage] : []) }}" class="search-clear" title="Clear search">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </form>

        <div class="toolbar-right">
            <div class="toolbar-meta">
                {{ $fees->total() }} {{ Str::plural('fee', $fees->total()) }}
                @if ($search !== '') for "<b>{{ $search }}</b>" @endif
            </div>

            <form action="{{ route('admin.fees') }}" method="GET" class="perpage-form" id="feePerPageForm">
                @if ($search !== '') <input type="hidden" name="search" value="{{ $search }}"> @endif
                <label for="feePerPageSelect">Show</label>
                <select name="per_page" id="feePerPageSelect" onchange="this.form.submit()">
                    @foreach ($perPageOptions as $option)
                        <option value="{{ $option }}" {{ $perPage == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
                <span>per page</span>
            </form>
        </div>
    </div>

    <div class="card" style="padding:0;overflow:hidden;">
        @if ($fees->isEmpty())
            <div class="empty-state">
                <div class="ico-circle" style="width:52px;height:52px;margin:0 auto 12px;">
                    <i class="bi bi-cash-coin" style="color:#AEB4C4;font-size:22px;"></i>
                </div>
                @if ($search !== '')
                    <p>No fees match "<b>{{ $search }}</b>".</p>
                    <a href="{{ route('admin.fees') }}" class="choose-btn" style="display:inline-block;width:auto;padding:9px 20px;text-decoration:none;">Clear search</a>
                @else
                    <p>No fees added yet.</p>
                    <a href="{{ route('admin.fees.create') }}" class="choose-btn" style="display:inline-block;width:auto;padding:9px 20px;text-decoration:none;">Add the first fee</a>
                @endif
            </div>
        @else
            <div class="table-scroll">
                <table class="news-table">
                    <thead>
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>Class</th>
                            <th>School Fees</th>
                            <th>Total</th>
                            <th style="width:130px;text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fees as $fee)
                            <tr>
                                <td data-label="No" class="muted-sub">{{ $fees->firstItem() + $loop->index }}</td>
                                <td data-label="Class"><b>{{ $fee->class_name }}</b></td>
                                <td data-label="Fees">
                                    ₹{{ number_format($fee->fee_amount, 2) }}
                                    <span class="muted-sub">× {{ $fee->installments }}</span>
                                </td>
                                <td data-label="Total" class="fee-total">₹{{ number_format($fee->total_amount, 2) }}</td>
                                <td data-label="Actions" style="text-align:right;white-space:nowrap;">
                                    <a href="{{ route('admin.fees.edit', $fee->id) }}" class="icon-btn" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="icon-btn icon-btn-danger" title="Delete"
                                            onclick="confirmDeleteFee({{ $fee->id }}, @js($fee->class_name))">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $fee->id }}"
                                          action="{{ route('admin.fees.destroy', $fee->id) }}"
                                          method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @if ($fees->hasPages())
        @php
            $pageUrl = function (int $page) use ($search, $perPage) {
                return route('admin.fees', array_filter([
                    'search'   => $search !== '' ? $search : null,
                    'per_page' => $perPage !== 10 ? $perPage : null,
                    'page'     => $page > 1 ? $page : null,
                ]));
            };

            $current = $fees->currentPage();
            $last    = $fees->lastPage();
            $start   = max(1, $current - 2);
            $end     = min($last, $start + 4);
            $start   = max(1, min($start, $end - 4));
        @endphp

        <nav class="pager" role="navigation" aria-label="Pagination">
            <div class="pager-status">
                Showing <b>{{ $fees->firstItem() }}</b> to <b>{{ $fees->lastItem() }}</b>
                of <b>{{ $fees->total() }}</b> {{ Str::plural('result', $fees->total()) }}
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
    const input = document.getElementById('feeSearchInput');
    const form  = document.getElementById('feeSearchForm');
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

function confirmDeleteFee(id, name) {
    Swal.fire({
        icon: 'warning',
        title: 'Delete fee?',
        text: `The fee for "${name}" will be permanently deleted.`,
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
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
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; line-height:1.55; }

    .btn-save{
        display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none;
        padding:11px 22px; border-radius:9px; cursor:pointer;
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4);
        transition:transform .12s ease, box-shadow .12s ease;
    }
    .btn-save:hover{ transform:translateY(-1px); box-shadow:0 8px 18px -6px rgba(15,21,38,0.5); color:#fff; }

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

    .table-scroll{ overflow-x:auto; }
    .news-table{ width:100%; border-collapse:collapse; }
    .news-table th{
        text-align:left; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;
        color: var(--faint,#9AA1B2); padding:14px 20px; border-bottom:1px solid var(--line,#E9EBF2); background:#FAFBFD; white-space:nowrap;
    }
    .news-table td{ padding:14px 20px; border-bottom:1px solid var(--line,#E9EBF2); font-size:13.5px; color: var(--ink,#171B2C); vertical-align:middle; }
    .news-table tbody tr:last-child td{ border-bottom:none; }
    .news-table tbody tr:hover{ background:#FAFBFD; }

    .muted-sub{ font-size:12px; color: var(--faint,#9AA1B2); }
    .fee-total{ font-weight:700; color: var(--orange,#BF0001); }

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

/* ---------- Tablet ---------- */
@media (max-width: 900px){
    .toolbar{ flex-direction:column; align-items:stretch; }
    .search-form{ max-width:none; min-width:0; }
    .toolbar-right{ justify-content:space-between; }
    .news-table th, .news-table td{ padding:12px 14px; }
}

/* ---------- Phone: rows become cards ---------- */
@media (max-width: 640px){
    .header{ flex-direction:column; align-items:stretch; margin-bottom:18px; }
    .header h1{ font-size:21px; }
    .header p{ font-size:13px; }
    .header .btn-save{ justify-content:center; width:100%; }

    .toolbar-right{ gap:10px; }
    .toolbar-meta{ white-space:normal; }

    .table-scroll{ overflow-x:visible; }
    .news-table thead{ display:none; }
    .news-table, .news-table tbody{ display:block; width:100%; }

    /* [class ............ actions]
       [₹6,000 × 4 ....... ₹24,000] */
    .news-table tr{
        display:grid;
        grid-template-columns:1fr auto;
        grid-template-areas:
            "class actions"
            "fees  total";
        gap:6px 12px; align-items:center;
        padding:14px 16px; border-bottom:1px solid var(--line,#E9EBF2);
    }
    .news-table tbody tr:last-child{ border-bottom:none; }
    .news-table td{ display:block; padding:0; border:none; }

    .news-table td[data-label="No"]     { display:none; }
    .news-table td[data-label="Class"]  { grid-area:class; font-size:14.5px; min-width:0; word-break:break-word; }
    .news-table td[data-label="Actions"]{ grid-area:actions; }
    .news-table td[data-label="Fees"]   { grid-area:fees; font-size:12.5px; color: var(--muted,#667085); }
    .news-table td[data-label="Total"]  { grid-area:total; text-align:right; font-size:14px; }

    .icon-btn{ width:38px; height:38px; margin-left:4px; }

    .pager{ flex-direction:column; align-items:center; gap:12px; }
    .pager-links{ flex-wrap:wrap; justify-content:center; }
    .pager-btn{ min-width:36px; height:36px; }
}

/* ---------- Very small phones ---------- */
@media (max-width: 380px){
    .perpage-form span{ display:none; }
    .toolbar-right{ flex-direction:column; align-items:flex-start; }
}
</style>

@endsection