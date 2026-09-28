@extends('admin.layout')
@section('title', $member->exists ? 'Edit Profile' : 'Add Profile')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@php
    $isEdit = $member->exists;
    $bioMax = \App\Http\Requests\ManagementMemberRequest::BIO_MAX;
@endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <span onclick="window.location='{{ route('admin.school-management') }}'">School Management</span>
        <span>&rsaquo;</span>
        <b>{{ $isEdit ? 'Edit' : 'Add' }}</b>
    </div>

    <div class="header">
        <div>
            <h1>{{ $isEdit ? 'Edit Profile' : 'Add Profile' }}</h1>
            <p>Name, designation, photo and a short bio for the School Management page.</p>
        </div>
    </div>

    <div class="notice caution" id="formErrorNotice" style="{{ $errors->any() ? '' : 'display:none;' }}">
        <i class="bi bi-exclamation-triangle"></i>
        <p>Please fix the highlighted fields below before saving.</p>
    </div>

    <form action="{{ $isEdit ? route('admin.school-management.update', $member) : route('admin.school-management.store') }}"
          method="POST" enctype="multipart/form-data" id="memberForm" novalidate>
        @csrf
        @if ($isEdit) @method('PUT') @endif

        <div class="form-grid">
            {{-- LEFT: details --}}
            <div class="form-main">
                <div class="card">
                    <div class="section-title">
                        <h2><span class="icon"><i class="bi bi-person-vcard"></i></span> Profile Details</h2>
                    </div>

                    <div class="field">
                        <div class="field-top"><label class="field-label" for="name">Full Name <span class="req">*</span></label></div>
                        <input type="text" id="name" name="name" maxlength="150"
                               value="{{ old('name', $member->name) }}"
                               class="{{ $errors->has('name') ? 'input-error' : '' }}"
                               placeholder="e.g.Ahmed Khan">
                        @error('name') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <div class="field-top field-top-row">
                            <label class="field-label" for="designation_id">Designation <span class="req">*</span></label>
                           <a href="{{ route('admin.designations.create', ['type' => 'management']) }}" target="_blank" class="add-link">
    <i class="bi bi-plus-lg"></i> New designation
</a>
                        </div>
                        <select id="designation_id" name="designation_id"
                                class="{{ $errors->has('designation_id') ? 'input-error' : '' }}"
                                {{ $designations->isEmpty() ? 'disabled' : '' }}>
                            <option value="">— Select Designation —</option>
                            @foreach ($designations as $d)
                                <option value="{{ $d->id }}"
                                    @selected((string) old('designation_id', $member->designation_id) === (string) $d->id)>
                                    {{ $d->name }}{{ $d->trashed() ? ' (deleted)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('designation_id') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                        @if ($designations->isEmpty())
                            <span class="field-hint" style="color:#B7791F;">
                                <i class="bi bi-exclamation-triangle"></i>
                                No designations yet. Add them under Master &rsaquo; Management Designations, then reload this page.
                            </span>
                        @else
                            <span class="field-hint">Profiles are ordered automatically by designation (Chairman, Vice Chairman, Secretary, ...).</span>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="section-title">
                        <h2><span class="icon"><i class="bi bi-card-text"></i></span> Brief Bio <span class="req">*</span></h2>
                        <span class="field-hint"><b id="bioCount">0</b> / {{ $bioMax }} characters</span>
                    </div>
                    <div class="field">
                        <textarea id="bio" name="bio" rows="6" maxlength="{{ $bioMax }}"
                                  class="{{ $errors->has('bio') ? 'input-error' : '' }}"
                                  placeholder="Qualifications, experience and role in the institution (2–4 sentences)...">{{ old('bio', $member->bio) }}</textarea>
                        @error('bio') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                        <span class="field-hint">Optional. Shown under the name on the website.</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT: photo --}}
            <div class="form-side">
                <div class="card" id="photoSection">
                    <div class="section-title">
                        <h2><span class="icon"><i class="bi bi-image"></i></span> Photo </h2>
                        <span class="field-hint">Optional</span>
                    </div>

                    <div class="photo-drop {{ $member->photo ? 'filled' : '' }} {{ $errors->has('photo') ? 'input-error' : '' }}"
                         id="photoDrop" onclick="document.getElementById('photoInput').click()">
                        <img id="photoPreview" src="{{ $member->photo_url }}" alt="" style="{{ $member->photo ? '' : 'display:none;' }}">

                        <div class="photo-empty" id="photoEmpty" style="{{ $member->photo ? 'display:none;' : '' }}">
                            <span class="initials" id="photoInitials">{{ $member->exists ? $member->initials : '' }}</span>
                            <i class="bi bi-camera" id="photoCam" style="{{ $member->exists ? 'display:none;' : '' }}"></i>
                            <div class="drop-title">Upload photo</div>
                            <div class="drop-sub">Recommended:304×335px JPG, PNG, WEBP · up to 2MB</div>
                        </div>

                        <button type="button" class="remove-img-btn" id="removePhotoBtn" title="Remove photo"
                                onclick="removePhoto(event)" style="{{ $member->photo ? '' : 'display:none;' }}">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <input type="file" name="photo" id="photoInput" accept="image/jpeg,image/png,image/webp" hidden>
                    <input type="hidden" name="remove_photo" id="removePhotoInput" value="0">
                    <span class="field-hint" id="photoInfo">Profile photo recommended. If empty, initials are shown.</span>
                    @error('photo') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

            </div>
        </div>

        <div class="savebar">
            <div class="savebar-inner">
                <span class="savebar-status">Changes save to the live School Management page</span>
                <div class="btn-group">
                    <a href="{{ route('admin.school-management') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save"><i class="bi bi-check-lg"></i> {{ $isEdit ? 'Update Profile' : 'Save Profile' }}</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    /* ---------- Bio character counter ---------- */
    (function () {
        const bio = document.getElementById('bio');
        const out = document.getElementById('bioCount');
        const max = {{ $bioMax }};
        const update = () => {
            out.textContent = bio.value.length;
            out.parentElement.classList.toggle('near', bio.value.length > max * 0.9);
        };
        bio.addEventListener('input', update);
        update();
    })();

    /* ---------- Live initials for the empty photo circle ---------- */
    (function () {
        const name = document.getElementById('name');
        const ini  = document.getElementById('photoInitials');
        const cam  = document.getElementById('photoCam');
        const titles = ['dr', 'mr', 'mrs', 'ms', 'prof', 'rev', 'adv', 'er'];
        name.addEventListener('input', function () {
            const words = this.value.trim().split(/\s+/).filter(w => w && !titles.includes(w.replace(/\.$/, '').toLowerCase()));
            const text = words.length ? (words[0][0] + (words.length > 1 ? words[words.length - 1][0] : '')).toUpperCase() : '';
            ini.textContent = text;
            cam.style.display = text ? 'none' : '';
        });
    })();

    /* ---------- Photo picker ---------- */
    const MAX_PHOTO_MB = 2;
    document.getElementById('photoInput').addEventListener('change', function () {
        const file = this.files[0];
        const info = document.getElementById('photoInfo');
        if (!file) return;

        const sizeMB = file.size / (1024 * 1024);
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            info.innerHTML = '<span style="color:#e74c3c;font-weight:600;">Only JPG, PNG or WEBP images are allowed.</span>';
            this.value = ''; return;
        }
        if (sizeMB > MAX_PHOTO_MB) {
            info.innerHTML = `<span style="color:#e74c3c;font-weight:600;">${sizeMB.toFixed(2)} MB — exceeds the 2MB limit.</span>`;
            this.value = ''; return;
        }

        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('photoPreview');
            img.src = e.target.result;
            img.style.display = '';
            document.getElementById('photoEmpty').style.display = 'none';
            document.getElementById('removePhotoBtn').style.display = '';
            document.getElementById('photoDrop').classList.add('filled');
            document.getElementById('removePhotoInput').value = '0';
            info.innerHTML = `<span style="color:#1e8449;">${file.name} · ${sizeMB.toFixed(2)} MB — ready</span>`;
        };
        reader.readAsDataURL(file);
    });

    function removePhoto(e) {
        e.stopPropagation();
        document.getElementById('photoInput').value = '';
        const img = document.getElementById('photoPreview');
        img.src = ''; img.style.display = 'none';
        document.getElementById('photoEmpty').style.display = '';
        document.getElementById('removePhotoBtn').style.display = 'none';
        document.getElementById('photoDrop').classList.remove('filled');
        document.getElementById('removePhotoInput').value = '1';
        document.getElementById('photoInfo').textContent = 'Photo will be removed when you save.';
    }

    /* ---------- AJAX save ---------- */
    document.getElementById('memberForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = this;
        const btn  = form.querySelector('.btn-save');
        const html = btn.innerHTML;

        form.querySelectorAll('.field-error.js').forEach(el => el.remove());
        form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
        document.getElementById('formErrorNotice').style.display = 'none';

        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Saving...';

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(async (res) => {
            const data = await res.json().catch(() => null);

            if (res.status === 422 && data && data.errors) { showErrors(data.errors); return; }
            if (res.status === 413) { showErrors({ photo: ['The photo is too large for the server to accept.'] }); return; }
            if (!res.ok) throw new Error();

            Swal.fire({ icon: 'success', title: 'Saved!', text: data.message, confirmButtonColor: '#002F5F', timer: 1800, timerProgressBar: true })
                .then(() => { window.location.href = data.redirect || "{{ route('admin.school-management') }}"; });
        })
        .catch(() => Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.', confirmButtonColor: '#002F5F' }))
        .finally(() => { btn.disabled = false; btn.innerHTML = html; });
    });

    function showErrors(errors) {
        const form = document.getElementById('memberForm');
        document.getElementById('formErrorNotice').style.display = '';

        Object.keys(errors).forEach(field => {
            const target = field === 'photo'
                ? document.getElementById('photoDrop')
                : form.querySelector(`[name="${field}"]:not([type="hidden"])`);
            if (!target) return;

            target.classList.add('input-error');
            const el = document.createElement('span');
            el.className = 'field-error js';
            el.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${errors[field][0]}`;
            (field === 'photo' ? document.getElementById('photoInfo') : target).insertAdjacentElement('afterend', el);
        });

        const first = form.querySelector('.input-error');
        if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
</script>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span[onclick]{ cursor:pointer; transition:color .15s; }
    .crumbs span[onclick]:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:560px; line-height:1.55; }

    .form-grid{ display:grid; grid-template-columns:minmax(0, 1fr) 320px; gap:16px; align-items:start; }
    @media (max-width:980px){ .form-grid{ grid-template-columns:1fr; } }
    .form-main, .form-side{ display:flex; flex-direction:column; gap:16px; min-width:0; }

    .section-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:6px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .icon{ display:inline-flex; color: var(--orange,#BF0001); }

    .field{ margin-bottom:20px; }
    .field:last-child{ margin-bottom:0; }
    .field-row{ display:flex; gap:16px; flex-wrap:wrap; }
    .field-row .field{ flex:1; min-width:200px; margin-bottom:0; }
    .field-top{ margin-bottom:8px; }
    .field-label{ font-size:13px; font-weight:600; color: var(--ink,#171B2C); }
    .field-hint{ display:block; font-size:12px; color: var(--faint,#9AA1B2); margin-top:6px; }
    .section-title .field-hint{ margin-top:0; }
    .field-hint.near b{ color:#B7791F; }
    .req{ color:#BF0001; }
    .field-top-row{ display:flex; align-items:baseline; justify-content:space-between; gap:10px; }
    .add-link{ display:inline-flex; align-items:center; gap:4px; font-size:12.5px; font-weight:600; color: var(--orange,#BF0001); text-decoration:none; }
    .add-link:hover{ text-decoration:underline; }

    input[type=text], input[type=number], select, textarea{
        width:100%; box-sizing:border-box; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; transition:box-shadow .15s, border-color .15s; background:#fff;
    }
    textarea{ resize:vertical; line-height:1.55; }
    input:focus, select:focus, textarea:focus{ border-color: var(--orange,#BF0001); box-shadow: 0 0 0 4px var(--orange-tint-strong,#FFE9D8); }
    .input-error{ border-color:#e74c3c !important; background:#fff8f8 !important; }
    .field-error{ display:flex; align-items:center; gap:5px; color:#e74c3c; font-size:12.5px; margin-top:6px; }

    .notice{ display:flex; align-items:flex-start; gap:8px; border-radius:10px; padding:10px 12px; margin-bottom:16px; }
    .notice p{ font-size:12.5px; margin:0; }
    .notice.caution{ background:#FFF8E8; border:1px solid #F5E3B3; }
    .notice.caution i{ color:#B7791F; }
    .notice.caution p{ color:#8A6116; }

    /* Photo */
    .photo-drop{
        position:relative; width:180px; height:180px; margin:0 auto; border-radius:0px; overflow:hidden; cursor:pointer;
        border:2px dashed var(--input-border,#DBDFEA); background:#FAFBFD;
        display:flex; align-items:center; justify-content:center; text-align:center; transition:border-color .15s, background .15s;
    }
    .photo-drop:hover{ border-color: var(--orange,#BF0001); background: var(--orange-tint,#FFF8F3); }
    .photo-drop.filled{ border:2px solid var(--line,#E9EBF2); }
    .photo-drop img{ width:100%; height:100%; object-fit:cover; display:block; }
    .photo-empty{ display:flex; flex-direction:column; align-items:center; gap:4px; }
    .photo-empty .initials{ font-size:34px; font-weight:700; color:#8A92A6; line-height:1; }
    .photo-empty .bi-camera{ font-size:26px; color:#AEB4C4; }
    .drop-title{ font-size:12.5px; font-weight:600; color: var(--muted,#667085); margin-top:6px; }
    .drop-sub{ font-size:11px; color:#B0B5C4; }
    #photoInfo{ text-align:center; }
    .remove-img-btn{
        position:absolute; top:14px; right:14px; width:28px; height:28px; border-radius:999px; background:rgba(0,0,0,0.6);
        border:none; color:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:12px; z-index:2;
    }
    .remove-img-btn:hover{ background:rgba(0,0,0,0.85); }

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
        margin:24px -32px -32px; padding:0 32px; box-shadow:0 -4px 16px -8px rgba(15,21,38,0.06);
    }
    .savebar-inner{ padding:16px 0; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; }
    .savebar-status{ font-size:12px; color: var(--faint,#9AA1B2); }
    .btn-group{ display:flex; align-items:center; gap:12px; }
    .btn-cancel{ font-size:13px; font-weight:600; color: var(--muted,#667085); padding:10px 16px; border-radius:8px; text-decoration:none; }
    .btn-cancel:hover{ color: var(--ink,#171B2C); background: var(--canvas,#F6F7FB); }
    .btn-save{
        display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none; padding:11px 22px; border-radius:9px; cursor:pointer;
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4); transition:transform .12s ease, box-shadow .12s ease;
    }
    .btn-save:hover{ transform:translateY(-1px); box-shadow:0 8px 18px -6px rgba(15,21,38,0.5); }
    .btn-save:disabled{ opacity:.7; cursor:wait; transform:none; }
</style>

@endsection
