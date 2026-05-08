@section('title','Reset Password')

<x-guest-layout>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                        <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Reset Password</h4>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-center text-muted mb-4">Masukkan password baru Anda</p>

                    <form role="form" class="text-start" method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $request->email) }}" required autofocus readonly>
                        </div>
                        @error('email')
                            <div class="text-danger text-xs mb-3">{{ $message }}</div>
                        @enderror

                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        @error('password')
                            <div class="text-danger text-xs mb-3">{{ $message }}</div>
                        @enderror

                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        @error('password_confirmation')
                            <div class="text-danger text-xs mb-3">{{ $message }}</div>
                        @enderror

                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">
                                Reset Password
                            </button>
                        </div>

                        <p class="mt-4 text-sm text-center">
                            <a href="{{ route('login') }}" class="text-primary text-gradient font-weight-bold">
                                Kembali ke Login
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>
