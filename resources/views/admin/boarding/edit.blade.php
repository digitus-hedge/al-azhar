@extends('admin.layout')
@section('title', 'Boarding & Fees')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($errors->any())
<div class="notice caution" style="margin-bottom:20px;">
    <i class="bi bi-exclamation-triangle" style="font-size:15px;flex-shrink:0;margin-top:1px;"></i>
    <div>
        <p style="margin-bottom:4px;"><b>Please fix the following before saving:</b></p>
        <ul class="err-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

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

@php
    $images = $boarding->images ?? [];
    $videos = $boarding->videos ?? [];
@endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <b>Boarding &amp; Fees</b>
    </div>

    <div class="header">
        <div>
            <h1>Boarding &amp; Fees</h1>
            <p>Content for the public Boarding page: heading, description, photos, videos and the fees payment QR code.</p>
        </div>
    </div>

    <form action="{{ route('admin.boarding.update') }}" method="POST" enctype="multipart/form-data" id="boardingForm">
        @csrf

        {{-- ================= Page content ================= --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-house-heart"></i></span> Page Content</h2>
            </div>

            <div class="field">
                <label for="title">Title <span class="req">*</span></label>
                <input type="text" id="title" name="title" maxlength="191"
                       value="{{ old('title', $boarding->title) }}"
                       placeholder="e.g. Where Safety, Discipline, and Nourishment Define Home Away from Home!"
                       class="{{ $errors->has('title') ? 'input-error' : '' }}">
                @error('title') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" maxlength="5000"
                          placeholder="Describe the hostel facilities, rules and food arrangements…"
                          class="{{ $errors->has('description') ? 'input-error' : '' }}">{{ old('description', $boarding->description) }}</textarea>
                <span class="hint">Leave a blank line between paragraphs.</span>
                @error('description') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        {{-- ================= Images ================= --}}
       @php
    $removedOld = (array) old('remove_images', []);
@endphp

<div class="card">
    <div class="section-title">
        <h2><span class="icon"><i class="bi bi-images"></i></span> Images</h2>
        <span class="section-sub"><span id="existingCount">{{ count(array_diff($images, $removedOld)) }}</span> uploaded</span>
    </div>

    {{-- Keeps removed photos removed if the form reloads with errors --}}
    <div id="removedImageInputs">
        @foreach ($removedOld as $path)
            <input type="hidden" name="remove_images[]" value="{{ $path }}">
        @endforeach
    </div>

    @if (count($images))
        <div class="media-grid" id="existingImages">
            @foreach ($images as $path)
                @continue(in_array($path, $removedOld, true))
                <div class="media-item" data-path="{{ $path }}">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($path) }}" alt="">
                    <button type="button" class="item-remove" title="Remove photo"
                            onclick="removeExistingImage(this)">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            @endforeach
        </div>
        <p class="hint" style="margin:10px 0 18px;">Click <i class="bi bi-x-lg"></i> to remove a photo. It is deleted when you save.</p>
    @endif

    <label class="drop" for="images" id="imageDrop">
        <i class="bi bi-cloud-arrow-up"></i>
        <span><b>Add photos</b> — click or drag &amp; drop. Select several at once, and add more as many times as you like. JPG, PNG or WebP, up to 5 MB each.</span>
        <input type="file" id="images" name="images[]" accept="image/jpeg,image/png,image/webp" multiple hidden>
    </label>
    <div class="picker-bar" id="imageBar" hidden>
        <span><b id="imageCount">0</b> new photo(s) ready to upload</span>
        <button type="button" class="link-btn" id="imageClear"><i class="bi bi-x-circle"></i> Clear all</button>
    </div>
    <div class="media-grid new-previews" id="imagePreviews"></div>
    @error('images') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
    @error('images.*') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
</div>

        {{-- ================= Videos ================= --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-camera-video"></i></span> Videos</h2>
                <span class="section-sub">{{ count($videos) }} added</span>
            </div>

            @if (count($videos))
                <ul class="video-list">
                    @foreach ($videos as $i => $video)
                        <li class="video-row">
                            <span class="video-ico">
                                <i class="bi {{ ($video['type'] ?? '') === 'file' ? 'bi-film' : 'bi-youtube' }}"></i>
                            </span>
                            <span class="video-src">
                                @if (($video['type'] ?? '') === 'file')
                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($video['src']) }}" target="_blank" rel="noopener">{{ basename($video['src']) }}</a>
                                    <small>Uploaded file</small>
                                @else
                                    <a href="{{ $video['src'] }}" target="_blank" rel="noopener">{{ $video['src'] }}</a>
                                    <small>Video link</small>
                                @endif
                            </span>
                            <label class="video-remove">
                                <input type="checkbox" name="remove_videos[]" value="{{ $i }}"
                                       @checked(in_array((string) $i, array_map('strval', (array) old('remove_videos', [])), true))>
                                Remove
                            </label>
                        </li>
                    @endforeach
                </ul>
            @endif

            @php
                $oldLinks = array_values((array) old('video_links', []));
                if (! count($oldLinks)) { $oldLinks = ['']; }
            @endphp

            <div class="two-col">
                {{-- Links: one row per video, add as many as needed --}}
                <div class="field">
                    <label>YouTube / Vimeo links</label>
                    <div class="link-rows" id="linkRows">
                        @foreach ($oldLinks as $i => $link)
                            <div class="link-row">
                                <span class="link-badge"><i class="bi bi-link-45deg"></i></span>
                                <input type="url" name="video_links[]" value="{{ $link }}" maxlength="500"
                                       placeholder="https://www.youtube.com/watch?v=…"
                                       class="{{ $errors->has("video_links.$i") ? 'input-error' : '' }}">
                                <button type="button" class="row-remove" aria-label="Remove link"><i class="bi bi-x-lg"></i></button>
                            </div>
                            @error("video_links.$i") <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                        @endforeach
                    </div>
                    <button type="button" class="add-btn" id="addLink"><i class="bi bi-plus-lg"></i> Add another link</button>
                    @error('video_links') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>

                {{-- Files: pick several, add more any time --}}
                <div class="field">
                    <label>Upload video files</label>
                    <label class="drop drop-sm" for="video_files" id="videoDrop">
                        <i class="bi bi-film"></i>
                        <span><b>Add videos</b> — click or drag &amp; drop, add more any time. MP4, WebM or MOV, up to 50 MB each.</span>
                        <input type="file" id="video_files" name="video_files[]" accept="video/mp4,video/webm,video/quicktime" multiple hidden>
                    </label>
                    <ul class="file-names" id="videoNames"></ul>
                    @error('video_files') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                    @error('video_files.*') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>
            </div>

            <template id="linkTpl">
                <div class="link-row">
                    <span class="link-badge"><i class="bi bi-link-45deg"></i></span>
                    <input type="url" name="video_links[]" maxlength="500" placeholder="https://www.youtube.com/watch?v=…">
                    <button type="button" class="row-remove" aria-label="Remove link"><i class="bi bi-x-lg"></i></button>
                </div>
            </template>
            <p class="hint" style="margin:6px 0 0;">Links are easier and faster for visitors. Large uploads may also need a higher upload limit on the server.</p>
        </div>

        {{-- ================= Fees & QR ================= --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-qr-code"></i></span> Fees &amp; Payment QR</h2>
            </div>

            <div class="two-col">
                <div>
                    <div class="field">
                        <label for="fees_title">Fees heading</label>
                        <input type="text" id="fees_title" name="fees_title" maxlength="191"
                               value="{{ old('fees_title', $boarding->fees_title) }}"
                               placeholder="e.g. Fees structure 2024-2025"
                               class="{{ $errors->has('fees_title') ? 'input-error' : '' }}">
                        @error('fees_title') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label for="qr_caption">Text under the QR code</label>
                        <input type="text" id="qr_caption" name="qr_caption" maxlength="191"
                               value="{{ old('qr_caption', $boarding->qr_caption) }}"
                               placeholder="e.g. Al Azhar Central School Mala"
                               class="{{ $errors->has('qr_caption') ? 'input-error' : '' }}">
                        @error('qr_caption') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="field">
                    <label>Payment QR code</label>
                    <div class="qr-box">
                        <div class="qr-preview" id="qrPreview">
                            @if ($boarding->qr_url)
                                <img src="{{ $boarding->qr_url }}" alt="Fees QR code">
                            @else
                                <span class="qr-empty"><i class="bi bi-qr-code"></i>No QR yet</span>
                            @endif
                        </div>
                        <div class="qr-actions">
                            <label class="btn-light" for="fees_qr"><i class="bi bi-upload"></i> {{ $boarding->qr_url ? 'Replace QR' : 'Upload QR' }}</label>
                            <input type="file" id="fees_qr" name="fees_qr" accept="image/jpeg,image/png,image/webp" hidden>
                            @if ($boarding->qr_url)
                                <label class="check-inline">
                                    <input type="checkbox" name="remove_qr" value="1" @checked(old('remove_qr'))> Remove QR code
                                </label>
                            @endif
                            <span class="hint">PNG or JPG, up to 2 MB</span>
                        </div>
                    </div>
                    @error('fees_qr') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="savebar">
            <div class="savebar-inner">
                <span class="savebar-status">All changes save to the live Boarding page</span>
                <div class="btn-group">
                    <a href="{{ route('admin.dashboard') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save" id="saveBtn">
                        <i class="bi bi-check-lg"></i>
                        <span>Save</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span:first-child{ cursor:pointer; transition:color .15s; }
    .crumbs span:first-child:hover{ color: var(--orange,#002F5F); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; line-height:1.55; }

    .section-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; flex-wrap:wrap; gap:6px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .icon{ display:inline-flex; color: var(--orange,#002F5F); }
    .section-sub{ font-size:12px; color: var(--faint,#9AA1B2); }

    .field{ display:flex; flex-direction:column; margin-bottom:18px; }
    .field:last-child{ margin-bottom:0; }
    .field label{ font-size:12.5px; font-weight:600; color: var(--ink,#171B2C); margin-bottom:7px; }
    .field input[type=text], .field textarea{
        padding:10px 12px; border:1px solid var(--input-border,#DBDFEA); border-radius:8px;
        font-size:14px; outline:none; width:100%; font-family:inherit; color: var(--ink,#171B2C);
        transition:box-shadow .15s, border-color .15s; resize:vertical;
    }
    .field input:focus, .field textarea:focus{ border-color: var(--orange,#002F5F); box-shadow:0 0 0 4px var(--orange-tint-strong,#E7ECF1); }
    .field .input-error{ border-color:#e74c3c !important; background:#fff8f8; }
    .hint{ font-size:12px; color: var(--faint,#9AA1B2); margin-top:6px; }
    .req{ color:#BF0001; }
    .field-error{ display:flex; align-items:center; gap:5px; color:#e74c3c; font-size:12px; margin-top:6px; }

    .two-col{ display:grid; grid-template-columns:1fr 1fr; gap:24px; }

    /* Media grid */
    .media-grid{ display:grid; grid-template-columns:repeat(auto-fill, minmax(140px, 1fr)); gap:12px; }
    .media-item{ position:relative; display:block; border-radius:10px; overflow:hidden; cursor:pointer;
        aspect-ratio:1 / 1; background: var(--canvas,#F6F7FB); border:2px solid transparent; transition:border-color .15s; }
    .media-item img{ width:100%; height:100%; object-fit:cover; display:block; transition:opacity .15s, filter .15s; }
    .media-item .remove-check{ position:absolute; opacity:0; pointer-events:none; }
    .media-item .remove-tag{
        position:absolute; left:8px; right:8px; bottom:8px; display:flex; align-items:center; justify-content:center; gap:5px;
        padding:5px; border-radius:6px; font-size:11.5px; font-weight:600; color:#fff; background:rgba(15,21,38,.65);
        opacity:0; transition:opacity .15s;
    }
    .media-item:hover .remove-tag{ opacity:1; }
    .media-item:has(.remove-check:checked){ border-color:#e74c3c; }
    .media-item:has(.remove-check:checked) img{ opacity:.35; filter:grayscale(1); }
    .media-item:has(.remove-check:checked) .remove-tag{ opacity:1; background:#e74c3c; }

    .new-previews:not(:empty){ margin-top:12px; }
    .new-previews .media-item{ cursor:default; }
    .new-previews .new-tag{ position:absolute; top:8px; left:8px; padding:2px 8px; border-radius:6px; font-size:11px; font-weight:700;
        color:#fff; background: var(--green,#12875A); }

    /* Drop zone */
    .drop{
        display:flex; align-items:center; justify-content:center; gap:10px; padding:22px; border-radius:10px; cursor:pointer;
        border:2px dashed var(--input-border,#DBDFEA); background: var(--canvas,#F6F7FB);
        font-size:13px; color: var(--muted,#667085); transition:border-color .15s, background .15s; text-align:center;
    }
    .drop i{ font-size:20px; color: var(--orange,#002F5F); }
    .drop b{ color: var(--ink,#171B2C); }
    .drop:hover{ border-color: var(--orange,#002F5F); background:#fff; }
    .drop-sm{ padding:18px; }

    /* Videos */
    .video-list{ list-style:none; padding:0; margin:0 0 20px; border:1px solid var(--line,#E9EBF2); border-radius:10px; }
    .video-row{ display:flex; align-items:center; gap:12px; padding:12px 14px; }
    .video-row + .video-row{ border-top:1px solid var(--line,#E9EBF2); }
    .video-ico{ width:36px; height:36px; border-radius:8px; flex:none; display:flex; align-items:center; justify-content:center;
        background: var(--orange-tint,#E7ECF1); color: var(--orange,#002F5F); }
    .video-src{ flex:1; min-width:0; display:flex; flex-direction:column; }
    .video-src a{ font-size:13.5px; color: var(--ink,#171B2C); text-decoration:none; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .video-src a:hover{ color: var(--orange,#002F5F); text-decoration:underline; }
    .video-src small{ font-size:11.5px; color: var(--faint,#9AA1B2); }
    .video-remove{ display:flex; align-items:center; gap:6px; font-size:12.5px; color:#e74c3c; cursor:pointer; flex:none; }
    .video-row:has(input:checked){ background:#fff8f8; }
    .video-row:has(input:checked) .video-src a{ text-decoration:line-through; opacity:.6; }
    .file-names{ list-style:none; padding:0; margin:8px 0 0; font-size:12.5px; color: var(--muted,#667085); }
    .file-names li{ display:flex; align-items:center; gap:6px; padding:3px 0; }


    /* Multi-picker */
    .drop.is-over{ border-color: var(--orange,#002F5F); background:#fff; }
    .picker-bar{ display:flex; align-items:center; justify-content:space-between; gap:10px; margin-top:12px; font-size:12.5px; color: var(--muted,#667085); }
    .picker-bar[hidden]{ display:none; }
    .picker-bar b{ color: var(--ink,#171B2C); }
    .link-btn{ display:inline-flex; align-items:center; gap:5px; border:0; background:none; color:#e74c3c; font-size:12.5px; font-weight:600; cursor:pointer; padding:4px 6px; border-radius:6px; }
    .link-btn:hover{ background:#fff1f1; }
    .new-previews .item-remove{
        position:absolute; top:6px; right:6px; width:26px; height:26px; border-radius:50%; border:0; cursor:pointer;
        display:flex; align-items:center; justify-content:center; background:rgba(15,21,38,.7); color:#fff; font-size:12px;
    }
    .new-previews .item-remove:hover{ background:#e74c3c; }
    .file-names li{ justify-content:space-between; background: var(--canvas,#F6F7FB); border-radius:8px; padding:7px 10px; margin-bottom:6px; }
    .file-names .fn{ display:flex; align-items:center; gap:6px; min-width:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .file-names .row-remove{ width:26px; height:26px; }

    /* Link rows */
    .link-rows{ display:flex; flex-direction:column; gap:8px; }
    .link-row{ display:flex; align-items:center; gap:8px; }
    .link-row input{
        flex:1; min-width:0; padding:10px 12px; border:1px solid var(--input-border,#DBDFEA); border-radius:8px;
        font-size:14px; outline:none; font-family:inherit; color: var(--ink,#171B2C); transition:box-shadow .15s, border-color .15s;
    }
    .link-row input:focus{ border-color: var(--orange,#002F5F); box-shadow:0 0 0 4px var(--orange-tint-strong,#E7ECF1); }
    .link-row input.input-error{ border-color:#e74c3c; background:#fff8f8; }
    .link-badge{ width:36px; height:38px; flex:none; border-radius:8px; display:flex; align-items:center; justify-content:center;
        background: var(--canvas,#F6F7FB); color: var(--faint,#9AA1B2); font-size:17px; transition:.15s; }
    .link-row.is-yt .link-badge{ background:#ffecec; color:#e62117; }
    .link-row.is-vimeo .link-badge{ background:#e8f7fd; color:#1ab7ea; }
    .link-row.is-bad .link-badge{ background:#fff4e5; color:#c77700; }
    .row-remove{ width:34px; height:34px; flex:none; border-radius:8px; border:1px solid var(--line,#E9EBF2); background:#fff;
        color: var(--muted,#667085); cursor:pointer; display:flex; align-items:center; justify-content:center; transition:.15s; }
    .row-remove:hover{ border-color:#e74c3c; color:#e74c3c; background:#fff8f8; }
    .add-btn{ align-self:flex-start; display:inline-flex; align-items:center; gap:6px; margin-top:10px; padding:8px 14px; border-radius:8px;
        border:1px dashed var(--orange,#002F5F); background:#fff; color: var(--orange,#002F5F); font-size:13px; font-weight:600; cursor:pointer; transition:.15s; }
    .add-btn:hover{ background: var(--orange-tint,#E7ECF1); }

    /* QR */
    .qr-box{ display:flex; gap:18px; align-items:center; }
    .qr-preview{ width:150px; height:150px; flex:none; border-radius:12px; overflow:hidden; border:1px solid var(--line,#E9EBF2);
        background: var(--canvas,#F6F7FB); display:flex; align-items:center; justify-content:center; }
    .qr-preview img{ width:100%; height:100%; object-fit:contain; background:#fff; }
    .qr-empty{ display:flex; flex-direction:column; align-items:center; gap:6px; font-size:12px; color: var(--faint,#9AA1B2); }
    .qr-empty i{ font-size:34px; }
    .qr-actions{ display:flex; flex-direction:column; align-items:flex-start; gap:10px; }
    .btn-light{ display:inline-flex; align-items:center; gap:7px; padding:9px 16px; border-radius:9px; cursor:pointer;
        border:1px solid var(--orange,#002F5F); color: var(--orange,#002F5F); background:#fff; font-size:13px; font-weight:600; transition:.15s; }
    .btn-light:hover{ background: var(--orange,#002F5F); color:#fff; }
    .check-inline{ display:flex; align-items:center; gap:6px; font-size:12.5px; color:#e74c3c; cursor:pointer; }

    /* Notice */
    .notice{ display:flex; align-items:flex-start; gap:8px; background: var(--canvas,#F6F7FB); border-radius:10px; padding:10px 12px; }
    .notice.caution{ background:#FFF8E8; border:1px solid #F5E3B3; }
    .notice.caution i{ color:#B7791F; }
    .notice.caution p, .notice.caution li{ color:#8A6116; margin:0; font-size:12px; }
    .err-list{ margin:0; padding-left:16px; }

    /* Save bar */
    .savebar{
        position:sticky; bottom:0; border-top:1px solid var(--line,#E9EBF2);
        background:rgba(255,255,255,0.92); backdrop-filter:blur(6px);
        margin:24px -32px -32px; padding:0 32px; z-index:4;
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
        transition:transform .12s ease, box-shadow .12s ease, opacity .15s;
    }
    .btn-save:hover{ transform:translateY(-1px); box-shadow:0 8px 18px -6px rgba(15,21,38,0.5); }
    .btn-save[disabled]{ opacity:.7; pointer-events:none; }

    @media (max-width:900px){
        .two-col{ grid-template-columns:1fr; gap:0; }
        .two-col > .field, .two-col > div{ margin-bottom:18px; }
    }
    @media (max-width:700px){ .savebar{ margin:20px -20px -20px; padding:0 20px; } }
    @media (max-width:560px){
        .savebar{ margin:14px -14px -14px; padding:0 14px; }
        .qr-box{ flex-direction:column; align-items:flex-start; }
        .media-grid{ grid-template-columns:repeat(3, 1fr); gap:8px; }
    }


    .media-item { position: relative; }
.media-item .item-remove {
    position: absolute; top: 6px; right: 6px;
    width: 28px; height: 28px; border-radius: 999px;
    background: rgba(0,0,0,0.6); color: #fff; border: none;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 12px; z-index: 2;
}
.media-item .item-remove:hover { background: #C62828; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* --------------------------------------------------------------
       Multi-file picker: every new selection (or drag & drop) is ADDED
       to the list instead of replacing it. Each file can be removed.
       -------------------------------------------------------------- */
    function multiPicker(cfg) {
        var input = document.getElementById(cfg.input);
        var drop  = document.getElementById(cfg.drop);
        var store = [];
        var accept = (input.getAttribute('accept') || '').split(',').map(function (s) { return s.trim(); });

        function key(f) { return f.name + '|' + f.size + '|' + f.lastModified; }
        function okType(f) { return !accept.length || accept.indexOf(f.type) !== -1; }

        function sync() {
            var dt = new DataTransfer();
            store.forEach(function (f) { dt.items.add(f); });
            input.files = dt.files;
            cfg.render(store, remove);
        }
        function add(files) {
            var skipped = 0, full = false;
            Array.prototype.forEach.call(files, function (f) {
                if (!okType(f)) { skipped++; return; }
                if (store.some(function (s) { return key(s) === key(f); })) return;
                if (store.length >= cfg.max) { full = true; return; }
                store.push(f);
            });
            sync();
            if (full)    Swal.fire({ icon: 'info', title: 'Limit reached', text: 'You can add up to ' + cfg.max + ' ' + cfg.label + ' per save.', confirmButtonColor: '#002F5F' });
            if (skipped) Swal.fire({ icon: 'warning', title: 'Some files skipped', text: skipped + ' file(s) were not a supported type.', confirmButtonColor: '#002F5F' });
        }
        function remove(i) { store.splice(i, 1); sync(); }
        function clear() { store = []; sync(); }

        input.addEventListener('change', function () { add(input.files); });

        ['dragenter', 'dragover'].forEach(function (ev) {
            drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.add('is-over'); });
        });
        ['dragleave', 'drop'].forEach(function (ev) {
            drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.remove('is-over'); });
        });
        drop.addEventListener('drop', function (e) { if (e.dataTransfer) add(e.dataTransfer.files); });

        return { clear: clear };
    }

    /* ----- Photos ----- */
    var imgBox = document.getElementById('imagePreviews');
    var images = multiPicker({
        input: 'images', drop: 'imageDrop', max: 20, label: 'photos',
        render: function (files, remove) {
            imgBox.innerHTML = '';
            files.forEach(function (file, i) {
                var item = document.createElement('div');
                item.className = 'media-item';
                var img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.onload = function () { URL.revokeObjectURL(img.src); };
                var tag = document.createElement('span');
                tag.className = 'new-tag';
                tag.textContent = 'New';
                var x = document.createElement('button');
                x.type = 'button'; x.className = 'item-remove'; x.title = 'Remove';
                x.innerHTML = '<i class="bi bi-x-lg"></i>';
                x.addEventListener('click', function () { remove(i); });
                item.append(img, tag, x);
                imgBox.appendChild(item);
            });
            document.getElementById('imageCount').textContent = files.length;
            document.getElementById('imageBar').hidden = files.length === 0;
        }
    });
    document.getElementById('imageClear').addEventListener('click', function () { images.clear(); });

    /* ----- Video files ----- */
    var vidList = document.getElementById('videoNames');
    multiPicker({
        input: 'video_files', drop: 'videoDrop', max: 5, label: 'video files',
        render: function (files, remove) {
            vidList.innerHTML = '';
            files.forEach(function (file, i) {
                var li = document.createElement('li');
                var name = document.createElement('span');
                name.className = 'fn';
                name.innerHTML = '<i class="bi bi-film"></i> ';
                name.appendChild(document.createTextNode(file.name + ' (' + (file.size / 1048576).toFixed(1) + ' MB)'));
                var x = document.createElement('button');
                x.type = 'button'; x.className = 'row-remove'; x.title = 'Remove';
                x.innerHTML = '<i class="bi bi-x-lg"></i>';
                x.addEventListener('click', function () { remove(i); });
                li.append(name, x);
                vidList.appendChild(li);
            });
        }
    });

    /* ----- Video links: add / remove rows, live YouTube / Vimeo check ----- */
    var rows = document.getElementById('linkRows');
    var tpl  = document.getElementById('linkTpl');
    var ytRe = /(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)[A-Za-z0-9_-]{11}/;
    var vmRe = /vimeo\.com\/(?:video\/)?\d+/;

    function check(row) {
        var v = row.querySelector('input').value.trim();
        var icon = row.querySelector('.link-badge i');
        row.classList.remove('is-yt', 'is-vimeo', 'is-bad');
        if (!v)               { icon.className = 'bi bi-link-45deg'; return; }
        if (ytRe.test(v))     { row.classList.add('is-yt');    icon.className = 'bi bi-youtube'; }
        else if (vmRe.test(v)){ row.classList.add('is-vimeo'); icon.className = 'bi bi-vimeo'; }
        else                  { row.classList.add('is-bad');   icon.className = 'bi bi-exclamation-triangle'; }
    }
    rows.querySelectorAll('.link-row').forEach(check);

    rows.addEventListener('input', function (e) {
        var row = e.target.closest('.link-row');
        if (row) check(row);
    });
    rows.addEventListener('click', function (e) {
        var btn = e.target.closest('.row-remove');
        if (!btn) return;
        var row = btn.closest('.link-row');
        var err = row.nextElementSibling;
        if (err && err.classList.contains('field-error')) err.remove();
        if (rows.querySelectorAll('.link-row').length > 1) {
            row.remove();
        } else {
            row.querySelector('input').value = '';   // keep one empty row
            check(row);
        }
    });
    document.getElementById('addLink').addEventListener('click', function () {
        if (rows.querySelectorAll('.link-row').length >= 20) {
            Swal.fire({ icon: 'info', title: 'Limit reached', text: 'You can add up to 20 links per save.', confirmButtonColor: '#002F5F' });
            return;
        }
        rows.appendChild(tpl.content.cloneNode(true));
        rows.lastElementChild.querySelector('input').focus();
    });

    /* ----- QR preview ----- */
    var qrInput = document.getElementById('fees_qr');
    var qrBox   = document.getElementById('qrPreview');
    qrInput.addEventListener('change', function () {
        if (!qrInput.files[0]) return;
        qrBox.innerHTML = '';
        var img = document.createElement('img');
        img.src = URL.createObjectURL(qrInput.files[0]);
        img.alt = 'New QR code';
        qrBox.appendChild(img);
    });

    /* ----- Prevent double submit ----- */
    document.getElementById('boardingForm').addEventListener('submit', function () {
        var btn = document.getElementById('saveBtn');
        btn.disabled = true;
        btn.querySelector('span').textContent = 'Saving…';
    });
});


</script>
<script>
function removeExistingImage(btn) {
    const item = btn.closest('.media-item');

    const input = document.createElement('input');
    input.type  = 'hidden';
    input.name  = 'remove_images[]';
    input.value = item.dataset.path;
    document.getElementById('removedImageInputs').appendChild(input);

    item.remove();

    const countEl = document.getElementById('existingCount');
    if (countEl) {
        countEl.textContent = document.querySelectorAll('#existingImages .media-item').length;
    }
}
</script>
@endsection