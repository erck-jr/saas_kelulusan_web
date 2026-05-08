@section('title', 'Detil Pengumuman')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.announcements.index') }}">Pengumuman</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detil Pengumuman</li>
@endsection

<x-layouts.admin-layout>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize ps-3">Detail Pengumuman</h6>
                        <div class="mx-3">
                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-sm btn-info">
                                <i class="material-icons-round text-sm">edit</i>
                                Edit
                            </a>
                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="material-icons-round text-sm">delete</i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body px-3 pb-2">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h4>{{ $announcement->title }}</h4>
                                <div class="text-sm text-muted mb-3">
                                    Status:
                                    @if($announcement->is_published)
                                        <span class="badge badge-sm bg-gradient-success">Dipublikasi</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-secondary">Draft</span>
                                    @endif
                                    |
                                    Tanggal Publikasi: {{ $announcement->published_at ? $announcement->published_at->format('d/m/Y H:i') : 'Belum ditentukan' }}
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        {!! nl2br(e($announcement->content)) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.announcements.index') }}" class="btn btn-light">
                                    <i class="material-icons-round text-sm">arrow_back</i>
                                    Kembali ke Daftar
                                </a>

                                @if(!$announcement->is_published)
                                    <form action="{{ route('admin.announcements.publish', $announcement) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn bg-gradient-success">
                                            <i class="material-icons-round text-sm">publish</i>
                                            Publikasikan Sekarang
                                        </button>
                                    </form>
                                @endif
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
</x-layouts.admin-layout>
