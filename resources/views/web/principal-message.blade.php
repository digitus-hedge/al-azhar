@extends('web.layouts.app')

@section('title', ($principal?->meta_title ?: "Principal's Message") . ' || Al Azhar Central School, Mala')
@section('meta_description', $principal?->meta_description
    ?: 'A message from the Principal of Al Azhar Central School, Mala, on our vision, values and commitment to every student.')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@section('content')

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('images/header.jpeg') }}"
    style="background-image: url('{{ asset('images/header.jpeg') }}');">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10 wow fadeInDown" data-wow-duration="0.9s" data-wow-delay="0.2s">Principal's Message</h1>
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

    <!-- Start Principal Message Section -->
    <div class="td_height_100 td_height_lg_50"></div>

    @if ($principal)
        {{-- This block uses its own pm_ layout classes (not the theme's td_faq_1 ones),
             so the photo and the text always start at the same top line. --}}
        <div class="pm_wrap" id="pmWrap">

            {{-- Left: photo --}}
            <div class="pm_left wow zoomIn" data-wow-duration="1.1s" data-wow-delay="0.2s">
                @if ($principal->photo_url)
                    <img class="pm_photo" src="{{ $principal->photo_url }}" alt="{{ $principal->name }}">
                @else
                    <div class="pm_photo pm_photo_fallback td_center">
                        <span class="pm_initial td_white_color">{{ $principal->initial }}</span>
                    </div>
                @endif
            </div>

            {{-- Right: heading, message, name, sign --}}
            <div class="pm_right">
                <div class="td_section_heading td_style_1 td_mb_30 pm_heading">
                    <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color wow fadeInDown" data-wow-delay="0.2s">
                        Principal's Message
                    </p>
                    <h2 class="td_section_title td_fs_48 mb-0 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.35s">{{ $principal->heading }}</h2>

                    <span class="pm_quote td_accent_color" aria-hidden="true">
                        <svg width="65" height="46" viewBox="0 0 65 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.08"
                                d="M13.9286 26.6H1V1H26.8571V27.362L17.956 45H6.26764L14.8213 28.0505L15.5534 26.6H13.9286ZM51.0714 26.6H38.1429V1H64V27.362L55.0988 45H43.4105L51.9642 28.0505L52.6962 26.6H51.0714Z"
                                fill="currentColor" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </span>
                </div>

                <div class="pm_message td_fs_18 td_heading_color wow fadeInUp" id="pmMessage" data-wow-duration="1s" data-wow-delay="0.5s">
                    @php
                        $message = trim((string) $principal->excerpt);
                        $isHtml  = $message !== strip_tags($message);
                    @endphp

                    @if ($isHtml)
                        {{-- Editor HTML: keep formatting, drop anything unsafe (scripts, iframes, etc.) --}}
                        {!! strip_tags($message, '<p><br><strong><b><em><i><u><ul><ol><li><a><h3><h4><h5><span><blockquote>') !!}
                    @else
                        @foreach (preg_split('/\R{2,}/', $message) as $para)
                            @if (trim($para) !== '')
                                <p>{!! nl2br(e(trim($para))) !!}</p>
                            @endif
                        @endforeach
                    @endif
                </div>

                <div class="pm_sign_block wow fadeInUp" data-wow-delay="0.3s">
                    <span class="pm_signature td_heading_color wow fadeInLeft" data-wow-duration="1.2s" data-wow-delay="0.5s">{{ $principal->name }}</span>
                    <h3 class="td_fs_24 td_semibold mb-0">{{ $principal->name }}</h3>
                    <p class="td_fs_16 mb-0 td_heading_color td_opacity_7">Principal, Al Azhar Central School</p>
                </div>
            </div>
        </div>
    @else
        <div class="container text-center">
            <p class="td_fs_18 mb-0">The Principal's message will be published soon.</p>
        </div>
    @endif

    <div class="td_height_100 td_height_lg_50"></div>
    <!-- End Principal Message Section -->

@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
<style>
    html, body { overflow-x: clip; }
    section, .pm_wrap { overflow-x: clip; }

    @keyframes fadeInLeft  { from { opacity: 0; transform: translate3d(-60px,0,0); } to { opacity: 1; transform: none; } }
    @keyframes fadeInRight { from { opacity: 0; transform: translate3d(60px,0,0); }  to { opacity: 1; transform: none; } }
    @keyframes fadeInUp    { from { opacity: 0; transform: translate3d(0,50px,0); }  to { opacity: 1; transform: none; } }
    @keyframes fadeInDown  { from { opacity: 0; transform: translate3d(0,-40px,0); } to { opacity: 1; transform: none; } }
    @keyframes zoomIn      { from { opacity: 0; transform: scale(.85); } }

    /* =====================================================================
       Settings you can change
       ===================================================================== */
    .pm_wrap {
        --pm-height: clamp(560px, 80vh, 700px);   /* height of the photo on side-by-side screens */
        --pm-sticky-top: 110px;                   /* header height + a small gap */
        --pm-photo-pos: center top;               /* which part of the photo stays visible */
    }

    /* ---------- Layout: stacked by default (tablet / phone) ---------- */
    .pm_wrap { display: flex; flex-direction: column; }

    .pm_left { width: 100%; height: 480px; background-color: #f4f5f7; }
    .pm_photo {
        display: block;
        width: 100%;
        height: 100%;
        max-width: none;
        object-fit: cover;
        object-position: var(--pm-photo-pos);
    }
    .pm_photo_fallback { background-color: var(--heading-color); }
    .pm_initial { font-size: 180px; line-height: 1; font-weight: 700; opacity: .9; }

    .pm_right { width: 100%; max-width: 720px; margin: 0 auto; padding: 45px 12px 0; }

    /* Heading + quote mark */
    .pm_heading { position: relative; }
    .pm_quote { position: absolute; right: 0; bottom: -6px; pointer-events: none; }

    /* Message */
    .pm_message { position: relative; line-height: 1.75em; opacity: .85; }
    .pm_message p { margin-bottom: 20px; }
    .pm_message p:last-of-type { margin-bottom: 0; }

    /* Name + signature */
    .pm_sign_block {
        margin-top: 40px;
        padding-top: 25px;
        border-top: 1px solid #E6E0FF;
        position: relative;
    }
    .pm_sign_block::before {
        content: "";
        position: absolute;
        top: -2px; left: 0;
        width: 60px; height: 3px;
        border-radius: 5px;
        background-color: var(--accent-color);
    }
    .pm_signature {
        display: block;
        font-family: "Great Vibes", cursive;
        font-size: 46px;
        line-height: 1.1;
        margin-bottom: 8px;
        transform: rotate(-3deg);
        transform-origin: left center;
        opacity: .9;
    }

    /* ---------- Side by side (desktop / laptop): photo stays in view, text scrolls with the page ---------- */
    @media (min-width: 992px) {
        .pm_wrap {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            align-items: start;                       /* photo and text start on the same top line */
        }

        /* Photo: fixed height, sticks below the header while the long message scrolls past */
        .pm_left {
            height: var(--pm-height);
            position: sticky;
            top: var(--pm-sticky-top);
        }

        /* Text: full message, as tall as it needs to be */
        .pm_right {
            max-width: none;
            margin: 0;
            padding: 4px clamp(24px, 3.2vw, 60px) 4px clamp(40px, 6vw, 115px);
        }
    }

    /* ---------- Smaller screens ---------- */
    @media (max-width: 1199px) {
        .pm_initial { font-size: 140px; }
    }
    @media (max-width: 767px) {
        .pm_right { max-width: 540px; }
    }
    @media (max-width: 575px) {
        .pm_left { height: 360px; }
        .pm_right { padding-top: 36px; }
        .pm_message { line-height: 1.65em; }
        .pm_signature { font-size: 38px; }
        .pm_quote svg { width: 48px; height: 34px; }
        .pm_initial { font-size: 110px; }
    }
</style>
@endpush