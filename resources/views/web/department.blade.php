{{--
    Departments page (one file).

    List page  (/departments)       : $departments = collection, $limit = 6
    Single page (/departments/{id}) : $departments = collection with ONE department, $limit = null
--}}
@extends('web.layouts.app')

@php
    $isSingle = is_null($limit);
    $pageName = $isSingle ? $departments->first()->name : 'Our Departments';

    // Grey avatar shown when a staff member has no photo
    $placeholder = 'data:image/svg+xml;utf8,' . rawurlencode(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><rect width="200" height="200" fill="#eef0f7"/><circle cx="100" cy="78" r="36" fill="#c9cde0"/><path d="M36 190c6-42 34-64 64-64s58 22 64 64z" fill="#c9cde0"/></svg>'
    );
    $photo = fn ($member) => $member->photo ? asset('storage/' . $member->photo) : $placeholder;
@endphp

@section('title', $pageName . ' || AL-Azhar')
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
    .dept_section { padding: 36px 0; border-bottom: 1px solid var(--dept-line); }
    .dept_section:nth-of-type(even) { background: #fbfaff; }
    .dept_section_top { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 20px; }
    .dept_label { display: inline-block; background: var(--dept-accent-soft); color: var(--dept-accent);
        font-size: 12px; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; padding: 3px 10px; border-radius: 6px; }
    .dept_title { font-size: 34px; font-weight: 700; color: var(--dept-navy); margin: 6px 0 4px; }
    .dept_tagline { color: var(--dept-muted); margin: 0; }
    .dept_viewall { display: inline-flex; align-items: center; gap: 6px; flex-shrink: 0;
        background: var(--dept-accent-soft); color: var(--dept-accent); font-weight: 600;
        padding: 8px 18px; border-radius: 30px; transition: .2s; }
    .dept_viewall:hover { background: var(--dept-accent); color: #fff; }

    /* Layout */
    .dept_grid { display: grid; grid-template-columns: 1.3fr 3fr; gap: 24px; align-items: start; }
    .dept_grid_single { grid-template-columns: minmax(0, 360px); }

    /* Head card */
    .dept_head_card { position: relative; padding-bottom: 40px; }
    .dept_head_card img { width: 100%; height: 390px; object-fit: cover; object-position: top;
        border-radius: 16px; display: block; background: #eef0f7; }
    .dept_badge { position: absolute; top: 14px; left: 14px; z-index: 1; background: var(--dept-accent); color: #fff;
        font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 6px; }
    .dept_head_info { position: absolute; left: 16px; right: 16px; bottom: 0; background: #fff; border-radius: 40px;
        text-align: center; padding: 18px 16px; box-shadow: 0 10px 30px rgba(13,27,76,.12); }
    .dept_head_info h3 { font-size: 20px; font-weight: 700; color: var(--dept-navy); margin: 0 0 4px; }
    .dept_head_info p { color: var(--dept-muted); margin: 0; }

    /* Member cards */
    .dept_members { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
    .dept_member_img img { width: 100%; aspect-ratio: 4 / 3; object-fit: cover; object-position: top;
        border-radius: 12px; display: block; background: #eef0f7; }
    .dept_member_info { position: relative; margin: -38px 10px 0; background: #fff; border-radius: 30px;
        text-align: center; padding: 10px 8px; box-shadow: 0 8px 22px rgba(13,27,76,.1); }
    .dept_member_info h4 { font-size: 15px; font-weight: 700; color: var(--dept-navy); margin: 0 0 2px; }
    .dept_member_info p { font-size: 13px; color: var(--dept-muted); margin: 0; }

    .dept_empty { padding: 80px 0; text-align: center; color: var(--dept-muted); }

    /* Responsive */
    @media (max-width: 991px) {
        .dept_grid { grid-template-columns: 1fr; }
        .dept_head_card { max-width: 420px; }
    }
    @media (max-width: 575px) {
        .dept_members { grid-template-columns: repeat(2, 1fr); gap: 14px; }
        .dept_section_top { flex-direction: column; }
        .dept_title { font-size: 26px; }
    }
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

    @forelse ($departments as $department)
        @php
            $staff  = $department->staff;
            $head   = $staff->firstWhere('is_head_of_staff', true) ?? $staff->first();
            $others = $staff->reject(fn ($member) => $member->is($head))->values();
            if ($limit) {
                $others = $others->take($limit);
            }
        @endphp

        @if ($head)
            <section class="dept_section">
                <div class="container">
                    <div class="dept_section_top">
                        <div class="wow fadeInLeft" data-wow-duration="0.9s" data-wow-delay="0.1s">
                            <span class="dept_label">Our Department</span>
                            <h2 class="dept_title">{{ $department->name }}</h2>
                            @if (!empty($department->description))
                                <p class="dept_tagline">{{ \Illuminate\Support\Str::limit(strip_tags($department->description), 120) }}</p>
                            @endif
                        </div>

                        @unless ($isSingle)
                            <a href="{{ route('departments.show', $department) }}" class="dept_viewall wow zoomIn" data-wow-delay="0.3s">
                                View All
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14M13 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endunless
                    </div>

                    <div class="dept_grid {{ $others->isEmpty() ? 'dept_grid_single' : '' }}">
                        {{-- Department head --}}
                        <div class="dept_head_card wow zoomIn" data-wow-duration="1s" data-wow-delay="0.2s">
                            <span class="dept_badge">Department Head</span>
                            <img src="{{ $photo($head) }}" alt="{{ $head->name }}" loading="lazy">
                            <div class="dept_head_info">
                                <h3>{{ $head->name }}</h3>
                                <p>{{ $head->designation }}</p>
                            </div>
                        </div>

                        {{-- Other members: left / up / right across each row of three --}}
                        @if ($others->isNotEmpty())
                            <div class="dept_members">
                                @foreach ($others as $member)
                                    <div class="dept_member_card wow {{ ['fadeInLeft', 'fadeInUp', 'fadeInRight'][$loop->index % 3] }}"
                                        data-wow-duration="0.9s" data-wow-delay="{{ 0.2 + ($loop->index % 3) * 0.12 }}s">
                                        <div class="dept_member_img">
                                            <img src="{{ $photo($member) }}" alt="{{ $member->name }}" loading="lazy">
                                        </div>
                                        <div class="dept_member_info">
                                            <h4>{{ $member->name }}</h4>
                                            <p>{{ $member->designation }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @else
            <div class="container dept_empty wow fadeInUp">
                <h3>No staff have been assigned to this department yet.</h3>
                <a href="{{ route('departments.index') }}" class="dept_viewall mt-3">Back to departments</a>
            </div>
        @endif
    @empty
        <div class="container dept_empty wow fadeInUp">
            <h3>No departments to show yet.</h3>
            <p>Add departments and assign staff from the admin panel.</p>
        </div>
    @endforelse

@endsection