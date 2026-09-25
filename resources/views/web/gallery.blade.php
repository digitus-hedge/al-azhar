@extends('web.layouts.app')

@section('title', 'Gallery || AL-Azhar')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@php
    $albums     = $albums ?? collect();
    $totalCount = $totalCount ?? 0;
@endphp

@section('content')

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
        data-src="{{ asset('uploads/website-images/students-after-graduation-ceremony.jpg') }}">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">Gallery</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Gallery</li>
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

    <!-- Start Gallery -->
    <section class="gal_section">
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">

            {{-- Section intro --}}
            <div class="td_section_heading td_style_1 text-center">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase gal_accent">
                    <i></i> Life at Al Azhar <i></i>
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">Moments We Cherish</h2>
                <div class="d-flex justify-content-center">
                    <p class="td_section_subtitle td_fs_18 mb-0 gal_intro">
                        Celebrations, achievements and everyday campus life, captured in photos and videos.
                    </p>
                </div>
            </div>
            <div class="td_height_60 td_height_lg_40"></div>

            @if ($totalCount === 0)
                <p class="text-center td_fs_18 mb-0">Photos and videos will appear here soon.</p>
            @else
                @php $index = 0; @endphp

                @foreach ($albums as $album)
                    <div class="gal_album">
                        <div class="gal_album_head">
                            <span class="gal_album_year">{{ $album->year }}</span>
                            <div class="gal_album_titles">
                                <h3 class="td_fs_32 td_semibold mb-0">
                                    {{ is_numeric($album->title) ? 'Moments of ' . $album->title : $album->title }}
                                </h3>
                                <p class="td_fs_16 mb-0 td_heading_color td_opacity_7">
                                    @if ($album->photos) {{ $album->photos }} {{ \Illuminate\Support\Str::plural('photo', $album->photos) }} @endif
                                    @if ($album->photos && $album->videos) &middot; @endif
                                    @if ($album->videos) {{ $album->videos }} {{ \Illuminate\Support\Str::plural('video', $album->videos) }} @endif
                                </p>
                            </div>
                        </div>

                        <div class="gal_grid">
                            @foreach ($album->items as $item)
                                @php
                                    if ($item->is_embed) {
                                        $kind = 'embed';
                                        $src  = $item->embed_url . (str_contains((string) $item->embed_url, '?') ? '&' : '?') . 'autoplay=1';
                                    } elseif ($item->is_video) {
                                        $kind = 'video';
                                        $src  = $item->media_url;
                                    } else {
                                        $kind = 'image';
                                        $src  = $item->media_url;
                                    }
                                    $thumb = $item->thumbnail_url;
                                @endphp
                                <a href="{{ $src }}" class="gal_tile" data-index="{{ $index++ }}"
                                    data-kind="{{ $kind }}" data-src="{{ $src }}" data-thumb="{{ $thumb }}"
                                    data-title="{{ $item->title }}" aria-label="Open {{ $item->title }}">

                                    @if ($thumb)
                                        <img src="{{ $thumb }}" alt="{{ $item->title }}" loading="lazy" decoding="async">
                                    @elseif ($kind === 'video')
                                        <video muted playsinline preload="none" data-lazy-src="{{ $src }}#t=0.5"></video>
                                    @else
                                        <span class="gal_tile_empty"></span>
                                    @endif

                                    @if ($kind !== 'image')
                                        <span class="gal_play"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg></span>
                                    @else
                                        <span class="gal_zoom"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg></span>
                                    @endif

                                    <span class="gal_caption">{{ $item->title }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Gallery -->

    {{-- Lightbox (no Bootstrap dependency) --}}
    <div class="gal_lb" id="galLb" aria-hidden="true" role="dialog" aria-label="Gallery viewer">
        <div class="gal_lb_backdrop" data-close></div>

        <div class="gal_lb_bar">
            <span class="gal_lb_counter"></span>
            <button type="button" class="gal_lb_btn" data-close aria-label="Close">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <button type="button" class="gal_lb_btn gal_lb_nav gal_lb_prev" aria-label="Previous">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </button>

        <div class="gal_lb_stage"></div>

        <button type="button" class="gal_lb_btn gal_lb_nav gal_lb_next" aria-label="Next">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </button>

        <div class="gal_lb_footer">
            <p class="gal_lb_title"></p>
            <div class="gal_lb_thumbs"></div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    /* Uses --heading-color (#00539B) because --accent-color is broken under td_theme_2 */
    .gal_section { --gal-accent: var(--heading-color, #00539B); --gal-dark: #00001B; }
    .gal_accent { color: var(--gal-accent); }
    .gal_section .td_section_subtitle_up i::before,
    .gal_section .td_section_subtitle_up i::after { background-color: var(--gal-accent); }
    .gal_intro { max-width: 640px; }

    /* ---------- Album header ---------- */
    .gal_album + .gal_album { margin-top: 80px; }
    .gal_album_head { display: flex; align-items: center; gap: 20px; margin-bottom: 30px; }
    .gal_album_year {
        flex: none; width: 76px; height: 76px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; font-weight: 700; color: #fff;
        background: var(--gal-accent);
        box-shadow: 0 0 0 6px rgba(0, 83, 155, 0.12);
    }
    .gal_album_titles { flex: 1; min-width: 0; padding-bottom: 14px; border-bottom: 1px dashed #d6dbe8; }
    .gal_album_titles h3 { line-height: 1.25; }

    /* ---------- Bento grid ---------- */
    .gal_grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-auto-rows: 210px;
        grid-auto-flow: dense;
        gap: 18px;
    }
    .gal_tile:nth-child(8n + 1) { grid-column: span 2; grid-row: span 2; }  /* big feature */
    .gal_tile:nth-child(8n + 6) { grid-column: span 2; }                    /* wide */

    .gal_tile {
        position: relative; display: block; overflow: hidden;
        border-radius: 14px; background: #eef0f7; cursor: zoom-in;
        box-shadow: 0 10px 30px -18px rgba(0, 0, 27, 0.45);
        transform: translateY(0); transition: transform .4s ease, box-shadow .4s ease;
    }
    .gal_tile img, .gal_tile video, .gal_tile_empty {
        width: 100%; height: 100%; object-fit: cover; display: block;
        transition: transform .8s cubic-bezier(.2, .7, .2, 1);
    }
    .gal_tile::after {
        content: ""; position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(0,0,27,0) 40%, rgba(0,0,27,.8) 100%);
        opacity: .55; transition: opacity .4s ease;
    }
    .gal_tile:hover { transform: translateY(-6px); box-shadow: 0 24px 40px -20px rgba(0, 0, 27, 0.55); }
    .gal_tile:hover img, .gal_tile:hover video { transform: scale(1.08); }
    .gal_tile:hover::after { opacity: 1; }
    .gal_tile:focus-visible { outline: 3px solid var(--gal-accent); outline-offset: 3px; }

    .gal_caption {
        position: absolute; left: 0; right: 0; bottom: 0; z-index: 2;
        padding: 16px 18px; color: #fff; font-weight: 600; font-size: 16px; line-height: 1.35;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        transform: translateY(6px); transition: transform .4s ease;
    }
    .gal_tile:hover .gal_caption { transform: none; }
    .gal_tile:nth-child(8n + 1) .gal_caption { font-size: 22px; padding: 22px 24px; }

    .gal_zoom, .gal_play {
        position: absolute; z-index: 2; display: flex; align-items: center; justify-content: center;
        border-radius: 50%; transition: all .4s ease;
    }
    .gal_zoom {
        top: 14px; right: 14px; width: 42px; height: 42px;
        background: rgba(255,255,255,.95); color: var(--gal-accent);
        opacity: 0; transform: scale(.6);
    }
    .gal_tile:hover .gal_zoom { opacity: 1; transform: scale(1); }
    .gal_play {
        left: 50%; top: 50%; width: 60px; height: 60px; margin: -30px 0 0 -30px;
        background: rgba(255,255,255,.95); color: var(--gal-accent);
        box-shadow: 0 0 0 10px rgba(255,255,255,.25);
    }
    .gal_play svg { margin-left: 3px; }
    .gal_tile:hover .gal_play { transform: scale(1.12); box-shadow: 0 0 0 14px rgba(255,255,255,.2); }

    /* ---------- Lightbox ---------- */
    .gal_lb {
        position: fixed; inset: 0; z-index: 99999;
        display: flex; align-items: center; justify-content: center;
        visibility: hidden; opacity: 0; transition: opacity .3s ease, visibility .3s ease;
    }
    .gal_lb.is-open { visibility: visible; opacity: 1; }
    .gal_lb_backdrop { position: absolute; inset: 0; background: rgba(0, 0, 18, .95); backdrop-filter: blur(4px); }

    .gal_lb_bar {
        position: absolute; top: 0; left: 0; right: 0; z-index: 3;
        display: flex; justify-content: space-between; align-items: center; padding: 16px 22px;
    }
    .gal_lb_counter { color: rgba(255,255,255,.75); font-size: 15px; font-weight: 500; letter-spacing: 1px; }

    .gal_lb_stage {
        position: relative; z-index: 2;
        width: calc(100% - 200px); height: calc(100% - 230px);
        display: flex; align-items: center; justify-content: center; margin-top: -40px;
    }
    .gal_lb_stage > * { animation: galFade .35s ease both; }
    .gal_lb_stage img, .gal_lb_stage video {
        max-width: 100%; max-height: 100%; object-fit: contain;
        border-radius: 10px; box-shadow: 0 30px 60px -20px rgba(0,0,0,.6);
    }
    .gal_lb_frame { width: 100%; max-width: 1100px; aspect-ratio: 16 / 9; max-height: 100%; }
    .gal_lb_frame iframe { width: 100%; height: 100%; border: 0; border-radius: 10px; }
    @keyframes galFade { from { opacity: 0; transform: scale(.97); } to { opacity: 1; transform: none; } }

    .gal_lb_btn {
        width: 48px; height: 48px; border-radius: 50%; border: 0; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,.12); color: #fff; transition: background .3s ease, transform .3s ease;
    }
    .gal_lb_btn:hover { background: var(--heading-color, #00539B); transform: scale(1.06); }
    .gal_lb_nav { position: absolute; top: 50%; z-index: 3; margin-top: -60px; width: 56px; height: 56px; }
    .gal_lb_prev { left: 28px; }
    .gal_lb_next { right: 28px; }

    .gal_lb_footer {
        position: absolute; left: 0; right: 0; bottom: 0; z-index: 3;
        padding: 0 20px 18px; text-align: center;
    }
    .gal_lb_title { color: #fff; font-size: 18px; font-weight: 500; margin-bottom: 12px; }
    .gal_lb_thumbs {
        display: flex; gap: 8px; justify-content: center;
        overflow-x: auto; scrollbar-width: none; padding: 4px;
    }
    .gal_lb_thumbs::-webkit-scrollbar { display: none; }
    .gal_lb_thumb {
        flex: none; width: 74px; height: 52px; padding: 0; border: 2px solid transparent;
        border-radius: 8px; overflow: hidden; cursor: pointer; opacity: .45;
        background: #1c1c3a; transition: all .25s ease; position: relative;
    }
    .gal_lb_thumb img { width: 100%; height: 100%; object-fit: cover; }
    .gal_lb_thumb.is-video::after {
        content: "▶"; position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 13px; background: rgba(0,0,0,.35);
    }
    .gal_lb_thumb:hover { opacity: .8; }
    .gal_lb_thumb.is-active { opacity: 1; border-color: #fff; }

    body.gal_lb_lock { overflow: hidden; }

    /* ---------- Responsive ---------- */
    @media (max-width: 1199px) {
        .gal_grid { grid-template-columns: repeat(3, 1fr); grid-auto-rows: 190px; }
    }
    @media (max-width: 991px) {
        .gal_album + .gal_album { margin-top: 60px; }
        .gal_lb_stage { width: calc(100% - 140px); }
        .gal_lb_prev { left: 14px; }
        .gal_lb_next { right: 14px; }
    }
    @media (max-width: 767px) {
        .gal_grid { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 160px; gap: 12px; }
        .gal_tile:nth-child(8n + 6) { grid-column: span 2; }
        .gal_album_head { gap: 14px; margin-bottom: 20px; }
        .gal_album_year { width: 58px; height: 58px; font-size: 16px; }
        .gal_album_titles h3 { font-size: 22px; }
        .gal_caption { font-size: 14px; padding: 12px 14px; }
        .gal_tile:nth-child(8n + 1) .gal_caption { font-size: 17px; padding: 16px; }
        .gal_zoom { display: none; }
        .gal_play { width: 46px; height: 46px; margin: -23px 0 0 -23px; }

        .gal_lb_stage { width: 100%; height: calc(100% - 210px); padding: 0 10px; margin-top: -20px; }
        .gal_lb_nav { top: auto; bottom: 92px; margin: 0; width: 44px; height: 44px; }
        .gal_lb_title { font-size: 15px; padding: 0 56px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .gal_lb_thumb { width: 56px; height: 40px; }
    }
    @media (max-width: 420px) {
        .gal_grid { grid-auto-rows: 130px; gap: 10px; }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    function init() {
        var tiles = Array.prototype.slice.call(document.querySelectorAll('.gal_tile'));
        var lb = document.getElementById('galLb');
        if (!tiles.length || !lb) return;

        var stage   = lb.querySelector('.gal_lb_stage');
        var titleEl = lb.querySelector('.gal_lb_title');
        var countEl = lb.querySelector('.gal_lb_counter');
        var thumbs  = lb.querySelector('.gal_lb_thumbs');
        var current = 0;

        /* ----- lazy-load uploaded-video frames ----- */
        var vids = document.querySelectorAll('video[data-lazy-src]');
        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (!e.isIntersecting) return;
                    e.target.preload = 'metadata';
                    e.target.src = e.target.getAttribute('data-lazy-src');
                    io.unobserve(e.target);
                });
            }, { rootMargin: '200px' });
            vids.forEach(function (v) { io.observe(v); });
        } else {
            vids.forEach(function (v) { v.src = v.getAttribute('data-lazy-src'); });
        }

        /* ----- thumbnail strip (built once) ----- */
        tiles.forEach(function (tile, i) {
            var b = document.createElement('button');
            b.type = 'button';
            b.className = 'gal_lb_thumb' + (tile.dataset.kind !== 'image' ? ' is-video' : '');
            b.setAttribute('aria-label', 'Show item ' + (i + 1));
            if (tile.dataset.thumb) {
                var im = document.createElement('img');
                im.src = tile.dataset.thumb; im.alt = ''; im.loading = 'lazy';
                b.appendChild(im);
            }
            b.addEventListener('click', function () { show(i); });
            thumbs.appendChild(b);
        });

        function show(i) {
            current = (i + tiles.length) % tiles.length;
            var t = tiles[current].dataset;

            stage.innerHTML = '';
            var node;
            if (t.kind === 'image') {
                node = document.createElement('img');
                node.src = t.src; node.alt = t.title;
            } else if (t.kind === 'video') {
                node = document.createElement('video');
                node.src = t.src; node.controls = true; node.autoplay = true; node.playsInline = true;
            } else {
                node = document.createElement('div');
                node.className = 'gal_lb_frame';
                var f = document.createElement('iframe');
                f.src = t.src; f.title = t.title;
                f.allow = 'autoplay; fullscreen; picture-in-picture';
                f.allowFullscreen = true;
                node.appendChild(f);
            }
            stage.appendChild(node);

            titleEl.textContent = t.title || '';
            countEl.textContent = (current + 1) + ' / ' + tiles.length;

            var all = thumbs.children;
            for (var k = 0; k < all.length; k++) all[k].classList.toggle('is-active', k === current);
            if (all[current] && all[current].scrollIntoView) {
                all[current].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }

            // preload neighbours for instant next/prev
            [current + 1, current - 1].forEach(function (n) {
                var d = tiles[(n + tiles.length) % tiles.length].dataset;
                if (d.kind === 'image') { var p = new Image(); p.src = d.src; }
            });
        }

        function open(i) {
            show(i);
            lb.classList.add('is-open');
            lb.setAttribute('aria-hidden', 'false');
            document.body.classList.add('gal_lb_lock');
        }

        function close() {
            lb.classList.remove('is-open');
            lb.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('gal_lb_lock');
            stage.innerHTML = '';   // stops video / embed
        }

        tiles.forEach(function (tile, i) {
            tile.addEventListener('click', function (e) { e.preventDefault(); open(i); });
        });

        lb.querySelector('.gal_lb_prev').addEventListener('click', function () { show(current - 1); });
        lb.querySelector('.gal_lb_next').addEventListener('click', function () { show(current + 1); });
        lb.querySelectorAll('[data-close]').forEach(function (el) { el.addEventListener('click', close); });

        document.addEventListener('keydown', function (e) {
            if (!lb.classList.contains('is-open')) return;
            if (e.key === 'Escape') close();
            if (e.key === 'ArrowLeft') show(current - 1);
            if (e.key === 'ArrowRight') show(current + 1);
        });

        // swipe on touch screens
        var sx = null;
        stage.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
        stage.addEventListener('touchend', function (e) {
            if (sx === null) return;
            var dx = e.changedTouches[0].clientX - sx;
            if (Math.abs(dx) > 50) show(current + (dx < 0 ? 1 : -1));
            sx = null;
        });
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
</script>
@endpush