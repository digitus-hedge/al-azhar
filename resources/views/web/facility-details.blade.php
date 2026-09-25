@extends('web.layouts.app')

@section('title', ($facility->meta_title ?: $facility->title) . ' || AL-Azhar')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@php
    $placeholder = 'data:image/svg+xml;utf8,' . rawurlencode(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 280"><rect width="400" height="280" fill="#eef0f7"/><path d="M150 180l40-50 30 36 20-24 50 38z" fill="#c9cde0"/><circle cx="160" cy="105" r="18" fill="#c9cde0"/></svg>'
    );

    $related = $related ?? collect();

    // Cover + gallery together for the photo grid / lightbox
    $photos = collect([$facility->image_url])->merge($facility->gallery_urls)->filter()->values();

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
        data-src="{{ asset('uploads/website-images/students-after-graduation-ceremony.jpg') }}">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">{{ $facility->title }}</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('facilities.index') }}">Facilities</a></li>
                    <li class="breadcrumb-item active">{{ $facility->title }}</li>
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
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    {{ $facility->category_label }}
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">{{ $facility->title }}</h2>
                @if ($facility->short_description)
                    <p class="td_section_subtitle td_fs_18 mb-0">{{ $facility->short_description }}</p>
                @endif
            </div>

            @php $firstOpen = true; @endphp
            <div class="td_accordians td_style_1 td_type_2 td_mb_40 fac_acc">
                @if (filled($description))
                    <div class="td_accordian {{ $firstOpen ? 'active' : '' }}">
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
                    <div class="td_accordian {{ $firstOpen ? 'active' : '' }}">
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
                    <div class="td_accordian {{ $firstOpen ? 'active' : '' }}">
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

            <a href="{{ route('contact.index') }}" class="td_btn td_style_2 td_type_2 td_heading_color td_medium">
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
    @if ($photos->count() > 1)
        <section>
            <div class="td_height_100 td_height_lg_50"></div>
            <div class="container">
                <div class="td_section_heading td_style_1 text-center">
                    <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                        <i></i> Gallery <i></i>
                    </p>
                    <h2 class="td_section_title td_fs_48 mb-0">Take a Closer Look</h2>
                </div>
                <div class="td_height_50 td_height_lg_40"></div>
                <div class="fac_gallery">
                    @foreach ($photos as $i => $photo)
                        <button type="button" class="fac_gallery_item" data-index="{{ $i }}"
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

        {{-- Lightbox --}}
        <div class="modal fade fac_lightbox" id="facLightbox" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <button type="button" class="fac_lb_close td_center" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    <button type="button" class="fac_lb_nav fac_lb_prev td_center" aria-label="Previous">&#8249;</button>
                    <img src="" alt="{{ $facility->title }}" class="fac_lb_img">
                    <button type="button" class="fac_lb_nav fac_lb_next td_center" aria-label="Next">&#8250;</button>
                    <p class="fac_lb_counter td_fs_14 mb-0"></p>
                </div>
            </div>
        </div>
    @endif

    {{-- Other facilities (same card style as the listing page) --}}
    @if ($related->isNotEmpty())
        <section>
            <div class="td_height_100 td_height_lg_50"></div>
            <div class="container">
                <div class="td_section_heading td_style_1 td_type_1">
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
                        <div class="col-xl-3 col-lg-4 col-md-6 d-flex">
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

    /* Lightbox */
    .fac_lightbox .modal-content { background: transparent; border: 0; position: relative; align-items: center; }
    .fac_lb_img { max-width: 100%; max-height: 80vh; border-radius: 10px; object-fit: contain; }
    .fac_lb_close, .fac_lb_nav {
        position: absolute; z-index: 2;
        width: 46px; height: 46px; border-radius: 50%; border: 0;
        background-color: #fff; color: var(--heading-color);
        font-size: 30px; line-height: 1;
    }
    .fac_lb_close { top: -58px; right: 0; }
    .fac_lb_prev { left: 10px; top: 50%; transform: translateY(-50%); }
    .fac_lb_next { right: 10px; top: 50%; transform: translateY(-50%); }
    .fac_lb_nav:hover, .fac_lb_close:hover { background-color: var(--accent-color); color: #fff; }
    .fac_lb_counter { color: #fff; margin-top: 12px; }

    /* Related cards */
    .fac_rel_card { width: 100%; background-color: #fff; }
    .fac_rel_card .td_card_thumb img { aspect-ratio: 16 / 11; object-fit: cover; }

    /* ---------- Responsive ---------- */
    @media (max-width: 1199px) {
        .fac_gallery { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 991px) {
        /* Theme puts the image below the text here - keep it on top */
        .td_faq_1.td_style_1.td_type_1.fac_detail { flex-direction: column; }
        .fac_detail .td_faq_1_img { min-height: 420px; }
        .fac_gallery { grid-template-columns: repeat(2, 1fr); gap: 15px; }
    }
    @media (max-width: 767px) {
        .fac_rel_card .td_card_btn { margin-bottom: 0; }
        .fac_rel_card:hover .td_card_info { margin-top: 0; }
    }
    @media (max-width: 575px) {
        .fac_detail .td_faq_1_img { min-height: 280px; }
        .fac_gallery { gap: 10px; }
        .fac_info li { flex-direction: column; gap: 2px; }
        .fac_info_value { text-align: left; }
        .fac_lb_nav { width: 38px; height: 38px; font-size: 24px; }
    }
</style>
@endpush

@push('scripts')
@if ($photos->count() > 1)
<script>
    $(function () {
        var photos = @json($photos);
        var current = 0;
        var el = document.getElementById('facLightbox');
        var modal = bootstrap.Modal.getOrCreateInstance(el);

        function show(i) {
            current = (i + photos.length) % photos.length;
            $('.fac_lb_img').attr('src', photos[current]);
            $('.fac_lb_counter').text((current + 1) + ' / ' + photos.length);
        }

        $('.fac_gallery_item').on('click', function () {
            show(parseInt($(this).data('index'), 10));
            modal.show();
        });
        $('.fac_lb_prev').on('click', function () { show(current - 1); });
        $('.fac_lb_next').on('click', function () { show(current + 1); });

        $(document).on('keydown', function (e) {
            if (!el.classList.contains('show')) return;
            if (e.key === 'ArrowLeft') show(current - 1);
            if (e.key === 'ArrowRight') show(current + 1);
        });
    });
</script>
@endif
@endpush