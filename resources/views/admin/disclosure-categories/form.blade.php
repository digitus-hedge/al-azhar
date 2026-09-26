@extends('admin.layout')
@section('title', $category->exists ? 'Edit Disclosure Category' : 'Add Disclosure Category')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({ icon: 'success', title: 'Saved!', text: @json(session('success')), confirmButtonColor: '#002F5F', timer: 2200, timerProgressBar: true });
    });
</script>
@endif

@php $isEdit = $category->exists; @endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <span onclick="window.location='{{ route('admin.disclosure-categories') }}'">Disclosure Categories</span>
        <span>&rsaquo;</span>
        <b>{{ $isEdit ? 'Edit' : 'Add' }}</b>
    </div>

    <div class="header">
        <div>
            <h1>{{ $isEdit ? 'Edit Category' : 'Add Category' }}</h1>
            <p>{{ $isEdit ? 'Rename this category. Documents already in it stay linked.' : 'Create a category to group Mandatory Disclosure documents.' }}</p>
        </div>
    </div>

    <form method="POST"
          action="{{ $isEdit ? route('admin.disclosure-categories.update', $category) : route('admin.disclosure-categories.store') }}"
          class="card form-card" novalidate>
        @csrf
        @if ($isEdit) @method('PUT') @endif

        <div class="field">
            <label for="name">Category Name <span class="req">*</span></label>
            <input type="text" id="name" name="name" maxlength="35" autofocus
                   value="{{ old('name', $category->name) }}"
                   placeholder="e.g. CBSE Affiliation, NOC, Trust Deed and Safety Certificates..."
                   class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
            <div class="field-foot">
                @error('name')
                    <span class="err"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @else
                    <span class="hint">Shown as a heading on the public Mandatory Disclosure page.</span>
                @enderror
                <span class="counter"><span id="nameCount">{{ mb_strlen(old('name', $category->name ?? '')) }}</span>/35</span>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.disclosure-categories') }}" class="btn-cancel">Cancel</a>
            <!-- @unless ($isEdit)
                <button type="submit" name="action" value="save_new" class="btn-outline">
                    <i class="bi bi-plus-lg"></i> Save &amp; add another
                </button>
            @endunless -->
            <button type="submit" name="action" value="save" class="btn-save">
                <i class="bi bi-check2"></i> {{ $isEdit ? 'Update Category' : 'Save Category' }}
            </button>
        </div>
    </form>
</div>

<script>
(function () {
    const input = document.getElementById('name');
    const count = document.getElementById('nameCount');
    if (!input || !count) return;
    input.addEventListener('input', () => { count.textContent = input.value.length; });
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
    .field input[type=text]{
        width:100%; box-sizing:border-box; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C); background:#fff; outline:none;
        transition:border-color .15s, box-shadow .15s;
    }
    .field input[type=text]:focus{ border-color: var(--orange,#BF0001); box-shadow:0 0 0 4px var(--orange-tint-strong,#FFE9D8); }
    .field input.is-invalid{ border-color:#e74c3c; }
    .field input.is-invalid:focus{ box-shadow:0 0 0 4px #FDECEC; }
    .field-foot{ display:flex; justify-content:space-between; gap:12px; margin-top:7px; font-size:12px; }
    .hint{ color: var(--faint,#9AA1B2); }
    .err{ color:#e74c3c; display:inline-flex; align-items:center; gap:5px; }
    .counter{ color: var(--faint,#9AA1B2); white-space:nowrap; }

    .form-actions{ display:flex; justify-content:flex-end; align-items:center; gap:10px; margin-top:24px; padding-top:18px; border-top:1px solid var(--line,#E9EBF2); flex-wrap:wrap; }
    .btn-cancel{ font-size:13px; font-weight:600; color: var(--muted,#667085); padding:10px 16px; border-radius:9px; text-decoration:none; }
    .btn-cancel:hover{ background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); }
    .btn-outline{
        display:inline-flex; align-items:center; gap:7px; font-size:13px; font-weight:600; color: var(--ink,#171B2C);
        background:#fff; border:1px solid var(--input-border,#DBDFEA); padding:10px 16px; border-radius:9px; cursor:pointer;
    }
    .btn-outline:hover{ border-color: var(--ink,#171B2C); }
    .btn-save{
        display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none; padding:11px 22px; border-radius:9px; cursor:pointer;
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4); transition:transform .12s ease, box-shadow .12s ease;
    }
    .btn-save:hover{ transform:translateY(-1px); box-shadow:0 8px 18px -6px rgba(15,21,38,0.5); }
</style>

@endsection
