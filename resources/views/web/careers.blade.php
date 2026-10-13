@extends('web.layouts.app')

@section('title', 'Careers || Al Azhar Central School, Mala')
@section('meta_description', 'Join the Al Azhar Central School family. Explore current career openings for teachers, administrators, and support staff at our Mala campus.')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@php
    $careers = $careers ?? collect();

    // Default icons rotated across the cards for visual variety
    $cardIcons = [
        '<path d="M12 3 1 8l11 5 11-5-11-5z"/><path d="M5 10.5V16c0 1.5 3 3 7 3s7-1.5 7-3v-5.5"/>',
        '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
        '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
        '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
        '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>',
    ];
@endphp

@section('content')

<!-- Start Page Heading Section -->
<section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('images/header.jpeg') }}"
    style="background-image: url('{{ asset('images/header.jpeg') }}');">
    <div class="container">
        <div class="td_page_heading_in">
            <h1 class="td_white_color td_fs_48 td_mb_10 wow fadeInDown" data-wow-duration="0.9s" data-wow-delay="0.2s">Careers</h1>
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

<!-- Start Intro Section -->
<section class="crr_intro">
    <div class="td_height_100 td_height_lg_75"></div>
    <div class="container">
        <div class="row align-items-center td_gap_y_40">
            {{-- Left: Content --}}
            <div class="col-lg-7 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase crr_accent">
                    Join Our Team
                </p>
                <h2 class="td_section_title td_fs_48 td_mb_20">Build a Rewarding Career With Us</h2>
                <p class="td_fs_18 td_mb_20" style="line-height:1.75;color:#5b6477;">
                    At Al Azhar Central School, we believe great education begins with great educators. We are always looking for passionate teachers, dedicated staff, and inspiring leaders who want to make a lasting difference in the lives of young learners.
                </p>
                <p class="td_fs_18 mb-0" style="line-height:1.75;color:#5b6477;">
                    If you share our commitment to excellence, values, and student-centred learning — we'd love to hear from you.
                </p>
            </div>

            {{-- Right: Stats badges --}}
            <div class="col-lg-5 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
                <div class="crr_stats">
                    <div class="crr_stat">
                        <span class="crr_stat_icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </span>
                        <div>
                            <strong>{{ $careers->count() }}</strong>
                            <small>Open Positions</small>
                        </div>
                    </div>
                    <div class="crr_stat">
                        <span class="crr_stat_icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 3 1 8l11 5 11-5-11-5z"/><path d="M5 10.5V16c0 1.5 3 3 7 3s7-1.5 7-3v-5.5"/>
                            </svg>
                        </span>
                        <div>
                            <strong>25+</strong>
                            <small>Years of Excellence</small>
                        </div>
                    </div>
                    <div class="crr_stat">
                        <span class="crr_stat_icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2l2.4 1.8 3-.2.9 2.9 2.5 1.7-1 2.8 1 2.8-2.5 1.7-.9 2.9-3-.2L12 22l-2.4-1.8-3 .2-.9-2.9-2.5-1.7 1-2.8-1-2.8 2.5-1.7.9-2.9 3 .2L12 2z"/>
                            </svg>
                        </span>
                        <div>
                            <strong>CBSE</strong>
                            <small>Affiliated School</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="td_height_100 td_height_lg_75"></div>
</section>
<!-- End Intro Section -->

<!-- Start Openings Section -->
<section class="crr_openings">
    <div class="container">
        <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
            <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase crr_accent">
                <i></i> Current Openings <i></i>
            </p>
            <h2 class="td_section_title td_fs_48 mb-0">Available Positions</h2>
            <p class="td_fs_18 mb-0 mt-3" style="max-width:720px;margin:0 auto;color:#6b7489;">
                Click any position to view the full details and apply.
            </p>
        </div>
        <div class="td_height_50 td_height_lg_40"></div>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="crr_flash crr_flash_success" id="crrFlash">
                <span class="crr_flash_icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </span>
                <div class="crr_flash_msg">{{ session('success') }}</div>
                <button type="button" class="crr_flash_close" aria-label="Dismiss" onclick="this.parentNode.remove()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
                        <path d="M18 6 6 18M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="crr_flash crr_flash_error">
                <span class="crr_flash_icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/>
                    </svg>
                </span>
                <div class="crr_flash_msg">
                    <strong>Please correct the following:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if ($careers->isNotEmpty())
            <div class="crr_grid">
                @foreach ($careers as $i => $career)
                    @php
                        $icon = $cardIcons[$i % count($cardIcons)];
                        $animClass = ['fadeInLeft', 'fadeInUp', 'fadeInRight'][$i % 3];
                        $hasDetails = !empty(trim(strip_tags((string) $career->description)));
                        $panelId = 'crrPanel_' . $career->id;
                        $formId = 'crrForm_' . $career->id;
                        $isOpen = old('career_id') == $career->id || request('career') == $career->id;
                    @endphp
                    <article
                        id="career-{{ $career->id }}"
                        class="crr_item wow {{ $animClass }} {{ $isOpen ? 'is-open' : '' }}"
                        data-wow-duration="0.9s"
                        data-wow-delay="{{ 0.2 + ($i % 3) * 0.1 }}s">

                        {{-- Preview / Header (click to expand) --}}
                        <button type="button" class="crr_item_head" aria-expanded="{{ $isOpen ? 'true' : 'false' }}" aria-controls="{{ $panelId }}">
                            <div class="crr_item_head_main">
                                <span class="crr_card_icon">
                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        {!! $icon !!}
                                    </svg>
                                </span>
                                <div class="crr_item_titleblock">
                                    <h3 class="crr_card_title">{{ $career->title }}</h3>
                                    <p class="crr_card_preview">
                                        {{ \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $career->description))), 140) }}
                                    </p>
                                </div>
                            </div>
                            <div class="crr_item_head_side">
                                <span class="crr_card_badge">Hiring</span>
                                <span class="crr_item_chev" aria-hidden="true">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"/>
                                    </svg>
                                </span>
                            </div>
                        </button>

                        {{-- Expandable panel --}}
                        <div class="crr_item_panel" id="{{ $panelId }}">
                            <div class="crr_item_panel_inner">
                                @if ($hasDetails)
                                    <div class="crr_item_details">
                                        {!! $career->description !!}
                                    </div>
                                @else
                                    <p class="crr_item_details"><em>No detailed description provided. Click Apply Now to submit your application for this role.</em></p>
                                @endif

                                <div class="crr_item_actions">
                                    <button type="button" class="crr_apply_btn" data-apply-toggle>
                                        <span>Apply Now</span>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>

                                {{-- Application Form --}}
                                <div class="crr_apply_form_wrap {{ (old('career_id') == $career->id && $errors->any()) ? 'is-open' : '' }}">
                                    <form
                                        id="{{ $formId }}"
                                        action="{{ route('careers.apply') }}"
                                        method="POST"
                                        enctype="multipart/form-data"
                                        class="crr_apply_form"
                                        novalidate>
                                        @csrf
                                        <input type="hidden" name="career_id" value="{{ $career->id }}">
                                        <input type="hidden" name="apply_for" value="{{ $career->title }}">

                                        <div class="crr_form_grid">
                                            <div class="crr_field">
                                                <label for="name_{{ $career->id }}">Full Name <span>*</span></label>
                                                <input
                                                    id="name_{{ $career->id }}"
                                                    type="text"
                                                    name="name"
                                                    value="{{ old('career_id') == $career->id ? old('name') : '' }}"
                                                    maxlength="150"
                                                    required
                                                    placeholder="Your full name">
                                            </div>

                                            <div class="crr_field">
                                                <label for="email_{{ $career->id }}">Email Address <span>*</span></label>
                                                <input
                                                    id="email_{{ $career->id }}"
                                                    type="email"
                                                    name="email"
                                                    value="{{ old('career_id') == $career->id ? old('email') : '' }}"
                                                    maxlength="150"
                                                    required
                                                    placeholder="you@example.com">
                                            </div>

                                            <div class="crr_field">
                                                <label for="phone_{{ $career->id }}">Phone <span>*</span></label>
                                                <input
                                                    id="phone_{{ $career->id }}"
                                                    type="tel"
                                                    name="phone"
                                                    value="{{ old('career_id') == $career->id ? old('phone') : '' }}"
                                                    maxlength="20"
                                                    required
                                                    placeholder="+91 ..."
                                                    pattern="[0-9+\-\s()]{7,20}">
                                            </div>

                                            <div class="crr_field">
                                                <label for="nationality_{{ $career->id }}">Nationality</label>
                                                <input
                                                    id="nationality_{{ $career->id }}"
                                                    type="text"
                                                    name="nationality"
                                                    value="{{ old('career_id') == $career->id ? old('nationality') : '' }}"
                                                    maxlength="100"
                                                    placeholder="e.g. Indian">
                                            </div>

                                            <div class="crr_field crr_field_full">
                                                <label for="apply_for_display_{{ $career->id }}">Applying For</label>
                                                <input
                                                    id="apply_for_display_{{ $career->id }}"
                                                    type="text"
                                                    value="{{ $career->title }}"
                                                    readonly
                                                    class="crr_field_readonly">
                                            </div>

                                            <div class="crr_field crr_field_full">
                                                <label for="cv_{{ $career->id }}">Upload CV <small>(PDF, DOC, DOCX — max 5MB)</small></label>
                                                <div class="crr_file_wrap">
                                                    <input
                                                        id="cv_{{ $career->id }}"
                                                        type="file"
                                                        name="cv"
                                                        accept=".pdf,.doc,.docx"
                                                        class="crr_file_input">
                                                    <label for="cv_{{ $career->id }}" class="crr_file_label">
                                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                                            <polyline points="17 8 12 3 7 8"/>
                                                            <line x1="12" y1="3" x2="12" y2="15"/>
                                                        </svg>
                                                        <span class="crr_file_text">Choose file…</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="crr_field crr_field_full">
                                                <label for="message_{{ $career->id }}">Cover Message</label>
                                                <textarea
                                                    id="message_{{ $career->id }}"
                                                    name="message"
                                                    rows="4"
                                                    maxlength="2000"
                                                    placeholder="Tell us briefly about yourself and why you're a good fit…">{{ old('career_id') == $career->id ? old('message') : '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="crr_form_footer">
                                            <button type="button" class="crr_form_cancel" data-apply-toggle>Cancel</button>
                                            <button type="submit" class="crr_form_submit">
                                                <span>Submit Application</span>
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            {{-- Empty state --}}
            <div class="crr_empty wow fadeInUp" data-wow-delay="0.3s">
                <span class="crr_empty_icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </span>
                <h3>No Open Positions Right Now</h3>
                <p>We don't have any job openings available at the moment, but we're always on the lookout for talented individuals. Feel free to reach out to us.</p>
                <a href="{{ route('contact.index') }}" class="crr_empty_btn">
                    <span>Contact Our HR Team</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
    <div class="td_height_100 td_height_lg_75"></div>
</section>
<!-- End Openings Section -->

@endsection

@push('styles')
<style>
    .crr_intro, .crr_openings, .crr_why, .crr_cta_wrap {
        --crr: var(--heading-color, #00539B);
        --crr-dark: #002F5F;
        --crr-soft: #F4F7FB;
        --crr-line: #E6EAF2;
    }
    .crr_accent { color: var(--crr); }
    .td_section_heading .crr_accent i::before,
    .td_section_heading .crr_accent i::after { background-color: var(--crr); }

    .td_page_heading .breadcrumb-item + .breadcrumb-item::before {
        content: "/" !important; color: #fff; padding: 0 8px;
    }

    /* ========= Intro Stats ========= */
    .crr_stats { display: flex; flex-direction: column; gap: 14px; }
    .crr_stat {
        display: flex; align-items: center; gap: 16px;
        padding: 20px 22px; border-radius: 14px; background: #fff;
        border: 1px solid var(--crr-line); border-left: 4px solid var(--crr);
        box-shadow: 0 18px 40px -30px rgba(0,0,27,.4);
        transition: transform .35s ease, box-shadow .35s ease;
    }
    .crr_stat:hover {
        transform: translateX(-6px);
        box-shadow: 0 26px 50px -30px rgba(0,0,27,.5);
    }
    .crr_stat_icon {
        width: 52px; height: 52px; border-radius: 14px; flex: none;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, var(--crr-soft), #e0e9f4);
        color: var(--crr);
        transition: background .35s ease, color .35s ease;
    }
    .crr_stat:hover .crr_stat_icon {
        background: linear-gradient(135deg, var(--crr), var(--crr-dark));
        color: #fff;
    }
    .crr_stat strong { display: block; font-size: 24px; font-weight: 700; color: var(--crr); line-height: 1.1; }
    .crr_stat small { display: block; font-size: 13px; color: #6b7489; margin-top: 3px; }

    /* ========= Flash Messages ========= */
    .crr_flash {
        display: flex; align-items: flex-start; gap: 14px;
        padding: 18px 22px; border-radius: 14px;
        margin-bottom: 30px;
        position: relative;
    }
    .crr_flash_success {
        background: #e6f7ee;
        border-left: 4px solid #198754;
        color: #0f5132;
    }
    .crr_flash_success .crr_flash_icon { color: #198754; }
    .crr_flash_error {
        background: #fdecea;
        border-left: 4px solid #d93025;
        color: #611a15;
    }
    .crr_flash_error .crr_flash_icon { color: #d93025; }
    .crr_flash_icon {
        flex: none;
        width: 36px; height: 36px; border-radius: 50%;
        background: rgba(255,255,255,.6);
        display: flex; align-items: center; justify-content: center;
    }
    .crr_flash_msg { flex: 1; font-size: 15px; line-height: 1.55; }
    .crr_flash_msg ul { padding-left: 18px; }
    .crr_flash_close {
        background: transparent; border: 0; padding: 4px; cursor: pointer;
        color: inherit; opacity: .7; border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
    }
    .crr_flash_close:hover { opacity: 1; }

    /* ========= Openings Section ========= */
    .crr_openings { background: #F6F8FB; padding-top: 100px; }

    .crr_grid {
        display: flex; flex-direction: column; gap: 20px;
    }

    .crr_item {
        background: #fff;
        border: 1px solid var(--crr-line);
        border-radius: 18px;
        box-shadow: 0 18px 40px -30px rgba(0,0,27,.3);
        overflow: hidden;
        transition: box-shadow .35s ease, border-color .35s ease;
        position: relative;
    }
    .crr_item::before {
        content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 4px;
        background: linear-gradient(90deg, var(--crr), var(--crr-dark));
        transform: scaleX(0); transform-origin: left; transition: transform .4s ease;
    }
    .crr_item.is-open,
    .crr_item:hover {
        box-shadow: 0 30px 50px -25px rgba(0,47,95,.4);
        border-color: rgba(0, 83, 155, 0.3);
    }
    .crr_item.is-open::before,
    .crr_item:hover::before { transform: scaleX(1); }

    /* --- Head (clickable preview) --- */
    .crr_item_head {
        width: 100%;
        display: flex; align-items: center; justify-content: space-between;
        gap: 20px; padding: 26px 30px;
        background: transparent;
        border: 0; cursor: pointer; text-align: left;
        font-family: inherit;
        transition: background .3s ease;
    }
    .crr_item_head:hover { background: #FAFBFD; }
    .crr_item_head_main {
        display: flex; align-items: center; gap: 20px; flex: 1; min-width: 0;
    }
    .crr_item_titleblock { flex: 1; min-width: 0; }

    .crr_card_icon {
        display: flex; align-items: center; justify-content: center;
        width: 56px; height: 56px; border-radius: 14px; flex: none;
        background: linear-gradient(135deg, var(--crr-soft), #e0e9f4);
        color: var(--crr);
        transition: all .35s ease;
    }
    .crr_item.is-open .crr_card_icon,
    .crr_item_head:hover .crr_card_icon {
        transform: rotate(-5deg) scale(1.05);
        background: linear-gradient(135deg, var(--crr), var(--crr-dark));
        color: #fff;
    }

    .crr_card_title {
        font-size: 20px; font-weight: 700;
        line-height: 1.3; color: var(--crr);
        margin: 0 0 6px;
    }
    .crr_card_preview {
        font-size: 14.5px; line-height: 1.55;
        color: #5b6477; margin: 0;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .crr_item.is-open .crr_card_preview {
        -webkit-line-clamp: unset;
        display: none;
    }

    .crr_item_head_side {
        display: flex; align-items: center; gap: 14px; flex: none;
    }
    .crr_card_badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 12px; border-radius: 20px;
        background: #e6f7ee; color: #198754;
        font-size: 11.5px; font-weight: 700;
        letter-spacing: 0.4px; text-transform: uppercase;
    }
    .crr_card_badge::before {
        content: ""; width: 6px; height: 6px; border-radius: 50%;
        background: #198754; animation: crrPulse 2s ease-in-out infinite;
    }
    @keyframes crrPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.3); }
    }
    .crr_item_chev {
        display: flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 50%;
        background: var(--crr-soft); color: var(--crr);
        transition: transform .35s ease, background .3s ease;
    }
    .crr_item.is-open .crr_item_chev {
        transform: rotate(180deg);
        background: var(--crr); color: #fff;
    }

    /* --- Panel (expandable) --- */
    .crr_item_panel {
        max-height: 0; overflow: hidden;
        transition: max-height .5s ease;
    }
    .crr_item.is-open .crr_item_panel {
        max-height: 4000px;
    }
    .crr_item_panel_inner {
        padding: 10px 30px 30px;
        border-top: 1px solid var(--crr-line);
    }

    .crr_item_details {
        font-size: 15.5px; line-height: 1.75;
        color: #3d4556;
        padding-top: 20px;
    }
    .crr_item_details h1, .crr_item_details h2, .crr_item_details h3,
    .crr_item_details h4, .crr_item_details h5, .crr_item_details h6,
    .crr_item_details strong, .crr_item_details b { color: var(--crr); }
    .crr_item_details h2 { font-size: 22px; }
    .crr_item_details h3 { font-size: 20px; }
    .crr_item_details h4, .crr_item_details h5 { font-size: 17px; }
    .crr_item_details h1, .crr_item_details h2, .crr_item_details h3,
    .crr_item_details h4, .crr_item_details h5 {
        font-weight: 600; margin: 18px 0 10px; line-height: 1.3;
    }
    .crr_item_details > *:first-child { margin-top: 0; }
    .crr_item_details p { margin: 0 0 12px; }
    .crr_item_details p:last-child { margin-bottom: 0; }
    .crr_item_details a { color: var(--crr); text-decoration: underline; }
    .crr_item_details ul, .crr_item_details ol {
        padding-left: 0; margin-bottom: 14px; list-style: none;
    }
    .crr_item_details li { position: relative; padding-left: 28px; margin-bottom: 8px; }
    .crr_item_details li::before {
        content: ""; position: absolute; left: 0; top: 8px;
        width: 16px; height: 16px; border-radius: 50%;
        background: var(--crr) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 6 9 17l-5-5'/%3E%3C/svg%3E") center / 10px no-repeat;
    }
    .crr_item_details blockquote {
        margin: 14px 0; padding: 12px 20px;
        border-left: 3px solid var(--crr);
        background: var(--crr-soft);
        border-radius: 0 10px 10px 0;
        font-style: italic;
    }
    .crr_item_details table {
        width: 100%; margin-bottom: 14px;
        border-collapse: collapse; font-size: 14.5px;
    }
    .crr_item_details th, .crr_item_details td {
        padding: 10px 14px; border: 1px solid var(--crr-line); text-align: left;
    }
    .crr_item_details th {
        background: var(--crr-soft); color: var(--crr); font-weight: 600;
    }
    .crr_item_details img { max-width: 100%; height: auto; border-radius: 10px; margin: 10px 0; }

    /* --- Actions --- */
    .crr_item_actions {
        margin-top: 24px;
        display: flex; gap: 12px; flex-wrap: wrap;
    }
    .crr_apply_btn {
        display: inline-flex; align-items: center; gap: 10px;
        padding: 13px 28px; border-radius: 30px;
        background: linear-gradient(135deg, var(--crr), var(--crr-dark));
        color: #fff; font-weight: 600; font-size: 14px;
        border: 0; cursor: pointer;
        box-shadow: 0 15px 30px -10px rgba(0,47,95,.5);
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .crr_apply_btn:hover {
        transform: translateY(-3px); color: #fff;
        box-shadow: 0 20px 40px -10px rgba(0,47,95,.6);
    }
    .crr_apply_btn svg { transition: transform .3s ease; }
    .crr_apply_btn:hover svg { transform: translateX(4px); }

    /* --- Apply form --- */
    .crr_apply_form_wrap {
        max-height: 0; overflow: hidden;
        transition: max-height .5s ease, margin-top .35s ease, opacity .35s ease;
        opacity: 0;
    }
    .crr_apply_form_wrap.is-open {
        max-height: 2500px;
        margin-top: 28px;
        opacity: 1;
    }
    .crr_apply_form {
        padding: 28px;
        background: var(--crr-soft);
        border-radius: 16px;
        border: 1px solid var(--crr-line);
    }
    .crr_form_grid {
        display: grid; grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }
    .crr_field { display: flex; flex-direction: column; }
    .crr_field_full { grid-column: 1 / -1; }
    .crr_field label {
        font-size: 13.5px; font-weight: 600;
        color: var(--crr); margin-bottom: 7px;
        display: inline-flex; align-items: baseline; gap: 6px;
    }
    .crr_field label span { color: #d93025; }
    .crr_field label small { color: #6b7489; font-weight: 400; font-size: 12px; }
    .crr_field input,
    .crr_field textarea {
        width: 100%; padding: 12px 14px;
        font-family: inherit; font-size: 14.5px;
        color: #3d4556;
        background: #fff;
        border: 1px solid var(--crr-line);
        border-radius: 10px;
        transition: border-color .25s ease, box-shadow .25s ease;
    }
    .crr_field input:focus,
    .crr_field textarea:focus {
        outline: none;
        border-color: var(--crr);
        box-shadow: 0 0 0 3px rgba(0, 83, 155, 0.12);
    }
    .crr_field_readonly { background: #eef2f8 !important; cursor: not-allowed; }
    .crr_field textarea { resize: vertical; min-height: 100px; }

    /* File input */
    .crr_file_wrap { position: relative; }
    .crr_file_input {
        position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px;
        overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0;
    }
    .crr_file_label {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 14px; cursor: pointer;
        background: #fff; border: 1px dashed var(--crr-line);
        border-radius: 10px;
        color: #6b7489; font-weight: 500;
        transition: border-color .25s ease, background .25s ease, color .25s ease;
    }
    .crr_file_label:hover {
        border-color: var(--crr); color: var(--crr);
        background: #fff;
    }
    .crr_file_label svg { flex: none; }
    .crr_file_text {
        flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    .crr_form_footer {
        margin-top: 24px;
        display: flex; justify-content: flex-end; align-items: center; gap: 12px;
        flex-wrap: wrap;
    }
    .crr_form_cancel {
        padding: 12px 24px; border-radius: 30px;
        background: transparent; border: 1px solid var(--crr-line);
        color: #6b7489; font-weight: 600; font-size: 14px;
        cursor: pointer;
        transition: all .25s ease;
    }
    .crr_form_cancel:hover { background: #fff; color: var(--crr); border-color: var(--crr); }
    .crr_form_submit {
        display: inline-flex; align-items: center; gap: 10px;
        padding: 13px 28px; border-radius: 30px;
        background: linear-gradient(135deg, var(--crr), var(--crr-dark));
        color: #fff; font-weight: 600; font-size: 14px;
        border: 0; cursor: pointer;
        box-shadow: 0 15px 30px -10px rgba(0,47,95,.5);
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .crr_form_submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px -10px rgba(0,47,95,.6);
    }
    .crr_form_submit svg { transition: transform .3s ease; }
    .crr_form_submit:hover svg { transform: translateX(4px); }

    /* ========= Empty State ========= */
    .crr_empty {
        max-width: 560px; margin: 0 auto;
        text-align: center; padding: 50px 30px;
        border: 2px dashed var(--crr-line); border-radius: 20px;
        background: #fff;
    }
    .crr_empty_icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 90px; height: 90px; border-radius: 50%;
        background: var(--crr-soft); color: var(--crr);
        margin-bottom: 20px;
    }
    .crr_empty h3 { font-size: 24px; font-weight: 700; color: var(--crr); margin: 0 0 10px; }
    .crr_empty p { font-size: 15px; line-height: 1.6; color: #6b7489; margin: 0 0 24px; }
    .crr_empty_btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 14px 28px; border-radius: 30px;
        background: linear-gradient(135deg, var(--crr), var(--crr-dark));
        color: #fff; font-weight: 600; font-size: 14px;
        box-shadow: 0 15px 30px -10px rgba(0,47,95,.5);
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .crr_empty_btn:hover {
        transform: translateY(-3px); color: #fff;
        box-shadow: 0 20px 40px -10px rgba(0,47,95,.6);
    }

    /* ========= Why Work With Us ========= */
    .crr_why { position: relative; overflow: hidden; }
    .crr_why::before, .crr_why::after {
        content: ""; position: absolute; border-radius: 50%;
        background: rgba(255,255,255,.06); pointer-events: none;
    }
    .crr_why::before { width: 420px; height: 420px; top: -160px; right: -120px; }
    .crr_why::after { width: 260px; height: 260px; bottom: -120px; left: -80px; }
    .crr_why .container { position: relative; z-index: 1; }

    .crr_why_badge {
        display: inline-block; margin: 0 0 16px;
        padding: 8px 18px; border-radius: 30px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.25);
        color: #fff; font-size: 14px; font-weight: 600;
        letter-spacing: 1px; text-transform: uppercase;
    }

    .crr_why_card {
        height: 100%; padding: 32px 26px; border-radius: 18px;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.18);
        backdrop-filter: blur(6px);
        color: #fff; text-align: center;
        transition: transform .35s ease, background .35s ease;
    }
    .crr_why_card:hover { transform: translateY(-6px); background: rgba(255,255,255,.14); }
    .crr_why_icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 64px; height: 64px; border-radius: 16px;
        background: rgba(255,255,255,.18); color: #fff;
        margin-bottom: 18px; backdrop-filter: blur(10px);
    }
    .crr_why_card h3 { font-size: 20px; font-weight: 600; color: #fff; margin: 0 0 12px; }
    .crr_why_card p { font-size: 14.5px; line-height: 1.65; color: rgba(255,255,255,.85); margin: 0; }

    /* ========= CTA ========= */
    .crr_cta {
        display: flex; align-items: center; justify-content: space-between;
        gap: 24px; flex-wrap: wrap;
        padding: 44px 50px; border-radius: 22px;
        position: relative; overflow: hidden;
        background: linear-gradient(135deg, var(--crr) 0%, var(--crr-dark) 100%);
        box-shadow: 0 30px 60px -35px rgba(0,47,95,.8);
    }
    .crr_cta::before {
        content: ""; position: absolute;
        width: 300px; height: 300px; border-radius: 50%;
        right: -90px; top: -120px;
        background: rgba(255,255,255,.07);
    }
    .crr_cta > * { position: relative; z-index: 1; }
    .crr_cta_btn {
        display: inline-flex; align-items: center; gap: 12px;
        padding: 6px 6px 6px 24px; border-radius: 30px;
        background: #fff; color: var(--crr); font-weight: 600;
        transition: box-shadow .3s ease, transform .3s ease;
    }
    .crr_cta_btn_icon {
        width: 40px; height: 40px; border-radius: 50%; flex: none;
        display: flex; align-items: center; justify-content: center;
        background: var(--crr); color: #fff;
        transition: transform .3s ease;
    }
    .crr_cta_btn:hover {
        color: var(--crr); transform: translateY(-2px);
        box-shadow: 0 14px 28px -14px rgba(0,0,0,.5);
    }
    .crr_cta_btn:hover .crr_cta_btn_icon {
        transform: translateX(4px) rotate(-45deg);
    }

    /* ========= Responsive ========= */
    @media (max-width: 991px) {
        .crr_cta { padding: 36px 30px; }
        .crr_item_head { padding: 22px 22px; }
        .crr_item_panel_inner { padding: 8px 22px 24px; }
    }
    @media (max-width: 767px) {
        .crr_item_head {
            flex-direction: column; align-items: flex-start; gap: 14px;
        }
        .crr_item_head_main { width: 100%; }
        .crr_item_head_side { width: 100%; justify-content: space-between; }
        .crr_form_grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 575px) {
        .crr_cta { padding: 30px 20px; }
        .crr_cta_btn { width: 100%; justify-content: space-between; }
        .crr_empty { padding: 36px 20px; }
        .crr_item_head { padding: 20px 18px; }
        .crr_item_panel_inner { padding: 8px 18px 22px; }
        .crr_apply_form { padding: 20px 18px; }
        .crr_form_footer { flex-direction: column-reverse; align-items: stretch; }
        .crr_form_cancel, .crr_form_submit { width: 100%; justify-content: center; }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    function init() {
        var items = document.querySelectorAll('.crr_item');
        if (!items.length) return;

        // Expand/collapse card
        items.forEach(function (item) {
            var head = item.querySelector('.crr_item_head');
            if (!head) return;

            head.addEventListener('click', function () {
                var isOpen = item.classList.toggle('is-open');
                head.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

                // Close other cards so only one is open at a time
                if (isOpen) {
                    items.forEach(function (other) {
                        if (other !== item && other.classList.contains('is-open')) {
                            other.classList.remove('is-open');
                            var otherHead = other.querySelector('.crr_item_head');
                            if (otherHead) otherHead.setAttribute('aria-expanded', 'false');
                            var otherForm = other.querySelector('.crr_apply_form_wrap');
                            if (otherForm) otherForm.classList.remove('is-open');
                        }
                    });

                    // Smooth scroll into view
                    setTimeout(function () {
                        var rect = item.getBoundingClientRect();
                        if (rect.top < 80 || rect.top > window.innerHeight - 200) {
                            window.scrollTo({
                                top: window.pageYOffset + rect.top - 100,
                                behavior: 'smooth'
                            });
                        }
                    }, 100);
                }
            });

            // Apply toggle (open form + cancel button)
            var toggles = item.querySelectorAll('[data-apply-toggle]');
            var formWrap = item.querySelector('.crr_apply_form_wrap');
            toggles.forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (!formWrap) return;
                    var opening = !formWrap.classList.contains('is-open');
                    formWrap.classList.toggle('is-open');

                    if (opening) {
                        setTimeout(function () {
                            var firstInput = formWrap.querySelector('input[name="name"]');
                            if (firstInput) firstInput.focus({ preventScroll: true });

                            var rect = formWrap.getBoundingClientRect();
                            if (rect.top < 80 || rect.top > window.innerHeight - 150) {
                                window.scrollTo({
                                    top: window.pageYOffset + rect.top - 100,
                                    behavior: 'smooth'
                                });
                            }
                        }, 200);
                    }
                });
            });

            // File input label update
            var fileInput = item.querySelector('.crr_file_input');
            if (fileInput) {
                fileInput.addEventListener('change', function () {
                    var label = item.querySelector('.crr_file_text');
                    if (!label) return;
                    if (fileInput.files && fileInput.files.length > 0) {
                        label.textContent = fileInput.files[0].name;
                    } else {
                        label.textContent = 'Choose file…';
                    }
                });
            }
        });

        // Auto-dismiss success flash after 7s
        var flash = document.getElementById('crrFlash');
        if (flash) {
            setTimeout(function () {
                flash.style.transition = 'opacity .5s ease';
                flash.style.opacity = '0';
                setTimeout(function () { flash.remove(); }, 500);
            }, 7000);
        }

        // Scroll to a specific career if URL has hash like #career-5
        if (window.location.hash && window.location.hash.indexOf('#career-') === 0) {
            var target = document.querySelector(window.location.hash);
            if (target && target.classList.contains('crr_item')) {
                setTimeout(function () {
                    target.classList.add('is-open');
                    var h = target.querySelector('.crr_item_head');
                    if (h) h.setAttribute('aria-expanded', 'true');
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 300);
            }
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@endpush