@section('title','Login')

<x-guest-layout>
    <div class="row">
        <div class="col-lg-4 col-md-8 col-12 mt-2 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-1 pe-1">
                        <h4 class="text-white font-weight-bolder text-center mt-2 mb-0 p-0">Login</h4>
                        <p class="text-white p-0 text-center">Masuk ke Panel Admin</p>
                    </div>
                </div>
                <div class="card-body p-2">
                    <!-- Session Status -->
                    <form role="form" class="text-start" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <div class="text-danger text-xs">{{ $message }}</div>
                        @enderror

                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        @error('password')
                            <div class="text-danger text-xs">{{ $message }}</div>
                        @enderror

                        <div class="form-check form-switch d-flex align-items-center mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                            <label class="form-check-label mb-0 ms-3" for="rememberMe">Ingat Saya</label>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Masuk</button>
                        </div>
                        @if (Route::has('password.request'))
                            <p class="mt-4 text-sm text-center">
                                <a href="{{ route('password.request') }}" class="text-primary text-gradient font-weight-bold">
                                    Lupa Password?
                                </a>
                            </p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
