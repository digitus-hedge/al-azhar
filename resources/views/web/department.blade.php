{{--
    Departments page (one file).

    Variables from App\Http\Controllers\Web\DepartmentController:
      $pageName   : page heading
      $department : Department model on /departments/{id}, null on /departments
      $groups     : [ ['key' => 'HOD', 'label' => 'Head of Department', 'people' => Collection], ['key' => 'HOS', ...] ]

    Every person is shown in the same-size card (department-head style).
--}}
@extends('web.layouts.app')

@php
    $isSingle = ! is_null($department);

    // Grey avatar shown when a person has no photo
    $placeholder = 'data:image/svg+xml;utf8,' . rawurlencode(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><rect width="200" height="200" fill="#eef0f7"/><circle cx="100" cy="78" r="36" fill="#c9cde0"/><path d="M36 190c6-42 34-64 64-64s58 22 64 64z" fill="#c9cde0"/></svg>'
    );
    $photo = fn ($member) => $member->photo ? asset('storage/' . $member->photo) : $placeholder;

    $hasPeople = $groups->contains(fn ($g) => $g['people']->isNotEmpty());
@endphp

@section('title', $pageName . ' || Al Azhar Central School, Mala')
@section('meta_description', $isSingle
    ? 'Head of Department and Head of Staff for ' . $pageName . ' at Al Azhar Central School, Mala.'
    : 'Meet the Heads of Department and Heads of Staff at Al Azhar Central School, Mala.')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@push('styles')
<style>
    :root {
        --dept-accent: #4f3ee8;
        --dept-accent-soft: #ece9ff;
        --dept-navy: #0d1b4c;
        --dept-muted: #5b6280;
        --dept-line: #eceaf8;
    }

    /* Page heading: fix the theme's breadcrumb separator (same as other pages) */
    .td_page_heading .breadcrumb-item + .breadcrumb-item::before { content: "/" !important; color: #fff; padding: 0 8px; }

    /* Section */
    .dept_section { padding: 48px 0; border-bottom: 1px solid var(--dept-line); }
    .dept_section:nth-of-type(even) { background: #fbfaff; }
    .dept_section_top { margin-bottom: 28px; }
    .dept_label { display: inline-block; background: var(--dept-accent-soft); color: var(--dept-accent);
        font-size: 12px; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; padding: 3px 10px; border-radius: 6px; }
    .dept_title { font-size: 34px; font-weight: 700; color: var(--dept-navy); margin: 6px 0 4px; }
    .dept_tagline { color: var(--dept-muted); margin: 0; max-width: 760px; }

    /* People: every card the same size (department-head style) */
    .dept_people { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 30px 24px; }
    .dept_card { position: relative; padding-bottom: 46px; }
    .dept_card_img { position: relative; overflow: hidden; border-radius: 16px; background: #eef0f7; }
    .dept_card_img img { width: 100%; aspect-ratio: 4 / 5; object-fit: cover; object-position: top;
        display: block; transition: transform .6s ease; }
    .dept_card:hover .dept_card_img img { transform: scale(1.05); }
    .dept_badge { position: absolute; top: 14px; left: 14px; z-index: 1; background: var(--dept-accent); color: #fff;
        font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 6px; }
    .dept_card_info { position: absolute; left: 16px; right: 16px; bottom: 0; background: #fff; border-radius: 40px;
        text-align: center; padding: 14px 14px; box-shadow: 0 10px 30px rgba(13,27,76,.12); }
    .dept_card_info h3 { font-size: 18px; font-weight: 700; color: var(--dept-navy); margin: 0 0 3px; line-height: 1.3; }
    .dept_card_info p { font-size: 14px; color: var(--dept-muted); margin: 0; line-height: 1.4; }
    .dept_card_info .dept_card_dept { font-size: 13px; color: var(--dept-accent); font-weight: 600; margin-top: 2px; }

    .dept_empty { padding: 80px 0; text-align: center; color: var(--dept-muted); }
    .dept_back { display: inline-flex; align-items: center; gap: 6px; margin-top: 12px;
        background: var(--dept-accent-soft); color: var(--dept-accent); font-weight: 600;
        padding: 8px 18px; border-radius: 30px; transition: .2s; }
    .dept_back:hover { background: var(--dept-accent); color: #fff; }

    /* Responsive */
    @media (max-width: 1199px) { .dept_people { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
    @media (max-width: 767px) {
        .dept_people { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 22px 14px; }
        .dept_card { padding-bottom: 40px; }
        .dept_card_info { left: 8px; right: 8px; padding: 10px 8px; border-radius: 24px; }
        .dept_card_info h3 { font-size: 15px; }
        .dept_card_info p { font-size: 12.5px; }
        .dept_card_info .dept_card_dept { font-size: 12px; }
        .dept_badge { top: 10px; left: 10px; font-size: 11px; }
        .dept_title { font-size: 26px; }
    }
    @media (max-width: 399px) { .dept_people { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('images/header.jpeg') }}"
    style="background-image: url('{{ asset('images/header.jpeg') }}');">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10 wow fadeInDown" data-wow-duration="0.9s" data-wow-delay="0.2s">{{ $pageName }}</h1>
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

    @if ($hasPeople)
        @foreach ($groups as $group)
            @continue($group['people']->isEmpty())

            <section class="dept_section">
                <div class="container">
                    <div class="dept_section_top wow fadeInLeft" data-wow-duration="0.9s" data-wow-delay="0.1s">
                        <span class="dept_label">{{ $group['key'] }}</span>
                        <h2 class="dept_title">{{ \Illuminate\Support\Str::plural($group['label']) }}</h2>
                        @if ($isSingle && !empty($department->description))
                            <p class="dept_tagline">{{ \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($department->description))), 160) }}</p>
                        @endif
                    </div>

                    <div class="dept_people">
                        @foreach ($group['people'] as $member)
                            <div class="dept_card wow {{ ['fadeInLeft', 'fadeInUp', 'fadeInUp', 'fadeInRight'][$loop->index % 4] }}"
                                data-wow-duration="0.9s" data-wow-delay="{{ 0.15 + ($loop->index % 4) * 0.1 }}s">
                                <div class="dept_card_img">
                                    <img src="{{ $photo($member) }}" alt="{{ $member->name }}" loading="lazy">
                                </div>
                                <div class="dept_card_info">
                                    <h3>{{ $member->name }}</h3>
                                    @if ($member->designation)
                                        <p>{{ $member->designation }}</p>
                                    @endif
                                    @if (! $isSingle && $member->department)
                                        <p class="dept_card_dept">{{ $member->department->name }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endforeach
    @else
        <div class="container dept_empty wow fadeInUp">
            <h3>No Heads of Department or Heads of Staff to show yet.</h3>
            <p>Set the "Head Type" (HOD / HOS) for staff members in the admin panel.</p>
            @if ($isSingle)
                <a href="{{ route('departments.index') }}" class="dept_back">Back to departments</a>
            @endif
        </div>
    @endif

@endsection