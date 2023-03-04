<!DOCTYPE html>
<html>

<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--iPhone from zooming form issue-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <title>{{setting('site.title')}} | @yield('title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')" />
    <link rel="icon" type="image/png" href="{{asset('front/images/favicon.png')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700">
{{--    <link rel="stylesheet" href="{{asset('front/css/bootstrap.min.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset('front/style.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset('front/css/colorized.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset('front/css/animate.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset('front/css/font-awesome.min.css')}}">--}}
{{--    <script src="{{asset('front/js/jquery-2.2.4.min.js')}}"></script>--}}
{{--    <script src="{{asset('front/js/bootstrapValidator.min.js')}}"></script>--}}

    <link rel="stylesheet" href="{{asset('front/css/app.css')}}">
    @yield('css')

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-MNH9WV8');</script>
    <!-- End Google Tag Manager -->

</head>
<body class="transition nav-plusminus slide-navbar slide-navbar--left">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MNH9WV8"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@include('layouts.header')
    <main id="page-content">
        @yield('content')
        @include('layouts.footer')
    </main>

{{--    <script src="{{asset('front/js/css_browser_selector.js')}}"></script>--}}
{{--    <script src="{{asset('front/js/bootstrap.min.js')}}"></script>--}}
{{--    <script src="{{asset('front/js/viewportchecker.js')}}"></script>--}}
{{--    <script src="{{asset('front/js/kodeized.js')}}"></script>--}}
{{--    <script src="{{asset('front/js/main.js')}}"></script>--}}
    <script src="{{asset('front/js/app.js')}}"></script>
    <div class="loader hidden" style="width: 100%">
        <svg class="car" width="102" height="40" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(2 1)" stroke="#002742" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
                <path class="car__body" d="M47.293 2.375C52.927.792 54.017.805 54.017.805c2.613-.445 6.838-.337 9.42.237l8.381 1.863c2.59.576 6.164 2.606 7.98 4.531l6.348 6.732 6.245 1.877c3.098.508 5.609 3.431 5.609 6.507v4.206c0 .29-2.536 4.189-5.687 4.189H36.808c-2.655 0-4.34-2.1-3.688-4.67 0 0 3.71-19.944 14.173-23.902zM36.5 15.5h54.01" stroke-width="3"/>
                <ellipse class="car__wheel--left" stroke-width="3.2" fill="#FFF" cx="83.493" cy="30.25" rx="6.922" ry="6.808"/>
                <ellipse class="car__wheel--right" stroke-width="3.2" fill="#FFF" cx="46.511" cy="30.25" rx="6.922" ry="6.808"/>
                <path class="car__line car__line--top" d="M22.5 16.5H2.475" stroke-width="3"/>
                <path class="car__line car__line--middle" d="M20.5 23.5H.4755" stroke-width="3"/>
                <path class="car__line car__line--bottom" d="M25.5 9.5h-19" stroke-width="3"/>
            </g>
        </svg>
    </div>

    @yield('script')
</body>
</html>
