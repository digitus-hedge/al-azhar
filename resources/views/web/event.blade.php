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
    data-src="{{ asset('images/header.jpeg') }}"
    style="background-image: url('{{ asset('images/header.jpeg') }}');">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10 wow fadeInDown" data-wow-duration="0.9s" data-wow-delay="0.2s">Events</h1>
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

            {{-- Filter tabs --}}
            <div class="event_tabs td_mb_40 wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.2s">
                @foreach (['all' => 'All Events', 'upcoming' => 'Upcoming', 'past' => 'Past Events'] as $key => $text)
                    <a href="{{ $key === 'all' ? route('events.index') : route('events.index', ['type' => $key]) }}"
                        class="event_tab {{ $type === $key ? 'active' : '' }}">{{ $text }}</a>
                @endforeach
            </div>

            <div class="row td_gap_y_30">
                @forelse ($events as $event)
                    @php
                        $date         = $event->event_date ? \Illuminate\Support\Carbon::parse($event->event_date) : null;
                        $time         = $event->event_time ? \Illuminate\Support\Carbon::parse($event->event_time)->format('h:i A') : null;
                        $isPast       = $date && $date->isBefore(today());
                        $link         = route('events.show', $event);
                        $canRespond   = $event->is_open_for_response;
                        $responseEnd  = $event->response_date ? \Illuminate\Support\Carbon::parse($event->response_date) : null;
                    @endphp
                    <div id="event-{{ $event->id }}"
                        class="col-lg-4 col-md-6 wow {{ ['fadeInLeft', 'fadeInUp', 'fadeInRight'][$loop->index % 3] }}"
                        data-wow-duration="0.9s" data-wow-delay="{{ 0.1 + ($loop->index % 3) * 0.12 }}s">
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

                                <div class="event_card_actions">
                                    <a href="{{ $link }}" class="event_more">
                                        <span>Read More</span>
                                        <span class="event_more_icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M5 12h14M12 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                    </a>

                                    @if ($canRespond)
                                        <button type="button" class="event_respond_btn"
                                            data-respond-open
                                            data-event-id="{{ $event->id }}"
                                            data-event-title="{{ $event->title }}"
                                            @if ($responseEnd) data-response-end="{{ $responseEnd->format('d M Y') }}" @endif>
                                            <span class="event_respond_icon">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                                </svg>
                                            </span>
                                            <span>Respond</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center event_empty wow zoomIn" data-wow-delay="0.2s">
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
                <ul class="event_pagination wow fadeInUp" data-wow-delay="0.1s">
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

    {{-- ============== Response Modal ============== --}}
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
                <input type="hidden" name="event_id" id="eventRespondId" value="">

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

@endsection

@push('styles')
<style>
    /* Page heading: fix the theme's breadcrumb separator (same as other pages) */
    .td_page_heading .breadcrumb-item + .breadcrumb-item::before { content: "/" !important; color: #fff; padding: 0 8px; }

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

    /* ======== Tabs ======== */
    .event_tabs { display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; }
    .event_tab {
        padding: 10px 24px; border-radius: 30px; font-weight: 500;
        border: 1px solid var(--accent-color); color: var(--accent-color); transition: .25s;
    }
    .event_tab:hover, .event_tab.active { background: var(--accent-color); color: #fff; }

    /* ======== Card ======== */
    .event_card { height: 100%; display: flex; flex-direction: column; }
    .event_card .td_post_info { display: flex; flex-direction: column; flex: 1; }
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

    /* ======== Card Actions (Read More + Respond) ======== */
    .event_card_actions {
        display: flex; align-items: center; justify-content: space-between;
        gap: 10px; flex-wrap: wrap;
        margin-top: auto;
    }

    /* Read More */
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
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 20px; border-radius: 30px;
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
    }
    .event_respond_icon {
        display: flex; align-items: center; justify-content: center;
    }

    /* ======== Pagination ======== */
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

    @media (max-width: 575px) {
        .event_card_actions { gap: 10px; }
        .event_more, .event_respond_btn { width: 100%; justify-content: center; }
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
        var idInput  = document.getElementById('eventRespondId');
        var titleEl  = document.getElementById('eventRespondTitle');
        var subEl    = document.getElementById('eventRespondSub');
        var openers  = document.querySelectorAll('[data-respond-open]');
        if (!modal) return;

        function open(btn) {
            var id    = btn.getAttribute('data-event-id') || '';
            var title = btn.getAttribute('data-event-title') || 'Share Your Response';
            var endOn = btn.getAttribute('data-response-end');

            idInput.value = id;
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

       // Auto-open the modal again ONLY when there are actual validation errors
        @if ($errors->any() && old('event_id') && !session('response_success'))
            (function () {
                var errBtn = document.querySelector('[data-event-id="{{ old('event_id') }}"]');
                if (errBtn) open(errBtn);
            })();
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