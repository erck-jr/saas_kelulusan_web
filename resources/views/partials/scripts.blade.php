<!-- jQuery Core -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!--   Core JS Files   -->
<script src="{{ asset('assets/material-kit/assets/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/material-kit/assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/material-kit/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/material-kit/assets/js/plugins/parallax.min.js') }}"></script>
<script src="{{ asset('assets/material-kit/assets/js/material-kit.min.js') }}" type="text/javascript"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success') || session('status'))
        @php
            $msg = session('success') ?? session('status');
            if ($msg == 'verification-link-sent') {
                $msg = 'Link verifikasi baru telah dikirim ke alamat email Anda.';
            }
        @endphp
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{!! addslashes($msg) !!}',
            showConfirmButton: false,
            timer: 3000 // Auto-close after 3 seconds
        });
    @endif
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            html: '{!! addslashes(implode("<br>", $errors->all())) !!}',
            confirmButtonText: 'OK'
        });
    @elseif (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan!',
            html: '{!! addslashes(session("error")) !!}',
            confirmButtonText: 'OK'
        });
    @endif
</script>
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
@yield('custom_js')
