@extends('web.layouts.app')

@section('title', 'Home || AL-Azhar')

@section('content')

  <!-- Start Hero Section -->
<section class="td_hero td_style_1 td_heading_bg td_center td_hero_carousel_wrap">

    {{-- Background image carousel: loops through all banner images (up to 5) --}}
    <div class="td_hero_bg_carousel">
        @if($banner && !empty($banner->images))
            @foreach($banner->images as $image)
                <div class="td_hero_bg_slide" style="background-image: url('{{ Storage::url($image) }}');"></div>
            @endforeach
        @else
            <div class="td_hero_bg_slide" style="background-image: url('{{ asset('uploads/website-images/students-after-graduation-ceremony.jpg') }}');"></div>
        @endif
    </div>

    <div class="container">
        <div class="td_hero_text wow fadeInRight" data-wow-duration="0.9s" data-wow-delay="0.35s">
            <p
                class="td_hero_subtitle_up td_fs_18 td_white_color td_spacing_1 td_semibold text-uppercase td_mb_10 td_opacity_9">
                Knowledge is Power</p>
            <h1 class="td_hero_title td_fs_64 td_white_color td_mb_12">
                @if($banner && $banner->title)
                    {{ $banner->title }}
                @else
                    <span>Educve</span> - The Best Place to Invest in your Knowledge
                @endif
            </h1>
            <p class="td_hero_subtitle td_fs_18 td_white_color td_opacity_7 td_mb_30">
                {{ $banner->description ?? 'A university is a vibrant institution that serves as a hub for higher education and research. It provides a dynamic environment.' }}
            </p>
            <a href="about-us.html" class="td_btn td_style_1 td_radius_30 td_medium">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>Explore Us</span>
                    <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>
            </a>
        </div>
    </div>
    <div class="td_lines">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</section>

<!-- End Hero Section -->

<style>
    /* Hero background carousel */
    .td_hero_carousel_wrap {
        position: relative;
        overflow: hidden;
    }

    .td_hero_bg_carousel {
        position: absolute;
        inset: 0;
        z-index: 0;
    }

    .td_hero_bg_carousel .slick-list,
    .td_hero_bg_carousel .slick-track {
        height: 100%;
    }

    .td_hero_bg_slide {
        position: relative;
        height: 100%;
        min-height: 650px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    /* keep the existing dark overlay (td_heading_bg) and content above the slides */
    .td_hero_carousel_wrap .container,
    .td_hero_carousel_wrap .td_lines {
        position: relative;
        z-index: 2;
    }

    .td_hero_carousel_wrap.td_heading_bg::before {
        z-index: 1;
    }

    /* single-image case: no slick controls needed, just show it statically */
    .td_hero_bg_carousel:not(.slick-initialized) .td_hero_bg_slide {
        display: none;
    }

    .td_hero_bg_carousel:not(.slick-initialized) .td_hero_bg_slide:first-child {
        display: block;
        width: 100%;
    }

    /* Fallback fade carousel (only when the slick plugin isn't available) */
    .td_hero_bg_carousel.hero_fade .td_hero_bg_slide {
        display: block; position: absolute; inset: 0; width: 100%;
        opacity: 0; transition: opacity 1s ease;
    }
    .td_hero_bg_carousel.hero_fade .td_hero_bg_slide.is-active { opacity: 1; }
</style>
@if (!empty($stats))
    @php
        // Icon picked from the stat's label (keywords), so it still matches after editing in admin.
        $statIconSet = [
            // Trophy — years / excellence / experience / awards
            'award' => '<svg width="22" height="22" style="flex-shrink:0;min-width:22px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M8 21h8M12 17v4M7 4h10v5a5 5 0 0 1-10 0V4z"/><path d="M17 5h2.5a1.5 1.5 0 0 1 1.5 1.5V7a4 4 0 0 1-4 4M7 5H4.5A1.5 1.5 0 0 0 3 6.5V7a4 4 0 0 0 4 4"/></svg>',
            // Graduation cap — students / enrolled / alumni
            'students' => '<svg width="22" height="22" style="flex-shrink:0;min-width:22px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M22 9 12 4 2 9l10 5 10-5z"/><path d="M6 11v5c0 1.7 2.7 3 6 3s6-1.3 6-3v-5"/><path d="M22 9v6"/></svg>',
            // Teacher at board — faculty / teachers / staff
            'faculty' => '<svg width="22" height="22" style="flex-shrink:0;min-width:22px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><circle cx="7" cy="7" r="3"/><path d="M2 21v-2a5 5 0 0 1 5-5h2l4-3"/><path d="M11 3h10v10H14"/></svg>',
            // Badge with tick — pass / result / percentage / success
            'pass' => '<svg width="22" height="22" style="flex-shrink:0;min-width:22px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M12 2l2.4 1.8 3-.2.9 2.9 2.5 1.7-1 2.8 1 2.8-2.5 1.7-.9 2.9-3-.2L12 22l-2.4-1.8-3 .2-.9-2.9-2.5-1.7 1-2.8-1-2.8 2.5-1.7.9-2.9 3 .2L12 2z"/><path d="m8.5 12 2.3 2.3 4.7-4.6"/></svg>',
            // Book — courses / programs / subjects / classes
            'courses' => '<svg width="22" height="22" style="flex-shrink:0;min-width:22px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M2 5a2 2 0 0 1 2-2h6v17H4a2 2 0 0 0-2 2V5zM22 5a2 2 0 0 0-2-2h-6v17h6a2 2 0 0 1 2 2V5z"/></svg>',
            // Star — anything else
            'default' => '<svg width="22" height="22" style="flex-shrink:0;min-width:22px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="m12 2 3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2z"/></svg>',
        ];

        $statKeywords = [
            'award'    => ['year', 'excellence', 'experience', 'award', 'legacy', 'since'],
            'students' => ['student', 'enroll', 'alumni', 'learner', 'pupil'],
            'faculty'  => ['faculty', 'teacher', 'staff', 'instructor', 'mentor', 'tutor'],
            'pass'     => ['pass', 'result', 'percent', '%', 'success', 'rank'],
            'courses'  => ['course', 'program', 'subject', 'class', 'department'],
        ];

        $statIconFor = function ($label) use ($statIconSet, $statKeywords) {
            $label = \Illuminate\Support\Str::lower($label);
            foreach ($statKeywords as $key => $words) {
                if (\Illuminate\Support\Str::contains($label, $words)) {
                    return $statIconSet[$key];
                }
            }
            return $statIconSet['default'];
        };
    @endphp

    <div class="container">
        <div class="td_hero_btn_group">
            @foreach ($stats as $item)
                @php
                    $value = $item['value'] ?? $item['number'] ?? $item['count'] ?? '';
                    $label = $item['label'] ?? $item['title'] ?? '';
                @endphp

                @if ($value !== '' || $label !== '')
                    <a href="javascript:;" class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                        data-wow-duration="0.9s" data-wow-delay="0.35s">
                        <span class="td_btn_in td_white_color td_accent_bg">
                            <span>{{ $value }} {{ $label }}</span>
                            {!! $statIconFor($label . ' ' . $value) !!}
                        </span>
                    </a>
                @endif
            @endforeach
        </div>
    </div>

@endif
    <!-- End Hero Section -->


   <!-- Start About Section -->
@php
    $aboutShort = \Illuminate\Support\Str::limit(
        trim(preg_replace('/\s+/', ' ', strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], ' ', (string) ($about->description ?? ''))))),
        230
    );
@endphp
<section id="home-about">
    <div class="td_height_100 td_height_lg_50"></div>
    <div class="td_about td_style_1 home_about">
        <div class="container">
            <div class="row align-items-center td_gap_y_40">

                {{-- Left: two static images (theme layout) --}}
                <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.25s">
                    <div class="td_about_thumb_wrap">
                        <div class="td_about_thumb_1">
                            <img src="{{ asset('images/about2.jpeg') }}" alt="Al Azhar Central School campus">
                        </div>
                        <div class="td_about_thumb_2">
                            <img src="{{ asset('images/about.webp') }}" alt="Students at Al Azhar Central School">
                        </div>
                    </div>
                </div>

                {{-- Right: heading, short description, vision & mission --}}
                <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                    <div class="td_section_heading td_style_1 td_mb_30">
                        <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                            About us
                        </p>
                        <h2 class="td_section_title td_fs_48 mb-0">
                            {{ $about->title ?? 'Welcome to Al Azhar Central School' }}
                        </h2>
                        @if ($aboutShort !== '')
                            <p class="td_section_subtitle td_fs_18 mb-0">{{ $aboutShort }}</p>
                        @endif
                    </div>

                    <div class="td_mb_40">
                        <ul class="td_list td_style_5 td_mp_0">
                            <li>
                                <h3 class="td_fs_24 td_mb_8">Our Vision</h3>
                                <p class="td_fs_18 mb-0">To nurture confident, compassionate learners who excel in knowledge, character and service.</p>
                            </li>
                            <li>
                                <h3 class="td_fs_24 td_mb_8">Our Mission</h3>
                                <p class="td_fs_18 mb-0">To provide holistic, value-based education that brings out the best in every child.</p>
                            </li>
                        </ul>
                    </div>

                    <a href="{{ url('/about-us') }}" class="td_btn td_style_1 td_radius_30 td_medium">
                        <span class="td_btn_in td_white_color td_accent_bg">
                            <span>More About</span>
                            <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="td_height_100 td_height_lg_50"></div>
</section>

<style>
    /* Same image shapes as the theme demo, whatever size your photos are */
    .home_about .td_about_thumb_1 img,
    .home_about .td_about_thumb_2 img { width: 100%; object-fit: cover; display: block; }
    .home_about .td_about_thumb_1 img { aspect-ratio: 476 / 492; }   /* tall left photo */
    .home_about .td_about_thumb_2 img { aspect-ratio: 315 / 416; }   /* overlapping right photo */
</style>
<!-- End About Section -->

   <!-- Start Principal's Desk Preview -->
@if ($principal)
    @php
        $pmExcerpt = \Illuminate\Support\Str::limit(
            trim(preg_replace('/\s+/', ' ', strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], ' ', (string) $principal->excerpt)))),
            380
        );
    @endphp
    <section>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">
            <div class="td_features td_style_1 td_hobble home_pm">

                {{-- Left: principal photo from admin --}}
                <div class="td_features_thumb">
                    @if ($principal->photo_url)
                        <img src="{{ $principal->photo_url }}" alt="{{ $principal->name }}"
                            class="td_radius_10 wow fadeInUp home_pm_photo" data-wow-duration="1s" data-wow-delay="0.2s">
                    @else
                        <div class="td_radius_10 home_pm_photo home_pm_fallback"><span>{{ $principal->initial }}</span></div>
                    @endif
                </div>

                {{-- Right: message preview card --}}
                <div class="td_features_content td_white_bg td_radius_10 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.25s">
                    <div class="td_section_heading td_style_1">
                        <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                            Principal's Desk
                        </p>
                        <h2 class="td_section_title td_fs_48 mb-0">{{ $principal->heading }}</h2>
                    </div>
                    <div class="td_height_50 td_height_lg_50"></div>
                    <div class="home_pm_msg">
                        <svg class="home_pm_quote" width="46" height="32" viewBox="0 0 65 46" fill="currentColor" aria-hidden="true">
                            <path d="M13.9286 26.6H1V1H26.8571V27.362L17.956 45H6.26764L14.8213 28.0505L15.5534 26.6H13.9286ZM51.0714 26.6H38.1429V1H64V27.362L55.0988 45H43.4105L51.9642 28.0505L52.6962 26.6H51.0714Z"/>
                        </svg>
                        <p class="td_fs_18 td_heading_color mb-0">{{ $pmExcerpt }}</p>
                    </div>

                    <div class="home_pm_foot">
                        <div>
                            <span class="home_pm_sign">{{ $principal->name }}</span>
                            <h3 class="td_fs_20 td_semibold mb-0">{{ $principal->name }}</h3>
                            <p class="td_fs_14 mb-0 td_heading_color td_opacity_7">Principal, Al Azhar Central School</p>
                        </div>
                        <a href="{{ route('principal-message') }}" class="td_btn td_style_1 td_radius_30 td_medium">
                            <span class="td_btn_in td_white_color td_accent_bg">
                                <span>Read More</span>
                                <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>

                {{-- Keep your two decorative wave shapes here: paste the existing
                     <div class="td_features_shape_1 ..."> and <div class="td_features_shape_2 ..."> blocks unchanged --}}
            </div>
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>

    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        /* Same size as the theme's Campus image */
        .home_pm .home_pm_photo {
            width: 100%; height: 790px; object-fit: cover; object-position: center top; display: block;
        }
        .home_pm .home_pm_fallback {
            display: flex; align-items: center; justify-content: center;
            background: var(--heading-color, #00539B); color: #fff; font-size: 200px; font-weight: 700;
        }
        @media (max-width: 1399px) { .home_pm .home_pm_photo { height: 700px; } }
        @media (max-width: 1199px) { .home_pm .home_pm_photo { height: 600px; } }
        @media (max-width: 991px)  { .home_pm .home_pm_photo { height: 520px; } }
        @media (max-width: 575px)  { .home_pm .home_pm_photo { height: 380px; } .home_pm .home_pm_fallback { font-size: 120px; } }
        .home_pm_msg { position: relative; margin-top: 30px; padding-left: 22px; border-left: 3px solid var(--heading-color, #00539B); }
        .home_pm_msg p { line-height: 1.75em; opacity: .85; }
        .home_pm_quote { position: absolute; top: -34px; right: 0; color: var(--heading-color, #00539B); opacity: .08; }
        .home_pm_foot {
            display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; flex-wrap: wrap;
            margin-top: 34px; padding-top: 24px; border-top: 1px solid #E6EAF2;
        }
        .home_pm_sign {
            display: block; font-family: "Great Vibes", cursive; font-size: 38px; line-height: 1;
            color: var(--heading-color, #00539B); margin-bottom: 6px; transform: rotate(-3deg); transform-origin: left center;
        }
        @media (max-width: 575px) {
            .home_pm .home_pm_fallback { font-size: 110px; }
            .home_pm_foot { flex-direction: column; align-items: flex-start; }
            .home_pm_sign { font-size: 32px; }
        }
    </style>
@endif
<!-- End Principal's Desk Preview -->

    <!-- Start Admission CTA -->
@php $admSession = $admSession ?? ''; @endphp
<section class="td_accent_bg td_shape_section_1 home_adm">
    <div class="td_height_100 td_height_lg_75"></div>
    <div class="container">
        <div class="row align-items-center td_gap_y_40">

            {{-- Left: message + buttons --}}
            <div class="col-lg-7 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                <span class="home_adm_badge"><span class="home_adm_dot"></span> Admissions Open {{ $admSession }}</span>

                <h2 class="td_fs_48 td_white_color td_mb_20 home_adm_title">Begin Your Child's Journey With Us</h2>
                <p class="td_fs_18 td_white_color td_opacity_8 mb-0 home_adm_text">
                    Admissions are open from Pre-KG to Grade XII, with hostel facilities available.
                    Send an enquiry online and our admission team will call you back.
                </p>

                <div class="home_adm_btns">
                    <a href="{{ route('admission') }}#admission-form" class="td_btn td_style_1 td_radius_30 td_medium td_fs_18">
                        <span class="td_btn_in td_heading_color td_white_bg">
                            <span>Enquire Now</span>
                            <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                    </a>
                    <a href="{{ route('admission') }}" class="home_adm_outline">Admission Details</a>
                </div>
            </div>

            {{-- Right: how it works + call --}}
            <div class="col-lg-5 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
                <div class="home_adm_card">
                    <h3 class="td_fs_24 td_semibold td_mb_20">How to Apply</h3>
                    <ol class="home_adm_steps td_mp_0">
                        <li><b>1</b><div><strong>Send an enquiry</strong><span>Fill in the short online form.</span></div></li>
                        <li><b>2</b><div><strong>We call you back</strong><span>By phone or WhatsApp.</span></div></li>
                        <li><b>3</b><div><strong>Visit the campus</strong><span>Meet our teachers and see the school.</span></div></li>
                        <li><b>4</b><div><strong>Confirm admission</strong><span>Complete the documents and fees.</span></div></li>
                    </ol>
                    {{-- TODO: replace with your real admission number --}}
                    <a href="tel:99884567809" class="home_adm_call">
                        <span class="home_adm_call_icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg>
                        </span>
                        <span><small>Admission Helpline</small>99884567809</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="td_height_100 td_height_lg_75"></div>
</section>

<style>
    .home_adm { position: relative; overflow: hidden; }
    .home_adm::before, .home_adm::after {
        content: ""; position: absolute; border-radius: 50%; background: rgba(255,255,255,.06); pointer-events: none;
    }
    .home_adm::before { width: 420px; height: 420px; top: -160px; right: -120px; }
    .home_adm::after  { width: 260px; height: 260px; bottom: -120px; left: -80px; }
    .home_adm .container { position: relative; z-index: 1; }

    .home_adm_badge {
        display: inline-flex; align-items: center; gap: 10px; padding: 8px 18px; margin-bottom: 22px;
        border-radius: 30px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.25);
        color: #fff; font-size: 14px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;
    }
    .home_adm_dot { width: 8px; height: 8px; border-radius: 50%; background: #3ddc84; position: relative; }
    .home_adm_dot::after {
        content: ""; position: absolute; inset: -4px; border-radius: 50%;
        border: 2px solid #3ddc84; animation: homeAdmPulse 1.6s ease-out infinite;
    }
    @keyframes homeAdmPulse { from { transform: scale(.6); opacity: 1; } to { transform: scale(1.8); opacity: 0; } }

    .home_adm_title { line-height: 1.2; }
    .home_adm_text { max-width: 560px; line-height: 1.7; }

    .home_adm_btns { display: flex; align-items: center; flex-wrap: wrap; gap: 16px; margin-top: 36px; }
    .home_adm_outline {
        display: inline-flex; align-items: center; height: 56px; padding: 0 30px; border-radius: 30px;
        border: 1px solid rgba(255,255,255,.6); color: #fff; font-weight: 500; transition: all .3s ease;
    }
    .home_adm_outline:hover { background: #fff; color: var(--heading-color, #00539B); }

    .home_adm_card {
        background: #fff; border-radius: 16px; padding: 34px 30px;
        box-shadow: 0 30px 60px -30px rgba(0,0,0,.45);
    }
    .home_adm_card h3 { color: var(--heading-color, #00539B); }
    .home_adm_steps { list-style: none; }
    .home_adm_steps li { display: flex; gap: 14px; position: relative; }
    .home_adm_steps li:not(:last-child) { padding-bottom: 18px; }
    .home_adm_steps li:not(:last-child)::before {
        content: ""; position: absolute; left: 17px; top: 38px; bottom: 2px; border-left: 2px dashed #d6dbe8;
    }
    .home_adm_steps b {
        flex: none; width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: var(--heading-color, #00539B); color: #fff; font-size: 15px;
    }
    .home_adm_steps strong { display: block; color: var(--heading-color, #00539B); font-weight: 600; }
    .home_adm_steps span { display: block; font-size: 14px; color: #6b7489; }

    .home_adm_call {
        display: flex; align-items: center; gap: 14px; margin-top: 24px; padding: 14px 16px;
        border-radius: 12px; background: #F4F7FB; transition: background .3s ease;
    }
    .home_adm_call:hover { background: #e9eff8; }
    .home_adm_call_icon {
        flex: none; width: 42px; height: 42px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: var(--heading-color, #00539B); color: #fff;
    }
    .home_adm_call span:last-child { color: var(--heading-color, #00539B); font-weight: 600; font-size: 18px; line-height: 1.2; }
    .home_adm_call small { display: block; font-size: 13px; font-weight: 500; color: #6b7489; }

    @media (max-width: 991px) {
        .home_adm_text { max-width: none; }
    }
    @media (max-width: 575px) {
        .home_adm_btns { flex-direction: column; align-items: stretch; }
        .home_adm_btns .td_btn, .home_adm_outline { width: 100%; justify-content: center; }
        .home_adm_card { padding: 26px 20px; }
    }
</style>
<!-- End Admission CTA -->


    <!-- Start News & Notices -->
@php
    $homeNotices = $homeNotices ?? collect();

    $nnUrl   = fn ($n) => route('news-notices.show', [$n, \Illuminate\Support\Str::slug($n->title) ?: 'notice']);
    $nnDate  = fn ($n) => $n->published_at ?? $n->created_at;
    $nnTypes = \App\Models\NewsNotice::TYPES;
    $nnFeatured = $homeNotices->first();
    $nnList     = $homeNotices->slice(1);
@endphp

@if ($homeNotices->isNotEmpty())
<section class="home_nn">
    <div class="td_height_100 td_height_lg_75"></div>
    <div class="container">
        <div class="home_nn_head wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
            <div class="td_section_heading td_style_1 mb-0">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase home_nn_accent">
                    Stay Updated
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">News &amp; Notices</h2>
            </div>
            <a href="{{ route('news-notices.index') }}" class="td_btn td_style_1 td_radius_30 td_medium">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>View All Notices</span>
                    <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </span>
            </a>
        </div>
        <div class="td_height_50 td_height_lg_40"></div>

        <div class="row td_gap_y_30">
            {{-- Left: featured (pinned / urgent / latest) --}}
            <div class="col-lg-5 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                @php $fd = $nnDate($nnFeatured); @endphp
                <a href="{{ $nnUrl($nnFeatured) }}"
                   class="home_nn_feature home_nn_p_{{ $nnFeatured->priority ?: 'normal' }} {{ $nnFeatured->image_url ? 'has-img' : '' }}">

                    @if ($nnFeatured->image_url)
                        {{-- With image: photo on top, date badge on the photo --}}
                        <div class="home_nn_feature_img">
                            <img src="{{ $nnFeatured->image_url }}" alt="{{ $nnFeatured->title }}" loading="lazy">
                            <div class="home_nn_img_date">
                                <strong>{{ $fd->format('d') }}</strong>
                                <span>{{ $fd->format('M Y') }}</span>
                            </div>
                        </div>
                        <div class="home_nn_feature_body">
                            <div class="home_nn_tags">
                                <span class="home_nn_type">{{ $nnTypes[$nnFeatured->type] ?? 'Notice' }}</span>
                                @if ($nnFeatured->priority && $nnFeatured->priority !== 'normal')
                                    <span class="home_nn_prio home_nn_prio_{{ $nnFeatured->priority }}">{{ $nnFeatured->priority_label }}</span>
                                @endif
                                @if ($nnFeatured->is_pinned)
                                    <span class="home_nn_pin">Pinned</span>
                                @endif
                            </div>
                            <h3 class="home_nn_feature_title">{{ $nnFeatured->title }}</h3>
                            <p class="home_nn_feature_text">
                                {{ \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $nnFeatured->description))), 130) }}
                            </p>
                            <span class="home_nn_more">Read full notice
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    @else
                        {{-- Without image: blue card --}}
                        <div class="home_nn_feature_top">
                            <div class="home_nn_bigdate">
                                <strong>{{ $fd->format('d') }}</strong>
                                <span>{{ $fd->format('M Y') }}</span>
                            </div>
                            <div class="home_nn_tags">
                                <span class="home_nn_type">{{ $nnTypes[$nnFeatured->type] ?? 'Notice' }}</span>
                                @if ($nnFeatured->priority && $nnFeatured->priority !== 'normal')
                                    <span class="home_nn_prio home_nn_prio_{{ $nnFeatured->priority }}">{{ $nnFeatured->priority_label }}</span>
                                @endif
                                @if ($nnFeatured->is_pinned)
                                    <span class="home_nn_pin">Pinned</span>
                                @endif
                            </div>
                        </div>
                        <h3 class="home_nn_feature_title">{{ $nnFeatured->title }}</h3>
                        <p class="home_nn_feature_text">
                            {{ \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $nnFeatured->description))), 200) }}
                        </p>
                        <span class="home_nn_more">Read full notice
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </span>
                    @endif
                </a>
            </div>

            {{-- Right: latest list --}}
            <div class="col-lg-7 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.25s">
                <div class="home_nn_list">
                    @forelse ($nnList as $n)
                        @php $d = $nnDate($n); @endphp
                        <a href="{{ $nnUrl($n) }}" class="home_nn_item home_nn_p_{{ $n->priority ?: 'normal' }}">
                            @if ($n->image_url)
                                <div class="home_nn_thumb">
                                    <img src="{{ $n->image_url }}" alt="{{ $n->title }}" loading="lazy">
                                    <span>{{ $d->format('d M') }}</span>
                                </div>
                            @else
                                <div class="home_nn_date">
                                    <strong>{{ $d->format('d') }}</strong>
                                    <span>{{ $d->format('M') }}</span>
                                </div>
                            @endif
                            <div class="home_nn_item_body">
                                <div class="home_nn_tags">
                                    <span class="home_nn_type">{{ $nnTypes[$n->type] ?? 'Notice' }}</span>
                                    @if ($n->priority && $n->priority !== 'normal')
                                        <span class="home_nn_prio home_nn_prio_{{ $n->priority }}">{{ $n->priority_label }}</span>
                                    @endif
                                    @if ($d->gte(now()->subDays(7)))
                                        <span class="home_nn_new">New</span>
                                    @endif
                                </div>
                                <h4 class="home_nn_item_title">{{ $n->title }}</h4>
                            </div>
                            <span class="home_nn_arrow" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </span>
                        </a>
                    @empty
                        <div class="home_nn_empty">More updates will appear here.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="td_height_100 td_height_lg_75"></div>
</section>

<style>
    .home_nn { --nn: var(--heading-color, #00539B); --nn-dark: #002F5F; --nn-line: #E6EAF2; --nn-red: #dc3545; --nn-amber: #f59f00; }
    .home_nn_accent { color: var(--nn); }
    .home_nn_head { display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; flex-wrap: wrap; }

    /* Featured card */
    .home_nn_feature {
        display: flex; flex-direction: column; height: 100%; padding: 34px 30px; border-radius: 18px; color: #fff;
        background: linear-gradient(145deg, var(--nn) 0%, var(--nn-dark) 100%);
        position: relative; overflow: hidden; box-shadow: 0 30px 60px -35px rgba(0,47,95,.8);
        transition: transform .35s ease;
    }
    .home_nn_feature::after {
        content: ""; position: absolute; width: 220px; height: 220px; right: -70px; top: -70px;
        border-radius: 50%; background: rgba(255,255,255,.08);
    }
    .home_nn_feature.home_nn_p_urgent { background: linear-gradient(145deg, #c62839 0%, #7d1420 100%); }
    .home_nn_feature:hover { transform: translateY(-6px); color: #fff; }
    .home_nn_feature > * { position: relative; z-index: 1; }
    .home_nn_feature_top { display: flex; align-items: flex-start; justify-content: space-between; gap: 14px; }
    .home_nn_bigdate strong { display: block; font-size: 56px; line-height: 1; font-weight: 700; }
    .home_nn_bigdate span { display: block; margin-top: 4px; font-size: 15px; letter-spacing: 1px; text-transform: uppercase; opacity: .8; }
    .home_nn_feature .home_nn_tags { justify-content: flex-end; }
    .home_nn_feature .home_nn_type, .home_nn_feature .home_nn_pin { background: rgba(255,255,255,.16); color: #fff; }
    .home_nn_feature_title { margin: 28px 0 12px; color: #fff; font-size: 26px; font-weight: 600; line-height: 1.35; }
    .home_nn_feature_text { margin: 0; opacity: .8; line-height: 1.7; }
    .home_nn_feature .home_nn_more { margin-top: auto; padding-top: 26px; color: #fff; }

    /* List */
    .home_nn_list { display: flex; flex-direction: column; gap: 14px; }
    .home_nn_item {
        display: flex; align-items: center; gap: 18px; padding: 16px 20px; border-radius: 14px; background: #fff;
        border: 1px solid var(--nn-line); border-left: 4px solid var(--nn);
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .home_nn_item.home_nn_p_important { border-left-color: var(--nn-amber); }
    .home_nn_item.home_nn_p_urgent { border-left-color: var(--nn-red); }
    .home_nn_item:hover { transform: translateX(6px); box-shadow: 0 18px 36px -26px rgba(0,0,27,.55); }
    .home_nn_date {
        flex: none; width: 62px; text-align: center; border-radius: 12px; overflow: hidden; border: 1px solid var(--nn-line);
    }
    .home_nn_date strong { display: block; padding: 7px 0 3px; background: var(--nn); color: #fff; font-size: 22px; line-height: 1; }
    .home_nn_date span { display: block; padding: 3px 0 5px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--nn); }
    .home_nn_item.home_nn_p_urgent .home_nn_date strong { background: var(--nn-red); }
    .home_nn_item_body { flex: 1; min-width: 0; }
    .home_nn_item_title {
        margin: 6px 0 0; font-size: 17px; font-weight: 600; line-height: 1.4; color: var(--nn);
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .home_nn_arrow {
        flex: none; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        background: #F4F7FB; color: var(--nn); transition: all .3s ease;
    }
    .home_nn_item:hover .home_nn_arrow { background: var(--nn); color: #fff; }

    /* Tags */
    .home_nn_tags { display: flex; flex-wrap: wrap; gap: 6px; }
    .home_nn_type, .home_nn_prio, .home_nn_pin, .home_nn_new {
        padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; line-height: 1.7;
    }
    .home_nn_type { background: #F4F7FB; color: var(--nn); }
    .home_nn_prio_important { background: #fff4db; color: #a86a00; }
    .home_nn_prio_urgent { background: #fde8ea; color: var(--nn-red); }
    .home_nn_pin { background: #eef4ff; color: var(--nn); }
    .home_nn_new { background: #e6f7ee; color: #198754; }
    .home_nn_more { display: inline-flex; align-items: center; gap: 8px; font-weight: 600; }
    .home_nn_more svg { transition: transform .3s ease; }
    .home_nn_feature:hover .home_nn_more svg { transform: translateX(4px); }
    .home_nn_empty { padding: 40px 20px; text-align: center; color: #6b7489; border: 2px dashed var(--nn-line); border-radius: 14px; }

    @media (max-width: 575px) {
        .home_nn_feature { padding: 26px 20px; }
        .home_nn_bigdate strong { font-size: 44px; }
        .home_nn_feature_title { font-size: 21px; }
        .home_nn_item { padding: 14px; gap: 12px; }
        .home_nn_item:hover { transform: none; }
        .home_nn_arrow { display: none; }
    }

    /* ---- Featured card with image ---- */
    .home_nn_feature.has-img { padding: 0; background: #fff; color: inherit; border: 1px solid var(--nn-line); box-shadow: 0 30px 60px -38px rgba(0,0,27,.55); }
    .home_nn_feature.has-img::after { display: none; }
    .home_nn_feature.has-img.home_nn_p_urgent { background: #fff; border-top: 4px solid var(--nn-red); }
    .home_nn_feature.has-img.home_nn_p_important { border-top: 4px solid var(--nn-amber); }
    .home_nn_feature_img { position: relative; aspect-ratio: 16 / 10; overflow: hidden; }
    .home_nn_feature_img img { width: 100%; height: 100%; object-fit: cover; transition: transform .8s ease; }
    .home_nn_feature.has-img:hover .home_nn_feature_img img { transform: scale(1.06); }
    .home_nn_img_date {
        position: absolute; left: 18px; bottom: 18px; min-width: 70px; padding: 8px 12px; border-radius: 12px; text-align: center;
        background: var(--nn); color: #fff; box-shadow: 0 12px 24px -10px rgba(0,0,0,.5);
    }
    .home_nn_feature.has-img.home_nn_p_urgent .home_nn_img_date { background: var(--nn-red); }
    .home_nn_img_date strong { display: block; font-size: 28px; line-height: 1; font-weight: 700; }
    .home_nn_img_date span { display: block; margin-top: 3px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; opacity: .85; }
    .home_nn_feature_body { display: flex; flex-direction: column; flex: 1; padding: 24px 26px 26px; }
    .home_nn_feature.has-img .home_nn_tags { justify-content: flex-start; }
    .home_nn_feature.has-img .home_nn_type { background: #F4F7FB; color: var(--nn); }
    .home_nn_feature.has-img .home_nn_pin { background: #eef4ff; color: var(--nn); }
    .home_nn_feature.has-img .home_nn_feature_title { margin: 14px 0 10px; color: var(--nn); font-size: 22px; }
    .home_nn_feature.has-img .home_nn_feature_text { color: #5b6477; opacity: 1; }
    .home_nn_feature.has-img .home_nn_more { color: var(--nn); padding-top: 20px; }
    .home_nn_feature.has-img:hover { color: inherit; }

    /* ---- List item thumbnail ---- */
    .home_nn_thumb { position: relative; flex: none; width: 92px; height: 72px; border-radius: 12px; overflow: hidden; }
    .home_nn_thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s ease; }
    .home_nn_item:hover .home_nn_thumb img { transform: scale(1.08); }
    .home_nn_thumb span {
        position: absolute; left: 0; right: 0; bottom: 0; padding: 3px 0; text-align: center;
        background: rgba(0,47,95,.85); color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
    }
    .home_nn_item.home_nn_p_urgent .home_nn_thumb span { background: rgba(200,16,46,.9); }

    @media (max-width: 575px) {
        .home_nn_feature_body { padding: 20px; }
        .home_nn_feature.has-img .home_nn_feature_title { font-size: 19px; }
        .home_nn_thumb { width: 74px; height: 60px; }
    }
</style>
@endif
<!-- End News & Notices -->


   <!-- Start Gallery Preview -->
@php $galleryItems = $galleryItems ?? collect(); @endphp
@if ($galleryItems->isNotEmpty())
<section class="home_gal">
    <div class="td_height_100 td_height_lg_75"></div>
    <div class="container">
        <div class="home_gal_head">
            <div class="td_section_heading td_style_1 mb-0">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase home_gal_accent">
                    Gallery
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">Moments From Our Campus</h2>
            </div>
            <a href="{{ route('gallery.index') }}" class="td_btn td_style_1 td_radius_30 td_medium">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>View Full Gallery</span>
                    <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </span>
            </a>
        </div>
        <div class="td_height_50 td_height_lg_40"></div>

        <div class="home_gal_grid">
            @foreach ($galleryItems as $i => $item)
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
                <a href="{{ $src }}" class="home_gal_tile wow fadeInUp" data-wow-duration="1s" data-wow-delay="{{ 0.1 + ($i % 4) * 0.05 }}s"
                    data-kind="{{ $kind }}" data-src="{{ $src }}" data-title="{{ $item->title }}"
                    aria-label="Open {{ $item->title }}">
                    @if ($thumb)
                        <img src="{{ $thumb }}" alt="{{ $item->title }}" loading="lazy" decoding="async">
                    @elseif ($kind === 'video')
                        <video muted playsinline preload="metadata" src="{{ $src }}#t=0.5"></video>
                    @endif

                    @if ($kind !== 'image')
                        <span class="home_gal_play"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg></span>
                    @endif
                    <span class="home_gal_caption">{{ $item->title }}</span>
                </a>
            @endforeach
        </div>
    </div>
    <div class="td_height_100 td_height_lg_75"></div>
</section>

{{-- Viewer --}}
<div class="home_gal_lb" id="homeGalLb" aria-hidden="true" role="dialog" aria-label="Gallery viewer">
    <div class="home_gal_lb_bg" data-close></div>
    <span class="home_gal_lb_count"></span>
    <button type="button" class="home_gal_lb_btn home_gal_lb_close" data-close aria-label="Close">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
    </button>
    <button type="button" class="home_gal_lb_btn home_gal_lb_prev" aria-label="Previous">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
    </button>
    <div class="home_gal_lb_stage"></div>
    <button type="button" class="home_gal_lb_btn home_gal_lb_next" aria-label="Next">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
    </button>
    <p class="home_gal_lb_title"></p>
</div>

<style>
    .home_gal { background: #F6F8FB; }
    .home_gal_accent { color: var(--heading-color, #00539B); }
    .home_gal_head { display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; flex-wrap: wrap; }

    /* Bento grid: 1 big, 1 wide, rest normal */
    .home_gal_grid {
        display: grid; grid-template-columns: repeat(4, 1fr);
        grid-auto-rows: 220px; grid-auto-flow: dense; gap: 18px;
    }
    .home_gal_tile:nth-child(1) { grid-column: span 2; grid-row: span 2; }
    .home_gal_tile:nth-child(6) { grid-column: span 2; }

    .home_gal_tile {
        position: relative; display: block; overflow: hidden; border-radius: 14px; background: #e6eaf2;
        box-shadow: 0 12px 30px -20px rgba(0,0,27,.5); cursor: zoom-in;
        transition: transform .4s ease, box-shadow .4s ease;
    }
    .home_gal_tile img, .home_gal_tile video {
        width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .8s ease;
    }
    .home_gal_tile::after {
        content: ""; position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(0,0,27,0) 45%, rgba(0,0,27,.8) 100%);
        opacity: .6; transition: opacity .4s ease;
    }
    .home_gal_tile:hover { transform: translateY(-6px); box-shadow: 0 24px 40px -22px rgba(0,0,27,.6); }
    .home_gal_tile:hover img, .home_gal_tile:hover video { transform: scale(1.08); }
    .home_gal_tile:hover::after { opacity: 1; }

    .home_gal_caption {
        position: absolute; left: 0; right: 0; bottom: 0; z-index: 2; padding: 14px 16px;
        color: #fff; font-weight: 600; font-size: 15px; line-height: 1.35;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .home_gal_tile:nth-child(1) .home_gal_caption { font-size: 20px; padding: 20px 22px; }
    .home_gal_play {
        position: absolute; left: 50%; top: 50%; z-index: 2; width: 56px; height: 56px; margin: -28px 0 0 -28px;
        display: flex; align-items: center; justify-content: center; border-radius: 50%;
        background: rgba(255,255,255,.95); color: var(--heading-color, #00539B);
        box-shadow: 0 0 0 10px rgba(255,255,255,.25); transition: transform .3s ease;
    }
    .home_gal_play svg { margin-left: 3px; }
    .home_gal_tile:hover .home_gal_play { transform: scale(1.1); }

    /* Viewer */
    .home_gal_lb {
        position: fixed; inset: 0; z-index: 99999; display: flex; align-items: center; justify-content: center;
        visibility: hidden; opacity: 0; transition: opacity .3s ease, visibility .3s ease;
    }
    .home_gal_lb.is-open { visibility: visible; opacity: 1; }
    .home_gal_lb_bg { position: absolute; inset: 0; background: rgba(0,0,18,.95); }
    .home_gal_lb_stage {
        position: relative; z-index: 2; width: calc(100% - 200px); height: calc(100% - 160px);
        display: flex; align-items: center; justify-content: center;
    }
    .home_gal_lb_stage img, .home_gal_lb_stage video { max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 10px; }
    .home_gal_lb_stage .home_gal_frame { width: 100%; max-width: 1100px; aspect-ratio: 16 / 9; max-height: 100%; }
    .home_gal_lb_stage iframe { width: 100%; height: 100%; border: 0; border-radius: 10px; }
    .home_gal_lb_btn {
        position: absolute; z-index: 3; width: 52px; height: 52px; border-radius: 50%; border: 0; cursor: pointer;
        display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,.12); color: #fff;
        transition: background .3s ease;
    }
    .home_gal_lb_btn:hover { background: var(--heading-color, #00539B); }
    .home_gal_lb_close { top: 16px; right: 20px; width: 46px; height: 46px; }
    .home_gal_lb_prev { left: 28px; top: 50%; margin-top: -26px; }
    .home_gal_lb_next { right: 28px; top: 50%; margin-top: -26px; }
    .home_gal_lb_count { position: absolute; top: 28px; left: 24px; z-index: 3; color: rgba(255,255,255,.75); font-size: 15px; letter-spacing: 1px; }
    .home_gal_lb_title {
        position: absolute; left: 80px; right: 80px; bottom: 24px; z-index: 3; margin: 0; text-align: center;
        color: #fff; font-size: 18px; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    body.home_gal_lock { overflow: hidden; }

    @media (max-width: 1199px) { .home_gal_grid { grid-template-columns: repeat(3, 1fr); grid-auto-rows: 200px; } }
    @media (max-width: 767px) {
        .home_gal_grid { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 160px; gap: 12px; }
        .home_gal_caption { font-size: 13px; padding: 10px 12px; }
        .home_gal_tile:nth-child(1) .home_gal_caption { font-size: 16px; padding: 14px; }
        .home_gal_tile:hover { transform: none; }
        .home_gal_play { width: 44px; height: 44px; margin: -22px 0 0 -22px; }
        .home_gal_lb_stage { width: 100%; height: calc(100% - 180px); padding: 0 10px; }
        .home_gal_lb_prev, .home_gal_lb_next { top: auto; bottom: 70px; margin: 0; width: 44px; height: 44px; }
        .home_gal_lb_title { left: 64px; right: 64px; bottom: 80px; font-size: 15px; }
    }
</style>

<script>
(function () {
    function init() {
        var tiles = Array.prototype.slice.call(document.querySelectorAll('.home_gal_tile'));
        var lb = document.getElementById('homeGalLb');
        if (!tiles.length || !lb) return;
        var stage = lb.querySelector('.home_gal_lb_stage');
        var titleEl = lb.querySelector('.home_gal_lb_title');
        var countEl = lb.querySelector('.home_gal_lb_count');
        var current = 0;

        function show(i) {
            current = (i + tiles.length) % tiles.length;
            var d = tiles[current].dataset, node;
            stage.innerHTML = '';
            if (d.kind === 'image') {
                node = document.createElement('img'); node.src = d.src; node.alt = d.title;
            } else if (d.kind === 'video') {
                node = document.createElement('video'); node.src = d.src; node.controls = true; node.autoplay = true; node.playsInline = true;
            } else {
                node = document.createElement('div'); node.className = 'home_gal_frame';
                var f = document.createElement('iframe');
                f.src = d.src; f.title = d.title; f.allow = 'autoplay; fullscreen; picture-in-picture'; f.allowFullscreen = true;
                node.appendChild(f);
            }
            stage.appendChild(node);
            titleEl.textContent = d.title || '';
            countEl.textContent = (current + 1) + ' / ' + tiles.length;
        }
        function open(i) { show(i); lb.classList.add('is-open'); lb.setAttribute('aria-hidden', 'false'); document.body.classList.add('home_gal_lock'); }
        function close() { lb.classList.remove('is-open'); lb.setAttribute('aria-hidden', 'true'); document.body.classList.remove('home_gal_lock'); stage.innerHTML = ''; }

        tiles.forEach(function (t, i) { t.addEventListener('click', function (e) { e.preventDefault(); open(i); }); });
        lb.querySelector('.home_gal_lb_prev').addEventListener('click', function () { show(current - 1); });
        lb.querySelector('.home_gal_lb_next').addEventListener('click', function () { show(current + 1); });
        lb.querySelectorAll('[data-close]').forEach(function (el) { el.addEventListener('click', close); });
        document.addEventListener('keydown', function (e) {
            if (!lb.classList.contains('is-open')) return;
            if (e.key === 'Escape') close();
            if (e.key === 'ArrowLeft') show(current - 1);
            if (e.key === 'ArrowRight') show(current + 1);
        });
        var sx = null;
        stage.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
        stage.addEventListener('touchend', function (e) {
            if (sx === null) return;
            var dx = e.changedTouches[0].clientX - sx;
            if (Math.abs(dx) > 50) show(current + (dx < 0 ? 1 : -1));
            sx = null;
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
})();
</script>
@endif
<!-- End Gallery Preview -->

   <!-- Start Events Section -->
@php
    $homeEvents = $homeEvents ?? collect();
    $evDate  = fn ($e) => $e->home_date;    // set in HomeController
    $evImage = fn ($e) => $e->home_image;   // set in HomeController

    $evPlaceholder = 'data:image/svg+xml;utf8,' . rawurlencode(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 260"><rect width="400" height="260" fill="#eef0f7"/><rect x="150" y="80" width="100" height="90" rx="10" fill="#c9cde0"/><rect x="150" y="80" width="100" height="24" rx="10" fill="#aeb4cf"/></svg>'
    );
@endphp

@if ($homeEvents->isNotEmpty())
<section class="home_ev">
    <div class="td_height_100 td_height_lg_75"></div>
    <div class="container">
        <div class="home_ev_head wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
            <div class="td_section_heading td_style_1 mb-0">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase home_ev_accent">
                    Events
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">Upcoming &amp; Recent Events</h2>
            </div>
            <a href="{{ route('events.index') }}" class="td_btn td_style_1 td_radius_30 td_medium">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>View All Events</span>
                    <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </span>
            </a>
        </div>
        <div class="td_height_50 td_height_lg_40"></div>

        <div class="row td_gap_y_30">
            @foreach ($homeEvents as $event)
                @php
                    $d        = $evDate($event);
                    $upcoming = $d && ($d->isFuture() || $d->isToday());
                    $url      = route('events.show', $event);
                    $text     = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) ($event->short_description ?? $event->excerpt ?? $event->description ?? '')))), 110);
                    $venue    = $event->location ?? $event->venue ?? null;
                @endphp
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="{{ 0.2 + $loop->index * 0.05 }}s">
                    <article class="home_ev_card">
                        <a href="{{ $url }}" class="home_ev_thumb">
                            <img src="{{ $evImage($event) ?: $evPlaceholder }}" alt="{{ $event->title }}" loading="lazy">
                            @if ($d)
                                <span class="home_ev_date">
                                    <strong>{{ $d->format('d') }}</strong>
                                    <span>{{ $d->format('M') }}</span>
                                </span>
                            @endif
                            <span class="home_ev_status {{ $upcoming ? 'is-up' : 'is-past' }}">{{ $upcoming ? 'Upcoming' : 'Past Event' }}</span>
                        </a>
                        <div class="home_ev_body">
                            <ul class="home_ev_meta td_mp_0">
                                @if ($d)
                                    <li>
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                        {{ $d->format('d M Y') }}
                                    </li>
                                @endif
                                @if ($venue)
                                    <li>
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                        <span>{{ $venue }}</span>
                                    </li>
                                @endif
                            </ul>
                            <h3 class="home_ev_title"><a href="{{ $url }}">{{ $event->title }}</a></h3>
                            @if ($text !== '')
                                <p class="home_ev_text">{{ $text }}</p>
                            @endif
                            <a href="{{ $url }}" class="home_ev_more">View Details
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
    <div class="td_height_100 td_height_lg_75"></div>
</section>

<style>
    .home_ev { --ev: var(--heading-color, #00539B); background: #F6F8FB; }
    .home_ev_accent { color: var(--ev); }
    .home_ev_head { display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; flex-wrap: wrap; }

    .home_ev_card {
        height: 100%; display: flex; flex-direction: column; background: #fff; border-radius: 16px; overflow: hidden;
        border: 1px solid #E6EAF2; box-shadow: 0 18px 40px -30px rgba(0,0,27,.45);
        transition: transform .35s ease, box-shadow .35s ease;
    }
    .home_ev_card:hover { transform: translateY(-6px); box-shadow: 0 28px 50px -30px rgba(0,0,27,.55); }

    .home_ev_thumb { position: relative; display: block; overflow: hidden; aspect-ratio: 16 / 10; }
    .home_ev_thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .8s ease; }
    .home_ev_card:hover .home_ev_thumb img { transform: scale(1.07); }

    .home_ev_date {
        position: absolute; left: 16px; bottom: 16px; width: 62px; text-align: center; border-radius: 12px;
        overflow: hidden; background: #fff; box-shadow: 0 10px 20px -8px rgba(0,0,0,.35);
    }
    .home_ev_date strong { display: block; padding: 7px 0 3px; background: var(--ev); color: #fff; font-size: 22px; line-height: 1; }
    .home_ev_date span { display: block; padding: 3px 0 5px; color: var(--ev); font-size: 12px; font-weight: 700; text-transform: uppercase; }

    .home_ev_status {
        position: absolute; top: 14px; right: 14px; padding: 3px 12px; border-radius: 20px;
        font-size: 12px; font-weight: 600; color: #fff;
    }
    .home_ev_status.is-up { background: #198754; }
    .home_ev_status.is-past { background: rgba(0,0,27,.6); }

    .home_ev_body { flex: 1; display: flex; flex-direction: column; padding: 22px 22px 24px; }
    .home_ev_meta { display: flex; flex-wrap: wrap; gap: 6px 16px; margin-bottom: 10px; font-size: 14px; color: #6b7489; }
    .home_ev_meta li { display: inline-flex; align-items: center; gap: 6px; min-width: 0; }
    .home_ev_meta svg { color: var(--ev); flex: none; }
    .home_ev_meta span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .home_ev_title { margin: 0 0 10px; font-size: 21px; font-weight: 600; line-height: 1.35; }
    .home_ev_title a { color: var(--ev); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .home_ev_text { margin: 0 0 18px; color: #5b6477; line-height: 1.6; font-size: 15px; }
    .home_ev_more { margin-top: auto; display: inline-flex; align-items: center; gap: 8px; font-weight: 600; color: var(--ev); }
    .home_ev_more svg { transition: transform .3s ease; }
    .home_ev_card:hover .home_ev_more svg { transform: translateX(4px); }

    @media (max-width: 767px) {
        .home_ev_card:hover { transform: none; }
    }
</style>
@endif
<!-- End Events Section -->

    @endsection

@push('scripts')
<script>
(function () {
    function initHeroCarousel() {
        var el = document.querySelector('.td_hero_bg_carousel');
        if (!el) return;
        var slides = el.querySelectorAll('.td_hero_bg_slide');
        if (slides.length < 2) return;

        // Preferred: the theme's slick plugin (same look as before, with dots)
        if (window.jQuery && jQuery.fn && jQuery.fn.slick) {
            var $c = jQuery(el);
            if (!$c.hasClass('slick-initialized')) {
                $c.slick({
                    slidesToShow: 1, slidesToScroll: 1, fade: true, arrows: false, dots: true,
                    autoplay: true, autoplaySpeed: 5000, speed: 1000,
                    pauseOnHover: false, pauseOnFocus: false, infinite: true
                });
            }
            return;
        }

        // Fallback: plain fade, same timing
        var i = 0;
        el.classList.add('hero_fade');
        slides[0].classList.add('is-active');
        setInterval(function () {
            slides[i].classList.remove('is-active');
            i = (i + 1) % slides.length;
            slides[i].classList.add('is-active');
        }, 5000);
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initHeroCarousel);
    else initHeroCarousel();
})();
</script>
@endpush