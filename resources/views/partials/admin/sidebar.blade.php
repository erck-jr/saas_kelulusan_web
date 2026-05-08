<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header p-2">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <div class="d-flex justify-content-center bg-gradient-light rounded-2">
            <a class="navbar-brand m-0" href="{{ route('admin.dashboard') }}">
                <x-application-logo></x-application-logo>
            </a>
        </div>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-gradient-primary' : '' }}" href="{{ route('admin.dashboard') }}">
                    <span class="material-icons-round opacity-10 me-2">dashboard</span>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.students.*') ? 'active bg-gradient-info' : '' }}" href="{{ route('admin.students.index') }}">
                    <span class="material-icons-round opacity-10 me-2">people</span>
                    <span class="nav-link-text ms-1">Data Siswa</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.school-classes.*') ? 'active bg-gradient-success' : '' }}" href="{{ route('admin.school-classes.index') }}">
                    <span class="material-icons-round opacity-10 me-2">school</span>
                    <span class="nav-link-text ms-1">Data Kelas</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.announcements.*') ? 'active bg-gradient-primary' : '' }}" href="{{ route('admin.announcements.index') }}">
                    <span class="material-icons-round opacity-10 me-2">campaign</span>
                    <span class="nav-link-text ms-1">Pengumuman</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.grades.*') ? 'active bg-gradient-danger' : '' }}" href="{{ route('admin.grades.index') }}">
                    <span class="material-icons-round opacity-10 me-2">grade</span>
                    <span class="nav-link-text ms-1">Data Nilai</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Pengaturan</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.graduation-periods.*') ? 'active bg-gradient-warning' : '' }}" href="{{ route('admin.graduation-periods.index') }}">
                    <span class="material-icons-round opacity-10 me-2">event</span>
                    <span class="nav-link-text ms-1">Periode Kelulusan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active bg-gradient-primary' : '' }}" href="{{ route('admin.users.index') }}">
                    <span class="material-icons-round opacity-10 me-2">manage_accounts</span>
                    <span class="nav-link-text ms-1">Pengguna</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.settings.*') ? 'active bg-gradient-primary' : '' }}" href="{{ route('admin.settings.index') }}">
                    <span class="material-icons-round opacity-10 me-2">settings</span>
                    <span class="nav-link-text ms-1">Pengaturan</span>
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="nav-link text-white bg-gradient-warning rounded-2 p-1" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                        <span class="material-icons-round ms-2 me-2">logout</span>
                        <span class="nav-link-text ms-1">Logout</span>
                    </a>
                </form>
            </li>
        </ul>
    </div>
</aside>
