<!DOCTYPE html>
<html lang="ko">
<head>
    @if(config('website.ga'))
        <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('website.ga') }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '{{ config('website.ga') }}');
            </script>
    @endif
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- meta character set -->
    <meta charset="UTF-8">
    @include('partials.favicon')
    <!-- Title -->
    <title>@yield('title_prefix', config('website.title_prefix', ''))
        @yield('title', config('website.title', '라라벨 코리아 커뮤니티(Laravel Korea Community)'))
        @yield('title_postfix', config('website.title_postfix', ''))</title>
    <meta name="description" content="@yield('description',config('website.meta.description','라라벨,Laravel KR'))"/>
    <meta name="keywords" content="@yield('keywords',config('website.meta.keywords','라라벨 laravel 매뉴얼 '))"/>
    <meta name="author" content="@yield('author',config('website.meta.author','laravel@laravel.kr'))"/>
    <meta name="robots" content="@yield('robots',config('website.meta.robots','index,follow'))"/>
    <meta property="og:title" content="@yield('meta.title',config('website.title',''))" />
    <meta property="og:description" content="@yield('meta.description',config('website.meta.description',''))" />
    <meta property="og:site_name" content="@yield('meta.site_name',config('website.meta.og.site_name',''))" />
    <meta property="og:locale" content="@yield('meta.locale',config('website.meta.og.locale',''))" />
    <meta property="og:url" content="@yield('meta.url',config('website.meta.og.url',''))" />
    <meta property="og:type" content="@yield('meta.type',config('website.meta.og.type',''))" />
    <meta property="og:image" content="@yield('meta.image',config('website.meta.og.image',''))" />
    <meta name="docsearch:language" content="{{ app()->getLocale() }}" />
    <meta name="docsearch:version" content="1.0.0" />

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <!--
    CSS
    ============================================= -->
    <link rel="stylesheet" href="/assets/vendor/adventure/css/linearicons.css">
    <link rel="stylesheet" href="/assets/vendor/adventure/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/vendor/adventure/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/vendor/adventure/css/magnific-popup.css">
    {{--<link rel="stylesheet" href="/assets/vendor/adventure/css/animate.min.css">--}}
    <link rel="stylesheet" href="/assets/vendor/adventure/css/owl.carousel.css">
    <link rel="stylesheet" href="/assets/vendor/adventure/css/main.css">
    <link href='{{ mix('css/common.css') }}' rel='stylesheet' type='text/css'>
    <link href='{{ mix('css/index.css') }}' rel='stylesheet' type='text/css'>
</head>
<body>
<!-- start banner Area -->
<section class="banner-area" id="home">
    <!-- Start Header Area -->
    <header class="default-header">
        <nav class="navbar navbar-expand-lg  navbar-light">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/assets/images/laravel-korea-logo-white.png" style="height: 40px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="text-white lnr lnr-menu"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end align-items-center"
                     id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>
                            <a href="https://wiki.modernpug.org/display/LAR/questions/all" target="_blank">QNA</a>
                        </li>
                        <li>
                            <a href="https://github.com/laravelkr/website/issues/2" target="_blank">
                                라라벨로 만든 사이트
                            </a>
                        </li>
                        <li>
                            <a href="https://github.com/laravelkr/website/issues/3" target="_blank">
                                기타 학습자료
                            </a>
                        </li>
                        <li>
                            <a href="https://github.com/laravelkr/website/issues/4" target="_blank">
                                스터디/행사
                            </a>
                        </li>
                        <!-- Dropdown -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                유저 모임
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="https://www.facebook.com/groups/laravelkorea/"
                                   target="_blank">
                                    라라벨 코리아
                                </a>
                                <a class="dropdown-item" href="https://www.facebook.com/groups/655071604594451/"
                                   target="_blank">
                                    모던 PHP 유저 그룹
                                </a>
                                <a class="dropdown-item" href="https://open.kakao.com/o/g3dWlf0/"
                                   target="_blank">
                                    카카오톡 오픈채팅
                                </a>

                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                한글 매뉴얼
                            </a>
                            <div class="dropdown-menu">

                                @foreach(array_reverse(config('docs.versions')) as $supportVersion => $versionStatus)
                                    @php
                                        $deprecated = $versionStatus['deprecatedAt']<$today;
                                        $documentStatus = [];
                                        if($versionStatus['lts'])
                                            $documentStatus[]="LTS";
                                        if($versionStatus['in_translation'])
                                            $documentStatus[]="번역중";
                                        if($deprecated)
                                            $documentStatus[]="지원종료";
                                    @endphp
                                    <a class="dropdown-item {{ $deprecated?"deprecated":"" }} {{ $supportVersion == config('docs.default')?"default":"" }} {{ $versionStatus['in_translation']?"disabled":"" }}"
                                       href="{{ $versionStatus['in_translation']?"#":route('docs.show', [$supportVersion]) }}">
                                        {{ $supportVersion }}
                                        @if(count($documentStatus))
                                            ({{ implode(",", $documentStatus) }})
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- End Header Area -->
</section>


<section class="default-banner active-blog-slider">
    <div class="item-slider relative"
         style="background: url(/assets/vendor/adventure/images/pexels-photo-1181269.jpeg);background-size: cover;">
        <div class="overlay" style="background: rgba(0,0,0,.7)"></div>
        <div class="container">
            <div class="row fullscreen justify-content-center align-items-center">
                <div class="col-md-10 col-12">
                    <div class="banner-content text-center mb-20">
                        <a href="https://bit.ly/3ofdmrG" target="_blank">
{{--                        <h4 class="text-white mb-20 text-uppercase">Discover the Colorful World</h4>--}}
                        <h1 class="text-white mb-20 mt-80 text-uppercase">라라벨 Up & Running</h1>
                        <p class="text-white">처음부터 제대로 배우는 라라벨</p>
                        <img class="hello-illustration" src="//image.yes24.com/goods/95757831/800x0"
                             style="max-width:50%; height:auto;margin:auto;">

                        <span class="text-uppercase header-btn">구매하기</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="item-slider relative"
         style="background: url(/assets/vendor/adventure/images/pexels-photo-1181244.jpeg);background-size: cover;">
        <div class="overlay" style="background: rgba(0,0,0,.7)"></div>
        <div class="container">
            <div class="row fullscreen justify-content-center align-items-center">
                <div class="col-md-10 col-12">
                    <div class="banner-content text-center mb-20">

                        {{--<h4 class="text-white mb-20 text-uppercase">Discover the Colorful World</h4>--}}
                        <h1 class="text-uppercase mb-20 mt-80 text-white">라라벨 코리아</h1>
                        <p class="text-white">Laravel.kr은 라라벨을 사용하거나 관심 있는 사람들이 모여 뉴스와 정보를 공유하고 문제를 같이 해결하기 위해서 마련한
                            곳입니다.</p>
                        <a href="https://www.facebook.com/groups/laravelkorea/" class="text-uppercase header-btn"
                           target="_blank">페이스북 그룹</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="item-slider relative"
         style="background: url(/assets/vendor/adventure/images/company-concept-creative-7369.jpg);background-size: cover;">
        <div class="overlay" style="background: rgba(0,0,0,.7)"></div>
        <div class="container">
            <div class="row fullscreen justify-content-center align-items-center">
                <div class="col-md-10 col-12">
                    <div class="banner-content text-center mb-20">
                        {{--<h3 class="text-uppercase text-white"></h1>--}}
                        <h1 class="text-white mb-20 mt-80 text-uppercase">신입 PHP 개발자 안내서</h1>
                        <p class="text-white">이현석님의 "바쁜 팀장님 대신 알려주는 신입 PHP 개발자 안내서"</p>
                        <img class="hello-illustration" src="//misc.ridibooks.com/cover/3166000001/xxlarge"
                             style="max-width:50%; height:auto;margin:auto;">
                        <a href="https://ridibooks.com/v2/Detail?id=3166000001" target="_blank"
                           class="text-uppercase header-btn">구매하기</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="item-slider relative"
         style="background: url(/assets/vendor/adventure/images/pexels-photo-326424.jpeg);background-size: cover;">
        <div class="overlay" style="background: rgba(0,0,0,.7)"></div>
        <div class="container">
            <div class="row fullscreen justify-content-center align-items-center">
                <div class="col-md-10 col-12">
                    <div class="banner-content text-center mb-20">
                        {{--<h3 class="text-uppercase text-white"></h1>--}}
                        <h1 class="text-white mb-20 mt-80 text-uppercase">클린 아키텍처 인 PHP</h1>
                        <p class="text-white">이현석님의 신간 "클린 아키텍처 인 PHP"</p>
                        <img class="hello-illustration" src="https://d2sofvawe08yqg.cloudfront.net/cleanphp-korean/hero?1561303266"
                             style="max-width:50%; height:auto;margin:auto;">
                        <a href="https://leanpub.com/cleanphp-korean" target="_blank"
                           class="text-uppercase header-btn">구매하기</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="item-slider relative"
         style="background: url(/assets/vendor/adventure/images/blurred-background-close-up-coffee-cup-908284.jpg);background-size: cover;">
        <div class="overlay" style="background: rgba(0,0,0,.7)"></div>
        <div class="container">
            <div class="row fullscreen justify-content-center align-items-center">
                <div class="col-md-10 col-12">
                    <div class="banner-content text-center mb-20">
                        {{--<h4 class="text-white mb-20 text-uppercase">Discover the Colorful World</h4>--}}
                        <h1 class="text-uppercase mb-20 mt-80 text-white">모던 PHP 유저 그룹</h1>
                        <p class="text-white">모던 PHP 유저 그룹은 PHP 5.3 이후의 새로운 개발 방식과 라이브러리, 도구를 적극적으로 습득하고 알리는 목적으로
                            시작되었습니다.</p>
                        <a href="https://www.facebook.com/groups/655071604594451/" target="_blank"
                           class="text-uppercase header-btn">페이스북 그룹</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Start about Area -->
<section class="section-gap info-area" id="about">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-40 col-lg-8">
                <div class="title text-center">
                    <h2 class="mb-10">유저 모임에서 우리를 만나주세요</h2>
                    <p>라라벨 사용자들이 모여있는 곳에서 더 많은 정보를 나눠보세요</p>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-4 col-md-6 ">
                <div class="single-feature mb-30">
                    <a target="_blank" href="https://www.facebook.com/groups/laravelkorea/">
                        <div class="title d-flex flex-row pb-20">
                            <span class="lnr"><i class="fa fa-facebook-official text-primary" aria-hidden="true"></i></span>
                            <h4>
                                라라벨 코리아
                            </h4>
                        </div>
                        <p>
                            페이스북 그룹을 통해서 라라벨과 관련된 이야기를 나눌 수 있습니다
                        </p>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 ">
                <div class="single-feature">
                    <a href="https://www.facebook.com/groups/655071604594451/" target="_blank">
                        <div class="title d-flex flex-row pb-20">
                            <span class="lnr"><i class="fa fa-facebook-official text-primary" aria-hidden="true"></i></span>
                            <h4>
                                모던 PHP 유저그룹
                            </h4>
                        </div>
                        <p>
                            모던 PHP 유저 그룹은 PHP 5.3 이후의 새로운 개발 방식과 라이브러리, 도구를 적극적으로 습득하고 알리는 목적으로 시작되었습니다
                        </p>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 ">
                <div class="single-feature">
                    <a href="https://open.kakao.com/o/g3dWlf0" target="_blank">
                        <div class="title d-flex flex-row pb-20">
                            <span class="lnr"><i class="fa fa-comment text-warning" aria-hidden="true"></i></span>
                            <h4>
                                라라벨 카카오톡 오픈채팅
                            </h4>
                        </div>
                        <p>
                            카카오톡 오픈채팅을 통해 다른 분들과 같이 학습을 해보세요
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End about Area -->


<!-- Start feature Area -->
<section class="feature-area section-gap" id="secvice">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-60 col-lg-8">
                <div class="title text-center">
                    <h2 class="mb-10">같이 알아 두면 좋아요</h2>
                    <p>라라벨 사용자를 위한 참고 사이트 입니다</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 ">
                <div class="single-feature mb-30">
                    <a target="_blank" href="https://modernpug.github.io/php-the-right-way/">
                        <div class="title d-flex flex-row pb-20">
                            <span class="lnr lnr-book"></span>
                            <h4>
                                PHP The Right Way
                            </h4>
                        </div>
                        <p>
                            PHP를 올바르게 사용하기 위한 지침서입니다
                        </p>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 ">
                <div class="single-feature mb-30">
                    <a target="_blank" href="https://www.php-fig.org/psr/">
                        <div class="title d-flex flex-row pb-20">
                            <span class="lnr lnr-book"></span>
                            <h4>
                                PHP Standards Recommendations
                            </h4>
                        </div>
                        <p>
                            PHP의 표준 개발 권고사항입니다
                        </p>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 ">
                <div class="single-feature mb-30">
                    <a target="_blank" href="https://wiki.modernpug.org/display/LAR/questions/all">
                        <div class="title d-flex flex-row pb-20">
                            <span class="lnr lnr-question-circle"></span>
                            <h4>
                                묻고답하기
                            </h4>
                        </div>
                        <p>
                            다양한 주제에 대해서 질문하고 의견을 나눌 수 있습니다
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End feature Area -->



<!-- Start feature Area -->
<section class="feature-area section-gap" id="contributors">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-60 col-lg-8">
                <div class="title text-center">
                    <h1 class="mb-10">CONTRIBUTORS</h1>
                    <p>이 사이트가 운영될 수 있도록 기여해주신 분들입니다</p>
                </div>
            </div>
        </div>
        <div class="row list">

            {!! $contributorsHtml !!}
        </div>
    </div>
</section>
<!-- End feature Area -->



{{--

<!-- Start faq Area -->
<section class="faq-area section-gap" id="faq">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-60 col-lg-8">
                <div class="title text-center">
                    <h1 class="mb-10">Frequently Asked Questions</h1>
                    <p>Who are in extremely love with eco friendly system.</p>
                </div>
            </div>
        </div>
        <div class="row d-flex align-items-center">
            <div class="counter-left col-lg-3 col-md-3">
                <div class="single-facts">
                    <h2 class="counter">5962</h2>
                    <p>Projects Completed</p>
                </div>
                <div class="single-facts">
                    <h2 class="counter">2394</h2>
                    <p>New Projects</p>
                </div>
                <div class="single-facts">
                    <h2 class="counter">1439</h2>
                    <p>Tickets Submitted</p>
                </div>
                <div class="single-facts">
                    <h2 class="counter">933</h2>
                    <p>Cup of Coffee</p>
                </div>
            </div>
            <div class="faq-content col-lg-9 col-md-9">
                <div class="single-faq">
                    <h2 class="text-uppercase">
                        Are your Templates responsive?
                    </h2>
                    <p>
                        “Few would argue that, despite the advancements of feminism over the past three decades, women
                        still face a double standard when it comes to their behavior. While men’s
                        borderline-inappropriate behavior.
                    </p>
                </div>
                <div class="single-faq">
                    <h2 class="text-uppercase">
                        Does it have all the plugin as mentioned?
                    </h2>
                    <p>
                        “Few would argue that, despite the advancements of feminism over the past three decades, women
                        still face a double standard when it comes to their behavior. While men’s
                        borderline-inappropriate behavior.
                    </p>
                </div>
                <div class="single-faq">
                    <h2 class="text-uppercase">
                        Can i use the these theme for my client?
                    </h2>
                    <p>
                        “Few would argue that, despite the advancements of feminism over the past three decades, women
                        still face a double standard when it comes to their behavior. While men’s
                        borderline-inappropriate behavior.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End faq Area -->

--}}


@if(!empty($notices))
    @include('partials.notices')
@endif


<!-- start footer Area -->
<footer class="footer-area section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    {{--<h6>About Us</h6>--}}
                    <p>
                        LARAVEL IS A TRADEMARK OF TAYLOR OTWELL. COPYRIGHT © TAYLOR OTWELL .
                    </p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    <p class="footer-text">Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                        All rights reserved | This template is made with <i class="fa fa-heart-o"
                                                                            aria-hidden="true"></i> by <a
                                href="https://colorlib.com" target="_blank">Colorlib</a></p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </div>
            </div>
            <div class="col-lg-5  col-md-6 col-sm-6">

            </div>
            <div class="col-lg-2 col-md-6 col-sm-6 social-widget">
                <div class="single-footer-widget">
                    <h6>Follow Us</h6>
                    <p>Let us be social</p>
                    <div class="footer-social d-flex align-items-center">
                        <a href="https://github.com/laravelkr/" target="_blank"><i class="fa fa-github"></i></a>
                        <a href="https://www.facebook.com/groups/laravelkorea/" target="_blank"><i
                                    class="fa fa-facebook"></i></a>
                        <a href="https://twitter.com/laravelkr" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="mailto:laravel@laravel.kr" target="_blank"><i class="fa fa-envelope"
                                                                               aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End footer Area -->

<script src="/assets/vendor/adventure/js/vendor/jquery-2.2.4.min.js"></script>
<script src="/assets/vendor/adventure/js/popper.min.js"></script>
<script src="/assets/vendor/adventure/js/vendor/bootstrap.min.js"></script>
<script src="/assets/vendor/adventure/js/jquery.ajaxchimp.min.js"></script>
<script src="/assets/vendor/adventure/js/jquery.magnific-popup.min.js"></script>
<script src="/assets/vendor/adventure/js/owl.carousel.min.js"></script>
<script src="/assets/vendor/adventure/js/jquery.sticky.js"></script>
<script src="/assets/vendor/adventure/js/slick.js"></script>
<script src="/assets/vendor/adventure/js/jquery.counterup.min.js"></script>
<script src="/assets/vendor/adventure/js/waypoints.min.js"></script>
<script src="/assets/vendor/adventure/js/main.js"></script>
@include('partials.toastr')
</body>
</html>
