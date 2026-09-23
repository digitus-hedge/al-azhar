<!-- Start Footer Section -->
<footer class="td_footer td_style_1 {{ $footerClass ?? '' }}">
    <div class="container">
        <div class="td_footer_row">
            <div class="td_footer_col">
                <div class="td_footer_widget">
                    <div class="td_footer_text_widget td_fs_18">
                        <img src="{{ asset('uploads/custom-images/secondary-logo.webp') }}" alt="Logo">
                        <p>It is a long established fact that a reader will be distracted by the readable content of
                            a page when looking at its layout the point of using lorem varius sit amet ipsum.</p>
                    </div>
                    <ul class="td_footer_address_widget td_medium td_mp_0">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.24.2 2.45.57 3.57a1 1 0 0 1-.25 1.02l-2.2 2.2z"/></svg>
                            <a href="tel:123-343-4444">123-343-4444</a>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 2C7.86 2 4.5 5.36 4.5 9.5c0 5.25 6.3 11.53 6.57 11.8a1.25 1.25 0 0 0 1.77 0c.26-.27 6.57-6.55 6.57-11.8C19.5 5.36 16.14 2 12 2zm0 10.25a2.75 2.75 0 1 1 0-5.5 2.75 2.75 0 0 1 0 5.5z"/></svg>
                            Los Angeles, CA, USA
                        </li>
                    </ul>
                </div>
            </div>
            <div class="td_footer_col">
                <div class="td_footer_widget">
                    <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">Navigate</h2>
                    <ul class="td_footer_widget_menu">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/about-us') }}">About Us</a></li>
                        <li><a href="{{ url('/contact-us') }}">Contact</a></li>
                        <li><a href="{{ url('/faq') }}">FAQ</a></li>
                        <li><a href="{{ url('/terms-conditions') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="td_footer_col">
                <div class="td_footer_widget">
                    <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">Category</h2>
                    <ul class="td_footer_widget_menu">
                        <li><a href="{{ url('/courses?category=server-management') }}">Server Management</a></li>
                        <li><a href="{{ url('/courses?category=online-educations') }}">Online Educations</a></li>
                        <li><a href="{{ url('/courses?category=design-system') }}">Design System</a></li>
                        <li><a href="{{ url('/courses?category=blockchain-develop') }}">Blockchain Develop</a></li>
                        <li><a href="{{ url('/courses?category=photography-video') }}">Photography &amp; Video</a></li>
                        <li><a href="{{ url('/courses?category=math-technology') }}">Math &amp; Technology</a></li>
                    </ul>
                </div>
            </div>
            <div class="td_footer_col">
                <div class="td_footer_widget">
                    <h2 class="td_footer_widget_title td_fs_32 td_white_color td_medium td_mb_30">Subscribe Now</h2>
                    <div class="td_newsletter td_style_1">
                        <p class="td_mb_20 td_opacity_7">Far far away, behind the word mountains, far from the Consonantia.</p>
                        <form action="{{ url('/store-newsletter') }}" method="POST" class="td_newsletter_form">
                            @csrf
                            <input type="email" class="td_newsletter_input" placeholder="Email address" name="email" required>
                            <button type="submit" class="td_btn td_style_1 td_radius_30 td_medium">
                                <span class="td_btn_in td_white_color td_accent_bg">
                                    <span>Subscribe</span>
                                </span>
                            </button>
                        </form>
                    </div>
                    <div class="td_footer_social_btns td_fs_20">
                        <a target="_blank" href="https://www.facebook.com/" class="td_center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M22 12.06C22 6.51 17.52 2 12 2S2 6.51 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.89h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94z"/></svg>
                        </a>
                        <a target="_blank" href="https://www.twitter.com/" class="td_center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a target="_blank" href="https://www.instagram.com/" class="td_center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.256 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 8.25a3.25 3.25 0 1 1 0-6.5 3.25 3.25 0 0 1 0 6.5zm5.25-8.6a1.13 1.13 0 1 0 0-2.26 1.13 1.13 0 0 0 0 2.26z"/></svg>
                        </a>
                        <a target="_blank" href="https://www.linkedin.com/" class="td_center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.446-2.136 2.94v5.666H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 1 1 0-4.124 2.062 2.062 0 0 1 0 4.124zM7.114 20.452H3.56V9h3.554v11.452z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="td_footer_bottom td_fs_18">
        <div class="container">
            <div class="td_footer_bottom_in">
                <p class="td_copyright mb-0">Copyright {{ date('Y') }}, Educve All Rights Reserved.</p>
                <ul class="td_footer_widget_menu">
                    <li><a href="{{ url('/terms-conditions') }}">Terms &amp; Conditions</a></li>
                    <li><a href="{{ url('/privacy-policy') }}">Privacy &amp; Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer Section -->