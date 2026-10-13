@extends('admin.layout')
@section('title', $item->exists ? 'Edit Blog' : 'Add Blog')
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
        <span onclick="window.location='{{ route('admin.blogs') }}'">Blogs</span>
        <span>&rsaquo;</span>
        <b>{{ $item->exists ? 'Edit' : 'Add' }}</b>
    </div>

    <div class="header">
        <div>
            <h1>{{ $item->exists ? 'Edit Blog' : 'Add Blog' }}</h1>
            <p>Enter title, publish date, cover image and description.</p>
        </div>
    </div>

    <form action="{{ $item->exists ? route('admin.blogs.update', $item) : route('admin.blogs.store') }}"
          method="POST" enctype="multipart/form-data" id="blogForm">
        @csrf
        @if ($item->exists) @method('PUT') @endif

        {{-- Title --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-type"></i></span> Title <span class="req">*</span></h2>
            </div>

            <div class="field">
                <input type="text" name="title" value="{{ old('title', $item->title) }}"
                       class="{{ $errors->has('title') ? 'input-error' : '' }}"
                       placeholder="Enter blog title">
                @error('title')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Date & Time --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-calendar-event"></i></span> Date &amp; Time</h2>
            </div>

            <div class="field" style="max-width:320px;">
                @php
                    $publishedValue = old('published_at',
                        optional($item->published_at)->format('Y-m-d\TH:i')
                    );
                @endphp
                <input type="datetime-local" name="published_at" value="{{ $publishedValue }}"
                       class="{{ $errors->has('published_at') ? 'input-error' : '' }}">
                @error('published_at')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
                <span class="field-hint" style="display:block;margin-top:6px;">
                    <i class="bi bi-info-circle"></i> When this blog should appear on the website.
                </span>
            </div>
        </div>

        {{-- Image --}}
        <div class="card" id="imageSection">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-image"></i></span>
                    Cover Image
                </h2>
            </div>

            <div class="notice caution">
                <i class="bi bi-exclamation-triangle" style="margin-top:1px;"></i>
                <p><b>Recommended:</b> 1200 &times; 630px &middot; JPG, PNG, WEBP &middot; up to 5MB.</p>
            </div>

            @error('image')
                <div class="notice caution" style="margin-bottom:16px;">
                    <i class="bi bi-exclamation-circle" style="margin-top:1px;"></i>
                    <p>{{ $message }}</p>
                </div>
            @enderror

            <div class="image-slot" style="max-width:320px;">
                <div class="drop img-slot {{ $item->image ? 'filled' : '' }}" id="imageDrop" onclick="triggerImageInput()">
                    <img id="imagePreview"
                         src="{{ $item->image ? Storage::url($item->image) : '' }}"
                         alt="Preview"
                         style="{{ $item->image ? '' : 'display:none;' }}">

                    <div class="drop-empty" id="dropEmpty" style="{{ $item->image ? 'display:none;' : '' }}">
                        <div class="ico-circle"><i class="bi bi-cloud-arrow-up" style="color:#AEB4C4;font-size:18px;"></i></div>
                        <div class="drop-title">Add image</div>
                        <div class="drop-sub">click to upload</div>
                    </div>

                    <button type="button" class="remove-img-btn" id="removeImageBtn"
                            onclick="removeBlogImage(event)"
                            style="{{ $item->image ? '' : 'display:none;' }}" title="Remove image">
                        <i class="bi bi-x-lg"></i>
                    </button>

                    <div class="uploaded-tag" id="uploadedTag" style="{{ $item->image ? '' : 'display:none;' }}">
                        <i class="bi bi-check-circle"></i> Uploaded
                    </div>
                </div>
                <input type="file" name="image" id="imageInput" accept="image/*" hidden>
                <input type="hidden" name="remove_image" id="removeImageInput" value="0">
            </div>
        </div>

        {{-- Description with TinyMCE --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-text-paragraph"></i></span> Description <span class="req">*</span></h2>
            </div>

            <div class="field">
                <textarea name="description" id="description-input" rows="12"
                          class="{{ $errors->has('description') ? 'input-error' : '' }}"
                          placeholder="Write the blog content...">{{ old('description', $item->description) }}</textarea>
                @error('description')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Sort Order --}}


        <!-- <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-sort-numeric-down"></i></span> Sort Order</h2>
            </div>
            <div class="field" style="max-width:220px;">
                <input type="number" name="sort_order" min="0"
                       value="{{ old('sort_order', $item->sort_order ?? 0) }}"
                       class="{{ $errors->has('sort_order') ? 'input-error' : '' }}">
                @error('sort_order')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
                <span class="field-hint" style="display:block;margin-top:6px;">
                    <i class="bi bi-info-circle"></i>
                    Lower number appears first on the website.
                </span>
            </div>
        </div> -->

        <div class="savebar">
            <div class="savebar-inner">
                <span class="savebar-status">All changes save to the live Blog section</span>
                <div class="btn-group">
                    <a href="{{ route('admin.blogs') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <i class="bi bi-check-lg"></i>
                        {{ $item->exists ? 'Update Blog' : 'Create Blog' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- TinyMCE --}}
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#description-input',
        height: 420,
        menubar: false,
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen wordcount',
        toolbar: 'undo redo | blocks | bold italic forecolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | link image | code preview fullscreen | removeformat help',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size:14px }',
        branding: false,
        promotion: false,
        setup: function (editor) {
            editor.on('change keyup blur', function () { editor.save(); });
            editor.on('init', function () {
                const textarea = editor.getElement();
                const next = textarea.nextElementSibling;
                if (textarea.classList.contains('input-error')) {
                    editor.getContainer().classList.add('input-error');
                }
                if (next && next.classList.contains('field-error')) {
                    editor.getContainer().insertAdjacentElement('afterend', next);
                }
            });
        }
    });

    document.getElementById('blogForm').addEventListener('submit', function () {
        if (window.tinymce) { tinymce.triggerSave(); }
    }, true);

    /* ---------------- Image upload / preview ---------------- */

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

    function removeBlogImage(e) {
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
        if (firstErrorField) {
            firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>

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

    .field{ margin-bottom:0; }
    input[type=text], input[type=number], input[type=datetime-local], textarea, select{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; transition:box-shadow .15s, border-color .15s; background:#fff;
    }
    input:focus, textarea:focus, select:focus{
        border-color: var(--orange,#BF0001);
        box-shadow: 0 0 0 4px var(--orange-tint-strong,#FFE9D8);
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button{ -webkit-appearance: none; margin: 0; }
    input[type=number]{ -moz-appearance: textfield; appearance: textfield; }

    .input-error{ border-color:#e74c3c !important; background:#fff8f8; }
    .tox.tox-tinymce.input-error{ border:1px solid #e74c3c !important; }
    .drop.input-error{ border:2px dashed #e74c3c !important; }
    .field-error{ display:flex; align-items:center; gap:5px; color:#e74c3c; font-size:12.5px; margin-top:6px; }

    .notice{ margin-top:16px; display:flex; align-items:flex-start; gap:8px; background: var(--canvas,#F6F7FB); border-radius:10px; padding:10px 12px; }
    .notice p{ font-size:12px; color: var(--muted,#667085); margin:0; }
    .notice.caution{ background:#FFF8E8; border:1px solid #F5E3B3; margin-top:0; margin-bottom:16px; }
    .notice.caution i{ color:#B7791F; }
    .notice.caution p{ color:#8A6116; }
    .notice.caution p b{ color:#6B4A0E; font-weight:700; }

    .drop{
        position:relative; aspect-ratio:16/9; border-radius:12px;
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

    .field-hint{ display:block; font-size:12px; color: var(--faint,#9AA1B2); line-height:1.45; }
    .field-hint i{ margin-right:3px; }

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
