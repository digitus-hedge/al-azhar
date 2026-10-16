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
    $date         = $event->event_date ? \Illuminate\Support\Carbon::parse($event->event_date) : null;
    $time         = $event->event_time ? \Illuminate\Support\Carbon::parse($event->event_time)->format('h:i A') : null;
    $isPast       = $date && $date->isBefore(today());
    $responseEnd  = $event->response_date ? \Illuminate\Support\Carbon::parse($event->response_date) : null;

    // Only show the Respond button from the event date up to (and including) the response date.
    // Hidden before the event starts and after the response window closes.
    $canRespond   = $event->is_open_for_response
                    && $date
                    && $responseEnd
                    && today()->betweenIncluded($date->copy()->startOfDay(), $responseEnd->copy()->startOfDay());
@endphp

    {{-- Shared page header --}}
@include('web.layouts.page-header', [
    'title'    => 'Event Details',
    'subtitle' => $event->title,
])

    <!-- Start Event Details -->
    <section>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">

            {{-- Flash messages for response form --}}
            @if (session('response_success'))
                <div class="event_flash event_flash_success wow fadeInDown">
                    <span class="event_flash_icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                    </span>
                    <div>{{ session('response_success') }}</div>
                    <button type="button" class="event_flash_close" onclick="this.parentNode.remove()" aria-label="Close">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            @if (session('response_error'))
                <div class="event_flash event_flash_error wow fadeInDown">
                    <span class="event_flash_icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                    </span>
                    <div>{{ session('response_error') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="event_flash event_flash_error wow fadeInDown">
                    <span class="event_flash_icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                    </span>
                    <div>
                        <strong>Please fix the following:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

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

                    <div class="event_detail_actions wow fadeInUp" data-wow-delay="0.2s">
                        <a href="{{ route('events.index') }}" class="event_back">
                            <span class="event_back_icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 12H5M12 19l-7-7 7-7" />
                                </svg>
                            </span>
                            <span>Back to Events</span>
                        </a>

                        @if ($canRespond)
                            <button type="button" class="event_respond_btn event_respond_btn_lg"
                                data-respond-open
                                data-event-id="{{ $event->id }}"
                                data-event-title="{{ $event->title }}"
                                @if ($responseEnd) data-response-end="{{ $responseEnd->format('d M Y') }}" @endif>
                                <span class="event_respond_icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                    </svg>
                                </span>
                                <span>Share Your Response</span>
                            </button>
                        @endif
                    </div>
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
                            @if ($responseEnd)
                                <li class="wow fadeInUp" data-wow-delay="0.85s">
                                    <span class="event_info_icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <small>Respond By</small>
                                        <strong>{{ $responseEnd->format('d M Y') }}</strong>
                                    </div>
                                </li>
                            @endif
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

    {{-- ============== Response Modal ============== --}}
    @if ($canRespond)
        <div class="event_modal" id="eventRespondModal" aria-hidden="true" role="dialog" aria-labelledby="eventRespondTitle">
            <div class="event_modal_bg" data-respond-close></div>
            <div class="event_modal_box">
                <button type="button" class="event_modal_close" data-respond-close aria-label="Close">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
                        <path d="M18 6 6 18M6 6l12 12"/>
                    </svg>
                </button>

                <div class="event_modal_head">
                    <span class="event_modal_badge">Event Response</span>
                    <h3 id="eventRespondTitle">Share Your Response</h3>
                    <p class="event_modal_sub" id="eventRespondSub">We'd love to hear your feedback.</p>
                </div>

                <form action="{{ route('events.response.store') }}" method="POST" class="event_modal_form" novalidate>
                    @csrf
                    <input type="hidden" name="event_id" id="eventRespondId" value="{{ $event->id }}">

                    {{-- Honeypot --}}
                    <div class="event_hp" aria-hidden="true">
                        <label for="event_website">Website</label>
                        <input type="text" id="event_website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="event_field">
                        <label for="event_resp_name">Your Name <span>*</span></label>
                        <input type="text" id="event_resp_name" name="name" maxlength="150" required placeholder="Enter your full name" value="{{ old('name') }}">
                    </div>

                    <div class="event_field">
                        <label for="event_resp_phone">Phone Number <span>*</span></label>
                        <input type="tel" id="event_resp_phone" name="phone" maxlength="20" required placeholder="e.g. 98765 43210" inputmode="tel" value="{{ old('phone') }}">
                    </div>

                    <div class="event_field">
                        <label for="event_resp_comment">Comment <small>(optional)</small></label>
                        <textarea id="event_resp_comment" name="comment" rows="4" maxlength="2000" placeholder="Share your thoughts, feedback or suggestions…">{{ old('comment') }}</textarea>
                    </div>

                    <div class="event_modal_foot">
                        <button type="button" class="event_modal_cancel" data-respond-close>Cancel</button>
                        <button type="submit" class="event_modal_submit">
                            <span>Submit Response</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

@endsection

@push('styles')
<style>

    .event_detail_img_wrap { margin-bottom: 30px; }
    .event_detail_img { width: 100%; aspect-ratio: 8 / 5; object-fit: cover; display: block; }
    .event_detail_body { line-height: 1.8; }

    /* ======== Flash messages ======== */
    .event_flash {
        display: flex; align-items: flex-start; gap: 14px;
        padding: 16px 22px; border-radius: 12px;
        margin-bottom: 24px;
        font-size: 15px; line-height: 1.5;
    }
    .event_flash_success {
        background: #e6f7ee; border-left: 4px solid #198754; color: #0f5132;
    }
    .event_flash_success .event_flash_icon { color: #198754; }
    .event_flash_error {
        background: #fdecea; border-left: 4px solid #d93025; color: #611a15;
    }
    .event_flash_error .event_flash_icon { color: #d93025; }
    .event_flash_icon {
        flex: none;
        width: 32px; height: 32px; border-radius: 50%;
        background: rgba(255,255,255,.7);
        display: flex; align-items: center; justify-content: center;
    }
    .event_flash > div { flex: 1; }
    .event_flash ul { padding-left: 18px; }
    .event_flash_close {
        background: transparent; border: 0; padding: 4px; cursor: pointer;
        color: inherit; opacity: .6; display: flex; align-items: center;
    }
    .event_flash_close:hover { opacity: 1; }

    /* ======== Detail actions row (Back + Respond side by side) ======== */
    .event_detail_actions {
        display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
    }

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

    /* Read More button */
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

    /* Respond button */
    .event_respond_btn {
        display: inline-flex; align-items: center; gap: 10px;
        padding: 10px 22px; border-radius: 30px;
        border: 0; cursor: pointer; font-family: inherit;
        background: linear-gradient(135deg, #16a34a, #15803d);
        color: #fff; font-weight: 600; font-size: 14px;
        box-shadow: 0 12px 24px -12px rgba(21, 128, 61, .55);
        transition: transform .3s ease, box-shadow .3s ease;
        position: relative;
    }
    .event_respond_btn::before {
        content: "";
        position: absolute; top: -3px; right: -3px;
        width: 10px; height: 10px; border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, .3);
        animation: eventRespondPulse 2s ease-in-out infinite;
    }
    @keyframes eventRespondPulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: .5; }
    }
    .event_respond_btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 30px -12px rgba(21, 128, 61, .7);
        color: #fff;
    }
    /* Larger variant for in-article placement */
    .event_respond_btn_lg {
        padding: 12px 26px; font-size: 15px;
    }
    /* Block version in the sidebar */
    .event_respond_btn_block {
        width: 100%; justify-content: center;
        padding: 14px 24px; font-size: 15px;
    }
    .event_respond_icon {
        display: flex; align-items: center; justify-content: center;
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

    .event_info_cta {
        margin-top: 20px; padding-top: 20px;
        border-top: 1px dashed #eceef5;
    }

    /* Cards */
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

    /* ======== Modal ======== */
    .event_hp { position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden; }

    .event_modal {
        position: fixed; inset: 0; z-index: 99999;
        display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden;
        transition: opacity .3s ease, visibility .3s ease;
        padding: 20px;
    }
    .event_modal.is-open { opacity: 1; visibility: visible; }
    .event_modal_bg {
        position: absolute; inset: 0;
        background: rgba(0, 20, 40, .75);
        backdrop-filter: blur(6px);
    }
    .event_modal_box {
        position: relative;
        width: 100%; max-width: 540px;
        max-height: calc(100vh - 40px);
        background: #fff;
        border-radius: 20px; overflow: hidden;
        box-shadow: 0 40px 80px -20px rgba(0, 0, 27, .5);
        transform: translateY(30px) scale(0.95);
        transition: transform .4s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex; flex-direction: column;
    }
    .event_modal.is-open .event_modal_box { transform: translateY(0) scale(1); }

    .event_modal_close {
        position: absolute; top: 14px; right: 14px; z-index: 3;
        width: 36px; height: 36px; border-radius: 50%;
        border: 0; cursor: pointer;
        background: rgba(255,255,255,.9);
        color: var(--heading-color, #00539B);
        display: flex; align-items: center; justify-content: center;
        transition: all .3s ease;
    }
    .event_modal_close:hover {
        background: #fff; transform: rotate(90deg) scale(1.1);
    }

    .event_modal_head {
        padding: 32px 32px 24px;
        background: linear-gradient(135deg, var(--heading-color, #00539B), #002F5F);
        color: #fff; position: relative; overflow: hidden;
        text-align: center;
    }
    .event_modal_head::before {
        content: ""; position: absolute;
        width: 220px; height: 220px; border-radius: 50%;
        background: rgba(255,255,255,.08);
        right: -70px; top: -70px;
    }
    .event_modal_head > * { position: relative; z-index: 1; }
    .event_modal_badge {
        display: inline-block;
        padding: 5px 14px; border-radius: 30px;
        background: rgba(255,255,255,.18);
        font-size: 11.5px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        margin-bottom: 12px;
    }
    .event_modal_head h3 {
        margin: 0; font-size: 22px; font-weight: 700;
        color: #fff; line-height: 1.3;
    }
    .event_modal_sub {
        margin: 8px 0 0; font-size: 14px;
        color: rgba(255,255,255,.85);
    }

    .event_modal_form {
        padding: 28px 32px 24px;
        overflow-y: auto; flex: 1;
    }
    .event_field {
        display: flex; flex-direction: column;
        margin-bottom: 18px;
    }
    .event_field label {
        font-size: 13.5px; font-weight: 600;
        color: var(--heading-color, #00539B); margin-bottom: 7px;
        display: inline-flex; align-items: baseline; gap: 6px;
    }
    .event_field label span { color: #dc3545; }
    .event_field label small { color: #6b7489; font-weight: 400; font-size: 12px; }
    .event_field input,
    .event_field textarea {
        width: 100%; padding: 12px 14px;
        font-family: inherit; font-size: 14.5px;
        color: #2d3545; background: #f7f9fc;
        border: 1.5px solid #e6eaf2; border-radius: 10px;
        transition: all .25s ease;
    }
    .event_field input:focus,
    .event_field textarea:focus {
        outline: none; background: #fff;
        border-color: var(--heading-color, #00539B);
        box-shadow: 0 0 0 3px rgba(0, 83, 155, .1);
    }
    .event_field textarea { resize: vertical; min-height: 100px; }

    .event_modal_foot {
        display: flex; justify-content: flex-end; align-items: center; gap: 12px;
        padding-top: 10px;
        flex-wrap: wrap;
    }
    .event_modal_cancel {
        padding: 11px 22px; border-radius: 30px;
        background: transparent; border: 1px solid #e6eaf2;
        color: #6b7489; font-weight: 600; font-size: 14px;
        cursor: pointer; transition: all .25s ease;
    }
    .event_modal_cancel:hover {
        background: #f7f9fc; color: var(--heading-color, #00539B);
        border-color: var(--heading-color, #00539B);
    }
    .event_modal_submit {
        display: inline-flex; align-items: center; gap: 10px;
        padding: 12px 24px; border-radius: 30px;
        background: linear-gradient(135deg, var(--heading-color, #00539B), #002F5F);
        color: #fff; font-weight: 600; font-size: 14px;
        border: 0; cursor: pointer;
        box-shadow: 0 12px 24px -10px rgba(0, 47, 95, .5);
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .event_modal_submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 30px -10px rgba(0, 47, 95, .65);
    }
    .event_modal_submit svg { transition: transform .3s ease; }
    .event_modal_submit:hover svg { transform: translateX(4px); }

    body.event_modal_lock { overflow: hidden; }

    @media (max-width: 991px) {
        .event_info_box { position: static; }
    }
    @media (max-width: 575px) {
        .event_detail_actions { flex-direction: column; align-items: stretch; }
        .event_detail_actions > * { justify-content: center; width: 100%; }
        .event_modal { padding: 12px; }
        .event_modal_box { border-radius: 16px; }
        .event_modal_head { padding: 26px 22px 22px; }
        .event_modal_head h3 { font-size: 19px; }
        .event_modal_form { padding: 22px; }
        .event_modal_foot { flex-direction: column-reverse; align-items: stretch; }
        .event_modal_cancel, .event_modal_submit { width: 100%; justify-content: center; }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    function init() {
        var modal    = document.getElementById('eventRespondModal');
        var titleEl  = document.getElementById('eventRespondTitle');
        var subEl    = document.getElementById('eventRespondSub');
        var openers  = document.querySelectorAll('[data-respond-open]');
        if (!modal) return;

        function open(btn) {
            var title = btn.getAttribute('data-event-title') || 'Share Your Response';
            var endOn = btn.getAttribute('data-response-end');

            titleEl.textContent = 'Respond to: ' + title;
            subEl.textContent = endOn
                ? 'Please share your response before ' + endOn + '.'
                : 'We\'d love to hear your feedback.';

            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('event_modal_lock');

            setTimeout(function () {
                var first = document.getElementById('event_resp_name');
                if (first) first.focus();
            }, 300);
        }

        function close() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('event_modal_lock');
        }

        openers.forEach(function (btn) {
            btn.addEventListener('click', function () { open(btn); });
        });

        modal.querySelectorAll('[data-respond-close]').forEach(function (el) {
            el.addEventListener('click', close);
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) close();
        });

        // Phone: digits, +, -, spaces, parens only
        var phoneInput = document.getElementById('event_resp_phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9+\-\s()]/g, '');
            });
        }

        // Auto-dismiss flash after 7s
        var flash = document.querySelector('.event_flash_success');
        if (flash) {
            setTimeout(function () {
                flash.style.transition = 'opacity .5s ease';
                flash.style.opacity = '0';
                setTimeout(function () { flash.remove(); }, 500);
            }, 7000);
        }

        // Reopen modal only on validation errors
        @if ($errors->any() && !session('response_success'))
            var firstOpener = document.querySelector('[data-respond-open]');
            if (firstOpener) open(firstOpener);
        @endif
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@endpush