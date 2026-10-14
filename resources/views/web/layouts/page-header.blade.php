{{-- ============================================
     Shared Page Header Partial
     Usage:
     @include('web.partials.page-header', [
         'title'    => 'About Us',
         'subtitle' => 'Discover our journey, vision and values.',
         'image'    => 'images/header.png', // optional
     ])
============================================ --}}

@once
@push('styles')
<style>
    /* Breadcrumb separator */
    .td_page_heading .breadcrumb-item + .breadcrumb-item::before {
        content: "/" !important;
        color: #fff;
        padding: 0 8px;
    }

    /* ===== Hero Header ===== */
    .td_page_heading.td_heading_bg {
        position: relative;
        overflow: hidden;
        min-height: 550px;
        display: flex;
        align-items: center;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    /* Rich blackish gradient overlay */
    .td_page_heading.td_heading_bg::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(135deg,
                rgba(5, 10, 25, 0.88) 0%,
                rgba(10, 25, 55, 0.78) 45%,
                rgba(0, 5, 20, 0.92) 100%);
        z-index: 1;
    }

    /* Soft animated color glow */
    .td_page_heading.td_heading_bg::after {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse at 20% 30%, rgba(0, 123, 255, 0.25), transparent 50%),
            radial-gradient(ellipse at 80% 70%, rgba(255, 193, 7, 0.15), transparent 50%);
        z-index: 1;
        animation: heroGlow 10s ease-in-out infinite alternate;
    }
    @keyframes heroGlow {
        0%   { opacity: 0.7; transform: scale(1); }
        100% { opacity: 1;   transform: scale(1.08); }
    }

    /* Lift container above overlays */
    .td_page_heading .container,
    .td_page_heading [class*="td_page_heading_shape"] {
        position: relative;
        z-index: 2;
    }

    /* Title styling */
    .td_page_heading h1 {
        font-weight: 700;
        letter-spacing: 0.5px;
        text-shadow: 0 4px 24px rgba(0, 0, 0, 0.4);
        margin-bottom: 18px !important;
    }

    /* Matching accent underline */
    .td_page_heading h1::after {
        content: "";
        display: block;
        width: 100px;
        height: 4px;
        margin: 20px auto 0;
        border-radius: 4px;
        background: linear-gradient(90deg,
            transparent 0%,
            #00539B 20%,
            #4A90E2 50%,
            #00539B 80%,
            transparent 100%);
        box-shadow: 0 2px 12px rgba(74, 144, 226, 0.5);
    }

    /* Subtitle / tagline */
    .td_page_heading .td_page_heading_sub {
        color: rgba(255, 255, 255, 0.85);
        font-size: 18px;
        max-width: 620px;
        margin: 0 auto 20px;
        line-height: 1.6;
    }

    /* Breadcrumb pill */
    .td_page_heading .breadcrumb {
        display: inline-flex;
        justify-content: center;
        padding: 10px 24px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-radius: 30px;
    }
    .td_page_heading .breadcrumb-item,
    .td_page_heading .breadcrumb-item a {
        color: #fff;
        font-weight: 500;
        font-size: 15px;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .td_page_heading .breadcrumb-item a:hover { color: #ffc107; }
    .td_page_heading .breadcrumb-item.active { color: rgba(255, 255, 255, 0.75); }

    /* Decorative shapes */
    .td_page_heading .hero_shape {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        z-index: 1;
    }
    .td_page_heading .hero_shape_1 {
        width: 300px; height: 300px;
        top: -100px; right: -80px;
        background: radial-gradient(circle, rgba(255,255,255,0.08), transparent 70%);
        animation: floatShape 8s ease-in-out infinite;
    }
    .td_page_heading .hero_shape_2 {
        width: 200px; height: 200px;
        bottom: -60px; left: -40px;
        background: radial-gradient(circle, rgba(255,193,7,0.15), transparent 70%);
        animation: floatShape 10s ease-in-out infinite reverse;
    }
    .td_page_heading .hero_shape_3 {
        width: 120px; height: 120px;
        top: 30%; left: 8%;
        background: radial-gradient(circle, rgba(0,123,255,0.2), transparent 70%);
        animation: floatShape 12s ease-in-out infinite;
    }
    @keyframes floatShape {
        0%, 100% { transform: translateY(0) scale(1); }
        50%      { transform: translateY(-30px) scale(1.1); }
    }

    /* Dotted pattern */
    .td_page_heading .hero_dots {
        position: absolute;
        bottom: 30px; right: 40px;
        width: 120px; height: 80px;
        opacity: 0.4;
        background-image: radial-gradient(circle, #fff 1.5px, transparent 1.5px);
        background-size: 18px 18px;
        z-index: 1;
    }

    /* Layered beautiful waves */
    .td_page_heading .hero_wave {
        position: absolute;
        left: 0;
        right: 0;
        bottom: -1px;
        width: 100%;
        height: 100px;
        z-index: 3;
        line-height: 0;
        pointer-events: none;
    }
    .td_page_heading .hero_wave svg {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        display: block;
    }

    /* Responsive */
    @media (max-width: 767px) {
        .td_page_heading.td_heading_bg { min-height: 320px; }
        .td_page_heading h1 { font-size: 36px !important; }
        .td_page_heading .td_page_heading_sub { font-size: 15px; padding: 0 20px; }
        .td_page_heading .hero_shape_1 { width: 180px; height: 180px; }
        .td_page_heading .hero_shape_2 { width: 140px; height: 140px; }
        .td_page_heading .hero_dots { display: none; }
        .td_page_heading .hero_wave { height: 70px; }
    }
</style>
@endpush
@endonce

<!-- Start Page Heading Section -->
<section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset($image ?? 'images/header.png') }}"
    style="background-image: url('{{ asset($image ?? 'images/header.png') }}');">

    {{-- Decorative shapes --}}
    <span class="hero_shape hero_shape_1"></span>
    <span class="hero_shape hero_shape_2"></span>
    <span class="hero_shape hero_shape_3"></span>
    <span class="hero_dots"></span>

    <div class="container">
        <div class="td_page_heading_in">
            <h1 class="td_white_color td_fs_48 wow fadeInDown" data-wow-duration="0.9s" data-wow-delay="0.2s">
                {{ $title }}
            </h1>

            @isset($subtitle)
                <p class="td_page_heading_sub wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">
                    {{ $subtitle }}
                </p>
            @endisset

            <nav aria-label="breadcrumb" class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Bottom wave --}}
    <div class="hero_wave">
        <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,30 C240,70 480,0 720,25 C960,50 1200,10 1440,35 L1440,60 L0,60 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>
<!-- End Page Heading Section -->