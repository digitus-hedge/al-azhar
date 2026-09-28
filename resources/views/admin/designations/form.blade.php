@extends('admin.layout')
@section('title', $designation->exists ? 'Edit Designation' : 'Add Designation')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({ icon: 'success', title: 'Saved!', text: @json(session('success')), confirmButtonColor: '#002F5F', timer: 2200, timerProgressBar: true });
    });
</script>
@endif

@php
    $isEdit      = $designation->exists;
    $types       = \App\Models\ManagementDesignation::TYPES;
    // Add: type set by the controller (?type=staff preselects Staff). Edit: the saved type.
  $currentType = old('type', $designation->type);
    // Type is locked once School Management profiles or Staff use this designation
    $inUse       = $isEdit && $designation->isInUse();
@endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <span onclick="window.location='{{ route('admin.designations') }}'">Designations</span>
        <span>&rsaquo;</span>
        <b>{{ $isEdit ? 'Edit' : 'Add' }}</b>
    </div>

    <div class="header">
        <div>
            <h1>{{ $isEdit ? 'Edit Designation' : 'Add Designation' }}</h1>
            <p>{{ $isEdit
                ? 'Update this designation. Profiles and staff using it update automatically.'
                : 'Create a designation for School Management profiles or Staff.' }}</p>
        </div>
    </div>

    <form method="POST"
          action="{{ $isEdit ? route('admin.designations.update', $designation) : route('admin.designations.store') }}"
          class="card form-card" novalidate>
        @csrf
        @if ($isEdit) @method('PUT') @endif

        {{-- Designation Type --}}
        <div class="field">
            <label for="type">Designation Type <span class="req">*</span></label>
            <select id="type" name="type" class="{{ $errors->has('type') ? 'is-invalid' : '' }}" {{ $inUse ? 'disabled' : '' }}>
    <option value="" disabled @selected(blank($currentType))>— Select Type —</option>
    @foreach ($types as $key => $label)
        <option value="{{ $key }}" @selected($currentType === $key)>{{ $label }}</option>
    @endforeach
</select>
            @if ($inUse)
                {{-- A disabled select is not submitted, so send the saved type --}}
                <input type="hidden" name="type" value="{{ $designation->type }}">
            @endif
            <div class="field-foot">
                @error('type')
                    <span class="err"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @else
                    <span class="hint">
                        @if ($inUse)
                            <i class="bi bi-lock"></i> Type can't be changed because this designation is already in use.
                        @else
                            Management → School Management form &middot; Staff → Staff form.
                        @endif
                    </span>
                @enderror
            </div>
        </div>

        {{-- Designation Name --}}
        <div class="field" style="margin-top:20px;">
            <label for="name">Designation Name <span class="req">*</span></label>
            <input type="text" id="name" name="name" maxlength="35" autofocus
                   value="{{ old('name', $designation->name) }}"
                   placeholder="{{ $currentType === 'staff' ? 'e.g. PGT, Librarian' : 'e.g. Chairman' }}"
                   class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
            <div class="field-foot">
                @error('name')
                    <span class="err"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @else
                    <span class="hint">Shown under the person's name on the website.</span>
                @enderror
                <span class="counter"><span id="nameCount">{{ mb_strlen(old('name', $designation->name ?? '')) }}</span>/35</span>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.designations', array_filter(['type' => $designation->type])) }}" class="btn-cancel">Cancel</a>
            <button type="submit" name="action" value="save" class="btn-save">
                <i class="bi bi-check2"></i> {{ $isEdit ? 'Update Designation' : 'Save Designation' }}
            </button>
        </div>
    </form>
</div>

<script>
(function () {
    const input = document.getElementById('name');
    const count = document.getElementById('nameCount');
    if (input && count) {
        input.addEventListener('input', () => { count.textContent = [...input.value].length; });
    }

    // Placeholder follows the chosen type
    const placeholders = {
        staff: 'e.g. Principal, Librarian',
        management: 'e.g. Chairman',
    };
    const defaultPlaceholder = 'e.g. Chairman, PGT';

    const type = document.getElementById('type');
    if (type && input) {
        const setPlaceholder = () => {
            input.placeholder = placeholders[type.value] || defaultPlaceholder;
        };
        type.addEventListener('change', setPlaceholder);
        setPlaceholder(); // correct it on page load too (e.g. after a validation error)
    }
})();
</script>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span[onclick]{ cursor:pointer; transition:color .15s; }
    .crumbs span[onclick]:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:560px; line-height:1.55; }

.form-card{ width:100%; max-width:none; padding:24px; box-sizing:border-box; }

    .field label{ display:block; font-size:13px; font-weight:600; color: var(--ink,#171B2C); margin-bottom:8px; }
    .req{ color:#e74c3c; }
    .field input[type=text], .field select{
        width:100%; box-sizing:border-box; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C); background:#fff; outline:none;
        transition:border-color .15s, box-shadow .15s;
    }
    .field select:disabled{ background:#F6F7FB; color: var(--muted,#667085); cursor:not-allowed; }
    .field input[type=text]:focus, .field select:focus{ border-color: var(--orange,#BF0001); box-shadow:0 0 0 4px var(--orange-tint-strong,#FFE9D8); }
    .field .is-invalid{ border-color:#e74c3c; }
    .field .is-invalid:focus{ box-shadow:0 0 0 4px #FDECEC; }
    .field-foot{ display:flex; justify-content:space-between; gap:12px; margin-top:7px; font-size:12px; }
    .hint{ color: var(--faint,#9AA1B2); }
    .err{ color:#e74c3c; display:inline-flex; align-items:center; gap:5px; }
    .counter{ color: var(--faint,#9AA1B2); white-space:nowrap; }

    .form-actions{ display:flex; justify-content:flex-end; align-items:center; gap:10px; margin-top:24px; padding-top:18px; border-top:1px solid var(--line,#E9EBF2); flex-wrap:wrap; }
    .btn-cancel{ font-size:13px; font-weight:600; color: var(--muted,#667085); padding:10px 16px; border-radius:9px; text-decoration:none; }
    .btn-cancel:hover{ background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); }
    .btn-save{
        display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none; padding:11px 22px; border-radius:9px; cursor:pointer;
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4); transition:transform .12s ease, box-shadow .12s ease;
    }
    .btn-save:hover{ transform:translateY(-1px); box-shadow:0 8px 18px -6px rgba(15,21,38,0.5); }
</style>

@endsection