@extends('web.layouts.app')

@section('title', 'Curriculum || Al Azhar Central School, Mala')
@section('meta_description', 'Explore the curriculum at Al Azhar Central School, Mala — a holistic learning framework blending academic rigor, values, and skills.')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@section('content')

    @php
        $curriculums = $curriculums ?? collect();
    @endphp

{{-- Shared page header --}}
@include('web.layouts.page-header', [
    'title'    => 'Curriculum',
    'subtitle' => 'A holistic learning framework blending academic rigor, moral values and life skills for every learner.',
])

    <!-- Start Curriculum Grid -->
    <section style="padding-top: 20px;">
        <div class="container">

            {{-- Section intro --}}
            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                    <i></i> Our Curriculum <i></i>
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">A Framework for Holistic Learning</h2>
                <div class="d-flex justify-content-center">
                    <p class="td_section_subtitle td_fs_18 mb-0 cur_intro">
                        Discover the structured yet flexible curriculum designed to nurture every student's intellectual, moral and personal growth.
                    </p>
                </div>
            </div>
            <div class="td_height_60 td_height_lg_40"></div>

            @if ($curriculums->isEmpty())
                <div class="cur_empty wow fadeInUp" data-wow-delay="0.2s">
                    <span class="cur_empty_icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                    </span>
                    <h3>No Curriculum Items Yet</h3>
                    <p>Curriculum details will appear here once they are added.</p>
                </div>
            @else
                <div class="row td_gap_y_30 td_row_gap_30">
                    @foreach ($curriculums as $i => $curriculum)
                       @php
    // Pull image list from the `images` JSON column, fall back to the single `image` for old records
    $images = [];
    if (is_array($curriculum->images) && count($curriculum->images)) {
        $images = $curriculum->images;
    } elseif (!empty($curriculum->image)) {
        $images = [$curriculum->image];
    }
    $hasImage = count($images) > 0;
    $anim     = ['fadeInLeft', 'fadeInUp', 'fadeInRight'][$i % 3];
    $delay    = 0.1 + ($i % 3) * 0.12;
@endphp

<div class="col-lg-4 col-md-6 cur_item">
    <div class="cur_card {{ $hasImage ? 'cur_card_has_image' : 'cur_card_no_image' }} td_radius_10 wow {{ $anim }}"
        data-wow-duration="0.9s" data-wow-delay="{{ $delay }}s">

        @if ($hasImage)
            <div class="cur_card_thumb" data-cur-carousel>
                <div class="cur_slides">
                    @foreach ($images as $imgIndex => $img)
                        @php $imgUrl = asset('storage/' . $img); @endphp
                        <a href="{{ $imgUrl }}"
                           class="cur_slide {{ $imgIndex === 0 ? 'is-active' : '' }}"
                           data-cur-lightbox
                           data-card-index="{{ $i }}"
                           data-img-index="{{ $imgIndex }}"
                           data-title="{{ $curriculum->title }}"
                           aria-label="Open image {{ $imgIndex + 1 }} of {{ $curriculum->title }}">
                            <img src="{{ $imgUrl }}" alt="{{ $curriculum->title }}" loading="lazy">
                        </a>
                    @endforeach
                </div>

                @if (count($images) > 1)
                    <button type="button" class="cur_nav cur_prev" aria-label="Previous image">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </button>
                    <button type="button" class="cur_nav cur_next" aria-label="Next image">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                    <div class="cur_dots">
                        @foreach ($images as $imgIndex => $img)
                            <button type="button" class="cur_dot {{ $imgIndex === 0 ? 'is-active' : '' }}" data-dot-index="{{ $imgIndex }}" aria-label="Go to image {{ $imgIndex + 1 }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="cur_card_badge">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    <path d="M9 7h7M9 11h5"/>
                </svg>
            </div>
        @endif

        <div class="cur_card_body">
            <span class="cur_card_number">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
            <h3 class="cur_card_title">{{ $curriculum->title }}</h3>
            @if ($curriculum->description)
                <div class="cur_card_desc">
                    {!! $curriculum->description !!}
                </div>
            @endif
        </div>
    </div>
</div>
                    @endforeach
                </div>
            @endif

        </div>
        <div class="td_height_100 td_height_lg_50"></div>
    </section>
    <!-- End Curriculum Grid -->
<div class="cur_lb" id="curLb" aria-hidden="true" role="dialog" aria-label="Image viewer">
    <div class="cur_lb_bg" data-close></div>
    <span class="cur_lb_count"></span>
    <button type="button" class="cur_lb_btn cur_lb_close" data-close aria-label="Close">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
    </button>
    <button type="button" class="cur_lb_btn cur_lb_prev" aria-label="Previous">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
    </button>
    <div class="cur_lb_stage"><img src="" alt=""></div>
    <button type="button" class="cur_lb_btn cur_lb_next" aria-label="Next">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
    </button>
    <p class="cur_lb_title"></p>
</div>

    @endsection


@push('styles')
<style>
    .cur_intro { max-width: 720px; }

    /* ---------- Card ---------- */
    .cur_item { display: flex; }
    .cur_card {
        width: 100%;
        background: #fff;
        border: 1px solid #eceef5;
        box-shadow: 0 15px 40px -25px rgba(0, 0, 27, .25);
        display: flex; flex-direction: column;
        overflow: hidden;
        transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
        position: relative;
    }
    .cur_card::before {
        content: ""; position: absolute;
        top: 0; left: 0; right: 0; height: 4px;
        background: linear-gradient(90deg, var(--heading-color, #00539B), #002F5F);
        transform: scaleX(0); transform-origin: left;
        transition: transform .4s ease;
    }
    .cur_card:hover {
        transform: translateY(-6px);
        box-shadow: 0 30px 50px -25px rgba(0, 47, 95, .35);
        border-color: rgba(0, 83, 155, .25);
    }
    .cur_card:hover::before { transform: scaleX(1); }

    /* ---------- With image ---------- */
    .cur_card_thumb {
        aspect-ratio: 16 / 11;
        overflow: hidden; background: #eef0f7;
    }
    .cur_card_thumb img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .5s ease;
    }
    .cur_card_has_image:hover .cur_card_thumb img { transform: scale(1.05); }

    /* ---------- No image (badge instead) ---------- */
    .cur_card_badge {
        display: flex; align-items: center; justify-content: center;
        width: 60px; height: 60px; border-radius: 16px;
        background: linear-gradient(135deg, var(--heading-color, #00539B), #002F5F);
        color: #fff;
        margin: 28px 28px 0;
        box-shadow: 0 15px 30px -10px rgba(0, 47, 95, .4);
        transition: transform .35s ease;
    }
    .cur_card_no_image:hover .cur_card_badge {
        transform: rotate(-6deg) scale(1.08);
    }

    /* ---------- Body ---------- */
    .cur_card_body {
        padding: 24px 28px 28px;
        flex: 1; display: flex; flex-direction: column;
        position: relative;
    }
    .cur_card_number {
        position: absolute; top: 20px; right: 24px;
        font-size: 42px; font-weight: 800;
        color: rgba(0, 83, 155, .08);
        line-height: 1;
        font-family: Georgia, serif;
        transition: color .35s ease;
    }
    .cur_card:hover .cur_card_number { color: rgba(0, 83, 155, .18); }

    .cur_card_title {
        font-size: 20px; font-weight: 700;
        line-height: 1.35;
        color: var(--heading-color, #00539B);
        margin: 0 0 14px;
        padding-right: 50px;
    }
    .cur_card_desc {
        font-size: 14.5px; line-height: 1.7;
        color: #5b6477;
    }
    .cur_card_desc > *:first-child { margin-top: 0; }
    .cur_card_desc > *:last-child { margin-bottom: 0; }
    .cur_card_desc p { margin: 0 0 10px; }
    .cur_card_desc h1, .cur_card_desc h2, .cur_card_desc h3,
    .cur_card_desc h4, .cur_card_desc h5, .cur_card_desc h6 {
        color: var(--heading-color, #00539B);
        font-weight: 600; font-size: 16px;
        margin: 14px 0 8px;
    }
    .cur_card_desc ul, .cur_card_desc ol {
        padding-left: 0; margin: 0 0 12px;
        list-style: none;
    }
    .cur_card_desc li {
        position: relative;
        padding-left: 22px; margin-bottom: 6px;
    }
    .cur_card_desc li::before {
        content: "";
        position: absolute; left: 0; top: 8px;
        width: 12px; height: 12px; border-radius: 50%;
        background: var(--heading-color, #00539B) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 6 9 17l-5-5'/%3E%3C/svg%3E") center / 8px no-repeat;
    }
    .cur_card_desc a {
        color: var(--heading-color, #00539B);
        text-decoration: underline;
    }
    .cur_card_desc strong, .cur_card_desc b { color: var(--heading-color, #00539B); }
    .cur_card_desc blockquote {
        margin: 10px 0; padding: 10px 14px;
        border-left: 3px solid var(--heading-color, #00539B);
        background: rgba(0, 83, 155, .05);
        border-radius: 0 8px 8px 0;
        font-style: italic;
    }
    .cur_card_desc img { max-width: 100%; height: auto; border-radius: 8px; margin: 10px 0; }

    /* ---------- Empty state ---------- */
    .cur_empty {
        max-width: 520px; margin: 0 auto;
        text-align: center; padding: 50px 30px;
        background: #fff;
        border: 2px dashed #e6eaf2; border-radius: 18px;
    }
    .cur_empty_icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 80px; height: 80px; border-radius: 50%;
        background: rgba(0, 83, 155, .08);
        color: var(--heading-color, #00539B);
        margin-bottom: 18px;
    }
    .cur_empty h3 {
        font-size: 22px; font-weight: 700;
        color: var(--heading-color, #00539B); margin: 0 0 8px;
    }
    .cur_empty p { color: #6b7489; font-size: 15px; margin: 0; }

    /* ---------- Responsive ---------- */
    @media (max-width: 767px) {
        .cur_card_body { padding: 22px 22px 24px; }
        .cur_card_badge { margin: 22px 22px 0; }
        .cur_card_title { font-size: 18px; padding-right: 40px; }
        .cur_card_number { font-size: 36px; }
    }

    /* ---------- Carousel on card ---------- */
.cur_card_thumb { position: relative; }
.cur_slides { position: relative; width: 100%; height: 100%; }
.cur_slide {
    position: absolute; inset: 0; display: block;
    opacity: 0; transition: opacity .7s ease;
    cursor: zoom-in;
}
.cur_slide.is-active { opacity: 1; z-index: 1; }
.cur_slide img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s ease; }
.cur_card_has_image:hover .cur_slide.is-active img { transform: scale(1.05); }

.cur_nav {
    position: absolute; top: 50%; transform: translateY(-50%);
    width: 36px; height: 36px; border-radius: 50%; border: 0;
    background: rgba(255,255,255,.9); color: var(--heading-color, #00539B);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; z-index: 3; opacity: 0;
    transition: opacity .3s ease, background .3s ease, color .3s ease;
    box-shadow: 0 6px 14px -4px rgba(0,0,0,.4);
}
.cur_prev { left: 10px; }
.cur_next { right: 10px; }
.cur_card_thumb:hover .cur_nav { opacity: 1; }
.cur_nav:hover { background: var(--heading-color, #00539B); color: #fff; }

.cur_dots {
    position: absolute; left: 0; right: 0; bottom: 10px; z-index: 3;
    display: flex; justify-content: center; gap: 6px;
}
.cur_dot {
    width: 8px; height: 8px; border-radius: 50%; border: 0; padding: 0;
    background: rgba(255,255,255,.5); cursor: pointer;
    transition: all .3s ease;
}
.cur_dot.is-active { background: #fff; width: 22px; border-radius: 10px; }

/* ---------- Lightbox ---------- */
.cur_lb {
    position: fixed; inset: 0; z-index: 99999;
    display: flex; align-items: center; justify-content: center;
    opacity: 0; visibility: hidden;
    transition: opacity .3s ease, visibility .3s ease;
}
.cur_lb.is-open { opacity: 1; visibility: visible; }
.cur_lb_bg { position: absolute; inset: 0; background: rgba(0,0,18,.95); }
.cur_lb_stage {
    position: relative; z-index: 2;
    width: calc(100% - 200px); height: calc(100% - 160px);
    display: flex; align-items: center; justify-content: center;
}
.cur_lb_stage img {
    max-width: 100%; max-height: 100%;
    object-fit: contain; border-radius: 10px;
}
.cur_lb_btn {
    position: absolute; z-index: 3;
    width: 52px; height: 52px; border-radius: 50%; border: 0; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    background: rgba(255,255,255,.12); color: #fff;
    transition: background .3s ease;
}
.cur_lb_btn:hover { background: var(--heading-color, #00539B); }
.cur_lb_close { top: 16px; right: 20px; width: 46px; height: 46px; }
.cur_lb_prev { left: 28px; top: 50%; margin-top: -26px; }
.cur_lb_next { right: 28px; top: 50%; margin-top: -26px; }
.cur_lb_count {
    position: absolute; top: 28px; left: 24px; z-index: 3;
    color: rgba(255,255,255,.75); font-size: 15px; letter-spacing: 1px;
}
.cur_lb_title {
    position: absolute; left: 80px; right: 80px; bottom: 24px; z-index: 3;
    margin: 0; text-align: center; color: #fff;
    font-size: 18px; font-weight: 500;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
body.cur_lb_lock { overflow: hidden; }

@media (max-width: 767px) {
    .cur_lb_stage { width: 100%; height: calc(100% - 180px); padding: 0 10px; }
    .cur_lb_prev, .cur_lb_next { top: auto; bottom: 70px; margin: 0; width: 44px; height: 44px; }
    .cur_lb_title { left: 64px; right: 64px; bottom: 80px; font-size: 15px; }
    .cur_nav { opacity: 1; width: 32px; height: 32px; }
}
</style>
@endpush
@push('scripts')
<script>
(function () {
    function init() {
        // ---- Per-card carousels with autoplay ----
        document.querySelectorAll('[data-cur-carousel]').forEach(function (box) {
            var slides = box.querySelectorAll('.cur_slide');
            var dots   = box.querySelectorAll('.cur_dot');
            if (slides.length < 2) return;

            var current = 0;
            var timer;

            function go(i) {
                current = (i + slides.length) % slides.length;
                slides.forEach(function (s, idx) { s.classList.toggle('is-active', idx === current); });
                dots.forEach(function (d, idx) { d.classList.toggle('is-active', idx === current); });
            }
            function next() { go(current + 1); }
            function prev() { go(current - 1); }
            function start() { stop(); timer = setInterval(next, 4000); }
            function stop() { if (timer) clearInterval(timer); }

            var nextBtn = box.querySelector('.cur_next');
            var prevBtn = box.querySelector('.cur_prev');
            if (nextBtn) nextBtn.addEventListener('click', function (e) { e.preventDefault(); e.stopPropagation(); next(); start(); });
            if (prevBtn) prevBtn.addEventListener('click', function (e) { e.preventDefault(); e.stopPropagation(); prev(); start(); });
            dots.forEach(function (d) {
                d.addEventListener('click', function (e) {
                    e.preventDefault(); e.stopPropagation();
                    go(parseInt(d.getAttribute('data-dot-index'), 10));
                    start();
                });
            });

            box.addEventListener('mouseenter', stop);
            box.addEventListener('mouseleave', start);
            start();
        });

        // ---- Lightbox ----
        var triggers = Array.prototype.slice.call(document.querySelectorAll('[data-cur-lightbox]'));
        var lb = document.getElementById('curLb');
        if (!triggers.length || !lb) return;

        var groups = {};
        triggers.forEach(function (t) {
            var k = t.getAttribute('data-card-index');
            (groups[k] = groups[k] || []).push(t);
        });

        var img     = lb.querySelector('.cur_lb_stage img');
        var titleEl = lb.querySelector('.cur_lb_title');
        var countEl = lb.querySelector('.cur_lb_count');
        var activeGroup = [];
        var current = 0;

        function show(i) {
            current = (i + activeGroup.length) % activeGroup.length;
            var t = activeGroup[current];
            img.src = t.getAttribute('href');
            img.alt = t.getAttribute('data-title') || '';
            titleEl.textContent = t.getAttribute('data-title') || '';
            countEl.textContent = (current + 1) + ' / ' + activeGroup.length;
        }
        function open(groupKey, startIndex) {
            activeGroup = groups[groupKey] || [];
            if (!activeGroup.length) return;
            show(startIndex);
            lb.classList.add('is-open');
            lb.setAttribute('aria-hidden', 'false');
            document.body.classList.add('cur_lb_lock');
        }
        function close() {
            lb.classList.remove('is-open');
            lb.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('cur_lb_lock');
            img.src = '';
        }

        triggers.forEach(function (t) {
            t.addEventListener('click', function (e) {
                e.preventDefault();
                open(t.getAttribute('data-card-index'), parseInt(t.getAttribute('data-img-index'), 10));
            });
        });
        lb.querySelector('.cur_lb_prev').addEventListener('click', function () { show(current - 1); });
        lb.querySelector('.cur_lb_next').addEventListener('click', function () { show(current + 1); });
        lb.querySelectorAll('[data-close]').forEach(function (el) { el.addEventListener('click', close); });
        document.addEventListener('keydown', function (e) {
            if (!lb.classList.contains('is-open')) return;
            if (e.key === 'Escape') close();
            if (e.key === 'ArrowLeft') show(current - 1);
            if (e.key === 'ArrowRight') show(current + 1);
        });

        var sx = null;
        var stage = lb.querySelector('.cur_lb_stage');
        stage.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
        stage.addEventListener('touchend', function (e) {
            if (sx === null) return;
            var dx = e.changedTouches[0].clientX - sx;
            if (Math.abs(dx) > 50) show(current + (dx < 0 ? 1 : -1));
            sx = null;
        });
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();
</script>
@endpush