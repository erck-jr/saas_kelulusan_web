@section('title', 'Tambah Pengumuman')

@section('breadcrumbs')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.announcements.index') }}">Pengumuman</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tambah Pengumuman</li>
@endsection

<x-layouts.admin-layout>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Tambah Pengumuman Baru</h6>
                    </div>
                </div>
                <div class="card-body px-3 pb-2">
                    <form method="POST" action="{{ route('admin.announcements.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Judul Pengumuman</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           name="title" value="{{ old('title') }}" required autofocus>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group input-group-outline my-3">
                                    <textarea class="form-control @error('content') is-invalid @enderror"
                                              name="content" rows="10" placeholder="Isi Pengumuman"
                                              required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3">Pengaturan Publikasi</h6>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_published"
                                                   id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_published">
                                                Publikasikan sekarang
                                            </label>
                                        </div>

                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Tanggal Publikasi</label>
                                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                                   name="published_at" value="">
                                            @error('published_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="d-flex justify-content-end mt-4">
                                            <a href="{{ route('admin.announcements.index') }}" class="btn btn-light me-2">
                                                Batal
                                            </a>
                                            <button type="submit" class="btn bg-gradient-primary">
                                                Simpan Pengumuman
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('custom_js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle Material Kit Input Group Outline behavior
        const inputs = document.querySelectorAll('.input-group-outline input, .input-group-outline textarea');
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
</x-layouts.admin-layout>
