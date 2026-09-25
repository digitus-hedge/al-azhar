@extends('web.layouts.app')

@section('title', 'Facilities || AL-Azhar')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@section('content')

    @php
    $facilities = $facilities ?? collect();
    $categories = $categories ?? \App\Models\Facility::CATEGORIES;
    $counts     = $counts ?? $facilities->countBy('category');
    $active     = $active ?? '';

    $placeholder = 'data:image/svg+xml;utf8,' . rawurlencode(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 280"><rect width="400" height="280" fill="#eef0f7"/><path d="M150 180l40-50 30 36 20-24 50 38z" fill="#c9cde0"/><circle cx="160" cy="105" r="18" fill="#c9cde0"/></svg>'
    );
    $visibleCount = $active === '' ? $facilities->count() : ($counts[$active] ?? 0);
@endphp

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
        data-src="{{ asset('uploads/website-images/students-after-graduation-ceremony.jpg') }}">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">Facilities</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Facilities</li>
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

    <!-- Start Facilities Grid -->
    <section>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">

            @if ($facilities->isEmpty())
                <p class="text-center td_fs_18 mb-0">Facilities will appear here soon.</p>
            @else

                {{-- Top bar: tabs (one row) + count --}}
                <div class="td_section_head_2 fac_head">
                    <ul class="td_tab_links td_style_2 td_mp_0 td_medium td_heading_color fac_tabs">
                        <li class="{{ $active === '' ? 'active' : '' }}">
                            <a href="{{ route('facilities.index') }}" data-filter="">
                                All <span class="fac_count">{{ $facilities->count() }}</span>
                            </a>
                        </li>
                        @foreach ($categories as $key => $label)
                            @if (($counts[$key] ?? 0) > 0)
                                <li class="{{ $active === $key ? 'active' : '' }}">
                                    <a href="{{ route('facilities.index', ['category' => $key]) }}" data-filter="{{ $key }}">
                                        {{ $label }} <span class="fac_count">{{ $counts[$key] }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                    <span class="td_heading_color td_medium fac_showing">
                        Showing <span id="fac_visible">{{ $visibleCount }}</span> of {{ $facilities->count() }} Facilities
                    </span>
                </div>
                <div class="td_height_60 td_height_lg_40"></div>

                {{-- Cards --}}
                <div class="row td_gap_y_30 td_row_gap_30">
                    @foreach ($facilities as $facility)
                        @php $url = route('facilities.show', $facility); @endphp
                        <div class="col-lg-4 col-md-6 fac_item {{ $active !== '' && $facility->category !== $active ? 'd-none' : '' }}"
                            data-category="{{ $facility->category }}">
                            <div class="td_card td_style_3 d-block td_radius_10 fac_card">

                                @if ($facility->photo_count > 1)
                                    <span class="td_cart_wishlist_icon fac_photo_badge" title="{{ $facility->photo_count }} photos">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                        <b>{{ $facility->photo_count }}</b>
                                    </span>
                                @endif

                                <a href="{{ $url }}" class="td_card_thumb">
                                    <img src="{{ $facility->image_url ?: $placeholder }}" alt="{{ $facility->title }}" loading="lazy">
                                </a>

                                <div class="td_card_info td_white_bg">
                                    <div class="td_card_info_in">

                                        @if ($facility->capacity || $facility->location)
                                            <ul class="td_card_meta td_mp_0 td_fs_18 td_medium td_heading_color">
                                                @if ($facility->capacity)
                                                    <li>
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8"/></svg>
                                                        <span class="td_opacity_7">{{ number_format($facility->capacity) }} Capacity</span>
                                                    </li>
                                                @endif
                                                @if ($facility->location)
                                                    <li class="fac_meta_location">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                                        <span class="td_opacity_7">{{ $facility->location }}</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        @endif

                                        <div class="td_card_category_df td_mb_14">
                                            <a href="{{ route('facilities.index', ['category' => $facility->category]) }}"
                                                class="td_card_category td_fs_14 td_normal td_heading_color fac_cat_link"
                                                data-filter="{{ $facility->category }}">
                                                <span>{{ $facility->category_label }}</span>
                                            </a>
                                            @if ($facility->timings)
                                                <span class="td_card_price td_fs_14 td_medium fac_timing">{{ $facility->timings }}</span>
                                            @endif
                                        </div>

                                        <h2 class="td_card_title td_fs_24 td_mb_16">
                                            <a href="{{ $url }}">{{ $facility->title }}</a>
                                        </h2>

                                        @if ($facility->short_description)
                                            <p class="td_card_subtitle td_heading_color td_opacity_7 td_mb_20">
                                                {{ $facility->short_description }}
                                            </p>
                                        @endif

                                        @if (! empty($facility->features))
                                            <ul class="td_mp_0 fac_features td_fs_14 td_heading_color">
                                                @foreach (array_slice($facility->features, 0, 3) as $feature)
                                                    <li>
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5" /></svg>
                                                        <span>{{ $feature }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif

                                        <div class="td_card_btn">
                                            <a href="{{ $url }}" class="td_btn td_style_1 td_radius_30 td_medium">
                                                <span class="td_btn_in td_white_color td_accent_bg">
                                                    <span>View Details</span>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Facilities Grid -->

@endsection

@push('styles')
<style>
    /* ---------- Top bar ---------- */
    .fac_head { flex-wrap: nowrap; align-items: center; }
    .fac_tabs {
        flex-wrap: nowrap !important;
        overflow-x: auto;
        scrollbar-width: none;
        padding: 4px 4px 10px;
        margin: -4px -4px -10px;
        min-width: 0;
    }
    .fac_tabs::-webkit-scrollbar { display: none; }
    .fac_tabs li { flex: none; }
    .fac_tabs li a { align-items: center; gap: 8px; white-space: nowrap; }
    .fac_count {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 24px; height: 22px; padding: 0 7px;
        border-radius: 20px; font-size: 13px; line-height: 1;
        background-color: rgba(0, 47, 95, 0.1); color: var(--accent-color);
    }
    .fac_tabs .active .fac_count { background-color: #fff; }
    .fac_showing { flex: none; white-space: nowrap; }

    /* ---------- Cards ---------- */
    .fac_item { display: flex; }
    .fac_item.d-none { display: none !important; }
    .fac_card { width: 100%; background-color: #fff; }
    .fac_card .td_card_thumb img { aspect-ratio: 16 / 11; object-fit: cover; }

    .fac_photo_badge { width: auto !important; padding: 0 12px; gap: 6px; color: var(--heading-color) !important; font-size: 14px; }
    .fac_photo_badge b { font-weight: 600; }

    .fac_card .td_card_meta { flex-wrap: wrap; row-gap: 6px; font-size: 16px; }
    .fac_card .td_card_meta svg { color: var(--accent-color); flex: none; }
    .fac_meta_location { min-width: 0; }
    .fac_meta_location span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    .fac_card .td_card_category_df { gap: 10px; }
    .fac_timing { max-width: 55%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    .fac_features li { display: flex; gap: 8px; align-items: flex-start; }
    .fac_features li:not(:last-child) { margin-bottom: 6px; }
    .fac_features svg { flex: none; margin-top: 4px; color: var(--accent-color); }
    .fac_features span { opacity: .8; }

    .fac_item.fac_in { animation: facIn .45s ease both; }
    @keyframes facIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: none; } }

    /* ---------- Responsive ---------- */
    @media (max-width: 991px) {
        .fac_head { flex-direction: column-reverse; align-items: flex-start; gap: 15px; }
        .fac_tabs { max-width: 100%; }
    }
    @media (max-width: 767px) {
        .fac_head { align-items: stretch; }
        .fac_tabs { width: calc(100% + 8px); }
        .fac_tabs li a { padding: 8px 16px; font-size: 15px; }
        /* No hover on touch: always show the button */
        .fac_card .td_card_btn { margin-bottom: 0; }
        .fac_card:hover .td_card_info { margin-top: 0; }
    }
</style>
@endpush

@push('scripts')
<script>
    $(function () {
        function applyFilter(filter, href) {
            $('.fac_tabs li').removeClass('active')
                .find('a[data-filter="' + filter + '"]').parent().addClass('active');

            var visible = 0;
            $('.fac_item').each(function () {
                var show = filter === '' || $(this).data('category') === filter;
                $(this).toggleClass('d-none', !show).removeClass('fac_in');
                if (show) { visible++; void this.offsetWidth; $(this).addClass('fac_in'); }
            });
            $('#fac_visible').text(visible);

            // keep the active tab in view on phones
            var $tab = $('.fac_tabs li.active')[0];
            if ($tab) $tab.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });

            history.replaceState(null, '', href);
        }

        // Tabs + category chip on each card
        $('.fac_tabs a, .fac_cat_link').on('click', function (e) {
            e.preventDefault();
            applyFilter(String($(this).data('filter') || ''), this.href);
            if ($(this).hasClass('fac_cat_link')) {
                $('html, body').animate({ scrollTop: $('.fac_head').offset().top - 140 }, 400);
            }
        });
    });
</script>
@endpush