@section('title', 'Edit Pengguna')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.users.index') }}">Data Pengguna</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit Pengguna</li>
@endsection

<x-layouts.admin-layout>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Edit Pengguna</h6>
                    </div>
                </div>
                <div class="card-body px-3 pb-2">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3 is-filled">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group input-group-outline my-3 is-filled">
                                    <label class="form-label">Alamat Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control"
                                           name="password_confirmation">
                                </div>

                                <div class="my-4">
                                    <label class="ms-0">Peran</label>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="role"
                                               id="role_admin" value="admin"
                                               {{ old('role', $user->role) === 'admin' ? 'checked' : '' }}
                                               {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                        <label class="custom-control-label" for="role_admin">
                                            Admin
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role"
                                               id="role_operator" value="operator"
                                               {{ old('role', $user->role) === 'operator' ? 'checked' : '' }}
                                               {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                        <label class="custom-control-label" for="role_operator">
                                            Operator
                                        </label>
                                    </div>
                                    @error('role')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-light me-2">
                                    Batal
                                </a>
                                <button type="submit" class="btn bg-gradient-primary">
                                    Perbarui Pengguna
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.admin-layout>
@section('custom_js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle Material Kit Input Group Outline behavior
        const inputs = document.querySelectorAll('.input-group-outline input');
        inputs.forEach(input => {
            if (input.value) {
                input.parentElement.classList.add('is-filled');
            }
            input.addEventListener('focus', () => {
                input.parentElement.classList.add('focused', 'is-filled');
            });
            input.addEventListener('blur', () => {
                input.parentElement.classList.remove('focused');
                if (!input.value) {
                    input.parentElement.classList.remove('is-filled');
                }
            });
        });
    });
</script>
@endsection
