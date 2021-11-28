<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    @include('partials.favicon')
    <!-- Title -->
    <title>@yield('title_prefix', config('website.title_prefix', ''))
        @yield('title', config('website.title', '라라벨 코리아 커뮤니티(Laravel Korea Community)'))
        @yield('title_postfix', config('website.title_postfix', ''))</title>
    <meta name="description" content="@yield('description',config('website.meta.description','라라벨,Laravel KR'))"/>
    <meta name="keywords" content="@yield('keywords',config('website.meta.keywords','라라벨 laravel 매뉴얼 '))"/>
    <meta name="author" content="@yield('author',config('website.meta.author','laravel@laravel.kr'))"/>
    <meta name="robots" content="@yield('robots',config('website.meta.robots','index,follow'))"/>
    <link rel="canonical" href="@yield('canonical',url()->current())"/>
    <meta property="og:title" content="@yield('meta.title',config('website.title',''))"/>
    <meta property="og:description" content="@yield('meta.description',config('website.meta.description',''))"/>
    <meta property="og:site_name" content="@yield('meta.site_name',config('website.meta.og.site_name',''))"/>
    <meta property="og:locale" content="@yield('meta.locale',config('website.meta.og.locale',''))"/>
    <meta property="og:url" content="@yield('meta.url',config('website.meta.og.url',''))"/>
    <meta property="og:type" content="@yield('meta.type',config('website.meta.og.type',''))"/>
    <meta property="og:image" content="@yield('meta.image',config('website.meta.og.image',''))"/>


    <link href="/assets/vendor/coreui/vendors/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="/assets/vendor/coreui/vendors/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="/assets/vendor/coreui/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/assets/vendor/coreui/vendors/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

    <link href="/assets/vendor/coreui/css/style.css" rel="stylesheet">
    <link href="/assets/vendor/coreui/vendors/pace-progress/css/pace.min.css" rel="stylesheet">

    <link href='https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/tomorrow-night.min.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link href='{{ mix('css/common.css') }}' rel='stylesheet' type='text/css'>
    <link href='{{ mix('css/docs.css') }}' rel='stylesheet' type='text/css'>
    @yield('head')
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed
{{ Request::cookie('navbar-toggle','true')=='true'?"sidebar-lg-show":"" }}
{{ Request::cookie('aside-toggle','true')=='true'?"aside-menu-lg-show":"" }}
">

@include('docs.nav')
<div class="app-body">
    @include('docs.sidebar')
    <main class="main">

        <div class="breadcrumb">
            @yield('last-modify')
        </div>

        <?php /** @var \App\Models\Banner[]|Illuminate\Support\Collection $banners */?>
        @if($banners->count())

            <div class="container-fluid">
                <div id="banner-slide" class="owl-carousel">

                <?php /** @var \App\Models\Banner $banner */?>
                @foreach($banners->shuffle() as $banner)
                    <div class="item">
                        <a href="{{ $banner->url }}" target="_blank"
                           onclick="ga('send', 'event', 'banner', 'click', '{{ $banner->code }}', 1);"  style="float:right;">
                            <img src="{{ $banner->imageUrl }}"/>
                        </a>
                    </div>
                @endforeach

                </div>
            </div>
        @endif

        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    @include('docs.aside')

    <span id="back-to-top" class="text-info">
        <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
    </span>
    <span id="kakao-open-chat">
        <a href="https://open.kakao.com/o/g3dWlf0" target="_blank" data-toggle="tooltip" data-placement="left"
           title="혼자 공부하기 힘들 땐?">
            <img src="{{ asset('assets/images/kakao.png') }}" alt="라라벨 카카오톡 오픈채팅">
        </a>
    </span>

</div>

@if(!empty($notices))
    @include('partials.notices')
@endif

<footer class="app-footer">
    <div>
        <a href="https://coreui.io/">CoreUI</a>
        <span>© 2018 creativeLabs.</span>
    </div>

    <div class="ml-auto">
        <span>Powered by</span>
        <a href="https://coreui.io/">CoreUI</a>
    </div>
</footer>

<script src="/assets/vendor/coreui/vendors/jquery/js/jquery.min.js"></script>
<script src="/assets/vendor/coreui/vendors/popper.js/js/popper.min.js"></script>
<script src="/assets/vendor/coreui/vendors/bootstrap/js/bootstrap.min.js"></script>
{{--<script src="/assets/vendor/coreui/vendors/pace-progress/js/pace.min.js"></script>--}}
<script src="/assets/vendor/coreui/vendors/perfect-scrollbar/js/perfect-scrollbar.min.js"></script>
<script src="/assets/vendor/coreui/vendors/@coreui/coreui/js/coreui.min.js"></script>
{{--<script src="/assets/vendor/coreui/vendors/chart.js/js/Chart.min.js"></script>--}}
{{--<script src="/assets/vendor/coreui/vendors/@coreui/coreui-plugin-chartjs-custom-tooltips/js/custom-tooltips.min.js"></script>--}}

<script src="/assets/vendor/coreui/js/jquery.cookie.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/anchor-js/4.1.1/anchor.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
<script src="{{ mix('js/docs.js') }}"></script>

@include('partials.toastr')
@yield('footerScript')
</body>
</html>
