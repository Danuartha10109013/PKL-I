<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>@yield('title')</title>
<!--

Lava Landing Page

https://templatemo.com/tm-540-lava-landing-page

-->

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{asset('vendor')}}/assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="{{asset('vendor')}}/assets/css/font-awesome.css">

    <link rel="stylesheet" href="{{asset('vendor')}}/assets/css/templatemo-lava.css">

    <link rel="stylesheet" href="{{asset('vendor')}}/assets/css/owl-carousel.css">

</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->


    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        @include('layouts.topbar')
    </header>
    <!-- ***** Header Area End ***** -->


    @yield('content')

    <!-- ***** Footer Start ***** -->
    <footer id="contact-us">
        @include('layouts.footer')
    </footer>

    <!-- jQuery -->
    <script src="{{asset('vendor')}}/assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="{{asset('vendor')}}/assets/js/popper.js"></script>
    <script src="{{asset('vendor')}}/assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="{{asset('vendor')}}/assets/js/owl-carousel.js"></script>
    <script src="{{asset('vendor')}}/assets/js/scrollreveal.min.js"></script>
    <script src="{{asset('vendor')}}/assets/js/waypoints.min.js"></script>
    <script src="{{asset('vendor')}}/assets/js/jquery.counterup.min.js"></script>
    <script src="{{asset('vendor')}}/assets/js/imgfix.min.js"></script>

    <!-- Global Init -->
    <script src="{{asset('vendor')}}/assets/js/custom.js"></script>

</body>
</html>