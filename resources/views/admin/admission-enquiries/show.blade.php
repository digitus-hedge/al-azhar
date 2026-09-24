@extends('admin.layout')
@section('title', 'Enquiry – ' . $enquiry->student_name)
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@php
    $isAdmin = auth()->user()?->role === 'admin';
    $waText  = rawurlencode("Hello {$enquiry->parent_name}, thank you for your admission enquiry for {$enquiry->student_name} (Grade {$enquiry->grade}).");
@endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <span onclick="window.location='{{ route('admin.admission-enquiries') }}'">Admission Enquiries</span>
        <span>&rsaquo;</span>
        <b>#{{ $enquiry->id }}</b>
    </div>

    <div class="header">
        <div>
            <span class="status-pill st-{{ $enquiry->status }}" id="status-pill">
                <i class="bi {{ $enquiry->status_icon }}"></i> <span>{{ $enquiry->status_label }}</span>
            </span>
            <h1>{{ $enquiry->student_name }}</h1>
            <p>Grade {{ $enquiry->grade }} &middot; received {{ $enquiry->created_at->format('d M Y, h:i A') }} ({{ $enquiry->created_at->diffForHumans() }})</p>
        </div>
        <div class="nav-btns">
            <a href="{{ $prevId ? route('admin.admission-enquiries.show', $prevId) : '#' }}" class="icon-btn {{ $prevId ? '' : 'disabled' }}" title="Previous enquiry"><i class="bi bi-chevron-left"></i></a>
            <a href="{{ $nextId ? route('admin.admission-enquiries.show', $nextId) : '#' }}" class="icon-btn {{ $nextId ? '' : 'disabled' }}" title="Next enquiry"><i class="bi bi-chevron-right"></i></a>
            <a href="{{ route('admin.admission-enquiries') }}" class="btn-outline"><i class="bi bi-arrow-left"></i> All enquiries</a>
        </div>
    </div>

    <div class="cols">
        <div>
            {{-- Student --}}
            <div class="card">
                <div class="section-title">
                    <h2><span class="icon"><i class="bi bi-mortarboard"></i></span> Student</h2>
                </div>
                <dl class="details">
                    <dt>Student's name</dt>
                    <dd>{{ $enquiry->student_name }}</dd>
                    <dt>Grade seeking admission</dt>
                    <dd>{{ $enquiry->grade }}</dd>
                    <dt>Hostel facility</dt>
                    <dd>
                        @if ($enquiry->needs_hostel)
                            <span class="badge-yes"><i class="bi bi-house-door-fill"></i> Needed</span>
                        @else
                            Not needed
                        @endif
                    </dd>
                </dl>
            </div>

            {{-- Message --}}
            <div class="card">
                <div class="section-title">
                    <h2><span class="icon"><i class="bi bi-chat-left-text"></i></span> Message from parent</h2>
                </div>
                @if ($enquiry->message)
                    <div class="message">{!! nl2br(e($enquiry->message)) !!}</div>
                @else
                    <p class="sub" style="margin:0;">No message was added.</p>
                @endif
            </div>

            {{-- Status + notes --}}
            <form class="card" id="statusForm" method="POST" action="{{ route('admin.admission-enquiries.update', $enquiry) }}">
                @csrf
                @method('PUT')
                <div class="section-title">
                    <h2><span class="icon"><i class="bi bi-flag"></i></span> Follow-up</h2>
                </div>

                <label class="lbl">Status</label>
                <div class="status-picker">
                    @foreach ($statuses as $key => $label)
                        <label class="st-option">
                            <input type="radio" name="status" value="{{ $key }}" @checked(old('status', $enquiry->status) === $key)>
                            <span class="st-card st-{{ $key }}">
                                <i class="bi {{ \App\Models\AdmissionEnquiry::STATUS_ICONS[$key] }}"></i> {{ $label }}
                            </span>
                        </label>
                    @endforeach
                </div>

                <label class="lbl" style="margin-top:16px;">Admin notes <span class="field-hint">(only visible to staff)</span></label>
                <textarea name="admin_notes" rows="4" maxlength="5000"
                          placeholder="e.g. Called on 24 Sep, parent will visit on Saturday for the interview.">{{ old('admin_notes', $enquiry->admin_notes) }}</textarea>
                @error('admin_notes')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror

                <div class="form-foot">
                    <span class="sub">
                        @if ($enquiry->contacted_at)
                            First followed up {{ $enquiry->contacted_at->format('d M Y, h:i A') }}
                        @else
                            Not contacted yet
                        @endif
                    </span>
                    @if (auth()->user()->role === 'admin')
                    <button type="submit" class="btn-save"><i class="bi bi-check-lg"></i> Save</button>
                    @endif
                </div>
            </form>
        </div>

        <div class="side">
            {{-- Parent + quick contact --}}
            <div class="card">
                <div class="section-title">
                    <h2><span class="icon"><i class="bi bi-person"></i></span> Parent</h2>
                </div>
                <div class="parent-name">{{ $enquiry->parent_name }}</div>
                <div class="sub">{{ $enquiry->parent_phone }}</div>
                @if ($enquiry->parent_email)
                    <div class="sub">{{ $enquiry->parent_email }}</div>
                @endif

                <div class="contact-btns">
                    <a href="tel:{{ $enquiry->parent_phone }}" class="c-btn"><i class="bi bi-telephone-fill"></i> Call</a>
                    <a href="https://wa.me/{{ $enquiry->whatsapp_number }}?text={{ $waText }}" target="_blank" rel="noopener" class="c-btn wa"><i class="bi bi-whatsapp"></i> WhatsApp</a>
                    @if ($enquiry->parent_email)
                        <a href="mailto:{{ $enquiry->parent_email }}?subject={{ rawurlencode('Admission enquiry – ' . $enquiry->student_name) }}" class="c-btn"><i class="bi bi-envelope-fill"></i> Email</a>
                    @endif
                </div>
            </div>

            {{-- Other enquiries from this parent --}}
            @if ($related->isNotEmpty())
                <div class="card">
                    <div class="section-title">
                        <h2><span class="icon"><i class="bi bi-files"></i></span> Other enquiries from this parent</h2>
                    </div>
                    <ul class="related">
                        @foreach ($related as $r)
                            <li>
                                <a href="{{ route('admin.admission-enquiries.show', $r) }}">
                                    <b>{{ $r->student_name }}</b> &middot; Grade {{ $r->grade }}
                                    <span class="sub">{{ $r->created_at->format('d M Y') }} &middot; {{ $r->status_label }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Info --}}
            <div class="card">
                <div class="section-title">
                    <h2><span class="icon"><i class="bi bi-info-circle"></i></span> Details</h2>
                </div>
                <dl class="meta">
                    <dt>Enquiry ID</dt><dd>#{{ $enquiry->id }}</dd>
                    <dt>Received</dt><dd>{{ $enquiry->created_at->format('d M Y, h:i A') }}</dd>
                    <dt>Last updated</dt><dd>{{ $enquiry->updated_at?->format('d M Y, h:i A') }}</dd>
                    <!-- <dt>IP address</dt><dd>{{ $enquiry->ip_address ?? '—' }}</dd> -->
                </dl>

                @if ($isAdmin)
                    <button type="button" class="btn-delete" onclick="confirmDelete()">
                        <i class="bi bi-trash"></i> Delete enquiry
                    </button>
                    <form id="delete-form" action="{{ route('admin.admission-enquiries.destroy', $enquiry) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('statusForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = this;
    const btn  = form.querySelector('.btn-save');
    const html = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Saving...';
    form.querySelectorAll('.field-error').forEach(el => el.remove());

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(async r => {
        const data = await r.json().catch(() => ({}));
        if (r.status === 422 && data.errors) {
            Object.values(data.errors).forEach(msgs => {
                const el = document.createElement('span');
                el.className = 'field-error';
                el.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${msgs[0]}`;
                form.querySelector('textarea').insertAdjacentElement('afterend', el);
            });
            return;
        }
        if (!r.ok) throw new Error(data.message || 'Something went wrong.');

        const pill = document.getElementById('status-pill');
        pill.className = 'status-pill st-' + data.status;
        pill.querySelector('span').textContent = data.label;

        Swal.fire({ icon: 'success', title: data.message || 'Saved', toast: true, position: 'top-end',
                    showConfirmButton: false, timer: 2000, timerProgressBar: true });
    })
    .catch(err => Swal.fire({ icon: 'error', title: 'Error', text: err.message, confirmButtonColor: '#002F5F' }))
    .finally(() => { btn.disabled = false; btn.innerHTML = html; });
});

function confirmDelete() {
    Swal.fire({
        icon: 'warning',
        title: 'Delete this enquiry?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        confirmButtonColor: '#BF0001',
        cancelButtonColor: '#667085',
        reverseButtons: true
    }).then(r => { if (r.isConfirmed) document.getElementById('delete-form').submit(); });
}
</script>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span{ cursor:pointer; }
    .crumbs span:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:22px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:24px; font-weight:700; letter-spacing:-0.02em; margin:10px 0 0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:6px 0 0; }
    .nav-btns{ display:flex; align-items:center; gap:6px; }
    .btn-outline{
        display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:600; text-decoration:none; margin-left:6px;
        color: var(--ink,#171B2C); background:#fff; border:1px solid var(--input-border,#DBDFEA); padding:9px 14px; border-radius:9px;
    }
    .icon-btn{
        display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:9px;
        border:1px solid var(--input-border,#DBDFEA); background:#fff; color: var(--muted,#667085); text-decoration:none;
    }
    .icon-btn:hover{ color: var(--ink,#171B2C); border-color: var(--ink,#171B2C); }
    .icon-btn.disabled{ opacity:.35; pointer-events:none; }

    .status-pill{ display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; }
    .st-new       { background:#FFE9D8; color:#BF0001; }
    .st-contacted { background:#EEF4FF; color:#2F5BD3; }
    .st-admitted  { background:#E6F6EC; color:#1E8E4E; }
    .st-rejected  { background:#F2F3F7; color:#555D70; }

    .cols{ display:grid; grid-template-columns:minmax(0, 2fr) minmax(0, 1fr); gap:16px; align-items:start; }
    @media (max-width:980px){ .cols{ grid-template-columns:1fr; } }
    .cols .card{ margin-bottom:16px; }

    .section-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .icon{ display:inline-flex; color: var(--orange,#BF0001); }
    .sub{ font-size:12.5px; color: var(--faint,#9AA1B2); }

    .details{ margin:0; display:grid; grid-template-columns:200px 1fr; gap:10px 16px; font-size:14px; }
    @media (max-width:560px){ .details{ grid-template-columns:1fr; gap:2px; } .details dd{ margin-bottom:10px; } }
    .details dt{ color: var(--muted,#667085); font-size:13px; }
    .details dd{ margin:0; color: var(--ink,#171B2C); font-weight:600; }
    .badge-yes{ display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; background:#EEF4FF; color:#2F5BD3; }
    .message{ font-size:14px; line-height:1.65; color: var(--ink,#171B2C); background: var(--canvas,#F6F7FB); padding:14px 16px; border-radius:10px; }

    .lbl{ display:flex; align-items:center; gap:6px; font-size:12.5px; font-weight:600; color: var(--muted,#667085); margin-bottom:8px; }
    .field-hint{ font-weight:400; color: var(--faint,#9AA1B2); }
    .status-picker{ display:grid; grid-template-columns:repeat(4, 1fr); gap:8px; }
    @media (max-width:560px){ .status-picker{ grid-template-columns:repeat(2, 1fr); } }
    .st-option input{ position:absolute; opacity:0; width:0; height:0; }
    .st-card{
        display:flex; align-items:center; justify-content:center; gap:6px; padding:10px 8px; border-radius:10px;
        font-size:13px; font-weight:700; cursor:pointer; border:2px solid transparent; opacity:.55; transition:all .15s;
    }
    .st-card:hover{ opacity:.85; }
    .st-option input:checked + .st-card{ opacity:1; border-color:currentColor; }
    .st-option input:focus-visible + .st-card{ outline:2px solid var(--ink,#171B2C); outline-offset:2px; }
    textarea{
        width:100%; box-sizing:border-box; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; resize:vertical; outline:none; line-height:1.55;
    }
    textarea:focus{ border-color: var(--orange,#BF0001); box-shadow:0 0 0 4px var(--orange-tint-strong,#FFE9D8); }
    .field-error{ display:flex; align-items:center; gap:5px; color:#e74c3c; font-size:12.5px; margin-top:6px; }
    .form-foot{ display:flex; align-items:center; justify-content:space-between; gap:12px; margin-top:14px; flex-wrap:wrap; }
    .btn-save{
        display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none; padding:10px 20px; border-radius:9px; cursor:pointer;
    }
    .btn-save:disabled{ opacity:.7; cursor:wait; }

    .parent-name{ font-size:16px; font-weight:700; color: var(--ink,#171B2C); margin-bottom:4px; }
    .contact-btns{ display:flex; flex-wrap:wrap; gap:8px; margin-top:14px; }
    .c-btn{
        flex:1; min-width:90px; display:inline-flex; align-items:center; justify-content:center; gap:6px;
        padding:9px 10px; border-radius:9px; font-size:13px; font-weight:600; text-decoration:none;
        background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); border:1px solid var(--line,#E9EBF2);
    }
    .c-btn:hover{ border-color: var(--ink,#171B2C); }
    .c-btn.wa{ background:#E6F6EC; color:#1E8E4E; border-color:#C9EBD5; }

    .related{ list-style:none; margin:0; padding:0; }
    .related li + li{ border-top:1px solid var(--line,#E9EBF2); }
    .related a{ display:block; padding:9px 0; text-decoration:none; color: var(--ink,#171B2C); font-size:13px; }
    .related a .sub{ display:block; margin-top:2px; }
    .related a:hover b{ color: var(--orange,#BF0001); }

    .meta{ margin:0; display:grid; grid-template-columns:auto 1fr; gap:8px 14px; font-size:13px; }
    .meta dt{ color: var(--faint,#9AA1B2); font-weight:600; }
    .meta dd{ margin:0; color: var(--ink,#171B2C); }
    .btn-delete{
        margin-top:16px; width:100%; display:inline-flex; align-items:center; justify-content:center; gap:6px;
        padding:9px; border-radius:9px; font-size:13px; font-weight:600; cursor:pointer;
        background:#fff; color:#C62828; border:1px solid #F3C4C4;
    }
    .btn-delete:hover{ background:#FFF6F6; }
</style>

@endsection
