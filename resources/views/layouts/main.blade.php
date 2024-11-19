<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title> @yield('title') - {{ config('app.name', 'Laravel') }}</title>
    {{-- favicon --}}
    <link rel="icon" href="{{ asset('logo.png') }}">

    <!-- Scripts -->
    @include('partials.style')
    @stack('style')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="hold-transition layout-top-nav">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        @include('partials.topbar')
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper py-5">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        @include('partials.footer-landing')
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    @include('partials.script')
    @stack('script')

</body>

</html>
