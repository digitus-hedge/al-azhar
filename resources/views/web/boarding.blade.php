@extends('web.layouts.app')

@php
    $images = $images ?? [];
    $videos = $videos ?? [];

    $title       = $boarding?->title ?: 'Boarding & Hostel';
    $description = trim((string) ($boarding?->description ?? ''));
    $paragraphs  = $description !== '' ? preg_split('/\R{2,}/', $description) : [];

    $feesTitle = $boarding?->fees_title ?: 'Fees Structure';
    $qrUrl     = $boarding?->qr_url;
    $qrCaption = $boarding?->qr_caption ?: 'Al Azhar Central School, Mala';

    // Thumbnail for each video: YouTube gives one; uploaded files use their first frame
    $videoThumb = function ($v) {
        if ($v['type'] === 'embed' && preg_match('~youtube\.com/embed/([A-Za-z0-9_-]{11})~', $v['url'], $m)) {
            return 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
        }
        return null;
    };

    $hasMedia   = count($images) || count($videos);
    $firstPanel = count($images) ? 'images' : 'videos';

    $highlights = [
        ['Safety',      'Secure, well-supervised hostels for boys and girls, housed separately.',
            '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>'],
        ['Discipline',  'A caring routine guided by the warden and teachers on duty.',
            '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>'],
        ['Nourishment', 'Food prepared under strict supervision for hygiene, taste and nutrition.',
            '<path d="M3 11h18a9 9 0 0 1-18 0z"/><path d="M8 7c0-1.5 1-2 1-3.5M12 7c0-1.5 1-2 1-3.5M16 7c0-1.5 1-2 1-3.5"/>'],
    ];
@endphp

@section('title', 'Boarding & Fees || Al Azhar Central School, Mala')
@section('meta_description', \Illuminate\Support\Str::limit(
    trim(preg_replace('/\s+/', ' ', strip_tags((string) ($description ?? ''))))
        ?: 'Hostel facilities, boarding life and fee details at Al Azhar Central School, Mala. Safe, supervised residential care for students.',
    155
))
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@section('content')

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('images/header.jpeg') }}"
    style="background-image: url('{{ asset('images/header.jpeg') }}');">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10 wow fadeInDown" data-wow-duration="0.9s" data-wow-delay="0.2s">Boarding &amp; Fees</h1>
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
    <section class="brd_intro">
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">
            <div class="row td_gap_y_40 align-items-center">
                <div class="col-lg-7">
                    <div class="td_section_heading td_style_1 td_mb_30">
                        <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase brd_accent wow fadeInDown" data-wow-delay="0.2s">
                            Boarding &amp; Hostel
                        </p>
                        <h2 class="td_section_title td_fs_48 mb-0 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">{{ $title }}</h2>
                    </div>

                    @if (count($paragraphs))
                        <div class="brd_text wow fadeInUp" data-wow-delay="0.4s">
                            @foreach ($paragraphs as $para)
                                @if (trim($para) !== '')
                                    <p>{!! nl2br(e(trim($para))) !!}</p>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="brd_text wow fadeInUp" data-wow-delay="0.4s">Details about our hostel facilities will be published here soon.</p>
                    @endif
                </div>

                <div class="col-lg-5">
                    <ul class="brd_highlights td_mp_0">
                        @foreach ($highlights as [$hTitle, $hText, $hIcon])
                            <li class="wow fadeInRight" data-wow-duration="0.9s" data-wow-delay="{{ 0.3 + $loop->index * 0.15 }}s">
                                <span class="brd_hl_icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{!! $hIcon !!}</svg>
                                </span>
                                <div>
                                    <h3>{{ $hTitle }}</h3>
                                    <p class="mb-0">{{ $hText }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Intro -->

    <!-- Start Photos & Videos -->
    @if ($hasMedia)
        <section class="brd_media">
            <div class="td_height_100 td_height_lg_75"></div>
            <div class="container">
                <div class="brd_media_head">
                    <div class="td_section_heading td_style_1 mb-0 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                        <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase brd_accent">Life in the Hostel</p>
                        <h2 class="td_section_title td_fs_48 mb-0">A Home Away From Home</h2>
                    </div>

                    @if (count($images) && count($videos))
                        <div class="brd_tabs wow fadeInRight" data-wow-delay="0.3s" role="tablist">
                            <button type="button" class="brd_tab is-active" data-panel="images" role="tab" aria-selected="true">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                Images <span>{{ count($images) }}</span>
                            </button>
                            <button type="button" class="brd_tab" data-panel="videos" role="tab" aria-selected="false">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="15" height="14" rx="2"/><path d="m17 10 5-3v10l-5-3"/></svg>
                                Videos <span>{{ count($videos) }}</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="td_height_50 td_height_lg_40"></div>

                {{-- Images --}}
                @if (count($images))
                    <div class="brd_panel {{ $firstPanel === 'images' ? 'is-active' : '' }}" data-panel="images">
                        <div class="brd_grid">
                            @foreach ($images as $i => $src)
                                <a href="{{ $src }}" class="brd_tile wow zoomIn" data-kind="image" data-src="{{ $src }}"
                                    data-wow-duration="0.9s" data-wow-delay="{{ 0.1 + ($i % 4) * 0.1 }}s"
                                    aria-label="Open photo {{ $i + 1 }}">
                                    <img src="{{ $src }}" alt="Boarding at Al Azhar, photo {{ $i + 1 }}" loading="lazy" decoding="async">
                                    <span class="brd_zoom">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Videos --}}
                @if (count($videos))
                    <div class="brd_panel {{ $firstPanel === 'videos' ? 'is-active' : '' }}" data-panel="videos">
                        <div class="brd_grid brd_grid_video">
                            @foreach ($videos as $i => $v)
                                @php
                                    $thumb = $videoThumb($v);
                                    $src   = $v['type'] === 'embed'
                                        ? $v['url'] . (str_contains($v['url'], '?') ? '&' : '?') . 'autoplay=1&rel=0'
                                        : $v['url'];
                                @endphp
                                <a href="{{ $v['type'] === 'embed' ? ($v['original'] ?? $v['url']) : $v['url'] }}"
                                    class="brd_tile brd_tile_video wow zoomIn"
                                    data-kind="{{ $v['type'] === 'embed' ? 'embed' : 'video' }}" data-src="{{ $src }}"
                                    data-wow-duration="0.9s" data-wow-delay="{{ 0.1 + ($i % 3) * 0.12 }}s"
                                    aria-label="Play video {{ $i + 1 }}">
                                    @if ($thumb)
                                        <img src="{{ $thumb }}" alt="Boarding video {{ $i + 1 }}" loading="lazy" decoding="async">
                                    @elseif ($v['type'] === 'file')
                                        <video muted playsinline preload="none" data-lazy-src="{{ $v['url'] }}#t=0.5"></video>
                                    @else
                                        <span class="brd_tile_blank"></span>
                                    @endif
                                    <span class="brd_play">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="td_height_100 td_height_lg_75"></div>
        </section>

        {{-- Viewer --}}
        <div class="brd_lb" id="brdLb" aria-hidden="true" role="dialog" aria-label="Media viewer">
            <div class="brd_lb_bg" data-close></div>
            <span class="brd_lb_count"></span>
            <button type="button" class="brd_lb_btn brd_lb_close" data-close aria-label="Close">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
            <button type="button" class="brd_lb_btn brd_lb_prev" aria-label="Previous">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </button>
            <div class="brd_lb_stage"></div>
            <button type="button" class="brd_lb_btn brd_lb_next" aria-label="Next">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            </button>
        </div>
    @endif
    <!-- End Photos & Videos -->

    <!-- Start Fees & Payment -->
    <section class="brd_fees">
        <div class="td_height_100 td_height_lg_75"></div>
        <div class="container">
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase brd_accent">
                    <i></i> Fees &amp; Payment <i></i>
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">{{ $feesTitle }}</h2>
            </div>
            <div class="td_height_50 td_height_lg_40"></div>

            @if ($qrUrl)
                <div class="brd_pay wow zoomIn" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="brd_pay_body">
                        <span class="brd_pay_badge">Pay Online</span>
                        <h3 class="brd_pay_title">Scan this QR code for payment</h3>
                        <p class="brd_pay_text">Pay the school and hostel fees from any UPI app in a few seconds.</p>

                        <ol class="brd_steps td_mp_0">
                            <li class="wow fadeInLeft" data-wow-delay="0.35s"><b>1</b><span>Open Google Pay, PhonePe, Paytm or your bank's UPI app</span></li>
                            <li class="wow fadeInLeft" data-wow-delay="0.5s"><b>2</b><span>Scan the QR code and enter the fee amount</span></li>
                            <li class="wow fadeInLeft" data-wow-delay="0.65s"><b>3</b><span>Add the student's name and class in the note, then pay</span></li>
                            <li class="wow fadeInLeft" data-wow-delay="0.8s"><b>4</b><span>Keep the payment screenshot as your receipt</span></li>
                        </ol>

                        <div class="brd_pay_btns">
                            <a href="{{ $qrUrl }}" download class="brd_btn brd_btn_white">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                                Download QR
                            </a>
                            <a href="{{ route('contact.index') }}" class="brd_btn brd_btn_ghost">Fee enquiries</a>
                        </div>
                    </div>

                    <div class="brd_qr wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.4s">
                        <div class="brd_qr_frame">
                            <img src="{{ $qrUrl }}" alt="Fee payment QR code">
                            <span class="brd_qr_corner c1"></span><span class="brd_qr_corner c2"></span>
                            <span class="brd_qr_corner c3"></span><span class="brd_qr_corner c4"></span>
                        </div>
                        <p class="brd_qr_caption">{{ $qrCaption }}</p>
                    </div>
                </div>
            @else
                <div class="brd_empty wow fadeInUp">
                    <p class="td_fs_18 mb-2">The fee payment QR code will be available here soon.</p>
                    <a href="{{ route('contact.index') }}" class="brd_btn">Contact the school office</a>
                </div>
            @endif
        </div>
        <div class="td_height_100 td_height_lg_75"></div>
    </section>
    <!-- End Fees & Payment -->

    <!-- Start CTA -->
    <section class="brd_cta_wrap">
        <div class="container">
            <div class="brd_cta wow zoomIn" data-wow-duration="1s" data-wow-delay="0.2s">
                <div>
                    <h2 class="td_fs_36 td_white_color td_mb_10">Looking for a hostel seat?</h2>
                    <p class="td_fs_18 td_white_color td_opacity_8 mb-0">Hostel facilities are available from STD III onwards. Talk to us about availability.</p>
                </div>
                <div class="brd_cta_btns">
                    <a href="{{ route('admission') }}" class="brd_cta_btn">
                        <span>Admission Details</span>
                        <span class="brd_cta_btn_icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_75"></div>
    </section>
    <!-- End CTA -->

@endsection

@push('styles')
<style>
    /* --heading-color (site blue) is used because --accent-color is broken under td_theme_2 */
    .brd_intro, .brd_media, .brd_fees, .brd_cta_wrap, .brd_lb {
        --brd: var(--heading-color, #00539B);
        --brd-dark: #002F5F;
        --brd-soft: #F4F7FB;
        --brd-line: #E6EAF2;
    }
    .brd_accent { color: var(--brd); }
    .td_section_heading .brd_accent i::before,
    .td_section_heading .brd_accent i::after { background-color: var(--brd); }

    .td_page_heading .breadcrumb-item + .breadcrumb-item::before { content: "/" !important; color: #fff; padding: 0 8px; }

    /* ---------- Intro ---------- */
    .brd_text p, p.brd_text { font-size: 17px; line-height: 1.85; color: #3d4556; margin-bottom: 16px; }
    .brd_text p:last-child { margin-bottom: 0; }

    .brd_highlights { display: flex; flex-direction: column; gap: 16px; }
    .brd_highlights li {
        display: flex; gap: 18px; align-items: flex-start; padding: 22px 24px; border-radius: 16px; background: #fff;
        border: 1px solid var(--brd-line); border-left: 4px solid var(--brd);
        box-shadow: 0 18px 40px -30px rgba(0,0,27,.45); transition: transform .35s ease, box-shadow .35s ease;
    }
    .brd_highlights li.animated { animation-fill-mode: backwards; }
    .brd_highlights li:hover { transform: translateX(-6px); box-shadow: 0 26px 50px -30px rgba(0,0,27,.55); }
    .brd_hl_icon {
        width: 52px; height: 52px; border-radius: 14px; flex: none;
        display: flex; align-items: center; justify-content: center; background: var(--brd-soft); color: var(--brd);
        transition: background .35s ease, color .35s ease;
    }
    .brd_highlights li:hover .brd_hl_icon { background: var(--brd); color: #fff; }
    .brd_highlights h3 { margin: 2px 0 4px; font-size: 20px; font-weight: 600; color: var(--brd); }
    .brd_highlights p { color: #5b6477; line-height: 1.6; }

    /* ---------- Media ---------- */
    .brd_media { background: #F6F8FB; }
    .brd_media_head { display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; flex-wrap: wrap; }

    .brd_tabs { display: inline-flex; gap: 6px; padding: 6px; border-radius: 40px; background: #fff; border: 1px solid var(--brd-line); box-shadow: 0 14px 30px -24px rgba(0,0,27,.5); }
    .brd_tab {
        display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border: 0; border-radius: 30px;
        background: transparent; color: var(--brd); font-weight: 600; font-size: 15px; cursor: pointer; transition: all .3s ease;
    }
    .brd_tab span {
        min-width: 24px; height: 22px; padding: 0 7px; border-radius: 20px; font-size: 12px;
        display: inline-flex; align-items: center; justify-content: center; background: var(--brd-soft);
    }
    .brd_tab:hover { background: var(--brd-soft); }
    .brd_tab.is-active { background: var(--brd); color: #fff; }
    .brd_tab.is-active span { background: rgba(255,255,255,.2); }

    .brd_panel { display: none; }
    .brd_panel.is-active { display: block; animation: brdPanelIn .45s ease both; }
    @keyframes brdPanelIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }

    .brd_grid { display: grid; grid-template-columns: repeat(4, 1fr); grid-auto-rows: 220px; grid-auto-flow: dense; gap: 18px; }
    .brd_grid > .brd_tile:nth-child(7n + 1) { grid-column: span 2; grid-row: span 2; }
    .brd_grid_video { grid-template-columns: repeat(3, 1fr); grid-auto-rows: auto; }
    .brd_grid_video > .brd_tile:nth-child(n) { grid-column: auto; grid-row: auto; aspect-ratio: 16 / 9; }

    .brd_tile {
        position: relative; display: block; overflow: hidden; border-radius: 14px; background: #e6eaf2; cursor: zoom-in;
        box-shadow: 0 12px 30px -20px rgba(0,0,27,.5); transition: transform .4s ease, box-shadow .4s ease;
    }
    .brd_tile.animated { animation-fill-mode: backwards; }
    .brd_tile_video { cursor: pointer; }
    .brd_tile img, .brd_tile video, .brd_tile_blank {
        width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .8s ease;
    }
    .brd_tile_blank { background: linear-gradient(135deg, var(--brd) 0%, var(--brd-dark) 100%); }
    .brd_tile::after {
        content: ""; position: absolute; inset: 0; pointer-events: none;
        background: linear-gradient(180deg, rgba(0,0,27,0) 50%, rgba(0,0,27,.55) 100%); opacity: .6; transition: opacity .4s ease;
    }
    .brd_tile:hover { transform: translateY(-6px); box-shadow: 0 24px 40px -22px rgba(0,0,27,.6); }
    .brd_tile:hover img, .brd_tile:hover video { transform: scale(1.08); }
    .brd_tile:hover::after { opacity: 1; }
    .brd_tile:focus-visible { outline: 3px solid var(--brd); outline-offset: 3px; }

    .brd_zoom {
        position: absolute; top: 14px; right: 14px; z-index: 2; width: 42px; height: 42px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,.95); color: var(--brd);
        opacity: 0; transform: scale(.6); transition: all .4s ease;
    }
    .brd_tile:hover .brd_zoom { opacity: 1; transform: scale(1); }
    .brd_play {
        position: absolute; left: 50%; top: 50%; z-index: 2; width: 62px; height: 62px; margin: -31px 0 0 -31px;
        display: flex; align-items: center; justify-content: center; border-radius: 50%;
        background: rgba(255,255,255,.95); color: var(--brd); box-shadow: 0 0 0 10px rgba(255,255,255,.25); transition: all .35s ease;
    }
    .brd_play svg { margin-left: 3px; }
    .brd_tile:hover .brd_play { transform: scale(1.12); box-shadow: 0 0 0 14px rgba(255,255,255,.2); }

    /* Viewer */
    .brd_lb {
        position: fixed; inset: 0; z-index: 99999; display: flex; align-items: center; justify-content: center;
        visibility: hidden; opacity: 0; transition: opacity .3s ease, visibility .3s ease;
    }
    .brd_lb.is-open { visibility: visible; opacity: 1; }
    .brd_lb_bg { position: absolute; inset: 0; background: rgba(0,0,18,.95); backdrop-filter: blur(4px); }
    .brd_lb_stage {
        position: relative; z-index: 2; width: calc(100% - 200px); height: calc(100% - 140px);
        display: flex; align-items: center; justify-content: center;
    }
    .brd_lb_stage > * { animation: brdFade .35s ease both; }
    .brd_lb_stage img, .brd_lb_stage video { max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 10px; box-shadow: 0 30px 60px -20px rgba(0,0,0,.6); }
    .brd_lb_frame { width: 100%; max-width: 1100px; aspect-ratio: 16 / 9; max-height: 100%; }
    .brd_lb_frame iframe { width: 100%; height: 100%; border: 0; border-radius: 10px; }
    @keyframes brdFade { from { opacity: 0; transform: scale(.97); } to { opacity: 1; transform: none; } }
    .brd_lb_btn {
        position: absolute; z-index: 3; width: 52px; height: 52px; border-radius: 50%; border: 0; cursor: pointer;
        display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,.12); color: #fff;
        transition: background .3s ease, transform .3s ease;
    }
    .brd_lb_btn:hover { background: var(--brd); transform: scale(1.06); }
    .brd_lb_close { top: 16px; right: 20px; width: 46px; height: 46px; }
    .brd_lb_prev { left: 28px; top: 50%; margin-top: -26px; }
    .brd_lb_next { right: 28px; top: 50%; margin-top: -26px; }
    .brd_lb_count { position: absolute; top: 28px; left: 24px; z-index: 3; color: rgba(255,255,255,.75); font-size: 15px; letter-spacing: 1px; }
    body.brd_lock { overflow: hidden; }

    /* ---------- Fees & QR ---------- */
    .brd_pay {
        display: grid; grid-template-columns: 1.4fr 1fr; gap: 40px; align-items: center;
        padding: 50px 56px; border-radius: 24px; position: relative; overflow: hidden;
        background: linear-gradient(135deg, var(--brd) 0%, var(--brd-dark) 100%);
        box-shadow: 0 40px 80px -45px rgba(0,47,95,.9);
    }
    .brd_pay::before, .brd_pay::after { content: ""; position: absolute; border-radius: 50%; background: rgba(255,255,255,.06); pointer-events: none; }
    .brd_pay::before { width: 420px; height: 420px; top: -180px; left: -140px; }
    .brd_pay::after  { width: 260px; height: 260px; bottom: -120px; right: 30%; }
    .brd_pay > * { position: relative; z-index: 1; }

    .brd_pay_badge {
        display: inline-block; margin-bottom: 16px; padding: 7px 16px; border-radius: 30px;
        background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.25);
        color: #fff; font-size: 13px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;
    }
    .brd_pay_title { margin: 0 0 10px; color: #fff; font-size: 34px; font-weight: 600; line-height: 1.25; }
    .brd_pay_text { margin: 0 0 26px; color: rgba(255,255,255,.8); font-size: 17px; }

    .brd_steps { list-style: none; display: flex; flex-direction: column; gap: 12px; }
    .brd_steps li { display: flex; align-items: center; gap: 14px; color: rgba(255,255,255,.92); }
    .brd_steps b {
        flex: none; width: 34px; height: 34px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; background: #fff; color: var(--brd); font-size: 15px;
    }

    .brd_pay_btns { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 30px; }
    .brd_btn {
        display: inline-flex; align-items: center; gap: 8px; height: 50px; padding: 0 26px; border-radius: 30px;
        border: 1px solid var(--brd); background: var(--brd); color: #fff; font-weight: 600; transition: all .3s ease;
    }
    .brd_btn:hover { background: var(--brd-dark); border-color: var(--brd-dark); color: #fff; }
    .brd_btn_white { background: #fff; border-color: #fff; color: var(--brd); }
    .brd_btn_white:hover { background: transparent; border-color: #fff; color: #fff; }
    .brd_btn_ghost { background: transparent; border-color: rgba(255,255,255,.6); color: #fff; }
    .brd_btn_ghost:hover { background: #fff; border-color: #fff; color: var(--brd); }

    .brd_qr { justify-self: center; text-align: center; }
    .brd_qr_frame {
        position: relative; width: 280px; max-width: 100%; padding: 18px; border-radius: 20px; background: #fff;
        box-shadow: 0 30px 60px -25px rgba(0,0,0,.55);
    }
    .brd_qr_frame img { width: 100%; aspect-ratio: 1 / 1; object-fit: contain; display: block; border-radius: 8px; }
    .brd_qr_corner { position: absolute; width: 30px; height: 30px; border: 4px solid var(--brd); }
    .brd_qr_corner.c1 { top: -8px; left: -8px; border-right: 0; border-bottom: 0; border-radius: 12px 0 0 0; }
    .brd_qr_corner.c2 { top: -8px; right: -8px; border-left: 0; border-bottom: 0; border-radius: 0 12px 0 0; }
    .brd_qr_corner.c3 { bottom: -8px; left: -8px; border-right: 0; border-top: 0; border-radius: 0 0 0 12px; }
    .brd_qr_corner.c4 { bottom: -8px; right: -8px; border-left: 0; border-top: 0; border-radius: 0 0 12px 0; }
    .brd_qr_frame::after {
        content: ""; position: absolute; left: 18px; right: 18px; top: 18px; height: 3px; border-radius: 3px;
        background: linear-gradient(90deg, transparent, #3ddc84, transparent); box-shadow: 0 0 12px #3ddc84;
        animation: brdScan 2.6s ease-in-out infinite;
    }
    @keyframes brdScan { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(calc(280px - 60px)); } }
    .brd_qr_caption {
        display: inline-block; margin: 22px 0 0; padding: 8px 18px; border-radius: 30px;
        background: rgba(255,255,255,.12); color: #fff; font-weight: 600; font-size: 15px;
    }

    .brd_empty { text-align: center; padding: 50px 20px; border: 2px dashed var(--brd-line); border-radius: 16px; color: #6b7489; background: #fff; }

    /* ---------- CTA ---------- */
    .brd_cta {
        display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap;
        padding: 44px 50px; border-radius: 22px; position: relative; overflow: hidden;
        background: linear-gradient(135deg, var(--brd) 0%, var(--brd-dark) 100%);
        box-shadow: 0 30px 60px -35px rgba(0,47,95,.8);
    }
    .brd_cta::before { content: ""; position: absolute; width: 300px; height: 300px; border-radius: 50%; right: -90px; top: -120px; background: rgba(255,255,255,.07); }
    .brd_cta > * { position: relative; z-index: 1; }
    .brd_cta_btn {
        display: inline-flex; align-items: center; gap: 12px; padding: 6px 6px 6px 24px; border-radius: 30px;
        background: #fff; color: var(--brd); font-weight: 600; transition: box-shadow .3s ease, transform .3s ease;
    }
    .brd_cta_btn_icon {
        width: 40px; height: 40px; border-radius: 50%; flex: none; display: flex; align-items: center; justify-content: center;
        background: var(--brd); color: #fff; transition: transform .3s ease;
    }
    .brd_cta_btn:hover { color: var(--brd); transform: translateY(-2px); box-shadow: 0 14px 28px -14px rgba(0,0,0,.5); }
    .brd_cta_btn:hover .brd_cta_btn_icon { transform: translateX(4px) rotate(-45deg); }

    /* ---------- Responsive ---------- */
    @media (max-width: 1199px) {
        .brd_grid { grid-template-columns: repeat(3, 1fr); grid-auto-rows: 200px; }
        .brd_pay { padding: 44px 40px; gap: 30px; }
    }
    @media (max-width: 991px) {
        .brd_pay { grid-template-columns: 1fr; }
        .brd_qr { order: -1; }
        .brd_grid_video { grid-template-columns: repeat(2, 1fr); }
        .brd_lb_stage { width: calc(100% - 140px); }
        .brd_lb_prev { left: 14px; } .brd_lb_next { right: 14px; }
        .brd_highlights li:hover { transform: none; }
    }
    @media (max-width: 767px) {
        .brd_grid { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 160px; gap: 12px; }
        .brd_grid_video { grid-template-columns: 1fr; }
        .brd_tile:hover { transform: none; }
        .brd_zoom { display: none; }
        .brd_play { width: 50px; height: 50px; margin: -25px 0 0 -25px; }
        .brd_tabs { width: 100%; }
        .brd_tab { flex: 1; justify-content: center; }
        .brd_lb_stage { width: 100%; height: calc(100% - 180px); padding: 0 10px; }
        .brd_lb_prev, .brd_lb_next { top: auto; bottom: 40px; margin: 0; width: 44px; height: 44px; }
        .brd_cta { padding: 32px 24px; }
    }
    @media (max-width: 575px) {
        .brd_pay { padding: 32px 20px; border-radius: 18px; }
        .brd_pay_title { font-size: 26px; }
        .brd_qr_frame { width: 230px; }
        @keyframes brdScan { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(calc(230px - 60px)); } }
        .brd_pay_btns .brd_btn { flex: 1 1 100%; justify-content: center; }
        .brd_highlights li { padding: 18px; }
        .brd_cta_btn { width: 100%; justify-content: space-between; }
    }
    @media (prefers-reduced-motion: reduce) { .brd_qr_frame::after { animation: none; display: none; } }
</style>
@endpush

@push('scripts')
<script>
(function () {
    function init() {
        /* ---------- Images / Videos tabs ---------- */
        var tabs   = document.querySelectorAll('.brd_tab');
        var panels = document.querySelectorAll('.brd_panel');
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var name = tab.getAttribute('data-panel');
                tabs.forEach(function (t) {
                    var on = t === tab;
                    t.classList.toggle('is-active', on);
                    t.setAttribute('aria-selected', on ? 'true' : 'false');
                });
                panels.forEach(function (p) { p.classList.toggle('is-active', p.getAttribute('data-panel') === name); });
                loadVideoFrames();
                // Let WOW reveal tiles that just became visible
                window.dispatchEvent(new Event('scroll'));
            });
        });

        /* ---------- First frame of uploaded videos, loaded only when visible ---------- */
        var io = 'IntersectionObserver' in window ? new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (!e.isIntersecting) return;
                e.target.preload = 'metadata';
                e.target.src = e.target.getAttribute('data-lazy-src');
                io.unobserve(e.target);
            });
        }, { rootMargin: '200px' }) : null;
        function loadVideoFrames() {
            document.querySelectorAll('.brd_panel.is-active video[data-lazy-src]:not([src])').forEach(function (v) {
                if (io) io.observe(v); else v.src = v.getAttribute('data-lazy-src');
            });
        }
        loadVideoFrames();

        /* ---------- Viewer (images, uploaded videos, YouTube / Vimeo) ---------- */
        var lb = document.getElementById('brdLb');
        if (!lb) return;
        var stage   = lb.querySelector('.brd_lb_stage');
        var countEl = lb.querySelector('.brd_lb_count');
        var list = [], current = 0;

        function show(i) {
            current = (i + list.length) % list.length;
            var d = list[current].dataset, node;
            stage.innerHTML = '';
            if (d.kind === 'image') {
                node = document.createElement('img'); node.src = d.src; node.alt = '';
            } else if (d.kind === 'video') {
                node = document.createElement('video');
                node.src = d.src; node.controls = true; node.autoplay = true; node.playsInline = true;
            } else {
                node = document.createElement('div'); node.className = 'brd_lb_frame';
                var f = document.createElement('iframe');
                f.src = d.src; f.title = 'Boarding video';
                f.allow = 'autoplay; fullscreen; picture-in-picture'; f.allowFullscreen = true;
                node.appendChild(f);
            }
            stage.appendChild(node);
            countEl.textContent = (current + 1) + ' / ' + list.length;
            var single = list.length < 2;
            lb.querySelector('.brd_lb_prev').hidden = single;
            lb.querySelector('.brd_lb_next').hidden = single;
        }
        function open(tile) {
            // Browse only within the same tab (images or videos)
            list = Array.prototype.slice.call(tile.closest('.brd_panel').querySelectorAll('.brd_tile'));
            show(list.indexOf(tile));
            lb.classList.add('is-open'); lb.setAttribute('aria-hidden', 'false');
            document.body.classList.add('brd_lock');
        }
        function close() {
            lb.classList.remove('is-open'); lb.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('brd_lock');
            stage.innerHTML = '';   // stops any playing video
        }

        document.querySelectorAll('.brd_tile').forEach(function (tile) {
            tile.addEventListener('click', function (e) { e.preventDefault(); open(tile); });
        });
        lb.querySelector('.brd_lb_prev').addEventListener('click', function () { show(current - 1); });
        lb.querySelector('.brd_lb_next').addEventListener('click', function () { show(current + 1); });
        lb.querySelectorAll('[data-close]').forEach(function (el) { el.addEventListener('click', close); });
        document.addEventListener('keydown', function (e) {
            if (!lb.classList.contains('is-open')) return;
            if (e.key === 'Escape') close();
            if (e.key === 'ArrowLeft') show(current - 1);
            if (e.key === 'ArrowRight') show(current + 1);
        });

        var sx = null;
        stage.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
        stage.addEventListener('touchend', function (e) {
            if (sx === null) return;
            var dx = e.changedTouches[0].clientX - sx;
            if (Math.abs(dx) > 50 && list.length > 1) show(current + (dx < 0 ? 1 : -1));
            sx = null;
        });
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
</script>
@endpush