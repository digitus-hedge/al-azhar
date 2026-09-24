@extends('admin.layout')
@section('title', 'Mandatory Disclosure')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@php
    /** Column header that toggles sort direction and keeps the other filters. */
    $sortLink = function (string $column, string $label) use ($sortBy, $sortDir) {
        $isCurrent = $sortBy === $column;
        $nextDir   = $isCurrent && $sortDir === 'asc' ? 'desc' : 'asc';
        $url       = request()->fullUrlWithQuery(['sort' => $column, 'dir' => $nextDir, 'page' => null]);
        $icon      = $isCurrent ? ($sortDir === 'asc' ? 'bi-sort-up' : 'bi-sort-down') : 'bi-arrow-down-up';

        return '<a href="' . e($url) . '" class="sort-link ' . ($isCurrent ? 'active' : '') . '">'
             . e($label) . ' <i class="bi ' . $icon . '"></i></a>';
    };
@endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <b>Mandatory Disclosure</b>
    </div>

    <div class="header">
        <div>
            <h1>Mandatory Disclosure</h1>
            <p>Statutory PDF repository — affiliation, recognition, safety certificates, fee structure and results shown on the public Mandatory Disclosure page.</p>
        </div>
        <a href="{{ route('admin.mandatory-disclosures.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Add Document
        </a>
    </div>

    @if (session('success'))
        <div class="notice success"><i class="bi bi-check-circle"></i><p>{{ session('success') }}</p></div>
    @endif

    @if ($expiredCount || $expiringCount)
        <div class="notice caution">
            <i class="bi bi-exclamation-triangle"></i>
            <p>
                @if ($expiredCount)
                    <b>{{ $expiredCount }}</b> {{ Str::plural('document', $expiredCount) }} expired.
                @endif
                @if ($expiringCount)
                    <b>{{ $expiringCount }}</b> {{ Str::plural('document', $expiringCount) }} expiring in the next 30 days.
                @endif
                Upload the renewed copies to keep the page compliant.
            </p>
        </div>
    @endif

    <div class="card">
        {{-- Toolbar: search, category filter, per page --}}
        <form method="GET" action="{{ route('admin.mandatory-disclosures') }}" class="toolbar">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" name="q" value="{{ $search }}" placeholder="Search title or issuer...">
            </div>

         

            <select name="per_page" onchange="this.form.submit()" style="max-width:120px;">
                @foreach ($perPageOptions as $n)
                    <option value="{{ $n }}" {{ $perPage === $n ? 'selected' : '' }}>{{ $n }} / page</option>
                @endforeach
            </select>

            <input type="hidden" name="sort" value="{{ $sortBy }}">
            <input type="hidden" name="dir" value="{{ $sortDir }}">

            @if ($search !== '')
                <a href="{{ route('admin.mandatory-disclosures') }}" class="btn-clear">Clear</a>
            @endif
        </form>

        @if ($disclosures->isEmpty())
            <div class="empty">
                <div class="empty-ico"><i class="bi bi-file-earmark-pdf"></i></div>
                <h3>{{ $search !== '' ? 'No documents match your filters' : 'No documents yet' }}</h3>
                <p>{{ $search !== ''  ? 'Try a different search or category.' : 'Upload your first statutory document to get started.' }}</p>
                @if ($search === '')
                    <a href="{{ route('admin.mandatory-disclosures.create') }}" class="btn-add" style="margin-top:14px;">
                        <i class="bi bi-plus-lg"></i> Add Document
                    </a>
                @endif
            </div>
        @else
            <div class="table-wrap">
                <table class="md-table">
                    <thead>
                        <tr>
                            <th>{!! $sortLink('title', 'Document') !!}</th>
                 
                            <!-- <th>{!! $sortLink('valid_until', 'Valid Until') !!}</th>
                            <th>{!! $sortLink('sort_order', 'Order') !!}</th> -->
                            <th>{!! $sortLink('is_active', 'Visible') !!}</th>
                            <th style="width:130px;text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($disclosures as $doc)
                            <tr>
                                <td>
                                    <div class="doc-cell">
                                        <div class="pdf-ico"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                                        <div class="doc-meta">
                                            <b>{{ $doc->title }}</b>
                                            <small>
                                                {{ $doc->issued_by ?: '—' }}
                                                @if ($doc->file_size_label) &middot; {{ $doc->file_size_label }} @endif
                                            </small>
                                        </div>
                                    </div>
                                </td>
                               
                                <!-- <td>
                                    @if (! $doc->valid_until)
                                        <span class="badge-muted">No expiry</span>
                                    @elseif ($doc->is_expired)
                                        <span class="badge-exp expired" title="Expired">
                                            <i class="bi bi-x-circle-fill"></i> {{ $doc->valid_until->format('d M Y') }}
                                        </span>
                                    @elseif ($doc->is_expiring_soon)
                                        <span class="badge-exp soon" title="Expires within 30 days">
                                            <i class="bi bi-exclamation-circle-fill"></i> {{ $doc->valid_until->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="badge-exp ok">
                                            <i class="bi bi-check-circle-fill"></i> {{ $doc->valid_until->format('d M Y') }}
                                        </span>
                                    @endif
                                </td> -->

                                <!-- <td>{{ $doc->sort_order }}</td> -->

                                <td>
                                    <label class="mini-toggle" title="Show / hide on website">
                                        <input type="checkbox" {{ $doc->is_active ? 'checked' : '' }}
                                               onchange="toggleDisclosure(this, '{{ route('admin.mandatory-disclosures.toggle', $doc) }}')">
                                        <span></span>
                                    </label>
                                </td>
                                <td style="text-align:right;white-space:nowrap;">
                                    <a href="{{ $doc->file_url }}" target="_blank" class="icon-btn" title="View PDF">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.mandatory-disclosures.edit', $doc) }}" class="icon-btn" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if (auth()->user()->role === 'admin')
                                        <button type="button" class="icon-btn icon-btn-danger" title="Delete"
                                                onclick="confirmDeleteDisclosure({{ $doc->id }}, @js($doc->title))">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $doc->id }}"
                                              action="{{ route('admin.mandatory-disclosures.destroy', $doc) }}"
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

            <div class="table-foot">
                <span>Showing {{ $disclosures->firstItem() }}–{{ $disclosures->lastItem() }} of {{ $disclosures->total() }}</span>
                {{ $disclosures->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    function confirmDeleteDisclosure(id, title) {
        Swal.fire({
            icon: 'warning',
            title: 'Delete document?',
            html: `<b>${title}</b> will be removed from the website.`,
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#D92D20',
            reverseButtons: true
        }).then(result => {
            if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
        });
    }

    function toggleDisclosure(checkbox, url) {
        fetch(url, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.ok ? r.json() : Promise.reject())
        .then(data => {
            checkbox.checked = data.is_active;
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: data.message,
                        showConfirmButton: false, timer: 1800 });
        })
        .catch(() => {
            checkbox.checked = !checkbox.checked; // revert
            Swal.fire({ icon: 'error', title: 'Error', text: 'Could not update visibility.', confirmButtonColor: '#002F5F' });
        });
    }
</script>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span{ cursor:pointer; transition:color .15s; }
    .crumbs span:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:600px; line-height:1.55; }

    .btn-add{
        display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); padding:11px 20px; border-radius:9px;
        text-decoration:none; box-shadow:0 4px 12px -4px rgba(15,21,38,0.4); transition:transform .12s;
    }
    .btn-add:hover{ transform:translateY(-1px); color:#fff; }

    .notice{ display:flex; align-items:flex-start; gap:8px; border-radius:10px; padding:10px 12px; margin-bottom:16px; }
    .notice p{ font-size:12.5px; margin:0; }
    .notice.caution{ background:#FFF8E8; border:1px solid #F5E3B3; }
    .notice.caution i{ color:#B7791F; } .notice.caution p{ color:#8A6116; }
    .notice.success{ background:#ECFDF3; border:1px solid #ABEFC6; }
    .notice.success i{ color:#079455; } .notice.success p{ color:#067647; }

    .toolbar{ display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:18px; }
    .search-box{ position:relative; flex:1; min-width:220px; }
    .search-box i{ position:absolute; left:13px; top:50%; transform:translateY(-50%); color: var(--faint,#9AA1B2); font-size:14px; }
    .search-box input{ padding-left:36px !important; }
    .toolbar input[type=text], .toolbar select{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:10px 14px; font-size:13.5px; font-family:inherit; color: var(--ink,#171B2C); background:#fff; outline:none;
    }
    .toolbar select{ width:auto; min-width:180px; }
    .toolbar input:focus, .toolbar select:focus{ border-color: var(--orange,#BF0001); box-shadow:0 0 0 4px var(--orange-tint-strong,#FFE9D8); }
    .btn-clear{ font-size:13px; font-weight:600; color: var(--muted,#667085); text-decoration:none; padding:10px 12px; border-radius:8px; }
    .btn-clear:hover{ background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); }

    .table-wrap{ overflow-x:auto; }
    .md-table{ width:100%; border-collapse:collapse; font-size:13.5px; }
    .md-table th{
        text-align:left; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;
        color: var(--faint,#9AA1B2); padding:10px 12px; border-bottom:1px solid var(--line,#E9EBF2); white-space:nowrap;
    }
    .md-table td{ padding:12px; border-bottom:1px solid var(--line,#F0F1F5); vertical-align:middle; color: var(--ink,#171B2C); }
    .md-table tbody tr:hover{ background:#FAFBFD; }
    .sort-link{ color:inherit; text-decoration:none; display:inline-flex; align-items:center; gap:4px; }
    .sort-link i{ font-size:11px; opacity:.5; }
    .sort-link.active{ color: var(--ink,#171B2C); } .sort-link.active i{ opacity:1; color: var(--orange,#BF0001); }

    .doc-cell{ display:flex; align-items:center; gap:10px; }
    .pdf-ico{ width:34px; height:34px; border-radius:8px; background:#FEECEC; color:#D92D20;
              display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; }
    .doc-meta{ display:flex; flex-direction:column; min-width:0; }
    .doc-meta b{ font-weight:600; }
    .doc-meta small{ font-size:12px; color: var(--faint,#9AA1B2); }

    .badge-cat{ display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:600;
                padding:4px 10px; border-radius:999px; background:#EEF2FF; color:#3538CD; white-space:nowrap; }
    .badge-muted{ font-size:12px; color: var(--faint,#9AA1B2); }
    .badge-exp{ display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600;
                padding:4px 10px; border-radius:999px; white-space:nowrap; }
    .badge-exp i{ font-size:11px; }
    .badge-exp.ok{ background:#ECFDF3; color:#067647; }
    .badge-exp.soon{ background:#FFF7E6; color:#B45309; }
    .badge-exp.expired{ background:#FEF2F2; color:#B91C1C; }

    .mini-toggle{ position:relative; display:inline-block; width:36px; height:20px; cursor:pointer; }
    .mini-toggle input{ position:absolute; opacity:0; width:0; height:0; }
    .mini-toggle span{ position:absolute; inset:0; border-radius:999px; background:#DBDFEA; transition:background .15s; }
    .mini-toggle span::after{ content:''; position:absolute; top:2px; left:2px; width:16px; height:16px; border-radius:999px;
                              background:#fff; box-shadow:0 1px 2px rgba(0,0,0,.2); transition:transform .15s; }
    .mini-toggle input:checked + span{ background: var(--orange,#BF0001); }
    .mini-toggle input:checked + span::after{ transform:translateX(16px); }

    .icon-btn{ display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px;
               border:none; background:none; color: var(--muted,#667085); cursor:pointer; text-decoration:none; transition:background .15s, color .15s; }
    .icon-btn:hover{ background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); }
    .icon-btn-danger:hover{ background:#FEF2F2; color:#D92D20; }

    .table-foot{ display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;
                 margin-top:16px; font-size:12.5px; color: var(--faint,#9AA1B2); }
    .table-foot nav{ margin:0; }

    .empty{ text-align:center; padding:48px 16px; }
    .empty-ico{ width:56px; height:56px; margin:0 auto 12px; border-radius:999px; background:#FEECEC; color:#D92D20;
                display:flex; align-items:center; justify-content:center; font-size:24px; }
    .empty h3{ font-size:15px; margin:0 0 4px; color: var(--ink,#171B2C); }
    .empty p{ font-size:13px; margin:0; color: var(--muted,#667085); }
</style>

@endsection
