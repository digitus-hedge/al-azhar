@php
    // TODO: keep these the same as the header
    $ftPhone   = '99884567809';
    $ftEmail   = 'al-azhar@gmail.com';
    $ftAddress = 'Al Azhar Central School, Mala, Thrissur, Kerala, India';
    $ftHours   = 'Mon – Sat, 9:00 AM – 4:00 PM';
    $ftLogo    = asset('images/logo1.png');

    $ftLink = fn ($name) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : '#';

    $ftQuick = [
        'About the School'     => url('/about-us'),
        "Principal's Message"  => $ftLink('principal-message'),
        'School Management'    => $ftLink('school-management'),
        'Admission'            => $ftLink('admission'),
        'Mandatory Disclosure' => $ftLink('mandatory-disclosure'),
        'Contact Us'           => $ftLink('contact.index'),
    ];
    $ftCampus = [
        'Departments'    => $ftLink('departments.index'),
        'Facilities'     => $ftLink('facilities.index'),
        'Gallery'        => $ftLink('gallery.index'),
        'Events'         => $ftLink('events.index'),
        'News & Notices' => $ftLink('news-notices.index'),
    ];
    $ftSocials = [
        'Facebook'  => ['https://www.facebook.com/',  '<path d="M22 12.06C22 6.51 17.52 2 12 2S2 6.51 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.89h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94z"/>'],
        'X'         => ['https://www.twitter.com/',   '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>'],
        'Instagram' => ['https://www.instagram.com/', '<path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.256 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 8.25a3.25 3.25 0 1 1 0-6.5 3.25 3.25 0 0 1 0 6.5zm5.25-8.6a1.13 1.13 0 1 0 0-2.26 1.13 1.13 0 0 0 0 2.26z"/>'],
        'LinkedIn'  => ['https://www.linkedin.com/',  '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.446-2.136 2.94v5.666H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 1 1 0-4.124 2.062 2.062 0 0 1 0 4.124zM7.114 20.452H3.56V9h3.554v11.452z"/>'],
    ];
@endphp

<!-- Start Footer Section -->
<footer class="af">
    <div class="container">
        <div class="af_grid">

            {{-- School --}}
            <div class="af_col af_col_brand">
                <a href="{{ url('/') }}" class="af_logo" aria-label="Al Azhar Central School – Home">
                    <img src="{{ $ftLogo }}" alt="Al Azhar Central School">
                </a>
                <p class="af_about">
                    A CBSE-affiliated school in Mala, Thrissur, offering value-based education from
                    Pre-KG to Grade XII with boarding facilities.
                </p>
                <div class="af_social">
                    @foreach ($ftSocials as $label => [$url, $icon])
                        <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ $label }}">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">{!! $icon !!}</svg>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Quick links --}}
            <div class="af_col">
                <h2 class="af_title">Quick Links</h2>
                <ul class="af_links">
                    @foreach ($ftQuick as $label => $href)
                        <li><a href="{{ $href }}">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Campus life --}}
            <div class="af_col">
                <h2 class="af_title">Campus Life</h2>
                <ul class="af_links">
                    @foreach ($ftCampus as $label => $href)
                        <li><a href="{{ $href }}">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div class="af_col">
                <h2 class="af_title">Get in Touch</h2>
                <ul class="af_contact">
                    <li>
                        <span class="af_icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg></span>
                        <a href="https://maps.google.com/?q={{ urlencode($ftAddress) }}" target="_blank" rel="noopener">{{ $ftAddress }}</a>
                    </li>
                    <li>
                        <span class="af_icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2z"/></svg></span>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $ftPhone) }}">{{ $ftPhone }}</a>
                    </li>
                    <li>
                        <span class="af_icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg></span>
                        <a href="mailto:{{ $ftEmail }}">{{ $ftEmail }}</a>
                    </li>
                    <li>
                        <span class="af_icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg></span>
                        <span>{{ $ftHours }}</span>
                    </li>
                </ul>
                <a href="{{ $ftLink('admission') }}" class="af_cta">
                    Admission Enquiry
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M8 7h9v9"/></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="af_bottom">
        <div class="container af_bottom_in">
            <p class="mb-0">&copy; {{ date('Y') }} Al Azhar Central School, Mala. All rights reserved.</p>
            <ul class="af_bottom_links">
                <li><a href="{{ $ftLink('mandatory-disclosure') }}">Mandatory Disclosure</a></li>
                <li><a href="{{ $ftLink('contact.index') }}">Contact</a></li>
            </ul>
        </div>
    </div>

    <button type="button" class="af_top" aria-label="Back to top">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
    </button>
</footer>
<!-- End Footer Section -->

<style>
    .af { --af: var(--heading-color, #00539B); --af-dark: #002F5F; position: relative; background: var(--af-dark); color: rgba(255,255,255,.75); }
    .af a { color: inherit; transition: color .25s ease; }
    .af a:hover { color: #fff; }

    .af_grid {
        display: grid; grid-template-columns: 1.4fr 1fr 1fr 1.4fr; gap: 40px;
        padding: 90px 0 60px;
    }
    .af_logo img { max-height: 80px; width: auto; }
    .af_about { margin: 22px 0 24px; line-height: 1.75; font-size: 15px; max-width: 340px; }

    .af_social { display: flex; gap: 10px; }
    .af_social a {
        width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15); color: #fff;
        transition: background .25s ease, color .25s ease, transform .25s ease;
    }
    .af_social a:hover { background: #fff; color: var(--af); transform: translateY(-3px); }

    .af_title {
        position: relative; margin: 8px 0 26px; padding-bottom: 14px; color: #fff; font-size: 22px; font-weight: 600;
    }
    .af_title::after { content: ""; position: absolute; left: 0; bottom: 0; width: 40px; height: 3px; border-radius: 3px; background: #fff; opacity: .6; }

    .af_links { margin: 0; padding: 0; list-style: none; }
    .af_links li + li { margin-top: 12px; }
    .af_links a { display: inline-flex; align-items: center; gap: 8px; font-size: 15px; }
    .af_links a::before {
        content: ""; width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,.4);
        transition: background .25s ease, transform .25s ease;
    }
    .af_links a:hover::before { background: #fff; transform: scale(1.4); }

    .af_contact { margin: 0 0 24px; padding: 0; list-style: none; }
    .af_contact li { display: flex; align-items: flex-start; gap: 12px; font-size: 15px; line-height: 1.6; }
    .af_contact li + li { margin-top: 14px; }
    .af_contact a, .af_contact span:last-child { word-break: break-word; padding-top: 5px; }
    .af_icon {
        flex: none; width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,.08); color: #fff;
    }

    .af_cta {
        display: inline-flex; align-items: center; gap: 8px; height: 48px; padding: 0 24px; border-radius: 30px;
        background: #fff; color: var(--af) !important; font-weight: 600;
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .af_cta:hover { transform: translateY(-2px); box-shadow: 0 12px 24px -12px rgba(0,0,0,.5); }

    .af_bottom { border-top: 1px solid rgba(255,255,255,.12); font-size: 14px; }
    .af_bottom_in { display: flex; align-items: center; justify-content: space-between; gap: 12px 24px; flex-wrap: wrap; padding: 22px 0; }
    .af_bottom_links { display: flex; gap: 22px; margin: 0; padding: 0; list-style: none; }

    .af_top {
        position: fixed; right: 24px; bottom: 24px; z-index: 900; width: 46px; height: 46px; border-radius: 50%; border: 0;
        display: flex; align-items: center; justify-content: center; background: var(--af); color: #fff; cursor: pointer;
        box-shadow: 0 12px 24px -10px rgba(0,0,0,.45);
        opacity: 0; visibility: hidden; transform: translateY(10px); transition: all .3s ease;
    }
    .af_top.is-visible { opacity: 1; visibility: visible; transform: none; }
    .af_top:hover { background: var(--af-dark); }

    @media (max-width: 1199px) {
        .af_grid { grid-template-columns: 1fr 1fr; gap: 44px 40px; padding: 70px 0 50px; }
    }
    @media (max-width: 575px) {
        .af_grid { grid-template-columns: 1fr; gap: 36px; padding: 56px 0 40px; }
        .af_about { max-width: none; }
        .af_bottom_in { flex-direction: column; text-align: center; }
        .af_cta { width: 100%; justify-content: center; }
        .af_top { right: 16px; bottom: 16px; width: 42px; height: 42px; }
    }
</style>

<script>
(function () {
    function init() {
        var btn = document.querySelector('.af_top');
        if (!btn) return;
        function toggle() { btn.classList.toggle('is-visible', window.scrollY > 500); }
        window.addEventListener('scroll', toggle, { passive: true });
        toggle();
        btn.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
})();
</script>