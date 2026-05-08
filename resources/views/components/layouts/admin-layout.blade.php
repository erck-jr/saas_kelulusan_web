<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <style>
    .font25{
        font-size: 2.5em !important;
    }
    </style>
</head>

<body class="g-sidenav-show bg-gray-200">
    @include('partials.admin.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('partials.admin.navbar')
        <div class="container-fluid py-4">
            {{ $slot }}
            @include('partials.footer')
        </div>
    </main>
    @include('partials.scripts')
</body>
</html>
