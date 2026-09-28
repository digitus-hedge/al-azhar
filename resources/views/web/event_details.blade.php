@extends('web.layouts.app')

@section('title', $event->title . ' || AL-Azhar')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($event->description), 155))
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@section('content')
    @php
        $eventPlaceholder = 'data:image/svg+xml;utf8,' . rawurlencode(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 500"><rect width="800" height="500" fill="#eef0f7"/><g fill="none" stroke="#c3c8dc" stroke-width="14" stroke-linecap="round" stroke-linejoin="round"><rect x="300" y="160" width="200" height="180" rx="18"/><path d="M300 210h200M350 140v40M450 140v40"/></g></svg>'
        );
        $date   = $event->event_date ? \Illuminate\Support\Carbon::parse($event->event_date) : null;
        $time   = $event->event_time ? \Illuminate\Support\Carbon::parse($event->event_time)->format('h:i A') : null;
        $isPast = $date && $date->isBefore(today());
    @endphp

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('images/header.jpeg') }}"
    style="background-image: url('{{ asset('images/header.jpeg') }}');">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10 wow fadeInDown" data-wow-duration="0.9s" data-wow-delay="0.2s">Event Details</h1>
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

    <!-- Start Event Details -->
    <section>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">
            <div class="row td_gap_y_40">
                <div class="col-lg-8">
                    <div class="event_detail_img_wrap wow zoomIn" data-wow-duration="1.1s" data-wow-delay="0.2s">
                        <img src="{{ $event->image ? asset('storage/' . $event->image) : $eventPlaceholder }}"
                            alt="{{ $event->title }}" class="event_detail_img td_radius_10">
                    </div>

                    <h2 class="td_fs_36 td_mb_20 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">{{ $event->title }}</h2>

                    <div class="event_detail_body td_fs_18 td_heading_color td_opacity_8 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">
                        {!! nl2br(e($event->description)) !!}
                    </div>

                    <div class="td_height_40 td_height_lg_30"></div>
                    <a href="{{ route('events.index') }}" class="event_back wow fadeInUp" data-wow-delay="0.2s">
                        <span class="event_back_icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                        </span>
                        <span>Back to Events</span>
                    </a>
                </div>

                <div class="col-lg-4">
                    <div class="event_info_box wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
                        <h3 class="td_fs_24 td_semibold td_mb_20">Event Info</h3>
                        <ul class="event_info_list">
                            @if ($date)
                                <li class="wow fadeInUp" data-wow-delay="0.45s">
                                    <span class="event_info_icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect x="3" y="5" width="18" height="16" rx="2" />
                                            <path d="M3 10h18M8 3v4M16 3v4" />
                                        </svg>
                                    </span>
                                    <div><small>Date</small><strong>{{ $date->format('l, d F Y') }}</strong></div>
                                </li>
                            @endif
                            @if ($time)
                                <li class="wow fadeInUp" data-wow-delay="0.55s">
                                    <span class="event_info_icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="9" />
                                            <path d="M12 7v5l3 2" />
                                        </svg>
                                    </span>
                                    <div><small>Time</small><strong>{{ $time }}</strong></div>
                                </li>
                            @endif
                            @if ($event->venue)
                                <li class="wow fadeInUp" data-wow-delay="0.65s">
                                    <span class="event_info_icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 21s-7-6.2-7-11.5A7 7 0 0 1 19 9.5C19 14.8 12 21 12 21z" />
                                            <circle cx="12" cy="9.5" r="2.5" />
                                        </svg>
                                    </span>
                                    <div><small>Venue</small><strong>{{ $event->venue }}</strong></div>
                                </li>
                            @endif
                            <li class="wow fadeInUp" data-wow-delay="0.75s">
                                <span class="event_info_icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="m8.5 12 2.5 2.5 4.5-5" />
                                    </svg>
                                </span>
                                <div>
                                    <small>Status</small>
                                    <strong class="{{ $isPast ? 'event_status_past' : 'event_status_upcoming' }}">
                                        {{ $isPast ? 'Completed' : ($date && $date->isToday() ? 'Today' : 'Upcoming') }}
                                    </strong>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- More events --}}
            @if ($moreEvents->isNotEmpty())
                <div class="td_height_80 td_height_lg_50"></div>
                <h2 class="td_fs_36 td_mb_30 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">More Events</h2>
                <div class="row td_gap_y_30">
                    @foreach ($moreEvents as $item)
                        @php
                            $itemDate = $item->event_date ? \Illuminate\Support\Carbon::parse($item->event_date) : null;
                            $itemLink = route('events.show', $item);
                        @endphp
                        {{-- Cards come in from the left, bottom and right across each row of three --}}
                        <div class="col-lg-4 col-md-6 wow {{ ['fadeInLeft', 'fadeInUp', 'fadeInRight'][$loop->index % 3] }}"
                            data-wow-duration="0.9s" data-wow-delay="{{ 0.1 + ($loop->index % 3) * 0.12 }}s">
                            <div class="td_post td_style_1 event_card">
                                <a href="{{ $itemLink }}" class="td_post_thumb d-block">
                                    <img src="{{ $item->image ? asset('storage/' . $item->image) : $eventPlaceholder }}"
                                        alt="{{ $item->title }}" loading="lazy">
                                    <i class="fa-solid fa-link"></i>
                                    @if ($itemDate)
                                        <span class="event_date_badge {{ $itemDate->isBefore(today()) ? 'is_past' : '' }}">
                                            <strong>{{ $itemDate->format('d') }}</strong>
                                            <small>{{ $itemDate->format('M Y') }}</small>
                                        </span>
                                    @endif
                                </a>
                                <div class="td_post_info">
                                    <h2 class="td_post_title td_fs_24 td_medium td_mb_16">
                                        <a href="{{ $itemLink }}">{{ $item->title }}</a>
                                    </h2>
                                    <a href="{{ $itemLink }}" class="event_more">
                                        <span>Read More</span>
                                        <span class="event_more_icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M5 12h14M12 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Event Details -->

@endsection

@push('styles')
<style>
    /* Page heading: fix the theme's breadcrumb separator (same as other pages) */
    .td_page_heading .breadcrumb-item + .breadcrumb-item::before { content: "/" !important; color: #fff; padding: 0 8px; }

    .event_detail_img_wrap { margin-bottom: 30px; }
    .event_detail_img { width: 100%; aspect-ratio: 8 / 5; object-fit: cover; display: block; }
    .event_detail_body { line-height: 1.8; }

    /* Back to Events button */
    .event_back {
        display: inline-flex; align-items: center; gap: 12px;
        padding: 6px 22px 6px 6px; border-radius: 30px;
        border: 1px solid var(--heading-color, #00539B);
        color: var(--heading-color, #00539B); font-weight: 600; font-size: 15px;
        background: #fff; transition: background .3s ease, color .3s ease, box-shadow .3s ease;
    }
    .event_back_icon {
        width: 36px; height: 36px; border-radius: 50%; flex: none;
        display: flex; align-items: center; justify-content: center;
        background: var(--heading-color, #00539B); color: #fff;
        transition: background .3s ease, color .3s ease, transform .3s ease;
    }
    .event_back:hover {
        background: var(--heading-color, #00539B); color: #fff;
        box-shadow: 0 12px 24px -12px rgba(0, 83, 155, .6);
    }
    .event_back:hover .event_back_icon {
        background: #fff; color: var(--heading-color, #00539B);
        transform: translateX(-4px);
    }

    /* Read More button (same as events list) */
    .event_more {
        display: inline-flex; align-items: center; gap: 12px;
        padding: 6px 6px 6px 22px; border-radius: 30px;
        border: 1px solid var(--heading-color, #00539B);
        color: var(--heading-color, #00539B); font-weight: 600; font-size: 15px;
        background: #fff; transition: background .3s ease, color .3s ease, box-shadow .3s ease;
    }
    .event_more_icon {
        width: 36px; height: 36px; border-radius: 50%; flex: none;
        display: flex; align-items: center; justify-content: center;
        background: var(--heading-color, #00539B); color: #fff;
        transition: background .3s ease, color .3s ease, transform .3s ease;
    }
    .event_more:hover {
        background: var(--heading-color, #00539B); color: #fff;
        box-shadow: 0 12px 24px -12px rgba(0, 83, 155, .6);
    }
    .event_more:hover .event_more_icon {
        background: #fff; color: var(--heading-color, #00539B);
        transform: translateX(4px) rotate(-45deg);
    }

    /* Event info box */
    .event_info_box {
        background: #fff; border-radius: 16px; padding: 30px;
        box-shadow: 0 10px 40px rgba(13, 27, 76, .08); position: sticky; top: 120px;
    }
    .event_info_list { list-style: none; padding: 0; margin: 0; }
    .event_info_list li { display: flex; gap: 14px; align-items: center; padding: 14px 0; border-bottom: 1px solid #eceef5; }
    .event_info_list li:last-child { border-bottom: 0; padding-bottom: 0; }
    .event_info_icon {
        flex-shrink: 0; width: 44px; height: 44px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: rgba(0, 83, 155, .08); color: var(--heading-color, #00539B);
    }
    .event_info_list small { display: block; font-size: 13px; opacity: .6; }
    .event_info_list strong { font-weight: 600; color: var(--heading-color); }
    .event_status_upcoming { color: #16a34a !important; }
    .event_status_past { color: #6b7280 !important; }

    /* Cards (same as events list) */
    .event_card .td_post_thumb { position: relative; }
    .event_card .td_post_thumb img { width: 100%; aspect-ratio: 8 / 5; object-fit: cover; }
    .event_date_badge {
        position: absolute; top: 16px; left: 16px; z-index: 2;
        background: var(--heading-color, #00539B); color: #fff; border-radius: 10px;
        padding: 8px 12px; text-align: center; line-height: 1.1; min-width: 64px;
    }
    .event_date_badge strong { display: block; font-size: 24px; }
    .event_date_badge small { font-size: 12px; text-transform: uppercase; }
    .event_date_badge.is_past { background: #6b7280; }

    @media (max-width: 991px) { .event_info_box { position: static; } }
</style>
@endpush