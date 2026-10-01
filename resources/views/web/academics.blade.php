@extends('web.layouts.app')

@section('title', 'Academics || AL-Azhar')
@section('meta_description', 'Academics at Al Azhar Central School, Mala: CBSE syllabus from Preschool to Senior Secondary, Montessori kindergarten, fee structure, board examinations and subject streams.')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@php
    // Put the campus photo at public/images/academics.jpg
    $acdImage = asset('images/about2.jpeg');

    $levels = [
        ['title' => 'Preschool',                 'sub' => 'First steps into learning',  'icon' => '<path d="M12 3a4 4 0 0 1 4 4v1H8V7a4 4 0 0 1 4-4z"/><path d="M5 21v-6a7 7 0 0 1 14 0v6"/><path d="M9 21v-3h6v3"/>'],
        ['title' => 'LKG and UKG',               'sub' => 'Montessori stream',           'icon' => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><circle cx="17.5" cy="17.5" r="3.5"/>'],
        ['title' => 'Primary Level',             'sub' => 'Classes I – V',               'icon' => '<path d="M2 5a2 2 0 0 1 2-2h6v17H4a2 2 0 0 0-2 2V5zM22 5a2 2 0 0 0-2-2h-6v17h6a2 2 0 0 1 2 2V5z"/>'],
        ['title' => 'Secondary Level',           'sub' => 'Classes VI – X',              'icon' => '<path d="M9 3h6v4l4 9a3 3 0 0 1-2.7 4.3H7.7A3 3 0 0 1 5 16l4-9V3z"/><path d="M8 3h8M7 14h10"/>'],
        ['title' => 'Senior Secondary Level',    'sub' => 'Classes XI – XII',            'icon' => '<path d="M22 9 12 4 2 9l10 5 10-5z"/><path d="M6 11v5c0 1.7 2.7 3 6 3s6-1.3 6-3v-5"/><path d="M22 9v6"/>'],
    ];

    $values = ['Ethics & morality', 'Civility', 'Kindness', 'Discipline', 'Honesty'];

    // ---------- Fee structure (data comes from AcademicController) ----------
    $fees       = $fees ?? collect();
    $classIndex = array_flip(\App\Models\Fee::CLASSES);

    $feeGroupMeta = [
        'Kindergarten'           => ['sub' => 'Pre-KG, LKG & UKG', 'icon' => $levels[1]['icon']],
        'Primary Level'          => ['sub' => 'Classes I – V',     'icon' => $levels[2]['icon']],
        'Secondary Level'        => ['sub' => 'Classes VI – X',    'icon' => $levels[3]['icon']],
        'Senior Secondary Level' => ['sub' => 'Classes XI – XII',  'icon' => $levels[4]['icon']],
        'Other Classes'          => ['sub' => '',                  'icon' => $levels[0]['icon']],
    ];
    $groupOrder = array_flip(array_keys($feeGroupMeta));

    $feeGroups = $fees
        ->groupBy(function ($fee) use ($classIndex) {
            $i = $classIndex[$fee->class_name] ?? null;
            return match (true) {
                $i === null => 'Other Classes',
                $i <= 2     => 'Kindergarten',
                $i <= 7     => 'Primary Level',
                $i <= 12    => 'Secondary Level',
                default     => 'Senior Secondary Level',
            };
        })
        ->sortBy(fn ($items, $group) => $groupOrder[$group] ?? 99);

    // Indian number format: 196000 → ₹1,96,000
    $inr = function ($amount) {
        [$int, $dec] = explode('.', number_format((float) $amount, 2, '.', ''));
        $last3 = substr($int, -3);
        $rest  = substr($int, 0, -3);
        if ($rest !== '' && $rest !== false) {
            $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest) . ',';
        } else {
            $rest = '';
        }
        return '₹' . $rest . $last3 . ($dec !== '00' ? '.' . $dec : '');
    };
@endphp

@section('content')

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('images/header.jpeg') }}"
    style="background-image: url('{{ asset('images/header.jpeg') }}');">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10 wow fadeInDown" data-wow-duration="0.9s" data-wow-delay="0.2s">Academics</h1>
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

    <!-- Start Intro -->
    <section class="acd_intro">
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">
            <div class="row align-items-center td_gap_y_40">

                {{-- Left: campus photo --}}
                <div class="col-lg-6">
                    <div class="acd_photo wow zoomIn" data-wow-duration="1.1s" data-wow-delay="0.2s">
                        <img src="{{ $acdImage }}" alt="Students at Al Azhar Central School campus">
                        <div class="acd_photo_badge">
                            <span class="acd_photo_badge_icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l2.4 1.8 3-.2.9 2.9 2.5 1.7-1 2.8 1 2.8-2.5 1.7-.9 2.9-3-.2L12 22l-2.4-1.8-3 .2-.9-2.9-2.5-1.7 1-2.8-1-2.8 2.5-1.7.9-2.9 3 .2L12 2z"/><path d="m8.5 12 2.3 2.3 4.7-4.6"/></svg>
                            </span>
                            <span><strong>CBSE</strong><small>New Delhi syllabus</small></span>
                        </div>
                    </div>
                </div>

                {{-- Right: intro text --}}
                <div class="col-lg-6 acd_intro_text">
                    <div class="td_section_heading td_style_1 td_mb_30">
                        <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase acd_accent wow fadeInDown" data-wow-delay="0.2s">
                            Academics
                        </p>
                        <h2 class="td_section_title td_fs_48 mb-0 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
                            Learning That Shapes Every Stage
                        </h2>
                        <p class="td_section_subtitle td_fs_18 mb-0 wow fadeInUp" data-wow-delay="0.4s">
                            AL AZHAR follows the syllabus of the Central Board of Secondary Education (CBSE), Delhi.
                            The medium of instruction is English, and the Kindergarten follows the Montessori method.
                        </p>
                    </div>

                    <ul class="acd_facts td_mp_0">
                        <li class="wow fadeInRight" data-wow-delay="0.5s">
                            <span class="acd_fact_icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8"/></svg>
                            </span>
                            <div><small>Syllabus</small><strong>CBSE, New Delhi</strong></div>
                        </li>
                        <li class="wow fadeInRight" data-wow-delay="0.6s">
                            <span class="acd_fact_icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 8h14M9 4v4M7 8c0 4 3 8 8 9M15 8c-1 4-4 7-9 9"/><path d="m13 21 4-9 4 9M14.5 18h5"/></svg>
                            </span>
                            <div><small>Medium</small><strong>English</strong></div>
                        </li>
                        <li class="wow fadeInRight" data-wow-delay="0.7s">
                            <span class="acd_fact_icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><circle cx="17.5" cy="17.5" r="3.5"/></svg>
                            </span>
                            <div><small>Kindergarten</small><strong>Montessori method</strong></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Intro -->

    <!-- Start Levels -->
    <section class="acd_levels">
        <div class="td_height_100 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase acd_accent">
                    <i></i> From First Steps to Graduation <i></i>
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">Our Academic Levels</h2>
            </div>
            <div class="td_height_50 td_height_lg_40"></div>

            <div class="acd_level_grid">
                @foreach ($levels as $i => $level)
                    <div class="acd_level wow {{ ['fadeInLeft', 'fadeInUp', 'fadeInUp', 'fadeInUp', 'fadeInRight'][$i] }}"
                        data-wow-duration="0.9s" data-wow-delay="{{ 0.1 + $i * 0.1 }}s">
                        <span class="acd_level_num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="acd_level_icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">{!! $level['icon'] !!}</svg>
                        </span>
                        <h3 class="acd_level_title">{{ $level['title'] }}</h3>
                        <p class="acd_level_sub mb-0">{{ $level['sub'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="td_height_100 td_height_lg_75"></div>
    </section>
    <!-- End Levels -->

    <!-- Start Fee Structure -->
    @if ($feeGroups->isNotEmpty())
    <section class="acd_fees" id="fee-structure">
        <div class="td_height_100 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase acd_accent">
                    <i></i> Transparent &amp; Simple <i></i>
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">Fee Structure</h2>
                <div class="d-flex justify-content-center">
                    <p class="td_section_subtitle td_fs_18 mb-0 acd_fees_intro">
                        Class-wise school fees for the academic year, payable in convenient instalments.
                    </p>
                </div>
            </div>
            <div class="td_height_50 td_height_lg_40"></div>

            <div class="acd_fees_grid">
                @foreach ($feeGroups as $group => $items)
                    @php $meta = $feeGroupMeta[$group] ?? $feeGroupMeta['Other Classes']; @endphp
                    <div class="acd_fee_card wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="{{ 0.1 + ($loop->index % 2) * 0.15 }}s">
                        <div class="acd_fee_head">
                            <span class="acd_fee_head_icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{!! $meta['icon'] !!}</svg>
                            </span>
                            <div>
                                <h3 class="acd_fee_title">{{ $group }}</h3>
                                @if ($meta['sub'])
                                    <p class="acd_fee_sub mb-0">{{ $meta['sub'] }}</p>
                                @endif
                            </div>
                        </div>

                        <table class="acd_fee_table">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th class="acd_fee_col_inst">Instalment</th>
                                    <th class="text-end">Yearly Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $fee)
                                    <tr>
                                        <td>
                                            <strong class="acd_fee_class">{{ $fee->class_name }}</strong>
                                            <span class="acd_fee_inst_m">{{ $inr($fee->fee_amount) }} × {{ $fee->installments }}</span>
                                        </td>
                                        <td class="acd_fee_col_inst">
                                            {{ $inr($fee->fee_amount) }} <span class="acd_fee_times">× {{ $fee->installments }}</span>
                                        </td>
                                        <td class="text-end"><span class="acd_fee_total">{{ $inr($fee->total_amount) }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>

            <div class="acd_fees_note wow fadeInUp" data-wow-delay="0.3s">
                <span class="acd_fees_note_icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                </span>
                <p class="mb-0">
                    Fees are paid in instalments as shown; the yearly total is the instalment amount multiplied by the number of instalments.
                    Fees are subject to revision. For details, please <a href="{{ route('contact.index') }}">contact the school office</a>.
                </p>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_75"></div>
    </section>
    @endif
    <!-- End Fee Structure -->

    <!-- Start Board Examinations -->
    <section class="td_accent_bg td_shape_section_1 acd_board">
        <div class="td_height_100 td_height_lg_75"></div>
        <div class="container">
            <div class="row td_gap_y_40 align-items-center">
                <div class="col-lg-5">
                    <p class="acd_board_badge wow fadeInDown" data-wow-delay="0.2s">Board Examinations</p>
                    <h2 class="td_fs_48 td_white_color td_mb_20 acd_board_title wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                        Board Examination and Subjects
                    </h2>
                    <p class="td_fs_18 td_white_color td_opacity_8 mb-0 acd_board_text wow fadeInUp" data-wow-delay="0.4s">
                        The Board examinations for the X and XII standards are held in March. The School endeavours
                        to ensure excellent performance of the students in these examinations.
                    </p>
                    <div class="acd_board_month wow zoomIn" data-wow-delay="0.55s">
                        <span class="acd_board_month_icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                        </span>
                        <span><small>Exams held in</small><strong>March</strong></span>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="row td_gap_y_30">
                        {{-- CBSE X --}}
                        <div class="col-md-6 wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.3s">
                            <div class="acd_pattern">
                                <div class="acd_pattern_head">
                                    <span class="acd_pattern_std">X</span>
                                    <div>
                                        <small>CBSE</small>
                                        <h3>X Standard Pattern</h3>
                                    </div>
                                </div>
                                <ul class="acd_pattern_list td_mp_0">
                                    <li>
                                        <strong>Languages</strong>
                                        <span>English, Malayalam, Hindi and Arabic</span>
                                    </li>
                                    <li>
                                        <strong>Subjects</strong>
                                        <span>Mathematics, Science and Social Science</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- CBSE XII --}}
                        <div class="col-md-6 wow fadeInRight" data-wow-duration="0.9s" data-wow-delay="0.45s">
                            <div class="acd_pattern">
                                <div class="acd_pattern_head">
                                    <span class="acd_pattern_std">XII</span>
                                    <div>
                                        <small>CBSE</small>
                                        <h3>XII Standard Pattern</h3>
                                    </div>
                                </div>
                                <ul class="acd_pattern_list td_mp_0">
                                    <li>
                                        <strong>Language</strong>
                                        <span>English Core</span>
                                    </li>
                                    <li>
                                        <strong>Science Stream A</strong>
                                        <span>Physics, Chemistry, Biology and Mathematics</span>
                                    </li>
                                    <li>
                                        <strong>Science Stream B</strong>
                                        <span>Physics, Chemistry, Biology and Computer Science</span>
                                    </li>
                                    <li>
                                        <strong>Commerce Stream</strong>
                                        <span>Accountancy, Business Studies, Economics, Computer Science / Mathematics</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_75"></div>
    </section>
    <!-- End Board Examinations -->

    <!-- Start Kindergarten & Primary -->
    <section class="acd_primary">
        <div class="td_height_100 td_height_lg_75"></div>
        <div class="container">
            <div class="row td_gap_y_40">
                <div class="col-lg-7">
                    <div class="td_section_heading td_style_1 td_mb_30">
                        <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase acd_accent wow fadeInDown" data-wow-delay="0.2s">
                            The Pride of Al Azhar
                        </p>
                        <h2 class="td_section_title td_fs_48 mb-0 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                            Kindergarten and the Primary Levels
                        </h2>
                    </div>

                    <div class="acd_text wow fadeInUp" data-wow-delay="0.4s">
                        <p>
                            The primary division is the pride of Al Azhar. Under the loving wings of the primary teachers,
                            the children learn about the world around them through real-life experiences in a fun and
                            friendly environment.
                        </p>
                        <p>
                            Apart from providing a strong academic base in languages, numeracy and general awareness, the
                            school also instils in the children ethics and morality, civility, kindness, discipline and honesty.
                            Emphasis is given to nurturing the children to become confident, happy and curious souls so that
                            they develop a lifelong love of learning.
                        </p>
                    </div>

                    <div class="acd_basics">
                        @foreach (['Languages', 'Numeracy', 'General Awareness'] as $b)
                            <span class="acd_basic wow zoomIn" data-wow-delay="{{ 0.5 + $loop->index * 0.1 }}s">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                {{ $b }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-5">
                    {{-- Values card --}}
                    <div class="acd_values wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
                        <h3 class="acd_values_title">Values We Instil</h3>
                        <ul class="acd_values_list td_mp_0">
                            @foreach ($values as $v)
                                <li class="wow fadeInUp" data-wow-delay="{{ 0.45 + $loop->index * 0.08 }}s">
                                    <span class="acd_values_dot"></span>{{ $v }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Character building --}}
                    <div class="acd_character wow zoomIn" data-wow-duration="1s" data-wow-delay="0.5s">
                        <span class="acd_character_icon">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.5-1.5 3-3.2 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.8 0-3 .5-4.5 2-1.5-1.5-2.7-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4 3 5.5l7 7z"/></svg>
                        </span>
                        <div>
                            <h3 class="td_fs_20 td_semibold td_white_color td_mb_10">Character Building</h3>
                            <p class="td_white_color td_opacity_8 mb-0">
                                Teachers give individual attention to mould the character of every student by instilling
                                righteousness and God-consciousness in their hearts.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_75"></div>
    </section>
    <!-- End Kindergarten & Primary -->

    <!-- Start CTA -->
    <section class="acd_cta_wrap">
        <div class="container">
            <div class="acd_cta wow zoomIn" data-wow-duration="1s" data-wow-delay="0.2s">
                <div>
                    <h2 class="td_fs_36 td_white_color td_mb_10">Begin Your Child's Journey With Us</h2>
                    <p class="td_fs_18 td_white_color td_opacity_8 mb-0">Admissions are open from Pre-KG to Grade XII.</p>
                </div>
                <a href="{{ route('admission') }}" class="acd_cta_btn">
                    <span>Admission Details</span>
                    <span class="acd_cta_btn_icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </span>
                </a>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_75"></div>
    </section>
    <!-- End CTA -->

@endsection

@push('styles')
<style>
    /* Uses --heading-color (site blue) because --accent-color is broken under td_theme_2 */
    .acd_intro, .acd_levels, .acd_fees, .acd_board, .acd_primary, .acd_cta_wrap {
        --acd: var(--heading-color, #00539B);
        --acd-dark: #002F5F;
        --acd-soft: #F4F7FB;
        --acd-line: #E6EAF2;
    }
    .acd_accent { color: var(--acd); }
    .td_section_heading .acd_accent i::before,
    .td_section_heading .acd_accent i::after { background-color: var(--acd); }

    /* Page heading: fix the theme's breadcrumb separator (same as other pages) */
    .td_page_heading .breadcrumb-item + .breadcrumb-item::before { content: "/" !important; color: #fff; padding: 0 8px; }

    /* ---------- Intro ---------- */
    .acd_photo { position: relative; padding: 0 0 40px 0; }
    .acd_photo img {
        width: 100%; aspect-ratio: 4 / 3; object-fit: cover; display: block;
        border-radius: 20px; box-shadow: 0 30px 60px -35px rgba(0, 0, 27, .6);
    }
    .acd_photo::before {
        content: ""; position: absolute; inset: 30px -18px 18px 30px; border-radius: 20px;
        border: 2px dashed rgba(0, 83, 155, .25); z-index: -1;
    }
    .acd_photo_badge {
        position: absolute; left: 24px; bottom: 0; display: flex; align-items: center; gap: 14px;
        padding: 14px 22px 14px 14px; border-radius: 16px; background: #fff;
        box-shadow: 0 20px 40px -20px rgba(0, 0, 27, .45);
    }
    .acd_photo_badge_icon {
        width: 48px; height: 48px; border-radius: 12px; flex: none;
        display: flex; align-items: center; justify-content: center; background: var(--acd); color: #fff;
    }
    .acd_photo_badge strong { display: block; color: var(--acd); font-size: 20px; line-height: 1.1; }
    .acd_photo_badge small { display: block; color: #6b7489; font-size: 13px; }

    .acd_facts li { display: flex; align-items: center; gap: 14px; padding: 14px 0; border-bottom: 1px solid var(--acd-line); }
    .acd_facts li:last-child { border-bottom: 0; }
    .acd_fact_icon {
        width: 46px; height: 46px; border-radius: 50%; flex: none;
        display: flex; align-items: center; justify-content: center; background: var(--acd-soft); color: var(--acd);
    }
    .acd_facts small { display: block; font-size: 13px; color: #6b7489; }
    .acd_facts strong { color: var(--acd); font-weight: 600; font-size: 17px; }

    /* ---------- Levels ---------- */
    .acd_levels { background: #F6F8FB; }
    .acd_level_grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px; }
    .acd_level {
        position: relative; overflow: hidden; text-align: center;
        padding: 34px 20px 28px; border-radius: 18px; background: #fff;
        border: 1px solid var(--acd-line); border-bottom: 4px solid var(--acd);
        box-shadow: 0 18px 40px -30px rgba(0, 0, 27, .45);
        transition: transform .35s ease, box-shadow .35s ease;
    }
    .acd_level.animated { animation-fill-mode: backwards; }
    .acd_level:hover { transform: translateY(-8px); box-shadow: 0 28px 50px -30px rgba(0, 0, 27, .55); }
    .acd_level_num {
        position: absolute; top: 12px; right: 16px; font-size: 34px; font-weight: 700;
        color: var(--acd); opacity: .08; line-height: 1;
    }
    .acd_level_icon {
        width: 70px; height: 70px; margin: 0 auto 18px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: var(--acd-soft); color: var(--acd); transition: background .35s ease, color .35s ease;
    }
    .acd_level:hover .acd_level_icon { background: var(--acd); color: #fff; }
    .acd_level_title { font-size: 19px; font-weight: 600; color: var(--acd); margin: 0 0 6px; line-height: 1.3; }
    .acd_level_sub { font-size: 14px; color: #6b7489; }

    /* ---------- Fee structure ---------- */
    .acd_fees_intro { max-width: 640px; }
    .acd_fees_grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; align-items: start; }
    .acd_fee_card {
        background: #fff; border: 1px solid var(--acd-line); border-radius: 18px; overflow: hidden;
        box-shadow: 0 24px 50px -36px rgba(0, 0, 27, .45);
    }
    .acd_fee_head {
        display: flex; align-items: center; gap: 14px; padding: 20px 24px;
        background: var(--acd-soft); border-bottom: 1px solid var(--acd-line);
    }
    .acd_fee_head_icon {
        width: 50px; height: 50px; border-radius: 14px; flex: none;
        display: flex; align-items: center; justify-content: center; background: var(--acd); color: #fff;
    }
    .acd_fee_title { margin: 0; font-size: 20px; font-weight: 600; color: var(--acd); line-height: 1.3; }
    .acd_fee_sub { font-size: 14px; color: #6b7489; }

    .acd_fee_table { width: 100%; border-collapse: collapse; margin: 0; }
    .acd_fee_table th {
        padding: 14px 24px 10px; font-size: 12px; font-weight: 600; letter-spacing: 1px;
        text-transform: uppercase; color: #8a93a6; text-align: left; border: 0;
    }
    .acd_fee_table th.text-end, .acd_fee_table td.text-end { text-align: right; }
    .acd_fee_table td {
        padding: 14px 24px; border: 0; border-top: 1px solid var(--acd-line);
        color: #3d4556; vertical-align: middle;
    }
    .acd_fee_table tbody tr { transition: background .25s ease; }
    .acd_fee_table tbody tr:hover { background: #FAFBFD; }
    .acd_fee_class { color: var(--acd); font-weight: 600; }
    .acd_fee_times { color: #8a93a6; font-size: 14px; }
    .acd_fee_total {
        display: inline-block; padding: 5px 12px; border-radius: 20px;
        background: var(--acd-soft); color: var(--acd); font-weight: 700; white-space: nowrap;
    }
    .acd_fee_inst_m { display: none; font-size: 13px; color: #8a93a6; margin-top: 2px; }

    .acd_fees_note {
        display: flex; align-items: flex-start; gap: 12px; margin-top: 30px;
        padding: 16px 20px; border-radius: 14px; background: var(--acd-soft); color: #5b6477; font-size: 15px;
    }
    .acd_fees_note_icon { color: var(--acd); flex: none; margin-top: 1px; }
    .acd_fees_note a { color: var(--acd); font-weight: 600; text-decoration: underline; }

    /* ---------- Board examinations ---------- */
    .acd_board { position: relative; overflow: hidden; }
    .acd_board::before, .acd_board::after {
        content: ""; position: absolute; border-radius: 50%; background: rgba(255,255,255,.06); pointer-events: none;
    }
    .acd_board::before { width: 420px; height: 420px; top: -160px; right: -120px; }
    .acd_board::after  { width: 260px; height: 260px; bottom: -120px; left: -80px; }
    .acd_board .container { position: relative; z-index: 1; }
    .acd_board_badge {
        display: inline-block; margin: 0 0 18px; padding: 8px 18px; border-radius: 30px;
        background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.25);
        color: #fff; font-size: 14px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;
    }
    .acd_board_title { line-height: 1.2; }
    .acd_board_text { line-height: 1.7; }
    .acd_board_month {
        display: inline-flex; align-items: center; gap: 14px; margin-top: 30px;
        padding: 12px 22px 12px 12px; border-radius: 16px;
        background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); color: #fff;
    }
    .acd_board_month_icon {
        width: 46px; height: 46px; border-radius: 12px; flex: none;
        display: flex; align-items: center; justify-content: center; background: #fff; color: var(--acd);
    }
    .acd_board_month small { display: block; font-size: 13px; opacity: .75; }
    .acd_board_month strong { font-size: 20px; }

    .acd_pattern {
        height: 100%; padding: 30px 26px; border-radius: 18px; background: #fff;
        box-shadow: 0 30px 60px -30px rgba(0,0,0,.45);
    }
    .acd_pattern_head {
        display: flex; align-items: center; gap: 14px; margin-bottom: 20px;
        padding-bottom: 18px; border-bottom: 1px solid var(--acd-line);
    }
    .acd_pattern_std {
        min-width: 56px; height: 56px; padding: 0 10px; border-radius: 14px; flex: none;
        display: flex; align-items: center; justify-content: center;
        background: var(--acd); color: #fff; font-size: 22px; font-weight: 700;
    }
    .acd_pattern_head small { display: block; font-size: 13px; font-weight: 600; letter-spacing: 1px; color: #6b7489; }
    .acd_pattern_head h3 { margin: 0; font-size: 21px; font-weight: 600; color: var(--acd); line-height: 1.3; }
    .acd_pattern_list li { position: relative; padding-left: 28px; }
    .acd_pattern_list li + li { margin-top: 14px; }
    .acd_pattern_list li::before {
        content: ""; position: absolute; left: 0; top: 4px; width: 18px; height: 18px; border-radius: 50%;
        background: var(--acd) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 6 9 17l-5-5'/%3E%3C/svg%3E") center / 11px no-repeat;
    }
    .acd_pattern_list strong { display: block; color: var(--acd); font-weight: 600; }
    .acd_pattern_list span { display: block; color: #5b6477; font-size: 15px; line-height: 1.55; }

    /* ---------- Kindergarten & primary ---------- */
    .acd_text p { font-size: 17px; line-height: 1.85; color: #3d4556; margin-bottom: 16px; }
    .acd_text p:last-child { margin-bottom: 0; }
    .acd_basics { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 26px; }
    .acd_basic {
        display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 30px;
        background: var(--acd-soft); color: var(--acd); font-weight: 600; font-size: 15px;
    }

    .acd_values {
        padding: 30px 28px; border-radius: 18px; background: #fff;
        border: 1px solid var(--acd-line); border-top: 4px solid var(--acd);
        box-shadow: 0 24px 50px -34px rgba(0,0,27,.45);
    }
    .acd_values_title {
        font-size: 22px; font-weight: 600; color: var(--acd); margin: 0 0 16px;
        padding-bottom: 14px; border-bottom: 1px solid var(--acd-line);
    }
    .acd_values_list { display: flex; flex-wrap: wrap; gap: 10px; }
    .acd_values_list li {
        display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 30px;
        border: 1px solid var(--acd-line); color: var(--acd); font-weight: 500;
    }
    .acd_values_dot { width: 8px; height: 8px; border-radius: 50%; background: var(--acd); flex: none; }

    .acd_character {
        display: flex; gap: 18px; margin-top: 24px; padding: 28px 26px; border-radius: 18px;
        position: relative; overflow: hidden;
        background: linear-gradient(135deg, var(--acd) 0%, var(--acd-dark) 100%);
    }
    .acd_character::after {
        content: ""; position: absolute; width: 180px; height: 180px; border-radius: 50%;
        right: -60px; top: -60px; background: rgba(255,255,255,.08);
    }
    .acd_character > * { position: relative; z-index: 1; }
    .acd_character_icon {
        width: 54px; height: 54px; border-radius: 14px; flex: none;
        display: flex; align-items: center; justify-content: center; background: #fff; color: var(--acd);
    }
    .acd_character p { line-height: 1.7; }

    /* ---------- CTA ---------- */
    .acd_cta {
        display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap;
        padding: 44px 50px; border-radius: 22px; position: relative; overflow: hidden;
        background: linear-gradient(135deg, var(--acd) 0%, var(--acd-dark) 100%);
        box-shadow: 0 30px 60px -35px rgba(0,47,95,.8);
    }
    .acd_cta::before {
        content: ""; position: absolute; width: 300px; height: 300px; border-radius: 50%;
        right: -90px; top: -120px; background: rgba(255,255,255,.07);
    }
    .acd_cta > * { position: relative; z-index: 1; }
    .acd_cta_btn {
        display: inline-flex; align-items: center; gap: 12px; flex: none;
        padding: 6px 6px 6px 24px; border-radius: 30px; background: #fff;
        color: var(--acd); font-weight: 600; transition: box-shadow .3s ease, transform .3s ease;
    }
    .acd_cta_btn_icon {
        width: 40px; height: 40px; border-radius: 50%; flex: none;
        display: flex; align-items: center; justify-content: center;
        background: var(--acd); color: #fff; transition: transform .3s ease;
    }
    .acd_cta_btn:hover { color: var(--acd); transform: translateY(-2px); box-shadow: 0 14px 28px -14px rgba(0,0,0,.5); }
    .acd_cta_btn:hover .acd_cta_btn_icon { transform: translateX(4px) rotate(-45deg); }

    /* ---------- Responsive ---------- */
    @media (min-width: 992px) {
        .acd_intro_text { padding-left: 60px; }
    }
    @media (min-width: 1400px) {
        .acd_intro_text { padding-left: 80px; }
    }
    @media (max-width: 1199px) {
        .acd_level_grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 991px) {
        .acd_photo::before { display: none; }
        .acd_cta { padding: 36px 30px; }
        .acd_fees_grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 767px) {
        .acd_level_grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
        .acd_level { padding: 26px 14px 22px; }
        .acd_level:hover { transform: none; }
        .acd_level_icon { width: 58px; height: 58px; }
        .acd_level_title { font-size: 16px; }
    }
    @media (max-width: 575px) {
        .acd_photo_badge { left: 12px; padding: 10px 16px 10px 10px; }
        .acd_pattern { padding: 24px 18px; }
        .acd_character { flex-direction: column; padding: 24px 20px; }
        .acd_cta { padding: 30px 20px; }
        .acd_cta_btn { width: 100%; justify-content: space-between; }

        .acd_fee_head { padding: 16px 18px; }
        .acd_fee_table th, .acd_fee_table td { padding-left: 18px; padding-right: 18px; }
        .acd_fee_col_inst { display: none; }
        .acd_fee_inst_m { display: block; }
    }
    @media (max-width: 420px) {
        .acd_level_grid { grid-template-columns: 1fr; }
    }
</style>
@endpush