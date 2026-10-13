@extends('admin.layout')
@section('title', 'Hostel Enquiry Details')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success', title: 'Saved!',
            text: @json(session('success')),
            confirmButtonColor: '#002F5F', timer: 2000, timerProgressBar: true
        });
    });
</script>
@endif

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <span onclick="window.location='{{ route('admin.hostel-enquiries') }}'">Hostel Enquiries</span>
        <span>&rsaquo;</span>
        <b>#{{ $item->id }}</b>
    </div>

    <div class="header">
        <div>
            <h1>{{ $item->student_name }}</h1>
            <p>Submitted on {{ $item->created_at?->format('d M Y, h:i A') }}</p>
        </div>
        <a href="{{ route('admin.hostel-enquiries') }}" class="btn-ghost">
            <i class="bi bi-arrow-left"></i> Back to list
        </a>
    </div>

    {{-- Applicant details --}}
    <div class="card">
        <div class="section-title">
            <h2><i class="bi bi-person-circle"></i> Applicant Details</h2>
            <span class="badge badge-{{ $item->status }}">{{ $statuses[$item->status] ?? ucfirst($item->status) }}</span>
        </div>

        <div class="details-grid">
            <div class="detail">
                <div class="dt-label">Student Name</div>
                <div class="dt-val">{{ $item->student_name }}</div>
            </div>
            <div class="detail">
                <div class="dt-label">Age</div>
                <div class="dt-val">{{ $item->age ?? '—' }}</div>
            </div>
            <div class="detail">
                <div class="dt-label">Gender</div>
                <div class="dt-val">{{ ucfirst($item->gender ?? '—') }}</div>
            </div>
            <div class="detail">
                <div class="dt-label">Class</div>
                <div class="dt-val">{{ $item->class_name_snapshot ?? '—' }}</div>
            </div>
            <div class="detail">
                <div class="dt-label">Parent Name</div>
                <div class="dt-val">{{ $item->parent_name ?? '—' }}</div>
            </div>
            <div class="detail">
                <div class="dt-label">Parent Phone</div>
                <div class="dt-val">
                    @if ($item->parent_phone)
                        <a href="tel:{{ $item->parent_phone }}" class="link">{{ $item->parent_phone }}</a>
                    @else — @endif
                </div>
            </div>
            <div class="detail">
                <div class="dt-label">Parent Email</div>
                <div class="dt-val">
                    @if ($item->parent_email)
                        <a href="mailto:{{ $item->parent_email }}" class="link">{{ $item->parent_email }}</a>
                    @else — @endif
                </div>
            </div>
            <div class="detail" style="grid-column:1/-1;">
                <div class="dt-label">Address</div>
                <div class="dt-val">{{ $item->address ?? '—' }}</div>
            </div>
        </div>
    </div>

    {{-- Status / Notes --}}
    <div class="card">
        <div class="section-title">
            <h2><i class="bi bi-check2-square"></i> Status &amp; Notes</h2>
        </div>

        <form action="{{ route('admin.hostel-enquiries.status', $item) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="field">
                <label class="field-label">Status</label>
                <select name="status" class="{{ $errors->has('status') ? 'input-error' : '' }}">
                    @foreach ($statuses as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $item->status) === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <label class="field-label">Admin Notes</label>
                <textarea name="admin_notes" rows="4"
                          class="{{ $errors->has('admin_notes') ? 'input-error' : '' }}"
                          placeholder="Internal notes about this enquiry...">{{ old('admin_notes', $item->admin_notes) }}</textarea>
                @error('admin_notes')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:8px;">
                <button type="submit" class="btn-save">
                    <i class="bi bi-check-lg"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
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

    .section-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:6px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .section-title h2 i{ color: var(--orange,#BF0001); }

    .badge{
        display:inline-block; font-size:11.5px; font-weight:600; padding:4px 10px;
        border-radius:999px;
    }
    .badge-pending   { background:#FFF8E8; color:#B7791F; }
    .badge-in_review { background:#E7ECF1; color:#002F5F; }
    .badge-approved  { background:#E9F8EF; color:#12875A; }
    .badge-rejected  { background:#FFF5F5; color:#B91C1C; }

    .details-grid{
        display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:18px 24px;
    }
    .detail{ min-width:0; }
    .dt-label{ font-size:11.5px; font-weight:600; color: var(--faint,#9AA1B2); text-transform:uppercase; letter-spacing:.04em; margin-bottom:4px; }
    .dt-val{ font-size:14px; color: var(--ink,#171B2C); word-break:break-word; }

    .link{ color:#002F5F; text-decoration:none; }
    .link:hover{ text-decoration:underline; }

    .field{ margin-bottom:20px; }
    .field-label{ display:block; font-size:13px; font-weight:600; color: var(--ink,#171B2C); margin-bottom:8px; }
    select, textarea{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; transition:box-shadow .15s, border-color .15s; background:#fff;
    }
    textarea{ resize:vertical; line-height:1.5; }
    select:focus, textarea:focus{
        border-color: var(--orange,#BF0001);
        box-shadow: 0 0 0 4px var(--orange-tint-strong,#FFE9D8);
    }
    .input-error{ border-color:#e74c3c !important; background:#fff8f8; }
    .field-error{ display:flex; align-items:center; gap:5px; color:#e74c3c; font-size:12.5px; margin-top:6px; }

    .btn-save{
        display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none;
        padding:11px 22px; border-radius:9px; cursor:pointer;
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4);
    }
    .btn-save:hover{ transform:translateY(-1px); }
</style>

@endsection
