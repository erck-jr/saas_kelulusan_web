<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0B0F19;
        }
        .font-display {
            font-family: 'Outfit', sans-serif;
        }
        .glass-panel {
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }
    </style>
</head>
<body class="h-full text-slate-100 flex items-center justify-center relative overflow-hidden">
    <!-- Glow backgrounds -->
    <div class="absolute top-[-20%] left-[-10%] w-[60vw] h-[60vw] rounded-full bg-indigo-950/20 blur-[140px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50vw] h-[50vw] rounded-full bg-purple-950/20 blur-[140px] pointer-events-none -z-10"></div>

    <div class="max-w-md w-full mx-4 p-8 rounded-2xl glass-panel text-center relative z-10">
        <div class="w-16 h-16 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 border border-red-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0-8v6m0-5h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-4xl font-extrabold font-display tracking-tight text-white mb-2">403</h1>
        <p class="text-lg font-semibold text-slate-200 mb-4">Akses Tidak Diizinkan</p>
        <p class="text-slate-400 text-sm mb-6">{{ $message }}</p>
        <a href="{{ $redirectUrl }}" class="inline-flex justify-center items-center px-5 py-3 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 transition-all shadow-lg hover:shadow-indigo-500/25">
            Kembali ke Dashboard Saya
        </a>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Akses Ditolak!',
                html: '{!! addslashes($message) !!}',
                icon: 'error',
                background: '#0B0F19',
                color: '#f1f5f9',
                confirmButtonColor: '#4f46e5',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: {
                    popup: 'border border-slate-800 rounded-2xl shadow-2xl glass-panel',
                    title: 'text-2xl font-bold font-display text-white',
                    htmlContainer: 'text-slate-400 text-sm mt-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ $redirectUrl }}";
                }
            });
        });
    </script>
</body>
</html>
