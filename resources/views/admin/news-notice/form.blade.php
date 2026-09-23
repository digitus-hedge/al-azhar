@extends('admin.layout')
@section('title', $newsNotice->exists ? 'Edit Notice' : 'Add Notice')
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
        <span onclick="window.location='{{ route('admin.news-notices') }}'">News &amp; Notices</span>
        <span>&rsaquo;</span>
        <b>{{ $newsNotice->exists ? 'Edit' : 'Add' }}</b>
    </div>

    <div class="header">
        <div>
            <h1>{{ $newsNotice->exists ? 'Edit Notice' : 'Add Notice' }}</h1>
            <p>{{ $newsNotice->exists ? 'Update this notice.' : 'Add a new circular, notice, or announcement.' }}</p>
        </div>
    </div>

    <form action="{{ $newsNotice->exists ? route('admin.news-notices.update', $newsNotice) : route('admin.news-notices.store') }}"
          method="POST" enctype="multipart/form-data" id="noticeForm">
        @csrf
        @if ($newsNotice->exists)
            @method('PUT')
        @endif

        {{-- Title --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-type"></i></span> Title <span class="req">*</span></h2>
            </div>
            <div class="field">
                <input type="text" name="title" value="{{ old('title', $newsNotice->title) }}"
                       class="{{ $errors->has('title') ? 'input-error' : '' }}"
                       placeholder="Enter notice title">
                @error('title')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Type + Published date --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-tags"></i></span> Type &amp; Date <span class="req">*</span></h2>
            </div>
            <div class="field-row">
                <div class="field">
                    <div class="field-top"><label class="field-label">Type</label></div>
                    <select name="type" class="{{ $errors->has('type') ? 'input-error' : '' }}">
                        <option value="">— Select type —</option>
                        @foreach ($types as $value => $label)
                            <option value="{{ $value }}" {{ old('type', $newsNotice->type) === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>
                <div class="field">
                    <div class="field-top"><label class="field-label">Published Date</label></div>
                    <input type="date" name="published_at"
                           value="{{ old('published_at', optional($newsNotice->published_at)->format('Y-m-d')) }}"
                           class="{{ $errors->has('published_at') ? 'input-error' : '' }}">
                    @error('published_at')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-text-paragraph"></i></span> Description</h2>
            </div>
            <div class="field">
                <textarea name="description" rows="5"
                          class="{{ $errors->has('description') ? 'input-error' : '' }}"
                          placeholder="Short summary shown with the notice...">{{ old('description', $newsNotice->description) }}</textarea>
                @error('description')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Attachment --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-paperclip"></i></span> Attachment</h2>
            </div>
            <div class="notice caution">
                <i class="bi bi-exclamation-triangle" style="margin-top:1px;"></i>
                <p>Optional PDF file (e.g. the circular document) &middot; up to 10MB.</p>
            </div>

            @if ($newsNotice->attachment)
                <div class="attachment-current">
                    <i class="bi bi-file-earmark-pdf"></i>
                    <a href="{{ Storage::url($newsNotice->attachment) }}" target="_blank" rel="noopener">
                        {{ basename($newsNotice->attachment) }}
                    </a>
                    <button type="button" class="remove-attachment-btn" onclick="removeAttachment()">
                        <i class="bi bi-x-lg"></i>
                    </button>
                    <input type="hidden" name="remove_attachment" id="remove-attachment" value="0">
                </div>
            @endif

            <div class="field" style="margin-top: {{ $newsNotice->attachment ? '12px' : '0' }};">
                <input type="file" name="attachment" id="attachmentInput" accept="application/pdf"
                       class="{{ $errors->has('attachment') ? 'input-error' : '' }}">
                @error('attachment')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>


         <!-- <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-search"></i></span> SEO Meta</h2>
            </div>
            <p class="section-sub" style="margin:0 0 16px;">Used for search engine results and social share previews.</p>

            <div class="field">
                <div class="field-top">
                    <label class="field-label">Meta Title</label>
                    <span class="field-hint">Recommended under 60 chars</span>
                </div>
                <input type="text" name="meta_title" value="{{ old('meta_title', $newsNotice->meta_title) }}" maxlength="60"
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
                          placeholder="Enter meta description">{{ old('meta_description', $newsNotice->meta_description) }}</textarea>
                @error('meta_description')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div> -->

        {{-- Link --}}
        <!-- <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-link-45deg"></i></span> External Link</h2>
            </div>
            <div class="field">
                <input type="text" name="link" value="{{ old('link', $newsNotice->link) }}"
                       class="{{ $errors->has('link') ? 'input-error' : '' }}"
                       placeholder="https://example.com/notice-details">
                @error('link')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div> -->

        {{-- Toggles --}}
        <!-- <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-toggles"></i></span> Visibility</h2>
            </div>
            <label class="toggle-row">
                <input type="hidden" name="is_pinned" value="0">
                <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned', $newsNotice->is_pinned) ? 'checked' : '' }}>
                <span class="toggle-switch"></span>
                <span class="toggle-label">Pin this notice to the top</span>
            </label>
            <label class="toggle-row" style="margin-top:14px;">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $newsNotice->exists ? $newsNotice->is_active : true) ? 'checked' : '' }}>
                <span class="toggle-switch"></span>
                <span class="toggle-label">Active (visible on the website)</span>
            </label>
        </div> -->

        <div class="savebar">
            <div class="savebar-inner">
                <span class="savebar-status">Changes save to the live News &amp; Notices ticker</span>
                <div class="btn-group">
                    <a href="{{ route('admin.news-notices') }}" class="btn-cancel">Cancel</a>
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
function removeAttachment() {
    document.getElementById('remove-attachment').value = '1';
    document.querySelector('.attachment-current').style.display = 'none';
}

document.getElementById('noticeForm').addEventListener('submit', function (e) {
    e.preventDefault();
    submitNoticeForm();
});

function submitNoticeForm() {
    const form = document.getElementById('noticeForm');
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
            showValidationErrors(data.errors);
            return;
        }

        if (!response.ok) {
            throw new Error('Request failed');
        }

        Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: data && data.message ? data.message : 'Notice saved successfully.',
            confirmButtonColor: '#002F5F',
            timer: 2000,
            timerProgressBar: true
        }).then(() => {
            window.location.href = "{{ route('admin.news-notices') }}";
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
    const form = document.getElementById('noticeForm');
    const fieldMap = {
        title: f => f.querySelector('[name="title"]'),
        type: f => f.querySelector('[name="type"]'),
        published_at: f => f.querySelector('[name="published_at"]'),
        description: f => f.querySelector('[name="description"]'),
        attachment: f => document.getElementById('attachmentInput'),
        link: f => f.querySelector('[name="link"]'),
    };

    Object.keys(errors).forEach(field => {
        const message = errors[field][0];
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

<style>
 

    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span{ cursor:pointer; transition:color .15s; }
    .crumbs span:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:560px; line-height:1.55; }

    .section-title{ display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 4px;
    flex-wrap: wrap;
    gap: 6px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .icon{ display:inline-flex; color: var(--orange,#BF0001); }

    .field{ margin-bottom:0; flex:1; }
    .field-row{ display:flex; gap:16px; flex-wrap:wrap; }
    .field-top{ margin-bottom:8px; }
    .field-label{ display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: var(--ink, #171B2C);

}

.field-hint {
    font-size: 11.5px;
    color: var(--faint, #9AA1B2);
}


    input[type=text], input[type=date], input[type=file], textarea, select{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; transition:box-shadow .15s, border-color .15s; background:#fff;
    }
    input[type=text]:focus, input[type=date]:focus, textarea:focus, select:focus{
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

    .attachment-current{
        display:flex; align-items:center; gap:8px; background: var(--canvas,#F6F7FB);
        border:1px solid var(--line,#E9EBF2); border-radius:10px; padding:10px 12px; font-size:13.5px;
    }
    .attachment-current i.bi-file-earmark-pdf{ color:#e74c3c; font-size:16px; }
    .attachment-current a{ color: var(--ink,#171B2C); text-decoration:none; font-weight:500; }
    .attachment-current a:hover{ text-decoration:underline; }
    .remove-attachment-btn{
        margin-left:auto; width:26px; height:26px; border-radius:999px; border:none;
        background:#fdecea; color:#e74c3c; cursor:pointer; display:flex; align-items:center; justify-content:center;
        transition:background .15s;
    }
    .remove-attachment-btn:hover{ background:#f8d3d0; }

    .toggle-row{ display:flex; align-items:center; gap:12px; cursor:pointer; }
    .toggle-row input[type="checkbox"]{ position:absolute; opacity:0; width:0; height:0; }
    .toggle-switch{ position:relative; width:42px; height:24px; border-radius:999px; background:#DBDFEA; flex-shrink:0; transition:background .15s; }
    .toggle-switch::after{ content:''; position:absolute; top:2px; left:2px; width:20px; height:20px; border-radius:999px; background:#fff; box-shadow:0 1px 2px rgba(0,0,0,0.2); transition:transform .15s; }
    .toggle-row input[type="checkbox"]:checked + .toggle-switch{ background: var(--orange,#BF0001); }
    .toggle-row input[type="checkbox"]:checked + .toggle-switch::after{ transform:translateX(18px); }
    .toggle-label{ font-size:13.5px; color: var(--ink,#171B2C); }

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

         .req{ color: #BF0001; }

         .section-sub {
    font-size: 12px;
    color: var(--faint, #9AA1B2);
    margin: 0 0 16px;
}

.field {
    margin-bottom: 28px;
}
.field-top {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-bottom: 8px;
}

</style>

@endsection
