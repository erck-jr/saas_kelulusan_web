@section('title', 'Detil Pengguna')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.users.index') }}">Data Pengguna</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Detil Pengguna</li>
@endsection

<x-layouts.admin-layout>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize ps-3">Detail Pengguna</h6>
                        <div class="mx-3">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-info">
                                <i class="material-icons-round text-sm">edit</i>
                                Edit
                            </a>
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="material-icons text-sm">delete</i>
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body px-3 pb-2">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="text-sm text-muted">Nama Lengkap</label>
                                        <p class="mb-0">{{ $user->name }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-sm text-muted">Email</label>
                                        <p class="mb-0">{{ $user->email }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-sm text-muted">Peran</label>
                                        <p class="mb-0">
                                            <span class="badge badge-sm bg-gradient-{{ $user->role === 'admin' ? 'primary' : 'info' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-gray-100">
                                <div class="card-body">
                                    <h6 class="mb-3">Informasi Akun</h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bg-transparent">
                                            <strong>Email terverifikasi:</strong><br>
                                            @if($user->email_verified_at)
                                                {{ $user->email_verified_at->format('d/m/Y H:i') }}
                                            @else
                                                <span class="text-danger">Belum terverifikasi</span>
                                            @endif
                                        </li>
                                        <li class="list-group-item bg-transparent">
                                            <strong>Bergabung pada:</strong><br>
                                            {{ $user->created_at->format('d/m/Y H:i') }}
                                        </li>
                                        <li class="list-group-item bg-transparent">
                                            <strong>Terakhir diperbarui:</strong><br>
                                            {{ $user->updated_at->format('d/m/Y H:i') }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light">
                            <i class="material-icons-round text-sm">arrow_back</i>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.admin-layout>
