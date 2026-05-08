@section('title', 'Dashboard')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
@endsection

<x-layouts.admin-layout>
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <span class="material-icons-round opacity-10 text-white font25 mt-2">people</span>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Siswa</p>
                        <h4 class="mb-0">{{ $totalStudents }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <a href="{{ route('admin.students.index') }}" class="text-primary text-sm font-weight-bolder">
                            Lihat Detail <span class="material-icons-round text-sm">arrow_forward</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <span class="material-icons-round opacity-10 text-white font25 mt-2">school</span>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Kelas</p>
                        <h4 class="mb-0">{{ $totalClasses }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <a href="{{ route('admin.school-classes.index') }}" class="text-primary text-sm font-weight-bolder">
                            Lihat Detail <span class="material-icons-round text-sm">arrow_forward</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <span class="material-icons-round opacity-10 text-white font25 mt-2">check_circle</span>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Siswa Lulus</p>
                        <h4 class="mb-0">{{ $totalGraduated }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span class="text-success text-sm font-weight-bolder">
                            @if($totalGraduated > 0)
                                {{ number_format(($totalGraduated/$totalStudents)*100, 1) }}
                            @else
                                0
                            @endif
                        % </span>dari total siswa
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <span class="material-icons-round opacity-10 text-white font25 mt-2">campaign</span>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Pengumuman</p>
                        <h4 class="mb-0">{{ $totalAnnouncements }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <a href="{{ route('admin.announcements.index') }}" class="text-primary text-sm font-weight-bolder">
                            Lihat Detail <span class="material-icons-round text-sm">arrow_forward</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>Pengumuman Terbaru</h6>
                        </div>
                        <div class="col-lg-6 col-5 my-auto text-end">
                            <a href="{{ route('admin.announcements.create') }}" class="btn btn-sm bg-gradient-dark mb-0">
                                <span class="material-icons-round text-sm">add</span> Tambah
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Judul</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAnnouncements as $announcement)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $announcement->title }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm {{ $announcement->is_published ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                            {{ $announcement->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $announcement->created_at->format('d M Y') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Statistik Kelulusan</h6>
                </div>
                <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                        @foreach($classStatistics as $class)
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <span class="material-icons-round text-dark text-gradient">school</span>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $class->name }}</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    {{ $class->graduated_count }}/{{ $class->total_students }} Siswa Lulus
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
