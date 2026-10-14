@extends('admin.layout')
@section('title', 'Event Response Details')
@section('content')

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <span onclick="window.location='{{ route('admin.event-responses.index') }}'" style="cursor:pointer;">Event Responses</span>
        <span>&rsaquo;</span>
        <b>Details</b>
    </div>

    <div class="header">
        <div>
            <h1>Response Details</h1>
            <p>Full details of the event response submission.</p>
        </div>
        <a href="{{ route('admin.event-responses.index') }}" class="back-btn">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card" style="padding:0;overflow:hidden;">
        <div class="detail-grid">
            <div class="label">Event</div>
            <div class="value"><b>{{ $response->event->title ?? 'N/A' }}</b></div>

            <div class="label">Event Date</div>
            <div class="value">
                {{ $response->event && $response->event->event_date
                    ? \Carbon\Carbon::parse($response->event->event_date)->format('d M Y')
                    : '—' }}
            </div>

            <div class="label">Event Time</div>
            <div class="value">
                {{ $response->event && $response->event->event_time
                    ? \Carbon\Carbon::parse($response->event->event_time)->format('h:i A')
                    : '—' }}
            </div>

            <div class="label">Venue</div>
            <div class="value">{{ $response->event->venue ?? '—' }}</div>

            <div class="label">Name</div>
            <div class="value"><b>{{ $response->name }}</b></div>

            <div class="label">Phone</div>
            <div class="value">
                @if ($response->phone)
                    <a href="tel:{{ $response->phone }}" class="link">
                        <i class="bi bi-telephone"></i> {{ $response->phone }}
                    </a>
                @else — @endif
            </div>

            <div class="label">Comment</div>
            <div class="value" style="white-space:pre-wrap;">{{ $response->comment ?: '—' }}</div>

            <div class="label">IP Address</div>
            <div class="value" style="font-family:monospace;color:var(--faint,#9AA1B2);">
                {{ $response->ip_address ?? '—' }}
            </div>

            <div class="label">Submitted At</div>
            <div class="value">{{ $response->created_at?->format('d M Y, h:i A') }}</div>
        </div>
    </div>
</div>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span:first-child, .crumbs span:nth-child(3){ cursor:pointer; }
    .crumbs span:first-child:hover, .crumbs span:nth-child(3):hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:560px; line-height:1.55; }

    .back-btn{
        display:inline-flex; align-items:center; gap:7px;
        background:#fff; color:#002F5F; border:1px solid #002F5F;
        padding:9px 16px; border-radius:9px; font-size:13px; font-weight:600;
        text-decoration:none; transition: background .15s, color .15s;
    }
    .back-btn:hover{ background:#002F5F; color:#fff; }

    .detail-grid{ display:grid; grid-template-columns: 200px 1fr; gap:0; }
    .detail-grid .label{
        background:#FAFBFD; padding:14px 18px;
        font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;
        color: var(--faint,#9AA1B2); border-bottom:1px solid var(--line,#E9EBF2);
    }
    .detail-grid .value{
        padding:14px 18px; font-size:13.5px; color: var(--ink,#171B2C);
        border-bottom:1px solid var(--line,#E9EBF2); word-break:break-word;
    }
    .detail-grid > div:nth-last-child(1),
    .detail-grid > div:nth-last-child(2){ border-bottom:none; }

    .link{ color:#002F5F; text-decoration:none; }
    .link:hover{ text-decoration:underline; }

    @media (max-width: 640px){
        .detail-grid{ grid-template-columns: 1fr; }
        .detail-grid .label{ border-bottom:none; padding:12px 16px 4px; background:transparent; }
        .detail-grid .value{ padding:0 16px 12px; border-bottom:1px solid var(--line,#E9EBF2); }
    }
</style>

@endsection