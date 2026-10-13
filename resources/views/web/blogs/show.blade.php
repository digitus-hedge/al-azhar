@extends('web.layouts.app')

@section('title', $blog->title . ' || AL-Azhar')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($blog->description), 155))
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@section('content')
    @php
        $blogPlaceholder = 'data:image/svg+xml;utf8,' . rawurlencode(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 500"><rect width="800" height="500" fill="#eef0f7"/><g fill="none" stroke="#c3c8dc" stroke-width="14" stroke-linecap="round" stroke-linejoin="round"><rect x="300" y="160" width="200" height="180" rx="18"/><path d="M330 210h140M330 240h100M330 270h120"/></g></svg>'
        );
        $publishedAt = $blog->published_at ? \Illuminate\Support\Carbon::parse($blog->published_at) : null;
        $wordCount   = str_word_count(strip_tags((string) $blog->description));
        $readTime    = max(1, (int) ceil($wordCount / 200));
    @endphp

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('images/header.jpeg') }}"
    style="background-image: url('{{ asset('images/header.jpeg') }}');">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10 wow fadeInDown" data-wow-duration="0.9s" data-wow-delay="0.2s">Blog Details</h1>
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

    <!-- Start Blog Details -->
    <section>
        <div class="td_height_100 td_height_lg_50"></div>
        <div class="container">
            <div class="row td_gap_y_40">
                <div class="col-lg-8">
                    <div class="blog_detail_img_wrap wow zoomIn" data-wow-duration="1.1s" data-wow-delay="0.2s">
                        <img src="{{ $blog->image ? asset('storage/' . $blog->image) : $blogPlaceholder }}"
                            alt="{{ $blog->title }}" class="blog_detail_img td_radius_10">
                    </div>

                    <h2 class="td_fs_36 td_mb_20 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">{{ $blog->title }}</h2>

                    <div class="blog_detail_body td_fs_18 td_heading_color td_opacity_8 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">
                        {!! $blog->description !!}
                    </div>

                    {{-- Journal link (if present) --}}
                    @if (!empty($blog->journal_link))
                        <div class="blog_journal wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.5s">
                            <span class="blog_journal_icon">
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                    <path d="M9 7h7M9 11h5"/>
                                </svg>
                            </span>
                            <div class="blog_journal_body">
                                <small>Source Reference</small>
                                <h4>Read the full journal article</h4>
                                <a href="{{ $blog->journal_link }}" target="_blank" rel="noopener noreferrer" class="blog_journal_link">
                                    <span>Open Journal Link</span>
                                    <span class="blog_journal_link_icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                            <polyline points="15 3 21 3 21 9"/>
                                            <line x1="10" y1="14" x2="21" y2="3"/>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="td_height_40 td_height_lg_30"></div>
                    <a href="{{ route('blogs') }}" class="blog_back wow fadeInUp" data-wow-delay="0.2s">
                        <span class="blog_back_icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 12H5M12 19l-7-7 7-7" />
                            </svg>
                        </span>
                        <span>Back to Blog</span>
                    </a>
                </div>

                <div class="col-lg-4">
                    <div class="blog_info_box wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
                        <h3 class="td_fs_24 td_semibold td_mb_20">Post Info</h3>
                        <ul class="blog_info_list">
                            @if ($publishedAt)
                                <li class="wow fadeInUp" data-wow-delay="0.45s">
                                    <span class="blog_info_icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="5" width="18" height="16" rx="2" />
                                            <path d="M3 10h18M8 3v4M16 3v4" />
                                        </svg>
                                    </span>
                                    <div><small>Published</small><strong>{{ $publishedAt->format('l, d F Y') }}</strong></div>
                                </li>
                            @endif
                            <li class="wow fadeInUp" data-wow-delay="0.55s">
                                <span class="blog_info_icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M12 7v5l3 2" />
                                    </svg>
                                </span>
                                <div><small>Reading Time</small><strong>{{ $readTime }} min read</strong></div>
                            </li>
                            <li class="wow fadeInUp" data-wow-delay="0.65s">
                                <span class="blog_info_icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                </span>
                                <div><small>Author</small><strong>Al Azhar Central School</strong></div>
                            </li>
                            @if (!empty($blog->journal_link))
                                <li class="wow fadeInUp" data-wow-delay="0.75s">
                                    <span class="blog_info_icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7.1-7.1l-1.7 1.7"/>
                                            <path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7.1 7.1l1.7-1.7"/>
                                        </svg>
                                    </span>
                                    <div><small>Reference</small><strong><a href="{{ $blog->journal_link }}" target="_blank" rel="noopener" class="blog_info_link">Journal Link</a></strong></div>
                                </li>
                            @endif
                        </ul>
                </div>
            </div>

            {{-- More blogs --}}
            @if (isset($related) && $related->isNotEmpty())
                <div class="td_height_80 td_height_lg_50"></div>
                <h2 class="td_fs_36 td_mb_30 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">More Posts</h2>
                <div class="row td_gap_y_30">
                    @foreach ($related as $item)
                        @php
                            $itemDate = $item->published_at ? \Illuminate\Support\Carbon::parse($item->published_at) : null;
                            $itemLink = route('blogs.show', $item->slug);
                        @endphp
                        <div class="col-lg-4 col-md-6 wow {{ ['fadeInLeft', 'fadeInUp', 'fadeInRight'][$loop->index % 3] }}"
                            data-wow-duration="0.9s" data-wow-delay="{{ 0.1 + ($loop->index % 3) * 0.12 }}s">
                            <div class="td_post td_style_1 blog_card">
                                <a href="{{ $itemLink }}" class="td_post_thumb d-block">
                                    <img src="{{ $item->image ? asset('storage/' . $item->image) : $blogPlaceholder }}"
                                        alt="{{ $item->title }}" loading="lazy">
                                    <i class="fa-solid fa-link"></i>
                                    @if ($itemDate)
                                        <span class="blog_date_badge">
                                            <strong>{{ $itemDate->format('d') }}</strong>
                                            <small>{{ $itemDate->format('M Y') }}</small>
                                        </span>
                                    @endif
                                </a>
                                <div class="td_post_info">
                                    <h2 class="td_post_title td_fs_24 td_medium td_mb_16">
                                        <a href="{{ $itemLink }}">{{ $item->title }}</a>
                                    </h2>
                                    <a href="{{ $itemLink }}" class="blog_more">
                                        <span>Read More</span>
                                        <span class="blog_more_icon">
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
    <!-- End Blog Details -->

@endsection

@push('styles')
<style>
    /* Page heading: fix the theme's breadcrumb separator (same as other pages) */
    .td_page_heading .breadcrumb-item + .breadcrumb-item::before { content: "/" !important; color: #fff; padding: 0 8px; }

    .blog_detail_img_wrap { margin-bottom: 30px; }
    .blog_detail_img { width: 100%; aspect-ratio: 8 / 5; object-fit: cover; display: block; }

    /* Rich-text body coming from CKEditor */
    .blog_detail_body { line-height: 1.8; }
    .blog_detail_body > *:first-child { margin-top: 0; }
    .blog_detail_body p { margin: 0 0 18px; }
    .blog_detail_body h1, .blog_detail_body h2, .blog_detail_body h3,
    .blog_detail_body h4, .blog_detail_body h5, .blog_detail_body h6 {
        color: var(--heading-color, #00539B);
        font-weight: 600;
        margin: 26px 0 14px;
        line-height: 1.35;
    }
    .blog_detail_body h2 { font-size: 26px; }
    .blog_detail_body h3 { font-size: 22px; }
    .blog_detail_body h4 { font-size: 19px; }
    .blog_detail_body a {
        color: var(--heading-color, #00539B);
        text-decoration: underline;
    }
    .blog_detail_body ul, .blog_detail_body ol {
        padding-left: 0; margin: 0 0 20px; list-style: none;
    }
    .blog_detail_body li { position: relative; padding-left: 28px; margin-bottom: 10px; }
    .blog_detail_body li::before {
        content: ""; position: absolute; left: 0; top: 10px;
        width: 14px; height: 14px; border-radius: 50%;
        background: var(--heading-color, #00539B) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 6 9 17l-5-5'/%3E%3C/svg%3E") center / 9px no-repeat;
    }
    .blog_detail_body blockquote {
        margin: 22px 0; padding: 18px 24px;
        background: rgba(0, 83, 155, .06);
        border-left: 4px solid var(--heading-color, #00539B);
        border-radius: 0 10px 10px 0;
        font-style: italic;
    }
    .blog_detail_body img { max-width: 100%; height: auto; border-radius: 10px; margin: 16px 0; }
    .blog_detail_body table {
        width: 100%; margin: 20px 0;
        border-collapse: collapse; font-size: 15px;
    }
    .blog_detail_body th, .blog_detail_body td {
        padding: 10px 14px; border: 1px solid #eceef5; text-align: left;
    }
    .blog_detail_body th {
        background: rgba(0, 83, 155, .06);
        color: var(--heading-color, #00539B); font-weight: 600;
    }

    /* Journal link card */
    .blog_journal {
        display: flex; gap: 18px; align-items: flex-start;
        margin-top: 32px; padding: 24px 26px;
        background: #fff;
        border: 1px solid #eceef5;
        border-left: 4px solid var(--heading-color, #00539B);
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(13, 27, 76, .06);
    }
    .blog_journal_icon {
        flex: none;
        width: 54px; height: 54px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        background: rgba(0, 83, 155, .08);
        color: var(--heading-color, #00539B);
    }
    .blog_journal_body { flex: 1; }
    .blog_journal_body small {
        display: block; font-size: 12px;
        color: var(--heading-color, #00539B); font-weight: 700;
        letter-spacing: 1.2px; text-transform: uppercase;
        margin-bottom: 4px;
    }
    .blog_journal_body h4 {
        font-size: 18px; font-weight: 600;
        color: var(--heading-color, #00539B); margin: 0 0 14px;
    }
    .blog_journal_link {
        display: inline-flex; align-items: center; gap: 12px;
        padding: 6px 6px 6px 22px; border-radius: 30px;
        border: 1px solid var(--heading-color, #00539B);
        color: var(--heading-color, #00539B); font-weight: 600; font-size: 14px;
        background: #fff; transition: background .3s ease, color .3s ease, box-shadow .3s ease;
    }
    .blog_journal_link_icon {
        width: 32px; height: 32px; border-radius: 50%; flex: none;
        display: flex; align-items: center; justify-content: center;
        background: var(--heading-color, #00539B); color: #fff;
        transition: background .3s ease, color .3s ease, transform .3s ease;
    }
    .blog_journal_link:hover {
        background: var(--heading-color, #00539B); color: #fff;
        box-shadow: 0 12px 24px -12px rgba(0, 83, 155, .6);
    }
    .blog_journal_link:hover .blog_journal_link_icon {
        background: #fff; color: var(--heading-color, #00539B);
        transform: translate(3px, -3px);
    }

    /* Back to Blog button */
    .blog_back {
        display: inline-flex; align-items: center; gap: 12px;
        padding: 6px 22px 6px 6px; border-radius: 30px;
        border: 1px solid var(--heading-color, #00539B);
        color: var(--heading-color, #00539B); font-weight: 600; font-size: 15px;
        background: #fff; transition: background .3s ease, color .3s ease, box-shadow .3s ease;
    }
    .blog_back_icon {
        width: 36px; height: 36px; border-radius: 50%; flex: none;
        display: flex; align-items: center; justify-content: center;
        background: var(--heading-color, #00539B); color: #fff;
        transition: background .3s ease, color .3s ease, transform .3s ease;
    }
    .blog_back:hover {
        background: var(--heading-color, #00539B); color: #fff;
        box-shadow: 0 12px 24px -12px rgba(0, 83, 155, .6);
    }
    .blog_back:hover .blog_back_icon {
        background: #fff; color: var(--heading-color, #00539B);
        transform: translateX(-4px);
    }

    /* Read More button */
    .blog_more {
        display: inline-flex; align-items: center; gap: 12px;
        padding: 6px 6px 6px 22px; border-radius: 30px;
        border: 1px solid var(--heading-color, #00539B);
        color: var(--heading-color, #00539B); font-weight: 600; font-size: 15px;
        background: #fff; transition: background .3s ease, color .3s ease, box-shadow .3s ease;
    }
    .blog_more_icon {
        width: 36px; height: 36px; border-radius: 50%; flex: none;
        display: flex; align-items: center; justify-content: center;
        background: var(--heading-color, #00539B); color: #fff;
        transition: background .3s ease, color .3s ease, transform .3s ease;
    }
    .blog_more:hover {
        background: var(--heading-color, #00539B); color: #fff;
        box-shadow: 0 12px 24px -12px rgba(0, 83, 155, .6);
    }
    .blog_more:hover .blog_more_icon {
        background: #fff; color: var(--heading-color, #00539B);
        transform: translateX(4px) rotate(-45deg);
    }

    /* Blog info box (same shape as event_info_box) */
    .blog_info_box {
        background: #fff; border-radius: 16px; padding: 30px;
        box-shadow: 0 10px 40px rgba(13, 27, 76, .08); position: sticky; top: 120px;
    }
    .blog_info_list { list-style: none; padding: 0; margin: 0; }
    .blog_info_list li { display: flex; gap: 14px; align-items: center; padding: 14px 0; border-bottom: 1px solid #eceef5; }
    .blog_info_list li:last-child { border-bottom: 0; padding-bottom: 0; }
    .blog_info_icon {
        flex-shrink: 0; width: 44px; height: 44px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: rgba(0, 83, 155, .08); color: var(--heading-color, #00539B);
    }
    .blog_info_list small { display: block; font-size: 13px; opacity: .6; }
    .blog_info_list strong { font-weight: 600; color: var(--heading-color); }
    .blog_info_link { color: var(--heading-color, #00539B) !important; text-decoration: underline; }
    .blog_info_link:hover { opacity: .8; }

    /* Share in sidebar */
    .blog_info_share { padding-top: 20px; margin-top: 10px; border-top: 1px solid #eceef5; }
    .blog_info_share small {
        display: block; font-size: 13px; opacity: .6; margin-bottom: 10px;
    }
    .blog_share_links { display: flex; gap: 10px; }
    .blog_share_links a {
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: rgba(0, 83, 155, .08); color: var(--heading-color, #00539B);
        transition: all .3s ease;
    }
    .blog_share_links a:hover {
        background: var(--heading-color, #00539B); color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -8px rgba(0, 83, 155, .5);
    }

    /* Cards */
    .blog_card .td_post_thumb { position: relative; }
    .blog_card .td_post_thumb img { width: 100%; aspect-ratio: 8 / 5; object-fit: cover; }
    .blog_date_badge {
        position: absolute; top: 16px; left: 16px; z-index: 2;
        background: var(--heading-color, #00539B); color: #fff; border-radius: 10px;
        padding: 8px 12px; text-align: center; line-height: 1.1; min-width: 64px;
    }
    .blog_date_badge strong { display: block; font-size: 24px; }
    .blog_date_badge small { font-size: 12px; text-transform: uppercase; }

    @media (max-width: 991px) { .blog_info_box { position: static; } }
</style>
@endpush