@extends('admin.layout')
@section('title', $facility->exists ? 'Edit Facility' : 'Add Facility')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@php
    $features = old('features', $facility->features ?? []);
    if (empty($features)) {
        $features = [''];
    }
@endphp

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
        <span onclick="window.location='{{ route('admin.facilities') }}'">Facilities</span>
        <span>&rsaquo;</span>
        <b>{{ $facility->exists ? 'Edit' : 'Add' }}</b>
    </div>

    <div class="header">
        <div>
            <h1>{{ $facility->exists ? 'Edit Facility' : 'Add Facility' }}</h1>
            <p>{{ $facility->exists ? 'Update the photos and details for this facility.' : 'Add a lab, library, sports ground, transport route or any other facility.' }}</p>
        </div>
    </div>

    <form action="{{ $facility->exists ? route('admin.facilities.update', $facility) : route('admin.facilities.store') }}"
          method="POST" enctype="multipart/form-data" id="facilityForm" novalidate>
        @csrf
        @if ($facility->exists)
            @method('PUT')
        @endif

        {{-- ================= Category ================= --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-grid"></i></span> Category <span class="req">*</span></h2>
            </div>

            <div class="cat-picker" id="cat-picker">
                @foreach ($categories as $key => $label)
                    <label class="cat-option">
                        <input type="radio" name="category" value="{{ $key }}"
                               @checked(old('category', $facility->category) === $key)>
                        <span class="cat-card">
                            <i class="bi {{ \App\Models\Facility::CATEGORY_ICONS[$key] ?? 'bi-grid' }}"></i>
                            {{ $label }}
                        </span>
                    </label>
                @endforeach
            </div>
            @error('category')
                <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>

        {{-- ================= Basic details ================= --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-card-text"></i></span> Basic Details</h2>
            </div>

            <div class="field">
                <label class="lbl">Title <span class="req">*</span></label>
                <input type="text" name="title" value="{{ old('title', $facility->title) }}" maxlength="150"
                       class="{{ $errors->has('title') ? 'input-error' : '' }}"
                       placeholder="e.g. Physics Lab, Main Library, Football Ground, Route 3 – Kakkanad">
                @error('title')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <label class="lbl">Short Description  <span class="req">*</span> <span class="counter" data-for="short_description"></span></label>
                <textarea name="short_description" rows="2" maxlength="255"
                          class="{{ $errors->has('short_description') ? 'input-error' : '' }}"
                          placeholder="One or two lines shown on the facility card">{{ old('short_description', $facility->short_description) }}</textarea>
                @error('short_description')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="field" style="margin-bottom:0;">
                <label class="lbl">Full Description</label>
                <textarea name="description" id="description" rows="8"
                          class="{{ $errors->has('description') ? 'input-error' : '' }}"
                          placeholder="Describe the facility — equipment, activities, how students use it…">{{ old('description', $facility->description) }}</textarea>
                @error('description')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- ================= Cover image ================= --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-image"></i></span> Cover Image <span class="req">*</span></h2>
            </div>

            <div class="notice caution">
                <i class="bi bi-exclamation-triangle" style="margin-top:1px;"></i>
             <p><b>Required</b> &middot; recommended 416&times;260px &middot; JPG, PNG, WEBP &middot; up to 5MB.</p>

            </div>

            <div class="image-slot" style="max-width:320px;">
                <div class="drop {{ $facility->image ? 'filled' : '' }}" id="drop-image" onclick="handleDropClick(this)" data-file-input="file-image">
                    @if ($facility->image)
                        <img src="{{ $facility->image_url }}" id="preview-image" alt="{{ $facility->title }}">
                        <button type="button" class="remove-img-btn" onclick="removeCover(event)" title="Remove image">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <div class="uploaded-tag"><i class="bi bi-check-circle"></i> Uploaded</div>
                    @else
                        <div class="preview-placeholder" id="preview-image">
                            <div class="ico-circle"><i class="bi bi-image" style="color:#AEB4C4;font-size:18px;"></i></div>
                            <div class="drop-title">Click to upload</div>
                            <div class="drop-sub">or drag &amp; drop</div>
                        </div>
                    @endif
                </div>
                <input type="file" id="file-image" name="image" accept="image/jpeg,image/png,image/webp" data-max-size="5" hidden
                       onchange="previewCover(this)">
                <input type="hidden" name="remove_image" id="remove-image" value="0">
                <button type="button" class="choose-btn" id="choose-image" style="{{ $facility->image ? 'display:none;' : '' }}"
                        onclick="document.getElementById('file-image').click()">Choose image</button>
                <span class="file-size-info" id="size-image"></span>
            </div>
            @error('image')
                <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>

        {{-- ================= Gallery ================= --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-images"></i></span> Photo Gallery <span class="req">*</span></h2>

                <!-- <span class="field-hint">Up to 20 photos per upload &middot; JPG, PNG, WEBP &middot; 5MB each</span> -->


                
            </div>

            
            <div class="notice caution">
                <i class="bi bi-exclamation-triangle" style="margin-top:1px;"></i>
          <p><b>Required</b> &middot; Min 1, up to 20 photos per upload &middot; Recommended 310&times;230px&middot; JPG, PNG, WEBP &middot; 5MB each</p>

            </div>

            <div class="gallery-grid" id="gallery-grid">
                {{-- Existing photos --}}
                @foreach ($facility->gallery ?? [] as $i => $path)
                    <div class="g-item existing" data-path="{{ $path }}">
                        <img src="{{ Storage::url($path) }}" alt="">
                        <label class="g-remove" title="Remove photo">
                            <input type="checkbox" name="remove_gallery[]" value="{{ $path }}" onchange="toggleExisting(this)">
                            <i class="bi bi-trash"></i>
                        </label>
                        <div class="g-removed-tag"><i class="bi bi-trash"></i> Will be removed</div>
                    </div>
                @endforeach

                {{-- Add tile --}}
                <div class="g-add" id="gallery-drop" onclick="document.getElementById('file-gallery').click()">
                    <i class="bi bi-plus-lg"></i>
                    <span>Add photos</span>
                </div>
            </div>
            <input type="file" id="file-gallery" name="gallery[]" accept="image/jpeg,image/png,image/webp" multiple hidden>
            <span class="file-size-info" id="size-gallery"></span>
            <span id="gallery-errors"></span>
        </div>

        {{-- ================= Highlights ================= --}}

        <!-- <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-stars"></i></span> Highlights</h2>
                <span class="field-hint">Short bullet points shown on the facility page</span>
            </div>

            <div id="features-list">
                @foreach ($features as $feature)
                    <div class="feature-row">
                        <i class="bi bi-check2-circle"></i>
                        <input type="text" name="features[]" value="{{ $feature }}" maxlength="100"
                               placeholder="e.g. 40 computers with high-speed internet">
                        <button type="button" class="feature-remove" onclick="removeFeature(this)" title="Remove">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                @endforeach
            </div>
            <button type="button" class="add-row-btn" onclick="addFeature()">
                <i class="bi bi-plus-lg"></i> Add highlight
            </button>
            @error('features.*')
                <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div> -->

        {{-- ================= Facility details ================= --}}


        <!-- <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-info-circle"></i></span> Facility Details</h2>
                <span class="field-hint">All optional</span>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label class="lbl" id="capacity-label">Capacity</label>
                    <input type="number" name="capacity" min="0" value="{{ old('capacity', $facility->capacity) }}"
                           class="{{ $errors->has('capacity') ? 'input-error' : '' }}" id="capacity-input">
                    @error('capacity')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label class="lbl" id="location-label">Location</label>
                    <input type="text" name="location" maxlength="150" value="{{ old('location', $facility->location) }}"
                           class="{{ $errors->has('location') ? 'input-error' : '' }}" id="location-input"
                           placeholder="e.g. Block A, 2nd floor">
                    @error('location')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label class="lbl">Timings</label>
                    <input type="text" name="timings" maxlength="100" value="{{ old('timings', $facility->timings) }}"
                           class="{{ $errors->has('timings') ? 'input-error' : '' }}"
                           placeholder="e.g. 8:30 AM – 4:00 PM, Mon–Sat">
                    @error('timings')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label class="lbl">Icon <span class="field-hint">(Bootstrap icon class)</span></label>
                    <input type="text" name="icon" maxlength="50" value="{{ old('icon', $facility->icon) }}"
                           class="{{ $errors->has('icon') ? 'input-error' : '' }}" placeholder="Leave empty for the category icon">
                    @error('icon')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label class="lbl" id="contact-person-label">Contact Person</label>
                    <input type="text" name="contact_person" maxlength="100" value="{{ old('contact_person', $facility->contact_person) }}"
                           class="{{ $errors->has('contact_person') ? 'input-error' : '' }}" placeholder="e.g. Lab in-charge, Librarian">
                    @error('contact_person')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label class="lbl">Contact Phone</label>
                    <input type="text" name="contact_phone" maxlength="20" value="{{ old('contact_phone', $facility->contact_phone) }}"
                           class="{{ $errors->has('contact_phone') ? 'input-error' : '' }}" placeholder="e.g. +91 98765 43210">
                    @error('contact_phone')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div> -->

        {{-- ================= SEO ================= --}}

        <!-- <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-search"></i></span> SEO</h2>
                <span class="field-hint">Leave empty to use the title and short description</span>
            </div>

            <div class="field">
                <label class="lbl">Meta Title <span class="counter" data-for="meta_title"></span></label>
                <input type="text" name="meta_title" maxlength="70" value="{{ old('meta_title', $facility->meta_title) }}"
                       class="{{ $errors->has('meta_title') ? 'input-error' : '' }}">
                @error('meta_title')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="field" style="margin-bottom:0;">
                <label class="lbl">Meta Description <span class="counter" data-for="meta_description"></span></label>
                <textarea name="meta_description" rows="3" maxlength="160"
                          class="{{ $errors->has('meta_description') ? 'input-error' : '' }}">{{ old('meta_description', $facility->meta_description) }}</textarea>
                @error('meta_description')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div> -->

        {{-- ================= Display settings ================= --}}


        <!-- <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-sliders"></i></span> Display Settings</h2>
            </div>

            <div class="field">
                <label class="lbl">Sort Order</label>
                <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $facility->sort_order ?? 0) }}"
                       class="{{ $errors->has('sort_order') ? 'input-error' : '' }}" style="max-width:140px;">
                <span class="field-hint" style="display:block;margin-top:6px;">Lower numbers show first.</span>
                @error('sort_order')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <label class="toggle-row" style="margin-bottom:14px;">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $facility->exists ? $facility->is_active : true) ? 'checked' : '' }}>
                <span class="toggle-switch"></span>
                <span class="toggle-label">Show this facility on the website</span>
            </label>

            <label class="toggle-row">
                <input type="hidden" name="show_on_home" value="0">
                <input type="checkbox" name="show_on_home" value="1"
                       {{ old('show_on_home', $facility->show_on_home) ? 'checked' : '' }}>
                <span class="toggle-switch"></span>
                <span class="toggle-label">Feature on the home page</span>
            </label>
        </div> -->

        
        <div class="savebar">
            <div class="savebar-inner">
                <span class="savebar-status">All changes save to the live Facilities list</span>
                <div class="btn-group">
                    <a href="{{ route('admin.facilities') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <i class="bi bi-check-lg"></i>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- ================= Scripts ================= --}}
<script>
/* ---------- Category-specific labels ---------- */
const CATEGORY_HINTS = {
    lab:       { capacity: 'Seating capacity (students)', location: 'Location', contact: 'Lab in-charge',
                 feature: 'e.g. 40 computers with high-speed internet', loc: 'e.g. Block A, 2nd floor' },
    library:   { capacity: 'Books in collection',         location: 'Location', contact: 'Librarian',
                 feature: 'e.g. 12,000+ books and 30 periodicals',     loc: 'e.g. Main block, ground floor' },
    sports:    { capacity: 'Courts / grounds',            location: 'Location', contact: 'Sports coach',
                 feature: 'e.g. Full-size football ground',             loc: 'e.g. Behind the main block' },
    transport: { capacity: 'Seating capacity (vehicle)',  location: 'Route / areas covered', contact: 'Driver / co-ordinator',
                 feature: 'e.g. GPS-tracked buses with lady attendant', loc: 'e.g. Kakkanad – Edappally – Vyttila' },
    other:     { capacity: 'Capacity',                    location: 'Location', contact: 'Contact Person',
                 feature: 'e.g. Air-conditioned',                       loc: 'e.g. Block B' },
};

function applyCategoryHints() {
    const checked = document.querySelector('input[name="category"]:checked');
    const h = CATEGORY_HINTS[checked ? checked.value : 'other'] || CATEGORY_HINTS.other;
    document.getElementById('capacity-label').textContent = h.capacity;
    document.getElementById('location-label').textContent = h.location;
    document.getElementById('contact-person-label').textContent = h.contact;
    document.getElementById('location-input').placeholder = h.loc;
    document.querySelectorAll('#features-list input').forEach(i => i.placeholder = h.feature);
}
document.querySelectorAll('input[name="category"]').forEach(r => r.addEventListener('change', applyCategoryHints));

/* ---------- Character counters ---------- */
function updateCounter(el) {
    const counter = document.querySelector(`.counter[data-for="${el.name}"]`);
    if (!counter) return;
    const max = parseInt(el.getAttribute('maxlength'), 10);
    counter.textContent = `${el.value.length}/${max}`;
    counter.classList.toggle('near', el.value.length > max * 0.9);
}
document.querySelectorAll('.counter').forEach(c => {
    const el = document.querySelector(`[name="${c.dataset.for}"]`);
    if (!el) return;
    el.addEventListener('input', () => updateCounter(el));
    updateCounter(el);
});

/* ---------- Cover image ---------- */
function handleDropClick(el) {
    if (el.classList.contains('filled')) return;
    document.getElementById(el.dataset.fileInput).click();
}

function previewCover(input) {
    const size = document.getElementById('size-image');
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const mb = file.size / (1024 * 1024);

    if (mb > 5) {
        size.innerHTML = `<i class="bi bi-exclamation-triangle"></i> ${mb.toFixed(2)} MB — exceeds 5MB limit!`;
        size.classList.add('size-error');
    } else {
        size.innerHTML = `<i class="bi bi-check-circle"></i> ${mb.toFixed(2)} MB`;
        size.classList.remove('size-error');
    }

    const reader = new FileReader();
    reader.onload = e => {
        const drop = document.getElementById('drop-image');
        drop.classList.add('filled');
        drop.innerHTML = `
            <img src="${e.target.result}" id="preview-image" alt="">
            <button type="button" class="remove-img-btn" onclick="removeCover(event)" title="Remove image">
                <i class="bi bi-x-lg"></i>
            </button>`;
        document.getElementById('choose-image').style.display = 'none';
        document.getElementById('remove-image').value = '0';
    };
    reader.readAsDataURL(file);
}

function removeCover(event) {
    event.stopPropagation();
    const drop = document.getElementById('drop-image');
    document.getElementById('file-image').value = '';
    document.getElementById('remove-image').value = '1';
    document.getElementById('size-image').textContent = '';
    drop.classList.remove('filled');
    drop.innerHTML = `
        <div class="preview-placeholder" id="preview-image">
            <div class="ico-circle"><i class="bi bi-image" style="color:#AEB4C4;font-size:18px;"></i></div>
            <div class="drop-title">Click to upload</div>
            <div class="drop-sub">or drag &amp; drop</div>
        </div>`;
    document.getElementById('choose-image').style.display = 'block';
}

/* ---------- Gallery (keeps a running list so you can add in batches) ---------- */
const galleryInput = document.getElementById('file-gallery');
let newGalleryFiles = [];

galleryInput.addEventListener('change', function () {
    addGalleryFiles(Array.from(this.files));
});

function addGalleryFiles(files) {
    files.filter(f => f.type.startsWith('image/')).forEach(f => newGalleryFiles.push(f));
    syncGalleryInput();
    renderNewGallery();
}

function syncGalleryInput() {
    const dt = new DataTransfer();
    newGalleryFiles.forEach(f => dt.items.add(f));
    galleryInput.files = dt.files;

    const info = document.getElementById('size-gallery');
    const tooBig = newGalleryFiles.filter(f => f.size > 5 * 1024 * 1024).length;
    if (!newGalleryFiles.length) {
        info.textContent = '';
        info.classList.remove('size-error');
    } else if (tooBig) {
        info.innerHTML = `<i class="bi bi-exclamation-triangle"></i> ${tooBig} photo(s) are larger than 5MB and will be rejected.`;
        info.classList.add('size-error');
    } else {
        info.innerHTML = `<i class="bi bi-check-circle"></i> ${newGalleryFiles.length} new photo(s) ready to upload`;
        info.classList.remove('size-error');
    }
}

function renderNewGallery() {
    const grid = document.getElementById('gallery-grid');
    const addTile = document.getElementById('gallery-drop');
    grid.querySelectorAll('.g-item.new').forEach(el => el.remove());

    newGalleryFiles.forEach((file, index) => {
        const item = document.createElement('div');
        item.className = 'g-item new';
        item.innerHTML = `
            <img alt="">
            <button type="button" class="g-remove-btn" title="Remove"><i class="bi bi-x-lg"></i></button>
            <span class="g-new-tag">New</span>`;
        item.querySelector('img').src = URL.createObjectURL(file);
        item.querySelector('button').onclick = () => {
            newGalleryFiles.splice(index, 1);
            syncGalleryInput();
            renderNewGallery();
        };
        grid.insertBefore(item, addTile);
    });
}

function toggleExisting(checkbox) {
    checkbox.closest('.g-item').classList.toggle('marked', checkbox.checked);
}

/* Drag & drop onto the add tile and the cover slot */
[['gallery-drop', files => addGalleryFiles(files)],
 ['drop-image', files => {
     if (!files[0]) return;
     const dt = new DataTransfer(); dt.items.add(files[0]);
     const input = document.getElementById('file-image');
     input.files = dt.files; previewCover(input);
 }]].forEach(([id, handler]) => {
    const el = document.getElementById(id);
    ['dragenter', 'dragover'].forEach(ev => el.addEventListener(ev, e => { e.preventDefault(); el.classList.add('drag'); }));
    ['dragleave', 'drop'].forEach(ev => el.addEventListener(ev, e => { e.preventDefault(); el.classList.remove('drag'); }));
    el.addEventListener('drop', e => handler(Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'))));
});

/* ---------- Highlights ---------- */
function addFeature(value = '') {
    const row = document.createElement('div');
    row.className = 'feature-row';
    row.innerHTML = `
        <i class="bi bi-check2-circle"></i>
        <input type="text" name="features[]" maxlength="100">
        <button type="button" class="feature-remove" onclick="removeFeature(this)" title="Remove"><i class="bi bi-x-lg"></i></button>`;
    row.querySelector('input').value = value;
    document.getElementById('features-list').appendChild(row);
    applyCategoryHints();
    row.querySelector('input').focus();
}

function removeFeature(btn) {
    const list = document.getElementById('features-list');
    if (list.children.length === 1) {
        list.querySelector('input').value = '';
        return;
    }
    btn.closest('.feature-row').remove();
}

document.getElementById('features-list').addEventListener('keydown', e => {
    if (e.key === 'Enter' && e.target.matches('input')) {
        e.preventDefault();
        addFeature();
    }
});

/* ---------- Init ---------- */
document.addEventListener('DOMContentLoaded', function () {
    applyCategoryHints();

    const firstError = document.querySelector('.input-error') || document.querySelector('.field-error');
    if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
</script>

<script>
/* ---------- AJAX submit (same flow as Gallery) ---------- */
document.getElementById('facilityForm').addEventListener('submit', function (e) {
    e.preventDefault();
    submitFacilityForm();
});

function submitFacilityForm() {
    const form = document.getElementById('facilityForm');
    const formData = new FormData(form);
    const submitBtn = form.querySelector('.btn-save');
    const originalBtnHtml = submitBtn.innerHTML;

    form.querySelectorAll('.field-error').forEach(el => el.remove());
    form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));

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
            showFacilityValidationErrors(data.errors);
            return;
        }

        if (response.status === 413) {
            throw new Error('The files are too large to upload together. Try fewer photos at a time.');
        }

        if (!response.ok) {
            throw new Error((data && data.message) || 'Something went wrong. Please try again.');
        }

        Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: data && data.message ? data.message : 'Facility saved successfully.',
            confirmButtonColor: '#002F5F',
            timer: 2000,
            timerProgressBar: true
        }).then(() => {
            window.location.href = "{{ route('admin.facilities') }}";
        });
    })
    .catch((err) => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: err.message || 'Something went wrong. Please try again.',
            confirmButtonColor: '#002F5F'
        });
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnHtml;
    });
}

function showFacilityValidationErrors(errors) {
    const form = document.getElementById('facilityForm');

    // Where to show errors for fields that aren't a simple input
    const targetFor = (field) => {
        const base = field.split('.')[0];
        if (base === 'category')       return document.getElementById('cat-picker');
        if (base === 'image')          return document.getElementById('drop-image');
        if (base === 'gallery')        return document.getElementById('gallery-errors');
        if (base === 'features')       return document.getElementById('features-list');
        if (base === 'remove_gallery') return document.getElementById('gallery-errors');
        return form.querySelector(`[name="${base}"]:not([type="hidden"])`) || form.querySelector(`[name="${base}"]`);
    };

    const shown = new Set();
    Object.keys(errors).forEach(field => {
        const target = targetFor(field);
        const message = errors[field][0];
        if (!target || shown.has(message)) return;
        shown.add(message);

        if (target.matches('input, textarea, select')) {
            target.classList.add('input-error');
        }

        const errorEl = document.createElement('span');
        errorEl.className = 'field-error';
        errorEl.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${message}`;

        // For toggles/labels, put the error after the wrapping element
        const anchor = target.closest('.toggle-row') || target;
        anchor.insertAdjacentElement('afterend', errorEl);
    });

    const first = form.querySelector('.input-error') || form.querySelector('.field-error');
    if (first) {
        first.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}
</script>

{{-- ================= Styles ================= --}}
<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span{ cursor:pointer; transition:color .15s; }
    .crumbs span:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:560px; line-height:1.55; }

    .section-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:6px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .icon{ display:inline-flex; color: var(--orange,#BF0001); }

    .field{ margin-bottom:16px; }
    .lbl{ display:flex; align-items:center; gap:6px; font-size:12.5px; font-weight:600; color: var(--muted,#667085); margin-bottom:6px; }
    .counter{ margin-left:auto; font-weight:500; font-size:11.5px; color: var(--faint,#9AA1B2); }
    .counter.near{ color:#B7791F; }
    input[type=text], input[type=number], textarea, select{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; transition:box-shadow .15s, border-color .15s; background:#fff; box-sizing:border-box;
    }
    textarea{ resize:vertical; line-height:1.55; }
    input[type=text]:focus, input[type=number]:focus, textarea:focus, select:focus{
        border-color: var(--orange,#BF0001);
        box-shadow: 0 0 0 4px var(--orange-tint-strong,#FFE9D8);
    }
    .input-error{ border-color:#e74c3c !important; background:#fff8f8; }
    .field-error{ display:flex; align-items:center; gap:5px; color:#e74c3c; font-size:12.5px; margin-top:6px; }
    .field-hint{ font-size:12px; color: var(--faint,#9AA1B2); font-weight:400; }
    .grid-2{ display:grid; grid-template-columns:1fr 1fr; gap:0 16px; }
    @media (max-width:720px){ .grid-2{ grid-template-columns:1fr; } }

    .notice{ margin-top:16px; display:flex; align-items:flex-start; gap:8px; background: var(--canvas,#F6F7FB); border-radius:10px; padding:10px 12px; }
    .notice p{ font-size:12px; color: var(--muted,#667085); margin:0; }
    .notice.caution{ background:#FFF8E8; border:1px solid #F5E3B3; margin-top:0; margin-bottom:16px; }
    .notice.caution i{ color:#B7791F; }
    .notice.caution p{ color:#8A6116; }
    .notice.caution p b{ color:#6B4A0E; font-weight:700; }

    /* Category picker */
    .cat-picker{ display:grid; grid-template-columns:repeat(auto-fill, minmax(130px, 1fr)); gap:10px; }
    .cat-option input{ position:absolute; opacity:0; width:0; height:0; }
    .cat-card{
        display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px 10px;
        border:1.5px solid var(--input-border,#DBDFEA); border-radius:12px; cursor:pointer;
        font-size:13px; font-weight:600; color: var(--muted,#667085); background:#fff; transition:all .15s; text-align:center;
    }
    .cat-card i{ font-size:22px; }
    .cat-card:hover{ border-color: var(--orange,#BF0001); color: var(--orange,#BF0001); }
    .cat-option input:checked + .cat-card{
        border-color: var(--orange,#BF0001); background: var(--orange-tint,#FFF8F3); color: var(--orange,#BF0001);
        box-shadow:0 0 0 3px var(--orange-tint-strong,#FFE9D8);
    }
    .cat-option input:focus-visible + .cat-card{ outline:2px solid var(--orange,#BF0001); outline-offset:2px; }

    /* Cover drop slot */
    .drop{
        position:relative; aspect-ratio:16/10; border-radius:12px;
        border:2px dashed var(--input-border,#DBDFEA); background:#FAFBFD;
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        cursor:pointer; overflow:hidden; transition:border-color .15s, background .15s; text-align:center;
    }
    .drop:hover, .drop.drag{ border-color: var(--orange,#BF0001); background: var(--orange-tint,#FFF8F3); }
    .drop.filled{ border:2px solid transparent; background:#0F1220; cursor:default; }
    .drop img{ width:100%; height:100%; object-fit:cover; display:block; }
    .ico-circle{ width:40px; height:40px; border-radius:999px; background:#EEF0F6; display:flex; align-items:center; justify-content:center; margin-bottom:8px; }
    .drop-title{ font-size:12px; font-weight:500; color: var(--muted,#667085); }
    .drop-sub{ font-size:11px; color:#B0B5C4; margin-top:2px; }
    .uploaded-tag{
        position:absolute; left:0; right:0; bottom:0; padding:8px 12px;
        background:linear-gradient(to top, rgba(0,0,0,0.55), transparent);
        color:rgba(255,255,255,0.9); font-size:11px; display:flex; align-items:center; gap:4px; pointer-events:none;
    }
    .choose-btn{
        margin-top:8px; width:100%; font-size:12px; font-weight:600; color: var(--orange,#BF0001);
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

    /* Gallery grid */
    .gallery-grid{ display:grid; grid-template-columns:repeat(auto-fill, minmax(140px, 1fr)); gap:12px; }
    .g-item, .g-add{ position:relative; aspect-ratio:4/3; border-radius:10px; overflow:hidden; }
    .g-item{ background:#0F1220; }
    .g-item img{ width:100%; height:100%; object-fit:cover; display:block; transition:opacity .15s, filter .15s; }
    .g-remove, .g-remove-btn{
        position:absolute; top:6px; right:6px; width:28px; height:28px; border-radius:999px;
        background:rgba(0,0,0,0.6); color:#fff; display:flex; align-items:center; justify-content:center;
        cursor:pointer; border:none; font-size:12px; z-index:2;
    }
    .g-remove input{ position:absolute; opacity:0; width:0; height:0; }
    .g-remove:hover, .g-remove-btn:hover{ background:#C62828; }
    .g-removed-tag{
        display:none; position:absolute; inset:0; align-items:center; justify-content:center; gap:5px;
        background:rgba(198,40,40,0.55); color:#fff; font-size:11px; font-weight:600; text-align:center; padding:8px;
        pointer-events:none;
    }
    .g-item.marked img{ opacity:.35; filter:grayscale(1); }
    .g-item.marked .g-removed-tag{ display:flex; }
    .g-item.marked .g-remove{ background:#C62828; }
    .g-new-tag{ position:absolute; left:6px; bottom:6px; background:#1E8E4E; color:#fff; font-size:10.5px; font-weight:700; padding:2px 8px; border-radius:999px; }
    .g-add{
        display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px;
        border:2px dashed var(--input-border,#DBDFEA); background:#FAFBFD; cursor:pointer;
        color: var(--muted,#667085); font-size:12.5px; font-weight:600; transition:all .15s;
    }
    .g-add i{ font-size:20px; }
    .g-add:hover, .g-add.drag{ border-color: var(--orange,#BF0001); color: var(--orange,#BF0001); background: var(--orange-tint,#FFF8F3); }

    /* Highlights */
    .feature-row{ display:flex; align-items:center; gap:10px; margin-bottom:10px; }
    .feature-row > i{ color:#1E8E4E; font-size:16px; flex-shrink:0; }
    .feature-remove{
        flex-shrink:0; width:34px; height:34px; border-radius:8px; border:1px solid var(--line,#E9EBF2);
        background:#fff; color: var(--faint,#9AA1B2); cursor:pointer; transition:all .15s;
    }
    .feature-remove:hover{ color:#C62828; border-color:#F3C4C4; background:#FFF6F6; }
    .add-row-btn{
        display:inline-flex; align-items:center; gap:6px; font-size:12.5px; font-weight:600;
        color: var(--orange,#BF0001); background:none; border:1px dashed var(--orange-border,#F3D8C2);
        border-radius:8px; padding:8px 14px; cursor:pointer; transition:background .15s;
    }
    .add-row-btn:hover{ background: var(--orange-tint,#FFF8F3); }

    /* Toggles */
    .toggle-row{ display:flex; align-items:center; gap:12px; cursor:pointer; position:relative; }
    .toggle-row input[type="checkbox"]{ position:absolute; opacity:0; width:0; height:0; }
    .toggle-switch{
        position:relative; width:42px; height:24px; border-radius:999px; background:#DBDFEA; flex-shrink:0;
        transition:background .15s;
    }
    .toggle-switch::after{
        content:''; position:absolute; top:2px; left:2px; width:20px; height:20px; border-radius:999px;
        background:#fff; box-shadow:0 1px 2px rgba(0,0,0,0.2); transition:transform .15s;
    }
    .toggle-row input[type="checkbox"]:checked + .toggle-switch{ background: var(--orange,#BF0001); }
    .toggle-row input[type="checkbox"]:checked + .toggle-switch::after{ transform:translateX(18px); }
    .toggle-label{ font-size:13.5px; color: var(--ink,#171B2C); }

    /* Save bar */
    .savebar{
        position:sticky; bottom:0; border-top:1px solid var(--line,#E9EBF2);
        background:rgba(255,255,255,0.92); backdrop-filter:blur(6px);
        margin:24px -32px -32px; padding:0 32px;
        box-shadow:0 -4px 16px -8px rgba(15,21,38,0.06); z-index:5;
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
    .btn-save:disabled{ opacity:.7; cursor:wait; transform:none; }

    .req{ color:#BF0001; }
</style>

@endsection
