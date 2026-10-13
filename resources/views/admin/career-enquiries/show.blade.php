@extends('admin.layout')
@section('title', 'Career Enquiry Details')
@section('content')

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <span onclick="window.location='{{ route('admin.career-enquiries') }}'">Career Enquiries</span>
        <span>&rsaquo;</span>
        <b>#{{ $item->id }}</b>
    </div>

    <div class="header">
        <div>
            <h1>{{ $item->name }}</h1>
            <p>Submitted on {{ $item->created_at?->format('d M Y, h:i A') }}</p>
        </div>
        <a href="{{ route('admin.career-enquiries') }}" class="btn-ghost">
            <i class="bi bi-arrow-left"></i> Back to list
        </a>
    </div>

    <div class="card">
        <div class="section-title">
            <h2><i class="bi bi-person-circle"></i> Applicant Details</h2>
        </div>

        <div class="details-grid">
            <div class="detail">
                <div class="dt-label">Full Name</div>
                <div class="dt-val">{{ $item->name }}</div>
            </div>
            <div class="detail">
                <div class="dt-label">Email</div>
                <div class="dt-val"><a href="mailto:{{ $item->email }}" class="link">{{ $item->email }}</a></div>
            </div>
            <div class="detail">
                <div class="dt-label">Phone</div>
                <div class="dt-val">
                    @if ($item->phone) <a href="tel:{{ $item->phone }}" class="link">{{ $item->phone }}</a>
                    @else — @endif
                </div>
            </div>
            <div class="detail">
                <div class="dt-label">Nationality</div>
                <div class="dt-val">{{ $item->nationality ?? '—' }}</div>
            </div>
            <div class="detail">
                <div class="dt-label">Applying For</div>
                <div class="dt-val">{{ $item->apply_for ?? '—' }}</div>
            </div>
            <!-- <div class="detail">
                <div class="dt-label">Linked Career</div>
                <div class="dt-val">{{ $item->career?->title ?? '—' }}</div>
            </div> -->
            <div class="detail">
                <div class="dt-label">CV / Resume</div>
                <div class="dt-val">
                    @if ($item->cv)
                        <a href="{{ asset('storage/'.$item->cv) }}" target="_blank" class="link">
                            <i class="bi bi-file-earmark-arrow-down"></i> Download CV
                        </a>
                    @else — @endif
                </div>
            </div>
            <div class="detail">
                <div class="dt-label">Submitted</div>
                <div class="dt-val">{{ $item->created_at?->format('d M Y, h:i A') }}</div>
            </div>
        </div>
    </div>

    @if ($item->message)
    <div class="card">
        <div class="section-title">
            <h2><i class="bi bi-chat-left-text"></i> Message</h2>
        </div>
        <div class="message-block">{!! nl2br(e($item->message)) !!}</div>
    </div>
    @endif
</div>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span:not(:last-child){ cursor:pointer; }
    .crumbs span:not(:last-child):hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; }

    .btn-ghost{
        display:inline-flex; align-items:center; gap:7px; font-size:13px; font-weight:600;
        color:#002F5F; background:#fff; border:1px solid #002F5F; padding:9px 16px;
        border-radius:9px; text-decoration:none;
    }
    .btn-ghost:hover{ background:#002F5F; color:#fff; }

    .section-title{ margin-bottom:16px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .section-title h2 i{ color: var(--orange,#BF0001); }

    .details-grid{
        display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:18px 24px;
    }
    .detail{ min-width:0; }
    .dt-label{ font-size:11.5px; font-weight:600; color: var(--faint,#9AA1B2); text-transform:uppercase; letter-spacing:.04em; margin-bottom:4px; }
    .dt-val{ font-size:14px; color: var(--ink,#171B2C); word-break:break-word; }

    .link{ color:#002F5F; text-decoration:none; }
    .link:hover{ text-decoration:underline; }

    .message-block{
        background: var(--canvas,#F6F7FB); border-radius:10px; padding:16px 18px;
        font-size:14px; color: var(--ink,#171B2C); line-height:1.6; white-space:pre-wrap;
    }
</style>

@endsection
