@extends('web.layouts.app')

@section('title', ($facility->meta_title ?: $facility->title) . ' || AL-Azhar')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@php
    $placeholder = 'data:image/svg+xml;utf8,' . rawurlencode(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 280"><rect width="400" height="280" fill="#eef0f7"/><path d="M150 180l40-50 30 36 20-24 50 38z" fill="#c9cde0"/><circle cx="160" cy="105" r="18" fill="#c9cde0"/></svg>'
    );

    $related = $related ?? collect();

    // gallery together for the photo grid / lightbox
    $photos = collect($facility->gallery_urls)->filter()->values();
    $details = collect([
        ['Capacity',       $facility->capacity ? number_format($facility->capacity) : null],
        ['Location',       $facility->location],
        ['Timings',        $facility->timings],
        ['Contact Person', $facility->contact_person],
        ['Contact Number', $facility->contact_phone],
    ])->filter(fn ($row) => filled($row[1]));

    $description = (string) $facility->description;
    $isHtml      = $description !== strip_tags($description); // rich-text editor content
@endphp

@section('content')

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('images/header.jpeg') }}"
    style="background-image: url('{{ asset('images/header.jpeg') }}');">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10 wow fadeInDown" data-wow-duration="0.9s" data-wow-delay="0.2s">{{ $facility->title }}</h1>
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

    <!-- Start Facility Details (FAQ layout) -->
    <div class="td_height_100 td_height_lg_50"></div>
    <div class="td_faq_1 td_style_1 td_type_1 fac_detail">

        {{-- Left: cover image --}}
        <div class="td_faq_1_left">
            <div class="td_faq_1_img td_bg_filed fac_cover" data-src="{{ $facility->image_url ?: $placeholder }}"
                style="background-image: url('{{ $facility->image_url ?: $placeholder }}');"
                role="img" aria-label="{{ $facility->title }}"></div>
        </div>

        {{-- Right: heading + accordion --}}
        <div class="td_faq_1_right">
            <div class="td_section_heading td_style_1 td_mb_30">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color wow fadeInDown" data-wow-delay="0.2s">
                    {{ $facility->category_label }}
                </p>
                <h2 class="td_section_title td_fs_48 mb-0 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.35s">{{ $facility->title }}</h2>
                @if ($facility->short_description)
                    <p class="td_section_subtitle td_fs_18 mb-0 wow fadeInUp" data-wow-delay="0.45s">{{ $facility->short_description }}</p>
                @endif
            </div>

            @php $firstOpen = true; @endphp
            <div class="td_accordians td_style_1 td_type_2 td_mb_40 fac_acc">
                @if (filled($description))
                    <div class="td_accordian {{ $firstOpen ? 'active' : '' }} wow fadeInRight" data-wow-delay="0.5s">
                        <div class="td_accordian_head">
                            <h2 class="td_accordian_title td_fs_24">About this Facility</h2>
                            <span class="td_accordian_toggle"></span>
                        </div>
                        <div class="td_accordian_body td_fs_18 fac_richtext">
                            @if ($isHtml)
                                {!! $description !!}
                            @else
                                <p>{!! nl2br(e($description)) !!}</p>
                            @endif
                        </div>
                    </div>
                    @php $firstOpen = false; @endphp
                @endif

                @if (! empty($facility->features))
                    <div class="td_accordian {{ $firstOpen ? 'active' : '' }} wow fadeInRight" data-wow-delay="0.65s">
                        <div class="td_accordian_head">
                            <h2 class="td_accordian_title td_fs_24">Highlights</h2>
                            <span class="td_accordian_toggle"></span>
                        </div>
                        <div class="td_accordian_body td_fs_18">
                            <ul class="td_mp_0 fac_features">
                                @foreach ($facility->features as $feature)
                                    <li>
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5" /></svg>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @php $firstOpen = false; @endphp
                @endif

                @if ($details->isNotEmpty())
                    <div class="td_accordian {{ $firstOpen ? 'active' : '' }} wow fadeInRight" data-wow-delay="0.8s">
                        <div class="td_accordian_head">
                            <h2 class="td_accordian_title td_fs_24">Facility Details</h2>
                            <span class="td_accordian_toggle"></span>
                        </div>
                        <div class="td_accordian_body td_fs_18">
                            <ul class="td_mp_0 fac_info">
                                @foreach ($details as [$label, $value])
                                    <li>
                                        <span class="fac_info_label">{{ $label }}</span>
                                        <span class="fac_info_value">
                                            @if ($label === 'Contact Number')
                                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $value) }}">{{ $value }}</a>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>

            <a href="{{ route('contact.index') }}" class="td_btn td_style_2 td_type_2 td_heading_color td_medium wow zoomIn" data-wow-delay="0.9s">
                Get In Touch
                <i>
                    @for ($i = 0; $i < 2; $i++)
                        <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    @endfor
                </i>
            </a>
        </div>
    </div>
    <!-- End Facility Details -->

    {{-- Photo gallery --}}
    @if ($photos->isNotEmpty())
        <section>
            <div class="td_height_100 td_height_lg_50"></div>
            <div class="container">
                <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                        <i></i> Gallery <i></i>
                    </p>
                    <h2 class="td_section_title td_fs_48 mb-0">Take a Closer Look</h2>
                </div>
                <div class="td_height_50 td_height_lg_40"></div>
                <div class="fac_gallery">
                    @foreach ($photos as $i => $photo)
                       <button type="button" class="fac_gallery_item wow zoomIn" data-index="{{ $i }}"
                            data-wow-duration="0.9s" data-wow-delay="{{ 0.1 + ($i % 4) * 0.1 }}s"
                            aria-label="Open photo {{ $i + 1 }} of {{ $photos->count() }}">
                            <img src="{{ $photo }}" alt="{{ $facility->title }} photo {{ $i + 1 }}" loading="lazy">
                            <span class="fac_gallery_zoom td_center">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3M11 8v6M8 11h6"/></svg>
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

                {{-- Lightbox (no Bootstrap dependency) --}}
        <div class="fac_lb" id="facLb" aria-hidden="true" role="dialog" aria-label="{{ $facility->title }} photos">
            <div class="fac_lb_backdrop" data-close></div>

            <div class="fac_lb_bar">
                <span class="fac_lb_counter"></span>
                <button type="button" class="fac_lb_btn" data-close aria-label="Close">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <button type="button" class="fac_lb_btn fac_lb_nav fac_lb_prev" aria-label="Previous">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </button>

            <div class="fac_lb_stage"></div>

            <button type="button" class="fac_lb_btn fac_lb_nav fac_lb_next" aria-label="Next">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </button>

            <div class="fac_lb_footer">
                <p class="fac_lb_title"></p>
                <div class="fac_lb_thumbs"></div>
            </div>
        </div>
    @endif

    {{-- Other facilities (same card style as the listing page) --}}
    @if ($related->isNotEmpty())
        <section>
            <div class="td_height_100 td_height_lg_50"></div>
            <div class="container">
                <div class="td_section_heading td_style_1 td_type_1 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_section_heading_left">
                        <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">More to explore</p>
                        <h2 class="td_section_title td_fs_48 mb-0">Other Facilities</h2>
                    </div>
                    <div class="td_section_heading_right">
                        <a href="{{ route('facilities.index') }}" class="td_btn td_style_1 td_radius_30 td_medium">
                            <span class="td_btn_in td_white_color td_accent_bg"><span>View All Facilities</span></span>
                        </a>
                    </div>
                </div>
                <div class="td_height_50 td_height_lg_40"></div>
                <div class="row td_gap_y_30 td_row_gap_30">
                    @foreach ($related as $item)
                        @php $url = route('facilities.show', $item); @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6 d-flex wow {{ ['fadeInLeft', 'fadeInUp', 'fadeInUp', 'fadeInRight'][$loop->index % 4] }}"
                            data-wow-duration="0.9s" data-wow-delay="{{ 0.1 + ($loop->index % 4) * 0.1 }}s">
                            <div class="td_card td_style_3 d-block td_radius_10 fac_rel_card">
                                <a href="{{ $url }}" class="td_card_thumb">
                                    <img src="{{ $item->image_url ?: $placeholder }}" alt="{{ $item->title }}" loading="lazy">
                                </a>
                                <div class="td_card_info td_white_bg">
                                    <div class="td_card_info_in">
                                        <div class="td_card_category_df td_mb_14">
                                            <span class="td_card_category td_fs_14 td_normal td_heading_color"><span>{{ $item->category_label }}</span></span>
                                        </div>
                                        <h2 class="td_card_title td_fs_20 td_mb_16"><a href="{{ $url }}">{{ $item->title }}</a></h2>
                                        @if ($item->short_description)
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 mb-0">{{ $item->short_description }}</p>
                                        @endif
                                        <div class="td_card_btn">
                                            <a href="{{ $url }}" class="td_btn td_style_1 td_radius_30 td_medium">
                                                <span class="td_btn_in td_white_color td_accent_bg"><span>View Details</span></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <div class="td_height_100 td_height_lg_50"></div>

@endsection

@push('styles')
<style>
    .fac_detail .fac_cover { background-position: center; background-size: cover; }

    .fac_richtext p:last-child { margin-bottom: 0; }
    .fac_richtext ul, .fac_richtext ol { margin-bottom: 15px; }

    .fac_features li { display: flex; gap: 10px; align-items: flex-start; }
    .fac_features li:not(:last-child) { margin-bottom: 12px; }
    .fac_features svg { flex: none; margin-top: 5px; color: #fff; }

    .fac_info li {
        display: flex; justify-content: space-between; gap: 15px;
        padding: 10px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    }
    .fac_info li:first-child { padding-top: 0; }
    .fac_info li:last-child { border-bottom: 0; padding-bottom: 0; }
    .fac_info_label { opacity: .75; flex: none; }
    .fac_info_value { text-align: right; color: #fff; font-weight: 500; word-break: break-word; }
    .fac_info_value a:hover { color: rgba(255, 255, 255, 0.75); }

    /* Gallery grid */
    .fac_gallery { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .fac_gallery_item {
        position: relative; padding: 0; border: 0; background: none;
        border-radius: 10px; overflow: hidden; aspect-ratio: 4 / 3; cursor: zoom-in;
    }
    .fac_gallery_item img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s ease; }
    .fac_gallery_zoom {
        position: absolute; inset: 0; color: #fff;
        background-color: rgba(0, 47, 95, 0.45); opacity: 0; transition: opacity .3s ease;
    }
    .fac_gallery_item:hover img { transform: scale(1.05); }
    .fac_gallery_item:hover .fac_gallery_zoom,
    .fac_gallery_item:focus-visible .fac_gallery_zoom { opacity: 1; }

        /* ---------- Lightbox (same as gallery page) ---------- */
    .fac_lb {
        position: fixed; inset: 0; z-index: 99999;
        display: flex; align-items: center; justify-content: center;
        visibility: hidden; opacity: 0; transition: opacity .3s ease, visibility .3s ease;
    }
    .fac_lb.is-open { visibility: visible; opacity: 1; }
    .fac_lb_backdrop { position: absolute; inset: 0; background: rgba(0, 0, 18, .95); backdrop-filter: blur(4px); }

    .fac_lb_bar {
        position: absolute; top: 0; left: 0; right: 0; z-index: 3;
        display: flex; justify-content: space-between; align-items: center; padding: 16px 22px;
    }
    .fac_lb_counter { color: rgba(255,255,255,.75); font-size: 15px; font-weight: 500; letter-spacing: 1px; }

    .fac_lb_stage {
        position: relative; z-index: 2;
        width: calc(100% - 200px); height: calc(100% - 230px);
        display: flex; align-items: center; justify-content: center; margin-top: -40px;
    }
    .fac_lb_stage > * { animation: facFade .35s ease both; }
    .fac_lb_stage img {
        max-width: 100%; max-height: 100%; object-fit: contain;
        border-radius: 10px; box-shadow: 0 30px 60px -20px rgba(0,0,0,.6);
    }
    @keyframes facFade { from { opacity: 0; transform: scale(.97); } to { opacity: 1; transform: none; } }

    .fac_lb_btn {
        width: 48px; height: 48px; border-radius: 50%; border: 0; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,.12); color: #fff; transition: background .3s ease, transform .3s ease;
    }
    .fac_lb_btn:hover { background: var(--heading-color, #00539B); transform: scale(1.06); }
    .fac_lb_nav { position: absolute; top: 50%; z-index: 3; margin-top: -60px; width: 56px; height: 56px; }
    .fac_lb_prev { left: 28px; }
    .fac_lb_next { right: 28px; }

    .fac_lb_footer {
        position: absolute; left: 0; right: 0; bottom: 0; z-index: 3;
        padding: 0 20px 18px; text-align: center;
    }
    .fac_lb_title { color: #fff; font-size: 18px; font-weight: 500; margin-bottom: 12px; }
    .fac_lb_thumbs {
        display: flex; gap: 8px; justify-content: center;
        overflow-x: auto; scrollbar-width: none; padding: 4px;
    }
    .fac_lb_thumbs::-webkit-scrollbar { display: none; }
    .fac_lb_thumb {
        flex: none; width: 74px; height: 52px; padding: 0; border: 2px solid transparent;
        border-radius: 8px; overflow: hidden; cursor: pointer; opacity: .45;
        background: #1c1c3a; transition: all .25s ease;
    }
    .fac_lb_thumb img { width: 100%; height: 100%; object-fit: cover; }
    .fac_lb_thumb:hover { opacity: .8; }
    .fac_lb_thumb.is-active { opacity: 1; border-color: #fff; }

    body.fac_lb_lock { overflow: hidden; }

    /* Related cards */
    .fac_rel_card { width: 100%; background-color: #fff; }
    .fac_rel_card .td_card_thumb img { aspect-ratio: 16 / 11; object-fit: cover; }
    .fac_detail { overflow-x: clip; }
    /* ---------- Responsive ---------- */
    @media (max-width: 1199px) {
        .fac_gallery { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 991px) {
        /* Theme puts the image below the text here - keep it on top */
        .td_faq_1.td_style_1.td_type_1.fac_detail { flex-direction: column; }
        .fac_detail .td_faq_1_img { min-height: 420px; }
        .fac_gallery { grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .fac_lb_stage { width: calc(100% - 140px); }
        .fac_lb_prev { left: 14px; }
        .fac_lb_next { right: 14px; }
    }
    @media (max-width: 767px) {
        .fac_rel_card .td_card_btn { margin-bottom: 0; }
        .fac_rel_card:hover .td_card_info { margin-top: 0; }
        .fac_lb_stage { width: 100%; height: calc(100% - 210px); padding: 0 10px; margin-top: -20px; }
        .fac_lb_nav { top: auto; bottom: 92px; margin: 0; width: 44px; height: 44px; }
        .fac_lb_title { font-size: 15px; padding: 0 56px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .fac_lb_thumb { width: 56px; height: 40px; }
    }
    @media (max-width: 575px) {
        .fac_detail .td_faq_1_img { min-height: 280px; }
        .fac_gallery { gap: 10px; }
        .fac_info li { flex-direction: column; gap: 2px; }
        .fac_info_value { text-align: left; }
        .fac_lb_nav { width: 38px; height: 38px; font-size: 24px; }
        .fac_lb_nav { width: 38px; height: 38px; font-size: 24px; }
    }

        /* Turn off the theme's own image animation so only the zoom-in plays */
    .fac_detail .td_faq_1_img {
        transform: none !important;
        animation: none !important;
        transition: none !important;
    }
</style>
@endpush

@push('scripts')
@if ($photos->isNotEmpty())
<script>
(function () {
    function init() {
        var photos = @json($photos);
        var title  = @json($facility->title);
        var tiles  = Array.prototype.slice.call(document.querySelectorAll('.fac_gallery_item'));
        var lb     = document.getElementById('facLb');
        if (!tiles.length || !lb) return;

        document.body.appendChild(lb); // keep it clear of theme wrappers

        var stage   = lb.querySelector('.fac_lb_stage');
        var titleEl = lb.querySelector('.fac_lb_title');
        var countEl = lb.querySelector('.fac_lb_counter');
        var thumbs  = lb.querySelector('.fac_lb_thumbs');
        var prevBtn = lb.querySelector('.fac_lb_prev');
        var nextBtn = lb.querySelector('.fac_lb_next');
        var current = 0;

        // hide arrows / thumbs when there is only one photo
        if (photos.length < 2) {
            prevBtn.style.display = nextBtn.style.display = thumbs.style.display = 'none';
        }

        /* ----- thumbnail strip (built once) ----- */
        photos.forEach(function (src, i) {
            var b = document.createElement('button');
            b.type = 'button';
            b.className = 'fac_lb_thumb';
            b.setAttribute('aria-label', 'Show photo ' + (i + 1));
            var im = document.createElement('img');
            im.src = src; im.alt = ''; im.loading = 'lazy';
            b.appendChild(im);
            b.addEventListener('click', function () { show(i); });
            thumbs.appendChild(b);
        });

        function show(i) {
            current = (i + photos.length) % photos.length;

            stage.innerHTML = '';
            var img = document.createElement('img');
            img.src = photos[current];
            img.alt = title + ' photo ' + (current + 1);
            stage.appendChild(img);

            titleEl.textContent = title;
            countEl.textContent = (current + 1) + ' / ' + photos.length;

            var all = thumbs.children;
            for (var k = 0; k < all.length; k++) all[k].classList.toggle('is-active', k === current);
            if (all[current] && all[current].scrollIntoView) {
                all[current].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }

            // preload neighbours for instant next/prev
            [current + 1, current - 1].forEach(function (n) {
                var p = new Image(); p.src = photos[(n + photos.length) % photos.length];
            });
        }

        function open(i) {
            show(i);
            lb.classList.add('is-open');
            lb.setAttribute('aria-hidden', 'false');
            document.body.classList.add('fac_lb_lock');
        }

        function close() {
            lb.classList.remove('is-open');
            lb.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('fac_lb_lock');
            stage.innerHTML = '';
        }

        tiles.forEach(function (tile) {
            tile.addEventListener('click', function (e) {
                e.preventDefault();
                open(parseInt(tile.getAttribute('data-index'), 10) || 0);
            });
        });

        prevBtn.addEventListener('click', function () { show(current - 1); });
        nextBtn.addEventListener('click', function () { show(current + 1); });
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
            if (sx === null || photos.length < 2) return;
            var dx = e.changedTouches[0].clientX - sx;
            if (Math.abs(dx) > 50) show(current + (dx < 0 ? 1 : -1));
            sx = null;
        });
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
</script>
@endif
@endpush