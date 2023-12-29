<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
{{--<!DOCTYPE html>--}}
{{--<html  lang="{{ app()->getLocale() }}">--}}

{{--<head>--}}
{{--    <!-- CSRF Token -->--}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
{{--    @include('layouts/css')--}}
{{--</head>--}}

{{--<body>--}}

{{--@include('layouts/header')--}}
{{--@include('layouts/sidebar')--}}

{{--<main id="main" class="main">--}}

{{--    --}}{{--    <div class="pagetitle">--}}
{{--    --}}{{--        <h1>Data Tables</h1>--}}
{{--    --}}{{--        <nav>--}}
{{--    --}}{{--            <ol class="breadcrumb">--}}
{{--    --}}{{--                <li class="breadcrumb-item"><a href="index.html">Home</a></li>--}}
{{--    --}}{{--                <li class="breadcrumb-item">Tables</li>--}}
{{--    --}}{{--                <li class="breadcrumb-item active">Data</li>--}}
{{--    --}}{{--            </ol>--}}
{{--    --}}{{--        </nav>--}}
{{--    --}}{{--    </div><!-- End Page Title -->--}}

{{--    <section class="section">--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-12">--}}

{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        @yield('content')--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

{{--</main><!-- End #main -->--}}

{{--<!-- ======= Footer ======= -->--}}
{{--@include('layouts/footer')--}}
{{--@include('layouts/js')--}}
{{--</body>--}}

{{--</html>--}}
