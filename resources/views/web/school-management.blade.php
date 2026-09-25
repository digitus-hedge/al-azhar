@extends('web.layouts.app')

@section('title', 'School Management || AL-Azhar')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@php
    $leader  = $leader ?? null;
    $members = $members ?? collect();

    $smPhoto = fn ($m) => $m->photo ? asset('storage/' . $m->photo) : null;
    $smRole  = fn ($m) => $m->designation?->name ?? '';
    $smInit  = function ($m) {
        $parts = preg_split('/\s+/', trim((string) $m->name));
        return strtoupper(mb_substr($parts[0] ?? '', 0, 1) . mb_substr(end($parts) ?: '', 0, 1));
    };
    // Bio may come from a rich-text editor: keep safe formatting only
    $smBio = fn ($m) => trim(strip_tags((string) $m->bio, '<p><br><strong><b><em><i><u><ul><ol><li>'));
    $smBioShort = fn ($m, $len = 140) => \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags(str_replace(['<br>', '</p>'], ' ', (string) $m->bio)))), $len);
@endphp

@section('content')

    <!-- Start Page Heading Section -->
    <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
        data-src="{{ asset('images/services-banner.webp') }}"
        style="background-image: url('{{ asset('images/services-banner.webp') }}'); background-size: cover; background-position: center;">
        <div class="container">
            <div class="td_page_heading_in">
                <h1 class="td_white_color td_fs_48 td_mb_10">School Management</h1>
                <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/about-us') }}">About Us</a></li>
                    <li class="breadcrumb-item active">School Management</li>
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

    <section class="sm_section">
        <div class="td_height_100 td_height_lg_75"></div>
        <div class="container">

            <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase sm_accent">
                    <i></i> Leadership <i></i>
                </p>
                <h2 class="td_section_title td_fs_48 mb-0">The People Who Guide Our School</h2>
                <div class="d-flex justify-content-center">
                    <p class="td_section_subtitle td_fs_18 mb-0 sm_intro">
                        Our management committee and trustees bring vision, care and commitment to every
                        part of school life at Al Azhar Central School.
                    </p>
                </div>
            </div>
            <div class="td_height_60 td_height_lg_40"></div>

            @if (! $leader)
                <div class="sm_empty">Management profiles will be published here soon.</div>
            @else

                {{-- ================= Leader (first by designation order) ================= --}}
                <div class="sm_leader wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="sm_leader_photo">
                        @if ($smPhoto($leader))
                            <img src="{{ $smPhoto($leader) }}" alt="{{ $leader->name }}">
                        @else
                            <span class="sm_initials sm_initials_lg">{{ $smInit($leader) }}</span>
                        @endif
                    </div>
                    <div class="sm_leader_body">
                        @if ($smRole($leader))
                            <span class="sm_role_badge">{{ $smRole($leader) }}</span>
                        @endif
                        <h3 class="sm_leader_name">{{ $leader->name }}</h3>
                        @if ($smBio($leader) !== '')
                            <div class="sm_leader_bio">
                                <svg class="sm_quote" width="46" height="32" viewBox="0 0 65 46" fill="currentColor" aria-hidden="true">
                                    <path d="M13.9286 26.6H1V1H26.8571V27.362L17.956 45H6.26764L14.8213 28.0505L15.5534 26.6H13.9286ZM51.0714 26.6H38.1429V1H64V27.362L55.0988 45H43.4105L51.9642 28.0505L52.6962 26.6H51.0714Z"/>
                                </svg>
                                {!! $smBio($leader) !!}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ================= Other members ================= --}}
                @if ($members->isNotEmpty())
                    <div class="td_height_80 td_height_lg_50"></div>
                    <div class="row td_gap_y_30">
                        @foreach ($members as $m)
                            <div class="col-xl-3 col-lg-4 col-sm-6 wow fadeInUp" data-wow-duration="1s"
                                data-wow-delay="{{ 0.15 + ($loop->index % 4) * 0.05 }}s">
                                <button type="button" class="sm_card" data-member="{{ $loop->index }}"
                                    aria-label="Read more about {{ $m->name }}">
                                    <span class="sm_card_photo">
                                        @if ($smPhoto($m))
                                            <img src="{{ $smPhoto($m) }}" alt="{{ $m->name }}" loading="lazy">
                                        @else
                                            <span class="sm_initials">{{ $smInit($m) }}</span>
                                        @endif
                                        @if ($smBio($m) !== '')
                                            <span class="sm_card_more">Read profile</span>
                                        @endif
                                    </span>
                                    <span class="sm_card_body">
                                        <span class="sm_card_name">{{ $m->name }}</span>
                                        @if ($smRole($m))
                                            <span class="sm_card_role">{{ $smRole($m) }}</span>
                                        @endif
                                        @if ($smBioShort($m) !== '')
                                            <span class="sm_card_bio">{{ $smBioShort($m, 90) }}</span>
                                        @endif
                                    </span>
                                </button>

                                {{-- Full profile (moved into the pop-up on click) --}}
                                <template id="sm_tpl_{{ $loop->index }}">
                                    <div class="sm_modal_photo">
                                        @if ($smPhoto($m))
                                            <img src="{{ $smPhoto($m) }}" alt="{{ $m->name }}">
                                        @else
                                            <span class="sm_initials sm_initials_lg">{{ $smInit($m) }}</span>
                                        @endif
                                    </div>
                                    <div class="sm_modal_body">
                                        @if ($smRole($m))
                                            <span class="sm_role_badge">{{ $smRole($m) }}</span>
                                        @endif
                                        <h3 class="sm_modal_name">{{ $m->name }}</h3>
                                        <div class="sm_modal_bio">
                                            @if ($smBio($m) !== '')
                                                {!! $smBio($m) !!}
                                            @else
                                                <p>Profile details will be added soon.</p>
                                            @endif
                                        </div>
                                    </div>
                                </template>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
        <div class="td_height_100 td_height_lg_75"></div>
    </section>

    {{-- Profile pop-up --}}
    <div class="sm_modal" id="smModal" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Member profile">
        <div class="sm_modal_bg" data-close></div>
        <div class="sm_modal_box">
            <button type="button" class="sm_modal_close" data-close aria-label="Close">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
            <div class="sm_modal_content"></div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    /* --heading-color is used instead of --accent-color (broken under td_theme_2) */
    .sm_section, .sm_modal { --sm: var(--heading-color, #00539B); --sm-dark: #002F5F; --sm-line: #E6EAF2; --sm-muted: #6b7489; }
    .sm_section { background: #F8F9FB; }
    .td_page_heading .breadcrumb-item + .breadcrumb-item::before { content: "/" !important; color: #fff; padding: 0 8px; }
    .sm_accent { color: var(--sm); }
    .sm_section .td_section_subtitle_up i::before, .sm_section .td_section_subtitle_up i::after { background-color: var(--sm); }
    .sm_intro { max-width: 700px; }
    .sm_empty { text-align: center; padding: 60px 20px; border: 2px dashed var(--sm-line); border-radius: 16px; color: var(--sm-muted); background: #fff; }

    .sm_initials {
        width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
        background: linear-gradient(145deg, var(--sm), var(--sm-dark)); color: #fff; font-size: 56px; font-weight: 700; letter-spacing: 2px;
    }
    .sm_initials_lg { font-size: 96px; }
    .sm_role_badge {
        display: inline-block; padding: 5px 16px; border-radius: 30px; background: #eef4ff; color: var(--sm);
        font-size: 14px; font-weight: 600; letter-spacing: .5px; text-transform: uppercase;
    }

    /* ---------- Leader ---------- */
    .sm_leader {
        display: grid; grid-template-columns: 420px 1fr; gap: 50px; align-items: center;
        padding: 30px; border-radius: 24px; background: #fff; border: 1px solid var(--sm-line);
        box-shadow: 0 30px 70px -45px rgba(0,0,27,.45); position: relative; overflow: hidden;
    }
    .sm_leader::after {
        content: ""; position: absolute; width: 320px; height: 320px; right: -120px; top: -120px;
        border-radius: 50%; background: rgba(0,83,155,.05); pointer-events: none;
    }
    .sm_leader_photo { border-radius: 18px; overflow: hidden; aspect-ratio: 4 / 5; background: #eef0f7; }
    .sm_leader_photo img { width: 100%; height: 100%; object-fit: cover; object-position: center top; }
    .sm_leader_body { position: relative; z-index: 1; padding-right: 20px; }
    .sm_leader_name { margin: 16px 0 22px; color: var(--sm); font-size: 42px; font-weight: 700; line-height: 1.15; }
    .sm_leader_bio {
        position: relative; padding-left: 24px; border-left: 3px solid var(--sm);
        font-size: 18px; line-height: 1.85; color: #3d4556;
    }
    .sm_leader_bio p { margin-bottom: 16px; }
    .sm_leader_bio > *:last-child { margin-bottom: 0; }
    .sm_quote { position: absolute; top: -44px; right: 0; color: var(--sm); opacity: .08; }

    /* ---------- Member cards ---------- */
    .sm_card {
        width: 100%; height: 100%; padding: 0; border: 1px solid var(--sm-line); border-radius: 18px; overflow: hidden;
        background: #fff; text-align: left; display: flex; flex-direction: column; cursor: pointer;
        box-shadow: 0 18px 40px -32px rgba(0,0,27,.5); transition: transform .35s ease, box-shadow .35s ease;
    }
    .sm_card:hover { transform: translateY(-8px); box-shadow: 0 30px 55px -32px rgba(0,0,27,.55); }
    .sm_card:focus-visible { outline: 3px solid var(--sm); outline-offset: 3px; }
    .sm_card_photo { position: relative; display: block; aspect-ratio: 4 / 4.4; overflow: hidden; background: #eef0f7; }
    .sm_card_photo img { width: 100%; height: 100%; object-fit: cover; object-position: center top; transition: transform .8s ease; }
    .sm_card:hover .sm_card_photo img { transform: scale(1.06); }
    .sm_card_more {
        position: absolute; left: 50%; bottom: 16px; transform: translate(-50%, 12px); opacity: 0;
        padding: 7px 18px; border-radius: 30px; background: #fff; color: var(--sm);
        font-size: 14px; font-weight: 600; white-space: nowrap; transition: all .35s ease;
        box-shadow: 0 10px 24px -10px rgba(0,0,0,.4);
    }
    .sm_card:hover .sm_card_more { opacity: 1; transform: translate(-50%, 0); }
    .sm_card_body { display: flex; flex-direction: column; gap: 4px; padding: 20px 20px 22px; border-top: 3px solid var(--sm); flex: 1; }
    .sm_card_name { color: var(--sm); font-size: 20px; font-weight: 600; line-height: 1.3; }
    .sm_card_role { color: var(--sm-muted); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
    .sm_card_bio { margin-top: 8px; color: #5b6477; font-size: 14px; line-height: 1.6; }

    /* ---------- Pop-up ---------- */
    .sm_modal {
        position: fixed; inset: 0; z-index: 99999; display: flex; align-items: center; justify-content: center; padding: 30px;
        visibility: hidden; opacity: 0; transition: opacity .3s ease, visibility .3s ease;
    }
    .sm_modal.is-open { visibility: visible; opacity: 1; }
    .sm_modal_bg { position: absolute; inset: 0; background: rgba(0,0,18,.75); backdrop-filter: blur(3px); }
    .sm_modal_box {
        position: relative; z-index: 1; width: 100%; max-width: 900px; max-height: 100%; overflow: auto;
        background: #fff; border-radius: 22px; transform: translateY(20px); transition: transform .3s ease;
    }
    .sm_modal.is-open .sm_modal_box { transform: none; }
    .sm_modal_close {
        position: absolute; top: 16px; right: 16px; z-index: 2; width: 42px; height: 42px; border-radius: 50%; border: 0;
        display: flex; align-items: center; justify-content: center; background: #F4F7FB; color: var(--sm); cursor: pointer;
    }
    .sm_modal_close:hover { background: var(--sm); color: #fff; }
    .sm_modal_content { display: grid; grid-template-columns: 320px 1fr; }
    .sm_modal_photo { min-height: 100%; background: #eef0f7; }
    .sm_modal_photo img { width: 100%; height: 100%; min-height: 380px; object-fit: cover; object-position: center top; }
    .sm_modal_body { padding: 40px 36px; }
    .sm_modal_name { margin: 14px 0 18px; color: var(--sm); font-size: 30px; font-weight: 700; line-height: 1.2; }
    .sm_modal_bio { font-size: 16px; line-height: 1.8; color: #3d4556; }
    .sm_modal_bio p { margin-bottom: 14px; }
    .sm_modal_bio > *:last-child { margin-bottom: 0; }
    body.sm_lock { overflow: hidden; }

    /* ---------- Responsive ---------- */
    @media (max-width: 1199px) {
        .sm_leader { grid-template-columns: 340px 1fr; gap: 36px; }
        .sm_leader_name { font-size: 36px; }
    }
    @media (max-width: 991px) {
        .sm_leader { grid-template-columns: 1fr; padding: 24px; }
        .sm_leader_photo { max-width: 420px; }
        .sm_leader_body { padding-right: 0; }
    }
    @media (max-width: 767px) {
        .sm_card:hover { transform: none; }
        .sm_card_more { opacity: 1; transform: translate(-50%, 0); }
        .sm_modal { padding: 0; align-items: flex-end; }
        .sm_modal_box { max-height: 92vh; border-radius: 22px 22px 0 0; }
        .sm_modal_content { grid-template-columns: 1fr; }
        .sm_modal_photo img { min-height: 0; aspect-ratio: 4 / 3; }
        .sm_modal_body { padding: 26px 20px 32px; }
        .sm_modal_name { font-size: 24px; }
    }
    @media (max-width: 575px) {
        .sm_leader { padding: 16px; border-radius: 18px; }
        .sm_leader_name { font-size: 28px; margin: 12px 0 16px; }
        .sm_leader_bio { font-size: 16px; padding-left: 16px; }
        .sm_initials_lg { font-size: 72px; }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    function init() {
        var modal = document.getElementById('smModal');
        if (!modal) return;
        var content = modal.querySelector('.sm_modal_content');
        var lastFocus = null;

        function open(i) {
            var tpl = document.getElementById('sm_tpl_' + i);
            if (!tpl) return;
            lastFocus = document.activeElement;
            content.innerHTML = '';
            content.appendChild(tpl.content.cloneNode(true));
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('sm_lock');
            modal.querySelector('.sm_modal_close').focus();
        }
        function close() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('sm_lock');
            if (lastFocus) lastFocus.focus();
        }

        document.querySelectorAll('.sm_card').forEach(function (card) {
            card.addEventListener('click', function () { open(card.getAttribute('data-member')); });
        });
        modal.querySelectorAll('[data-close]').forEach(function (el) { el.addEventListener('click', close); });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) close();
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
})();
</script>
@endpush