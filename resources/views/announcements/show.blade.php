@section('title','Detil Pengumuman')
<x-guest-layout>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize ps-3">Detail Pengumuman</h6>
                    </div>
                </div>
                <div class="card-body px-3 pb-2">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h4>{{ $announcement->title }}</h4>
                                <div class="text-sm text-muted mb-3">
                                    Status: <span class="badge badge-sm bg-gradient-success">Dipublikasi</span>
                                    Tanggal Publikasi: {{ $announcement->published_at ? $announcement->published_at->format('d/m/Y H:i') : 'Belum ditentukan' }}
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        {!! nl2br(e($announcement->content)) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('announcements') }}" class="btn btn-light">
                                    <i class="material-icons-round text-sm">arrow_back</i>
                                    Kembali ke Daftar
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-gray-100">
                                <div class="card-body">
                                    <h6 class="mb-3">Informasi Pengumuman</h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bg-transparent">
                                            <strong>Dibuat pada:</strong><br>
                                            {{ $announcement->created_at->format('d/m/Y H:i') }}
                                        </li>
                                        <li class="list-group-item bg-transparent">
                                            <strong>Terakhir diperbarui:</strong><br>
                                            {{ $announcement->updated_at->format('d/m/Y H:i') }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>
