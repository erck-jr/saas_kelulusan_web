# Sistem Kelulusan Web

Aplikasi web Sistem Kelulusan berbasis Laravel. Aplikasi ini digunakan untuk mengelola data kelulusan siswa, melihat pengumuman kelulusan, dan mendistribusikan nilai siswa secara online.

## Fitur Utama
- **Manajemen Siswa & Nilai**: Input dan kelola data siswa beserta nilainya.
- **Pengumuman Kelulusan**: Pengaturan status lulus/tidak lulus untuk masing-masing siswa.
- **Periode Kelulusan**: Mengatur tahun ajaran atau periode kelulusan.
- **Akses Pengumuman**: Halaman khusus untuk siswa mengecek status kelulusan mereka.
- **Bahasa Indonesia**: Mendukung localization bahasa Indonesia untuk pesan kesalahan dan validasi.

## Persyaratan Sistem Lokal (Development)
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database / Laravel Herd / XAMPP / Laragon

## Cara Instalasi Lokal
1. Pastikan Anda sudah menginstall dependencies PHP dan Node.js:
   ```bash
   composer install
   npm install
   ```
2. Buat database baru di MySQL dengan nama `db_kelulusan`.
3. Sesuaikan file `.env`:
   - `APP_ENV=local`
   - `APP_URL=http://kelulusan.test` (Jika menggunakan Herd)
   - Sesuaikan kredensial `DB_*` dengan server MySQL lokal Anda.
4. Jalankan migrasi dan seeder untuk membuat tabel dan data awal:
   ```bash
   php artisan migrate:fresh --seed
   ```
5. Akses project melalui `http://kelulusan.test` (Herd) atau jalankan server lokal:
   ```bash
   php artisan serve
   ```

## Lisensi
Sistem ini menggunakan framework [Laravel](https://laravel.com) yang bersifat open-source dengan lisensi [MIT license](https://opensource.org/licenses/MIT).
