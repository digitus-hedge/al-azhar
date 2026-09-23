@extends('web.layouts.app')

@section('title', 'Events || AL-Azhar')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@php
    // Shown when an event has no image
    $eventPlaceholder = 'data:image/svg+xml;utf8,' . rawurlencode(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 500"><rect width="800" height="500" fill="#eef0f7"/><g fill="none" stroke="#c3c8dc" stroke-width="14" stroke-linecap="round" stroke-linejoin="round"><rect x="300" y="160" width="200" height="180" rx="18"/><path d="M300 210h200M350 140v40M450 140v40"/></g></svg>'
    );
@endphp

@section('content')

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
        data-src="{{ asset('uploads/website-images/students-after-graduation-ceremony.jpg') }}">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">Events</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Events</li>
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

    <!-- Start Event List -->
    <section>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">

            {{-- Filter tabs --}}
            <div class="event_tabs td_mb_40">
                @foreach (['all' => 'All Events', 'upcoming' => 'Upcoming', 'past' => 'Past Events'] as $key => $text)
                    <a href="{{ $key === 'all' ? route('events.index') : route('events.index', ['type' => $key]) }}"
                        class="event_tab {{ $type === $key ? 'active' : '' }}">{{ $text }}</a>
                @endforeach
            </div>

            <div class="row td_gap_y_30">
                @forelse ($events as $event)
                    @php
                        $date     = $event->event_date ? \Illuminate\Support\Carbon::parse($event->event_date) : null;
                        $time     = $event->event_time ? \Illuminate\Support\Carbon::parse($event->event_time)->format('h:i A') : null;
                        $isPast   = $date && $date->isBefore(today());
                        $link     = route('events.show', $event);
                    @endphp
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="1s"
                        data-wow-delay="{{ 0.1 + ($loop->index % 3) * 0.1 }}s">
                        <div class="td_post td_style_1 event_card">
                            <a href="{{ $link }}" class="td_post_thumb d-block">
                                <img src="{{ $event->image ? asset('storage/' . $event->image) : $eventPlaceholder }}"
                                    alt="{{ $event->title }}" loading="lazy">
                                <i class="fa-solid fa-link"></i>
                                @if ($date)
                                    <span class="event_date_badge {{ $isPast ? 'is_past' : '' }}">
                                        <strong>{{ $date->format('d') }}</strong>
                                        <small>{{ $date->format('M Y') }}</small>
                                    </span>
                                @endif
                            </a>
                            <div class="td_post_info">
                                <div class="td_post_meta td_fs_14 td_medium td_mb_20">
                                    @if ($time)
                                        <span>
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="12" r="9" />
                                                <path d="M12 7v5l3 2" />
                                            </svg>
                                            {{ $time }}
                                        </span>
                                    @endif
                                    @if ($event->venue)
                                        <span>
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 21s-7-6.2-7-11.5A7 7 0 0 1 19 9.5C19 14.8 12 21 12 21z" />
                                                <circle cx="12" cy="9.5" r="2.5" />
                                            </svg>
                                            {{ \Illuminate\Support\Str::limit($event->venue, 28) }}
                                        </span>
                                    @endif
                                </div>
                                <h2 class="td_post_title td_fs_24 td_medium td_mb_16">
                                    <a href="{{ $link }}">{{ $event->title }}</a>
                                </h2>
                                <p class="td_post_subtitle td_mb_24 td_heading_color td_opacity_7">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 110) }}
                                </p>
                                <a href="{{ $link }}" class="td_btn td_style_1 td_type_3 td_radius_30 td_medium">
                                    <span class="td_btn_in td_accent_color">
                                        <span>Read More</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center event_empty">
                        <h3 class="td_fs_24 td_mb_10">No events found</h3>
                        <p class="td_opacity_7 mb-0">
                            @if ($type === 'upcoming')
                                There are no upcoming events right now. Please check back soon.
                            @elseif ($type === 'past')
                                No past events to show yet.
                            @else
                                Events will appear here once they are added.
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($events->hasPages())
                <div class="td_height_60 td_height_lg_40"></div>
                <ul class="event_pagination">
                    <li class="{{ $events->onFirstPage() ? 'disabled' : '' }}">
                        <a href="{{ $events->previousPageUrl() ?? 'javascript:;' }}" aria-label="Previous">&lsaquo;</a>
                    </li>
                    @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                        <li class="{{ $page == $events->currentPage() ? 'active' : '' }}">
                            <a href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                    <li class="{{ $events->hasMorePages() ? '' : 'disabled' }}">
                        <a href="{{ $events->nextPageUrl() ?? 'javascript:;' }}" aria-label="Next">&rsaquo;</a>
                    </li>
                </ul>
            @endif
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Event List -->

@endsection

@push('styles')
<style>
    /* Tabs */
    .event_tabs { display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; }
    .event_tab {
        padding: 10px 24px; border-radius: 30px; font-weight: 500;
        border: 1px solid var(--accent-color); color: var(--accent-color); transition: .25s;
    }
    .event_tab:hover, .event_tab.active { background: var(--accent-color); color: #fff; }

    /* Card */
    .event_card .td_post_thumb { position: relative; }
    .event_card .td_post_thumb img { width: 100%; aspect-ratio: 8 / 5; object-fit: cover; }
    .event_date_badge {
        position: absolute; top: 16px; left: 16px; z-index: 2;
        background: var(--accent-color); color: #fff; border-radius: 10px;
        padding: 8px 12px; text-align: center; line-height: 1.1; min-width: 64px;
    }
    .event_date_badge strong { display: block; font-size: 24px; }
    .event_date_badge small { font-size: 12px; text-transform: uppercase; }
    .event_date_badge.is_past { background: #6b7280; }
    .event_card .td_post_meta span { display: inline-flex; align-items: center; gap: 6px; }
    .event_empty { padding: 60px 0; }

    /* Pagination */
    .event_pagination { display: flex; justify-content: center; gap: 8px; list-style: none; padding: 0; margin: 0; }
    .event_pagination a {
        display: flex; align-items: center; justify-content: center;
        width: 44px; height: 44px; border-radius: 50%;
        border: 1px solid #e2e4ee; color: var(--heading-color); font-weight: 500; transition: .25s;
    }
    .event_pagination li.active a, .event_pagination a:hover {
        background: var(--accent-color); border-color: var(--accent-color); color: #fff;
    }
    .event_pagination li.disabled a { opacity: .4; pointer-events: none; }
</style>
@endpush