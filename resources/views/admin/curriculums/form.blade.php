@extends('admin.layout')
@section('title', $item->exists ? 'Edit Curriculum' : 'Add Curriculum')
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
        <span onclick="window.location='{{ route('admin.curriculums') }}'">Co-Curriculum</span>
        <span>&rsaquo;</span>
        <b>{{ $item->exists ? 'Edit' : 'Add' }}</b>
    </div>

    <div class="header">
        <div>
            <h1>{{ $item->exists ? 'Edit Co-Curriculum' : 'Add Co-Curriculum' }}</h1>
            <p>Enter the Co-Curriculum title, short description and up to 10 cover images.</p>
        </div>
    </div>

    <form action="{{ $item->exists ? route('admin.curriculums.update', $item) : route('admin.curriculums.store') }}"
          method="POST" enctype="multipart/form-data" id="curriculumForm">
        @csrf
        @if ($item->exists) @method('PUT') @endif

        {{-- =============== TITLE =============== --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-type"></i></span> Title <span class="req">*</span></h2>
            </div>

            <div class="field">
                <input type="text" name="title" id="titleInput"
                       value="{{ old('title', $item->title) }}"
                       class="{{ $errors->has('title') ? 'input-error' : '' }}"
                       placeholder="e.g. Learning Beyond the Classroom: Developing Skills for Life"
                       maxlength="150">
                <div class="field-counter">
                    <span><span id="titleCount">0</span> / 150 characters</span>
                    <small class="field-hint">Keep it clear and descriptive</small>
                </div>
                @error('title')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- =============== DESCRIPTION =============== --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-text-paragraph"></i></span> Short Description <span class="req">*</span></h2>
            </div>

            <div class="field">
                <textarea name="description" id="descriptionInput" rows="4"
                          class="{{ $errors->has('description') ? 'input-error' : '' }}"
                          placeholder="A short summary shown on the curriculum list and link previews..."
                          maxlength="550">{{ old('description', $item->description) }}</textarea>
                <div class="field-counter">
                    <span><span id="descCount">0</span> / 550 characters</span>
                    <small class="field-hint">A concise summary of the curriculum</small>
                </div>
                @error('description')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- =============== MULTIPLE IMAGES =============== --}}
        <div class="card" id="imageSection">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-images"></i></span> Cover Images</h2>
                <span class="help-badge">Up to 10 images</span>
            </div>

            <div class="notice caution">
                <i class="bi bi-exclamation-triangle" style="margin-top:1px;"></i>
                <p><b>Recommended:</b> 1200 &times; 630px &middot; JPG, PNG, WEBP &middot; up to 5MB each. You can click <b>Add images</b> multiple times to add more.</p>
            </div>

            @error('images')
                <div class="notice caution" style="margin-bottom:16px;">
                    <i class="bi bi-exclamation-circle" style="margin-top:1px;"></i>
                    <p>{{ $message }}</p>
                </div>
            @enderror
            @error('images.*')
                <div class="notice caution" style="margin-bottom:16px;">
                    <i class="bi bi-exclamation-circle" style="margin-top:1px;"></i>
                    <p>{{ $message }}</p>
                </div>
            @enderror

            {{-- Grid of existing + new images --}}
            <div class="image-grid" id="imageGrid">
                {{-- Existing images (from DB) --}}
                @if (!empty($item->images) && is_array($item->images))
                    @foreach ($item->images as $index => $existingImage)
                        <div class="image-tile existing" data-existing="{{ $existingImage }}">
                            <img src="{{ Storage::url($existingImage) }}" alt="Image {{ $index + 1 }}">
                            <button type="button" class="remove-img-btn" onclick="removeExistingImage(this, '{{ $existingImage }}')" title="Remove image">
                                <i class="bi bi-x-lg"></i>
                            </button>
                            <div class="uploaded-tag"><i class="bi bi-check-circle"></i> Uploaded</div>
                        </div>
                    @endforeach
                @endif

                {{-- "Add image" tile — triggers the picker. Reset the picker on each click
                     so re-selecting the same file still fires a change event. --}}
                <div class="image-tile drop" id="addImageTile" onclick="openImagePicker()">
                    <div class="drop-empty">
                        <div class="ico-circle"><i class="bi bi-cloud-arrow-up" style="color:#AEB4C4;font-size:18px;"></i></div>
                        <div class="drop-title">Add images</div>
                        <div class="drop-sub">click to upload</div>
                    </div>
                </div>
            </div>

            {{-- File input (hidden via CSS, kept inside the form) --}}
            <input type="file" name="images[]" id="imageInput" accept="image/*" multiple
                   style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0;">

            {{-- Hidden list of existing images the user chose to remove --}}
            <input type="hidden" name="removed_images" id="removedImagesInput" value="[]">
        </div>

        {{-- =============== SAVE BAR =============== --}}
        <div class="savebar">
            <div class="savebar-inner">
                <span class="savebar-status">All changes save to the live Curriculum section</span>
                <div class="btn-group">
                    <a href="{{ route('admin.curriculums') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <i class="bi bi-check-lg"></i>
                        {{ $item->exists ? 'Update Curriculum' : 'Create Curriculum' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
/* ================================================================
   CHARACTER COUNTERS for title (150) and description (550)
   ================================================================ */
(function () {
    const fields = [
        { input: 'titleInput',       counter: 'titleCount', max: 150 },
        { input: 'descriptionInput', counter: 'descCount',  max: 550 },
    ];

    fields.forEach(function (f) {
        const input   = document.getElementById(f.input);
        const counter = document.getElementById(f.counter);
        if (!input || !counter) return;

        const update = function () {
            const len = input.value.length;
            counter.textContent = len;
            counter.parentElement.classList.toggle('near-limit', len > f.max * 0.9);
        };
        input.addEventListener('input', update);
        update();
    });
})();

/* ================================================================
   MULTIPLE IMAGE UPLOAD WITH ACCUMULATION
   ---------------------------------------------------------------
   How it works (and why it works):
   1. We keep a DataTransfer `bag` as the single source of truth for
      all newly picked files.
   2. On each `change`, we APPEND the newly picked files into the bag,
      then assign bag.files back to input.files. This is the one and
      only place we touch input.files — never on cancel, never later.
   3. We NEVER set input.value = '' (that was the Chrome-breaking bug).
      Instead, to let the user re-pick the same file, we call
      input.value = null just BEFORE opening the picker, not after.
      Setting value=null before .click() is safe; setting it after a
      selection clears .files on Chromium.
   4. Each tile stores a UUID in a data attribute that maps to a
      key in a `tileFileMap`, so removing a tile removes exactly the
      right File from the bag.
   ================================================================ */
(function () {
    const MAX_IMAGES  = 10;
    const grid        = document.getElementById('imageGrid');
    const input       = document.getElementById('imageInput');
    const addTile     = document.getElementById('addImageTile');
    const removedList = document.getElementById('removedImagesInput');

    const bag          = new DataTransfer();  // single source of truth for picked files
    const tileFileMap  = new Map();            // tileId -> File object

    function existingCount() {
        return grid.querySelectorAll('.image-tile.existing').length;
    }
    function newCount() {
        return grid.querySelectorAll('.image-tile.new').length;
    }
    function totalCount() {
        return existingCount() + newCount();
    }

    function enforceLimit() {
        addTile.style.display = (totalCount() >= MAX_IMAGES) ? 'none' : '';
    }

    // Expose the picker-opener so the "Add images" tile can call it
    window.openImagePicker = function () {
        // Reset the picker's internal value BEFORE opening so the user
        // can re-select the same file if they just removed it from the
        // bag. This is safe — we have not yet assigned anything.
        input.value = null;
        input.click();
    };

    // Rebuild the bag from the current tileFileMap, then push to input.files.
    // This is called after adding or removing a new tile.
    function syncInputFromMap() {
        // Clear and rebuild the DataTransfer bag
        while (bag.items.length) bag.items.remove(0);
        tileFileMap.forEach(function (file) { bag.items.add(file); });
        input.files = bag.files;
    }

    input.addEventListener('change', function () {
        const picked = Array.from(this.files || []);
        if (picked.length === 0) return; // user cancelled — no change

        // How many can we still accept?
        const remainingSlots = MAX_IMAGES - totalCount();
        if (remainingSlots <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Limit reached',
                text: 'You already have ' + MAX_IMAGES + ' images. Remove one before adding more.',
                confirmButtonColor: '#BF0001'
            });
            return;
        }

        const toAdd = picked.slice(0, remainingSlots);
        const skipped = picked.length - toAdd.length;

        if (skipped > 0) {
            Swal.fire({
                icon: 'info',
                title: 'Some files skipped',
                text: 'Only ' + toAdd.length + ' of your ' + picked.length +
                      ' selected files were added. The ' + MAX_IMAGES +
                      '-image limit was reached.',
                confirmButtonColor: '#BF0001'
            });
        }

        toAdd.forEach(function (file) {
            const tileId = 'tile_' + Date.now() + '_' + Math.random().toString(36).slice(2, 8);
            tileFileMap.set(tileId, file);

            // Preview tile
            const reader = new FileReader();
            reader.onload = function (e) {
                const tile = document.createElement('div');
                tile.className = 'image-tile new';
                tile.setAttribute('data-tile-id', tileId);
                tile.innerHTML =
                    '<img src="' + e.target.result + '" alt="New image">' +
                    '<button type="button" class="remove-img-btn" title="Remove image">' +
                        '<i class="bi bi-x-lg"></i>' +
                    '</button>' +
                    '<div class="uploaded-tag selected"><i class="bi bi-check-circle"></i> Selected</div>';

                tile.querySelector('.remove-img-btn').addEventListener('click', function (ev) {
                    ev.stopPropagation();
                    tileFileMap.delete(tileId);
                    tile.remove();
                    syncInputFromMap();
                    enforceLimit();
                });

                grid.insertBefore(tile, addTile);
                enforceLimit();
            };
            reader.readAsDataURL(file);
        });

        // After adding to the map, push everything to the real input
        syncInputFromMap();
    });

    enforceLimit();

    window.removeExistingImage = function (btn, path) {
        Swal.fire({
            title: 'Remove this image?',
            text: 'This image will be deleted when you save the form.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#6c757d',
            reverseButtons: true,
        }).then(function (result) {
            if (!result.isConfirmed) return;

            const tile = btn.closest('.image-tile');
            tile.remove();

            const removed = JSON.parse(removedList.value || '[]');
            removed.push(path);
            removedList.value = JSON.stringify(removed);

            enforceLimit();
        });
    };
})();

/* ================================================================
   Scroll to first error
   ================================================================ */
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
    .help-badge{
        font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px;
        background: var(--canvas,#F6F7FB); color: var(--muted,#667085);
    }

    .field{ margin-bottom:0; }
    input[type=text], textarea, select{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; transition:box-shadow .15s, border-color .15s; background:#fff;
        box-sizing:border-box;
    }
    textarea{ resize:vertical; min-height:96px; line-height:1.55; }
    input:focus, textarea:focus, select:focus{
        border-color: var(--orange,#BF0001);
        box-shadow: 0 0 0 4px var(--orange-tint-strong,#FFE9D8);
    }
    .input-error{ border-color:#e74c3c !important; background:#fff8f8; }
    .field-error{ display:flex; align-items:center; gap:5px; color:#e74c3c; font-size:12.5px; margin-top:6px; }

    .field-counter{
        display:flex; align-items:center; justify-content:space-between; gap:12px;
        margin-top:6px; font-size:11.5px; color: var(--faint,#9AA1B2); font-weight:500;
    }
    .field-counter .field-hint{ font-size:11px; color: var(--faint,#9AA1B2); }
    .field-counter.near-limit > span:first-child{ color:#BF0001; font-weight:600; }

    .notice{ margin-top:16px; display:flex; align-items:flex-start; gap:8px; background: var(--canvas,#F6F7FB); border-radius:10px; padding:10px 12px; }
    .notice p{ font-size:12px; color: var(--muted,#667085); margin:0; }
    .notice.caution{ background:#FFF8E8; border:1px solid #F5E3B3; margin-top:0; margin-bottom:16px; }
    .notice.caution i{ color:#B7791F; }
    .notice.caution p{ color:#8A6116; }
    .notice.caution p b{ color:#6B4A0E; font-weight:700; }

    .image-grid{
        display:grid; grid-template-columns:repeat(auto-fill, minmax(170px, 1fr));
        gap:12px;
    }
    .image-tile{
        position:relative; aspect-ratio:16/9; border-radius:12px; overflow:hidden;
        background:#0F1220; display:flex; align-items:center; justify-content:center;
    }
    .image-tile img{ width:100%; height:100%; object-fit:cover; display:block; }
    .image-tile.drop{
        background:#FAFBFD; border:2px dashed var(--input-border,#DBDFEA);
        cursor:pointer; flex-direction:column; text-align:center;
        transition:border-color .15s, background .15s;
    }
    .image-tile.drop:hover{ border-color: var(--orange,#BF0001); background: var(--orange-tint,#FFF8F3); }
    .ico-circle{ width:40px; height:40px; border-radius:999px; background:#EEF0F6; display:flex; align-items:center; justify-content:center; margin-bottom:8px; }
    .drop-title{ font-size:12px; font-weight:500; color: var(--muted,#667085); }
    .drop-sub{ font-size:11px; color:#B0B5C4; margin-top:2px; }

    .uploaded-tag{
        position:absolute; left:0; right:0; bottom:0; padding:6px 10px;
        background:linear-gradient(to top, rgba(0,0,0,0.55), transparent);
        color:rgba(255,255,255,0.9); font-size:11px; display:flex; align-items:center; gap:4px;
    }
    .uploaded-tag.selected{ color:#fff; }
    .remove-img-btn{
        position:absolute; top:6px; right:6px; width:26px; height:26px; border-radius:999px;
        background:rgba(0,0,0,0.6); border:none; color:#fff; display:flex; align-items:center;
        justify-content:center; cursor:pointer; transition:background .15s; z-index:3; font-size:12px;
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