@section('title', 'Daftar Pengumuman')
<x-guest-layout>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize ps-3">Daftar Pengumuman</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Judul</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Publikasi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($announcements as $announcement)
                                    <tr>
                                        @if($announcement->is_published)
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $announcement->title }}</h6>
                                                    <p class="text-muted">{{ substr($announcement->content, 0, 20) }}
                                                        @if(strlen($announcement->content) > 20)
                                                            ....
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle px-3">
                                            {{ $announcement->published_at ? $announcement->published_at->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td class="align-middle px-3">
                                            <a href="{{ route('announcements.show', $announcement) }}" class="btn btn-sm btn-info" title="Detail">
                                                <i class="material-icons-round">visibility</i>
                                            </a>
                                        </td>
                                        @endif
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
</x-guest-layout>
