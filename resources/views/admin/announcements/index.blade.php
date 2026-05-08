@section('title', 'Data Pengumuman')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Data Pengumuman</li>
@endsection

<x-layouts.admin-layout>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize ps-3">Daftar Pengumuman</h6>
                        <a href="{{ route('admin.announcements.create') }}" class="btn btn-sm btn-success mx-3">
                            <i class="material-icons-round text-sm">add</i>
                            Tambah Pengumuman
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Judul</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Publikasi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($announcements as $announcement)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $announcement->title }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle px-3">
                                            @if($announcement->is_published)
                                                <span class="badge badge-sm bg-gradient-success">Dipublikasi</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Draft</span>
                                            @endif
                                        </td>
                                        <td class="align-middle px-3">
                                            {{ $announcement->published_at ? $announcement->published_at->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td class="align-middle px-3">
                                            <a href="{{ route('admin.announcements.show', $announcement) }}" class="btn btn-sm btn-info" title="Detail">
                                                <i class="material-icons-round">visibility</i>
                                            </a>
                                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="material-icons-round">edit</i>
                                            </a>
                                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="material-icons-round">delete</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">Tidak ada pengumuman</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="px-3 pt-4">
                            {{ $announcements->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.admin-layout>
