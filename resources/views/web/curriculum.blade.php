@extends('web.layouts.app')

@section('title', 'Curriculum || Al Azhar Central School, Mala')
@section('meta_description', 'Explore the curriculum at Al Azhar Central School, Mala — a holistic learning framework blending academic rigor, values, and skills.')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@section('content')

    @php
        $curriculums = $curriculums ?? collect();
    @endphp

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('images/header.jpeg') }}"
    style="background-image: url('{{ asset('images/header.jpeg') }}');">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10 wow fadeInDown" data-wow-duration="0.9s" data-wow-delay="0.2s">Curriculum</h1>
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

    <!-- Start Curriculum Grid -->
    <section>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">

            {{-- Section intro --}}
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    <i></i> Our Curriculum <i></i>
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">A Framework for Holistic Learning</h2>
                <div class="d-flex justify-content-center">
                    <p class="td_section_subtitle td_fs_18 mb-0 cur_intro">
                        Discover the structured yet flexible curriculum designed to nurture every student's intellectual, moral and personal growth.
                    </p>
                </div>
            </div>
            <div class="td_height_60 td_height_lg_40"></div>

            @if ($curriculums->isEmpty())
                <div class="cur_empty wow fadeInUp" data-wow-delay="0.2s">
                    <span class="cur_empty_icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                    </span>
                    <h3>No Curriculum Items Yet</h3>
                    <p>Curriculum details will appear here once they are added.</p>
                </div>
            @else
                <div class="row td_gap_y_30 td_row_gap_30">
                    @foreach ($curriculums as $i => $curriculum)
                        @php
                            $hasImage = !empty($curriculum->image);
                            $anim    = ['fadeInLeft', 'fadeInUp', 'fadeInRight'][$i % 3];
                            $delay   = 0.1 + ($i % 3) * 0.12;
                        @endphp

                        <div class="col-lg-4 col-md-6 cur_item">
                            <div class="cur_card {{ $hasImage ? 'cur_card_has_image' : 'cur_card_no_image' }} td_radius_10 wow {{ $anim }}"
                                data-wow-duration="0.9s" data-wow-delay="{{ $delay }}s">

                                @if ($hasImage)
                                    <div class="cur_card_thumb">
                                        <img src="{{ asset('storage/' . $curriculum->image) }}" alt="{{ $curriculum->title }}" loading="lazy">
                                    </div>
                                @else
                                    <div class="cur_card_badge">
                                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                            <path d="M9 7h7M9 11h5"/>
                                        </svg>
                                    </div>
                                @endif

                                <div class="cur_card_body">
                                    <span class="cur_card_number">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <h3 class="cur_card_title">{{ $curriculum->title }}</h3>
                                    @if ($curriculum->description)
                                        <div class="cur_card_desc">
                                            {!! $curriculum->description !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Curriculum Grid -->

@endsection

@push('styles')
<style>
    .cur_intro { max-width: 720px; }

    /* ---------- Card ---------- */
    .cur_item { display: flex; }
    .cur_card {
        width: 100%;
        background: #fff;
        border: 1px solid #eceef5;
        box-shadow: 0 15px 40px -25px rgba(0, 0, 27, .25);
        display: flex; flex-direction: column;
        overflow: hidden;
        transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
        position: relative;
    }
    .cur_card::before {
        content: ""; position: absolute;
        top: 0; left: 0; right: 0; height: 4px;
        background: linear-gradient(90deg, var(--heading-color, #00539B), #002F5F);
        transform: scaleX(0); transform-origin: left;
        transition: transform .4s ease;
    }
    .cur_card:hover {
        transform: translateY(-6px);
        box-shadow: 0 30px 50px -25px rgba(0, 47, 95, .35);
        border-color: rgba(0, 83, 155, .25);
    }
    .cur_card:hover::before { transform: scaleX(1); }

    /* ---------- With image ---------- */
    .cur_card_thumb {
        aspect-ratio: 16 / 11;
        overflow: hidden; background: #eef0f7;
    }
    .cur_card_thumb img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .5s ease;
    }
    .cur_card_has_image:hover .cur_card_thumb img { transform: scale(1.05); }

    /* ---------- No image (badge instead) ---------- */
    .cur_card_badge {
        display: flex; align-items: center; justify-content: center;
        width: 60px; height: 60px; border-radius: 16px;
        background: linear-gradient(135deg, var(--heading-color, #00539B), #002F5F);
        color: #fff;
        margin: 28px 28px 0;
        box-shadow: 0 15px 30px -10px rgba(0, 47, 95, .4);
        transition: transform .35s ease;
    }
    .cur_card_no_image:hover .cur_card_badge {
        transform: rotate(-6deg) scale(1.08);
    }

    /* ---------- Body ---------- */
    .cur_card_body {
        padding: 24px 28px 28px;
        flex: 1; display: flex; flex-direction: column;
        position: relative;
    }
    .cur_card_number {
        position: absolute; top: 20px; right: 24px;
        font-size: 42px; font-weight: 800;
        color: rgba(0, 83, 155, .08);
        line-height: 1;
        font-family: Georgia, serif;
        transition: color .35s ease;
    }
    .cur_card:hover .cur_card_number { color: rgba(0, 83, 155, .18); }

    .cur_card_title {
        font-size: 20px; font-weight: 700;
        line-height: 1.35;
        color: var(--heading-color, #00539B);
        margin: 0 0 14px;
        padding-right: 50px;
    }
    .cur_card_desc {
        font-size: 14.5px; line-height: 1.7;
        color: #5b6477;
    }
    .cur_card_desc > *:first-child { margin-top: 0; }
    .cur_card_desc > *:last-child { margin-bottom: 0; }
    .cur_card_desc p { margin: 0 0 10px; }
    .cur_card_desc h1, .cur_card_desc h2, .cur_card_desc h3,
    .cur_card_desc h4, .cur_card_desc h5, .cur_card_desc h6 {
        color: var(--heading-color, #00539B);
        font-weight: 600; font-size: 16px;
        margin: 14px 0 8px;
    }
    .cur_card_desc ul, .cur_card_desc ol {
        padding-left: 0; margin: 0 0 12px;
        list-style: none;
    }
    .cur_card_desc li {
        position: relative;
        padding-left: 22px; margin-bottom: 6px;
    }
    .cur_card_desc li::before {
        content: "";
        position: absolute; left: 0; top: 8px;
        width: 12px; height: 12px; border-radius: 50%;
        background: var(--heading-color, #00539B) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 6 9 17l-5-5'/%3E%3C/svg%3E") center / 8px no-repeat;
    }
    .cur_card_desc a {
        color: var(--heading-color, #00539B);
        text-decoration: underline;
    }
    .cur_card_desc strong, .cur_card_desc b { color: var(--heading-color, #00539B); }
    .cur_card_desc blockquote {
        margin: 10px 0; padding: 10px 14px;
        border-left: 3px solid var(--heading-color, #00539B);
        background: rgba(0, 83, 155, .05);
        border-radius: 0 8px 8px 0;
        font-style: italic;
    }
    .cur_card_desc img { max-width: 100%; height: auto; border-radius: 8px; margin: 10px 0; }

    /* ---------- Empty state ---------- */
    .cur_empty {
        max-width: 520px; margin: 0 auto;
        text-align: center; padding: 50px 30px;
        background: #fff;
        border: 2px dashed #e6eaf2; border-radius: 18px;
    }
    .cur_empty_icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 80px; height: 80px; border-radius: 50%;
        background: rgba(0, 83, 155, .08);
        color: var(--heading-color, #00539B);
        margin-bottom: 18px;
    }
    .cur_empty h3 {
        font-size: 22px; font-weight: 700;
        color: var(--heading-color, #00539B); margin: 0 0 8px;
    }
    .cur_empty p { color: #6b7489; font-size: 15px; margin: 0; }

    /* ---------- Responsive ---------- */
    @media (max-width: 767px) {
        .cur_card_body { padding: 22px 22px 24px; }
        .cur_card_badge { margin: 22px 22px 0; }
        .cur_card_title { font-size: 18px; padding-right: 40px; }
        .cur_card_number { font-size: 36px; }
    }
</style>
@endpush