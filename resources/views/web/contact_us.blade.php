@extends('web.layouts.app')

@section('title', 'Contact Us || AL-Azhar')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@php
    $ctMapQuery = 'Al Azhar Central School, Kunnathukad, Paranatukunnu, Mala, Kerala 680732';
@endphp

@section('content')

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('images/header.jpeg') }}"
    style="background-image: url('{{ asset('images/header.jpeg') }}');">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10 wow fadeInDown" data-wow-duration="0.9s" data-wow-delay="0.2s">Contact Us</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.4s">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Contact Us</li>
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

    <!-- Start Contact Section -->
    <section>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">
            <div class="row">
                <div class="col-xxl-10 offset-xxl-1">
                    <div class="row align-items-center td_gap_y_40">
                        <div class="col-lg-7 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                            <div class="contact_modal contact_modal_page">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Get In Touch</h5>
                                    </div>
                                    <div class="modal-body">

                                        @if (session('success'))
                                            <div class="alert alert-success contact_alert" role="alert">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        <form class="contact_modal_form" action="{{ route('contact.store') }}"
                                            method="POST" novalidate>
                                            @csrf

                                            {{-- Honeypot (hidden from people, bots fill it) --}}
                                            <div class="contact_hp" aria-hidden="true">
                                                <label for="website">Website</label>
                                                <input type="text" id="website" name="website" tabindex="-1"
                                                    autocomplete="off">
                                            </div>

                                            <div class="contact_modal_form_item wow fadeInUp" data-wow-delay="0.4s">
                                                <div class="contact_modal_form_inner">
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        placeholder="Full Name *" name="name"
                                                        value="{{ old('name') }}" maxlength="150" required>
                                                    @error('name')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="contact_modal_form_inner">
                                                    <input type="tel"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        placeholder="Phone" name="phone" value="{{ old('phone') }}"
                                                        maxlength="20">
                                                    @error('phone')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="contact_modal_form_item wow fadeInUp" data-wow-delay="0.5s">
                                                <div class="contact_modal_form_inner">
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        placeholder="Email *" name="email" value="{{ old('email') }}"
                                                        maxlength="191" required>
                                                    @error('email')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="contact_modal_form_inner">
                                                    <input type="text"
                                                        class="form-control @error('subject') is-invalid @enderror"
                                                        placeholder="Subject *" name="subject"
                                                        value="{{ old('subject') }}" maxlength="191" required>
                                                    @error('subject')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="contact_modal_form_item wow fadeInUp" data-wow-delay="0.6s">
                                                <div class="contact_modal_form_inner">
                                                    <textarea class="form-control @error('message') is-invalid @enderror"
                                                        placeholder="Message *" rows="5" name="message" maxlength="5000"
                                                        required>{{ old('message') }}</textarea>
                                                    @error('message')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="contact_modal_form_item wow zoomIn" data-wow-delay="0.7s">
                                                <button type="submit"
                                                    class="td_btn td_style_1 td_radius_30 td_medium td_with_shadow contact_submit">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span class="contact_submit_text">Send Message</span>
                                                        <svg width="19" height="20" viewBox="0 0 19 20" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M15.1575 4.34302L3.84375 15.6567"
                                                                stroke="currentColor" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path
                                                                d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                                                                stroke="currentColor" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
                            <div class="ct_info">
                                <h2 class="ct_title wow fadeInDown" data-wow-delay="0.35s">Contact Info</h2>
                                <p class="ct_intro wow fadeInUp" data-wow-delay="0.45s">
                                    AL AZHAR CENTRAL SCHOOL is affiliated to the Central Board of Secondary Education
                                    (CBSE, Affiliation No. 930609) New Delhi. It is a Boarding school imparting holistic
                                    education from Pre-KG to XIIth Grades.
                                </p>

                                <div class="ct_grid">
                                    {{-- Location --}}
                                    <div class="ct_item wow fadeInUp" data-wow-delay="0.5s">
                                        <div class="ct_head">
                                            <span class="ct_icon">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg>
                                            </span>
                                            <h3>Location</h3>
                                        </div>
                                        <a href="https://maps.google.com/?q={{ urlencode($ctMapQuery) }}" target="_blank" rel="noopener">
                                            Kunnathukad, Paranatukunnu, P.O, Mala, Kerala 680732
                                        </a>
                                    </div>

                                    {{-- Email --}}
                                    <div class="ct_item wow fadeInUp" data-wow-delay="0.6s">
                                        <div class="ct_head">
                                            <span class="ct_icon">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4.2-8 5-8-5V6l8 5 8-5v2.2z"/></svg>
                                            </span>
                                            <h3>Email</h3>
                                        </div>
                                        <a href="mailto:alazharmala@gmail.com">alazharmala@gmail.com</a>
                                        <a href="mailto:alazharschool@yahoo.com">alazharschool@yahoo.com</a>
                                    </div>

                                    {{-- Phone --}}
                                    <div class="ct_item wow fadeInUp" data-wow-delay="0.7s">
                                        <div class="ct_head">
                                            <span class="ct_icon">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1l-2.2 2.23z"/></svg>
                                            </span>
                                            <h3>Phone</h3>
                                        </div>
                                        <a href="tel:+918943337011">Mob: 894 333 7011</a>
                                        <span class="ct_phones">
                                            <a href="tel:+914802897605">+91 480 289 7605</a>,
                                            <a href="tel:+914802897505">+91 480 289 7505</a>
                                        </span>
                                    </div>

                                    {{-- Website --}}
                                    <div class="ct_item wow fadeInUp" data-wow-delay="0.8s">
                                        <div class="ct_head">
                                            <span class="ct_icon">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/></svg>
                                            </span>
                                            <h3>Website</h3>
                                        </div>
                                        <a href="https://alazharmala.com" target="_blank" rel="noopener">alazharmala.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="td_map wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
            <iframe id="map" title="School location"
                src="https://maps.google.com/maps?q={{ urlencode($ctMapQuery) }}&output=embed"
                loading="lazy" allowfullscreen=""></iframe>
        </div>
    </section>
    <!-- End Contact Section -->

@endsection

@push('styles')
<style>
    .contact_hp { position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden; }
    .contact_error { display: block; margin-top: 6px; color: #dc3545; font-size: 14px; }
    .contact_modal_form .form-control.is-invalid { border-color: #dc3545; }
    .contact_alert { border-radius: 10px; margin-bottom: 20px; }
    .contact_submit[disabled] { opacity: .7; pointer-events: none; }

    /* Breadcrumb separator (same as other pages) */
    .td_page_heading .breadcrumb-item + .breadcrumb-item::before { content: "/" !important; color: #fff; padding: 0 8px; }

    /* ---------- Contact Info ---------- */
    .ct_info { --ct: var(--heading-color, #00539B); }
    .ct_title { margin: 0 0 18px; font-size: 44px; font-weight: 700; color: var(--ct); line-height: 1.15; }
    .ct_intro { margin: 0 0 40px; font-size: 16px; line-height: 1.75; color: #6b7489; }

    .ct_grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px 30px; }
    .ct_item { display: flex; flex-direction: column; gap: 4px; min-width: 0; }
    .ct_item.animated { animation-fill-mode: backwards; }
    .ct_head { display: flex; align-items: center; gap: 16px; margin-bottom: 14px; }
    .ct_icon {
        width: 40px; height: 40px; flex: none; border-radius: 4px;
        display: flex; align-items: center; justify-content: center;
        background: var(--ct); color: #fff; transition: transform .3s ease, border-radius .3s ease;
    }
    .ct_item:hover .ct_icon { transform: rotate(-8deg) scale(1.06); border-radius: 10px; }
    .ct_head h3 { margin: 0; font-size: 21px; font-weight: 600; color: var(--heading-color, #0d1b4c); }
    .ct_item a, .ct_phones { font-size: 16px; line-height: 1.6; color: var(--ct); word-break: break-word; }
    .ct_item a:hover { color: #002F5F; text-decoration: underline; }

    @media (max-width: 1199px) { .ct_title { font-size: 38px; } }
    @media (max-width: 575px) {
        .ct_title { font-size: 32px; }
        .ct_grid { grid-template-columns: 1fr; gap: 28px; }
    }
</style>
@endpush

@push('scripts')
<script>
    $(function () {
        // Stop double-submits and show progress
        $('.contact_modal_form').on('submit', function () {
            var $btn = $(this).find('.contact_submit');
            $btn.prop('disabled', true).find('.contact_submit_text').text('Sending...');
        });

        // Scroll to the form after submit (success or errors)
        @if (session('success') || $errors->any())
            var $form = $('.contact_modal_form');
            if ($form.length) {
                $('html, body').animate({ scrollTop: $form.offset().top - 180 }, 400);
            }
        @endif
    });
</script>
@endpush