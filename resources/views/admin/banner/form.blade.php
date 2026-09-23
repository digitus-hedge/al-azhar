@extends('admin.layout')
@section('title', 'Banner Section')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: @json(session('success')),
            confirmButtonColor: '#002F5F',
            timer: 2500,
            timerProgressBar: true
        });
    });
</script>
@endif

@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: @json(session('error')),
            confirmButtonColor: '#002F5F'
        });
    });
</script>
@endif

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
        <b>Banner Section</b>
    </div>

    <div class="header">
        <div>
            <h1>Banner Section</h1>
            <p>This is the first thing visitors see on your homepage. Add between 1 and 5 images.</p>
        </div>
    </div>

    @php $existingImages = $banner->images ?? []; @endphp

    <form action="{{ route('admin.home.banner.store') }}" method="POST" enctype="multipart/form-data" id="bannerForm">
        @csrf

        {{-- Title + Description --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-type"></i></span> Banner Details</h2>
            </div>

            <div class="field">
                <div class="field-top">
                    <label class="field-label">Title <span class="req">*</span></label>
                </div>
                <input type="text" name="title" value="{{ old('title', $banner->title) }}"
                       class="{{ $errors->has('title') ? 'input-error' : '' }}"
                       placeholder="Enter banner title">
                @error('title')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <div class="field-top">
                    <label class="field-label">Description<span class="req">*</span></label>
                </div>
                <textarea name="description" rows="4"
                          class="{{ $errors->has('description') ? 'input-error' : '' }}"
                          placeholder="Enter banner description">{{ old('description', $banner->description) }}</textarea>
                @error('description')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Images --}}
        <div class="card" id="imageSection">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-images"></i></span> Images <span class="req">*</span></h2>
                <span class="section-sub" id="imagesCountLabel" style="margin:0;">{{ count($existingImages) }} of 5 images</span>
            </div>

            <div class="notice caution">
                <i class="bi bi-exclamation-triangle" style="margin-top:1px;"></i>
                <p><b>Minimum 1, maximum 5 images.</b> Recommended size: {{ $imageWidth ?? 1200 }} &times; {{ $imageHeight ?? 600 }}px &middot; 16:9 landscape &middot; JPG, PNG, WEBP &middot; up to 10MB each.</p>
            </div>

            @error('images')
                <div class="notice caution" style="margin-bottom:16px;">
                    <i class="bi bi-exclamation-circle" style="margin-top:1px;"></i>
                    <p>{{ $message }}</p>
                </div>
            @enderror

            <div class="images-row" id="imagesRow">
                @foreach ($existingImages as $index => $path)
                    <div class="image-slot" data-slot>
                        <div class="slot-top"><span class="slot-label">Image {{ $index + 1 }}</span></div>
                        <div class="drop img-slot filled">
                            <img src="{{ Storage::url($path) }}" alt="Image {{ $index + 1 }}">
                            <button type="button" class="remove-img-btn" onclick="removeImageSlot(this)" title="Remove image">
                                <i class="bi bi-x-lg"></i>
                            </button>
                            <div class="uploaded-tag"><i class="bi bi-check-circle"></i> Uploaded</div>
                        </div>
                        <input type="hidden" name="keep_images[]" value="{{ $path }}">
                    </div>
                @endforeach

                <div class="image-slot" id="addImageSlot" @if (count($existingImages) >= 5) style="display:none;" @endif>
                    <div class="slot-top">&nbsp;</div>
                    <div class="drop add-slot" id="addImageDrop" onclick="triggerAddImage()">
                        <div class="ico-circle"><i class="bi bi-plus-lg" style="color:#AEB4C4;font-size:18px;"></i></div>
                        <div class="drop-title">Add image</div>
                        <div class="drop-sub">click to upload</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SEO Meta --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-search"></i></span> SEO Meta</h2>
            </div>
            <p class="section-sub" style="margin:0 0 16px;">Used for search engine results and social share previews.</p>

            <div class="field">
                <div class="field-top">
                    <label class="field-label">Meta Title</label>
                    <span class="field-hint">Recommended under 60 chars</span>
                </div>
                <input type="text" name="meta_title" value="{{ old('meta_title', $banner->meta_title) }}" maxlength="60"
                       class="{{ $errors->has('meta_title') ? 'input-error' : '' }}"
                       placeholder="Enter meta title">
                @error('meta_title')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <div class="field-top">
                    <label class="field-label">Meta Description</label>
                    <span class="field-hint">Recommended under 160 chars</span>
                </div>
                <textarea name="meta_description" rows="3" maxlength="160"
                          class="{{ $errors->has('meta_description') ? 'input-error' : '' }}"
                          placeholder="Enter meta description">{{ old('meta_description', $banner->meta_description) }}</textarea>
                @error('meta_description')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="savebar">
            <div class="savebar-inner">
                <span class="savebar-status">All changes save to the live homepage banner</span>
                <div class="btn-group">
                    <a href="{{ route('admin.dashboard') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <i class="bi bi-check-lg"></i>
                        Save Banner
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
document.getElementById('bannerForm').addEventListener('submit', function (e) {
    e.preventDefault();
    submitBannerForm();
});

function submitBannerForm() {
    const form = document.getElementById('bannerForm');
    const formData = new FormData(form);
    const submitBtn = document.querySelector('.btn-save');
    const originalBtnHtml = submitBtn.innerHTML;

    // clear previous errors
    form.querySelectorAll('.field-error').forEach(el => el.remove());
    form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
    form.querySelectorAll('.notice.caution.dynamic-error').forEach(el => el.remove());

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Saving...';

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(async (response) => {
        const data = await response.json().catch(() => null);

        if (response.status === 422 && data && data.errors) {
            showBannerValidationErrors(data.errors);
            return;
        }

        if (!response.ok) {
            throw new Error('Request failed');
        }

        Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: 'Banner updated successfully.',
            confirmButtonColor: '#002F5F',
            timer: 2000,
            timerProgressBar: true
        }).then(() => {
            window.location.reload();
        });
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.',
            confirmButtonColor: '#002F5F'
        });
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnHtml;
    });
}

function showBannerValidationErrors(errors) {
    const form = document.getElementById('bannerForm');

    const fieldMap = {
        title: f => f.querySelector('[name="title"]'),
        description: f => f.querySelector('[name="description"]'),
        meta_title: f => f.querySelector('[name="meta_title"]'),
        meta_description: f => f.querySelector('[name="meta_description"]'),
    };

    Object.keys(errors).forEach(field => {
        const message = errors[field][0];

        // Any "images" (or images.N) error shows as a banner notice on the section, not tied to one slot
        if (field === 'images' || field.startsWith('images.')) {
            const imageSection = document.getElementById('imageSection');
            const notice = document.createElement('div');
            notice.className = 'notice caution dynamic-error';
            notice.style.marginBottom = '16px';
            notice.innerHTML = `<i class="bi bi-exclamation-circle" style="margin-top:1px;"></i><p>${message}</p>`;
            imageSection.querySelector('.section-title').insertAdjacentElement('afterend', notice);
            return;
        }

        const target = fieldMap[field] ? fieldMap[field](form) : null;
        if (!target) return;

        target.classList.add('input-error');

        const errorEl = document.createElement('span');
        errorEl.className = 'field-error';
        errorEl.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${message}`;
        target.insertAdjacentElement('afterend', errorEl);
    });

    const firstErrorField = form.querySelector('.input-error');
    if (firstErrorField) {
        firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}
</script>

<script>
    const MAX_IMAGES = 5;

    function currentImageCount() {
        return document.querySelectorAll('#imagesRow [data-slot]').length;
    }

    function updateImagesUI() {
        const count = currentImageCount();
        const label = document.getElementById('imagesCountLabel');
        if (label) label.textContent = `${count} of ${MAX_IMAGES} images`;

        const addSlot = document.getElementById('addImageSlot');
        if (addSlot) addSlot.style.display = count >= MAX_IMAGES ? 'none' : '';
    }

    function renumberImageSlots() {
        document.querySelectorAll('#imagesRow [data-slot]').forEach((slot, idx) => {
            const label = slot.querySelector('.slot-label');
            if (label) label.textContent = `Image ${idx + 1}`;
        });
    }

    function triggerAddImage() {
        if (currentImageCount() >= MAX_IMAGES) return;

        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'images[]';
        input.accept = 'image/*';
        input.hidden = true;

        input.addEventListener('change', function () {
            if (input.files && input.files[0]) {
                addImageSlotFromFile(input, input.files[0]);
            } else {
                input.remove();
            }
        });

        document.body.appendChild(input);
        input.click();
    }

    function addImageSlotFromFile(input, file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const slot = document.createElement('div');
            slot.className = 'image-slot';
            slot.setAttribute('data-slot', '');

            const num = currentImageCount() + 1;
            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            const oversize = sizeMB > 10;

            slot.innerHTML = `
                <div class="slot-top"><span class="slot-label">Image ${num}</span></div>
                <div class="drop img-slot filled">
                    <img src="${e.target.result}" alt="Image ${num}">
                    <button type="button" class="remove-img-btn" title="Remove image"><i class="bi bi-x-lg"></i></button>
                    <div class="uploaded-tag"><i class="bi bi-check-circle"></i> Selected</div>
                </div>
                <span class="file-size-info ${oversize ? 'size-error' : ''}">
                    <i class="bi bi-${oversize ? 'exclamation-triangle' : 'check-circle'}"></i>
                    ${sizeMB} MB${oversize ? ' — exceeds 10MB limit!' : ''}
                </span>
            `;

            slot.querySelector('.drop').appendChild(input);

            slot.querySelector('.remove-img-btn').addEventListener('click', function (ev) {
                ev.stopPropagation();
                slot.remove();
                renumberImageSlots();
                updateImagesUI();
            });

            const addSlot = document.getElementById('addImageSlot');
            addSlot.insertAdjacentElement('beforebegin', slot);
            updateImagesUI();
        };
        reader.readAsDataURL(file);
    }

    function removeImageSlot(btn) {
        const slot = btn.closest('[data-slot]');
        if (slot) slot.remove();
        renumberImageSlots();
        updateImagesUI();
    }

    document.addEventListener('DOMContentLoaded', updateImagesUI);

    document.addEventListener('DOMContentLoaded', function () {
        // ===== Scroll to the first validation error on page load =====
        const firstErrorField = document.querySelector('.input-error, .upload-btn-error');
        const firstErrorMsg = document.querySelector('.field-error');

        if (firstErrorField) {
            firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstErrorField.classList.add('error-flash');
            setTimeout(() => firstErrorField.classList.remove('error-flash'), 1500);
        } else if (firstErrorMsg) {
            firstErrorMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>

<style>
    .req{ color: #BF0001; }

    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span:first-child{ cursor:pointer; transition:color .15s; }
    .crumbs span:first-child:hover{ color: var(--orange,#EF7B2E); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; line-height:1.55; }

    .section-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:4px; flex-wrap:wrap; gap:6px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .section-title .optional{ font-size:11px; font-weight:400; color: var(--faint,#9AA1B2); }
    .icon{ display:inline-flex; color: var(--orange,#EF7B2E); }
    .section-sub{ font-size:12px; color: var(--faint,#9AA1B2); margin:0 0 16px; }

    .field{ margin-bottom:28px; }
    .field:last-child{ margin-bottom:0; }
    .field-top{ display:flex; align-items:baseline; justify-content:space-between; margin-bottom:8px; }
    .field-label{ display:flex; align-items:center; gap:6px; font-size:13px; font-weight:600; color: var(--ink,#171B2C); }
    .field-hint{ font-size:11.5px; color: var(--faint,#9AA1B2); }

    input[type=text], textarea{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; transition:box-shadow .15s, border-color .15s;
    }
    input[type=text]:focus, textarea:focus{
        border-color: var(--orange,#EF7B2E);
        box-shadow: 0 0 0 4px var(--orange-tint-strong,#FFE9D8);
    }
    textarea{ resize:vertical; line-height:1.5; }
    .input-error{ border-color:#e74c3c !important; background:#fff8f8; }
    .field-error{ display:flex; align-items:center; gap:5px; color:#e74c3c; font-size:12.5px; margin-top:6px; }

    .notice{ margin-top:16px; display:flex; align-items:flex-start; gap:8px; background: var(--canvas,#F6F7FB); border-radius:10px; padding:10px 12px; }
    .notice p{ font-size:12px; color: var(--muted,#667085); margin:0; }
    .notice.caution{ background:#FFF8E8; border:1px solid #F5E3B3; margin-top:0; margin-bottom:16px; }
    .notice.caution i{ color:#B7791F; }
    .notice.caution p{ color:#8A6116; }
    .notice.caution p b{ color:#6B4A0E; font-weight:700; }

    .images-row{ display:flex; gap:16px; flex-wrap:wrap; }
    .image-slot{ flex:1; min-width:160px; }
    .slot-top{ display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; }
    .slot-label{ font-size:12px; font-weight:500; color: var(--muted,#667085); }

    .drop{
        position:relative; aspect-ratio:4/3; border-radius:12px;
        border:2px dashed var(--input-border,#DBDFEA); background:#FAFBFD;
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        cursor:pointer; overflow:hidden; transition:border-color .15s, background .15s; text-align:center;
    }
    .drop:hover{ border-color: var(--orange,#EF7B2E); background: var(--orange-tint,#FFF8F3); }
    .drop.filled{ border:2px solid transparent; background:#0F1220; cursor:default; }
    .drop img{ width:100%; height:100%; object-fit:cover; display:block; }
    .ico-circle{ width:40px; height:40px; border-radius:999px; background:#EEF0F6; display:flex; align-items:center; justify-content:center; margin-bottom:8px; }
    .drop-title{ font-size:12px; font-weight:500; color: var(--muted,#667085); }
    .drop-sub{ font-size:11px; color:#B0B5C4; margin-top:2px; }
    .uploaded-tag{
        position:absolute; left:0; right:0; bottom:0; padding:8px 12px;
        background:linear-gradient(to top, rgba(0,0,0,0.55), transparent);
        color:rgba(255,255,255,0.9); font-size:11px; display:flex; align-items:center; gap:4px;
    }
    .choose-btn{
        margin-top:8px; width:100%; font-size:12px; font-weight:600; color: var(--orange,#EF7B2E);
        background:#fff; border:1px solid var(--orange-border,#F3D8C2); border-radius:8px;
        padding:7px 0; cursor:pointer; transition:background .15s;
    }
    .choose-btn:hover{ background: var(--orange-tint,#FFF8F3); }

    .remove-img-btn{
        position:absolute; top:8px; right:8px; width:28px; height:28px; border-radius:999px;
        background:rgba(0,0,0,0.6); border:none; color:#fff; display:flex; align-items:center;
        justify-content:center; cursor:pointer; transition:background .15s; z-index:3; font-size:13px;
    }
    .remove-img-btn:hover{ background:rgba(0,0,0,0.85); }

    .file-size-info{ display:block; font-size:12px; color:#1e8449; margin-top:6px; }
    .file-size-info.size-error{ color:#e74c3c; font-weight:600; }

    .savebar{
        position:sticky; bottom:0; border-top:1px solid var(--line,#E9EBF2);
        background:rgba(255,255,255,0.92); backdrop-filter:blur(6px);
        margin:24px -32px -32px; padding:0 32px;
        box-shadow:0 -4px 16px -8px rgba(15,21,38,0.06);
    }
    .savebar-inner{ padding:16px 0; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; }
    .savebar-status{ font-size:12px; color: var(--faint,#9AA1B2); }
    .btn-group{ display:flex; align-items:center; gap:12px; }
    .btn-cancel{
        font-size:13px; font-weight:600; color: var(--muted,#667085); background:none; border:none;
        padding:10px 16px; border-radius:8px; cursor:pointer; text-decoration:none; transition:color .15s, background .15s;
    }
    .btn-cancel:hover{ color: var(--ink,#171B2C); background: var(--canvas,#F6F7FB); }
    .btn-save{
        display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none;
        padding:11px 22px; border-radius:9px; cursor:pointer;
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4);
        transition:transform .12s ease, box-shadow .12s ease;
    }
    .btn-save:hover{ transform:translateY(-1px); box-shadow:0 8px 18px -6px rgba(15,21,38,0.5); }
</style>

@endsection
