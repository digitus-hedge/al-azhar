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
        data-src="{{ asset('uploads/website-images/students-after-graduation-ceremony.jpg') }}">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">Event Details</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                    <li class="breadcrumb-item active">{{ \Illuminate\Support\Str::limit($event->title, 40) }}</li>
                </ol>
            </div>
        </div>
        <div class="td_page_heading_shape_1 position-absolute td_hover_layer_3"></div>
        <div class="td_page_heading_shape_2 position-absolute td_hover_layer_5"></div>
        <div class="td_page_heading_shape_6 position-absolute td_hover_layer_3"></div>
    </section>
    <!-- End Page Heading Section -->

    <!-- Start Event Details -->
    <section>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">
            <div class="row td_gap_y_40">
                <div class="col-lg-8">
                    <img src="{{ $event->image ? asset('storage/' . $event->image) : $eventPlaceholder }}"
                        alt="{{ $event->title }}" class="event_detail_img td_radius_10 td_mb_30">

                    <h2 class="td_fs_36 td_mb_20">{{ $event->title }}</h2>

                    <div class="event_detail_body td_fs_18 td_heading_color td_opacity_8">
                        {!! nl2br(e($event->description)) !!}
                    </div>

                    <div class="td_height_40 td_height_lg_30"></div>
                    <a href="{{ route('events.index') }}" class="td_btn td_style_1 td_type_3 td_radius_30 td_medium">
                        <span class="td_btn_in td_accent_color">
                            <span>&larr; Back to Events</span>
                        </span>
                    </a>
                </div>

                <div class="col-lg-4">
                    <div class="event_info_box">
                        <h3 class="td_fs_24 td_semibold td_mb_20">Event Info</h3>
                        <ul class="event_info_list">
                            @if ($date)
                                <li>
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
                                <li>
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
                                <li>
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
                            <li>
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
                <h2 class="td_fs_36 td_mb_30 text-center">More Events</h2>
                <div class="row td_gap_y_30">
                    @foreach ($moreEvents as $item)
                        @php
                            $itemDate = $item->event_date ? \Illuminate\Support\Carbon::parse($item->event_date) : null;
                            $itemLink = route('events.show', $item);
                        @endphp
                        <div class="col-lg-4 col-md-6">
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
                                    <a href="{{ $itemLink }}" class="td_btn td_style_1 td_type_3 td_radius_30 td_medium">
                                        <span class="td_btn_in td_accent_color"><span>Read More</span></span>
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
    .event_detail_img { width: 100%; aspect-ratio: 8 / 5; object-fit: cover; display: block; }
    .event_detail_body { line-height: 1.8; }

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
        background: rgba(0, 0, 0, .04); color: var(--accent-color);
    }
    .event_info_list small { display: block; font-size: 13px; opacity: .6; }
    .event_info_list strong { font-weight: 600; color: var(--heading-color); }
    .event_status_upcoming { color: #16a34a !important; }
    .event_status_past { color: #6b7280 !important; }

    /* cards (same as events list) */
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

    @media (max-width: 991px) { .event_info_box { position: static; } }
</style>
@endpush