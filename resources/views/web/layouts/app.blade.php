<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>document.documentElement.classList.add('js-anim');</script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon (browser tab icon) - school logo -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo1.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/logo1.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo1.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/logo1.png') }}">
    <link rel="preload" as="image" href="{{ asset('images/header.jpeg') }}">
    <meta name="theme-color" content="#00539B">

    <!-- Site Title -->
    <title>@yield('title', 'Al Azhar Central School, Mala')</title>
    <meta name="title" content="@yield('title', 'Al Azhar Central School, Mala')">
    <meta name="description" content="@yield('meta_description', 'Al Azhar Central School, Mala - a CBSE school offering education from Preschool to Senior Secondary, with hostel facilities.')">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Al Azhar Central School, Mala">
    <meta property="og:title" content="@yield('title', 'Al Azhar Central School, Mala')">
    <meta property="og:description" content="@yield('meta_description', 'Al Azhar Central School, Mala - a CBSE school offering education from Preschool to Senior Secondary, with hostel facilities.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/logo1.png'))">
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/cookie_consent.css') }}">
    <link rel="stylesheet" href="{{ asset('global/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/dev.css') }}">

    <style>
        /* Hide animated elements until WOW reveals them (stops the flash on load) */
        .js-anim .wow { visibility: hidden; }

        /* Wider container on large screens */
        @media (min-width: 1400px) { .container { max-width: 1440px; padding-left: 30px; padding-right: 30px; } }
        @media (min-width: 1600px) { .container { max-width: 1560px; } }
        @media (min-width: 1800px) { .container { max-width: 1680px; } }

        /* Stop side slides from causing a horizontal scrollbar */
        section { overflow-x: clip; }

        /* Shorter, softer entrance animations */
        @keyframes fadeInLeft  { from { opacity: 0; transform: translate3d(-60px,0,0); } to { opacity: 1; transform: none; } }
        @keyframes fadeInRight { from { opacity: 0; transform: translate3d(60px,0,0); }  to { opacity: 1; transform: none; } }
        @keyframes fadeInUp    { from { opacity: 0; transform: translate3d(0,50px,0); }  to { opacity: 1; transform: none; } }
        @keyframes fadeInDown  { from { opacity: 0; transform: translate3d(0,-40px,0); } to { opacity: 1; transform: none; } }
        @keyframes zoomIn      { from { opacity: 0; transform: scale(.85); }             to { opacity: 1; transform: none; } }

        /* Let hover lifts work after the entrance animation */
        .home_gal_tile.animated, .gal_tile.animated, .home_ev_card.animated,
        .home_nn_item.animated, .nn_item.animated, .nn_hcard.animated { animation-fill-mode: backwards; }
    </style>

    {{-- Page-specific CSS goes here via @push('styles') --}}
    @stack('styles')
</head>

<body class="@yield('body_class')">

    @include('web.layouts.header')

    {{-- Page content --}}
    @yield('content')

    {{-- Pages can pick a footer style with @section('footer_class', 'td_color_1') --}}
    @include('web.layouts.footer', ['footerClass' => trim($__env->yieldContent('footer_class'))])

    <!-- Start Scroll Up Button -->
    <div class="td_scrollup">
        <i class="fa-solid fa-arrow-up"></i>
    </div>
    <!-- End Scroll Up Button -->

    <!-- Cookie consent modal -->
    <div class="common-modal cookie_consent_modal d-none bg-white">
        <button type="button" class="btn-close cookie_consent_close_btn" aria-label="Close"></button>
        <h5>Cookies</h5>
        <p>We use cookies to improve your experience on our website. By continuing to browse, you agree to our use of cookies.</p>
        <a href="javascript:;" class="td_btn td_style_1 td_type_3 td_radius_30 td_medium td_fs_14 report-modal-btn cookie_consent_accept_btn">
            <span class="td_btn_in td_accent_color">
                <span>Accept</span>
            </span>
        </a>
    </div>

    <!-- Scripts: jQuery MUST be first -->
    <script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.slick.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/odometer.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>

    {{-- Allow WOW to start only ONCE (main.js or anything else calling init again is ignored) --}}
    <script>
        (function () {
            if (!window.WOW) return;
            var originalInit = WOW.prototype.init;
            WOW.prototype.init = function () {
                if (window.__wowStarted) return this;
                window.__wowStarted = true;
                return originalInit.apply(this, arguments);
            };
        })();
    </script>

    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script src="{{ asset('global/toastr/toastr.min.js') }}"></script>

    {{-- Start WOW if main.js didn't (does nothing if it already did) --}}
    <script>
        if (window.WOW) {
            new WOW({ boxClass: 'wow', animateClass: 'animated', offset: 80, mobile: true, live: true }).init();
        } else {
            document.documentElement.classList.remove('js-anim');   // no WOW: show everything normally
        }
    </script>

    <!-- Common site script -->
    <script>
        (function ($) {
            "use strict";

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $(document).ready(function () {
                @if (session('success'))
                    toastr.success(@json(session('success')));
                @endif
                @if (session('error'))
                    toastr.error(@json(session('error')));
                @endif
                @if (session('info'))
                    toastr.info(@json(session('info')));
                @endif

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        toastr.error(@json($error));
                    @endforeach
                @endif

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

                $('.before_auth_wishlist').on('click', function () {
                    toastr.error('Please login first');
                });

                $('.currency_code').on('change', function () {
                    window.location.href = "{{ url('currency-switcher') }}?currency_code=" + $(this).val();
                });
                $('.language_code').on('change', function () {
                    window.location.href = "{{ url('language-switcher') }}?lang_code=" + $(this).val();
                });
            });
        })(jQuery);
    </script>

    {{-- Page-specific scripts go here via @push('scripts') --}}
    @stack('scripts')
</body>

</html>