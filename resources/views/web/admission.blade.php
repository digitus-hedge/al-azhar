@extends('web.layouts.app')

@section('title', 'Admission || Al Azhar Central School, Mala')
@section('meta_description', 'Admissions open at Al Azhar Central School, Mala for Preschool to Senior Secondary (CBSE), with hostel facilities. Send an online enquiry and our team will call you back.')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@section('content')

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('images/header.jpeg') }}"
    style="background-image: url('{{ asset('images/header.jpeg') }}');">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">Admission</h1>
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

    <!-- Start Admission Section -->
    <section>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">

            {{-- Section heading --}}
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s"
                data-wow-delay="0.2s">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    <i></i>
                    Admissions Open {{ $session }}
                    <i></i>
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">Begin Your Child's Journey With Us</h2>
                <div class="d-flex justify-content-center">
                    <p class="td_section_subtitle td_fs_18 mb-0 adm_intro">
                        Fill in the enquiry form below and our admission team will get in touch with you
                        on your phone or WhatsApp to guide you through the next steps.
                    </p>
                </div>
            </div>
            <div class="td_height_50 td_height_lg_40"></div>

            <div class="row">
                <div class="col-xxl-10 offset-xxl-1">
                    <div class="row td_gap_y_40">

                        {{-- ================= Enquiry form ================= --}}
                        <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                            <div class="contact_modal contact_modal_page adm_form_card" id="admission-form">
                                <div class="modal-content">
                                    <div class="modal-header adm_form_header">
                                        <div>
                                            <span class="adm_badge td_fs_14 td_semibold text-uppercase">Session {{ $session }}</span>
                                            <h5 class="modal-title">Admission Enquiry Form</h5>
                                            <p class="td_fs_14 mb-0 td_opacity_7 td_heading_color">
                                                Fields marked <span class="adm_req">*</span> are required
                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-body">

                                        @if (session('success'))
                                            <div class="adm_success" role="status">
                                                <span class="adm_success_icon td_center">
                                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2.4" stroke-linecap="round"
                                                        stroke-linejoin="round"><path d="M20 6 9 17l-5-5" /></svg>
                                                </span>
                                                <div>
                                                    <h6 class="td_fs_18 td_semibold mb-1">Enquiry received</h6>
                                                    <p class="mb-0">{{ session('success') }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="alert alert-danger contact_alert" role="alert">
                                                Please correct the highlighted fields and try again.
                                            </div>
                                        @endif

                                        <form class="contact_modal_form adm_form" action="{{ route('admission.store') }}"
                                            method="POST" novalidate>
                                            @csrf

                                            {{-- Honeypot (hidden from people, bots fill it) --}}
                                            <div class="contact_hp" aria-hidden="true">
                                                <label for="website">Website</label>
                                                <input type="text" id="website" name="website" tabindex="-1"
                                                    autocomplete="off">
                                            </div>

                                            {{-- Section: Student --}}
                                            <h6 class="adm_section_title">Student Details</h6>

                                            {{-- Student Name / Gender --}}
                                            <div class="contact_modal_form_item adm_align_start">
                                                <div class="contact_modal_form_inner">
                                                    <label class="adm_label" for="student_name">Student's Name <span class="adm_req">*</span></label>
                                                    <input type="text" id="student_name"
                                                        class="form-control @error('student_name') is-invalid @enderror"
                                                        placeholder="Enter student's full name" name="student_name"
                                                        value="{{ old('student_name') }}" maxlength="150"
                                                        autocomplete="off" required>
                                                    @error('student_name')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="contact_modal_form_inner">
                                                    <span class="adm_label" id="gender_label">Gender <span class="adm_req">*</span></span>
                                                    <div class="adm_choice adm_choice_3 @error('gender') is-invalid @enderror"
                                                        role="radiogroup" aria-labelledby="gender_label">
                                                        <label class="adm_choice_item">
                                                            <input type="radio" name="gender" value="male"
                                                                @checked(old('gender') === 'male') required>
                                                            <span>Male</span>
                                                        </label>
                                                        <label class="adm_choice_item">
                                                            <input type="radio" name="gender" value="female"
                                                                @checked(old('gender') === 'female')>
                                                            <span>Female</span>
                                                        </label>
                                                        <label class="adm_choice_item">
                                                            <input type="radio" name="gender" value="other"
                                                                @checked(old('gender') === 'other')>
                                                            <span>Other</span>
                                                        </label>
                                                    </div>
                                                    @error('gender')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Grade --}}
                                            <div class="contact_modal_form_item adm_align_start">
                                                <div class="contact_modal_form_inner">
                                                    <label class="adm_label" for="grade">Grade Seeking Admission Into <span class="adm_req">*</span></label>
                                                    <select id="grade" name="grade"
                                                        class="form-control adm_select @error('grade') is-invalid @enderror"
                                                        required>
                                                        <option value="" disabled @selected(!old('grade'))>Select a grade</option>
                                                        @foreach ($grades as $grade)
                                                            <option value="{{ $grade }}" @selected(old('grade') === $grade)>{{ $grade }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('grade')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="contact_modal_form_inner d-none d-lg-block"></div>
                                            </div>

                                            {{-- Section: Parent --}}
                                            <h6 class="adm_section_title adm_section_title_spaced">Parent / Guardian</h6>

                                            {{-- Parent Name / Phone --}}
                                            <div class="contact_modal_form_item">
                                                <div class="contact_modal_form_inner">
                                                    <label class="adm_label" for="parent_name">Parent's Name <span class="adm_req">*</span></label>
                                                    <input type="text" id="parent_name"
                                                        class="form-control @error('parent_name') is-invalid @enderror"
                                                        placeholder="Enter parent's full name" name="parent_name"
                                                        value="{{ old('parent_name') }}" maxlength="150"
                                                        autocomplete="name" required>
                                                    @error('parent_name')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="contact_modal_form_inner">
                                                    <label class="adm_label" for="parent_phone">Parent's Mobile / WhatsApp No <span class="adm_req">*</span></label>
                                                    <input type="tel" id="parent_phone"
                                                        class="form-control @error('parent_phone') is-invalid @enderror"
                                                        placeholder="e.g. 98765 43210" name="parent_phone"
                                                        value="{{ old('parent_phone') }}" maxlength="20"
                                                        inputmode="tel" autocomplete="tel" required>
                                                    @error('parent_phone')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Email --}}
                                            <div class="contact_modal_form_item">
                                                <div class="contact_modal_form_inner">
                                                    <label class="adm_label" for="parent_email">Parent's Email</label>
                                                    <input type="email" id="parent_email"
                                                        class="form-control @error('parent_email') is-invalid @enderror"
                                                        placeholder="e.g. name@example.com" name="parent_email"
                                                        value="{{ old('parent_email') }}" maxlength="191"
                                                        autocomplete="email">
                                                    @error('parent_email')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="contact_modal_form_inner d-none d-lg-block"></div>
                                            </div>

                                            {{-- Section: Location --}}
                                            <h6 class="adm_section_title adm_section_title_spaced">Location</h6>

                                            {{-- State / District --}}
                                            <div class="contact_modal_form_item">
                                                <div class="contact_modal_form_inner">
                                                    <label class="adm_label" for="state">State <span class="adm_req">*</span></label>
                                                    <input type="text" id="state"
                                                        class="form-control @error('state') is-invalid @enderror"
                                                        placeholder="e.g. Kerala" name="state"
                                                        value="{{ old('state') }}" maxlength="100"
                                                        autocomplete="address-level1" required>
                                                    @error('state')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="contact_modal_form_inner">
                                                    <label class="adm_label" for="district">District <span class="adm_req">*</span></label>
                                                    <input type="text" id="district"
                                                        class="form-control @error('district') is-invalid @enderror"
                                                        placeholder="e.g. Thrissur" name="district"
                                                        value="{{ old('district') }}" maxlength="100"
                                                        required>
                                                    @error('district')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- City --}}
                                            <div class="contact_modal_form_item">
                                                <div class="contact_modal_form_inner">
                                                    <label class="adm_label" for="city">City / Town / Village <span class="adm_req">*</span></label>
                                                    <input type="text" id="city"
                                                        class="form-control @error('city') is-invalid @enderror"
                                                        placeholder="e.g. Mala, Chalakudy" name="city"
                                                        value="{{ old('city') }}" maxlength="100"
                                                        autocomplete="address-level2" required>
                                                    @error('city')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="contact_modal_form_inner d-none d-lg-block"></div>
                                            </div>

                                            {{-- Section: Facilities --}}
                                            <h6 class="adm_section_title adm_section_title_spaced">Facilities Needed</h6>

                                            {{-- Hostel / Transportation --}}
                                            <div class="contact_modal_form_item adm_align_start">
                                                <div class="contact_modal_form_inner">
                                                    <span class="adm_label" id="hostel_label">Do you need Hostel facilities? <span class="adm_req">*</span></span>
                                                    <div class="adm_choice @error('needs_hostel') is-invalid @enderror"
                                                        role="radiogroup" aria-labelledby="hostel_label">
                                                        <label class="adm_choice_item">
                                                            <input type="radio" name="needs_hostel" value="1"
                                                                @checked(old('needs_hostel') === '1') required>
                                                            <span>Yes</span>
                                                        </label>
                                                        <label class="adm_choice_item">
                                                            <input type="radio" name="needs_hostel" value="0"
                                                                @checked(old('needs_hostel') === '0')>
                                                            <span>No</span>
                                                        </label>
                                                    </div>
                                                    @error('needs_hostel')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="contact_modal_form_inner">
                                                    <span class="adm_label" id="transport_label">Do you need Transportation? <span class="adm_req">*</span></span>
                                                    <div class="adm_choice @error('needs_transport') is-invalid @enderror"
                                                        role="radiogroup" aria-labelledby="transport_label">
                                                        <label class="adm_choice_item">
                                                            <input type="radio" name="needs_transport" value="1"
                                                                @checked(old('needs_transport') === '1') required>
                                                            <span>Yes</span>
                                                        </label>
                                                        <label class="adm_choice_item">
                                                            <input type="radio" name="needs_transport" value="0"
                                                                @checked(old('needs_transport') === '0')>
                                                            <span>No</span>
                                                        </label>
                                                    </div>
                                                    @error('needs_transport')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Message --}}
                                            <div class="contact_modal_form_item">
                                                <div class="contact_modal_form_inner">
                                                    <label class="adm_label" for="message">Message / Questions <span class="adm_optional">(optional)</span></label>
                                                    <textarea id="message"
                                                        class="form-control @error('message') is-invalid @enderror"
                                                        placeholder="Previous school, preferred time to call, or anything you'd like to ask"
                                                        rows="4" name="message" maxlength="2000">{{ old('message') }}</textarea>
                                                    @error('message')
                                                        <small class="contact_error">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="contact_modal_form_item adm_submit_row">
                                                <button type="submit"
                                                    class="td_btn td_style_1 td_radius_30 td_medium td_with_shadow contact_submit">
                                                    <span class="td_btn_in td_white_color td_accent_bg">
                                                        <span class="contact_submit_text">Submit Enquiry</span>
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
                                                <p class="td_fs_14 mb-0 td_opacity_7 td_heading_color adm_privacy">
                                                    Your details are used only to respond to this enquiry.
                                                </p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ================= Side info ================= --}}
                        <div class="col-xl-4 offset-xl-1 col-lg-5 wow fadeInRight" data-wow-duration="1s"
                            data-wow-delay="0.25s">
                            <div class="td_contact_info adm_side">

                                <div class="td_section_heading td_style_2 td_mb_30">
                                    <h2 class="td_contact_info_title td_fs_36 mb-0">Admission Process</h2>
                                </div>

                                <ol class="adm_steps td_mp_0 td_mb_40">
                                    @foreach ([
                                        ['Submit the enquiry', 'Fill in the form with the student and parent details.'],
                                        ['We call you back', 'Our admission team contacts you by phone or WhatsApp.'],
                                        ['Visit & interaction', 'Visit the campus and meet our teachers.'],
                                        ['Confirm admission', 'Complete the documents and fee formalities.'],
                                    ] as $i => [$title, $text])
                                        <li>
                                            <span class="adm_step_num td_center td_fs_18 td_semibold">{{ $i + 1 }}</span>
                                            <div>
                                                <h3 class="td_fs_20 td_semibold td_mb_4">{{ $title }}</h3>
                                                <p class="td_fs_16 mb-0 td_heading_color td_opacity_7">{{ $text }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ol>

                                {{-- TODO: replace with your real phone / email (same as Contact page) --}}
                                <div class="adm_help td_accent_bg td_radius_10">
                                    <p class="td_fs_14 td_white_color td_opacity_8 td_mb_4 text-uppercase td_spacing_1">Need help?</p>
                                    <h3 class="td_fs_24 td_semibold td_white_color td_mb_20">Talk to our Admission Office</h3>
                                    <ul class="adm_help_list td_mp_0">
                                        <li>
                                            <span class="adm_help_icon td_center">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg>
                                            </span>
                                            <a href="tel:99884567809" class="td_white_color">99884567809</a>
                                        </li>
                                        <li>
                                            <span class="adm_help_icon td_center">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
                                            </span>
                                            <a href="mailto:al-azhar@gmail.com" class="td_white_color">al-azhar@gmail.com</a>
                                        </li>
                                        <li>
                                            <span class="adm_help_icon td_center">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                            </span>
                                            <span>Mon – Sat, 9:00 AM – 4:00 PM</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Admission Section -->

@endsection

@push('styles')
<style>
    /* ======== Shared with Contact page ======== */
    .contact_hp { position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden; }
    .contact_error { display: block; margin-top: 6px; color: #dc3545; font-size: 13px; font-weight: 500; }
    .contact_modal_form .form-control.is-invalid { border-color: #dc3545 !important; }
    .contact_alert { border-radius: 12px; margin: 20px 0 0; }
    .contact_submit[disabled] { opacity: .7; pointer-events: none; }

    /* ======== Admission page ======== */
    .adm_intro { max-width: 720px; }

    /* ---- Form card ---- */
    .adm_form_card .modal-content {
        padding: 40px 42px 44px !important;
        border-radius: 20px !important;
        background: #fff !important;
        box-shadow: 0 25px 60px -30px rgba(0, 47, 95, .25), 0 10px 30px -20px rgba(0, 0, 27, .08) !important;
        border: 1px solid #eef1f6 !important;
    }

    /* ---- Header ---- */
    .adm_form_header {
        flex-direction: column; align-items: flex-start;
        padding: 0 !important; border: 0 !important;
        margin-bottom: 30px;
    }
    .adm_form_header .modal-title {
        margin: 14px 0 6px;
        font-size: 26px; font-weight: 700;
        color: var(--heading-color, #00539B);
    }
    .adm_badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 30px;
        background: linear-gradient(135deg, var(--accent-color, #00539B), #002F5F);
        color: #fff;
        letter-spacing: 1.2px;
        font-size: 12px;
        box-shadow: 0 8px 20px -10px rgba(0, 47, 95, .5);
    }
    .adm_req { color: #dc3545; margin-left: 2px; }
    .adm_optional { font-weight: 400; opacity: .55; font-size: 13px; }

    /* ---- Labels ---- */
    .adm_label {
        display: block;
        margin-bottom: 10px;
        color: #2d3545;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: .2px;
    }

    /* ---- Section titles ---- */
    .adm_section_title {
        display: flex; align-items: center; gap: 12px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--accent-color, #00539B);
        margin: 0 0 22px;
    }
    .adm_section_title::after {
        content: "";
        flex: 1; height: 1px;
        background: linear-gradient(to right, rgba(0, 83, 155, .25), transparent);
    }
    .adm_section_title_spaced { margin-top: 32px; }

    /* ---- Inputs ---- */
    .adm_form .contact_modal_form_item.adm_align_start { align-items: flex-start; }

    .contact_modal .modal-body .form-control {
        padding: 14px 18px !important;
        font-size: 15px !important;
        color: #2d3545 !important;
        background-color: #f7f9fc !important;
        border: 1.5px solid #e6eaf2 !important;
        border-radius: 12px !important;
        transition: all .25s ease !important;
        box-shadow: none !important;
    }
    .contact_modal .modal-body .form-control::placeholder { color: #9aa3b5 !important; }
    .contact_modal .modal-body .form-control:focus {
        background-color: #fff !important;
        border-color: var(--accent-color, #00539B) !important;
        box-shadow: 0 0 0 4px rgba(0, 83, 155, .1) !important;
    }
    .adm_form textarea.form-control { resize: vertical; min-height: 110px; }

    /* ---- Select ---- */
    .contact_modal .modal-body select.adm_select {
        -webkit-appearance: none; -moz-appearance: none; appearance: none;
        cursor: pointer;
        padding-right: 48px !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2300539B' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 18px center !important;
        background-size: 14px !important;
    }
    .contact_modal .modal-body select.adm_select:invalid { color: #9aa3b5 !important; }
    .contact_modal .modal-body select.adm_select option { color: #2d3545; }

    /* ---- Choice pills (Yes/No, Gender) ---- */
    .adm_choice { display: flex; gap: 10px; flex-wrap: wrap; }
    .adm_choice_item { position: relative; margin: 0; flex: 1 1 0; min-width: 100px; }
    .adm_choice_3 .adm_choice_item { min-width: 80px; }
    .adm_choice_item input {
        position: absolute; opacity: 0; width: 100%; height: 100%; left: 0; top: 0; margin: 0; cursor: pointer;
    }
    .adm_choice_item span {
        display: flex; align-items: center; justify-content: center;
        height: 52px;
        padding: 0 18px;
        border-radius: 12px;
        background-color: #f7f9fc;
        border: 1.5px solid #e6eaf2;
        color: #2d3545;
        font-weight: 600;
        font-size: 14.5px;
        transition: all .25s ease;
    }
    .adm_choice_item:hover span { border-color: rgba(0, 83, 155, .35); background-color: #fff; }
    .adm_choice_item input:checked + span {
        background: linear-gradient(135deg, var(--accent-color, #00539B), #002F5F);
        border-color: var(--accent-color, #00539B);
        color: #fff;
        box-shadow: 0 10px 22px -10px rgba(0, 47, 95, .5);
    }
    .adm_choice_item input:focus-visible + span { outline: 2px solid var(--heading-color); outline-offset: 2px; }
    .adm_choice.is-invalid .adm_choice_item span { border-color: #dc3545; }

    /* ---- Submit row ---- */
    .adm_submit_row {
        flex-wrap: wrap;
        justify-content: flex-start !important;
        gap: 14px 24px !important;
        margin-top: 10px !important;
        padding-top: 24px;
        border-top: 1px solid #eef1f6;
    }
    .adm_privacy { flex: 1 1 200px; font-size: 13px; }

    /* ---- Success box ---- */
    .adm_success {
        display: flex; gap: 15px; align-items: flex-start;
        margin-bottom: 24px;
        padding: 18px 20px;
        border-radius: 12px;
        background-color: #e6f7ee;
        border-left: 4px solid #198754;
        color: #0f5132;
    }
    .adm_success h6 { color: #198754; }
    .adm_success_icon {
        width: 36px; height: 36px; flex: none;
        border-radius: 50%;
        background-color: #198754;
        color: #fff;
    }

    /* ---- Steps ---- */
    .adm_steps { list-style: none; position: relative; }
    .adm_steps li { display: flex; gap: 18px; position: relative; }
    .adm_steps li:not(:last-child) { padding-bottom: 28px; }
    .adm_steps li:not(:last-child)::before {
        content: "";
        position: absolute;
        left: 22px; top: 48px; bottom: 4px;
        border-left: 2px dashed var(--border-color);
    }
    .adm_step_num {
        width: 46px; height: 46px; flex: none;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent-color), #002F5F);
        color: #fff;
        box-shadow: 0 0 0 6px rgba(0, 47, 95, 0.1);
    }
    .adm_steps h3 { margin-top: 8px; }

    /* ---- Help card ---- */
    .adm_help { padding: 30px; margin-top: 30px; }
    .adm_help_list li { display: flex; align-items: center; gap: 12px; color: #fff; word-break: break-word; }
    .adm_help_list li:not(:last-child) { margin-bottom: 14px; }
    .adm_help_list a:hover { color: rgba(255, 255, 255, 0.75); }
    .adm_help_icon {
        width: 38px; height: 38px; flex: none;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.15);
    }

    /* ======== Responsive ======== */
    @media (max-width: 1199px) {
        .contact_modal .modal-body .contact_modal_form_item { gap: 20px; }
    }
    @media (max-width: 991px) {
        .adm_side { max-width: 640px; }
    }
    @media (max-width: 767px) {
        .adm_form_card .modal-content { padding: 30px 24px 32px !important; }
        .contact_modal .modal-body .contact_modal_form_item { gap: 18px; margin-top: 18px; align-items: stretch; }
        .adm_choice_item span { height: 50px; }
        .adm_submit_row { align-items: stretch !important; }
        .adm_submit_row .td_btn { width: 100%; }
        .adm_privacy { text-align: center; }
        .adm_help { padding: 25px 20px; }
        .adm_section_title_spaced { margin-top: 24px; }
    }
    @media (max-width: 420px) {
        .adm_form_card .modal-content { padding: 24px 18px 28px !important; }
        .adm_steps li { gap: 14px; }
        .adm_choice { gap: 8px; }
        .adm_choice_3 .adm_choice_item span { padding: 0 10px; font-size: 13.5px; }
    }
</style>
@endpush

@push('scripts')
<script>
    $(function () {
        // Prevent double submits and show progress
        $('.adm_form').on('submit', function () {
            var $btn = $(this).find('.contact_submit');
            $btn.prop('disabled', true).find('.contact_submit_text').text('Submitting...');
        });

        // Phone: allow only digits, spaces, +, -, ( )
        $('#parent_phone').on('input', function () {
            this.value = this.value.replace(/[^0-9+\-\s()]/g, '');
        });

        // Scroll to the form after submit (success or errors)
        @if (session('success') || $errors->any())
            var $form = $('#admission-form');
            if ($form.length) {
                $('html, body').animate({ scrollTop: $form.offset().top - 140 }, 400);
            }
        @endif
    });
</script>
@endpush