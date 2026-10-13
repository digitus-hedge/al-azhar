@extends('web.layouts.app')

@section('title', 'Policies & Objectives || Al Azhar Central School, Mala')
@section('meta_description', 'Our school policies, academic objectives, and feature projects at Al Azhar Central School, Mala. Discover our commitment to value-based CBSE education.')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@push('styles')
<style>
    .td_page_heading .breadcrumb-item + .breadcrumb-item::before {
        content: "/" !important;
        color: #fff;
        padding: 0 8px;
    }
</style>
@endpush

@section('content')

<!-- Start Page Heading Section -->
<section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('images/header.png') }}"
    style="background-image: url('{{ asset('images/header.png') }}');">
    <div class="container">
        <div class="td_page_heading_in">
            <h1 class="td_white_color td_fs_48 td_mb_10 wow fadeInDown" data-wow-duration="0.9s" data-wow-delay="0.2s">Policies &amp; Objectives</h1>
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
<!-- Start Policies Section -->
<section class="po_policies">
    <div class="container">
        <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
            <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                School Policies
            </p>
            <h2 class="td_section_title td_fs_48 mb-0">Our Guiding Policies</h2>
            <p class="td_fs_18 mb-0 mt-3" style="max-width:720px;margin:0 auto;color:#6b7489;">
                Clear, fair, and student-first — these policies shape a safe and supportive environment for every learner.
            </p>
        </div>
        <div class="td_height_50 td_height_lg_40"></div>

        <div class="row td_gap_y_30">
            @php
                $policies = [
                    [
                        'icon' => '<path d="M12 3 1 8l11 5 11-5-11-5z"/><path d="M5 10.5V16c0 1.5 3 3 7 3s7-1.5 7-3v-5.5"/>',
                        'title' => 'Academic Excellence Policy',
                        'desc' => 'A balanced curriculum aligned with CBSE guidelines, emphasizing critical thinking, creativity, and conceptual clarity across all subjects.',
                    ],
                    [
                        'icon' => '<path d="M20 7h-7m7 5h-7m7 5h-7"/><circle cx="5" cy="7" r="1.5"/><circle cx="5" cy="12" r="1.5"/><circle cx="5" cy="17" r="1.5"/>',
                        'title' => 'Admission Policy',
                        'desc' => 'Transparent, merit-based admissions open to students from all backgrounds, with equal opportunities regardless of caste, creed, or community.',
                    ],
                    [
                        'icon' => '<path d="M9 12l2 2 4-4"/><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"/>',
                        'title' => 'Code of Conduct',
                        'desc' => 'Respect, discipline, and integrity form the cornerstone of student life, applicable to classrooms, campus, and outside activities alike.',
                    ],
                ];
            @endphp

            @foreach ($policies as $i => $policy)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="{{ 0.2 + ($i % 3) * 0.1 }}s">
                    <div class="po_policy_card">
                        <div class="po_policy_icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                {!! $policy['icon'] !!}
                            </svg>
                        </div>
                        <h3 class="po_policy_title">{{ $policy['title'] }}</h3>
                        <p class="po_policy_desc">{{ $policy['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="td_height_100 td_height_lg_75"></div>
</section>
<!-- End Policies Section -->

<!-- Start Feature Projects Section -->
<section class="po_projects">
    <div class="td_height_100 td_height_lg_75"></div>
    <div class="container">
        <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
            <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                Beyond The Classroom
            </p>
            <h2 class="td_section_title td_fs_48 mb-0">Feature Projects &amp; Initiatives</h2>
            <p class="td_fs_18 mb-0 mt-3" style="max-width:720px;margin:0 auto;color:#6b7489;">
                Flagship programs that bring our policies and objectives to life — nurturing curious, confident, and compassionate learners.
            </p>
        </div>
        <div class="td_height_50 td_height_lg_40"></div>

        <div class="row td_gap_y_30">
            @php
                $projects = [
                    [
                        'icon' => '<path d="M4.5 2L3 7l9 5 9-5-1.5-5"/><path d="M3 7v8l9 5 9-5V7"/><path d="M12 12v10"/>',
                        'tag' => 'STEM Lab',
                        'title' => 'Innovation Hub',
                        'desc' => 'A fully-equipped laboratory for robotics, coding, and electronics where students build real-world projects, from automated plant-watering systems to Arduino-based weather stations.',
                        'tags' => ['Robotics', 'Coding', 'Electronics'],
                    ],
                    [
                        'icon' => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>',
                        'tag' => 'Reading Program',
                        'title' => 'Little Library Campaign',
                        'desc' => 'Weekly reading circles, author meet-and-greets, and book exchanges have made our campus a reading haven. Students have collectively read over 15,000 books this year alone.',
                        'tags' => ['Literacy', 'Books', 'Author Talks'],
                    ],
                    [
                        'icon' => '<path d="M12 2v8"/><path d="M12 10c-3 0-5 2-5 5 0 2 1 4 2 5"/><path d="M12 10c3 0 5 2 5 5 0 2-1 4-2 5"/><path d="M7 20c1-2 3-3 5-3s4 1 5 3"/>',
                        'tag' => 'Green Initiative',
                        'title' => 'Eco Warriors Club',
                        'desc' => 'Students lead campus-wide composting, rainwater harvesting, and tree-planting drives. Over 500 saplings have been planted and 2 tonnes of waste composted since 2024.',
                        'tags' => ['Sustainability', 'Environment', 'Community'],
                    ],
                ];
            @endphp

            @foreach ($projects as $i => $proj)
                @php $projAnim = ['fadeInLeft', 'fadeInUp', 'fadeInRight'][$i % 3]; @endphp
                <div class="col-lg-4 col-md-6 wow {{ $projAnim }}" data-wow-duration="1s" data-wow-delay="{{ 0.2 + ($i % 3) * 0.1 }}s">
                    <article class="po_proj_card">
                        <div class="po_proj_head">
                            <span class="po_proj_icon">
                                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    {!! $proj['icon'] !!}
                                </svg>
                            </span>
                            <span class="po_proj_badge">{{ $proj['tag'] }}</span>
                        </div>
                        <div class="po_proj_body">
                            <h3 class="po_proj_title">{{ $proj['title'] }}</h3>
                            <p class="po_proj_desc">{{ $proj['desc'] }}</p>
                            <div class="po_proj_tags">
                                @foreach ($proj['tags'] as $tag)
                                    <span>#{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
    <div class="td_height_100 td_height_lg_75"></div>
</section>
<!-- End Feature Projects Section -->

<!-- Start CTA Section -->
<section class="po_cta">
    <div class="container">
        <div class="po_cta_box wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
            <div class="po_cta_text">
                <h2>Want to Know More About Our School?</h2>
                <p>Visit our campus, meet our teachers, and see our policies and projects in action.</p>
            </div>
            <div class="po_cta_btns">
                <a href="{{ route('admission') }}" class="td_btn td_style_1 td_radius_30 td_medium">
                    <span class="td_btn_in td_white_color td_accent_bg">
                        <span>Apply Now</span>
                        <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
                <a href="{{ route('contact.index') }}" class="po_cta_outline">Contact Us</a>
            </div>
        </div>
    </div>
    <div class="td_height_100 td_height_lg_75"></div>
</section>
<!-- End CTA Section -->

<style>
    :root { --po: var(--heading-color, #00539B); }

    /* ===== Intro Section ===== */
    .po_intro_img_wrap { position: relative; }
    .po_intro_img {
        width: 100%; aspect-ratio: 4 / 5; object-fit: cover; display: block;
        border-radius: 20px; box-shadow: 0 25px 50px -20px rgba(0,47,95,.4);
    }
    .po_intro_badge {
        position: absolute; bottom: -24px; right: -10px;
        padding: 20px 28px; border-radius: 16px;
        background: #fff; box-shadow: 0 20px 40px -15px rgba(0,47,95,.3);
        text-align: center;
    }
    .po_intro_badge strong {
        display: block; font-size: 36px; font-weight: 800;
        color: var(--po); line-height: 1;
    }
    .po_intro_badge span {
        display: block; font-size: 13px; font-weight: 600;
        color: #6b7489; margin-top: 6px; text-transform: uppercase; letter-spacing: 0.5px;
    }

    /* ===== Policies Section ===== */
    .po_policies { background: #F6F8FB; padding-top: 100px; }
    .po_policy_card {
        height: 100%; background: #fff; padding: 32px 28px; border-radius: 18px;
        border: 1px solid #E6EAF2; box-shadow: 0 18px 40px -30px rgba(0,0,27,.3);
        transition: transform .35s ease, box-shadow .35s ease;
        position: relative; overflow: hidden;
    }
    .po_policy_card::before {
        content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 3px;
        background: linear-gradient(90deg, var(--po), #002F5F);
        transform: scaleX(0); transform-origin: left; transition: transform .4s ease;
    }
    .po_policy_card:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 50px -25px rgba(0,47,95,.4);
    }
    .po_policy_card:hover::before { transform: scaleX(1); }
    .po_policy_icon {
        width: 60px; height: 60px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #eef4fb, #d9e5f3);
        color: var(--po); margin-bottom: 20px;
        transition: transform .35s ease;
    }
    .po_policy_card:hover .po_policy_icon {
        transform: rotate(-5deg) scale(1.1);
        background: linear-gradient(135deg, var(--po), #002F5F);
        color: #fff;
    }
    .po_policy_title {
        font-size: 20px; font-weight: 700; line-height: 1.3;
        color: var(--po); margin: 0 0 12px;
    }
    .po_policy_desc {
        font-size: 15px; line-height: 1.65;
        color: #5b6477; margin: 0;
    }

    /* ===== Objectives Section ===== */
    .po_objectives { position: relative; overflow: hidden; }
    .po_objectives::before, .po_objectives::after {
        content: ""; position: absolute; border-radius: 50%;
        background: rgba(255,255,255,.06); pointer-events: none;
    }
    .po_objectives::before { width: 420px; height: 420px; top: -160px; right: -120px; }
    .po_objectives::after { width: 260px; height: 260px; bottom: -120px; left: -80px; }
    .po_objectives .container { position: relative; z-index: 1; }

    .po_obj_badge {
        display: inline-block; margin: 0 0 16px; padding: 8px 18px; border-radius: 30px;
        background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.25);
        color: #fff; font-size: 14px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;
    }

    .po_obj_card {
        height: 100%; padding: 36px 30px; border-radius: 18px;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.18);
        backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
        color: #fff; position: relative; overflow: hidden;
        transition: transform .35s ease, background .35s ease;
    }
    .po_obj_card:hover {
        transform: translateY(-6px);
        background: rgba(255,255,255,.14);
    }
    .po_obj_num {
        display: inline-block; font-size: 48px; font-weight: 800;
        line-height: 1; color: rgba(255,255,255,.25);
        margin-bottom: 10px; letter-spacing: -1px;
    }
    .po_obj_title {
        font-size: 22px; font-weight: 600; line-height: 1.3;
        color: #fff; margin: 0 0 12px;
    }
    .po_obj_desc {
        font-size: 15px; line-height: 1.7;
        color: rgba(255,255,255,.85); margin: 0;
    }

    /* ===== Feature Projects Section (No Images) ===== */
.po_projects { background: #fff; }
.po_proj_card {
    height: 100%; background: #fff; border-radius: 18px; overflow: hidden;
    border: 1px solid #E6EAF2;
    box-shadow: 0 18px 40px -30px rgba(0,0,27,.3);
    transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
    display: flex; flex-direction: column;
    position: relative;
}
.po_proj_card::before {
    content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 4px;
    background: linear-gradient(90deg, var(--po), #002F5F);
    transform: scaleX(0); transform-origin: left;
    transition: transform .4s ease;
}
.po_proj_card:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 55px -25px rgba(0,47,95,.4);
    border-color: rgba(0, 83, 155, 0.3);
}
.po_proj_card:hover::before { transform: scaleX(1); }

/* Card header: icon + badge */
.po_proj_head {
    display: flex; align-items: center; justify-content: space-between;
    gap: 14px; padding: 28px 24px 0;
}
.po_proj_icon {
    display: flex; align-items: center; justify-content: center;
    width: 64px; height: 64px; border-radius: 16px;
    background: linear-gradient(135deg, #eef4fb, #d9e5f3);
    color: var(--po);
    transition: transform .35s ease, background .35s ease;
    flex: none;
}
.po_proj_card:hover .po_proj_icon {
    transform: rotate(-5deg) scale(1.1);
    background: linear-gradient(135deg, var(--po), #002F5F);
    color: #fff;
}
.po_proj_badge {
    padding: 5px 14px; border-radius: 20px;
    background: #eef4fb; color: var(--po);
    font-size: 11.5px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.5px;
    white-space: nowrap;
}

.po_proj_body { flex: 1; display: flex; flex-direction: column; padding: 20px 24px 28px; }
.po_proj_title {
    font-size: 22px; font-weight: 700; line-height: 1.3;
    color: var(--po); margin: 0 0 12px;
}
.po_proj_desc {
    font-size: 14.5px; line-height: 1.7;
    color: #5b6477; margin: 0 0 18px;
}
.po_proj_tags {
    display: flex; flex-wrap: wrap; gap: 6px;
    margin-top: auto; padding-top: 16px;
    border-top: 1px solid #F0F2F7;
}
.po_proj_tags span {
    display: inline-block; padding: 3px 10px; border-radius: 20px;
    background: #F6F8FB; color: var(--po);
    font-size: 11.5px; font-weight: 600;
    transition: background .25s ease;
}
.po_proj_card:hover .po_proj_tags span {
    background: #e3edf7;
}

    /* ===== CTA Section ===== */
    .po_cta { padding-bottom: 50px; background: #fff; }
    .po_cta_box {
        padding: 50px 50px; border-radius: 24px;
        background: linear-gradient(135deg, var(--po) 0%, #002F5F 100%);
        box-shadow: 0 30px 60px -20px rgba(0,47,95,.5);
        display: flex; align-items: center; justify-content: space-between;
        gap: 30px; flex-wrap: wrap; position: relative; overflow: hidden;
    }
    .po_cta_box::before {
        content: ""; position: absolute; width: 300px; height: 300px;
        border-radius: 50%; background: rgba(255,255,255,.08);
        top: -100px; right: -80px;
    }
    .po_cta_text { color: #fff; position: relative; z-index: 1; flex: 1; min-width: 280px; }
    .po_cta_text h2 {
        font-size: 32px; font-weight: 700; line-height: 1.2;
        color: #fff; margin: 0 0 10px;
    }
    .po_cta_text p {
        font-size: 16px; margin: 0; opacity: 0.9;
    }
    .po_cta_btns {
        display: flex; gap: 14px; flex-wrap: wrap;
        position: relative; z-index: 1;
    }
    .po_cta_outline {
        display: inline-flex; align-items: center; height: 56px; padding: 0 30px;
        border-radius: 30px; border: 1px solid rgba(255,255,255,.6);
        color: #fff; font-weight: 500; transition: all .3s ease;
    }
    .po_cta_outline:hover {
        background: #fff; color: var(--po);
    }

    /* ===== Responsive ===== */
    @media (max-width: 991px) {
        .po_cta_box { padding: 36px 28px; text-align: center; }
        .po_cta_text { min-width: 100%; }
        .po_cta_btns { width: 100%; justify-content: center; }
    }
    @media (max-width: 767px) {
        .po_intro_badge { bottom: -16px; right: 20px; padding: 16px 20px; }
        .po_intro_badge strong { font-size: 28px; }
        .po_intro_badge span { font-size: 11px; }
        .po_policy_card:hover,
        .po_obj_card:hover,
        .po_proj_card:hover { transform: none; }
        .po_cta_text h2 { font-size: 24px; }
    }
    @media (max-width: 575px) {
        .po_policy_card { padding: 26px 22px; }
        .po_policy_title { font-size: 18px; }
        .po_obj_card { padding: 28px 22px; }
        .po_obj_num { font-size: 40px; }
        .po_obj_title { font-size: 20px; }
        .po_proj_title { font-size: 19px; }
        .po_cta_btns { flex-direction: column; align-items: stretch; }
        .po_cta_btns .td_btn,
        .po_cta_outline { width: 100%; justify-content: center; }
    }
</style>

@endsection