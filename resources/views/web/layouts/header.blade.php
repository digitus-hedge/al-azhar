{{--
    Site header
    Row 1 (top bar): phone + email (left) · social links (right)
    Row 2 (main):    logo (left) · menu (right)
    Tablet / mobile: logo + hamburger → slide-in menu
--}}
@php
    // TODO: replace with your real details
    $hdPhone   = '99884567809';
    $hdEmail   = 'al-azhar@gmail.com';
    $hdSocials = [
        'Facebook'  => ['url' => 'https://www.facebook.com/',  'icon' => '<path d="M22 12.06C22 6.51 17.52 2 12 2S2 6.51 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.89h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94z"/>'],
        'X'         => ['url' => 'https://www.twitter.com/',   'icon' => '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>'],
        'Instagram' => ['url' => 'https://www.instagram.com/', 'icon' => '<path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.256 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 8.25a3.25 3.25 0 1 1 0-6.5 3.25 3.25 0 0 1 0 6.5zm5.25-8.6a1.13 1.13 0 1 0 0-2.26 1.13 1.13 0 0 0 0 2.26z"/>'],
        'LinkedIn'  => ['url' => 'https://www.linkedin.com/',  'icon' => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.446-2.136 2.94v5.666H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 1 1 0-4.124 2.062 2.062 0 0 1 0 4.124zM7.114 20.452H3.56V9h3.554v11.452z"/>'],
    ];

    // Menu: [label, url, active?, children]
    $hdLink = function ($name, $params = []) {
        return \Illuminate\Support\Facades\Route::has($name) ? route($name, $params) : '#';
    };
    $hdMenu = [
        ['Home', url('/'), request()->is('/'), []],
        ['About Us', url('/about-us'), request()->is('about-us*') || request()->routeIs('principal-message', 'school-management', 'mandatory-disclosure'), [
            ['About the School',     url('/about-us')],
            ["Principal's Message",  $hdLink('principal-message')],
            ['School Management',    $hdLink('school-management')],
            ['Mandatory Disclosure', $hdLink('mandatory-disclosure')],
        ]],
        ['Departments', $hdLink('departments.index'), request()->routeIs('departments.*'), []],
        ['Campus Life', $hdLink('facilities.index'), request()->routeIs('facilities.*', 'gallery.*', 'events.*'), [
            ['Facilities', $hdLink('facilities.index')],
            ['Gallery',    $hdLink('gallery.index')],
            ['Events',     $hdLink('events.index')],
        ]],
        ['News & Notices', $hdLink('news-notices.index'), request()->routeIs('news-notices.*'), []],
        ['Contact Us', $hdLink('contact.index'), request()->routeIs('contact.*'), []],
    ];
    $hdAdmission = $hdLink('admission');
    $hdLogo = asset('images/logo1.png');
@endphp

<!-- Start Header Section -->
<header class="ah" id="siteHeader">

    {{-- ===== Row 1: top bar ===== --}}
    <div class="ah_top">
        <div class="container ah_top_in">
            <ul class="ah_contact">
                <li>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $hdPhone) }}">{{ $hdPhone }}</a>
                </li>
                <li>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
                    <a href="mailto:{{ $hdEmail }}">{{ $hdEmail }}</a>
                </li>
            </ul>
            <div class="ah_social">
                @foreach ($hdSocials as $label => $s)
                    <a href="{{ $s['url'] }}" target="_blank" rel="noopener" aria-label="{{ $label }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">{!! $s['icon'] !!}</svg>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ===== Row 2: logo + menu ===== --}}
    <div class="ah_main">
        <div class="container ah_main_in">
            <a class="ah_logo" href="{{ url('/') }}" aria-label="Al Azhar Central School – Home">
                <img src="{{ $hdLogo }}" alt="Al Azhar Central School">
            </a>

            <nav class="ah_nav" aria-label="Main">
                <ul class="ah_menu">
                    @foreach ($hdMenu as [$label, $href, $active, $children])
                        <li class="{{ $children ? 'has-sub' : '' }} {{ $active ? 'is-active' : '' }}">
                            <a href="{{ $href }}" @if ($active) aria-current="page" @endif>
                                {{ $label }}
                                @if ($children)
                                    <svg class="ah_caret" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                                @endif
                            </a>
                            @if ($children)
                                <ul class="ah_sub">
                                    @foreach ($children as [$cLabel, $cHref])
                                        <li><a href="{{ $cHref }}">{{ $cLabel }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <a href="{{ $hdAdmission }}" class="ah_cta">
                    Admission
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M8 7h9v9"/></svg>
                </a>
            </nav>

            <button type="button" class="ah_burger" aria-label="Open menu" aria-controls="ahDrawer" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>

{{-- ===== Mobile / tablet drawer ===== --}}
<div class="ah_drawer" id="ahDrawer" aria-hidden="true">
    <div class="ah_drawer_bg" data-ah-close></div>
    <aside class="ah_drawer_panel" role="dialog" aria-modal="true" aria-label="Menu">
        <div class="ah_drawer_head">
            <a class="ah_logo" href="{{ url('/') }}"><img src="{{ $hdLogo }}" alt="Al Azhar Central School"></a>
            <button type="button" class="ah_drawer_close" data-ah-close aria-label="Close menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <nav class="ah_mnav" aria-label="Mobile">
            <ul>
                @foreach ($hdMenu as $i => [$label, $href, $active, $children])
                    <li class="{{ $active ? 'is-active' : '' }} {{ $children ? 'has-sub' : '' }}">
                        @if ($children)
                            <button type="button" class="ah_mnav_toggle" aria-expanded="{{ $active ? 'true' : 'false' }}" aria-controls="ahSub{{ $i }}">
                                {{ $label }}
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            <ul class="ah_mnav_sub {{ $active ? 'is-open' : '' }}" id="ahSub{{ $i }}">
                                @foreach ($children as [$cLabel, $cHref])
                                    <li><a href="{{ $cHref }}">{{ $cLabel }}</a></li>
                                @endforeach
                            </ul>
                        @else
                            <a href="{{ $href }}">{{ $label }}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
            <a href="{{ $hdAdmission }}" class="ah_cta ah_cta_block">Admission Enquiry</a>
        </nav>

        <div class="ah_drawer_foot">
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $hdPhone) }}" class="ah_drawer_line">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg>
                {{ $hdPhone }}
            </a>
            <a href="mailto:{{ $hdEmail }}" class="ah_drawer_line">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
                {{ $hdEmail }}
            </a>
            <div class="ah_social ah_social_dark">
                @foreach ($hdSocials as $label => $s)
                    <a href="{{ $s['url'] }}" target="_blank" rel="noopener" aria-label="{{ $label }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">{!! $s['icon'] !!}</svg>
                    </a>
                @endforeach
            </div>
        </div>
    </aside>
</div>
<!-- End Header Section -->

<style>
    .ah, .ah_drawer { --ah: var(--heading-color, #00539B); --ah-dark: #002F5F; }

    /* Sits over the page banner / hero like the theme header did */
    .ah { position: absolute; top: 0; left: 0; right: 0; z-index: 1000; }

    /* ---------- Row 1 ---------- */
    .ah_top { background: var(--ah-dark); color: rgba(255,255,255,.9); font-size: 14px; }
    .ah_top_in { display: flex; align-items: center; justify-content: space-between; gap: 16px; min-height: 44px; }
    .ah_contact { display: flex; align-items: center; gap: 26px; margin: 0; padding: 0; list-style: none; min-width: 0; }
    .ah_contact li { display: inline-flex; align-items: center; gap: 8px; min-width: 0; }
    .ah_contact li + li { position: relative; }
    .ah_contact li + li::before { content: ""; position: absolute; left: -13px; top: 3px; bottom: 3px; border-left: 1px solid rgba(255,255,255,.25); }
    .ah_contact svg { flex: none; opacity: .85; }
    .ah_contact a { color: inherit; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ah_contact a:hover { color: #fff; }

    .ah_social { display: flex; align-items: center; gap: 8px; flex: none; }
    .ah_social a {
        width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        color: #fff; background: rgba(255,255,255,.1); transition: background .25s ease, color .25s ease;
    }
    .ah_social a:hover { background: #fff; color: var(--ah); }

    /* ---------- Row 2 ---------- */
    .ah_main { background: var(--ah); transition: box-shadow .3s ease; }
    .ah_main_in { display: flex; align-items: center; justify-content: space-between; gap: 24px; min-height: 90px; }
    .ah_logo { flex: none; display: inline-flex; align-items: center; }
    .ah_logo img { max-height: 62px; width: auto; }

    .ah_nav { display: flex; align-items: center; gap: 22px; margin-left: auto; }
    .ah_menu { display: flex; align-items: center; gap: 4px; margin: 0; padding: 0; list-style: none; }
    .ah_menu > li { position: relative; }
    .ah_menu > li > a {
        display: inline-flex; align-items: center; gap: 6px; padding: 10px 14px; border-radius: 30px;
        color: #fff; font-weight: 500; font-size: 16px; white-space: nowrap; transition: background .25s ease, color .25s ease;
    }
    .ah_menu > li > a:hover, .ah_menu > li:focus-within > a { background: rgba(255,255,255,.12); color: #fff; }
    .ah_menu > li.is-active > a { background: rgba(255,255,255,.18); }
    .ah_caret { transition: transform .25s ease; }
    .ah_menu > li:hover .ah_caret, .ah_menu > li:focus-within .ah_caret { transform: rotate(180deg); }

    .ah_sub {
        position: absolute; top: calc(100% + 10px); left: 0; min-width: 240px; margin: 0; padding: 10px; list-style: none;
        background: #fff; border-radius: 14px; box-shadow: 0 24px 50px -20px rgba(0,0,27,.35);
        opacity: 0; visibility: hidden; transform: translateY(8px); transition: all .25s ease;
    }
    .ah_sub::before { content: ""; position: absolute; left: 0; right: 0; top: -12px; height: 12px; }  /* hover bridge */
    .ah_menu > li:hover > .ah_sub, .ah_menu > li:focus-within > .ah_sub { opacity: 1; visibility: visible; transform: none; }
    .ah_sub a {
        display: block; padding: 10px 14px; border-radius: 10px; color: var(--ah); font-weight: 500; font-size: 15px;
        transition: background .2s ease, padding .2s ease;
    }
    .ah_sub a:hover { background: #F4F7FB; padding-left: 18px; }

    .ah_cta {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 46px; padding: 0 22px;
        border-radius: 30px; background: #fff; color: var(--ah); font-weight: 600; white-space: nowrap;
        box-shadow: 0 10px 24px -12px rgba(0,0,0,.4); transition: transform .25s ease, background .25s ease, color .25s ease;
    }
    .ah_cta:hover { transform: translateY(-2px); color: var(--ah); }

    /* ---------- Sticky state (after scrolling) ---------- */
.ah.is-sticky .ah_main {
    position: fixed; top: 0; left: 0; right: 0; background: var(--ah);
    box-shadow: 0 10px 30px -18px rgba(0,0,27,.6); animation: ahDown .35s ease;
}
@keyframes ahDown { from { transform: translateY(-100%); } to { transform: none; } }
.ah.is-sticky .ah_main_in { min-height: 74px; }
.ah.is-sticky .ah_logo img { max-height: 52px; }
    @keyframes ahDown { from { transform: translateY(-100%); } to { transform: none; } }
    .ah.is-sticky .ah_main_in { min-height: 74px; }
    .ah.is-sticky .ah_logo img { max-height: 52px; }
    

    /* ---------- Hamburger ---------- */
    .ah_burger {
        display: none; flex: none; width: 48px; height: 48px; padding: 0 12px; border: 0; border-radius: 12px;
        background: rgba(255,255,255,.14); flex-direction: column; justify-content: center; gap: 5px; cursor: pointer;
    }
    .ah_burger span { display: block; height: 2px; border-radius: 2px; background: #fff; transition: transform .3s ease, opacity .3s ease; }
    .ah_burger span:nth-child(2) { width: 70%; margin-left: auto; }

    /* ---------- Drawer ---------- */
    .ah_drawer { position: fixed; inset: 0; z-index: 2000; visibility: hidden; }
    .ah_drawer.is-open { visibility: visible; }
    .ah_drawer_bg { position: absolute; inset: 0; background: rgba(0,0,18,.55); opacity: 0; transition: opacity .3s ease; }
    .ah_drawer.is-open .ah_drawer_bg { opacity: 1; }
    .ah_drawer_panel {
        position: absolute; top: 0; right: 0; bottom: 0; width: min(380px, 88vw); background: #fff;
        display: flex; flex-direction: column; transform: translateX(100%); transition: transform .35s cubic-bezier(.2,.7,.2,1);
        box-shadow: -20px 0 50px -20px rgba(0,0,0,.35);
    }
    .ah_drawer.is-open .ah_drawer_panel { transform: none; }
    .ah_drawer_head { display: flex; align-items: center; justify-content: space-between; padding: 18px 20px; border-bottom: 1px solid #E6EAF2; }
    .ah_drawer_head .ah_logo img { max-height: 48px; }
    .ah_drawer_close {
        width: 42px; height: 42px; border-radius: 50%; border: 0; display: flex; align-items: center; justify-content: center;
        background: #F4F7FB; color: var(--ah); cursor: pointer;
    }
    .ah_mnav { flex: 1; overflow-y: auto; padding: 14px 20px 20px; }
    .ah_mnav ul { margin: 0; padding: 0; list-style: none; }
    .ah_mnav > ul > li { border-bottom: 1px solid #EEF1F6; }
    .ah_mnav > ul > li > a, .ah_mnav_toggle {
        width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 15px 4px;
        border: 0; background: none; color: var(--ah); font-size: 17px; font-weight: 600; text-align: left; cursor: pointer;
    }
    .ah_mnav > ul > li.is-active > a, .ah_mnav > ul > li.is-active > .ah_mnav_toggle { color: var(--ah-dark); }
    .ah_mnav_toggle svg { transition: transform .25s ease; }
    .ah_mnav_toggle[aria-expanded="true"] svg { transform: rotate(180deg); }
    .ah_mnav_sub { display: none; padding: 0 0 12px 12px !important; }
    .ah_mnav_sub.is-open { display: block; }
    .ah_mnav_sub a { display: block; padding: 9px 12px; border-left: 2px solid #E6EAF2; color: #4a5468; font-weight: 500; }
    .ah_mnav_sub a:hover { border-left-color: var(--ah); color: var(--ah); }
    .ah_cta_block { width: 100%; margin-top: 20px; background: var(--ah); color: #fff; height: 52px; }
    .ah_cta_block:hover { color: #fff; }
    .ah_drawer_foot { padding: 18px 20px 24px; background: #F6F8FB; border-top: 1px solid #E6EAF2; }
    .ah_drawer_line { display: flex; align-items: center; gap: 10px; padding: 6px 0; color: var(--ah); font-weight: 500; word-break: break-all; }
    .ah_social_dark { margin-top: 12px; }
    .ah_social_dark a { background: #fff; color: var(--ah); border: 1px solid #E6EAF2; width: 36px; height: 36px; }
    .ah_social_dark a:hover { background: var(--ah); color: #fff; }
    body.ah_lock { overflow: hidden; }

    /* ---------- Responsive ---------- */
    @media (max-width: 1399px) {
        .ah_menu > li > a { padding: 10px 11px; font-size: 15px; }
        .ah_nav { gap: 14px; }
    }
    @media (max-width: 1199px) {          /* tablet & below: hamburger */
        .ah_nav { display: none; }
        .ah_burger { display: flex; }
        .ah_main_in { min-height: 76px; }
        .ah_logo img { max-height: 52px; }
    }
    @media (max-width: 767px) {
        .ah_top_in { min-height: 40px; }
        .ah_contact { gap: 18px; }
        .ah_contact li + li::before { left: -9px; }
        .ah_social a { width: 26px; height: 26px; }
        .ah_social svg { width: 13px; height: 13px; }
    }
    @media (max-width: 575px) {
        .ah_top { font-size: 13px; }
        .ah_contact li:nth-child(2) { display: none; }          /* email lives in the drawer */
        .ah_contact li + li::before { display: none; }
        .ah_main_in { min-height: 68px; }
        .ah_logo img { max-height: 44px; }
        .ah_burger { width: 44px; height: 44px; }
    }
    @media (max-width: 360px) {
        .ah_social a:nth-child(n+4) { display: none; }
    }
</style>

<script>
(function () {
    function init() {
        var header = document.getElementById('siteHeader');
        var drawer = document.getElementById('ahDrawer');
        if (!header || !drawer) return;
        var burger = header.querySelector('.ah_burger');
        var top = header.querySelector('.ah_top');

        /* Sticky main row after scrolling past the top bar + a little */
        function onScroll() {
            var limit = (top ? top.offsetHeight : 0) + 80;
            header.classList.toggle('is-sticky', window.scrollY > limit);
        }
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        /* Drawer */
        function open() {
            drawer.classList.add('is-open');
            drawer.setAttribute('aria-hidden', 'false');
            burger.setAttribute('aria-expanded', 'true');
            document.body.classList.add('ah_lock');
            drawer.querySelector('.ah_drawer_close').focus();
        }
        function close() {
            drawer.classList.remove('is-open');
            drawer.setAttribute('aria-hidden', 'true');
            burger.setAttribute('aria-expanded', 'false');
            document.body.classList.remove('ah_lock');
            burger.focus();
        }
        burger.addEventListener('click', open);
        drawer.querySelectorAll('[data-ah-close]').forEach(function (el) { el.addEventListener('click', close); });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && drawer.classList.contains('is-open')) close();
        });
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1200 && drawer.classList.contains('is-open')) close();
        });

        /* Sub-menu accordions in the drawer */
        drawer.querySelectorAll('.ah_mnav_toggle').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var sub = document.getElementById(btn.getAttribute('aria-controls'));
                var isOpen = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
                sub.classList.toggle('is-open', !isOpen);
            });
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
})();
</script>