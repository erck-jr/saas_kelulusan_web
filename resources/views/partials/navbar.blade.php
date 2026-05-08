<!-- Navigation -->
<nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 shadow my-3 py-2 navbar-light mx-7 start-0 end-0 rounded">
    <div class="container">
        <a class="navbar-brand font-weight-bolder ms-sm-3 text-sm" href="{{ route('home') }}" rel="tooltip" title="Sistem Informasi Kelulusan" data-placement="bottom">
            <x-application-logo width="150px"></x-application-logo>
        </a>
        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0" id="navigation">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-2">
                    <a class="nav-link text-sm text-dark" href="{{ route('announcements') }}">
                        <span class="material-icons-round me-2 text-md">campaign</span> Pengumuman
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link text-dark" href="{{ route('login') }}">
                        <span class="material-icons-round me-2 text-md">person</span> Login
                    </a>
                </li>
                @if (Route::has('password.request'))
                    <li class="nav-item mx-2">
                        <a class="nav-link text-dark" href="{{ route('password.request') }}">
                            <span class="material-icons-round me-2 text-md">key</span> Reset Password
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<!-- End Navigation -->
