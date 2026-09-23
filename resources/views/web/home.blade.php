<!DOCTYPE html>
<html class="no-js" lang="en">


<!-- Mirrored from educve-laravel.themedox.com/?theme=four by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Sep 2026 04:20:56 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="uploads/website-images/favicon-2025-01-26-05-02-44-5347.png" type="image/x-icon">

    <!-- Site Title -->
    <title>Educve - Complete eLearning Management System With Laravel</title>
    <meta name="title" content="Educve - Complete eLearning Management System With Laravel">
    <meta name="description" content="Educve - Complete eLearning Management System With Laravel">

    <link rel="stylesheet" href="frontend/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="frontend/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="frontend/assets/css/slick.min.css">
    <link rel="stylesheet" href="frontend/assets/css/odometer.css">
    <link rel="stylesheet" href="frontend/assets/css/animate.css">
    <link rel="stylesheet" href="frontend/assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="frontend/assets/css/style.css">
    <link rel="stylesheet" href="frontend/assets/css/dev.css">
    <link rel="stylesheet" href="frontend/assets/css/cookie_consent.css">

    <link rel="stylesheet" href="global/toastr/toastr.min.css">




    <script>
        ! function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '156905933');
        fbq('track', 'PageView');

    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=156905933&amp;ev=PageView&amp;noscript=1" /></noscript>

</head>

<body>
   @include('web.partials.header')

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
</style>

<script>
    // NOTE: this script is placed high up in the page, before jQuery core and
    // jquery.slick.min.js (loaded near the bottom of the layout). We cannot
    // reference `jQuery` directly here at parse time — it doesn't exist yet.
    // document.addEventListener only *registers* the callback; the body isn't
    // executed until DOMContentLoaded fires, by which point every earlier
    // synchronous <script> tag on the page (including jQuery and slick) has
    // already loaded and run, so `jQuery` and `.slick()` are safely available.
    document.addEventListener('DOMContentLoaded', function () {
        jQuery(function ($) {
            var $heroCarousel = $('.td_hero_bg_carousel');

            // Only initialize slick when there's more than one slide to rotate through
            if ($heroCarousel.length && $heroCarousel.find('.td_hero_bg_slide').length > 1) {
                $heroCarousel.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    fade: true,
                    arrows: false,
                    dots: true,
                    autoplay: true,
                    autoplaySpeed: 4000,
                    speed: 800,
                    pauseOnHover: false,
                    infinite: true
                });
            }
        });
    });
</script>

    <div class="container">
        <div class="td_hero_btn_group">
            <a href="courses.html" class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                data-wow-duration="0.9s" data-wow-delay="0.35s">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>Browse Course</span>
                    <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </a>
            <a href="faq.html" class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                data-wow-duration="0.9s" data-wow-delay="0.35s">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>Our FAQ</span>
                    <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.625 4.875C10.625 5.09751 10.559 5.31502 10.4354 5.50002C10.3118 5.68503 10.1361 5.82922 9.93052 5.91437C9.72496 5.99952 9.49876 6.0218 9.28053 5.97839C9.0623 5.93498 8.86184 5.82783 8.70451 5.6705C8.54718 5.51316 8.44003 5.31271 8.39662 5.09448C8.35321 4.87625 8.37549 4.65005 8.46064 4.44449C8.54579 4.23892 8.68998 4.06322 8.87499 3.9396C9.05999 3.81598 9.2775 3.75 9.5 3.75C9.79837 3.75 10.0845 3.86853 10.2955 4.07951C10.5065 4.29049 10.625 4.57664 10.625 4.875ZM18.5 9C18.5 7.21997 17.9722 5.47991 16.9832 3.99987C15.9943 2.51983 14.5887 1.36628 12.9442 0.685088C11.2996 0.00389957 9.49002 -0.17433 7.74419 0.172937C5.99836 0.520204 4.39472 1.37737 3.13604 2.63604C1.87737 3.89472 1.0202 5.49836 0.672937 7.24419C0.32567 8.99002 0.5039 10.7996 1.18509 12.4442C1.86628 14.0887 3.01983 15.4943 4.49987 16.4832C5.97991 17.4722 7.71997 18 9.5 18H18.5V9ZM17 9V16.5H9.5C8.01664 16.5 6.5666 16.0601 5.33323 15.236C4.09986 14.4119 3.13856 13.2406 2.57091 11.8701C2.00325 10.4997 1.85473 8.99168 2.14411 7.53683C2.4335 6.08197 3.14781 4.7456 4.1967 3.6967C5.2456 2.64781 6.58197 1.9335 8.03683 1.64411C9.49168 1.35473 10.9997 1.50325 12.3701 2.07091C13.7406 2.63856 14.9119 3.59986 15.736 4.83323C16.5601 6.0666 17 7.51664 17 9ZM11 9C11 8.60218 10.842 8.22065 10.5607 7.93934C10.2794 7.65804 9.89783 7.5 9.5 7.5H8V9H9.5V14.25H11V9Z"
                            fill="currentColor" />
                    </svg>
                </span>
            </a>
            <a href="contact-us.html" class="td_btn td_style_1 td_radius_10 td_medium td_fs_20 wow fadeInUp"
                data-wow-duration="0.9s" data-wow-delay="0.35s">
                <span class="td_btn_in td_white_color td_accent_bg">
                    <span>Contact with Us</span>
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_5145_10366)">
                            <path
                                d="M18.0008 8.43531C17.8924 6.68032 17.2727 4.99544 16.2182 3.58838C15.1638 2.18131 13.7206 1.11358 12.0666 0.516803C10.4127 -0.0799705 8.62022 -0.179693 6.91027 0.229928C5.20031 0.63955 3.6476 1.54061 2.44356 2.82202C1.23952 4.10343 0.436777 5.70918 0.134303 7.4413C-0.168171 9.17342 0.0428439 10.9562 0.741334 12.5698C1.43982 14.1835 2.59525 15.5575 4.06518 16.5224C5.5351 17.4873 7.25526 18.001 9.0136 18.0001H14.2508C15.2451 17.9991 16.1984 17.6037 16.9014 16.9006C17.6044 16.1976 17.9999 15.2443 18.0008 14.2501V8.43531ZM16.5008 14.2501C16.5008 14.8468 16.2638 15.4191 15.8418 15.841C15.4199 16.263 14.8476 16.5001 14.2508 16.5001H9.0136C7.9553 16.4996 6.90898 16.276 5.94287 15.844C4.97676 15.412 4.11255 14.7812 3.4066 13.9928C2.69723 13.2048 2.16454 12.2742 1.84427 11.2634C1.52399 10.2526 1.42352 9.18508 1.5496 8.13231C1.74867 6.47176 2.49474 4.9247 3.67018 3.735C4.84562 2.5453 6.38357 1.78064 8.0416 1.56156C8.36502 1.52102 8.69064 1.50048 9.0166 1.50006C10.7645 1.49529 12.4582 2.10598 13.8008 3.22506C14.585 3.87676 15.2286 4.68092 15.6927 5.58878C16.1569 6.49664 16.4318 7.48929 16.5008 8.50656V14.2501Z"
                                fill="currentColor" />
                            <path
                                d="M6 6.75H9C9.19891 6.75 9.38968 6.67098 9.53033 6.53033C9.67098 6.38968 9.75 6.19891 9.75 6C9.75 5.80109 9.67098 5.61032 9.53033 5.46967C9.38968 5.32902 9.19891 5.25 9 5.25H6C5.80109 5.25 5.61032 5.32902 5.46967 5.46967C5.32902 5.61032 5.25 5.80109 5.25 6C5.25 6.19891 5.32902 6.38968 5.46967 6.53033C5.61032 6.67098 5.80109 6.75 6 6.75Z"
                                fill="currentColor" />
                            <path
                                d="M12 8.25H6C5.80109 8.25 5.61032 8.32902 5.46967 8.46967C5.32902 8.61032 5.25 8.80109 5.25 9C5.25 9.19891 5.32902 9.38968 5.46967 9.53033C5.61032 9.67098 5.80109 9.75 6 9.75H12C12.1989 9.75 12.3897 9.67098 12.5303 9.53033C12.671 9.38968 12.75 9.19891 12.75 9C12.75 8.80109 12.671 8.61032 12.5303 8.46967C12.3897 8.32902 12.1989 8.25 12 8.25Z"
                                fill="currentColor" />
                            <path
                                d="M12 11.25H6C5.80109 11.25 5.61032 11.329 5.46967 11.4697C5.32902 11.6103 5.25 11.8011 5.25 12C5.25 12.1989 5.32902 12.3897 5.46967 12.5303C5.61032 12.671 5.80109 12.75 6 12.75H12C12.1989 12.75 12.3897 12.671 12.5303 12.5303C12.671 12.3897 12.75 12.1989 12.75 12C12.75 11.8011 12.671 11.6103 12.5303 11.4697C12.3897 11.329 12.1989 11.25 12 11.25Z"
                                fill="currentColor" />
                        </g>
                        <defs>
                            <clipPath id="clip0_5145_10366">
                                <rect width="18" height="18" fill="currentColor" />
                            </clipPath>
                        </defs>
                    </svg>

                </span>
            </a>
        </div>
    </div>
    <!-- End Hero Section -->


    <!-- Start About Section -->
    <section>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="td_about td_style_1">
            <div class="container">
                <div class="row align-items-center td_gap_y_40">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.25s">
                        <div class="td_about_thumb_wrap">
                            <div class="td_about_year text-uppercase td_fs_64 td_bold">EST 1995</div>
                            <div class="td_about_thumb_1">
                                <img src="uploads/website-images/about1.jpg" alt="">
                            </div>
                            <div class="td_about_thumb_2">
                                <img src="uploads/website-images/about2.jpg" alt="">
                            </div>
                            <a href="https://www.youtube.com/embed/rRid6GCJtgc"
                                class="td_circle_text td_center td_video_open">
                                <svg width="15" height="19" viewBox="0 0 15 19" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.086 8.63792C14.6603 9.03557 14.6603 9.88459 14.086 10.2822L2.54766 18.2711C1.88444 18.7303 0.978418 18.2557 0.978418 17.449L0.978418 1.47118C0.978418 0.664496 1.88444 0.189811 2.54767 0.649016L14.086 8.63792Z"
                                        fill="white" />
                                </svg>

                                <img src="uploads/website-images/rotate image.webp" alt="" class="">

                            </a>
                            <div class="td_circle_shape"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                        <div class="td_section_heading td_style_1 td_mb_30">
                            <p
                                class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                                About us</p>
                            <h2 class="td_section_title td_fs_48 mb-0">The largest &amp; Most Diverse Universities in
                                the United Emirates
                            </h2>
                            <p class="td_section_subtitle td_fs_18 mb-0">
                                Far far away, behind the word mountains, far from the Consonantia, there live the blind
                                texts. Separated they marks grove right at the coast of the Semantics a large language
                                ocean
                            </p>

                        </div>
                        <div class="td_mb_40">
                            <ul class="td_list td_style_5 td_mp_0">
                                <li>
                                    <h3 class="td_fs_24 td_mb_8">Graduate Program</h3>
                                    <p class="td_fs_18 mb-0">Browse the Undergraduate Degrees</p>
                                </li>
                                <li>
                                    <h3 class="td_fs_24 td_mb_8">Undergraduate Program</h3>
                                    <p class="td_fs_18 mb-0">Browse the Undergraduate Degrees</p>
                                </li>
                            </ul>
                        </div>
                        <a href="about-us.html" class="td_btn td_style_1 td_radius_30 td_medium">
                            <span class="td_btn_in td_white_color td_accent_bg">
                                <span>More About</span>
                                <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path
                                        d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End About Section -->

    <!-- Start Feature Section -->
    <section>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">
            <div class="td_features td_style_1 td_hobble">
                <div class="td_features_thumb">
                    <img src="uploads/website-images/campus.jpg" alt=""
                        class="td_radius_10 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                </div>
                <div class="td_features_content td_white_bg td_radius_10 wow fadeInRight" data-wow-duration="1s"
                    data-wow-delay="0.25s">
                    <div class="td_section_heading td_style_1">
                        <p
                            class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                            CAMPUS</p>
                        <h2 class="td_section_title td_fs_48 mb-0">Campus is your Dream Lifestyle</h2>
                    </div>
                    <div class="td_height_50 td_height_lg_50"></div>
                    <ul class="td_feature_list td_mp_0">
                        <li>
                            <div class="td_feature_icon td_center">
                                <img src="uploads/website-images/1738413298_item_one_icon.html" alt="">
                            </div>
                            <div class="td_feature_info">
                                <h3 class="td_fs_32 td_semibold td_mb_15">Smart Hostel</h3>
                                <p class="td_fs_14 td_heading_color td_opacity_7 mb-0">Behind the word mountains, far
                                    from the Conso there live the blind texts</p>
                            </div>
                        </li>
                        <li>
                            <div class="td_feature_icon td_center">
                                <img src="uploads/website-images/1738413298_item_two_icon.html" alt="">
                            </div>
                            <div class="td_feature_info">
                                <h3 class="td_fs_32 td_semibold td_mb_15">Student Life</h3>
                                <p class="td_fs_14 td_heading_color td_opacity_7 mb-0">Behind the word mountains, far
                                    from the Conso there live the blind texts</p>
                            </div>
                        </li>
                        <li>
                            <div class="td_feature_icon td_center">
                                <img src="uploads/website-images/1738413331_item_three_icon.html" alt="">
                            </div>
                            <div class="td_feature_info">
                                <h3 class="td_fs_32 td_semibold td_mb_15">Arts &amp; Clubs</h3>
                                <p class="td_fs_14 td_heading_color td_opacity_7 mb-0">Behind the word mountains, far
                                    from the Conso there live the blind texts</p>
                            </div>
                        </li>
                        <li>
                            <div class="td_feature_icon td_center">
                                <img src="uploads/website-images/1738413331_item_four_icon.html" alt="">
                            </div>
                            <div class="td_feature_info">
                                <h3 class="td_fs_32 td_semibold td_mb_15">Sports &amp; Fitness</h3>
                                <p class="td_fs_14 td_heading_color td_opacity_7 mb-0">Behind the word mountains, far
                                    from the Conso there live the blind texts</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="td_features_shape_1 position-absolute td_accent_color td_hover_layer_3">
                    <svg width="482" height="769" viewBox="0 0 482 769" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M95.5257 63.6079C95.5257 63.6079 440.442 -122.4 331.028 144.941C186.89 497.038 374.069 383.766 443.343 372.701C533.011 358.466 432.66 620.605 432.66 620.605M89.566 67.8652C89.566 67.8652 425.38 -107.274 318.228 154.436C178.626 495.525 359.245 392.597 435.947 380.589C531.877 365.485 417.864 629.948 417.864 629.948M83.6064 72.1225C83.6064 72.1225 410.212 -91.9622 305.428 163.93C170.242 493.943 344.301 401.36 428.657 388.29C530.744 372.504 403.055 639.034 403.055 639.034M77.7534 76.1935C77.7534 76.1935 395.15 -76.8363 292.734 173.239C162.086 492.243 329.585 410.005 421.489 396.06C529.717 379.336 388.366 648.19 388.366 648.19M71.6731 80.3817C71.6731 80.3817 379.968 -61.7794 279.813 182.664C153.702 490.661 314.641 418.767 414.078 403.692C528.69 386.169 373.678 657.346 373.678 657.346M65.7135 84.639C65.7135 84.639 364.799 -46.4671 267.013 192.158C145.332 489.334 299.817 427.599 406.682 411.579C527.571 393.443 358.762 666.62 358.762 666.62M59.7538 88.8963C59.7538 88.8963 349.51 -31.2238 254.106 201.839C136.948 487.752 284.767 436.548 399.286 419.467C526.437 400.462 343.966 675.962 343.966 675.962M53.7942 93.1536C53.7942 93.1536 334.449 -16.0979 241.305 211.334C128.684 486.239 269.943 445.379 391.89 427.354C525.304 407.481 329.171 685.304 329.171 685.304M47.8345 97.4109C47.8345 97.4109 319.28 -0.785629 228.505 220.828C120.3 484.657 255.12 454.211 384.614 435.31C524.184 414.755 314.376 694.646 314.376 694.646M41.9815 101.482C41.9815 101.482 304.219 14.3403 215.811 230.136C112.143 482.958 240.403 462.856 377.431 442.825C523.385 421.471 299.794 703.616 299.794 703.616M36.0219 105.739C36.0219 105.739 289.157 29.4662 203.011 239.631C103.88 481.445 225.459 471.619 370.035 450.712C522.131 428.42 284.984 712.703 284.984 712.703M30.0622 109.997C30.0622 109.997 273.988 44.7786 190.09 249.056C95.4961 479.863 210.515 480.381 362.625 458.345C520.997 435.439 270.068 721.976 270.068 721.976M24.1026 114.254C24.1026 114.254 258.82 60.0909 177.29 258.551C87.112 478.281 195.692 489.213 355.229 466.232C519.864 442.458 255.273 731.319 255.273 731.319M18.1429 118.511C18.1429 118.511 243.638 75.1478 164.489 268.045C78.8487 476.768 180.868 498.044 348.06 474.002C518.958 449.36 240.705 740.544 240.705 740.544M12.1833 122.768C12.1833 122.768 228.469 90.46 151.689 277.54C70.5853 475.255 166.045 506.876 340.663 481.889C517.838 456.634 225.91 749.886 225.91 749.886M6.3303 126.839C6.3303 126.839 213.514 105.4 138.995 286.848C62.3079 473.486 151.208 515.452 333.481 489.404C516.705 463.653 211.101 758.973 211.101 758.973M0.25 131.028C0.25 131.028 198.225 120.643 125.968 296.46C53.8173 472.09 136.157 524.401 325.857 497.409C515.678 470.486 196.412 768.129 196.412 768.129"
                            stroke="currentColor" stroke-miterlimit="10" />
                    </svg>
                </div>
                <div class="td_features_shape_2 position-absolute td_accent_color td_hover_layer_5">
                    <svg width="576" height="726" viewBox="0 0 576 726" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M492.179 645.603C492.179 645.603 177.451 855.296 228.555 594.921C295.898 251.997 127.985 377.265 58.6234 394.914C-31.1778 417.678 11.7299 163.105 11.7299 163.105M497.373 641.009C497.373 641.009 189.556 839.623 239.628 584.728C304.835 252.527 141.316 367.473 64.4603 386.789C-31.6424 411.026 24.9113 152.842 24.9113 152.842M502.567 636.415C502.567 636.415 201.729 823.765 250.702 574.535C313.912 253.109 154.787 357.734 70.23 378.85C-32.107 404.375 38.1671 142.815 38.1671 142.815M507.694 632.006C507.694 632.006 213.834 808.091 261.709 564.526C322.782 253.825 168.05 348.127 75.8582 370.859C-32.6388 397.908 51.2814 132.736 51.2814 132.736M513.029 627.464C513.029 627.464 226.081 792.469 272.924 554.384C331.86 254.407 181.522 338.387 81.7694 362.97C-33.1705 391.442 64.3956 122.657 64.3956 122.657M518.223 622.87C518.223 622.87 238.253 776.611 283.998 544.191C340.863 254.753 194.852 328.596 87.6063 354.846C-33.7095 384.554 77.7186 112.445 77.7186 112.445M523.417 618.276C523.417 618.276 250.567 760.804 295.139 533.813C349.941 255.335 208.39 318.672 93.4432 346.722C-34.1741 377.903 90.9 102.182 90.9 102.182M528.611 613.681C528.611 613.681 262.672 745.131 306.213 523.619C358.878 255.866 221.72 308.88 99.28 338.598C-34.6387 371.251 104.081 91.9181 104.081 91.9181M533.805 609.087C533.805 609.087 274.845 729.273 317.286 513.426C367.956 256.448 235.05 299.089 104.975 330.422C-35.1777 364.364 117.263 81.6546 117.263 81.6546M538.932 604.678C538.932 604.678 286.95 713.599 328.293 503.417C376.825 257.163 248.313 289.483 110.678 322.667C-35.9181 358.03 130.31 71.7605 130.31 71.7605M544.126 600.084C544.126 600.084 299.055 697.926 339.367 493.224C385.762 257.694 261.785 279.743 116.515 314.543C-36.2412 351.43 143.566 61.7332 143.566 61.7332M549.32 595.49C549.32 595.49 311.228 682.068 350.582 483.082C394.84 258.276 275.256 270.003 122.426 306.655C-36.7059 344.779 156.889 51.5211 156.889 51.5211M554.514 590.896C554.514 590.896 323.4 666.21 361.656 472.889C403.918 258.858 288.587 260.212 128.263 298.53C-37.1705 338.127 170.07 41.2576 170.07 41.2576M559.708 586.302C559.708 586.302 335.647 650.588 372.73 462.695C412.854 259.389 301.917 250.421 133.891 290.539C-37.8437 331.609 183.043 31.1274 183.043 31.1274M564.902 581.708C564.902 581.708 347.819 634.729 383.803 452.502C421.791 259.92 315.247 240.629 139.728 282.415C-38.3826 324.722 196.224 20.8639 196.224 20.8639M570.029 577.299C570.029 577.299 359.857 619.241 394.81 442.493C430.801 260.687 328.651 231.074 145.431 274.66C-38.8473 318.07 209.48 10.8366 209.48 10.8366M575.364 572.756C575.364 572.756 372.171 603.434 406.092 432.167C439.946 261.084 342.19 221.15 151.476 266.402C-39.3791 311.604 222.594 0.757812 222.594 0.757812"
                            stroke="currentColor" stroke-miterlimit="10" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Feature Section -->


    <!-- Start Campus Life -->
    <section class="td_accent_bg td_shape_section_1">
        <div class="td_shape_position_4 td_accent_color position-absolute">
            <svg width="37" height="40" viewBox="0 0 37 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.4">
                    <rect y="12.3906" width="23.6182" height="31.0709" rx="1" transform="rotate(-30.4551 0 12.3906)"
                        fill="white" />
                    <rect x="4" y="14.8125" width="18.5361" height="2.62207" rx="1.31104"
                        transform="rotate(-30.4551 4 14.8125)" fill="currentColor" />
                    <rect x="7" y="19.8125" width="18.5361" height="2.62207" rx="1.31104"
                        transform="rotate(-30.4551 7 19.8125)" fill="currentColor" />
                </g>
            </svg>
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">
            <div class="row td_gap_y_40">
                <div class="col-lg-5 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_height_57 td_height_lg_0"></div>
                    <div class="td_section_heading td_style_1">
                        <h2 class="td_section_title td_fs_48 mb-0 td_white_color">Navigate</h2>
                        <p class="td_section_subtitle td_fs_18 mb-0 td_white_color td_opacity_7">
                            Far far away, behind the word mountains, far from the Consonantia, there live the blind
                            texts. Separated they marks grove right at the coast of the Semantics
                        </p>
                    </div>
                    <div class="td_btn_box">
                        <svg width="299" height="315" viewBox="0 0 299 315" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.75" clip-path="url(#clip0_34_2222)">
                                <path
                                    d="M242.757 275.771C242.505 275.771 242.253 275.75 242.005 275.707C32.3684 239.98 0.342741 8.13005 0.0437414 5.79468C-0.108609 4.51176 0.22739 3.21754 0.9787 2.19335C1.73001 1.16916 2.8359 0.497795 4.05598 0.32519C5.27606 0.152585 6.5117 0.492693 7.4943 1.27158C8.4769 2.05047 9.12704 3.20518 9.3034 4.48471C9.59772 6.7514 40.7872 231.477 243.5 266.022C244.658 266.22 245.702 266.868 246.426 267.838C247.15 268.808 247.5 270.028 247.406 271.256C247.312 272.484 246.782 273.63 245.921 274.467C245.06 275.303 243.93 275.769 242.757 275.771Z"
                                    fill="white" />
                                <path
                                    d="M299.002 275.455C271.709 283.305 237.446 297.872 215.562 314.617L235.465 269.602L223.318 221.648C242.099 242.137 273.428 262.728 299.002 275.455Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_34_2222">
                                    <rect width="299" height="314" fill="white" transform="translate(0 0.421875)" />
                                </clipPath>
                            </defs>
                        </svg>
                        <div class="td_btn_box_in">
                            <a href="https://www.google.com/" target="_blank"
                                class="td_btn td_style_1 td_radius_30 td_medium td_fs_18">
                                <span class="td_btn_in td_heading_color td_white_bg">
                                    <span>View All Program</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="row">
                        <div class="col-sm-6">

                            <div class="td_card td_style_2 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                                <a target="_blank" href="https://www.google.com/" class="td_card_thumb d-block">
                                    <img src="uploads/website-images/studentlife.jpg" alt=""
                                        class="w-100">
                                </a>
                                <div class="td_card_info">
                                    <h2 class="td_card_title mb-0 td_fs_18 td_semibold td_white_color">
                                        <a target="_blank" href="https://www.google.com/">Campus Student Life</a>
                                    </h2>
                                    <a target="_blank" href="https://www.google.com/" class="td_card_btn">
                                        <svg width="23" height="24" viewBox="0 0 23 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.564 4.70161L4.42188 18.8438" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M18.5654 13.5341C18.5654 13.5341 19.7299 5.85989 18.5654 4.69528C17.4008 3.53067 9.72656 4.69531 9.72656 4.69531"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <svg width="23" height="24" viewBox="0 0 23 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.564 4.70161L4.42188 18.8438" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M18.5654 13.5341C18.5654 13.5341 19.7299 5.85989 18.5654 4.69528C17.4008 3.53067 9.72656 4.69531 9.72656 4.69531"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <div class="td_height_40 td_height_lg_30"></div>
                            <div class="td_card td_style_2 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                                <a target="_blank" href="https://www.google.com/" class="td_card_thumb d-block">
                                    <img src="uploads/website-images/creation.jpg" alt=""
                                        class="w-100">
                                </a>
                                <div class="td_card_info">
                                    <h2 class="td_card_title mb-0 td_fs_18 td_semibold td_white_color">
                                        <a target="_blank" href="https://www.google.com/">Recreations &amp; Wellness</a>
                                    </h2>
                                    <a target="_blank" href="https://www.google.com/" class="td_card_btn">
                                        <svg width="23" height="24" viewBox="0 0 23 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.564 4.70161L4.42188 18.8438" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M18.5654 13.5341C18.5654 13.5341 19.7299 5.85989 18.5654 4.69528C17.4008 3.53067 9.72656 4.69531 9.72656 4.69531"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <svg width="23" height="24" viewBox="0 0 23 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.564 4.70161L4.42188 18.8438" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M18.5654 13.5341C18.5654 13.5341 19.7299 5.85989 18.5654 4.69528C17.4008 3.53067 9.72656 4.69531 9.72656 4.69531"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="td_height_50 td_height_lg_30"></div>
                            <div class="td_card td_style_2 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.25s">
                                <a target="_blank" href="https://www.google.com/" class="td_card_thumb d-block">
                                    <img src="uploads/website-images/about1.jpg" alt=""
                                        class="w-100">
                                </a>
                                <div class="td_card_info">
                                    <h2 class="td_card_title mb-0 td_fs_18 td_semibold td_white_color">
                                        <a target="_blank" href="https://www.google.com/">Recreations &amp; Wellness</a>
                                    </h2>
                                    <a target="_blank" href="https://www.google.com/" class="td_card_btn">
                                        <svg width="23" height="24" viewBox="0 0 23 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.564 4.70161L4.42188 18.8438" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M18.5654 13.5341C18.5654 13.5341 19.7299 5.85989 18.5654 4.69528C17.4008 3.53067 9.72656 4.69531 9.72656 4.69531"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <svg width="23" height="24" viewBox="0 0 23 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.564 4.70161L4.42188 18.8438" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M18.5654 13.5341C18.5654 13.5341 19.7299 5.85989 18.5654 4.69528C17.4008 3.53067 9.72656 4.69531 9.72656 4.69531"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="td_height_40 td_height_lg_30"></div>
                            <div class="td_card td_style_2 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                                <a target="_blank" href="https://www.google.com/" class="td_card_thumb d-block">
                                    <img src="uploads/website-images/sports.jpg" alt=""
                                        class="w-100">
                                </a>
                                <div class="td_card_info">
                                    <h2 class="td_card_title mb-0 td_fs_18 td_semibold td_white_color">
                                        <a target="_blank" href="https://www.google.com/">Sports &amp; Fitness</a>
                                    </h2>
                                    <a target="_blank" href="https://www.google.com/" class="td_card_btn">
                                        <svg width="23" height="24" viewBox="0 0 23 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.564 4.70161L4.42188 18.8438" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M18.5654 13.5341C18.5654 13.5341 19.7299 5.85989 18.5654 4.69528C17.4008 3.53067 9.72656 4.69531 9.72656 4.69531"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <svg width="23" height="24" viewBox="0 0 23 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.564 4.70161L4.42188 18.8438" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M18.5654 13.5341C18.5654 13.5341 19.7299 5.85989 18.5654 4.69528C17.4008 3.53067 9.72656 4.69531 9.72656 4.69531"
                                                stroke="white" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_75"></div>
    </section>
    <!-- End Campus Life -->


    <!-- Start Departments Section -->
    <section>
        <div class="td_height_100 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    Departments</p>
                <h2 class="td_section_title td_fs_48 mb-0">Popular Departments</h2>
                <div class="d-flex justify-content-center">
                    <p class="td_section_subtitle td_fs_18 mb-0 qs-custom-min-width-1">Far far away, behind the word
                        mountains, far from the Consonantia, there live the blind texts. Separated they marks grove
                        right at the coast</p>
                </div>
            </div>
            <div class="td_height_50 td_height_lg_50"></div>
            <div class="td_iconbox_1_wrap">
                <div class="td_iconbox td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                    data-wow-delay="0.2s">
                    <div class="td_iconbox_icon td_accent_color td_mb_10">
                        <img src="uploads/website-images/1738413524_department_one_image.html" alt="">
                    </div>
                    <h3 class="td_iconbox_title mb-0 td_medium td_fs_36">Economics</h3>
                </div>

                <div class="td_iconbox td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                    data-wow-delay="0.3s">
                    <div class="td_iconbox_icon td_accent_color td_mb_10">
                        <img src="uploads/website-images/1738413524_department_two_image.html" alt="">
                    </div>
                    <h3 class="td_iconbox_title mb-0 td_medium td_fs_36">Computer</h3>
                </div>

                <div class="td_iconbox td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                    data-wow-delay="0.4s">
                    <div class="td_iconbox_icon td_accent_color td_mb_10">
                        <img src="uploads/website-images/1738413524_department_three_image.html" alt="">
                    </div>
                    <h3 class="td_iconbox_title mb-0 td_medium td_fs_36">Electrical</h3>
                </div>
                <div class="td_iconbox td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                    data-wow-delay="0.4s">
                    <div class="td_iconbox_icon td_accent_color td_mb_10">
                        <img src="uploads/website-images/1738413524_department_four_image.html" alt="">
                    </div>
                    <h3 class="td_iconbox_title mb-0 td_medium td_fs_36">Civil</h3>
                </div>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Departments Section -->

    <!-- Start Video Section -->
    <section>
        <div class="td_video_block td_style_1 td_accent_bg td_center text-center"
     style="background-image: url('uploads/website-images/videoimg.jpg'); background-size: cover; background-position: center;">
            <div class="container">
                <a href="https://www.youtube.com/embed/rRid6GCJtgc"
                    class="td_player_btn_wrap_2 td_video_open wow zoomIn" data-wow-duration="1s" data-wow-delay="0.2s">
                    <span class="td_player_btn td_center">
                        <span></span>
                    </span>
                </a>
                <div class="td_height_70 td_height_lg_50"></div>
                <h2 class="td_fs_48 td_white_color mb-0 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">Take
                    a Video Tour to Learn Intro of Campus</h2>
            </div>
        </div>
        <div class="container wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.25s">
            <div class="td_contact_box td_style_1 td_accent_bg td_radius_10">
                <div class="td_contact_box_left">
                    <p class="td_fs_18 td_light td_white_color td_mb_4">Get In Touch:</p>
                    <h3 class="td_fs_36 mb-0 td_white_color"><a href="mailto:info@educve.com">info@educve.com</a></h3>
                </div>
                <div
                    class="td_contact_box_or td_fs_24 td_medium td_white_bg td_white_bg td_center rounded-circle td_accent_color">
                    or
                </div>
                <div class="td_contact_box_right">
                    <p class="td_fs_18 td_light td_white_color td_mb_4">Get In Touch:</p>
                    <h3 class="td_fs_36 mb-0 td_white_color"><a href="tel:+01 998 7698 870">+01 998 7698 870</a></h3>
                </div>
            </div>
        </div>
    </section>
    <!-- End Video Section -->


    <!-- Start Team Section -->
    <section class="td_shape_section_8 td_hobble">
        <span class="td_shape_position_1 position-absolute td_hover_layer_3">
            <svg width="172" height="173" viewBox="0 0 172 173" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.53" clip-path="url(#clip0_34_15810)">
                    <path
                        d="M129.849 69.6796C131.425 66.9298 132.078 63.7471 131.711 60.5988C131.345 57.4506 129.98 54.5026 127.815 52.1877C125.65 49.8728 122.8 48.313 119.683 47.7372C116.566 47.1614 113.347 47.6 110.498 48.9885C107.649 50.3771 105.32 52.6425 103.853 55.4521C102.386 58.2618 101.859 61.4676 102.348 64.5991C102.838 67.7306 104.318 70.6226 106.572 72.8507C108.827 75.0788 111.736 76.5255 114.873 76.9785C112.861 79.0096 111.212 81.3709 109.998 83.9595C105.104 82.6372 99.9818 82.3899 94.983 83.2345C97.5685 79.538 98.8532 75.0876 98.6354 70.5819C98.4176 66.0762 96.7097 61.7704 93.7797 58.3405C90.8497 54.9107 86.8636 52.551 82.4472 51.6319C78.0309 50.7129 73.4344 51.2866 69.3794 53.2628C65.3244 55.2391 62.0405 58.5061 60.0433 62.5508C58.0462 66.5956 57.4488 71.1891 58.3451 75.6101C59.2414 80.0312 61.5805 84.0294 64.9952 86.977C68.4099 89.9246 72.7068 91.6548 77.2113 91.8958C73.4662 95.3127 70.5049 99.4997 68.531 104.169C65.7443 103.53 62.8687 103.374 60.0292 103.707C61.6078 100.956 62.2625 97.7705 61.8972 94.6194C61.5319 91.4684 60.1658 88.5174 57.9995 86.2001C55.8333 83.8827 52.9811 82.3211 49.8617 81.7444C46.7424 81.1677 43.5203 81.6065 40.6688 82.9963C37.8172 84.386 35.4864 86.6535 34.0187 89.4657C32.551 92.278 32.0237 95.4867 32.5143 98.6207C33.0049 101.755 34.4874 104.649 36.7443 106.878C39.0011 109.107 41.9133 110.554 45.0532 111.006C41.3951 114.712 38.9744 119.46 38.1238 124.598C37.2732 129.735 38.0344 135.01 40.3027 139.697C40.5351 140.174 40.9474 140.539 41.4489 140.712C41.9504 140.885 42.5 140.851 42.9768 140.619C43.4536 140.386 43.8186 139.974 43.9914 139.473C44.1643 138.971 44.1308 138.422 43.8984 137.945C42.1761 134.393 41.4809 130.431 41.8914 126.506C42.3018 122.58 43.8015 118.847 46.2212 115.729C48.6409 112.611 51.8842 110.231 55.5849 108.858C59.2856 107.486 63.2963 107.175 67.1642 107.961C64.6592 116.376 65.4085 125.426 69.2635 133.314C69.4959 133.791 69.9082 134.156 70.4097 134.329C70.9112 134.502 71.4608 134.468 71.9376 134.236C72.4144 134.003 72.7794 133.591 72.9522 133.09C73.1251 132.588 73.0916 132.039 72.8592 131.562C69.412 124.155 69.0108 115.69 71.7421 107.99C74.4734 100.29 80.1188 93.97 87.4631 90.3906C94.8074 86.8113 103.263 86.2586 111.011 88.8515C118.759 91.4444 125.179 96.9757 128.889 104.255C129.122 104.732 129.534 105.096 130.035 105.269C130.537 105.442 131.086 105.409 131.563 105.176C132.04 104.944 132.405 104.532 132.578 104.03C132.751 103.529 132.717 102.979 132.485 102.502C128.647 94.6056 121.981 88.4399 113.809 85.2281C115.572 81.6945 118.287 78.7243 121.649 76.653C125.011 74.5817 128.885 73.492 132.834 73.507C136.783 73.522 140.649 74.6411 143.995 76.7378C147.341 78.8346 150.034 81.8254 151.769 85.3722C152.002 85.8491 152.414 86.214 152.915 86.3869C153.417 86.5597 153.967 86.5263 154.443 86.2939C154.92 86.0615 155.285 85.6492 155.458 85.1477C155.631 84.6462 155.597 84.0966 155.365 83.6198C153.072 78.9459 149.388 75.0966 144.819 72.6005C140.25 70.1045 135.021 69.0841 129.849 69.6796ZM37.4215 101.054C36.489 99.1266 36.1485 96.9666 36.4429 94.8462C36.7374 92.7259 37.6536 90.7404 39.0759 89.1404C40.4981 87.5405 42.3626 86.398 44.4339 85.8572C46.5051 85.3163 48.6902 85.4015 50.7131 86.1018C52.736 86.8022 54.506 88.0863 55.7994 89.792C57.0929 91.4977 57.8519 93.5485 57.9804 95.6854C58.109 97.8222 57.6014 99.9492 56.5218 101.798C55.4422 103.646 53.839 105.133 51.9147 106.071C50.6337 106.694 49.2426 107.058 47.8207 107.143C46.3989 107.228 44.9742 107.032 43.6283 106.566C42.2823 106.1 41.0413 105.373 39.9763 104.427C38.9113 103.482 38.0432 102.335 37.4215 101.054ZM63.5792 78.7159C62.1695 75.8054 61.6541 72.5423 62.098 69.3389C62.5419 66.1355 63.9253 63.1355 66.0733 60.718C68.2214 58.3004 71.0378 56.5737 74.1667 55.7561C77.2956 54.9384 80.5967 55.0664 83.6529 56.1239C86.7091 57.1815 89.3833 59.121 91.3377 61.6977C93.2921 64.2743 94.439 67.3724 94.6335 70.6005C94.828 73.8287 94.0614 77.0421 92.4305 79.8347C90.7997 82.6274 88.3777 84.874 85.4706 86.2909C81.5693 88.1863 77.0756 88.4571 72.975 87.0438C68.8744 85.6305 65.5017 82.6485 63.5968 78.7519L63.5792 78.7159ZM107.232 67.0303C106.294 65.1049 105.947 62.9444 106.237 60.822C106.526 58.6997 107.438 56.7109 108.858 55.1071C110.278 53.5033 112.142 52.3565 114.213 51.8117C116.285 51.267 118.471 51.3488 120.496 52.0467C122.521 52.7447 124.294 54.0275 125.59 55.7329C126.886 57.4383 127.647 59.4897 127.777 61.6277C127.907 63.7657 127.401 65.8943 126.321 67.7443C125.241 69.5943 123.637 71.0826 121.712 72.021C119.13 73.2766 116.154 73.4563 113.44 72.5207C110.725 71.585 108.492 69.6104 107.232 67.0303Z"
                        fill="#EBECED" />
                </g>
                <defs>
                    <clipPath id="clip0_34_15810">
                        <rect width="128" height="128" fill="white" transform="translate(0 56.999) rotate(-25.983)" />
                    </clipPath>
                </defs>
            </svg>
        </span>
        <span class="td_shape_position_2 position-absolute td_hover_layer_3">
            <svg width="128" height="128" viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.53" clip-path="url(#clip0_34_15812)">
                    <path
                        d="M63.7756 16.265C65.1661 16.265 66.2933 15.1377 66.2933 13.7472V2.51775C66.2933 1.12725 65.1661 0 63.7756 0C62.3851 0 61.2578 1.12725 61.2578 2.51775V13.7472C61.2581 15.1377 62.3853 16.265 63.7756 16.265Z"
                        fill="#EBECED" />
                    <path
                        d="M125.319 86.497L120.871 82.0617C119.289 80.4815 117.18 79.611 114.933 79.611C113.497 79.611 112.117 79.9685 110.895 80.6382L102.514 72.2667L102.922 71.859C106.322 68.452 106.321 62.9157 102.922 59.5202C101.707 58.3032 100.191 57.4917 98.5389 57.1502C98.7664 56.365 98.8862 55.5425 98.8862 54.7007C98.8862 52.362 97.9777 50.169 96.3332 48.5312C95.1182 47.3142 93.6027 46.5027 91.9504 46.1612C92.1779 45.376 92.2977 44.5537 92.2977 43.7117C92.2977 41.3727 91.3892 39.18 89.7419 37.5397C88.4979 36.2972 86.9687 35.5107 85.3629 35.176C86.2219 32.2142 85.4879 28.882 83.1579 26.548C81.2184 24.6167 78.5866 23.7867 76.0504 24.0557L59.4417 20.912C56.9087 20.4315 53.7454 20.1137 51.7487 21.935C51.6227 22.05 51.4942 22.1822 51.3677 22.3295C48.2717 21.201 44.6607 21.873 42.1814 24.3495C40.5367 25.9922 39.6307 28.1842 39.6307 30.5217C39.6307 31.3637 39.7499 32.186 39.9772 32.9715C38.3267 33.3127 36.8129 34.1232 35.6022 35.3362C33.9542 36.9775 33.0454 39.167 33.0437 41.5017C33.0429 42.3457 33.1627 43.1707 33.3912 43.9582C31.7399 44.2987 30.2252 45.1077 29.0107 46.3207C27.3627 47.967 26.4552 50.1602 26.4552 52.4965C26.4552 54.286 26.9894 55.9907 27.9794 57.4307C26.7294 57.8545 25.5844 58.5597 24.6257 59.5175C21.2232 62.9157 21.2219 68.4522 24.6279 71.8642L25.0347 72.2692L16.6522 80.6365C13.5369 79.1697 9.69866 79.7192 7.12791 82.2867L2.67741 86.7247C1.09441 88.3057 0.222906 90.4147 0.222656 92.663C0.222656 94.9115 1.09441 97.0207 2.67741 98.602L8.23166 104.149C9.21541 105.132 10.8097 105.131 11.7922 104.147C12.7749 103.164 12.7739 101.569 11.7902 100.587L6.23591 95.0395C5.60541 94.4097 5.25816 93.5657 5.25816 92.6632C5.25816 91.761 5.60541 90.9172 6.23441 90.289L10.6852 85.8507C11.7972 84.74 13.4992 84.5745 14.7917 85.3472C14.8827 85.484 14.9879 85.614 15.1084 85.7347C15.3242 85.951 15.5704 86.1167 15.8319 86.238L41.3552 111.724C41.4764 111.988 41.6429 112.237 41.8602 112.454C42.0717 112.666 42.3129 112.83 42.5689 112.95C43.1087 113.56 43.4069 114.34 43.4069 115.171C43.4069 116.074 43.0597 116.918 42.4292 117.547L37.9829 121.988C36.6692 123.296 34.5322 123.296 33.2224 121.992L27.6682 116.438C26.6849 115.454 25.0909 115.454 24.1077 116.438C23.1244 117.421 23.1244 119.015 24.1077 119.998L29.6659 125.557C31.3019 127.186 33.4504 128 35.5999 128C37.7499 128 39.9009 127.185 41.5389 125.554L45.9879 121.11C47.5709 119.529 48.4427 117.42 48.4427 115.171C48.4427 113.567 47.9964 112.034 47.1667 110.713L56.6007 101.29C56.6107 101.28 56.6207 101.27 56.6309 101.259C57.7112 100.143 60.7194 100.352 63.6287 100.554C65.6957 100.697 68.0002 100.857 70.2517 100.598L80.5827 110.916C79.9134 112.137 79.5562 113.514 79.5562 114.949C79.5562 117.195 80.4279 119.303 82.0109 120.884L86.4602 125.328C88.0422 126.908 90.1509 127.778 92.3979 127.778C94.6447 127.778 96.7534 126.908 98.3357 125.328L125.321 98.3752C126.904 96.7942 127.776 94.6852 127.776 92.4367C127.775 90.1885 126.904 88.0795 125.319 86.497ZM58.5042 25.8595L69.4259 27.9267L62.8887 34.4615C61.8774 33.9755 60.4914 33.069 58.9709 31.6145C56.8897 29.6235 55.4009 27.3247 55.2654 25.891C55.2652 25.8902 55.2652 25.8895 55.2652 25.8887C55.2652 25.8885 55.2649 25.8882 55.2649 25.888C55.2552 25.785 55.2527 25.7027 55.2539 25.64C55.5832 25.56 56.4577 25.4712 58.5042 25.8595ZM45.7397 27.9122C47.0152 26.638 48.9967 26.491 50.4379 27.467C51.2547 30.8915 54.1759 33.9952 55.4902 35.2527C56.4642 36.1847 59.5894 38.979 62.7439 39.747C63.1707 40.3587 63.4029 41.088 63.4029 41.8575C63.4029 42.8487 63.0217 43.7755 62.3269 44.4695C61.6342 45.1635 60.7059 45.5455 59.7129 45.5455C58.7197 45.5455 57.7914 45.1635 57.0954 44.4662L57.0952 44.466L57.0939 44.4647L45.7394 33.1307C45.0472 32.4395 44.6659 31.5127 44.6659 30.5217C44.6662 29.5305 45.0474 28.6037 45.7397 27.9122ZM39.1607 38.899C39.8534 38.2052 40.7807 37.823 41.7722 37.823C42.7649 37.823 43.6952 38.206 44.3924 38.9025L53.5354 48.0272C54.9752 49.4692 54.9752 51.8157 53.5404 53.2527C52.8439 53.9465 51.9124 54.3285 50.9177 54.3285C49.9229 54.3285 48.9914 53.9465 48.2979 53.2557L48.2977 53.2555L41.3614 46.3207C41.3507 46.31 41.3389 46.3 41.3279 46.289L39.1579 44.12C38.4617 43.4245 38.0784 42.496 38.0792 41.5055C38.0802 40.5182 38.4622 39.5945 39.1607 38.899ZM32.5692 49.8835C33.2624 49.1912 34.1917 48.81 35.1862 48.81C36.1724 48.81 37.0937 49.1857 37.7839 49.866L44.7414 56.8202C45.4352 57.5112 45.8174 58.437 45.8174 59.427C45.8174 60.4167 45.4352 61.3425 44.7387 62.0362C44.0457 62.7282 43.1174 63.1095 42.1247 63.1095C41.1304 63.1095 40.1992 62.7272 39.5052 62.0362L36.9829 59.517C36.9824 59.5162 36.9817 59.5157 36.9812 59.5152L32.5694 55.1087C31.8739 54.414 31.4909 53.486 31.4909 52.496C31.4909 51.5062 31.8739 50.578 32.5692 49.8835ZM28.1842 63.08C28.8804 62.3845 29.8109 62.0015 30.8042 62.0015C31.7972 62.0015 32.7274 62.3842 33.4234 63.0792L35.9492 65.602C36.6432 66.293 37.0252 67.2187 37.0252 68.2087C37.0252 69.1987 36.6429 70.1242 35.9439 70.8207C35.2512 71.5145 34.3229 71.8967 33.3299 71.8967C32.3367 71.8967 31.4084 71.5147 30.7107 70.8157L30.3944 70.5007C30.3902 70.4965 30.3869 70.492 30.3829 70.488C30.3782 70.4835 30.3732 70.4795 30.3684 70.475L28.1867 68.3017C26.7469 66.859 26.7457 64.5167 28.1842 63.08ZM79.4927 91.6945C78.5099 90.7105 76.9156 90.7097 75.9322 91.6922L73.6922 93.9295C71.5637 96.058 67.7069 95.79 63.9772 95.5312C59.9269 95.2497 55.7387 94.9592 53.0284 97.7417L43.7547 107.004L20.5639 83.8475L28.7709 75.6552C30.1274 76.4867 31.6927 76.9325 33.3304 76.9325C35.6702 76.9325 37.8642 76.0255 39.5029 74.3837C41.1527 72.7407 42.0614 70.548 42.0614 68.209C42.0614 68.1872 42.0599 68.1657 42.0599 68.144C42.0817 68.1442 42.1034 68.1455 42.1252 68.1455C44.4617 68.1455 46.6539 67.2412 48.2949 65.6022C49.9447 63.9592 50.8534 61.7662 50.8534 59.4275C50.8534 59.4057 50.8519 59.3842 50.8519 59.3625C50.8739 59.3625 50.8959 59.364 50.9182 59.364C53.2539 59.364 55.4474 58.4607 57.0994 56.8155C58.8144 55.0977 59.6627 52.8362 59.6464 50.5795C59.6689 50.5797 59.6914 50.581 59.7139 50.581C62.0537 50.5807 64.2474 49.674 65.8887 48.0297C67.5334 46.387 68.4394 44.195 68.4394 41.8575C68.4394 40.2227 67.9949 38.66 67.1662 37.3062L74.3594 30.116C74.8954 29.5822 75.5564 29.2472 76.2492 29.109C76.3242 29.101 76.3982 29.089 76.4714 29.0745C77.5829 28.9212 78.7502 29.2642 79.6002 30.1107C81.0399 31.553 81.0399 33.8995 79.6054 35.3365L77.4146 37.5182C77.4074 37.5255 77.3997 37.532 77.3924 37.5392L74.8692 40.0582C73.8852 41.0407 73.8842 42.635 74.8669 43.6187C75.8499 44.6027 77.4439 44.6035 78.4274 43.621L80.6269 41.4245C80.6274 41.424 80.6279 41.4235 80.6284 41.423L80.9609 41.0917C82.4046 39.6612 84.7437 39.6642 86.1859 41.1045C86.8799 41.7955 87.2622 42.7212 87.2622 43.7112C87.2622 44.701 86.8799 45.6267 86.1804 46.3232L83.9771 48.531C83.9769 48.5312 83.9767 48.5315 83.9764 48.532L81.4534 51.0447C80.4681 52.026 80.4649 53.6202 81.4462 54.6052C82.4274 55.5905 84.0214 55.5935 85.0067 54.6125L87.5412 52.0882C88.2339 51.3942 89.1622 51.0122 90.1552 51.0122C91.1484 51.0122 92.0769 51.3942 92.7747 52.0932C93.4687 52.7845 93.8507 53.7102 93.8507 54.7002C93.8507 55.69 93.4687 56.6157 92.7707 57.3107L88.3782 61.705C87.3951 62.6885 87.3954 64.2825 88.3787 65.2655C88.8704 65.757 89.5144 66.0025 90.1587 66.0025C90.8032 66.0025 91.4477 65.7565 91.9392 65.2647L94.0919 63.1112C94.1042 63.0995 94.1174 63.0892 94.1297 63.077C94.8224 62.383 95.7507 62.001 96.7437 62.001C97.7369 62.001 98.6652 62.383 99.3604 63.0795C100.799 64.5162 100.797 66.8587 99.3604 68.2982L97.1717 70.4845C97.1709 70.4852 97.1699 70.486 97.1692 70.4867C97.1684 70.4875 97.1676 70.4885 97.1669 70.4892L93.6929 73.959C92.7092 74.9417 92.7082 76.536 93.6907 77.5197C94.1824 78.012 94.8274 78.2582 95.4722 78.2582C96.1159 78.2582 96.7599 78.0127 97.2514 77.522L98.9507 75.8247L107.095 83.9595L83.9062 107.12L75.5977 98.8215C76.1769 98.449 76.7312 98.011 77.2514 97.4907L79.4902 95.2547C80.4744 94.2725 80.4754 92.6782 79.4927 91.6945ZM121.762 94.8125L94.7769 121.765C94.1457 122.395 93.3007 122.743 92.3977 122.743C91.4947 122.743 90.6497 122.395 90.0182 121.765L85.5689 117.321C84.9384 116.691 84.5912 115.849 84.5912 114.949C84.5912 114.049 84.9384 113.206 85.5689 112.576L112.554 85.624C113.186 84.9932 114.03 84.646 114.934 84.646C115.837 84.646 116.682 84.9932 117.315 85.6255L121.762 90.0607C122.393 90.6905 122.74 91.534 122.74 92.4365C122.74 93.3392 122.393 94.183 121.762 94.8125Z"
                        fill="#EBECED" />
                    <path
                        d="M30.3434 14.1438C30.8349 14.6343 31.4784 14.8793 32.1219 14.8793C32.7669 14.8793 33.4121 14.6328 33.9039 14.14C34.8861 13.1558 34.8846 11.5618 33.9004 10.5795L24.7259 1.42328C23.7419 0.441032 22.1476 0.442282 21.1654 1.42678C20.1831 2.41103 20.1846 4.00503 21.1689 4.98728L30.3434 14.1438Z"
                        fill="#EBECED" />
                    <path
                        d="M95.4317 14.8792C96.0755 14.8792 96.7195 14.6337 97.211 14.1429L106.379 4.98644C107.362 4.00394 107.363 2.40969 106.381 1.42594C105.398 0.442188 103.804 0.441188 102.82 1.42394L93.6525 10.5804C92.6688 11.5629 92.6677 13.1572 93.6505 14.1409C94.1422 14.6332 94.787 14.8792 95.4317 14.8792Z"
                        fill="#EBECED" />
                    <path
                        d="M15.7067 108.3C14.7319 109.291 14.7454 110.885 15.7372 111.86L15.7444 111.867C16.2337 112.348 16.8689 112.588 17.5039 112.588C18.1557 112.588 18.8074 112.335 19.3012 111.833C20.2759 110.842 20.2587 109.244 19.2672 108.269C18.2759 107.294 16.6819 107.308 15.7067 108.3Z"
                        fill="#EBECED" />
                    <path
                        d="M85.6491 88.0685C86.0321 88.0685 86.4206 87.9813 86.7854 87.7975C88.0269 87.1713 88.5256 85.6573 87.8996 84.4158C87.2734 83.1743 85.7591 82.6753 84.5179 83.3015L84.5039 83.3085C83.2624 83.9348 82.7706 85.4453 83.3966 86.6868C83.8386 87.5638 84.7276 88.0685 85.6491 88.0685Z"
                        fill="#EBECED" />
                </g>
                <defs>
                    <clipPath id="clip0_34_15812">
                        <rect width="128" height="128" fill="white" />
                    </clipPath>
                </defs>
            </svg>
        </span>
        <div class="td_height_100 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    <i></i>
                    Featured Instructor
                    <i></i>
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">Our Expert Instructor</h2>
                <p class="td_section_subtitle td_fs_18 mb-0">
                    Far far away, behind the word mountains, far from the Consonantia, there <br>live the blind texts.
                    Separated they marks grove right</p>
            </div>
            <div class="td_height_50 td_height_lg_50"></div>
            <div class="row td_gap_y_30">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.25s">
                    <div class="td_team td_style_1 td_style-home-four text-center position-relative">

                        <img src="uploads/website-images/david.png" alt=""
                            class="w-100 td_radius_10" />

                        <a href="instructors/david-rechard-20250115042132.html" class="td_team_info td_white_bg">
                            <h3 class="td_team_member_title td_fs_18 td_semibold mb-0">David Malan</h3>
                            <p class="td_team_member_designation mb-0 td_fs_14 td_opacity_7 td_heading_color">Laravel
                                Developer</p>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.25s">
                    <div class="td_team td_style_1 td_style-home-four text-center position-relative">

                        <img src="uploads/website-images/richard.png" alt=""
                            class="w-100 td_radius_10" />

                        <a href="instructors/david-rechard-20250118091258.html" class="td_team_info td_white_bg">
                            <h3 class="td_team_member_title td_fs_18 td_semibold mb-0">David Richard</h3>
                            <p class="td_team_member_designation mb-0 td_fs_14 td_opacity_7 td_heading_color">Web
                                Developer</p>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.25s">
                    <div class="td_team td_style_1 td_style-home-four text-center position-relative">

                        <img src="uploads/website-images/selena.png" alt=""
                            class="w-100 td_radius_10" />

                        <a href="instructors/sabbir-rahman-20250118091258.html" class="td_team_info td_white_bg">
                            <h3 class="td_team_member_title td_fs_18 td_semibold mb-0">Selena Gomez</h3>
                            <p class="td_team_member_designation mb-0 td_fs_14 td_opacity_7 td_heading_color">Web
                                Developer</p>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.25s">
                    <div class="td_team td_style_1 td_style-home-four text-center position-relative">

                        <img src="uploads/website-images/islam.png" alt=""
                            class="w-100 td_radius_10" />

                        <a href="instructors/rajibul-islam-20250118091258.html" class="td_team_info td_white_bg">
                            <h3 class="td_team_member_title td_fs_18 td_semibold mb-0">Rajibul Islam</h3>
                            <p class="td_team_member_designation mb-0 td_fs_14 td_opacity_7 td_heading_color">Web
                                Developer</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="td_height_60 td_height_lg_40"></div>
            <div class="text-center wow zoomIn" data-wow-duration="1s" data-wow-delay="0.2s">

                <a href="instructors.html" class="td_btn td_style_1 td_radius_30 td_medium td_with_shadow">
                    <span class="td_btn_in td_white_color td_accent_bg">
                        <span>See All Instructors</span>
                        <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                            <path
                                d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                    </span>
                </a>

            </div>
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Team Section -->


    <!-- Start Testimonial Section -->
    <section class="td_heading_bg td_heading_bg_forth T td_hobble">
        <div class="td_height_100 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <h2 class="td_section_title td_fs_48 mb-0 td_white_color">Start your journey With Us</h2>
                <div class="d-flex justify-content-center">
                    <p class="td_section_subtitle td_fs_18 mb-0 td_white_color td_opacity_7 qs-custom-min-width-1">
                        Education is a dynamic and evolving field that plays a crucial role in shaping individuals and
                        societies. While significant challenges
                    </p>
                </div>
            </div>
            <div class="td_height_50 td_height_lg_50"></div>
            <div class="row align-items-center td_gap_y_40">
                <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_testimonial_img_wrap">
                        <img src="uploads/website-images/journey1.png" alt=""
                            class="td_testimonial_img">
                        <span class="td_testimonial_img_shape_1"><span></span></span>
                        <span class="td_testimonial_img_shape_2 td_accent_color td_hover_layer_3">
                            <svg width="145" height="165" viewBox="0 0 145 165" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M145.003 25.9077L139.516 27.7024L143.814 31.5573L145.003 25.9077ZM69.5244 11.4999L69.2176 11.1051L69.5244 11.4999ZM69.5244 53.0379L69.3973 53.5215L69.5244 53.0379ZM141.65 28.8989C135.031 35.2997 125.943 38.4375 116.315 39.2654C106.688 40.0931 96.561 38.607 87.9207 35.8021C79.2649 32.9923 72.1739 28.8832 68.5572 24.5234C66.753 22.3484 65.8508 20.1579 65.9824 18.0635C66.1133 15.9807 67.2739 13.8818 69.8312 11.8948L69.2176 11.1051C66.5057 13.2123 65.1383 15.552 64.9844 18.0007C64.8313 20.4378 65.8877 22.8715 67.7876 25.1618C71.5792 29.7325 78.8783 33.9182 87.6119 36.7533C96.361 39.5934 106.622 41.1025 116.4 40.2617C126.177 39.4211 135.511 36.2268 142.346 29.6178L141.65 28.8989ZM69.8312 11.8948C76.1217 7.00714 81.1226 4.09865 85.0169 2.71442C88.9178 1.32781 91.6197 1.49918 93.4091 2.61867C95.1994 3.73872 96.231 5.90455 96.5629 8.8701C96.894 11.8276 96.5159 15.4895 95.5803 19.4474C93.7094 27.3612 89.6393 36.3356 84.7843 42.9886C82.3565 46.3156 79.7503 49.0371 77.1481 50.7594C74.545 52.4823 72.001 53.1717 69.6515 52.5543L69.3973 53.5215C72.1238 54.238 74.964 53.4042 77.7 51.5933C80.437 49.7818 83.1248 46.9592 85.5921 43.578C90.5275 36.8148 94.6527 27.7176 96.5534 19.6775C97.5035 15.6584 97.9053 11.8728 97.5567 8.75886C97.2091 5.65298 96.1014 3.12347 93.9395 1.77091C91.7766 0.417783 88.7131 0.33927 84.6819 1.77217C80.6441 3.20744 75.5463 6.18784 69.2176 11.1051L69.8312 11.8948ZM69.6515 52.5543C56.6241 49.1307 47.457 52.0938 41.14 58.6639C34.8623 65.1932 31.4678 75.2154 29.7777 85.7878C28.0854 96.3743 28.0905 107.589 28.673 116.58C28.9644 121.078 29.4007 125.024 29.843 128.065C30.2827 131.086 30.7341 133.255 31.0666 134.168L32.0062 133.825C31.7138 133.023 31.2736 130.952 30.8326 127.921C30.3942 124.908 29.9607 120.988 29.6709 116.516C29.0912 107.568 29.0886 96.4337 30.7652 85.9456C32.444 75.4434 35.7949 65.6661 41.8608 59.357C47.8875 53.0888 56.6625 50.1748 69.3973 53.5215L69.6515 52.5543Z"
                                    fill="white" />
                                <circle cx="34" cy="150" r="15" fill="currentColor" />
                                <circle cx="15" cy="137" r="15" fill="currentColor" />
                                <circle cx="24" cy="144" r="15" fill="white" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_slider td_style_1">
                        <div class="td_slider_container" data-autoplay="0" data-loop="1" data-speed="800"
                            data-center="0" data-variable-width="0" data-slides-per-view="1">
                            <div class="td_slider_wrapper">
                                <div class="td_slide">
                                    <div class="td_testimonial td_style_1 td_white_bg td_radius_5">
                                        <span class="td_quote_icon td_accent_color">
                                            <svg width="65" height="46" viewBox="0 0 65 46" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.05"
                                                    d="M13.9286 26.6H1V1H26.8571V27.362L17.956 45H6.26764L14.8213 28.0505L15.5534 26.6H13.9286ZM51.0714 26.6H38.1429V1H64V27.362L55.0988 45H43.4105L51.9642 28.0505L52.6962 26.6H51.0714Z"
                                                    fill="currentColor" stroke="currentColor" stroke-width="2" />
                                            </svg>
                                        </span>
                                        <div class="td_testimonial_meta td_mb_24">
                                            <img src="uploads/website-images/img1.jpg" alt="">
                                            <div class="td_testimonial_meta_right">
                                                <h3 class="td_fs_24 td_semibold td_mb_2">Karvin McSinney</h3>
                                                <p class="td_fs_14 mb-0 td_heading_color td_opacity_7">8th Batch
                                                    Students</p>
                                            </div>
                                        </div>
                                        <blockquote
                                            class="td_testimonial_text td_fs_20 td_medium td_heading_color td_mb_24 td_opacity_9">
                                            Frameworks such as Coursera, edX, and university-specific online programs
                                            provide greater flexibility and accessibility to a broader audience. The
                                            pandemic significantly accelerated learning models.
                                        </blockquote>
                                        <div class="td_rating" data-rating="4">
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <div class="td_rating_percentage">
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="td_slide">
                                    <div class="td_testimonial td_style_1 td_white_bg td_radius_5">
                                        <span class="td_quote_icon td_accent_color">
                                            <svg width="65" height="46" viewBox="0 0 65 46" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.05"
                                                    d="M13.9286 26.6H1V1H26.8571V27.362L17.956 45H6.26764L14.8213 28.0505L15.5534 26.6H13.9286ZM51.0714 26.6H38.1429V1H64V27.362L55.0988 45H43.4105L51.9642 28.0505L52.6962 26.6H51.0714Z"
                                                    fill="currentColor" stroke="currentColor" stroke-width="2" />
                                            </svg>
                                        </span>
                                        <div class="td_testimonial_meta td_mb_24">
                                            <img src="uploads/custom-images/sarvin-mckinney-20250115023253.html" alt="">
                                            <div class="td_testimonial_meta_right">
                                                <h3 class="td_fs_24 td_semibold td_mb_2">Sarvin McKinney</h3>
                                                <p class="td_fs_14 mb-0 td_heading_color td_opacity_7">10th Batch
                                                    Students</p>
                                            </div>
                                        </div>
                                        <blockquote
                                            class="td_testimonial_text td_fs_20 td_medium td_heading_color td_mb_24 td_opacity_9">
                                            Platforms like Coursera, edX, and university-specific online programs offer
                                            flexibility and
                                            accessibility to a wider audience. The pandemic has accelerated the shift to
                                            online and hybrid
                                            learning models.
                                        </blockquote>
                                        <div class="td_rating" data-rating="5">
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <div class="td_rating_percentage">
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="td_slide">
                                    <div class="td_testimonial td_style_1 td_white_bg td_radius_5">
                                        <span class="td_quote_icon td_accent_color">
                                            <svg width="65" height="46" viewBox="0 0 65 46" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.05"
                                                    d="M13.9286 26.6H1V1H26.8571V27.362L17.956 45H6.26764L14.8213 28.0505L15.5534 26.6H13.9286ZM51.0714 26.6H38.1429V1H64V27.362L55.0988 45H43.4105L51.9642 28.0505L52.6962 26.6H51.0714Z"
                                                    fill="currentColor" stroke="currentColor" stroke-width="2" />
                                            </svg>
                                        </span>
                                        <div class="td_testimonial_meta td_mb_24">
                                            <img src="uploads/custom-images/marvin-mckinney-20250115023046.html" alt="">
                                            <div class="td_testimonial_meta_right">
                                                <h3 class="td_fs_24 td_semibold td_mb_2">Marvin McKinney</h3>
                                                <p class="td_fs_14 mb-0 td_heading_color td_opacity_7">15th Batch
                                                    Students</p>
                                            </div>
                                        </div>
                                        <blockquote
                                            class="td_testimonial_text td_fs_20 td_medium td_heading_color td_mb_24 td_opacity_9">
                                            The pandemic has accelerated the shift to online and hybrid learning models.
                                            Platforms like Coursera, edX, and university-specific online programs offer
                                            flexibility and accessibility to a wider audience.
                                        </blockquote>
                                        <div class="td_rating" data-rating="5">
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                            <div class="td_rating_percentage">
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                                <i class="fa-solid fa-star fa-fw"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Testimonial Section -->

    <!-- Start Blog Section -->
    <section>
        <div class="td_height_100 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <p
                    class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    BLOG &amp; ARTICLES</p>
                <h2 class="td_section_title td_fs_48 mb-0">Take A Look At The Latest <br>Articles</h2>
            </div>
            <div class="td_height_50 td_height_lg_50"></div>
            <div class="row td_gap_y_30">
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_post td_style_1">
                        <a href="blog/navigating-the-new-education-system-a-students-guide.html"
                            class="td_post_thumb d-block">
                            <img src="uploads/website-images/blog1.jpg" alt="">
                            <i class="fa-solid fa-link"></i>
                        </a>
                        <div class="td_post_info">
                            <div class="td_post_meta td_fs_14 td_medium td_mb_20">
                                <span>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_5145_10345)">
                                            <path
                                                d="M12.6667 1.33333H12V0.666667C12 0.489856 11.9298 0.320286 11.8047 0.195262C11.6797 0.0702379 11.5101 0 11.3333 0C11.1565 0 10.987 0.0702379 10.8619 0.195262C10.7369 0.320286 10.6667 0.489856 10.6667 0.666667V1.33333H5.33333V0.666667C5.33333 0.489856 5.2631 0.320286 5.13807 0.195262C5.01305 0.0702379 4.84348 0 4.66667 0C4.48986 0 4.32029 0.0702379 4.19526 0.195262C4.07024 0.320286 4 0.489856 4 0.666667V1.33333H3.33333C2.4496 1.33439 1.60237 1.68592 0.97748 2.31081C0.352588 2.93571 0.00105857 3.78294 0 4.66667L0 12.6667C0.00105857 13.5504 0.352588 14.3976 0.97748 15.0225C1.60237 15.6474 2.4496 15.9989 3.33333 16H12.6667C13.5504 15.9989 14.3976 15.6474 15.0225 15.0225C15.6474 14.3976 15.9989 13.5504 16 12.6667V4.66667C15.9989 3.78294 15.6474 2.93571 15.0225 2.31081C14.3976 1.68592 13.5504 1.33439 12.6667 1.33333ZM1.33333 4.66667C1.33333 4.13623 1.54405 3.62753 1.91912 3.25245C2.29419 2.87738 2.8029 2.66667 3.33333 2.66667H12.6667C13.1971 2.66667 13.7058 2.87738 14.0809 3.25245C14.456 3.62753 14.6667 4.13623 14.6667 4.66667V5.33333H1.33333V4.66667ZM12.6667 14.6667H3.33333C2.8029 14.6667 2.29419 14.456 1.91912 14.0809C1.54405 13.7058 1.33333 13.1971 1.33333 12.6667V6.66667H14.6667V12.6667C14.6667 13.1971 14.456 13.7058 14.0809 14.0809C13.7058 14.456 13.1971 14.6667 12.6667 14.6667Z"
                                                fill="black" />
                                            <path
                                                d="M8 11C8.55228 11 9 10.5523 9 10C9 9.44772 8.55228 9 8 9C7.44772 9 7 9.44772 7 10C7 10.5523 7.44772 11 8 11Z"
                                                fill="black" />
                                            <path
                                                d="M4.66602 11C5.2183 11 5.66602 10.5523 5.66602 10C5.66602 9.44772 5.2183 9 4.66602 9C4.11373 9 3.66602 9.44772 3.66602 10C3.66602 10.5523 4.11373 11 4.66602 11Z"
                                                fill="black" />
                                            <path
                                                d="M11.334 11C11.8863 11 12.334 10.5523 12.334 10C12.334 9.44772 11.8863 9 11.334 9C10.7817 9 10.334 9.44772 10.334 10C10.334 10.5523 10.7817 11 11.334 11Z"
                                                fill="black" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_5145_10345">
                                                <rect width="16" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    15-01-2025
                                </span>
                                <span>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_34_15948)">
                                            <path
                                                d="M7.885 7.70726C8.94384 7.70726 9.86058 7.3275 10.6099 6.57823C11.3589 5.82909 11.7388 4.91247 11.7388 3.85351C11.7388 2.79492 11.359 1.87817 10.6097 1.12878C9.86046 0.37976 8.94372 0 7.885 0C6.82604 0 5.90942 0.37976 5.16028 1.1289C4.41113 1.87805 4.03125 2.79479 4.03125 3.85351C4.03125 4.91247 4.41113 5.82921 5.16028 6.57836C5.90966 7.32738 6.82641 7.70726 7.885 7.70726ZM5.82336 1.79187C6.39819 1.21704 7.0725 0.93762 7.885 0.93762C8.69738 0.93762 9.37182 1.21704 9.94677 1.79187C10.5216 2.36682 10.8011 3.04125 10.8011 3.85351C10.8011 4.66601 10.5216 5.34032 9.94677 5.91527C9.37182 6.49022 8.69738 6.76964 7.885 6.76964C7.07275 6.76964 6.39843 6.4901 5.82336 5.91527C5.24841 5.34044 4.96887 4.66601 4.96887 3.85351C4.96887 3.04125 5.24841 2.36682 5.82336 1.79187Z"
                                                fill="#00001B" />
                                            <path
                                                d="M14.629 12.309C14.6074 11.9972 14.5637 11.6571 14.4994 11.298C14.4344 10.9362 14.3508 10.5941 14.2507 10.2815C14.1472 9.95837 14.0067 9.63928 13.8327 9.33349C13.6524 9.01611 13.4405 8.73974 13.2027 8.51233C12.9541 8.27441 12.6496 8.08313 12.2976 7.9436C11.9468 7.80481 11.558 7.7345 11.1421 7.7345C10.9787 7.7345 10.8208 7.80151 10.5157 8.00012C10.328 8.12256 10.1084 8.26416 9.86327 8.42077C9.65367 8.55432 9.36974 8.67944 9.01903 8.79272C8.67687 8.90344 8.32945 8.95959 7.98644 8.95959C7.64366 8.95959 7.29625 8.90344 6.95385 8.79272C6.60351 8.67956 6.31945 8.55444 6.11022 8.4209C5.86742 8.26575 5.6477 8.12414 5.45715 8C5.15234 7.80139 4.99438 7.73438 4.83105 7.73438C4.41503 7.73438 4.02636 7.80481 3.67565 7.94373C3.32385 8.08301 3.01928 8.27429 2.77038 8.51245C2.53259 8.73999 2.32068 9.01623 2.1405 9.33349C1.9668 9.63928 1.82617 9.95825 1.72266 10.2816C1.62268 10.5942 1.53906 10.9362 1.47412 11.298C1.40967 11.6566 1.36609 11.9968 1.34448 12.3093C1.32324 12.6149 1.3125 12.9329 1.3125 13.2541C1.3125 14.0893 1.578 14.7655 2.10156 15.2641C2.61865 15.7562 3.30273 16.0057 4.13488 16.0057H11.839C12.6709 16.0057 13.355 15.7562 13.8722 15.2641C14.3958 14.7659 14.6614 14.0895 14.6614 13.254C14.6612 12.9316 14.6504 12.6136 14.629 12.309ZM13.2257 14.5848C12.884 14.91 12.4304 15.0681 11.8388 15.0681H4.13488C3.54321 15.0681 3.0896 14.91 2.74804 14.5849C2.41296 14.266 2.25012 13.8306 2.25012 13.2541C2.25012 12.9543 2.26001 12.6583 2.27978 12.3741C2.29907 12.0953 2.3385 11.7891 2.39697 11.4636C2.45471 11.1422 2.5282 10.8406 2.6156 10.5675C2.69946 10.3057 2.81384 10.0464 2.95569 9.79663C3.09106 9.55859 3.24682 9.35437 3.4187 9.18982C3.57946 9.03589 3.7821 8.90991 4.02087 8.81543C4.24169 8.72803 4.48986 8.68017 4.75927 8.67297C4.79211 8.69043 4.85058 8.72375 4.94531 8.78552C5.13805 8.91113 5.36022 9.05444 5.60583 9.2113C5.88268 9.38781 6.23937 9.54724 6.66552 9.68481C7.10119 9.82568 7.54552 9.89721 7.98656 9.89721C8.4276 9.89721 8.87206 9.82568 9.30748 9.68493C9.73399 9.54712 10.0906 9.38781 10.3678 9.21106C10.6191 9.05041 10.8351 8.91125 11.0278 8.78552C11.1225 8.72387 11.181 8.69043 11.2138 8.67297C11.4834 8.68017 11.7315 8.72803 11.9525 8.81543C12.1911 8.90991 12.3938 9.03601 12.5545 9.18982C12.7264 9.35424 12.8822 9.55847 13.0176 9.79675C13.1595 10.0464 13.274 10.3058 13.3578 10.5674C13.4453 10.8408 13.5189 11.1423 13.5765 11.4635C13.6349 11.7895 13.6744 12.0959 13.6937 12.3743V12.3745C13.7136 12.6576 13.7236 12.9535 13.7237 13.2541C13.7236 13.8307 13.5608 14.266 13.2257 14.5848Z"
                                                fill="#00001B" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_34_15948">
                                                <rect width="16" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    John Doe
                                </span>
                            </div>
                            <h2 class="td_post_title td_fs_24 td_medium td_mb_16">
                                <a href="blog/navigating-the-new-education-system-a-students-guide.html">Navigating the
                                    New Education System: A Student&#039;s Guide</a>
                            </h2>
                            <p class="td_post_subtitle td_mb_24 td_heading_color td_opacity_7">Education is a dynamic
                                and evolving field that plays a crucial.</p>
                            <a href="blog/navigating-the-new-education-system-a-students-guide.html"
                                class="td_btn td_style_1 td_type_3 td_radius_30 td_medium">
                                <span class="td_btn_in td_accent_color">
                                    <span>Read More</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_post td_style_1">
                        <a href="blog/overview-of-the-new-education-system-for-students.html"
                            class="td_post_thumb d-block">
                            <img src="uploads/website-images/blog2.jpg" alt="">
                            <i class="fa-solid fa-link"></i>
                        </a>
                        <div class="td_post_info">
                            <div class="td_post_meta td_fs_14 td_medium td_mb_20">
                                <span>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_5145_10345)">
                                            <path
                                                d="M12.6667 1.33333H12V0.666667C12 0.489856 11.9298 0.320286 11.8047 0.195262C11.6797 0.0702379 11.5101 0 11.3333 0C11.1565 0 10.987 0.0702379 10.8619 0.195262C10.7369 0.320286 10.6667 0.489856 10.6667 0.666667V1.33333H5.33333V0.666667C5.33333 0.489856 5.2631 0.320286 5.13807 0.195262C5.01305 0.0702379 4.84348 0 4.66667 0C4.48986 0 4.32029 0.0702379 4.19526 0.195262C4.07024 0.320286 4 0.489856 4 0.666667V1.33333H3.33333C2.4496 1.33439 1.60237 1.68592 0.97748 2.31081C0.352588 2.93571 0.00105857 3.78294 0 4.66667L0 12.6667C0.00105857 13.5504 0.352588 14.3976 0.97748 15.0225C1.60237 15.6474 2.4496 15.9989 3.33333 16H12.6667C13.5504 15.9989 14.3976 15.6474 15.0225 15.0225C15.6474 14.3976 15.9989 13.5504 16 12.6667V4.66667C15.9989 3.78294 15.6474 2.93571 15.0225 2.31081C14.3976 1.68592 13.5504 1.33439 12.6667 1.33333ZM1.33333 4.66667C1.33333 4.13623 1.54405 3.62753 1.91912 3.25245C2.29419 2.87738 2.8029 2.66667 3.33333 2.66667H12.6667C13.1971 2.66667 13.7058 2.87738 14.0809 3.25245C14.456 3.62753 14.6667 4.13623 14.6667 4.66667V5.33333H1.33333V4.66667ZM12.6667 14.6667H3.33333C2.8029 14.6667 2.29419 14.456 1.91912 14.0809C1.54405 13.7058 1.33333 13.1971 1.33333 12.6667V6.66667H14.6667V12.6667C14.6667 13.1971 14.456 13.7058 14.0809 14.0809C13.7058 14.456 13.1971 14.6667 12.6667 14.6667Z"
                                                fill="black" />
                                            <path
                                                d="M8 11C8.55228 11 9 10.5523 9 10C9 9.44772 8.55228 9 8 9C7.44772 9 7 9.44772 7 10C7 10.5523 7.44772 11 8 11Z"
                                                fill="black" />
                                            <path
                                                d="M4.66602 11C5.2183 11 5.66602 10.5523 5.66602 10C5.66602 9.44772 5.2183 9 4.66602 9C4.11373 9 3.66602 9.44772 3.66602 10C3.66602 10.5523 4.11373 11 4.66602 11Z"
                                                fill="black" />
                                            <path
                                                d="M11.334 11C11.8863 11 12.334 10.5523 12.334 10C12.334 9.44772 11.8863 9 11.334 9C10.7817 9 10.334 9.44772 10.334 10C10.334 10.5523 10.7817 11 11.334 11Z"
                                                fill="black" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_5145_10345">
                                                <rect width="16" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    15-01-2025
                                </span>
                                <span>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_34_15948)">
                                            <path
                                                d="M7.885 7.70726C8.94384 7.70726 9.86058 7.3275 10.6099 6.57823C11.3589 5.82909 11.7388 4.91247 11.7388 3.85351C11.7388 2.79492 11.359 1.87817 10.6097 1.12878C9.86046 0.37976 8.94372 0 7.885 0C6.82604 0 5.90942 0.37976 5.16028 1.1289C4.41113 1.87805 4.03125 2.79479 4.03125 3.85351C4.03125 4.91247 4.41113 5.82921 5.16028 6.57836C5.90966 7.32738 6.82641 7.70726 7.885 7.70726ZM5.82336 1.79187C6.39819 1.21704 7.0725 0.93762 7.885 0.93762C8.69738 0.93762 9.37182 1.21704 9.94677 1.79187C10.5216 2.36682 10.8011 3.04125 10.8011 3.85351C10.8011 4.66601 10.5216 5.34032 9.94677 5.91527C9.37182 6.49022 8.69738 6.76964 7.885 6.76964C7.07275 6.76964 6.39843 6.4901 5.82336 5.91527C5.24841 5.34044 4.96887 4.66601 4.96887 3.85351C4.96887 3.04125 5.24841 2.36682 5.82336 1.79187Z"
                                                fill="#00001B" />
                                            <path
                                                d="M14.629 12.309C14.6074 11.9972 14.5637 11.6571 14.4994 11.298C14.4344 10.9362 14.3508 10.5941 14.2507 10.2815C14.1472 9.95837 14.0067 9.63928 13.8327 9.33349C13.6524 9.01611 13.4405 8.73974 13.2027 8.51233C12.9541 8.27441 12.6496 8.08313 12.2976 7.9436C11.9468 7.80481 11.558 7.7345 11.1421 7.7345C10.9787 7.7345 10.8208 7.80151 10.5157 8.00012C10.328 8.12256 10.1084 8.26416 9.86327 8.42077C9.65367 8.55432 9.36974 8.67944 9.01903 8.79272C8.67687 8.90344 8.32945 8.95959 7.98644 8.95959C7.64366 8.95959 7.29625 8.90344 6.95385 8.79272C6.60351 8.67956 6.31945 8.55444 6.11022 8.4209C5.86742 8.26575 5.6477 8.12414 5.45715 8C5.15234 7.80139 4.99438 7.73438 4.83105 7.73438C4.41503 7.73438 4.02636 7.80481 3.67565 7.94373C3.32385 8.08301 3.01928 8.27429 2.77038 8.51245C2.53259 8.73999 2.32068 9.01623 2.1405 9.33349C1.9668 9.63928 1.82617 9.95825 1.72266 10.2816C1.62268 10.5942 1.53906 10.9362 1.47412 11.298C1.40967 11.6566 1.36609 11.9968 1.34448 12.3093C1.32324 12.6149 1.3125 12.9329 1.3125 13.2541C1.3125 14.0893 1.578 14.7655 2.10156 15.2641C2.61865 15.7562 3.30273 16.0057 4.13488 16.0057H11.839C12.6709 16.0057 13.355 15.7562 13.8722 15.2641C14.3958 14.7659 14.6614 14.0895 14.6614 13.254C14.6612 12.9316 14.6504 12.6136 14.629 12.309ZM13.2257 14.5848C12.884 14.91 12.4304 15.0681 11.8388 15.0681H4.13488C3.54321 15.0681 3.0896 14.91 2.74804 14.5849C2.41296 14.266 2.25012 13.8306 2.25012 13.2541C2.25012 12.9543 2.26001 12.6583 2.27978 12.3741C2.29907 12.0953 2.3385 11.7891 2.39697 11.4636C2.45471 11.1422 2.5282 10.8406 2.6156 10.5675C2.69946 10.3057 2.81384 10.0464 2.95569 9.79663C3.09106 9.55859 3.24682 9.35437 3.4187 9.18982C3.57946 9.03589 3.7821 8.90991 4.02087 8.81543C4.24169 8.72803 4.48986 8.68017 4.75927 8.67297C4.79211 8.69043 4.85058 8.72375 4.94531 8.78552C5.13805 8.91113 5.36022 9.05444 5.60583 9.2113C5.88268 9.38781 6.23937 9.54724 6.66552 9.68481C7.10119 9.82568 7.54552 9.89721 7.98656 9.89721C8.4276 9.89721 8.87206 9.82568 9.30748 9.68493C9.73399 9.54712 10.0906 9.38781 10.3678 9.21106C10.6191 9.05041 10.8351 8.91125 11.0278 8.78552C11.1225 8.72387 11.181 8.69043 11.2138 8.67297C11.4834 8.68017 11.7315 8.72803 11.9525 8.81543C12.1911 8.90991 12.3938 9.03601 12.5545 9.18982C12.7264 9.35424 12.8822 9.55847 13.0176 9.79675C13.1595 10.0464 13.274 10.3058 13.3578 10.5674C13.4453 10.8408 13.5189 11.1423 13.5765 11.4635C13.6349 11.7895 13.6744 12.0959 13.6937 12.3743V12.3745C13.7136 12.6576 13.7236 12.9535 13.7237 13.2541C13.7236 13.8307 13.5608 14.266 13.2257 14.5848Z"
                                                fill="#00001B" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_34_15948">
                                                <rect width="16" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    John Doe
                                </span>
                            </div>
                            <h2 class="td_post_title td_fs_24 td_medium td_mb_16">
                                <a href="blog/overview-of-the-new-education-system-for-students.html">Overview of the
                                    New Education System for Students</a>
                            </h2>
                            <p class="td_post_subtitle td_mb_24 td_heading_color td_opacity_7">Education is a dynamic
                                and evolving field that plays a crucial.</p>
                            <a href="blog/overview-of-the-new-education-system-for-students.html"
                                class="td_btn td_style_1 td_type_3 td_radius_30 td_medium">
                                <span class="td_btn_in td_accent_color">
                                    <span>Read More</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="td_post td_style_1">
                        <a href="blog/complete-guide-for-students-on-the-new-education-system.html"
                            class="td_post_thumb d-block">
                            <img src="uploads/website-images/blog1.jpg" alt="">
                            <i class="fa-solid fa-link"></i>
                        </a>
                        <div class="td_post_info">
                            <div class="td_post_meta td_fs_14 td_medium td_mb_20">
                                <span>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_5145_10345)">
                                            <path
                                                d="M12.6667 1.33333H12V0.666667C12 0.489856 11.9298 0.320286 11.8047 0.195262C11.6797 0.0702379 11.5101 0 11.3333 0C11.1565 0 10.987 0.0702379 10.8619 0.195262C10.7369 0.320286 10.6667 0.489856 10.6667 0.666667V1.33333H5.33333V0.666667C5.33333 0.489856 5.2631 0.320286 5.13807 0.195262C5.01305 0.0702379 4.84348 0 4.66667 0C4.48986 0 4.32029 0.0702379 4.19526 0.195262C4.07024 0.320286 4 0.489856 4 0.666667V1.33333H3.33333C2.4496 1.33439 1.60237 1.68592 0.97748 2.31081C0.352588 2.93571 0.00105857 3.78294 0 4.66667L0 12.6667C0.00105857 13.5504 0.352588 14.3976 0.97748 15.0225C1.60237 15.6474 2.4496 15.9989 3.33333 16H12.6667C13.5504 15.9989 14.3976 15.6474 15.0225 15.0225C15.6474 14.3976 15.9989 13.5504 16 12.6667V4.66667C15.9989 3.78294 15.6474 2.93571 15.0225 2.31081C14.3976 1.68592 13.5504 1.33439 12.6667 1.33333ZM1.33333 4.66667C1.33333 4.13623 1.54405 3.62753 1.91912 3.25245C2.29419 2.87738 2.8029 2.66667 3.33333 2.66667H12.6667C13.1971 2.66667 13.7058 2.87738 14.0809 3.25245C14.456 3.62753 14.6667 4.13623 14.6667 4.66667V5.33333H1.33333V4.66667ZM12.6667 14.6667H3.33333C2.8029 14.6667 2.29419 14.456 1.91912 14.0809C1.54405 13.7058 1.33333 13.1971 1.33333 12.6667V6.66667H14.6667V12.6667C14.6667 13.1971 14.456 13.7058 14.0809 14.0809C13.7058 14.456 13.1971 14.6667 12.6667 14.6667Z"
                                                fill="black" />
                                            <path
                                                d="M8 11C8.55228 11 9 10.5523 9 10C9 9.44772 8.55228 9 8 9C7.44772 9 7 9.44772 7 10C7 10.5523 7.44772 11 8 11Z"
                                                fill="black" />
                                            <path
                                                d="M4.66602 11C5.2183 11 5.66602 10.5523 5.66602 10C5.66602 9.44772 5.2183 9 4.66602 9C4.11373 9 3.66602 9.44772 3.66602 10C3.66602 10.5523 4.11373 11 4.66602 11Z"
                                                fill="black" />
                                            <path
                                                d="M11.334 11C11.8863 11 12.334 10.5523 12.334 10C12.334 9.44772 11.8863 9 11.334 9C10.7817 9 10.334 9.44772 10.334 10C10.334 10.5523 10.7817 11 11.334 11Z"
                                                fill="black" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_5145_10345">
                                                <rect width="16" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    15-01-2025
                                </span>
                                <span>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_34_15948)">
                                            <path
                                                d="M7.885 7.70726C8.94384 7.70726 9.86058 7.3275 10.6099 6.57823C11.3589 5.82909 11.7388 4.91247 11.7388 3.85351C11.7388 2.79492 11.359 1.87817 10.6097 1.12878C9.86046 0.37976 8.94372 0 7.885 0C6.82604 0 5.90942 0.37976 5.16028 1.1289C4.41113 1.87805 4.03125 2.79479 4.03125 3.85351C4.03125 4.91247 4.41113 5.82921 5.16028 6.57836C5.90966 7.32738 6.82641 7.70726 7.885 7.70726ZM5.82336 1.79187C6.39819 1.21704 7.0725 0.93762 7.885 0.93762C8.69738 0.93762 9.37182 1.21704 9.94677 1.79187C10.5216 2.36682 10.8011 3.04125 10.8011 3.85351C10.8011 4.66601 10.5216 5.34032 9.94677 5.91527C9.37182 6.49022 8.69738 6.76964 7.885 6.76964C7.07275 6.76964 6.39843 6.4901 5.82336 5.91527C5.24841 5.34044 4.96887 4.66601 4.96887 3.85351C4.96887 3.04125 5.24841 2.36682 5.82336 1.79187Z"
                                                fill="#00001B" />
                                            <path
                                                d="M14.629 12.309C14.6074 11.9972 14.5637 11.6571 14.4994 11.298C14.4344 10.9362 14.3508 10.5941 14.2507 10.2815C14.1472 9.95837 14.0067 9.63928 13.8327 9.33349C13.6524 9.01611 13.4405 8.73974 13.2027 8.51233C12.9541 8.27441 12.6496 8.08313 12.2976 7.9436C11.9468 7.80481 11.558 7.7345 11.1421 7.7345C10.9787 7.7345 10.8208 7.80151 10.5157 8.00012C10.328 8.12256 10.1084 8.26416 9.86327 8.42077C9.65367 8.55432 9.36974 8.67944 9.01903 8.79272C8.67687 8.90344 8.32945 8.95959 7.98644 8.95959C7.64366 8.95959 7.29625 8.90344 6.95385 8.79272C6.60351 8.67956 6.31945 8.55444 6.11022 8.4209C5.86742 8.26575 5.6477 8.12414 5.45715 8C5.15234 7.80139 4.99438 7.73438 4.83105 7.73438C4.41503 7.73438 4.02636 7.80481 3.67565 7.94373C3.32385 8.08301 3.01928 8.27429 2.77038 8.51245C2.53259 8.73999 2.32068 9.01623 2.1405 9.33349C1.9668 9.63928 1.82617 9.95825 1.72266 10.2816C1.62268 10.5942 1.53906 10.9362 1.47412 11.298C1.40967 11.6566 1.36609 11.9968 1.34448 12.3093C1.32324 12.6149 1.3125 12.9329 1.3125 13.2541C1.3125 14.0893 1.578 14.7655 2.10156 15.2641C2.61865 15.7562 3.30273 16.0057 4.13488 16.0057H11.839C12.6709 16.0057 13.355 15.7562 13.8722 15.2641C14.3958 14.7659 14.6614 14.0895 14.6614 13.254C14.6612 12.9316 14.6504 12.6136 14.629 12.309ZM13.2257 14.5848C12.884 14.91 12.4304 15.0681 11.8388 15.0681H4.13488C3.54321 15.0681 3.0896 14.91 2.74804 14.5849C2.41296 14.266 2.25012 13.8306 2.25012 13.2541C2.25012 12.9543 2.26001 12.6583 2.27978 12.3741C2.29907 12.0953 2.3385 11.7891 2.39697 11.4636C2.45471 11.1422 2.5282 10.8406 2.6156 10.5675C2.69946 10.3057 2.81384 10.0464 2.95569 9.79663C3.09106 9.55859 3.24682 9.35437 3.4187 9.18982C3.57946 9.03589 3.7821 8.90991 4.02087 8.81543C4.24169 8.72803 4.48986 8.68017 4.75927 8.67297C4.79211 8.69043 4.85058 8.72375 4.94531 8.78552C5.13805 8.91113 5.36022 9.05444 5.60583 9.2113C5.88268 9.38781 6.23937 9.54724 6.66552 9.68481C7.10119 9.82568 7.54552 9.89721 7.98656 9.89721C8.4276 9.89721 8.87206 9.82568 9.30748 9.68493C9.73399 9.54712 10.0906 9.38781 10.3678 9.21106C10.6191 9.05041 10.8351 8.91125 11.0278 8.78552C11.1225 8.72387 11.181 8.69043 11.2138 8.67297C11.4834 8.68017 11.7315 8.72803 11.9525 8.81543C12.1911 8.90991 12.3938 9.03601 12.5545 9.18982C12.7264 9.35424 12.8822 9.55847 13.0176 9.79675C13.1595 10.0464 13.274 10.3058 13.3578 10.5674C13.4453 10.8408 13.5189 11.1423 13.5765 11.4635C13.6349 11.7895 13.6744 12.0959 13.6937 12.3743V12.3745C13.7136 12.6576 13.7236 12.9535 13.7237 13.2541C13.7236 13.8307 13.5608 14.266 13.2257 14.5848Z"
                                                fill="#00001B" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_34_15948">
                                                <rect width="16" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    John Doe
                                </span>
                            </div>
                            <h2 class="td_post_title td_fs_24 td_medium td_mb_16">
                                <a href="blog/complete-guide-for-students-on-the-new-education-system.html">Complete
                                    Guide for Students on the New Education System</a>
                            </h2>
                            <p class="td_post_subtitle td_mb_24 td_heading_color td_opacity_7">Education is a dynamic
                                and evolving field that plays a crucial.</p>
                            <a href="blog/complete-guide-for-students-on-the-new-education-system.html"
                                class="td_btn td_style_1 td_type_3 td_radius_30 td_medium">
                                <span class="td_btn_in td_accent_color">
                                    <span>Read More</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Blog Section -->




    <!-- Start Footer Section -->
    <footer class="td_footer td_style_1">
        <div class="container">
            <div class="td_footer_row">
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <div class="td_footer_text_widget td_fs_18">
                            <img src="uploads/custom-images/secondary-logo.webp"
                                alt="Logo">
                            <p>It is a long established fact that a reader will be distracted by the readable content of
                                a page when looking at its layout the point of using lorem varius sit amet ipsum.</p>
                        </div>
                        <ul class="td_footer_address_widget td_medium td_mp_0">
    <li>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
            <path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.24.2 2.45.57 3.57a1 1 0 0 1-.25 1.02l-2.2 2.2z"/>
        </svg>
        <a href="tel:123-343-4444">123-343-4444</a>
    </li>
    <li>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
            <path d="M12 2C7.86 2 4.5 5.36 4.5 9.5c0 5.25 6.3 11.53 6.57 11.8a1.25 1.25 0 0 0 1.77 0c.26-.27 6.57-6.55 6.57-11.8C19.5 5.36 16.14 2 12 2zm0 10.25a2.75 2.75 0 1 1 0-5.5 2.75 2.75 0 0 1 0 5.5z"/>
        </svg>
        Los Angeles, CA, USA <br>Los Angeles, CA, USA
    </li>
</ul>
                    </div>
                </div>
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">Navigate</h2>
                        <ul class="td_footer_widget_menu">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ url('/about-us') }}">About Us</a></li>
                            <li><a href="contact-us.html">Contact</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="terms-conditions.html">Terms &amp; Conditions</a></li>
                            <li><a href="privacy-policy.html">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">Category</h2>
                        <ul class="td_footer_widget_menu">
                            <li><a href="coursesf88d.html?category=server-management">Server Management</a></li>
                            <li><a href="coursesb8ec.html?category=online-educations">Online Educations</a></li>
                            <li><a href="courses33fa.html?category=design-system">Design System</a></li>
                            <li><a href="courses0b61.html?category=blockchain-develop">Blockchain Develop</a></li>
                            <li><a href="courses4a40.html?category=photography-video">Photography &amp; Video</a></li>
                            <li><a href="coursesbd10.html?category=math-technology">Math &amp; Technology</a></li>
                        </ul>
                    </div>
                </div>
                <div class="td_footer_col">
                    <div class="td_footer_widget">
                        <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">Subscribe Now</h2>
                        <div class="td_newsletter td_style_1">
                            <p class="td_mb_20 td_opacity_7">Far far away, behind the word mountains, far from the
                                Consonantia.</p>
                            <form action="https://educve-laravel.themedox.com/store-newsletter" method="POST"
                                class="td_newsletter_form">
                                <input type="hidden" name="_token" value="VqO89dIZeDlcA4eRdpnkwW1ct9J7cXbs9lCJByJ6"
                                    autocomplete="off"> <input type="email" class="td_newsletter_input"
                                    placeholder="Email address" name="email">
                                <button type="submit" class="td_btn td_style_1 td_radius_30 td_medium">
                                    <span class="td_btn_in td_white_color td_accent_bg">
                                        <span>Subscribe</span>
                                    </span>
                                </button>
                            </form>
                        </div>
                        <div class="td_footer_social_btns td_fs_20">
    <a target="_blank" href="https://www.facebook.com/" class="td_center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
            <path d="M22 12.06C22 6.51 17.52 2 12 2S2 6.51 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.89h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94z"/>
        </svg>
    </a>
    <a target="_blank" href="https://www.twitter.com/" class="td_center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
        </svg>
    </a>
    <a target="_blank" href="https://www.instagram.com/" class="td_center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
            <path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.256 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 8.25a3.25 3.25 0 1 1 0-6.5 3.25 3.25 0 0 1 0 6.5zm5.25-8.6a1.13 1.13 0 1 0 0-2.26 1.13 1.13 0 0 0 0 2.26z"/>
        </svg>
    </a>
    <a target="_blank" href="https://www.linkedin.com/" class="td_center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.446-2.136 2.94v5.666H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 1 1 0-4.124 2.062 2.062 0 0 1 0 4.124zM7.114 20.452H3.56V9h3.554v11.452z"/>
        </svg>
    </a>
</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="td_footer_bottom td_fs_18">
            <div class="container">
                <div class="td_footer_bottom_in">
                    <p class="td_copyright mb-0">Copyright 2025, Educve All Rights Reserved.</p>
                    <ul class="td_footer_widget_menu">
                        <li><a href="terms-conditions.html"> Terms &amp; Conditions</a></li>
                        <li><a href="privacy-policy.html">Privacy &amp; Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer Section -->
    <!-- Start Scroll Up Button -->
    <div class="td_scrollup">
        <i class="fa-solid fa-arrow-up"></i>
    </div>
    <!-- End Scroll Up Button -->







    <!-- common-modal start  -->
    <div class="common-modal cookie_consent_modal d-none bg-white">
        <button type="button" class="btn-close cookie_consent_close_btn" aria-label="Close"></button>

        <h5>Cookies</h5>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
            industry&#039;s standard dummy text ever since the when an unknown printer took.</p>


        <a href="javascript:;"
            class="td_btn td_style_1 td_type_3 td_radius_30 td_medium td_fs_14 report-modal-btn cookie_consent_accept_btn">
            <span class="td_btn_in td_accent_color">
                <span>Accept</span>
            </span>
        </a>

    </div>
    <!-- common-modal end  -->


    <!-- Script -->
    <script src="global/js/jquery-3.7.1.min.js"></script>
    <script src="frontend/assets/js/jquery.slick.min.js"></script>
    <script src="frontend/assets/js/odometer.js"></script>
    <script src="frontend/assets/js/gsap.min.js"></script>
    <script src="frontend/assets/js/jquery-ui.min.js"></script>
    <script src="frontend/assets/js/wow.min.js"></script>
    <script src="frontend/assets/js/main.js"></script>


    <script src="global/toastr/toastr.min.js"></script>

    <script>
        (function ($) {
            "use strict"
            $(document).ready(function () {

                const session_notify_message = null;
                const demo_mode_message = null;

                if (session_notify_message != null) {
                    const session_notify_type = "info";
                    switch (session_notify_type) {
                        case 'info':
                            toastr.info(session_notify_message);
                            break;
                        case 'success':
                            toastr.success(session_notify_message);
                            break;
                        case 'warning':
                            toastr.warning(session_notify_message);
                            break;
                        case 'error':
                            toastr.error(session_notify_message);
                            break;
                    }
                }

                if (demo_mode_message != null) {
                    toastr.warning("All Language keywords are not implemented in the demo mode");
                    toastr.info("Admin can translate every word from the admin panel");
                }

                const validation_errors = [];

                if (validation_errors.length > 0) {
                    validation_errors.forEach(error => toastr.error(error));
                }

                if (localStorage.getItem('educve-cookie') != '1') {
                    $('.cookie_consent_modal').removeClass('d-none');
                }

                $('.cookie_consent_close_btn').on('click', function () {
                    $('.cookie_consent_modal').addClass('d-none');
                });

                $('.cookie_consent_accept_btn').on('click', function () {
                    localStorage.setItem('educve-cookie', '1');
                    $('.cookie_consent_modal').addClass('d-none');
                });

                $('.before_auth_wishlist').on("click", function () {
                    toastr.error("Please login first")
                });

                $(".currency_code").on('change', function () {
                    var currency_code = $(this).val();

                    window.location.href = "https://educve-laravel.themedox.com/currency-switcher" +
                        "?currency_code=" + currency_code;
                });

                $(".language_code").on('change', function () {
                    var language_code = $(this).val();

                    window.location.href = "https://educve-laravel.themedox.com/language-switcher" +
                        "?lang_code=" + language_code;
                });

            });
        })(jQuery);

    </script>


    <script>
        "use strict";
        $(function () {


            $(".add_to_cart").on("click", function (e) {

                let course_id = $(this).data('course_id');

                $.ajax({
                    type: 'GET',
                    url: "https://educve-laravel.themedox.com/add-to-card" + "/" + course_id,
                    success: function (response) {
                        toastr.success(response.message);

                        let total_cart = $('#total_cart').html();
                        total_cart = parseInt(total_cart) + parseInt(1);
                        $('#total_cart').html(total_cart);

                    },
                    error: function (err) {

                        if (err.status == 403) {
                            toastr.error(err.responseJSON.message)
                        } else {
                            toastr.error(`Server error occured`)
                        }

                    }
                });

            })

            $(".add_to_wishlist").on("click", function (e) {

                var app_mode = "DEMO"
                if (app_mode == 'DEMO') {
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }

                let course_id = $(this).data('course_id');
                let current_item = $(this);

                current_item.addClass('active');

                let _token = "VqO89dIZeDlcA4eRdpnkwW1ct9J7cXbs9lCJByJ6";

                $.ajax({
                    type: 'POST',
                    data: {
                        _token,
                        item_id: course_id
                    },
                    url: "https://educve-laravel.themedox.com/student/wishlist",
                    success: function (response) {
                        toastr.success(response.message);

                        if (response.type == 'added') {
                            current_item.addClass('active');

                            let total_wishlist = $('#total_wishlist').html();
                            total_wishlist = parseInt(total_wishlist) + parseInt(1);
                            $('#total_wishlist').html(total_wishlist);

                        } else if (response.type == 'removed') {
                            current_item.removeClass('active');

                            let total_wishlist = $('#total_wishlist').html();
                            total_wishlist = parseInt(total_wishlist) - parseInt(1);
                            $('#total_wishlist').html(total_wishlist);

                        }

                    },
                    error: function (err) {
                        current_item.removeClass('active');
                        if (err.status == 401) {
                            toastr.error(`Please login first`)
                        } else {
                            toastr.error(`Server error occured`)
                        }
                    }
                });

            })



        });

    </script>


</body>


<!-- Mirrored from educve-laravel.themedox.com/?theme=four by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Sep 2026 04:21:10 GMT -->

</html>
