@extends('admin.layout')

@section('title', 'Homepage Popup')

@section('content')

@if (session('success'))
    <div class="pp-alert pp-ok"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="pp-alert pp-err">
        <i class="bi bi-exclamation-circle"></i>
        <div>@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    </div>
@endif

<form method="POST" action="{{ route('admin.home.popup.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="pp-grid">
        {{-- Left: settings --}}
        <div class="card">
            <div class="pp-head">
                <div>
                    <h2 class="pp-title">Popup settings</h2>
                    <p class="pp-sub">Shown once per visit when someone opens the home page.</p>
                </div>
                <label class="pp-switch">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $popup->is_active) ? 'checked' : '' }}>
                    <span class="pp-slider"></span>
                    <span class="pp-switch-txt">Show on website</span>
                </label>
            </div>

            <div class="pp-field">
                <label class="pp-label">Popup image <span class="pp-hint">JPG, PNG or WEBP, max 3 MB. Portrait (e.g. 800×1100) works best.</span></label>
                <label class="pp-drop" for="ppImage">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <span id="ppFileName">{{ $popup->image ? 'Choose a new image to replace the current one' : 'Click to choose an image' }}</span>
                    <input type="file" id="ppImage" name="image" accept="image/jpeg,image/png,image/webp">
                </label>
                @if ($popup->image)
                    <label class="pp-check">
                        <input type="checkbox" name="remove_image" value="1"> Remove current image (also switches the popup off)
                    </label>
                @endif
            </div>

            <div class="pp-field">
                <label class="pp-label" for="ppTitle">Title <span class="pp-hint">Optional. Used as alt text, e.g. "Admissions Open 2027-28".</span></label>
                <input class="pp-input" type="text" id="ppTitle" name="title" maxlength="150" value="{{ old('title', $popup->title) }}">
            </div>

            <div class="pp-field">
                <label class="pp-label" for="ppLink">Link when clicked <span class="pp-hint">Leave empty to open the admission form.</span></label>
                <input class="pp-input" type="text" id="ppLink" name="link" maxlength="500"
                       placeholder="{{ route('admission') }}#admission-form" value="{{ old('link', $popup->link) }}">
            </div>

            <div class="pp-row">
                <div class="pp-field">
                    <label class="pp-label" for="ppFrom">Show from <span class="pp-hint">Optional</span></label>
                    <input class="pp-input" type="date" id="ppFrom" name="starts_on" value="{{ old('starts_on', $popup->starts_on?->format('Y-m-d')) }}">
                </div>
                <div class="pp-field">
                    <label class="pp-label" for="ppUntil">Show until <span class="pp-hint">Optional</span></label>
                    <input class="pp-input" type="date" id="ppUntil" name="ends_on" value="{{ old('ends_on', $popup->ends_on?->format('Y-m-d')) }}">
                </div>
            </div>

            <button type="submit" class="pp-btn"><i class="bi bi-check2"></i> Save popup</button>
        </div>

        {{-- Right: preview --}}
        <div class="card pp-preview-card">
            <h2 class="pp-title">Preview</h2>
            <p class="pp-sub">
                Status:
                @if (\App\Models\HomePopup::current())
                    <span class="pp-badge pp-live">Live on website</span>
                @elseif ($popup->is_active)
                    <span class="pp-badge pp-wait">On, but outside the date range</span>
                @else
                    <span class="pp-badge pp-off">Off</span>
                @endif
            </p>
            <div class="pp-stage">
                <div class="pp-modal">
                    <span class="pp-x">&times;</span>
                    <img id="ppPreview" src="{{ $popup->image_url }}" alt="" {{ $popup->image ? '' : 'hidden' }}>
                    <div id="ppEmpty" class="pp-empty" {{ $popup->image ? 'hidden' : '' }}>
                        <i class="bi bi-image"></i><span>No image yet</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('styles')
<style>
    .pp-grid { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr); gap: 20px; align-items: start; }
    @media (max-width: 1100px) { .pp-grid { grid-template-columns: 1fr; } }

    .pp-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap; margin-bottom: 22px; }
    .pp-title { margin: 0; font-size: 17px; }
    .pp-sub { margin: 4px 0 0; font-size: 13px; color: var(--muted); }

    .pp-field { margin-bottom: 18px; }
    .pp-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    @media (max-width: 560px) { .pp-row { grid-template-columns: 1fr; } }
    .pp-label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 7px; }
    .pp-hint { display: block; font-weight: 400; color: var(--faint); font-size: 12px; margin-top: 2px; }
    .pp-input {
        width: 100%; padding: 10px 12px; border: 1px solid var(--input-border); border-radius: 9px;
        font: inherit; font-size: 14px; color: var(--ink); background: #fff;
    }
    .pp-input:focus { outline: none; border-color: var(--orange); box-shadow: 0 0 0 3px var(--orange-tint); }

    .pp-drop {
        display: flex; align-items: center; gap: 10px; padding: 18px; cursor: pointer;
        border: 1.5px dashed var(--input-border); border-radius: 12px; background: var(--canvas);
        font-size: 13.5px; color: var(--muted); transition: border-color .15s;
    }
    .pp-drop:hover { border-color: var(--orange); }
    .pp-drop i { font-size: 22px; color: var(--orange); }
    .pp-drop input { display: none; }
    .pp-check { display: flex; align-items: center; gap: 8px; margin-top: 10px; font-size: 13px; color: var(--muted); }

    .pp-switch { display: inline-flex; align-items: center; gap: 10px; cursor: pointer; }
    .pp-switch input[type=checkbox] { display: none; }
    .pp-slider { width: 42px; height: 24px; border-radius: 99px; background: #D5D9E3; position: relative; transition: background .2s; }
    .pp-slider::after { content: ""; position: absolute; top: 3px; left: 3px; width: 18px; height: 18px; border-radius: 50%; background: #fff; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
    .pp-switch input:checked + .pp-slider { background: var(--green); }
    .pp-switch input:checked + .pp-slider::after { transform: translateX(18px); }
    .pp-switch-txt { font-size: 13.5px; font-weight: 600; }

    .pp-btn {
        display: inline-flex; align-items: center; gap: 7px; padding: 11px 22px; border: 0; border-radius: 9px;
        background: var(--orange); color: #fff; font: inherit; font-size: 14px; font-weight: 600; cursor: pointer;
    }
    .pp-btn:hover { background: var(--navy-hover); }

    .pp-badge { display: inline-block; padding: 2px 10px; border-radius: 99px; font-size: 12px; font-weight: 600; }
    .pp-live { background: var(--green-tint); color: var(--green); }
    .pp-wait { background: #FFF4DB; color: #A86A00; }
    .pp-off  { background: var(--canvas); color: var(--muted); }

    .pp-stage { margin-top: 16px; padding: 28px 16px; border-radius: 12px; background: rgba(15,21,38,.72); display: flex; justify-content: center; }
    .pp-modal { position: relative; background: #fff; padding: 10px; border-radius: 10px; max-width: 320px; width: 100%; }
    .pp-modal img { display: block; width: 100%; height: auto; border-radius: 4px; }
    .pp-x { position: absolute; top: -12px; right: -12px; width: 28px; height: 28px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px; line-height: 1; box-shadow: 0 2px 8px rgba(0,0,0,.3); }
    .pp-empty { aspect-ratio: 3 / 4; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; color: var(--faint); background: var(--canvas); border-radius: 4px; }
    .pp-empty i { font-size: 34px; }
    .pp-empty[hidden], .pp-modal img[hidden] { display: none; }
    .pp-alert { display: flex; gap: 10px; align-items: flex-start; padding: 12px 16px; border-radius: 10px; margin-bottom: 18px; font-size: 14px; }
    .pp-ok  { background: var(--green-tint); color: var(--green); }
    .pp-err { background: #FDE8EA; color: #B42335; }
</style>
@endpush

@push('scripts')
<script>
    (function () {
        var input = document.getElementById('ppImage');
        if (!input) return;
        input.addEventListener('change', function () {
            var f = input.files && input.files[0];
            if (!f) return;
            document.getElementById('ppFileName').textContent = f.name;
            var img = document.getElementById('ppPreview');
            img.src = URL.createObjectURL(f);
            img.hidden = false;
            document.getElementById('ppEmpty').hidden = true;
        });
    })();
</script>
@endpush
