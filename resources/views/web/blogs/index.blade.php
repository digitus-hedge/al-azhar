@extends('web.layouts.app')

@section('title', 'Blog || Al Azhar Central School, Mala')
@section('meta_description', 'Read the latest news, stories, and articles from Al Azhar Central School, Mala.')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@section('content')

{{-- Shared page header --}}
@include('web.layouts.page-header', [
    'title'    => 'Our Blog',
    'subtitle' => 'News, stories and updates from Al Azhar Central School, Mala.',
])

<!-- Blog Listing -->
<section class="blg_wrap">
    <div class="td_height_100 td_height_lg_75"></div>
    <div class="container">

        {{-- Search bar --}}
        <div class="blg_search_wrap wow fadeInUp" data-wow-delay="0.2s">
            <form action="{{ route('blogs') }}" method="GET" class="blg_search">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                </svg>
                <input type="text" name="q" value="{{ $search }}" placeholder="Search blog posts…" maxlength="100">
                <button type="submit">Search</button>
            </form>
            @if ($search)
                <p class="blg_search_result">
                    Showing results for <strong>"{{ $search }}"</strong>
                    <a href="{{ route('blogs') }}">Clear</a>
                </p>
            @endif
        </div>

        <div class="td_height_50 td_height_lg_40"></div>

        <div class="row">
            {{-- ========= Main Blog Grid ========= --}}
            <div class="col-lg-8">
                @if ($blogs->isNotEmpty())
                    <div class="row td_gap_y_30">
                        @foreach ($blogs as $i => $blog)
                            <div class="col-md-6 wow fadeInUp" data-wow-delay="{{ 0.2 + ($i % 2) * 0.1 }}s">
                                <article class="blg_card">
                                    <a href="{{ route('blogs.show', $blog->slug) }}" class="blg_card_media">
                                        @if ($blog->image)
                                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" loading="lazy">
                                        @else
                                            <div class="blg_card_placeholder">
                                                <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <span class="blg_card_badge">Blog</span>
                                    </a>
                                    <div class="blg_card_body">
                                        @if ($blog->published_at)
                                            <div class="blg_card_meta">
                                                <span>
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                                                    </svg>
                                                    {{ $blog->published_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                        @endif
                                        <h3 class="blg_card_title">
                                            <a href="{{ route('blogs.show', $blog->slug) }}">{{ $blog->title }}</a>
                                        </h3>
                                        <p class="blg_card_excerpt">
                                            {{ \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $blog->description))), 130) }}
                                        </p>
                                        <a href="{{ route('blogs.show', $blog->slug) }}" class="blg_card_more">
                                            Read Article
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M5 12h14M12 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="blg_pagination mt-5">
                        {{ $blogs->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="blg_empty wow fadeInUp">
                        <span class="blg_empty_icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            </svg>
                        </span>
                        <h3>No Blog Posts Found</h3>
                        <p>{{ $search ? 'Try a different search term.' : "We haven't published any posts yet. Please check back soon." }}</p>
                    </div>
                @endif
            </div>

            {{-- ========= Sidebar ========= --}}
            <div class="col-lg-4">
                <aside class="blg_sidebar wow fadeInRight" data-wow-delay="0.3s">
                    <h4 class="blg_sidebar_title">Recent Posts</h4>
                    @if ($recent->isNotEmpty())
                        <ul class="blg_recent">
                            @foreach ($recent as $r)
                                <li>
                                    <a href="{{ route('blogs.show', $r->slug) }}" class="blg_recent_media">
                                        @if ($r->image)
                                            <img src="{{ asset('storage/' . $r->image) }}" alt="{{ $r->title }}" loading="lazy">
                                        @else
                                            <div class="blg_recent_placeholder">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </a>
                                    <div class="blg_recent_body">
                                        @if ($r->published_at)
                                            <small>{{ $r->published_at->format('M d, Y') }}</small>
                                        @endif
                                        <h5><a href="{{ route('blogs.show', $r->slug) }}">{{ \Illuminate\Support\Str::limit($r->title, 60) }}</a></h5>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="blg_sidebar_empty">No posts yet.</p>
                    @endif
                </aside>
            </div>
        </div>

    </div>
    <div class="td_height_100 td_height_lg_75"></div>
</section>

@endsection

@push('styles')
<style>
    .blg_wrap {
        --blg: var(--heading-color, #00539B);
        --blg-dark: #002F5F;
        --blg-soft: #F4F7FB;
        --blg-line: #E6EAF2;
        background: #F6F8FB;
    }

    /* Search */
    .blg_search_wrap { max-width: 640px; margin: 0 auto; }
    .blg_search {
        display: flex; align-items: center; gap: 10px;
        padding: 8px 8px 8px 20px;
        background: #fff;
        border-radius: 50px;
        border: 1px solid var(--blg-line);
        box-shadow: 0 20px 40px -30px rgba(0, 0, 27, 0.3);
    }
    .blg_search svg { color: #9aa3b5; flex: none; }
    .blg_search input {
        flex: 1; border: 0; outline: 0; background: transparent;
        font-size: 15px; color: #2d3545;
        padding: 8px 0;
    }
    .blg_search button {
        padding: 12px 28px; border: 0; border-radius: 50px;
        background: linear-gradient(135deg, var(--blg), var(--blg-dark));
        color: #fff; font-weight: 600; font-size: 14px;
        cursor: pointer;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .blg_search button:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -8px rgba(0, 47, 95, .5); }
    .blg_search_result {
        text-align: center; margin: 16px 0 0;
        font-size: 14px; color: #6b7489;
    }
    .blg_search_result a { color: var(--blg); font-weight: 600; margin-left: 8px; }

    /* Card */
    .blg_card {
        height: 100%;
        background: #fff;
        border: 1px solid var(--blg-line);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 18px 40px -30px rgba(0, 0, 27, .3);
        transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
        display: flex; flex-direction: column;
    }
    .blg_card:hover {
        transform: translateY(-6px);
        box-shadow: 0 30px 50px -25px rgba(0, 47, 95, .4);
        border-color: rgba(0, 83, 155, .25);
    }
    .blg_card_media {
        display: block; position: relative;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: var(--blg-soft);
    }
    .blg_card_media img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .5s ease;
    }
    .blg_card:hover .blg_card_media img { transform: scale(1.05); }
    .blg_card_placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        color: var(--blg); opacity: .4;
    }
    .blg_card_badge {
        position: absolute; top: 14px; left: 14px;
        padding: 5px 12px; border-radius: 20px;
        background: rgba(255, 255, 255, .95);
        color: var(--blg); font-size: 11.5px; font-weight: 700;
        letter-spacing: .5px; text-transform: uppercase;
        backdrop-filter: blur(6px);
    }
    .blg_card_body { padding: 24px; flex: 1; display: flex; flex-direction: column; }
    .blg_card_meta {
        display: flex; gap: 14px; margin-bottom: 10px;
        font-size: 13px; color: #6b7489;
    }
    .blg_card_meta span { display: inline-flex; align-items: center; gap: 6px; }
    .blg_card_meta svg { color: var(--blg); }
    .blg_card_title { margin: 0 0 12px; font-size: 18px; font-weight: 700; line-height: 1.35; }
    .blg_card_title a { color: var(--blg); transition: color .25s ease; }
    .blg_card_title a:hover { color: var(--blg-dark); }
    .blg_card_excerpt {
        font-size: 14px; line-height: 1.6; color: #5b6477;
        margin: 0 0 18px; flex: 1;
        display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    }
    .blg_card_more {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 13px; font-weight: 700;
        color: var(--blg); text-transform: uppercase; letter-spacing: .5px;
    }
    .blg_card_more svg { transition: transform .3s ease; }
    .blg_card:hover .blg_card_more svg { transform: translateX(4px); }

    /* Sidebar */
    .blg_sidebar {
        background: #fff;
        border: 1px solid var(--blg-line);
        border-radius: 18px;
        padding: 28px 24px;
        box-shadow: 0 18px 40px -30px rgba(0, 0, 27, .3);
    }
    .blg_sidebar_title {
        font-size: 18px; font-weight: 700;
        color: var(--blg); margin: 0 0 20px;
        padding-bottom: 14px; border-bottom: 2px solid var(--blg-soft);
        position: relative;
    }
    .blg_sidebar_title::after {
        content: ""; position: absolute; left: 0; bottom: -2px;
        width: 40px; height: 2px; background: var(--blg);
    }
    .blg_recent { list-style: none; padding: 0; margin: 0; }
    .blg_recent li {
        display: flex; gap: 14px;
        padding: 14px 0;
        border-bottom: 1px dashed var(--blg-line);
    }
    .blg_recent li:last-child { border-bottom: 0; padding-bottom: 0; }
    .blg_recent li:first-child { padding-top: 0; }
    .blg_recent_media {
        flex: none; width: 78px; height: 78px;
        border-radius: 10px; overflow: hidden;
        background: var(--blg-soft);
    }
    .blg_recent_media img { width: 100%; height: 100%; object-fit: cover; }
    .blg_recent_placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        color: var(--blg); opacity: .4;
    }
    .blg_recent_body { flex: 1; min-width: 0; }
    .blg_recent_body small { font-size: 12px; color: #6b7489; }
    .blg_recent_body h5 { font-size: 14.5px; font-weight: 600; margin: 4px 0 0; line-height: 1.4; }
    .blg_recent_body h5 a { color: var(--blg); transition: color .25s ease; }
    .blg_recent_body h5 a:hover { color: var(--blg-dark); }
    .blg_sidebar_empty { color: #6b7489; font-size: 14px; margin: 0; }

    /* Empty */
    .blg_empty {
        text-align: center; padding: 60px 30px;
        border: 2px dashed var(--blg-line); border-radius: 20px;
        background: #fff;
    }
    .blg_empty_icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 90px; height: 90px; border-radius: 50%;
        background: var(--blg-soft); color: var(--blg);
        margin-bottom: 20px;
    }
    .blg_empty h3 { font-size: 24px; font-weight: 700; color: var(--blg); margin: 0 0 10px; }
    .blg_empty p { font-size: 15px; color: #6b7489; margin: 0; }

    /* Pagination */
    .blg_pagination .pagination { justify-content: center; gap: 6px; flex-wrap: wrap; }
    .blg_pagination .page-link {
        border-radius: 10px !important;
        border: 1px solid var(--blg-line) !important;
        color: var(--blg) !important;
        padding: 10px 16px !important;
        font-weight: 600;
    }
    .blg_pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--blg), var(--blg-dark)) !important;
        border-color: var(--blg) !important;
        color: #fff !important;
    }

    @media (max-width: 991px) {
        .blg_sidebar { margin-top: 40px; }
    }
    @media (max-width: 575px) {
        .blg_search { flex-direction: column; padding: 16px; border-radius: 16px; }
        .blg_search input { width: 100%; padding: 10px 0; text-align: center; }
        .blg_search button { width: 100%; }
    }
</style>
@endpush