@extends('admin.layout')
@section('title', $disclosure->exists ? 'Edit Document' : 'Add Document')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($errors->any())
<div class="notice caution" style="margin-bottom:20px;">
    <i class="bi bi-exclamation-triangle" style="font-size:15px;flex-shrink:0;margin-top:1px;"></i>
    <p>Please fill in the highlighted fields below before submitting.</p>
</div>
@endif

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <span onclick="window.location='{{ route('admin.mandatory-disclosures') }}'">Mandatory Disclosure</span>
        <span>&rsaquo;</span>
        <b>{{ $disclosure->exists ? 'Edit' : 'Add' }}</b>
    </div>

    <div class="header">
        <div>
            <h1>{{ $disclosure->exists ? 'Edit Document' : 'Add Document' }}</h1>
            <p>{{ $disclosure->exists
                ? 'Update this document. Upload a new PDF only if you want to replace the current one.'
                : 'Upload a statutory document (PDF) for the Mandatory Disclosure page.' }}</p>
        </div>
    </div>

    <form action="{{ $disclosure->exists ? route('admin.mandatory-disclosures.update', $disclosure) : route('admin.mandatory-disclosures.store') }}"
          method="POST" enctype="multipart/form-data" id="disclosureForm" novalidate>
        @csrf
        @if ($disclosure->exists)
            @method('PUT')
        @endif

        {{-- Title --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-file-earmark-text"></i></span> Document Title <span class="req">*</span></h2>
            </div>
            <div class="field">
                <input type="text" name="title" value="{{ old('title', $disclosure->title) }}"
                       class="{{ $errors->has('title') ? 'input-error' : '' }}"
                       placeholder="e.g. Fire Safety Certificate">
                @error('title')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Category --}}
       
        {{-- PDF --}}
        <div class="card" id="fileSection">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-file-earmark-pdf"></i></span> PDF File
                    @if (! $disclosure->exists) <span class="req">*</span> @endif
                </h2>
            </div>

            <div class="notice caution">
                <i class="bi bi-exclamation-triangle" style="margin-top:1px;"></i>
                <p><b>PDF only</b> &middot; up to 10MB. Upload the signed / stamped copy.</p>
            </div>

            @if ($disclosure->file)
                <div class="current-file" id="currentFile">
                    <div class="pdf-ico"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                    <div class="pdf-meta">
                        <b>{{ $disclosure->original_name ?: basename($disclosure->file) }}</b>
                        <small>Current file {{ $disclosure->file_size_label ? '· ' . $disclosure->file_size_label : '' }}</small>
                    </div>
                    <a href="{{ $disclosure->file_url }}" target="_blank" class="pdf-view">
                        <i class="bi bi-box-arrow-up-right"></i> View
                    </a>
                </div>
            @endif

            <label class="pdf-drop {{ $errors->has('file') ? 'input-error' : '' }}" id="pdfDrop" for="fileInput">
                <div class="ico-circle"><i class="bi bi-cloud-arrow-up" style="color:#AEB4C4;font-size:18px;"></i></div>
                <div class="drop-title" id="pdfDropTitle">
                    {{ $disclosure->file ? 'Click to replace the PDF' : 'Click to upload PDF' }}
                </div>
                <div class="drop-sub" id="pdfDropSub">or drag &amp; drop here</div>
            </label>
            <input type="file" name="file" id="fileInput" accept="application/pdf,.pdf" hidden>
            <span class="file-size-info" id="fileSizeInfo"></span>

            @error('file')
                <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>

        {{-- Order & Visibility --}}

        <!-- <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-toggles"></i></span> Order &amp; Visibility</h2>
            </div>

            <div class="field">
                <div class="field-top"><label class="field-label">Display Order</label></div>
                <input type="number" name="sort_order" min="0"
                       value="{{ old('sort_order', $disclosure->sort_order ?? 0) }}"
                       class="{{ $errors->has('sort_order') ? 'input-error' : '' }}"
                       style="max-width:160px;">
                @error('sort_order')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
                <span class="field-hint">Lower numbers appear first within the category.</span>
            </div>

            <label class="toggle-row">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $disclosure->exists ? $disclosure->is_active : true) ? 'checked' : '' }}>
                <span class="toggle-switch"></span>
                <span class="toggle-label">Show on website</span>
            </label>
        </div> -->

        <div class="savebar">
            <div class="savebar-inner">
                <span class="savebar-status">Changes save to the live Mandatory Disclosure page</span>
                <div class="btn-group">
                    <a href="{{ route('admin.mandatory-disclosures') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <i class="bi bi-check-lg"></i>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    /* ---------- PDF picker: preview name + size, drag & drop ---------- */
    const MAX_MB    = 10;
    const fileInput = document.getElementById('fileInput');
    const pdfDrop   = document.getElementById('pdfDrop');

    function showPickedFile(file) {
        const info  = document.getElementById('fileSizeInfo');
        const title = document.getElementById('pdfDropTitle');
        const sub   = document.getElementById('pdfDropSub');

        if (!file) { info.textContent = ''; return; }

        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        const isPdf  = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');

        title.textContent = file.name;
        sub.textContent   = 'Click to choose a different file';
        pdfDrop.classList.add('picked');

        if (!isPdf) {
            info.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Only PDF files are allowed.';
            info.classList.add('size-error');
        } else if (sizeMB > MAX_MB) {
            info.innerHTML = `<i class="bi bi-exclamation-triangle"></i> ${sizeMB} MB — exceeds ${MAX_MB}MB limit!`;
            info.classList.add('size-error');
        } else {
            info.innerHTML = `<i class="bi bi-check-circle"></i> ${sizeMB} MB — ready to upload`;
            info.classList.remove('size-error');
        }
    }

    fileInput.addEventListener('change', () => showPickedFile(fileInput.files[0]));

    ['dragenter', 'dragover'].forEach(ev => pdfDrop.addEventListener(ev, e => {
        e.preventDefault(); pdfDrop.classList.add('dragging');
    }));
    ['dragleave', 'drop'].forEach(ev => pdfDrop.addEventListener(ev, e => {
        e.preventDefault(); pdfDrop.classList.remove('dragging');
    }));
    pdfDrop.addEventListener('drop', e => {
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            showPickedFile(fileInput.files[0]);
        }
    });

    /* ---------- AJAX save ---------- */
    document.getElementById('disclosureForm').addEventListener('submit', function (e) {
        e.preventDefault();
        submitDisclosureForm();
    });

    function submitDisclosureForm() {
        const form      = document.getElementById('disclosureForm');
        const formData  = new FormData(form);
        const submitBtn = form.querySelector('.btn-save');
        const original  = submitBtn.innerHTML;

        form.querySelectorAll('.field-error').forEach(el => el.remove());
        form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));

        submitBtn.disabled  = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Saving...';

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(async (response) => {
            const data = await response.json().catch(() => null);

            if (response.status === 422 && data && data.errors) {
                showDisclosureErrors(data.errors);
                return;
            }
            if (response.status === 413) {
                showDisclosureErrors({ file: ['The PDF is too large for the server to accept.'] });
                return;
            }
            if (!response.ok) throw new Error('Request failed');

            Swal.fire({
                icon: 'success',
                title: 'Saved!',
                text: data && data.message ? data.message : 'Document saved successfully.',
                confirmButtonColor: '#002F5F',
                timer: 2000,
                timerProgressBar: true
            }).then(() => {
                window.location.href = "{{ route('admin.mandatory-disclosures') }}";
            });
        })
        .catch(() => {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.', confirmButtonColor: '#002F5F' });
        })
        .finally(() => {
            submitBtn.disabled  = false;
            submitBtn.innerHTML = original;
        });
    }

    function showDisclosureErrors(errors) {
        const form = document.getElementById('disclosureForm');
        const fieldMap = {
            title:       f => f.querySelector('[name="title"]'),
            category:    f => f.querySelector('[name="category"]'),
            issued_by:   f => f.querySelector('[name="issued_by"]'),
            issue_date:  f => f.querySelector('[name="issue_date"]'),
            valid_until: f => f.querySelector('[name="valid_until"]'),
            file:        f => document.getElementById('pdfDrop'),
            sort_order:  f => f.querySelector('[name="sort_order"]'),
        };

        Object.keys(errors).forEach(field => {
            const target = fieldMap[field] ? fieldMap[field](form) : null;
            if (!target) return;

            target.classList.add('input-error');

            const errorEl = document.createElement('span');
            errorEl.className = 'field-error';
            errorEl.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${errors[field][0]}`;
            target.insertAdjacentElement('afterend', errorEl);
        });

        const first = form.querySelector('.input-error');
        if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const first = document.querySelector('.input-error') || document.querySelector('.field-error');
        if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
</script>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span{ cursor:pointer; transition:color .15s; }
    .crumbs span:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:560px; line-height:1.55; }

    .card + .card{ margin-top:15px; }
    .section-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:6px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .icon{ display:inline-flex; color: var(--orange,#BF0001); }

    .field{ margin-bottom:22px; }
    .field:last-child{ margin-bottom:0; }
    .field-row{ display:flex; gap:16px; flex-wrap:wrap; }
    .field-row .field{ flex:1; min-width:200px; margin-bottom:0; }
    .field-top{ margin-bottom:8px; }
    .field-label{ font-size:13px; font-weight:600; color: var(--ink,#171B2C); }
    .field-hint{ display:block; font-size:12px; color: var(--faint,#9AA1B2); margin-top:6px; }

    input[type=text], input[type=date], input[type=number], select{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; transition:box-shadow .15s, border-color .15s; background:#fff;
    }
    input[type=text]:focus, input[type=date]:focus, input[type=number]:focus, select:focus{
        border-color: var(--orange,#BF0001);
        box-shadow: 0 0 0 4px var(--orange-tint-strong,#FFE9D8);
    }
    .input-error{ border-color:#e74c3c !important; background:#fff8f8 !important; }
    .field-error{ display:flex; align-items:center; gap:5px; color:#e74c3c; font-size:12.5px; margin-top:6px; }

    .notice{ display:flex; align-items:flex-start; gap:8px; border-radius:10px; padding:10px 12px; }
    .notice p{ font-size:12px; margin:0; }
    .notice.caution{ background:#FFF8E8; border:1px solid #F5E3B3; margin-bottom:16px; }
    .notice.caution i{ color:#B7791F; }
    .notice.caution p{ color:#8A6116; }
    .notice.caution p b{ color:#6B4A0E; }

    /* Current file row */
    .current-file{
        display:flex; align-items:center; gap:12px; padding:12px 14px; margin-bottom:12px;
        border:1px solid var(--line,#E9EBF2); border-radius:10px; background: var(--canvas,#F6F7FB);
    }
    .pdf-ico{ width:38px; height:38px; border-radius:9px; background:#FEECEC; color:#D92D20;
              display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
    .pdf-meta{ display:flex; flex-direction:column; min-width:0; flex:1; }
    .pdf-meta b{ font-size:13px; color: var(--ink,#171B2C); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .pdf-meta small{ font-size:11.5px; color: var(--faint,#9AA1B2); }
    .pdf-view{ font-size:12.5px; font-weight:600; color: var(--orange,#BF0001); text-decoration:none; display:flex; align-items:center; gap:5px; }

    /* PDF drop zone */
    .pdf-drop{
        display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;
        padding:26px 16px; border:2px dashed var(--input-border,#DBDFEA); border-radius:12px; background:#FAFBFD;
        cursor:pointer; transition:border-color .15s, background .15s;
    }
    .pdf-drop:hover, .pdf-drop.dragging{ border-color: var(--orange,#BF0001); background: var(--orange-tint,#FFF8F3); }
    .pdf-drop.picked{ border-style:solid; border-color:#A6D8B8; background:#F3FBF6; }
    .ico-circle{ width:40px; height:40px; border-radius:999px; background:#EEF0F6; display:flex; align-items:center; justify-content:center; margin-bottom:8px; }
    .drop-title{ font-size:13px; font-weight:600; color: var(--ink,#171B2C); word-break:break-all; }
    .drop-sub{ font-size:11.5px; color:#B0B5C4; margin-top:2px; }
    .file-size-info{ display:block; font-size:12px; color:#1e8449; margin-top:6px; }
    .file-size-info.size-error{ color:#e74c3c; font-weight:600; }

    /* Toggle */
    .toggle-row{ display:flex; align-items:center; gap:12px; cursor:pointer; margin-top:6px; }
    .toggle-row input[type="checkbox"]{ position:absolute; opacity:0; width:0; height:0; }
    .toggle-switch{ position:relative; width:42px; height:24px; border-radius:999px; background:#DBDFEA; flex-shrink:0; transition:background .15s; }
    .toggle-switch::after{ content:''; position:absolute; top:2px; left:2px; width:20px; height:20px; border-radius:999px; background:#fff; box-shadow:0 1px 2px rgba(0,0,0,0.2); transition:transform .15s; }
    .toggle-row input[type="checkbox"]:checked + .toggle-switch{ background: var(--orange,#BF0001); }
    .toggle-row input[type="checkbox"]:checked + .toggle-switch::after{ transform:translateX(18px); }
    .toggle-label{ font-size:13.5px; color: var(--ink,#171B2C); }

    /* Save bar */
    .savebar{
        position:sticky; bottom:0; border-top:1px solid var(--line,#E9EBF2);
        background:rgba(255,255,255,0.92); backdrop-filter:blur(6px);
        margin:24px -32px -32px; padding:0 32px;
        box-shadow:0 -4px 16px -8px rgba(15,21,38,0.06);
    }
    .savebar-inner{ padding:16px 0; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; }
    .savebar-status{ font-size:12px; color: var(--faint,#9AA1B2); }
    .btn-group{ display:flex; align-items:center; gap:12px; }
    .btn-cancel{ font-size:13px; font-weight:600; color: var(--muted,#667085); padding:10px 16px; border-radius:8px; text-decoration:none; transition:color .15s, background .15s; }
    .btn-cancel:hover{ color: var(--ink,#171B2C); background: var(--canvas,#F6F7FB); }
    .btn-save{
        display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none;
        padding:11px 22px; border-radius:9px; cursor:pointer;
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4);
        transition:transform .12s ease, box-shadow .12s ease;
    }
    .btn-save:hover{ transform:translateY(-1px); box-shadow:0 8px 18px -6px rgba(15,21,38,0.5); }
    .btn-save:disabled{ opacity:.7; cursor:wait; transform:none; }

    .req{ color:#BF0001; }
</style>

@endsection
