@extends('web.layouts.app')

@php
    $isDetail = isset($notice) && $notice;
    $types    = \App\Models\NewsNotice::TYPES;

    // ---- small helpers ----
    $dateOf  = fn ($n) => $n->published_at ?? $n->created_at;
    $urlOf   = fn ($n) => route('news-notices.show', [$n, \Illuminate\Support\Str::slug($n->title) ?: 'notice']);
    $excerpt = fn ($n, $len = 170) => \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $n->description))), $len);

    $typeIcons = [
        'notice'       => '<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>',
        'circular'     => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/>',
        'announcement' => '<path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>',
    ];
    $icon = fn ($type, $size = 16) => '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">'.($typeIcons[$type] ?? $typeIcons['notice']).'</svg>';

    $pageTitle = $isDetail ? ($notice->meta_title ?: $notice->title) : 'News & Notices';
@endphp

@section('title', $pageTitle . ' || AL-Azhar')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@section('content')

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
        data-src="{{ asset('uploads/website-images/students-after-graduation-ceremony.jpg') }}">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10 nn_heading_title">{{ $isDetail ? $notice->title : 'News & Notices' }}</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    @if ($isDetail)
                        <li class="breadcrumb-item"><a href="{{ route('news-notices.index') }}">News &amp; Notices</a></li>
                        <li class="breadcrumb-item active">{{ $types[$notice->type] ?? 'Notice' }}</li>
                    @else
                        <li class="breadcrumb-item active">News &amp; Notices</li>
                    @endif
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

    <section class="nn_section">
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">

            @unless ($isDetail)
                {{-- ================= SEARCH BAR ================= --}}
                <form action="{{ route('news-notices.index') }}" method="GET" class="nn_search" role="search">
                    <div class="nn_search_field nn_search_q">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                        <input type="search" name="q" value="{{ $search }}" placeholder="Search notices, circulars, announcements…" aria-label="Search">
                    </div>
                    <div class="nn_search_field">
                        <select name="type" aria-label="Type">
                            <option value="">All Types</option>
                            @foreach ($types as $key => $label)
                                <option value="{{ $key }}" @selected($type === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="nn_search_field">
                        <select name="year" aria-label="Year">
                            <option value="">All Years</option>
                            @foreach ($years as $y => $count)
                                <option value="{{ $y }}" @selected($year === (int) $y)>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="nn_btn">Search</button>
                </form>

                {{-- Type chips --}}
                <div class="nn_chips">
                    <a href="{{ route('news-notices.index', array_filter(['q' => $search, 'year' => $year ?: null])) }}"
                        class="nn_chip {{ $type === '' ? 'is-active' : '' }}">All <span>{{ $totalPublished }}</span></a>
                    @foreach ($types as $key => $label)
                        <a href="{{ route('news-notices.index', array_filter(['q' => $search, 'type' => $key, 'year' => $year ?: null])) }}"
                            class="nn_chip {{ $type === $key ? 'is-active' : '' }}">
                            {!! $icon($key, 15) !!} {{ \Illuminate\Support\Str::plural($label) }} <span>{{ $typeCounts[$key] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- ================= PRIORITY STRIP ================= --}}
                @if ($highlights->isNotEmpty())
                    <div class="nn_highlights">
                        <div class="nn_block_title">
                            <span class="nn_pulse"></span>
                            <h2 class="td_fs_24 td_semibold mb-0">Priority Notices</h2>
                        </div>
                        <div class="row td_gap_y_24">
                            @foreach ($highlights as $h)
                                <div class="col-lg-4 col-md-6">
                                    <a href="{{ $urlOf($h) }}" class="nn_hcard nn_p_{{ $h->priority ?: 'normal' }} {{ $h->image_url ? 'has-img' : '' }}">
                                        @if ($h->image_url)
                                            <div class="nn_hcard_img">
                                                <img src="{{ $h->image_url }}" alt="{{ $h->title }}" loading="lazy">
                                            </div>
                                        @endif
                                        <div class="nn_hcard_top">
                                            <span class="nn_prio nn_prio_{{ $h->priority ?: 'normal' }}">
                                                {{ $h->is_pinned && $h->priority === 'normal' ? 'Pinned' : $h->priority_label }}
                                            </span>
                                            <span class="nn_hcard_date">{{ $dateOf($h)->format('d M Y') }}</span>
                                        </div>
                                        <h3 class="td_fs_20 td_semibold mb-0">{{ $h->title }}</h3>
                                        <span class="nn_more">Read notice
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                        </span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endunless

            <div class="row td_gap_y_50">
                {{-- ================= MAIN COLUMN ================= --}}
                <div class="col-lg-8">

                    @if ($isDetail)
                        {{-- ---------- DETAIL ---------- --}}
                        @php
                            $d = $dateOf($notice);
                            $description = trim((string) $notice->description);
                            $isHtml = $description !== strip_tags($description);

                            $attUrl = $notice->attachment ? \Illuminate\Support\Facades\Storage::url($notice->attachment) : null;
                            $attExt = $notice->attachment ? strtolower(pathinfo($notice->attachment, PATHINFO_EXTENSION)) : null;
                            $attIsImage = in_array($attExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true);
                            $shareUrl = url()->current();
                        @endphp

                        <article class="nn_article">
                            <div class="nn_article_head">
                                <div class="nn_date">
                                    <strong>{{ $d->format('d') }}</strong>
                                    <span>{{ $d->format('M') }}</span>
                                    <small>{{ $d->format('Y') }}</small>
                                </div>
                                <div class="nn_article_meta">
                                    <div class="nn_tags">
                                        <span class="nn_type">{!! $icon($notice->type) !!} {{ $types[$notice->type] ?? 'Notice' }}</span>
                                        @if ($notice->priority && $notice->priority !== 'normal')
                                            <span class="nn_prio nn_prio_{{ $notice->priority }}">{{ $notice->priority_label }}</span>
                                        @endif
                                        @if ($notice->is_pinned)
                                            <span class="nn_pin">📌 Pinned</span>
                                        @endif
                                    </div>
                                    <h2 class="td_fs_36 td_semibold mb-0">{{ $notice->title }}</h2>
                                    <p class="nn_published mb-0">Published on {{ $d->format('l, d F Y') }}</p>
                                </div>
                            </div>

                            @if ($notice->image_url)
                                <a href="{{ $notice->image_url }}" target="_blank" rel="noopener" class="nn_cover">
                                    <img src="{{ $notice->image_url }}" alt="{{ $notice->title }}">
                                </a>
                            @endif

                            @if ($description !== '')
                                <div class="nn_body td_fs_18">
                                    @if ($isHtml)
                                        {!! strip_tags($description, '<p><br><strong><b><em><i><u><ul><ol><li><a><h3><h4><h5><span><blockquote><table><thead><tbody><tr><th><td>') !!}
                                    @else
                                        @foreach (preg_split('/\R{2,}/', $description) as $para)
                                            @if (trim($para) !== '') <p>{!! nl2br(e(trim($para))) !!}</p> @endif
                                        @endforeach
                                    @endif
                                </div>
                            @endif

                            @if ($attUrl && $attIsImage)
                                <a href="{{ $attUrl }}" target="_blank" rel="noopener" class="nn_attach_img">
                                    <img src="{{ $attUrl }}" alt="{{ $notice->title }}" loading="lazy">
                                </a>
                            @endif

                            @if ($attUrl || $notice->link)
                                <div class="nn_attach">
                                    @if ($attUrl)
                                        <div class="nn_attach_file">
                                            <span class="nn_attach_icon">{{ strtoupper($attExt ?: 'FILE') }}</span>
                                            <div class="nn_attach_info">
                                                <strong>Attachment</strong>
                                                <small>{{ \Illuminate\Support\Str::limit(basename($notice->attachment), 40) }}</small>
                                            </div>
                                            <div class="nn_attach_actions">
                                                <a href="{{ $attUrl }}" target="_blank" rel="noopener" class="nn_btn nn_btn_outline">View</a>
                                                <a href="{{ $attUrl }}" download class="nn_btn">Download</a>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($notice->link)
                                        <a href="{{ $notice->link }}" target="_blank" rel="noopener" class="nn_btn nn_btn_link">
                                            Open related link
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6M10 14 21 3M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <div class="nn_share">
                                <span class="td_semibold td_heading_color">Share:</span>
                                <a href="https://wa.me/?text={{ urlencode($notice->title . ' ' . $shareUrl) }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.5 14.4c-.3-.1-1.8-.9-2-1s-.5-.1-.7.1-.8 1-.9 1.2-.3.2-.6.1a8 8 0 0 1-4-3.5c-.3-.5.3-.5.8-1.6.1-.2 0-.4 0-.5l-.9-2.2c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4s-1 1-1 2.5 1.1 2.9 1.2 3.1 2.1 3.2 5.1 4.5c1.9.8 2.6.9 3.6.7.6-.1 1.8-.7 2-1.4s.3-1.3.2-1.4-.3-.2-.6-.3zM12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2z"/></svg>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener" aria-label="Share on Facebook">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12.06C22 6.51 17.52 2 12 2S2 6.51 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.89h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94z"/></svg>
                                </a>
                                <button type="button" class="nn_copy" data-url="{{ $shareUrl }}" aria-label="Copy link">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7l-1.7 1.7"/><path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7l1.7-1.7"/></svg>
                                    <span>Copy link</span>
                                </button>
                            </div>
                        </article>

                        {{-- Prev / next --}}
                        @if ($newer || $older)
                            <div class="nn_pager">
                                @if ($older)
                                    <a href="{{ $urlOf($older) }}" class="nn_pager_item">
                                        <small>← Previous</small>
                                        <span>{{ \Illuminate\Support\Str::limit($older->title, 60) }}</span>
                                    </a>
                                @else <span></span> @endif
                                @if ($newer)
                                    <a href="{{ $urlOf($newer) }}" class="nn_pager_item text-end">
                                        <small>Next →</small>
                                        <span>{{ \Illuminate\Support\Str::limit($newer->title, 60) }}</span>
                                    </a>
                                @endif
                            </div>
                        @endif

                        <a href="{{ route('news-notices.index') }}" class="nn_back">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                            Back to all notices
                        </a>

                    @else
                        {{-- ---------- LIST ---------- --}}
                        <div class="nn_list_head">
                            <h2 class="td_fs_24 td_semibold mb-0">
                                @if ($filtering)
                                    {{ $notices->total() }} {{ \Illuminate\Support\Str::plural('result', $notices->total()) }}
                                    @if ($search) for “{{ $search }}” @endif
                                @else
                                    Latest Updates
                                @endif
                            </h2>
                            @if ($filtering)
                                <a href="{{ route('news-notices.index') }}" class="nn_clear">Clear filters ✕</a>
                            @endif
                        </div>

                        @forelse ($notices as $n)
                            @php $d = $dateOf($n); @endphp
                            <article class="nn_item nn_p_{{ $n->priority ?: 'normal' }} {{ $n->is_pinned ? 'is-pinned' : '' }} {{ $n->image_url ? 'has-img' : '' }}">
                                @if ($n->image_url)
                                    <a href="{{ $urlOf($n) }}" class="nn_item_img" aria-hidden="true" tabindex="-1">
                                        <img src="{{ $n->image_url }}" alt="" loading="lazy">
                                        <span class="nn_item_img_date">
                                            <strong>{{ $d->format('d') }}</strong>
                                            <span>{{ $d->format('M Y') }}</span>
                                        </span>
                                    </a>
                                @else
                                    <a href="{{ $urlOf($n) }}" class="nn_date" aria-hidden="true" tabindex="-1">
                                        <strong>{{ $d->format('d') }}</strong>
                                        <span>{{ $d->format('M') }}</span>
                                        <small>{{ $d->format('Y') }}</small>
                                    </a>
                                @endif
                                <div class="nn_item_body">
                                    <div class="nn_tags">
                                        <span class="nn_type">{!! $icon($n->type) !!} {{ $types[$n->type] ?? 'Notice' }}</span>
                                        @if ($n->priority && $n->priority !== 'normal')
                                            <span class="nn_prio nn_prio_{{ $n->priority }}">{{ $n->priority_label }}</span>
                                        @endif
                                        @if ($n->is_pinned)
                                            <span class="nn_pin">📌 Pinned</span>
                                        @endif
                                        @if ($d->gte(now()->subDays(7)))
                                            <span class="nn_new">New</span>
                                        @endif
                                    </div>
                                    <h3 class="td_fs_20 td_semibold mb-0"><a href="{{ $urlOf($n) }}">{{ $n->title }}</a></h3>
                                    @if ($excerpt($n))
                                        <p class="nn_excerpt mb-0">{{ $excerpt($n) }}</p>
                                    @endif
                                    <div class="nn_item_foot">
                                        <a href="{{ $urlOf($n) }}" class="nn_more">Read more
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                        </a>
                                        @if ($n->attachment)
                                            <span class="nn_has_file">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.4 11-9.2 9.2a6 6 0 0 1-8.5-8.5l9.2-9.2a4 4 0 0 1 5.7 5.7l-9.2 9.2a2 2 0 0 1-2.8-2.8l8.5-8.5"/></svg>
                                                Attachment
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="nn_empty">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3M8 11h6"/></svg>
                                <h3 class="td_fs_20 td_semibold">No notices found</h3>
                                <p class="mb-0">Try a different keyword, type or year.</p>
                            </div>
                        @endforelse

                        {{-- Pagination (theme style) --}}
                        @if ($notices->hasPages())
                            @php
                                $cur  = $notices->currentPage();
                                $last = $notices->lastPage();
                                $from = max(1, $cur - 2);
                                $to   = min($last, $cur + 2);
                            @endphp
                            <ul class="td_page_pagination td_mp_0 td_fs_18 td_semibold nn_pagination">
                                @if ($cur > 1)
                                    <li><a class="td_page_pagination_item td_center" href="{{ $notices->previousPageUrl() }}" aria-label="Previous">‹</a></li>
                                @endif
                                @for ($p = $from; $p <= $to; $p++)
                                    <li><a class="td_page_pagination_item td_center {{ $p === $cur ? 'active' : '' }}" href="{{ $notices->url($p) }}">{{ $p }}</a></li>
                                @endfor
                                @if ($cur < $last)
                                    <li><a class="td_page_pagination_item td_center" href="{{ $notices->nextPageUrl() }}" aria-label="Next">›</a></li>
                                @endif
                            </ul>
                        @endif
                    @endif
                </div>

                {{-- ================= SIDEBAR ================= --}}
                <aside class="col-lg-4">
                    <div class="nn_sidebar">

                        @if ($isDetail)
                            <div class="nn_widget">
                                <h3 class="nn_widget_title">Search Notices</h3>
                                <form action="{{ route('news-notices.index') }}" method="GET" class="nn_side_search">
                                    <input type="search" name="q" placeholder="Search…" aria-label="Search">
                                    <button type="submit" aria-label="Search">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
                                    </button>
                                </form>
                            </div>
                        @endif

                        <div class="nn_widget">
                            <h3 class="nn_widget_title">Categories</h3>
                            <ul class="nn_cat_list td_mp_0">
                                @foreach ($types as $key => $label)
                                    <li>
                                        <a href="{{ route('news-notices.index', ['type' => $key]) }}"
                                            class="{{ (! $isDetail && $type === $key) ? 'is-active' : '' }}">
                                            <span class="nn_cat_icon">{!! $icon($key, 18) !!}</span>
                                            {{ \Illuminate\Support\Str::plural($label) }}
                                            <b>{{ $typeCounts[$key] ?? 0 }}</b>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @if ($years->isNotEmpty())
                            <div class="nn_widget">
                                <h3 class="nn_widget_title">Archive</h3>
                                <div class="nn_years">
                                    @foreach ($years as $y => $count)
                                        <a href="{{ route('news-notices.index', ['year' => $y]) }}"
                                            class="{{ (! $isDetail && $year === (int) $y) ? 'is-active' : '' }}">
                                            {{ $y }} <span>{{ $count }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($recent->isNotEmpty())
                            <div class="nn_widget">
                                <h3 class="nn_widget_title">Recent Updates</h3>
                                <ul class="nn_recent td_mp_0">
                                    @foreach ($recent as $r)
                                        <li>
                                            <a href="{{ $urlOf($r) }}" class="{{ $r->image_url ? 'has-img' : '' }}">
                                                @if ($r->image_url)
                                                    <img src="{{ $r->image_url }}" alt="" class="nn_recent_img" loading="lazy">
                                                @endif
                                                <span class="nn_recent_text">
                                                    <span class="nn_recent_date">{{ $dateOf($r)->format('d M Y') }}</span>
                                                    <span class="nn_recent_title">{{ $r->title }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- TODO: replace with your real phone / email --}}
                        <div class="nn_help">
                            <h3 class="td_fs_20 td_semibold td_white_color td_mb_10">Have a question?</h3>
                            <p class="td_white_color td_opacity_8 td_mb_20">Contact the school office for any clarification about a notice.</p>
                            <a href="{{ route('contact.index') }}" class="nn_btn nn_btn_white">Contact Us</a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>

@endsection

@push('styles')
<style>
    /* --heading-color is used instead of --accent-color (broken under td_theme_2) */
    .nn_section {
        --nn-accent: var(--heading-color, #00539B);
        --nn-dark: #002F5F;
        --nn-soft: #F4F7FB;
        --nn-line: #E6EAF2;
        --nn-urgent: #dc3545;
        --nn-important: #f59f00;
    }
    .nn_heading_title { max-width: 900px; margin-left: auto; margin-right: auto; }

    /* ---------- Buttons ---------- */
    .nn_btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 12px 26px; border: 1px solid var(--nn-accent); border-radius: 30px;
        background: var(--nn-accent); color: #fff; font-weight: 500; white-space: nowrap;
        transition: all .3s ease;
    }
    .nn_btn:hover { background: var(--nn-dark); border-color: var(--nn-dark); color: #fff; }
    .nn_btn_outline { background: transparent; color: var(--nn-accent); }
    .nn_btn_outline:hover { background: var(--nn-accent); color: #fff; }
    .nn_btn_white { background: #fff; border-color: #fff; color: var(--nn-accent); }
    .nn_btn_white:hover { background: transparent; color: #fff; border-color: #fff; }

    /* ---------- Search ---------- */
    .nn_search {
        display: flex; gap: 12px; padding: 12px; border-radius: 16px;
        background: #fff; box-shadow: 0 20px 50px -25px rgba(0, 0, 27, .25);
        border: 1px solid var(--nn-line);
    }
    .nn_search_field {
        display: flex; align-items: center; gap: 10px;
        background: var(--nn-soft); border-radius: 12px; padding: 0 16px; min-width: 160px;
    }
    .nn_search_q { flex: 1; color: #8a93a6; }
    .nn_search input, .nn_search select {
        border: 0; outline: 0; background: transparent; width: 100%;
        height: 52px; color: var(--nn-accent); font-weight: 500;
    }
    .nn_search select { cursor: pointer; }

    .nn_chips { display: flex; flex-wrap: wrap; gap: 10px; margin: 22px 0 50px; }
    .nn_chip {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 16px; border-radius: 30px; border: 1px solid var(--nn-line);
        background: #fff; color: var(--nn-accent); font-weight: 500; font-size: 15px;
    }
    .nn_chip span {
        min-width: 22px; height: 22px; padding: 0 6px; border-radius: 20px; font-size: 12px;
        display: inline-flex; align-items: center; justify-content: center;
        background: var(--nn-soft);
    }
    .nn_chip:hover { border-color: var(--nn-accent); color: var(--nn-accent); }
    .nn_chip.is-active { background: var(--nn-accent); border-color: var(--nn-accent); color: #fff; }
    .nn_chip.is-active span { background: rgba(255, 255, 255, .2); }

    /* ---------- Priority strip ---------- */
    .nn_highlights { margin-bottom: 60px; }
    .nn_block_title { display: flex; align-items: center; gap: 12px; margin-bottom: 22px; }
    .nn_pulse {
        width: 12px; height: 12px; border-radius: 50%; background: var(--nn-urgent); position: relative;
    }
    .nn_pulse::after {
        content: ""; position: absolute; inset: -6px; border-radius: 50%;
        border: 2px solid var(--nn-urgent); animation: nnPulse 1.6s ease-out infinite;
    }
    @keyframes nnPulse { from { transform: scale(.6); opacity: 1; } to { transform: scale(1.6); opacity: 0; } }

    .nn_hcard {
        display: flex; flex-direction: column; gap: 14px; height: 100%;
        padding: 24px; border-radius: 16px; background: #fff; position: relative; overflow: hidden;
        border: 1px solid var(--nn-line); border-top: 4px solid var(--nn-accent);
        box-shadow: 0 18px 40px -28px rgba(0, 0, 27, .4); transition: transform .35s ease, box-shadow .35s ease;
    }
    .nn_hcard.nn_p_urgent { border-top-color: var(--nn-urgent); }
    .nn_hcard.nn_p_important { border-top-color: var(--nn-important); }
    .nn_hcard:hover { transform: translateY(-6px); box-shadow: 0 26px 50px -28px rgba(0, 0, 27, .5); }
    .nn_hcard h3 { color: var(--nn-accent); line-height: 1.4; }
    .nn_hcard_top { display: flex; justify-content: space-between; align-items: center; gap: 10px; }
    .nn_hcard_date { font-size: 14px; color: #6b7489; }
    .nn_hcard .nn_more { margin-top: auto; }

    /* ---------- Tags ---------- */
    .nn_tags { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 10px; }
    .nn_type, .nn_prio, .nn_pin, .nn_new {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 3px 12px; border-radius: 30px; font-size: 13px; font-weight: 600; line-height: 1.6;
    }
    .nn_type { background: var(--nn-soft); color: var(--nn-accent); }
    .nn_prio_normal { background: #eef0f4; color: #5b6477; }
    .nn_prio_important { background: #fff4db; color: #a86a00; }
    .nn_prio_urgent { background: #fde8ea; color: var(--nn-urgent); }
    .nn_pin { background: #eef4ff; color: var(--nn-accent); }
    .nn_new { background: #e6f7ee; color: #198754; }

    /* ---------- Date badge ---------- */
    .nn_date {
        flex: none; width: 86px; border-radius: 14px; overflow: hidden; text-align: center;
        background: #fff; border: 1px solid var(--nn-line);
        box-shadow: 0 10px 24px -18px rgba(0, 0, 27, .5);
        display: flex; flex-direction: column;
    }
    .nn_date strong {
        display: block; padding: 10px 0 4px; font-size: 32px; line-height: 1; color: #fff;
        background: var(--nn-accent);
    }
    .nn_date span {
        display: block; padding-bottom: 8px; background: var(--nn-accent); color: rgba(255,255,255,.9);
        font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;
    }
    .nn_date small { display: block; padding: 6px 0; font-size: 14px; font-weight: 600; color: var(--nn-accent); }

    /* ---------- List ---------- */
    .nn_list_head { display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 24px; }
    .nn_clear { color: var(--nn-urgent); font-weight: 500; font-size: 15px; }

    .nn_item {
        display: flex; gap: 22px; padding: 24px; margin-bottom: 20px;
        border-radius: 16px; background: #fff; border: 1px solid var(--nn-line);
        border-left: 4px solid transparent; position: relative;
        transition: box-shadow .35s ease, transform .35s ease, border-color .35s ease;
    }
    .nn_item:hover { box-shadow: 0 22px 45px -30px rgba(0, 0, 27, .45); transform: translateX(4px); border-left-color: var(--nn-accent); }
    .nn_item.nn_p_important { border-left-color: var(--nn-important); }
    .nn_item.nn_p_urgent { border-left-color: var(--nn-urgent); background: linear-gradient(90deg, #fff7f8 0%, #fff 40%); }
    .nn_item.nn_p_urgent .nn_date strong, .nn_item.nn_p_urgent .nn_date span { background: var(--nn-urgent); }
    .nn_item.nn_p_urgent .nn_date small { color: var(--nn-urgent); }
    .nn_item.is-pinned { background: linear-gradient(90deg, #f4f8ff 0%, #fff 45%); }

    .nn_item_body { flex: 1; min-width: 0; }
    .nn_item h3 a { color: var(--nn-accent); }
    .nn_item h3 a:hover { color: var(--nn-dark); }
    .nn_excerpt { margin-top: 8px; color: #5b6477; line-height: 1.65; }
    .nn_item_foot { display: flex; align-items: center; gap: 18px; margin-top: 14px; flex-wrap: wrap; }
    .nn_more { display: inline-flex; align-items: center; gap: 6px; font-weight: 600; color: var(--nn-accent); font-size: 15px; }
    .nn_more svg { transition: transform .3s ease; }
    .nn_more:hover svg, .nn_hcard:hover .nn_more svg { transform: translateX(4px); }
    .nn_has_file { display: inline-flex; align-items: center; gap: 6px; font-size: 14px; color: #6b7489; }

    .nn_empty { text-align: center; padding: 60px 20px; border: 2px dashed var(--nn-line); border-radius: 16px; color: #6b7489; }
    .nn_empty svg { color: var(--nn-accent); opacity: .5; margin-bottom: 12px; }
    .nn_pagination { justify-content: flex-start; margin-top: 30px; }
    .nn_pagination .td_page_pagination_item { border-color: var(--nn-accent); color: var(--nn-accent); }
    .nn_pagination .td_page_pagination_item.active,
    .nn_pagination .td_page_pagination_item:hover { background: var(--nn-accent); color: #fff; }

    /* ---------- Article ---------- */
    .nn_article {
        padding: 40px; border-radius: 18px; background: #fff; border: 1px solid var(--nn-line);
        box-shadow: 0 30px 60px -40px rgba(0, 0, 27, .35);
    }
    .nn_article_head { display: flex; gap: 24px; align-items: flex-start; padding-bottom: 26px; border-bottom: 1px solid var(--nn-line); }
    .nn_article_head h2 { color: var(--nn-accent); line-height: 1.3; }
    .nn_published { margin-top: 10px; color: #6b7489; font-size: 15px; }
    .nn_body { padding-top: 26px; color: #3d4556; line-height: 1.85; }
    .nn_body p { margin-bottom: 18px; }
    .nn_body ul, .nn_body ol { margin-bottom: 18px; }
    .nn_body a { color: var(--nn-accent); text-decoration: underline; }
    .nn_body table { border: 1px solid var(--nn-line); }

    .nn_attach_img { display: block; margin-top: 26px; border-radius: 12px; overflow: hidden; border: 1px solid var(--nn-line); }
    .nn_attach_img img { width: 100%; }
    .nn_attach { margin-top: 30px; display: flex; flex-direction: column; gap: 14px; align-items: flex-start; }
    .nn_attach_file {
        display: flex; align-items: center; gap: 16px; width: 100%;
        padding: 16px 18px; border-radius: 14px; background: var(--nn-soft); border: 1px dashed #c9d3e6;
    }
    .nn_attach_icon {
        flex: none; width: 52px; height: 58px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        background: var(--nn-urgent); color: #fff; font-weight: 700; font-size: 12px;
    }
    .nn_attach_info { flex: 1; min-width: 0; display: flex; flex-direction: column; }
    .nn_attach_info strong { color: var(--nn-accent); }
    .nn_attach_info small { color: #6b7489; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .nn_attach_actions { display: flex; gap: 10px; }
    .nn_attach_actions .nn_btn { padding: 9px 18px; font-size: 15px; }
    .nn_btn_link { background: #fff; color: var(--nn-accent); }
    .nn_btn_link:hover { background: var(--nn-accent); color: #fff; }

    .nn_share { display: flex; align-items: center; gap: 10px; margin-top: 32px; padding-top: 22px; border-top: 1px solid var(--nn-line); flex-wrap: wrap; }
    .nn_share a, .nn_copy {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        height: 40px; min-width: 40px; padding: 0 12px; border-radius: 30px; border: 0;
        background: var(--nn-soft); color: var(--nn-accent); font-size: 14px; font-weight: 500;
        transition: all .3s ease;
    }
    .nn_share a:hover, .nn_copy:hover { background: var(--nn-accent); color: #fff; }

    .nn_pager { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 26px; }
    .nn_pager_item {
        display: flex; flex-direction: column; gap: 4px; padding: 18px 22px; border-radius: 14px;
        border: 1px solid var(--nn-line); background: #fff; transition: all .3s ease;
    }
    .nn_pager_item small { color: #6b7489; font-weight: 600; }
    .nn_pager_item span { color: var(--nn-accent); font-weight: 600; }
    .nn_pager_item:hover { border-color: var(--nn-accent); box-shadow: 0 16px 34px -26px rgba(0,0,27,.5); }
    .nn_back { display: inline-flex; align-items: center; gap: 8px; margin-top: 26px; font-weight: 600; color: var(--nn-accent); }

    /* ---------- Sidebar ---------- */
    .nn_sidebar { position: sticky; top: 120px; display: flex; flex-direction: column; gap: 26px; }
    .nn_widget { padding: 26px; border-radius: 16px; background: #fff; border: 1px solid var(--nn-line); }
    .nn_widget_title {
        font-size: 20px; font-weight: 600; color: var(--nn-accent);
        padding-bottom: 12px; margin-bottom: 18px; border-bottom: 1px solid var(--nn-line); position: relative;
    }
    .nn_widget_title::after {
        content: ""; position: absolute; left: 0; bottom: -2px; width: 40px; height: 3px; border-radius: 5px;
        background: var(--nn-accent);
    }
    .nn_cat_list li + li { margin-top: 8px; }
    .nn_cat_list a {
        display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 12px;
        color: var(--nn-accent); font-weight: 500; transition: all .3s ease;
    }
    .nn_cat_list a b {
        margin-left: auto; min-width: 28px; height: 24px; padding: 0 8px; border-radius: 20px;
        display: inline-flex; align-items: center; justify-content: center; font-size: 13px;
        background: var(--nn-soft);
    }
    .nn_cat_icon {
        width: 36px; height: 36px; border-radius: 10px; flex: none;
        display: inline-flex; align-items: center; justify-content: center; background: var(--nn-soft);
    }
    .nn_cat_list a:hover, .nn_cat_list a.is-active { background: var(--nn-accent); color: #fff; }
    .nn_cat_list a:hover .nn_cat_icon, .nn_cat_list a.is-active .nn_cat_icon,
    .nn_cat_list a:hover b, .nn_cat_list a.is-active b { background: rgba(255,255,255,.18); }

    .nn_years { display: flex; flex-wrap: wrap; gap: 8px; }
    .nn_years a {
        display: inline-flex; align-items: center; gap: 8px; padding: 7px 14px; border-radius: 30px;
        border: 1px solid var(--nn-line); color: var(--nn-accent); font-weight: 500; font-size: 15px;
    }
    .nn_years a span { font-size: 12px; opacity: .7; }
    .nn_years a:hover, .nn_years a.is-active { background: var(--nn-accent); border-color: var(--nn-accent); color: #fff; }

    .nn_recent li + li { border-top: 1px dashed var(--nn-line); }
    .nn_recent a { display: flex; flex-direction: column; gap: 4px; padding: 12px 0; }
    .nn_recent li:first-child a { padding-top: 0; }
    .nn_recent_date { font-size: 13px; font-weight: 600; color: #6b7489; }
    .nn_recent_title {
        color: var(--nn-accent); font-weight: 500; line-height: 1.45;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .nn_recent a:hover .nn_recent_title { text-decoration: underline; }

    .nn_side_search { position: relative; }
    .nn_side_search input {
        width: 100%; height: 50px; padding: 0 56px 0 18px; border-radius: 12px; outline: 0;
        border: 1px solid var(--nn-line); background: var(--nn-soft); color: var(--nn-accent);
    }
    .nn_side_search button {
        position: absolute; right: 5px; top: 5px; width: 40px; height: 40px; border: 0; border-radius: 10px;
        background: var(--nn-accent); color: #fff; display: flex; align-items: center; justify-content: center;
    }

    .nn_help {
        padding: 30px 26px; border-radius: 16px; position: relative; overflow: hidden;
        background: linear-gradient(135deg, var(--nn-accent) 0%, var(--nn-dark) 100%);
    }
    .nn_help::after {
        content: ""; position: absolute; width: 180px; height: 180px; border-radius: 50%;
        right: -60px; top: -60px; background: rgba(255,255,255,.08);
    }
    .nn_help > * { position: relative; z-index: 1; }

    /* ---------- Notices with an image ---------- */
    /* Priority card */
    .nn_hcard.has-img { padding-top: 0; }
    .nn_hcard_img { margin: 0 -24px 4px; aspect-ratio: 16 / 9; overflow: hidden; }
    .nn_hcard_img img { width: 100%; height: 100%; object-fit: cover; transition: transform .7s ease; }
    .nn_hcard:hover .nn_hcard_img img { transform: scale(1.06); }

    /* List item */
    .nn_item_img { position: relative; flex: none; width: 220px; border-radius: 14px; overflow: hidden; align-self: stretch; min-height: 150px; }
    .nn_item_img img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: transform .7s ease; }
    .nn_item:hover .nn_item_img img { transform: scale(1.06); }
    .nn_item_img_date {
        position: absolute; left: 10px; top: 10px; min-width: 58px; padding: 6px 8px; border-radius: 10px; text-align: center;
        background: var(--nn-accent); color: #fff; box-shadow: 0 10px 20px -8px rgba(0,0,0,.5);
    }
    .nn_item.nn_p_urgent .nn_item_img_date { background: var(--nn-urgent); }
    .nn_item_img_date strong { display: block; font-size: 22px; line-height: 1; }
    .nn_item_img_date span { display: block; margin-top: 2px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; opacity: .9; }

    /* Detail cover */
    .nn_cover { display: block; margin-top: 26px; border-radius: 14px; overflow: hidden; border: 1px solid var(--nn-line); }
    .nn_cover img { width: 100%; max-height: 520px; object-fit: cover; display: block; }

    /* Sidebar recent */
    .nn_recent a.has-img { flex-direction: row; align-items: center; gap: 12px; }
    .nn_recent_text { display: flex; flex-direction: column; gap: 4px; min-width: 0; }
    .nn_recent_img { flex: none; width: 64px; height: 52px; border-radius: 10px; object-fit: cover; }

    /* ---------- Responsive ---------- */
    @media (max-width: 991px) {
        .nn_search { flex-wrap: wrap; }
        .nn_search_q { flex: 1 1 100%; }
        .nn_search_field:not(.nn_search_q) { flex: 1; }
        .nn_sidebar { position: static; }
        .nn_article { padding: 30px; }
    }
    @media (max-width: 767px) {
        .nn_search .nn_btn { flex: 1 1 100%; }
        .nn_chips { flex-wrap: nowrap; overflow-x: auto; scrollbar-width: none; margin: 18px 0 36px; padding-bottom: 4px; }
        .nn_chips::-webkit-scrollbar { display: none; }
        .nn_chip { flex: none; }
        .nn_item { gap: 16px; padding: 18px; }
        .nn_item:hover { transform: none; }
        .nn_date { width: 66px; }
        .nn_date strong { font-size: 24px; padding-top: 8px; }
        .nn_date span { font-size: 12px; }
        .nn_date small { font-size: 12px; padding: 4px 0; }
        .nn_article { padding: 22px 18px; }
        .nn_article_head { gap: 16px; }
        .nn_article_head h2 { font-size: 24px; }
        .nn_attach_file { flex-wrap: wrap; }
        .nn_attach_actions { width: 100%; }
        .nn_attach_actions .nn_btn { flex: 1; }
        .nn_pager { grid-template-columns: 1fr; }
        .nn_pager .text-end { text-align: left !important; }
        .nn_item_img { width: 150px; min-height: 120px; }
    }
    @media (max-width: 420px) {
        .nn_item { flex-direction: column; }
        .nn_item .nn_date { flex-direction: row; width: auto; align-self: flex-start; }
        .nn_item .nn_date strong, .nn_item .nn_date span, .nn_item .nn_date small { padding: 6px 10px; font-size: 14px; }
        .nn_search_field { min-width: 0; }
        .nn_item_img { width: 100%; min-height: 0; aspect-ratio: 16 / 9; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var btn = document.querySelector('.nn_copy');
        if (!btn) return;
        btn.addEventListener('click', function () {
            var url = btn.getAttribute('data-url');
            var label = btn.querySelector('span');
            var done = function () {
                label.textContent = 'Copied!';
                setTimeout(function () { label.textContent = 'Copy link'; }, 2000);
            };
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(done);
            } else {
                var t = document.createElement('input');
                t.value = url; document.body.appendChild(t); t.select();
                document.execCommand('copy'); t.remove(); done();
            }
        });
    });
</script>
@endpush