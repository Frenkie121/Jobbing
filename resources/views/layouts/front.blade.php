
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

<!-- Basic Page Needs
================================================== -->
<meta charset="utf-8">
<title>Jobbing | @yield('subtitle')</title>

<!-- Mobile Specific Metas
================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
================================================== -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/colors/green.css') }}" id="colors">

@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <div id="wrapper">

        <!-- Header
        ================================================== -->

        @include('front.includes.header')

        <div class="clearfix"></div>

        @yield('content')

        <!-- Footer
        ================================================== -->
        <div class="margin-top-15"></div>

        @include('front.includes.footer')

        <!-- Back To Top Button -->
        <div id="backtotop"><a href="#"></a></div>

    </div>
    <!-- Wrapper / End -->

    <!-- Scripts
    ================================================== -->
    <script src="{{ asset('assets/scripts/jquery-2.1.3.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/custom.js') }}"></script>
    <script src="{{ asset('assets/scripts/jquery.superfish.js') }}"></script>
    <script src="{{ asset('assets/scripts/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/jquery.themepunch.showbizpro.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/jquery.flexslider-min.js') }}"></script>
    <script src="{{ asset('assets/scripts/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/jquery.jpanelmenu.js') }}"></script>
    <script src="{{ asset('assets/scripts/stacktable.js') }}"></script>

</body>
</html>