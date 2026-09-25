@extends('web.layouts.app')

@section('title', 'Mandatory Public Disclosure || AL-Azhar')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@php
    $groups      = $groups ?? collect();
    $total       = $total ?? 0;
    $lastUpdated = $lastUpdated ?? null;
@endphp

@section('content')

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
        data-src="{{ asset('uploads/website-images/students-after-graduation-ceremony.jpg') }}">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">Mandatory Public Disclosure</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Mandatory Disclosure</li>
                </ol>
            </div>
        </div>
        <div class="td_page_heading_shape_1 position-absolute td_hover_layer_3"></div>
        <div class="td_page_heading_shape_2 position-absolute td_hover_layer_5"></div>
        @foreach (['td_page_heading_shape_3', 'td_page_heading_shape_4'] as $shape)
            <span class="{{ $shape }} position-absolute">
                <svg width="58" height="49" viewBox="0 0 58 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.2"
                        d="M2.00391 46.9086C8.15358 39.6828 13.0063 31.1947 17.3986 22.8314C17.7378 22.1855 24.3145 8.7469 25.3114 7.19042C30.3973 -0.749718 29.5578 15.0972 29.5911 15.9962C29.6605 17.8644 29.7062 28.9991 29.7143 31.6371C29.729 36.4089 29.5594 35.5953 29.9606 31.4832C30.5072 25.8808 31.0938 21.6345 31.9927 15.9346C32.4274 13.1779 32.8769 10.4226 33.409 7.68305C33.7667 5.84148 34.2728 0.65867 35.1332 2.32571C36.2755 4.53885 35.6173 7.28718 35.6874 9.77672C35.8174 14.3916 34.9248 20.0463 35.9337 24.5864C36.2728 26.1124 36.7224 21.5597 37.0421 20.0296C37.0843 19.828 38.2738 9.93996 40.86 14.9493C42.2649 17.6706 43.9104 24.5791 44.4932 27.1419C44.7774 28.3918 45.7668 40.064 47.8184 41.0587C48.6263 41.4504 55.6961 24.5153 56.3163 23.0777"
                        stroke="white" stroke-width="3" stroke-linecap="round" />
                </svg>
            </span>
        @endforeach
        <span class="td_page_heading_shape_5 position-absolute">
            <svg width="154" height="134" viewBox="0 0 154 134" fill="none" xmlns="http://www.w3.org/2000/svg">
                @foreach ([3.014, 33.154, 61.858, 91.998, 120.846, 150.986] as $cx)
                    @foreach ([3.01, 28.663, 54.46, 80.257, 105.194, 130.99] as $cy)
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="3.014" fill="#A7A7CA" />
                    @endforeach
                @endforeach
            </svg>
        </span>
        <div class="td_page_heading_shape_6 position-absolute td_hover_layer_3"></div>
    </section>
    <!-- End Page Heading Section -->

    <section class="md_section">
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">

            {{-- Intro --}}
            <div class="td_section_heading td_style_1 text-center">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase md_accent">
                    <i></i> As per CBSE Norms <i></i>
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">Mandatory Public Disclosure</h2>
                <div class="d-flex justify-content-center">
                    <p class="td_section_subtitle td_fs_18 mb-0 md_intro">
                        Affiliation, recognition, safety certificates and other documents published in line with
                        CBSE's disclosure requirements. Click any document to view it or download it.
                    </p>
                </div>
            </div>
            <div class="td_height_50 td_height_lg_40"></div>

            @if ($total === 0)
                <div class="md_empty">
                    <p class="td_fs_18 mb-0">Documents will be published here soon.</p>
                </div>
            @else

                {{-- Toolbar: search + category jump + counts --}}
                <div class="md_toolbar">
                    <div class="md_search">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="search" id="md_q" placeholder="Search documents…" aria-label="Search documents" autocomplete="off">
                    </div>
                    <div class="md_stats">
                        <span><b id="md_visible">{{ $total }}</b> {{ \Illuminate\Support\Str::plural('document', $total) }}</span>
                        @if ($lastUpdated)
                            <span class="md_dot">·</span>
                            <span>Updated {{ $lastUpdated->format('d M Y') }}</span>
                        @endif
                    </div>
                </div>

                @if ($groups->count() > 1)
                    <div class="md_chips">
                        <button type="button" class="md_chip is-active" data-cat="">All</button>
                        @foreach ($groups as $name => $docs)
                            <button type="button" class="md_chip" data-cat="{{ \Illuminate\Support\Str::slug($name) }}">
                                {{ $name }} <span>{{ $docs->count() }}</span>
                            </button>
                        @endforeach
                    </div>
                @endif

                {{-- Groups --}}
                @foreach ($groups as $name => $docs)
                    <div class="md_group" data-cat="{{ \Illuminate\Support\Str::slug($name) }}">
                        <div class="md_group_head">
                            <h3 class="td_fs_24 td_semibold mb-0">{{ $name }}</h3>
                            <span class="md_group_count">{{ $docs->count() }}</span>
                        </div>

                        <div class="row td_gap_y_24">
                            @foreach ($docs as $doc)
                                @php
                                    $ext   = strtolower(pathinfo((string) $doc->file, PATHINFO_EXTENSION)) ?: 'file';
                                    $isPdf = $ext === 'pdf';
                                    $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true);
                                @endphp
                                <div class="col-xl-4 col-md-6 md_item"
                                    data-search="{{ \Illuminate\Support\Str::lower($doc->title . ' ' . $name . ' ' . $doc->issued_by) }}">
                                    <div class="md_card">
                                        <span class="md_file md_file_{{ $isPdf ? 'pdf' : ($isImg ? 'img' : 'doc') }}">{{ strtoupper($ext) }}</span>

                                        <div class="md_card_body">
                                            <h4 class="md_title">{{ $doc->title }}</h4>
                                            <div class="md_meta">
                                                @if ($doc->issued_by)
                                                    <span>{{ $doc->issued_by }}</span>
                                                @endif
                                                @if ($doc->issue_date)
                                                    <span>Issued {{ $doc->issue_date->format('d M Y') }}</span>
                                                @endif
                                                @if ($doc->file_size_label)
                                                    <span>{{ $doc->file_size_label }}</span>
                                                @endif
                                            </div>
                                            @if ($doc->valid_until)
                                                <span class="md_valid {{ $doc->is_expired ? 'is-expired' : 'is-valid' }}">
                                                    {{ $doc->is_expired ? 'Expired' : 'Valid till' }} {{ $doc->valid_until->format('d M Y') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="md_actions">
                                            <a href="{{ $doc->file_url }}" class="md_btn md_view" target="_blank" rel="noopener"
                                                data-src="{{ $doc->file_url }}" data-title="{{ $doc->title }}"
                                                data-kind="{{ $isPdf ? 'pdf' : ($isImg ? 'image' : 'other') }}">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                                View
                                            </a>
                                            <a href="{{ $doc->file_url }}" download="{{ $doc->original_name ?: basename($doc->file) }}"
                                                class="md_btn md_btn_icon" aria-label="Download {{ $doc->title }}" title="Download">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="md_empty d-none" id="md_none">
                    <p class="td_fs_18 mb-0">No documents match your search.</p>
                </div>
            @endif
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>

    {{-- Document viewer (no Bootstrap dependency) --}}
    <div class="md_viewer" id="mdViewer" aria-hidden="true" role="dialog" aria-label="Document viewer">
        <div class="md_viewer_backdrop" data-close></div>
        <div class="md_viewer_box">
            <div class="md_viewer_head">
                <h5 class="md_viewer_title mb-0"></h5>
                <div class="md_viewer_tools">
                    <a href="#" class="md_btn md_viewer_open" target="_blank" rel="noopener">Open in new tab</a>
                    <a href="#" class="md_btn md_viewer_download" download>Download</a>
                    <button type="button" class="md_viewer_close" data-close aria-label="Close">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            <div class="md_viewer_body"></div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    /* --heading-color is used instead of --accent-color (broken under td_theme_2) */
    .md_section, .md_viewer {
        --md-accent: var(--heading-color, #00539B);
        --md-dark: #002F5F;
        --md-soft: #F4F7FB;
        --md-line: #E6EAF2;
        --md-red: #C8102E;
        --md-muted: #6b7489;
    }
    .md_section { background: #F8F9FB; }
    .md_accent { color: var(--md-accent); }
    .md_section .td_section_subtitle_up i::before,
    .md_section .td_section_subtitle_up i::after { background-color: var(--md-accent); }
    .md_intro { max-width: 720px; }

    /* Fix the theme's broken breadcrumb separator */
    .td_page_heading .breadcrumb-item + .breadcrumb-item::before { content: "/" !important; color: #fff; padding: 0 8px; }

    /* ---------- Toolbar ---------- */
    .md_toolbar {
        display: flex; align-items: center; justify-content: space-between; gap: 16px;
        padding: 12px 12px 12px 12px; border-radius: 16px; background: #fff;
        border: 1px solid var(--md-line); box-shadow: 0 20px 50px -30px rgba(0,0,27,.3);
    }
    .md_search {
        flex: 1; max-width: 520px; display: flex; align-items: center; gap: 10px;
        padding: 0 16px; border-radius: 12px; background: var(--md-soft); color: #8a93a6;
    }
    .md_search input { flex: 1; height: 50px; border: 0; outline: 0; background: transparent; color: var(--md-accent); font-weight: 500; }
    .md_stats { display: flex; align-items: center; gap: 8px; padding-right: 8px; color: var(--md-muted); font-size: 15px; white-space: nowrap; }
    .md_stats b { color: var(--md-accent); }

    .md_chips { display: flex; flex-wrap: wrap; gap: 10px; margin: 22px 0 10px; }
    .md_chip {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 16px; border-radius: 30px; border: 1px solid var(--md-line);
        background: #fff; color: var(--md-accent); font-weight: 500; font-size: 15px; cursor: pointer;
        transition: all .25s ease;
    }
    .md_chip span {
        min-width: 22px; height: 22px; padding: 0 6px; border-radius: 20px; font-size: 12px;
        display: inline-flex; align-items: center; justify-content: center; background: var(--md-soft);
    }
    .md_chip:hover { border-color: var(--md-accent); }
    .md_chip.is-active { background: var(--md-accent); border-color: var(--md-accent); color: #fff; }
    .md_chip.is-active span { background: rgba(255,255,255,.2); }

    /* ---------- Groups ---------- */
    .md_group { margin-top: 44px; }
    .md_group_head {
        display: flex; align-items: center; gap: 12px; margin-bottom: 22px;
        padding-bottom: 12px; border-bottom: 1px solid var(--md-line); position: relative;
    }
    .md_group_head::after {
        content: ""; position: absolute; left: 0; bottom: -2px; width: 60px; height: 3px;
        border-radius: 5px; background: var(--md-accent);
    }
    .md_group_head h3 { color: var(--md-accent); }
    .md_group_count {
        min-width: 28px; height: 26px; padding: 0 9px; border-radius: 20px; font-size: 13px; font-weight: 600;
        display: inline-flex; align-items: center; justify-content: center;
        background: var(--md-soft); color: var(--md-accent);
    }

    /* ---------- Card ---------- */
    .md_item { display: flex; }
    .md_card {
        width: 100%; display: flex; align-items: center; gap: 16px;
        padding: 18px; border-radius: 14px; background: #fff;
        border: 1px solid var(--md-line); border-left: 4px solid var(--md-accent);
        box-shadow: 0 10px 30px -24px rgba(0,0,27,.4);
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .md_card:hover { transform: translateY(-4px); box-shadow: 0 22px 44px -26px rgba(0,0,27,.5); }

    .md_file {
        flex: none; width: 48px; height: 56px; border-radius: 8px; position: relative;
        display: flex; align-items: flex-end; justify-content: center; padding-bottom: 8px;
        font-size: 11px; font-weight: 700; letter-spacing: .5px; color: #fff;
    }
    .md_file::before {   /* folded corner */
        content: ""; position: absolute; top: 0; right: 0; width: 14px; height: 14px;
        background: linear-gradient(225deg, #F8F9FB 50%, rgba(255,255,255,.45) 50%);
        border-bottom-left-radius: 4px;
    }
    .md_file_pdf { background: var(--md-red); }
    .md_file_img { background: #1f8a5b; }
    .md_file_doc { background: var(--md-accent); }

    .md_card_body { flex: 1; min-width: 0; }
    .md_title {
        margin: 0; font-size: 17px; font-weight: 600; line-height: 1.35; color: var(--md-accent);
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .md_meta { display: flex; flex-wrap: wrap; gap: 2px 10px; margin-top: 4px; font-size: 13px; color: var(--md-muted); }
    .md_meta span + span::before { content: "•"; margin-right: 10px; opacity: .6; }
    .md_valid {
        display: inline-block; margin-top: 8px; padding: 2px 10px; border-radius: 20px;
        font-size: 12px; font-weight: 600;
    }
    .md_valid.is-valid { background: #e6f7ee; color: #198754; }
    .md_valid.is-expired { background: #fde8ea; color: var(--md-red); }

    .md_actions { flex: none; display: flex; gap: 6px; }
    .md_btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        height: 38px; padding: 0 14px; border-radius: 30px; border: 1px solid var(--md-accent);
        background: #fff; color: var(--md-accent); font-size: 14px; font-weight: 500; white-space: nowrap;
        transition: all .25s ease;
    }
    .md_btn:hover { background: var(--md-accent); color: #fff; }
    .md_btn_icon { width: 38px; padding: 0; }

    .md_empty {
        text-align: center; padding: 60px 20px; margin-top: 30px;
        border: 2px dashed var(--md-line); border-radius: 16px; color: var(--md-muted); background: #fff;
    }

    /* ---------- Viewer ---------- */
    .md_viewer {
        position: fixed; inset: 0; z-index: 99999; display: flex; align-items: center; justify-content: center;
        padding: 30px; visibility: hidden; opacity: 0; transition: opacity .3s ease, visibility .3s ease;
    }
    .md_viewer.is-open { visibility: visible; opacity: 1; }
    .md_viewer_backdrop { position: absolute; inset: 0; background: rgba(0, 0, 18, .85); backdrop-filter: blur(3px); }
    .md_viewer_box {
        position: relative; z-index: 1; width: 100%; max-width: 1100px; height: 100%;
        display: flex; flex-direction: column; border-radius: 16px; overflow: hidden; background: #fff;
        transform: translateY(20px); transition: transform .3s ease;
    }
    .md_viewer.is-open .md_viewer_box { transform: none; }
    .md_viewer_head {
        display: flex; align-items: center; justify-content: space-between; gap: 16px;
        padding: 14px 18px; border-bottom: 1px solid var(--md-line);
    }
    .md_viewer_title { font-size: 18px; font-weight: 600; color: var(--md-accent); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .md_viewer_tools { display: flex; align-items: center; gap: 8px; flex: none; }
    .md_viewer_download { background: var(--md-accent); color: #fff; }
    .md_viewer_close {
        width: 40px; height: 40px; border-radius: 50%; border: 0; cursor: pointer;
        display: flex; align-items: center; justify-content: center; background: var(--md-soft); color: var(--md-accent);
    }
    .md_viewer_close:hover { background: var(--md-accent); color: #fff; }
    .md_viewer_body { flex: 1; background: #525659; display: flex; align-items: center; justify-content: center; }
    .md_viewer_body iframe { width: 100%; height: 100%; border: 0; background: #fff; }
    .md_viewer_body img { max-width: 100%; max-height: 100%; object-fit: contain; }
    body.md_lock { overflow: hidden; }

    /* ---------- Responsive ---------- */
    @media (max-width: 991px) {
        .md_toolbar { flex-direction: column; align-items: stretch; }
        .md_search { max-width: none; }
        .md_stats { justify-content: center; padding: 0; }
    }
    @media (max-width: 767px) {
        .md_chips { flex-wrap: nowrap; overflow-x: auto; scrollbar-width: none; padding-bottom: 4px; }
        .md_chips::-webkit-scrollbar { display: none; }
        .md_chip { flex: none; }
        .md_group { margin-top: 34px; }
        .md_card:hover { transform: none; }
        .md_viewer { padding: 0; }
        .md_viewer_box { border-radius: 0; }
        .md_viewer_open { display: none; }
    }
    @media (max-width: 420px) {
        .md_card { flex-wrap: wrap; padding: 16px; }
        .md_card_body { flex: 1 1 calc(100% - 64px); }
        .md_actions { width: 100%; }
        .md_actions .md_view { flex: 1; }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    function init() {
        var items  = Array.prototype.slice.call(document.querySelectorAll('.md_item'));
        var groups = Array.prototype.slice.call(document.querySelectorAll('.md_group'));
        var q      = document.getElementById('md_q');
        var chips  = document.querySelectorAll('.md_chip');
        var state  = { q: '', cat: '' };

        /* ---------- Search + category filter ---------- */
        function apply() {
            var visible = 0;
            groups.forEach(function (g) {
                var catOk = !state.cat || g.getAttribute('data-cat') === state.cat;
                var inGroup = 0;
                g.querySelectorAll('.md_item').forEach(function (it) {
                    var show = catOk && (!state.q || it.getAttribute('data-search').indexOf(state.q) !== -1);
                    it.classList.toggle('d-none', !show);
                    if (show) inGroup++;
                });
                g.classList.toggle('d-none', inGroup === 0);
                visible += inGroup;
            });
            var v = document.getElementById('md_visible');
            if (v) v.textContent = visible;
            var none = document.getElementById('md_none');
            if (none) none.classList.toggle('d-none', visible > 0);
        }

        if (q) q.addEventListener('input', function () { state.q = q.value.trim().toLowerCase(); apply(); });
        chips.forEach(function (c) {
            c.addEventListener('click', function () {
                chips.forEach(function (x) { x.classList.remove('is-active'); });
                c.classList.add('is-active');
                state.cat = c.getAttribute('data-cat');
                apply();
            });
        });

        /* ---------- Viewer ---------- */
        var viewer = document.getElementById('mdViewer');
        if (!viewer) return;
        var body   = viewer.querySelector('.md_viewer_body');
        var title  = viewer.querySelector('.md_viewer_title');
        var openA  = viewer.querySelector('.md_viewer_open');
        var dlA    = viewer.querySelector('.md_viewer_download');
        var isPhone = window.matchMedia('(max-width: 767px)').matches;

        function open(src, name, kind) {
            body.innerHTML = '';
            if (kind === 'image') {
                var img = document.createElement('img'); img.src = src; img.alt = name; body.appendChild(img);
            } else {
                var f = document.createElement('iframe'); f.src = src; f.title = name; body.appendChild(f);
            }
            title.textContent = name;
            openA.href = src; dlA.href = src;
            viewer.classList.add('is-open');
            viewer.setAttribute('aria-hidden', 'false');
            document.body.classList.add('md_lock');
        }
        function close() {
            viewer.classList.remove('is-open');
            viewer.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('md_lock');
            body.innerHTML = '';
        }

        document.querySelectorAll('.md_view').forEach(function (a) {
            a.addEventListener('click', function (e) {
                var kind = a.getAttribute('data-kind');
                // Phones can't show PDFs inside a page reliably: let the link open the file directly.
                if (kind === 'other' || (kind === 'pdf' && isPhone)) return;
                e.preventDefault();
                open(a.getAttribute('data-src'), a.getAttribute('data-title'), kind);
            });
        });
        viewer.querySelectorAll('[data-close]').forEach(function (el) { el.addEventListener('click', close); });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && viewer.classList.contains('is-open')) close();
        });
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
</script>
@endpush