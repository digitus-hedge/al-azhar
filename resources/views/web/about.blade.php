@extends('web.layouts.app')

@section('title', 'About Us || AL-Azhar')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@section('content')
@push('styles')
<style>
    .td_page_heading .breadcrumb-item + .breadcrumb-item::before {
        content: "/" !important;
        color: #fff;
        padding: 0 8px;
    }
</style>
@endpush
  <!-- Start Page Heading Section -->
  <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble about_banner"
    data-src="{{ asset('images/services-banner.webp') }}"
    style="background-image: url('{{ asset('images/services-banner.webp') }}'); background-size: cover; background-position: center;">
    <div class="container">
      <div class="td_page_heading_in">
        <h1 class="td_white_color td_fs_48 td_mb_10">About Us</h1>
        <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">About Us</li>
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

   <!-- Start About Section -->
@php
    $aboutShort = \Illuminate\Support\Str::limit(
        trim(preg_replace('/\s+/', ' ', strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], ' ', (string) ($about->description ?? ''))))),
        230
    );
@endphp
<section>
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
                                <div class="td_fs_18 mb-0">{!! strip_tags($about->vision ?? 'To nurture confident, compassionate learners who excel in knowledge, character and service.', '<p><br><strong><b><em><i><u>') !!}</div>
                            </li>
                            <li>
                                <h3 class="td_fs_24 td_mb_8">Our Mission</h3>
                                <div class="td_fs_18 mb-0">{!! strip_tags($about->mission ?? 'To provide holistic, value-based education that brings out the best in every child.', '<p><br><strong><b><em><i><u>') !!}</div>
                            </li>
                        </ul>
                    </div>

                    <a href="{{ route('contact.index') }}" class="td_btn td_style_1 td_radius_30 td_medium">
                        <span class="td_btn_in td_white_color td_accent_bg">
                            <span>Contact Us</span>
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

   <!-- Start History & Values (from admin > About Section) -->
@php
    // CKEditor HTML: keep formatting, drop anything unsafe (scripts, iframes, styles)
    $abAllowed = '<p><br><strong><b><em><i><u><ul><ol><li><a><h2><h3><h4><h5><span><blockquote><table><thead><tbody><tr><th><td>';
    $abHistory = trim(strip_tags((string) ($about->history ?? ''), $abAllowed));
    $abValues  = trim(strip_tags((string) ($about->values ?? ''), $abAllowed));
@endphp
@if ($abHistory !== '' || $abValues !== '')
<section class="ab_hv">
    <div class="td_height_100 td_height_lg_75"></div>
    <div class="container">
        <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
            <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase ab_hv_accent">
                <i></i> Who We Are <i></i>
            </p>
            <h2 class="td_section_title td_fs_48 mb-0">Our History &amp; Values</h2>
        </div>
        <div class="td_height_50 td_height_lg_40"></div>

        <div class="row td_gap_y_30">
            @if ($abHistory !== '')
                <div class="{{ $abValues !== '' ? 'col-lg-7' : 'col-lg-10 offset-lg-1' }} wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="ab_hv_card">
                        <div class="ab_hv_card_head">
                            <span class="ab_hv_icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v5h5"/><path d="M3.05 13A9 9 0 1 0 6 5.3L3 8"/><path d="M12 7v5l4 2"/></svg>
                            </span>
                            <h3 class="td_fs_32 td_semibold mb-0">Our History</h3>
                        </div>
                        <div class="ab_hv_text">{!! $abHistory !!}</div>
                    </div>
                </div>
            @endif

            @if ($abValues !== '')
                <div class="{{ $abHistory !== '' ? 'col-lg-5' : 'col-lg-10 offset-lg-1' }} wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.25s">
                    <div class="ab_hv_card ab_hv_card_values">
                        <div class="ab_hv_card_head">
                            <span class="ab_hv_icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l2.4 1.8 3-.2.9 2.9 2.5 1.7-1 2.8 1 2.8-2.5 1.7-.9 2.9-3-.2L12 22l-2.4-1.8-3 .2-.9-2.9-2.5-1.7 1-2.8-1-2.8 2.5-1.7.9-2.9 3 .2L12 2z"/><path d="m8.5 12 2.3 2.3 4.7-4.6"/></svg>
                            </span>
                            <h3 class="td_fs_32 td_semibold mb-0">Our Values</h3>
                        </div>
                        <div class="ab_hv_text">{!! $abValues !!}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="td_height_100 td_height_lg_75"></div>
</section>

<style>
    .ab_hv { --hv: var(--heading-color, #00539B); background: #F6F8FB; }
    .ab_hv_accent { color: var(--hv); }
    .ab_hv .td_section_subtitle_up i::before, .ab_hv .td_section_subtitle_up i::after { background-color: var(--hv); }

    .ab_hv_card {
        height: 100%; padding: 40px 36px; border-radius: 18px; background: #fff;
        border: 1px solid #E6EAF2; border-top: 4px solid var(--hv);
        box-shadow: 0 24px 50px -34px rgba(0,0,27,.45);
    }
    .ab_hv_card_values { background: linear-gradient(160deg, var(--hv) 0%, #002F5F 100%); border: 0; color: #fff; }
    .ab_hv_card_head { display: flex; align-items: center; gap: 14px; margin-bottom: 24px; padding-bottom: 18px; border-bottom: 1px solid #E6EAF2; }
    .ab_hv_card_values .ab_hv_card_head { border-bottom-color: rgba(255,255,255,.2); }
    .ab_hv_card_head h3 { color: var(--hv); }
    .ab_hv_card_values .ab_hv_card_head h3 { color: #fff; }
    .ab_hv_icon {
        flex: none; width: 52px; height: 52px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center; background: #F4F7FB; color: var(--hv);
    }
    .ab_hv_card_values .ab_hv_icon { background: rgba(255,255,255,.14); color: #fff; }

    /* CKEditor content */
    .ab_hv_text { font-size: 17px; line-height: 1.85; color: #3d4556; }
    .ab_hv_card_values .ab_hv_text { color: rgba(255,255,255,.9); }
    .ab_hv_text p { margin-bottom: 16px; }
    .ab_hv_text > *:last-child { margin-bottom: 0; }
    .ab_hv_text h2, .ab_hv_text h3, .ab_hv_text h4, .ab_hv_text h5 { color: var(--hv); font-weight: 600; margin: 22px 0 10px; line-height: 1.3; }
    .ab_hv_text h2 { font-size: 24px; } .ab_hv_text h3 { font-size: 21px; } .ab_hv_text h4, .ab_hv_text h5 { font-size: 18px; }
    .ab_hv_text > h2:first-child, .ab_hv_text > h3:first-child { margin-top: 0; }
    .ab_hv_card_values .ab_hv_text h2, .ab_hv_card_values .ab_hv_text h3,
    .ab_hv_card_values .ab_hv_text h4, .ab_hv_card_values .ab_hv_text h5 { color: #fff; }
    .ab_hv_text strong, .ab_hv_text b { color: var(--hv); }
    .ab_hv_card_values .ab_hv_text strong, .ab_hv_card_values .ab_hv_text b { color: #fff; }
    .ab_hv_text a { color: inherit; text-decoration: underline; }
    .ab_hv_text ul, .ab_hv_text ol { padding-left: 0; margin-bottom: 16px; list-style: none; }
    .ab_hv_text li { position: relative; padding-left: 30px; }
    .ab_hv_text li + li { margin-top: 10px; }
    .ab_hv_text li::before {
        content: ""; position: absolute; left: 0; top: 7px; width: 18px; height: 18px; border-radius: 50%;
        background: var(--hv) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 6 9 17l-5-5'/%3E%3C/svg%3E") center / 11px no-repeat;
    }
    .ab_hv_card_values .ab_hv_text li::before {
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2300539B' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 6 9 17l-5-5'/%3E%3C/svg%3E");
    }
    .ab_hv_text blockquote { margin: 16px 0; padding: 12px 18px; border-left: 3px solid var(--hv); background: #F4F7FB; border-radius: 0 10px 10px 0; }
    .ab_hv_text table { width: 100%; margin-bottom: 16px; border-collapse: collapse; }
    .ab_hv_text th, .ab_hv_text td { padding: 8px 10px; border: 1px solid #E6EAF2; }

    @media (max-width: 575px) {
        .ab_hv_card { padding: 28px 20px; }
        .ab_hv_text { font-size: 16px; }
    }
</style>
@endif
<!-- End History & Values -->

    <!-- Start Vision & Mission (from admin > About Section) -->
@php
    $vmAllowed = '<p><br><strong><b><em><i><u><ul><ol><li><a><h2><h3><h4><h5><span><blockquote>';
    $vmVision  = trim(strip_tags((string) ($about->vision ?? ''), $vmAllowed));
    $vmMission = trim(strip_tags((string) ($about->mission ?? ''), $vmAllowed));
@endphp
@if ($vmVision !== '' || $vmMission !== '')
<section class="td_accent_bg td_shape_section_1 ab_vm">
    <div class="td_height_100 td_height_lg_75"></div>
    <div class="container">
        <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
            <p class="ab_vm_badge">What Guides Us</p>
            <h2 class="td_section_title td_fs_48 mb-0 td_white_color">Our Vision &amp; Mission</h2>
        </div>
        <div class="td_height_50 td_height_lg_40"></div>

        <div class="row td_gap_y_30">
            @if ($vmVision !== '')
                <div class="{{ $vmMission !== '' ? 'col-lg-6' : 'col-lg-10 offset-lg-1' }} wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="ab_vm_card">
                        <div class="ab_vm_head">
                            <span class="ab_vm_icon">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                            </span>
                            <div>
                                <span class="ab_vm_num">01</span>
                                <h3 class="ab_vm_title">Our Vision</h3>
                            </div>
                        </div>
                        <div class="ab_vm_text">{!! $vmVision !!}</div>
                    </div>
                </div>
            @endif

            @if ($vmMission !== '')
                <div class="{{ $vmVision !== '' ? 'col-lg-6' : 'col-lg-10 offset-lg-1' }} wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.25s">
                    <div class="ab_vm_card">
                        <div class="ab_vm_head">
                            <span class="ab_vm_icon">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                            </span>
                            <div>
                                <span class="ab_vm_num">02</span>
                                <h3 class="ab_vm_title">Our Mission</h3>
                            </div>
                        </div>
                        <div class="ab_vm_text">{!! $vmMission !!}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="td_height_100 td_height_lg_75"></div>
</section>

<style>
    .ab_vm { position: relative; overflow: hidden; }
    .ab_vm::before, .ab_vm::after {
        content: ""; position: absolute; border-radius: 50%; background: rgba(255,255,255,.06); pointer-events: none;
    }
    .ab_vm::before { width: 420px; height: 420px; top: -160px; right: -120px; }
    .ab_vm::after  { width: 260px; height: 260px; bottom: -120px; left: -80px; }
    .ab_vm .container { position: relative; z-index: 1; }

    .ab_vm_badge {
        display: inline-block; margin: 0 0 16px; padding: 8px 18px; border-radius: 30px;
        background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.25);
        color: #fff; font-size: 14px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;
    }

    .ab_vm_card {
        height: 100%; padding: 40px 36px; border-radius: 20px; color: #fff;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18);
        backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
        transition: transform .35s ease, background .35s ease;
    }
    .ab_vm_card:hover { transform: translateY(-6px); background: rgba(255,255,255,.12); }

    .ab_vm_head { display: flex; align-items: center; gap: 18px; margin-bottom: 26px; padding-bottom: 22px; border-bottom: 1px solid rgba(255,255,255,.2); }
    .ab_vm_icon {
        flex: none; width: 64px; height: 64px; border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        background: #fff; color: var(--heading-color, #00539B);
        box-shadow: 0 14px 30px -14px rgba(0,0,0,.5);
    }
    .ab_vm_num { display: block; font-size: 14px; font-weight: 700; letter-spacing: 2px; opacity: .6; }
    .ab_vm_title { margin: 2px 0 0; color: #fff; font-size: 30px; font-weight: 600; line-height: 1.2; }

    /* CKEditor content, full length */
    .ab_vm_text { font-size: 17px; line-height: 1.85; color: rgba(255,255,255,.88); }
    .ab_vm_text p { margin-bottom: 16px; }
    .ab_vm_text > *:last-child { margin-bottom: 0; }
    .ab_vm_text h2, .ab_vm_text h3, .ab_vm_text h4, .ab_vm_text h5 { color: #fff; font-weight: 600; margin: 20px 0 10px; line-height: 1.3; }
    .ab_vm_text h2 { font-size: 22px; } .ab_vm_text h3 { font-size: 20px; } .ab_vm_text h4, .ab_vm_text h5 { font-size: 18px; }
    .ab_vm_text > h2:first-child, .ab_vm_text > h3:first-child { margin-top: 0; }
    .ab_vm_text strong, .ab_vm_text b { color: #fff; }
    .ab_vm_text a { color: #fff; text-decoration: underline; }
    .ab_vm_text ul, .ab_vm_text ol { padding-left: 0; margin-bottom: 16px; list-style: none; }
    .ab_vm_text li { position: relative; padding-left: 30px; }
    .ab_vm_text li + li { margin-top: 10px; }
    .ab_vm_text li::before {
        content: ""; position: absolute; left: 0; top: 7px; width: 18px; height: 18px; border-radius: 50%;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2300539B' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 6 9 17l-5-5'/%3E%3C/svg%3E") center / 11px no-repeat;
    }
    .ab_vm_text blockquote { margin: 16px 0; padding: 12px 18px; border-left: 3px solid #fff; background: rgba(255,255,255,.08); border-radius: 0 10px 10px 0; }

    @media (max-width: 767px) { .ab_vm_card:hover { transform: none; } }
    @media (max-width: 575px) {
        .ab_vm_card { padding: 28px 20px; }
        .ab_vm_icon { width: 54px; height: 54px; border-radius: 14px; }
        .ab_vm_title { font-size: 24px; }
        .ab_vm_text { font-size: 16px; }
    }
</style>
@endif
<!-- End Vision & Mission -->

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
                <a href="{{ $nnUrl($nnFeatured) }}" class="home_nn_feature home_nn_p_{{ $nnFeatured->priority ?: 'normal' }}">
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
                </a>
            </div>

            {{-- Right: latest list --}}
            <div class="col-lg-7 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.25s">
                <div class="home_nn_list">
                    @forelse ($nnList as $n)
                        @php $d = $nnDate($n); @endphp
                        <a href="{{ $nnUrl($n) }}" class="home_nn_item home_nn_p_{{ $n->priority ?: 'normal' }}">
                            <div class="home_nn_date">
                                <strong>{{ $d->format('d') }}</strong>
                                <span>{{ $d->format('M') }}</span>
                            </div>
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