@extends('admin.layout')
@section('title', $item->exists ? 'Edit Section' : 'Add Section')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($errors->any())
<div class="notice caution" style="margin-bottom:20px;">
    <i class="bi bi-exclamation-triangle" style="font-size:15px;flex-shrink:0;margin-top:1px;"></i>
    <p>Please fix the highlighted fields below before submitting.</p>
</div>
@endif

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <span onclick="window.location='{{ route('admin.classes') }}'">Section</span>
        <span>&rsaquo;</span>
        <b>{{ $item->exists ? 'Edit' : 'Add' }}</b>
    </div>

    <div class="header">
        <div>
            <h1>{{ $item->exists ? 'Edit Section' : 'Add Section' }}</h1>
            <p>Section used across the school, optionally grouped under a department.</p>
        </div>
    </div>

    <form action="{{ $item->exists ? route('admin.classes.update', $item) : route('admin.classes.store') }}"
          method="POST" id="classForm">
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-collection"></i></span> Section Details</h2>
            </div>

            <div class="row-fields">
                <div class="field" style="flex:2;">
                    <div class="field-top"><label class="field-label">Name <span class="req">*</span></label></div>
                    <input type="text" name="name" value="{{ old('name', $item->name) }}"
                           class="{{ $errors->has('name') ? 'input-error' : '' }}"
                           placeholder="e.g. Higher Secondary">
                    @error('name')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

          
            </div>

            <div class="field">
                <div class="field-top">
                    <label class="field-label">Department</label>
                    <span class="field-hint">Optional</span>
                </div>
                <select name="department_id" class="{{ $errors->has('department_id') ? 'input-error' : '' }}">
                    <option value="">— None —</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}"
                            {{ (int) old('department_id', $item->department_id) === $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- <div class="row-fields">
                <div class="field" style="flex:1;">
                    <div class="field-top"><label class="field-label">Sort Order</label></div>
                    <input type="number" name="sort_order" min="0"
                           value="{{ old('sort_order', $item->sort_order ?? 0) }}"
                           class="{{ $errors->has('sort_order') ? 'input-error' : '' }}">
                    @error('sort_order')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>
            </div> -->

            <!-- <label class="toggle-row" for="is_active">
                <span>
                    <span class="field-label">Active</span>
                    <span class="field-hint d-block">Available for selection elsewhere (e.g. student admission)</span>
                </span>
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
            </label> -->
        </div>

        <div class="savebar">
            <div class="savebar-inner">
                <span class="savebar-status">&nbsp;</span>
                <div class="btn-group">
                    <a href="{{ route('admin.classes') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <i class="bi bi-check-lg"></i>
                        {{ $item->exists ? 'Update Class' : 'Create Class' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
      .req{ color: #BF0001; }
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span:not(:last-child){ cursor:pointer; }
    .crumbs span:not(:last-child):hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:560px; line-height:1.55; }

    .section-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:6px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .icon{ display:inline-flex; color: var(--orange,#BF0001); }

    .field{ margin-bottom:24px; }
    .field:last-child{ margin-bottom:0; }
    .field-top{ display:flex; align-items:baseline; justify-content:space-between; margin-bottom:8px; }
    .field-label{ font-size:13px; font-weight:600; color: var(--ink,#171B2C); }
    .field-hint{ font-size:11.5px; color: var(--faint,#9AA1B2); }
    .field-hint.d-block{ display:block; margin-top:2px; }
    .row-fields{ display:flex; gap:16px; flex-wrap:wrap; margin-bottom:24px; }

    input[type=text], input[type=number], textarea, select{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; transition:box-shadow .15s, border-color .15s; background:#fff;
    }
    input:focus, textarea:focus, select:focus{
        border-color: var(--orange,#BF0001);
        box-shadow: 0 0 0 4px var(--orange-tint-strong,#FFE9D8);
    }
    .input-error{ border-color:#e74c3c !important; background:#fff8f8; }
    .field-error{ display:flex; align-items:center; gap:5px; color:#e74c3c; font-size:12.5px; margin-top:6px; }

    .notice{ margin-top:16px; display:flex; align-items:flex-start; gap:8px; background: var(--canvas,#F6F7FB); border-radius:10px; padding:10px 12px; }
    .notice p{ font-size:12px; color: var(--muted,#667085); margin:0; }
    .notice.caution{ background:#FFF8E8; border:1px solid #F5E3B3; margin-top:0; margin-bottom:16px; }
    .notice.caution i{ color:#B7791F; }
    .notice.caution p{ color:#8A6116; }

    .toggle-row{ display:flex; align-items:center; justify-content:space-between; gap:16px; cursor:pointer; padding:4px 0; }
    .toggle-row input[type=checkbox]{ width:40px; height:22px; accent-color: var(--orange,#BF0001); cursor:pointer; }

    .savebar{
        position:sticky; bottom:0; border-top:1px solid var(--line,#E9EBF2);
        background:rgba(255,255,255,0.92); backdrop-filter:blur(6px);
        margin:24px -32px -32px; padding:0 32px;
        box-shadow:0 -4px 16px -8px rgba(15,21,38,0.06);
    }
    .savebar-inner{ padding:16px 0; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; }
    .btn-group{ display:flex; align-items:center; gap:12px; }
    .btn-cancel{
        font-size:13px; font-weight:600; color: var(--muted,#667085); background:none; border:none;
        padding:10px 16px; border-radius:8px; cursor:pointer; text-decoration:none;
    }
    .btn-cancel:hover{ color: var(--ink,#171B2C); background: var(--canvas,#F6F7FB); }
    .btn-save{
        display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none;
        padding:11px 22px; border-radius:9px; cursor:pointer;
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4);
    }
    .btn-save:hover{ transform:translateY(-1px); }
</style>

@endsection
