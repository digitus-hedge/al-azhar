@extends('admin.layout')
@section('title', 'About School')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: @json(session('success')),
            confirmButtonColor: '#BF0001',
            timer: 2500,
            timerProgressBar: true
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
        <b>About School</b>
    </div>

    <div class="header">
        <div>
            <h1>About School</h1>
            <p>Vision, mission, history and values shown on the homepage About section.</p>
        </div>
    </div>

    <form action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data" id="aboutForm">
        @csrf

        {{-- Title + Description --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-type"></i></span> Heading &amp; Intro</h2>
            </div>

            <div class="field">
                <div class="field-top"><label class="field-label">Title</label></div>
                <input type="text" name="title" value="{{ old('title', $about->title) }}"
                       class="{{ $errors->has('title') ? 'input-error' : '' }}"
                       placeholder="e.g. About Al-Azhar School">
                @error('title')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <div class="field-top"><label class="field-label">Short Description</label></div>
                <textarea name="description" id="description-input" rows="4"
                          class="{{ $errors->has('description') ? 'input-error' : '' }}"
                          placeholder="A short intro paragraph shown under the title...">{{ old('description', $about->description) }}</textarea>
                @error('description')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Vision & Mission --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-eye"></i></span> Vision &amp; Mission</h2>
            </div>

            <div class="field">
                <div class="field-top"><label class="field-label">Vision</label></div>
                <textarea name="vision" id="vision-input" rows="4"
                          class="{{ $errors->has('vision') ? 'input-error' : '' }}"
                          placeholder="What the school aspires to be...">{{ old('vision', $about->vision) }}</textarea>
                @error('vision')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <div class="field-top"><label class="field-label">Mission</label></div>
                <textarea name="mission" id="mission-input" rows="4"
                          class="{{ $errors->has('mission') ? 'input-error' : '' }}"
                          placeholder="How the school works to achieve its vision...">{{ old('mission', $about->mission) }}</textarea>
                @error('mission')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- History & Values --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-clock-history"></i></span> History &amp; Values</h2>
            </div>

            <div class="field">
                <div class="field-top"><label class="field-label">History</label></div>
                <textarea name="history" id="history-input" rows="6"
                          class="{{ $errors->has('history') ? 'input-error' : '' }}"
                          placeholder="The story of how the school was founded and has grown...">{{ old('history', $about->history) }}</textarea>
                @error('history')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <div class="field-top"><label class="field-label">Values</label></div>
                <textarea name="values" id="values-input" rows="4"
                          class="{{ $errors->has('values') ? 'input-error' : '' }}"
                          placeholder="The core values the school stands for...">{{ old('values', $about->values) }}</textarea>
                @error('values')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Image --}}
        <div class="card" id="imageSection">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-image"></i></span> About Image</h2>
            </div>

            <div class="notice caution">
                <i class="bi bi-exclamation-triangle" style="margin-top:1px;"></i>
                <p>Optional &middot; recommended 900&times;700px &middot; JPG, PNG, WEBP &middot; up to 5MB.</p>
            </div>

            @error('image')
                <div class="notice caution" style="margin-bottom:16px;">
                    <i class="bi bi-exclamation-circle" style="margin-top:1px;"></i>
                    <p>{{ $message }}</p>
                </div>
            @enderror

            <div class="images-row">
                <div class="image-slot" style="max-width:260px;">
                    <div class="drop img-slot {{ $about->image ? 'filled' : '' }}" id="imageDrop" onclick="triggerImageInput()">
                        <img id="imagePreview" src="{{ $about->image ? Storage::url($about->image) : '' }}"
                             alt="Preview" style="{{ $about->image ? '' : 'display:none;' }}">

                        <div class="drop-empty" id="dropEmpty" style="{{ $about->image ? 'display:none;' : '' }}">
                            <div class="ico-circle"><i class="bi bi-cloud-arrow-up" style="color:#AEB4C4;font-size:18px;"></i></div>
                            <div class="drop-title">Add image</div>
                            <div class="drop-sub">click to upload</div>
                        </div>

                        <button type="button" class="remove-img-btn" id="removeImageBtn"
                                onclick="removeAboutImage(event)" style="{{ $about->image ? '' : 'display:none;' }}" title="Remove image">
                            <i class="bi bi-x-lg"></i>
                        </button>

                        <div class="uploaded-tag" id="uploadedTag" style="{{ $about->image ? '' : 'display:none;' }}">
                            <i class="bi bi-check-circle"></i> Uploaded
                        </div>
                    </div>
                    <input type="file" name="image" id="imageInput" accept="image/*" hidden>
                    <input type="hidden" name="remove_image" id="removeImageInput" value="0">
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
                <input type="text" name="meta_title" value="{{ old('meta_title', $about->meta_title) }}" maxlength="60"
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
                          placeholder="Enter meta description">{{ old('meta_description', $about->meta_description) }}</textarea>
                @error('meta_description')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="savebar">
            <div class="savebar-inner">
                <span class="savebar-status">All changes save to the live About section</span>
                <div class="btn-group">
                    <a href="{{ route('admin.dashboard') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <i class="bi bi-check-lg"></i>
                        Save About Section
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('aboutForm').addEventListener('submit', function (e) {
    e.preventDefault();
    submitAboutForm();
});

function submitAboutForm() {
    const form = document.getElementById('aboutForm');
    const formData = new FormData(form);
    const submitBtn = form.querySelector('.btn-save');
    const originalBtnHtml = submitBtn.innerHTML;

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
            showValidationErrors(data.errors);
            return;
        }

        if (!response.ok) {
            throw new Error('Request failed');
        }

        Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: data && data.message ? data.message : 'About section updated successfully.',
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

function showValidationErrors(errors) {
    const form = document.getElementById('aboutForm');
    const fieldMap = {
        title: f => f.querySelector('[name="title"]'),
        description: f => f.querySelector('[name="description"]'),
        vision: f => f.querySelector('[name="vision"]'),
        mission: f => f.querySelector('[name="mission"]'),
        history: f => f.querySelector('[name="history"]'),
        values: f => f.querySelector('[name="values"]'),
        meta_title: f => f.querySelector('[name="meta_title"]'),
        meta_description: f => f.querySelector('[name="meta_description"]'),
    };

    Object.keys(errors).forEach(field => {
        const message = errors[field][0];

        if (field === 'image') {
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
    function triggerImageInput() {
        document.getElementById('imageInput').click();
    }

    document.getElementById('imageInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('imagePreview');
            preview.src = e.target.result;
            preview.style.display = '';

            document.getElementById('dropEmpty').style.display = 'none';
            document.getElementById('removeImageBtn').style.display = '';
            document.getElementById('uploadedTag').innerHTML = '<i class="bi bi-check-circle"></i> Selected';
            document.getElementById('uploadedTag').style.display = '';
            document.getElementById('imageDrop').classList.add('filled');
            document.getElementById('removeImageInput').value = '0';
        };
        reader.readAsDataURL(file);
    });

    function removeAboutImage(e) {
        e.stopPropagation();

        const input = document.getElementById('imageInput');
        input.value = '';

        const preview = document.getElementById('imagePreview');
        preview.src = '';
        preview.style.display = 'none';

        document.getElementById('dropEmpty').style.display = '';
        document.getElementById('removeImageBtn').style.display = 'none';
        document.getElementById('uploadedTag').style.display = 'none';
        document.getElementById('imageDrop').classList.remove('filled');
        document.getElementById('removeImageInput').value = '1';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const firstErrorField = document.querySelector('.input-error');
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

<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#description-input, #vision-input, #mission-input, #history-input, #values-input',
        height: 280,
        menubar: false,
        plugins: 'advlist autolink lists link charmap preview anchor searchreplace visualblocks code fullscreen wordcount',
        toolbar: 'undo redo | blocks | bold italic forecolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | link | code preview fullscreen | removeformat help',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size:14px }',
        branding: false,
        promotion: false,
        setup: function (editor) {
            editor.on('change keyup blur', function () {
                editor.save();
            });
        }
    });

    // TinyMCE replaces the textareas with iframes, so make sure their
    // content is synced into the underlying <textarea> before the form
    // is serialized by the AJAX submit handler above.
    document.getElementById('aboutForm').addEventListener('submit', function () {
        if (window.tinymce) {
            tinymce.triggerSave();
        }
    }, true);
</script>

<style>
    .req{ color: var(--orange, #BF0001); }

    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span:first-child{ cursor:pointer; transition:color .15s; }
    .crumbs span:first-child:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:560px; line-height:1.55; }

    .section-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:6px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .icon{ display:inline-flex; color: var(--orange,#BF0001); }
    .section-sub{ font-size:12px; color: var(--faint,#9AA1B2); margin:0 0 16px; }

    .field{ margin-bottom:28px; }
    .field:last-child{ margin-bottom:0; }
    .field-top{ display:flex; align-items:baseline; justify-content:space-between; margin-bottom:8px; }
    .field-label{ font-size:13px; font-weight:600; color: var(--ink,#171B2C); }
    .field-hint{ font-size:11.5px; color: var(--faint,#9AA1B2); }

    input[type=text], textarea{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; transition:box-shadow .15s, border-color .15s; background:#fff;
    }
    input[type=text]:focus, textarea:focus{
        border-color: var(--orange,#BF0001);
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

    .images-row{ display:flex; gap:16px; flex-wrap:wrap; }
    .image-slot{ flex:1; min-width:160px; }

    .drop{
        position:relative; aspect-ratio:4/3; border-radius:12px;
        border:2px dashed var(--input-border,#DBDFEA); background:#FAFBFD;
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        cursor:pointer; overflow:hidden; transition:border-color .15s, background .15s; text-align:center;
    }
    .drop:hover{ border-color: var(--orange,#BF0001); background: var(--orange-tint,#FFF8F3); }
    .drop.filled{ border:2px solid transparent; background:#0F1220; }
    .drop img{ width:100%; height:100%; object-fit:cover; display:block; }
    .ico-circle{ width:40px; height:40px; border-radius:999px; background:#EEF0F6; display:flex; align-items:center; justify-content:center; margin-bottom:8px; }
    .drop-title{ font-size:12px; font-weight:500; color: var(--muted,#667085); }
    .drop-sub{ font-size:11px; color:#B0B5C4; margin-top:2px; }
    .uploaded-tag{
        position:absolute; left:0; right:0; bottom:0; padding:8px 12px;
        background:linear-gradient(to top, rgba(0,0,0,0.55), transparent);
        color:rgba(255,255,255,0.9); font-size:11px; display:flex; align-items:center; gap:4px;
    }
    .remove-img-btn{
        position:absolute; top:8px; right:8px; width:28px; height:28px; border-radius:999px;
        background:rgba(0,0,0,0.6); border:none; color:#fff; display:flex; align-items:center;
        justify-content:center; cursor:pointer; transition:background .15s; z-index:3; font-size:13px;
    }
    .remove-img-btn:hover{ background:rgba(0,0,0,0.85); }

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
