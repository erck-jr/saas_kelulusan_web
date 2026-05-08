<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <style>
        .bg-img {
            background-image: url('{{ asset('assets/img/bg-web.jpg')}}');
            /* Add the blur effect */
            filter: blur(3px);
            -webkit-filter: blur(3px);
        }
    </style>
</head>

<body class="index-page bg-gradient-dark">
    @include('partials.navbar')
    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-100" style="">
            <span class="mask bg-img opacity-9"></span>
            <div class="container">
                <div class="d-flex justify-content-center mt-7 mb-5">
                    <x-application-logo></x-application-logo>
                </div>
                {{ $slot }}
                @include('partials.footer')
            </div>
        </div>
    </main>
    @include('partials.scripts')
    @yield('custom_js')
</body>
</html>
