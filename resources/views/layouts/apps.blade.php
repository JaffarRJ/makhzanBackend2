<!DOCTYPE html>
<html  lang="{{ app()->getLocale() }}">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts/css')
</head>

<body>

@include('layouts/header')
@include('layouts/sidebar')

<main id="main" class="main">

{{--        <div class="pagetitle">--}}
{{--            <h1>Data Tables</h1>--}}
{{--            <nav>--}}
{{--                <ol class="breadcrumb">--}}
{{--                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>--}}
{{--                    <li class="breadcrumb-item">Tables</li>--}}
{{--                    <li class="breadcrumb-item active">Data</li>--}}
{{--                </ol>--}}
{{--            </nav>--}}
{{--        </div><!-- End Page Title -->--}}

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        @yield('content')
                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
@include('layouts/footer')
@include('layouts/js')
</body>

</html>
