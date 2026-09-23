<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ asset('uploads/website-images/favicon-2025-01-26-05-02-44-5347.png') }}" type="image/x-icon">

    <!-- Site Title -->
    <title>@yield('title', 'Educve - Complete eLearning Management System With Laravel')</title>
    <meta name="title" content="@yield('title', 'Educve - Complete eLearning Management System With Laravel')">
    <meta name="description" content="@yield('meta_description', 'Educve - Complete eLearning Management System With Laravel')">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/dev.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/cookie_consent.css') }}">
    <link rel="stylesheet" href="{{ asset('global/toastr/toastr.min.css') }}">

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
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script src="{{ asset('global/toastr/toastr.min.js') }}"></script>

    <!-- Common site script -->
    <script>
        (function ($) {
            "use strict";

            // Send the CSRF token with every AJAX request
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $(document).ready(function () {

                // Flash messages from Laravel: return back()->with('success', '...')
                @if (session('success'))
                    toastr.success(@json(session('success')));
                @endif
                @if (session('error'))
                    toastr.error(@json(session('error')));
                @endif
                @if (session('info'))
                    toastr.info(@json(session('info')));
                @endif

                // Validation errors
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        toastr.error(@json($error));
                    @endforeach
                @endif

                // Cookie consent
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

                // Currency / language switchers (point to YOUR routes)
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