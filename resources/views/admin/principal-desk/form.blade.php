@extends('admin.layout')
@section('title', 'Principle Message')
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
        <b>Principle Message</b>
    </div>

    <div class="header">
        <div>
            <h1>Principle Message</h1>
            <p>Photo, heading and message shown in the "Principal's Desk" preview card on the homepage.</p>
        </div>
    </div>

    <form action="{{ $item->exists ? route('admin.principal-desk.update', $item) : route('admin.principal-desk.store') }}"
          method="POST" enctype="multipart/form-data" id="aboutForm">
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        {{-- Heading & Name --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-type"></i></span> Heading &amp; Name</h2>
            </div>

            <div class="field">
                <div class="field-top"><label class="field-label">Heading</label></div>
                <input type="text" name="heading" value="{{ old('heading', $item->heading) }}"
                       class="{{ $errors->has('heading') ? 'input-error' : '' }}"
                       placeholder="e.g. Principal's Desk">
                @error('heading')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <div class="field-top"><label class="field-label">Principal's Name</label></div>
                <input type="text" name="name" value="{{ old('name', $item->name) }}"
                       class="{{ $errors->has('name') ? 'input-error' : '' }}"
                       placeholder="e.g. Dr. Jane Doe">
                @error('name')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Message --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-chat-quote"></i></span> Message</h2>
            </div>

            <div class="field">
                <div class="field-top">
                    <label class="field-label">Short Excerpt</label>
                    <span class="field-hint">Shown on the preview card</span>
                </div>
                <textarea name="excerpt" id="excerpt-input" rows="4" maxlength="500"
                          class="{{ $errors->has('excerpt') ? 'input-error' : '' }}"
                          placeholder="A brief welcome message shown on the homepage card...">{{ old('excerpt', $item->excerpt) }}</textarea>
                @error('excerpt')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- <div class="field">
                <div class="field-top">
                    <label class="field-label">Full Message</label>
                    <span class="field-hint">Shown on "Read More"</span>
                </div>
                <textarea name="message" id="message-input" rows="8"
                          class="{{ $errors->has('message') ? 'input-error' : '' }}"
                          placeholder="The complete Principal's message...">{{ old('message', $item->message) }}</textarea>
                @error('message')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div> -->
        </div>

        {{-- Photo --}}
        <div class="card" id="imageSection">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-image"></i></span> Photo</h2>
            </div>

            <div class="notice caution">
                <i class="bi bi-exclamation-triangle" style="margin-top:1px;"></i>
                <p>Optional &middot; square photo recommended &middot; JPG, PNG, WEBP &middot; up to 2MB. If left empty, the fallback initial below is shown instead.</p>
            </div>

            @error('photo')
                <div class="notice caution" style="margin-bottom:16px;">
                    <i class="bi bi-exclamation-circle" style="margin-top:1px;"></i>
                    <p>{{ $message }}</p>
                </div>
            @enderror

            <div class="images-row">
                <div class="image-slot" style="max-width:180px;">
                    <div class="drop img-slot round {{ $item->photo ? 'filled' : '' }}" id="imageDrop" onclick="triggerImageInput()">
                        <img id="imagePreview" src="{{ $item->photo ? $item->photo_url : '' }}"
                             alt="Preview" style="{{ $item->photo ? '' : 'display:none;' }}">

                        <div class="drop-empty" id="dropEmpty" style="{{ $item->photo ? 'display:none;' : '' }}">
                            <div class="ico-circle"><i class="bi bi-cloud-arrow-up" style="color:#AEB4C4;font-size:18px;"></i></div>
                            <div class="drop-title">Add photo</div>
                            <div class="drop-sub">click to upload</div>
                        </div>

                        <button type="button" class="remove-img-btn" id="removeImageBtn"
                                onclick="removeAboutImage(event)" style="{{ $item->photo ? '' : 'display:none;' }}" title="Remove photo">
                            <i class="bi bi-x-lg"></i>
                        </button>

                        <div class="uploaded-tag" id="uploadedTag" style="{{ $item->photo ? '' : 'display:none;' }}">
                            <i class="bi bi-check-circle"></i> Uploaded
                        </div>
                    </div>
                    <input type="file" name="photo" id="imageInput" accept="image/*" hidden>
                    <input type="hidden" name="remove_photo" id="removeImageInput" value="0">
                </div>
<!-- 
                <div class="field" style="flex:1;min-width:160px;margin-bottom:0;">
                    <div class="field-top">
                        <label class="field-label">Fallback Initial</label>
                        <span class="field-hint">Shown in the circle if no photo</span>
                    </div>
                    <input type="text" name="avatar_initial" maxlength="2" style="max-width:120px;"
                           value="{{ old('avatar_initial', $item->avatar_initial) }}"
                           class="{{ $errors->has('avatar_initial') ? 'input-error' : '' }}"
                           placeholder="P">
                    @error('avatar_initial')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div> -->
            </div>
        </div>

        {{-- Display Settings --}}
        <!-- <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-sliders"></i></span> Display Settings</h2>
            </div>

            <div class="field">
                <div class="field-top"><label class="field-label">Sort Order</label></div>
                <input type="number" name="sort_order" min="0" style="max-width:160px;"
                       value="{{ old('sort_order', $item->sort_order ?? 0) }}"
                       class="{{ $errors->has('sort_order') ? 'input-error' : '' }}">
                @error('sort_order')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <label class="toggle-row" for="is_active">
                <span>
                    <span class="field-label">Active</span>
                    <span class="field-hint d-block">Visible in the preview card on the website</span>
                </span>
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
            </label>
        </div> -->

        <div class="savebar">
            <div class="savebar-inner">
                <span class="savebar-status">All changes save to the live Principal's Desk card</span>
                <div class="btn-group">
                    <a href="{{ route('admin.dashboard') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <i class="bi bi-check-lg"></i>
                        Save Principle Message
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
            text: data && data.message ? data.message : "Principal's Desk entry saved successfully.",
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
        heading: f => f.querySelector('[name="heading"]'),
        name: f => f.querySelector('[name="name"]'),
        avatar_initial: f => f.querySelector('[name="avatar_initial"]'),
        sort_order: f => f.querySelector('[name="sort_order"]'),
        excerpt: f => f.querySelector('[name="excerpt"]'),
        message: f => f.querySelector('[name="message"]'),
    };

    Object.keys(errors).forEach(field => {
        const message = errors[field][0];

        if (field === 'photo') {
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
        selector: '#excerpt-input, #message-input',
        height: 260,
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
  .req{ color: #BF0001; }

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
    .field-hint.d-block{ display:block; margin-top:2px; }

    input[type=text], input[type=number], textarea{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; transition:box-shadow .15s, border-color .15s; background:#fff;
    }
    input[type=text]:focus, input[type=number]:focus, textarea:focus{
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

    .images-row{ display:flex; gap:20px; flex-wrap:wrap; align-items:flex-start; }
    .image-slot{ flex:0 0 auto; }

    .drop{
        position:relative; width:140px; height:140px; border-radius:12px;
        border:2px dashed var(--input-border,#DBDFEA); background:#FAFBFD;
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        cursor:pointer; overflow:hidden; transition:border-color .15s, background .15s; text-align:center;
    }
    /* .drop.round{ border-radius:50%; } */
    .drop:hover{ border-color: var(--orange,#BF0001); background: var(--orange-tint,#FFF8F3); }
    .drop.filled{ border:2px solid transparent; background:#0F1220; }
    .drop img{ width:100%; height:100%; object-fit:cover; display:block; }
    .ico-circle{ width:40px; height:40px; border-radius:999px; background:#EEF0F6; display:flex; align-items:center; justify-content:center; margin-bottom:8px; }
    .drop-title{ font-size:12px; font-weight:500; color: var(--muted,#667085); }
    .drop-sub{ font-size:11px; color:#B0B5C4; margin-top:2px; }
    .uploaded-tag{
        position:absolute; left:0; right:0; bottom:0; padding:8px 12px;
        background:linear-gradient(to top, rgba(0,0,0,0.55), transparent);
        color:rgba(255,255,255,0.9); font-size:11px; display:flex; align-items:center; justify-content:center; gap:4px;
    }
    .remove-img-btn{
        position:absolute; top:8px; right:8px; width:28px; height:28px; border-radius:999px;
        background:rgba(0,0,0,0.6); border:none; color:#fff; display:flex; align-items:center;
        justify-content:center; cursor:pointer; transition:background .15s; z-index:3; font-size:13px;
    }
    .remove-img-btn:hover{ background:rgba(0,0,0,0.85); }

    .toggle-row{
        display:flex; align-items:center; justify-content:space-between; gap:16px;
        cursor:pointer; padding:4px 0;
    }
    .toggle-row input[type=checkbox]{ width:40px; height:22px; accent-color: var(--orange,#BF0001); cursor:pointer; }

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
