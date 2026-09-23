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

@section('title', $pageName . ' || Educve')
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

    /* Hero */
    .dept_hero { position: relative; padding: 220px 0 90px; background-size: cover; background-position: center; overflow: hidden; }
    .dept_hero::before { content: ""; position: absolute; inset: 0;
        background: linear-gradient(90deg, rgba(13,27,76,.95) 0%, rgba(13,27,76,.75) 60%, rgba(13,27,76,.6) 100%); }
    .dept_hero .container { position: relative; z-index: 1; }
    .dept_breadcrumb { display: flex; align-items: center; gap: 6px; list-style: none; padding: 0; margin: 0 0 8px;
        color: rgba(255,255,255,.85); font-size: 15px; }
    .dept_breadcrumb a { color: #fff; }
    .dept_hero h1 { color: #fff; font-size: 48px; font-weight: 700; margin: 0 0 12px; }
    .dept_hero p { color: rgba(255,255,255,.85); font-size: 17px; margin: 0; }
        .dept_hero_dots {
        position: absolute; right: 40px; top: 60%; transform: translateY(-50%);
        display: grid; grid-template-columns: repeat(6, 6px); gap: 14px; z-index: 1;
    }
    .dept_hero_dots span { width: 5px; height: 5px; border-radius: 50%; background: rgba(255,255,255,.7); }

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
        .dept_hero h1 { font-size: 36px; }
        .dept_hero_dots { display: none; }
         .dept_hero { padding: 160px 0 60px; }
    }
    @media (max-width: 575px) {
        .dept_members { grid-template-columns: repeat(2, 1fr); gap: 14px; }
        .dept_section_top { flex-direction: column; }
        .dept_title { font-size: 26px; }
    }
</style>
@endpush

@section('content')

    <!-- Hero -->
    <section class="dept_hero"
        style="background-image: url('{{ asset('uploads/website-images/students-after-graduation-ceremony.jpg') }}');">
        <div class="container">
            <ol class="dept_breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>&rsaquo;</li>
                @if ($isSingle)
                    <li><a href="{{ route('departments.index') }}">Departments</a></li>
                    <li>&rsaquo;</li>
                    <li>{{ $pageName }}</li>
                @else
                    <li>Departments</li>
                @endif
            </ol>
            <h1>{{ $pageName }}</h1>
            <p>{{ $isSingle ? 'Meet the team behind the department.' : 'Explore our departments and learn from industry experts.' }}</p>
        </div>
        <div class="dept_hero_dots">
            @for ($i = 0; $i < 36; $i++)
                <span></span>
            @endfor
        </div>
    </section>

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
                        <div>
                            <span class="dept_label">Our Department</span>
                            <h2 class="dept_title">{{ $department->name }}</h2>
                            @if (!empty($department->description))
                                <p class="dept_tagline">{{ \Illuminate\Support\Str::limit(strip_tags($department->description), 120) }}</p>
                            @endif
                        </div>

                        @unless ($isSingle)
                            <a href="{{ route('departments.show', $department) }}" class="dept_viewall">
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
                        <div class="dept_head_card wow fadeInUp" data-wow-duration="1s">
                            <span class="dept_badge">Department Head</span>
                            <img src="{{ $photo($head) }}" alt="{{ $head->name }}" loading="lazy">
                            <div class="dept_head_info">
                                <h3>{{ $head->name }}</h3>
                                <p>{{ $head->designation }}</p>
                            </div>
                        </div>

                        {{-- Other members --}}
                        @if ($others->isNotEmpty())
                            <div class="dept_members">
                                @foreach ($others as $member)
                                    <div class="dept_member_card wow fadeInUp" data-wow-duration="1s"
                                        data-wow-delay="{{ 0.05 * ($loop->index % 6) }}s">
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
            <div class="container dept_empty">
                <h3>No staff have been assigned to this department yet.</h3>
                <a href="{{ route('departments.index') }}" class="dept_viewall mt-3">Back to departments</a>
            </div>
        @endif
    @empty
        <div class="container dept_empty">
            <h3>No departments to show yet.</h3>
            <p>Add departments and assign staff from the admin panel.</p>
        </div>
    @endforelse

@endsection