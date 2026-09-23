@extends('web.layouts.app')

@section('title', 'About Us || AL-Azhar')
@section('body_class', 'td_theme_2')
@section('footer_class', 'td_color_1')

@section('content')

  <!-- Start Page Heading Section -->
  <section class="td_page_heading td_center td_bg_filed td_heading_bg text-center td_hobble"
    data-src="{{ asset('uploads/website-images/students-after-graduation-ceremony.jpg') }}">
    <div class="container">
      <div class="td_page_heading_in">
        <h1 class="td_white_color td_fs_48 td_mb_10">About Us</h1>
        <ol class="breadcrumb m-0 td_fs_20 td_opacity_8 td_semibold td_white_color">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">About Us</li>
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

  <!-- Start About Section -->
  <section>
    <div class="td_height_100 td_height_lg_50"></div>
    <div class="td_about td_style_1">
      <div class="container">
        <div class="row align-items-center td_gap_y_40">
          <div class="col-lg-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.25s">
            <div class="td_about_thumb_wrap">
              <div class="td_about_year text-uppercase td_fs_64 td_bold">EST 1995</div>
              <div class="td_about_thumb_1">
                <img src="{{ asset('uploads/website-images/about1.jpg') }}" alt="">
              </div>
              <div class="td_about_thumb_2">
                <img src="{{ asset('uploads/website-images/about2.jpg') }}" alt="">
              </div>
              <a href="https://www.youtube.com/embed/rRid6GCJtgc" class="td_circle_text td_center td_video_open">
                <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M14.086 8.63792C14.6603 9.03557 14.6603 9.88459 14.086 10.2822L2.54766 18.2711C1.88444 18.7303 0.978418 18.2557 0.978418 17.449L0.978418 1.47118C0.978418 0.664496 1.88444 0.189811 2.54767 0.649016L14.086 8.63792Z"
                    fill="white" />
                </svg>
                <img src="{{ asset('uploads/website-images/rotate image.webp') }}" alt="">
              </a>
              <div class="td_circle_shape"></div>
            </div>
          </div>
          <div class="col-lg-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
            <div class="td_section_heading td_style_1 td_mb_30">
              <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
                About us</p>
              <h2 class="td_section_title td_fs_48 mb-0">The largest &amp; Most Diverse Universities in the United Emirates</h2>
              <p class="td_section_subtitle td_fs_18 mb-0">
                Far far away, behind the word mountains, far from the Consonantia, there live the blind texts. Separated
                they marks grove right at the coast of the Semantics a large language ocean
              </p>
            </div>
            <div class="td_mb_40">
              <ul class="td_list td_style_5 td_mp_0">
                <li>
                  <h3 class="td_fs_24 td_mb_8">Graduate Program</h3>
                  <p class="td_fs_18 mb-0">Browse the Undergraduate Degrees</p>
                </li>
                <li>
                  <h3 class="td_fs_24 td_mb_8">Undergraduate Program</h3>
                  <p class="td_fs_18 mb-0">Browse the Undergraduate Degrees</p>
                </li>
              </ul>
            </div>
            <a href="{{ url('/contact-us') }}" class="td_btn td_style_1 td_radius_30 td_medium td_with_shadow">
              <span class="td_btn_in td_white_color td_accent_bg">
                <span>Contact Us</span>
                <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.1575 4.34302L3.84375 15.6567" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round"></path>
                  <path
                    d="M15.157 11.4142C15.157 11.4142 16.0887 5.2748 15.157 4.34311C14.2253 3.41142 8.08594 4.34314 8.08594 4.34314"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="td_height_100 td_height_lg_50"></div>
  </section>
  <!-- End About Section -->

  <!-- Start Campus Life -->
  @php
    $arrowSvg = '<svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.564 4.70161L4.42188 18.8438" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M18.5654 13.5341C18.5654 13.5341 19.7299 5.85989 18.5654 4.69528C17.4008 3.53067 9.72656 4.69531 9.72656 4.69531" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>';
    $campusCols = [
      [
        ['img' => 'studentlife.jpg', 'title' => 'Campus Student Life', 'delay' => '0.2s'],
        ['img' => 'creation.jpg', 'title' => 'Recreations & Wellness', 'delay' => '0.3s'],
      ],
      [
        ['img' => 'about1.jpg', 'title' => 'Recreations & Wellness', 'delay' => '0.25s'],
        ['img' => 'sports.jpg', 'title' => 'Sports & Fitness', 'delay' => '0.3s'],
      ],
    ];
  @endphp
  <section class="td_accent_bg td_shape_section_1">
    <div class="td_shape_position_4 td_accent_color position-absolute">
      <svg width="37" height="40" viewBox="0 0 37 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g opacity="0.4">
          <rect y="12.3906" width="23.6182" height="31.0709" rx="1" transform="rotate(-30.4551 0 12.3906)" fill="white" />
          <rect x="4" y="14.8125" width="18.5361" height="2.62207" rx="1.31104" transform="rotate(-30.4551 4 14.8125)" fill="currentColor" />
          <rect x="7" y="19.8125" width="18.5361" height="2.62207" rx="1.31104" transform="rotate(-30.4551 7 19.8125)" fill="currentColor" />
        </g>
      </svg>
    </div>
    <div class="td_height_100 td_height_lg_50"></div>
    <div class="container">
      <div class="row td_gap_y_40">
        <div class="col-lg-5 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
          <div class="td_height_57 td_height_lg_0"></div>
          <div class="td_section_heading td_style_1">
            <h2 class="td_section_title td_fs_48 mb-0 td_white_color">Navigate</h2>
            <p class="td_section_subtitle td_fs_18 mb-0 td_white_color td_opacity_7">
              Far far away, behind the word mountains, far from the Consonantia, there live the blind texts. Separated
              they marks grove right at the coast of the Semantics
            </p>
          </div>
          <div class="td_btn_box">
            <svg width="299" height="315" viewBox="0 0 299 315" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g opacity="0.75" clip-path="url(#clip0_34_2222)">
                <path
                  d="M242.757 275.771C242.505 275.771 242.253 275.75 242.005 275.707C32.3684 239.98 0.342741 8.13005 0.0437414 5.79468C-0.108609 4.51176 0.22739 3.21754 0.9787 2.19335C1.73001 1.16916 2.8359 0.497795 4.05598 0.32519C5.27606 0.152585 6.5117 0.492693 7.4943 1.27158C8.4769 2.05047 9.12704 3.20518 9.3034 4.48471C9.59772 6.7514 40.7872 231.477 243.5 266.022C244.658 266.22 245.702 266.868 246.426 267.838C247.15 268.808 247.5 270.028 247.406 271.256C247.312 272.484 246.782 273.63 245.921 274.467C245.06 275.303 243.93 275.769 242.757 275.771Z"
                  fill="white" />
                <path
                  d="M299.002 275.455C271.709 283.305 237.446 297.872 215.562 314.617L235.465 269.602L223.318 221.648C242.099 242.137 273.428 262.728 299.002 275.455Z"
                  fill="white" />
              </g>
              <defs>
                <clipPath id="clip0_34_2222">
                  <rect width="299" height="314" fill="white" transform="translate(0 0.421875)" />
                </clipPath>
              </defs>
            </svg>
            <div class="td_btn_box_in">
              <a href="{{ url('/courses') }}" class="td_btn td_style_1 td_radius_30 td_medium td_fs_18">
                <span class="td_btn_in td_heading_color td_white_bg">
                  <span>View All Program</span>
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 offset-lg-1">
          <div class="row">
            @foreach ($campusCols as $colIndex => $cards)
              <div class="col-sm-6">
                @if ($colIndex == 1)
                  <div class="td_height_50 td_height_lg_30"></div>
                @endif
                @foreach ($cards as $i => $card)
                  @if ($i > 0)
                    <div class="td_height_40 td_height_lg_30"></div>
                  @endif
                  <div class="td_card td_style_2 wow fadeInUp" data-wow-duration="1s" data-wow-delay="{{ $card['delay'] }}">
                    <a href="#" class="td_card_thumb d-block">
                      <img src="{{ asset('uploads/website-images/' . $card['img']) }}" alt="" class="w-100">
                    </a>
                    <div class="td_card_info">
                      <h2 class="td_card_title mb-0 td_fs_18 td_semibold td_white_color">
                        <a href="#">{{ $card['title'] }}</a>
                      </h2>
                      <a href="#" class="td_card_btn">{!! $arrowSvg !!}{!! $arrowSvg !!}</a>
                    </div>
                  </div>
                @endforeach
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <div class="td_height_100 td_height_lg_75"></div>
  </section>
  <!-- End Campus Life -->

  <!-- Start Departments Section -->
  <section>
    <div class="td_height_100 td_height_lg_75"></div>
    <div class="container">
      <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
        <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
          Departments</p>
        <h2 class="td_section_title td_fs_48 mb-0">Popular Departments</h2>
        <div class="d-flex justify-content-center">
          <p class="td_section_subtitle td_fs_18 mb-0 qs-custom-min-width-1">Far far away, behind the word mountains, far
            from the Consonantia, there live the blind texts. Separated they marks grove right at the coast</p>
        </div>
      </div>
      <div class="td_height_50 td_height_lg_50"></div>
      <div class="td_iconbox_1_wrap">
        {{-- TODO: replace the icon file names with real images in public/uploads/website-images --}}
        @foreach ([
            ['name' => 'Economics', 'icon' => 'department_one.png', 'delay' => '0.2s'],
            ['name' => 'Computer', 'icon' => 'department_two.png', 'delay' => '0.3s'],
            ['name' => 'Electrical', 'icon' => 'department_three.png', 'delay' => '0.4s'],
            ['name' => 'Civil', 'icon' => 'department_four.png', 'delay' => '0.4s'],
        ] as $dept)
          <div class="td_iconbox td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="{{ $dept['delay'] }}">
            <div class="td_iconbox_icon td_accent_color td_mb_10">
              <img src="{{ asset('uploads/website-images/' . $dept['icon']) }}" alt="{{ $dept['name'] }}">
            </div>
            <h3 class="td_iconbox_title mb-0 td_medium td_fs_36">{{ $dept['name'] }}</h3>
          </div>
        @endforeach
      </div>
    </div>
    <div class="td_height_100 td_height_lg_50"></div>
  </section>
  <!-- End Departments Section -->

  <!-- Start Video Section -->
  <section>
    <div class="td_video_block td_style_1 td_accent_bg td_center text-center"
      style="background-image: url('{{ asset('uploads/website-images/videoimg.jpg') }}'); background-size: cover; background-position: center;">
      <div class="container">
        <a href="https://www.youtube.com/embed/rRid6GCJtgc" class="td_player_btn_wrap_2 td_video_open wow zoomIn"
          data-wow-duration="1s" data-wow-delay="0.2s">
          <span class="td_player_btn td_center">
            <span></span>
          </span>
        </a>
        <div class="td_height_70 td_height_lg_50"></div>
        <h2 class="td_fs_48 td_white_color mb-0 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">Take a Video
          Tour to Learn Intro of Campus</h2>
      </div>
    </div>
    <div class="container wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.25s">
      <div class="td_contact_box td_style_1 td_accent_bg td_radius_10">
        <div class="td_contact_box_left">
          <p class="td_fs_18 td_light td_white_color td_mb_4">Get In Touch:</p>
          <h3 class="td_fs_36 mb-0 td_white_color"><a href="mailto:info@educve.com">info@educve.com</a></h3>
        </div>
        <div class="td_contact_box_or td_fs_24 td_medium td_white_bg td_center rounded-circle td_accent_color">
          or
        </div>
        <div class="td_contact_box_right">
          <p class="td_fs_18 td_light td_white_color td_mb_4">Get In Touch:</p>
          <h3 class="td_fs_36 mb-0 td_white_color"><a href="tel:+019987698870">+01 998 7698 870</a></h3>
        </div>
      </div>
    </div>
  </section>
  <!-- End Video Section -->

  <!-- Start Blog Section -->
  @php
    $posts = [
      ['slug' => 'navigating-the-new-education-system-a-students-guide', 'img' => 'blog1.jpg', 'title' => "Navigating the New Education System: A Student's Guide"],
      ['slug' => 'overview-of-the-new-education-system-for-students', 'img' => 'blog2.jpg', 'title' => 'Overview of the New Education System for Students'],
      ['slug' => 'complete-guide-for-students-on-the-new-education-system', 'img' => 'blog1.jpg', 'title' => 'Complete Guide for Students on the New Education System'],
    ];
  @endphp
  <section>
    <div class="td_height_100 td_height_lg_75"></div>
    <div class="container">
      <div class="td_section_heading td_style_1 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
        <p class="td_section_subtitle_up td_fs_18 td_semibold td_spacing_1 td_mb_10 text-uppercase td_accent_color">
          BLOG &amp; ARTICLES</p>
        <h2 class="td_section_title td_fs_48 mb-0">Take A Look At The Latest <br>Articles</h2>
      </div>
      <div class="td_height_50 td_height_lg_50"></div>
      <div class="row td_gap_y_30">
        @foreach ($posts as $post)
          <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
            <div class="td_post td_style_1">
              <a href="{{ url('/blog/' . $post['slug']) }}" class="td_post_thumb d-block">
                <img src="{{ asset('uploads/website-images/' . $post['img']) }}" alt="">
                <i class="fa-solid fa-link"></i>
              </a>
              <div class="td_post_info">
                <div class="td_post_meta td_fs_14 td_medium td_mb_20">
                  <span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M12.6667 1.33333H12V0.666667C12 0.489856 11.9298 0.320286 11.8047 0.195262C11.6797 0.0702379 11.5101 0 11.3333 0C11.1565 0 10.987 0.0702379 10.8619 0.195262C10.7369 0.320286 10.6667 0.489856 10.6667 0.666667V1.33333H5.33333V0.666667C5.33333 0.489856 5.2631 0.320286 5.13807 0.195262C5.01305 0.0702379 4.84348 0 4.66667 0C4.48986 0 4.32029 0.0702379 4.19526 0.195262C4.07024 0.320286 4 0.489856 4 0.666667V1.33333H3.33333C2.4496 1.33439 1.60237 1.68592 0.97748 2.31081C0.352588 2.93571 0.00105857 3.78294 0 4.66667L0 12.6667C0.00105857 13.5504 0.352588 14.3976 0.97748 15.0225C1.60237 15.6474 2.4496 15.9989 3.33333 16H12.6667C13.5504 15.9989 14.3976 15.6474 15.0225 15.0225C15.6474 14.3976 15.9989 13.5504 16 12.6667V4.66667C15.9989 3.78294 15.6474 2.93571 15.0225 2.31081C14.3976 1.68592 13.5504 1.33439 12.6667 1.33333ZM1.33333 4.66667C1.33333 4.13623 1.54405 3.62753 1.91912 3.25245C2.29419 2.87738 2.8029 2.66667 3.33333 2.66667H12.6667C13.1971 2.66667 13.7058 2.87738 14.0809 3.25245C14.456 3.62753 14.6667 4.13623 14.6667 4.66667V5.33333H1.33333V4.66667ZM12.6667 14.6667H3.33333C2.8029 14.6667 2.29419 14.456 1.91912 14.0809C1.54405 13.7058 1.33333 13.1971 1.33333 12.6667V6.66667H14.6667V12.6667C14.6667 13.1971 14.456 13.7058 14.0809 14.0809C13.7058 14.456 13.1971 14.6667 12.6667 14.6667Z" fill="black" />
                      <circle cx="8" cy="10" r="1" fill="black" />
                      <circle cx="4.666" cy="10" r="1" fill="black" />
                      <circle cx="11.334" cy="10" r="1" fill="black" />
                    </svg>
                    15-01-2025
                  </span>
                  <span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <circle cx="7.885" cy="3.854" r="3.385" stroke="#00001B" stroke-width="0.94" />
                      <path d="M1.8 13.25C1.8 10.2 3.2 8.2 4.8 8.2C5.6 8.7 6.6 9.4 8 9.4C9.4 9.4 10.4 8.7 11.2 8.2C12.8 8.2 14.2 10.2 14.2 13.25C14.2 14.6 13.3 15.5 11.84 15.5H4.13C2.7 15.5 1.8 14.6 1.8 13.25Z" stroke="#00001B" stroke-width="0.94" />
                    </svg>
                    John Doe
                  </span>
                </div>
                <h2 class="td_post_title td_fs_24 td_medium td_mb_16">
                  <a href="{{ url('/blog/' . $post['slug']) }}">{{ $post['title'] }}</a>
                </h2>
                <p class="td_post_subtitle td_mb_24 td_heading_color td_opacity_7">Education is a dynamic and evolving
                  field that plays a crucial.</p>
                <a href="{{ url('/blog/' . $post['slug']) }}" class="td_btn td_style_1 td_type_3 td_radius_30 td_medium">
                  <span class="td_btn_in td_accent_color">
                    <span>Read More</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="td_height_100 td_height_lg_50"></div>
  </section>
  <!-- End Blog Section -->

@endsection