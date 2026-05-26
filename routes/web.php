<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GraduationController;
use App\Http\Controllers\SaaSMainController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\GraduationPeriodController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

$appDomain = parse_url(config('app.url'), PHP_URL_HOST);

// ============================================================
// 1. Landing Page Utama Platform SaaS & Panel Pusat Superadmin
// ============================================================
Route::domain($appDomain)->group(function () {
    Route::get('/', [SaaSMainController::class, 'index'])->name('saas.home');
    Route::post('/register-school', [SaaSMainController::class, 'register'])->name('saas.register');

    // Override default Breeze dashboard redirect
    Route::redirect('/dashboard', '/admin')->name('dashboard');
    
    // Panel khusus Superadmin untuk memantau performa SaaS secara global
    Route::middleware(['auth', 'verified', 'superadmin'])
        ->prefix('saas-master')
        ->name('superadmin.global.')
        ->group(function () {
            Route::get('/', [SaaSMainController::class, 'globalDashboard'])->name('dashboard');
            Route::resource('users', UserController::class);
            Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
            Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        });
});

// ============================================================
// 2. Portal Publik & Dashboard Sekolah (Subdomain Tenant)
// ============================================================
Route::domain('{school_slug}.' . $appDomain)->group(function () {

    // --------------------------------------------------------
    // A. SISI SISWA: Portal Publik Pengecekan Kelulusan
    // --------------------------------------------------------
    Route::middleware('tenant.identify')->group(function () {
        Route::get('/', [GraduationController::class, 'index'])->name('school.home');
        Route::post('/check', [GraduationController::class, 'check'])->name('school.check');
        Route::get('/announcements', [AnnouncementController::class, 'publicIndex'])->name('school.announcements');
        Route::get('/announcements/{announcement}', [AnnouncementController::class, 'publicShow'])->name('school.announcements.show');
    });

    // --------------------------------------------------------
    // B. SISI PANEL ADMIN & SUPERADMIN (Akses Data Sekolah)
    // --------------------------------------------------------
    // Di sini middleware diubah menjadi 'role.admin-or-super' agar Superadmin bisa masuk ke panel sekolah
    Route::middleware(['auth', 'verified', 'tenant.admin']) 
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            
            // Dashboard (Bisa diakses Admin Sekolah & Superadmin)
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

            // Students Management (Bisa diakses Admin Sekolah & Superadmin)
            Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
            Route::get('students/export', [StudentController::class, 'export'])->name('students.export');
            Route::get('students/template', [StudentController::class, 'template'])->name('students.template');
            Route::resource('students', StudentController::class);

            // Classes Management (Bisa diakses Admin Sekolah & Superadmin)
            Route::resource('school-classes', SchoolClassController::class);

            // Announcements Management (Bisa diakses Admin Sekolah & Superadmin)
            Route::post('announcements/{announcement}/publish', [AnnouncementController::class, 'publish'])->name('announcements.publish');
            Route::resource('announcements', AnnouncementController::class);

            // Grades Management (Bisa diakses Admin Sekolah & Superadmin)
            Route::post('grades/import', [GradeController::class, 'import'])->name('grades.import');
            Route::get('grades/export', [GradeController::class, 'export'])->name('grades.export');
            Route::get('grades/template', [GradeController::class, 'template'])->name('grades.template');
            Route::resource('grades', GradeController::class);

            // Graduation Periods (Bisa diakses Admin Sekolah & Superadmin)
            Route::resource('graduation-periods', GraduationPeriodController::class);

            // Settings Dasar Sekolah (Bisa diakses Admin Sekolah & Superadmin)
            Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
            Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

            // --------------------------------------------------------
            // PROTEKSI 1: Hanya Admin Sekolah (Superadmin dilarang generate sertifikat)
            // --------------------------------------------------------
            Route::middleware('deny.superadmin')->group(function () {
                Route::get('settings/certificate-preview', [SettingController::class, 'previewCertificate'])->name('settings.certificate-preview');
                Route::get('regenerate-certificates/{school}', [SettingController::class, 'regenerateCertificates'])->name('regenerate-certificates');
            });

            // --------------------------------------------------------
            // PROTEKSI 2: Hanya Superadmin (Telah dipindah ke /saas-master)
            // --------------------------------------------------------
            // (Rute user sudah dipindah ke domain utama)
        });

    // --------------------------------------------------------
    // C. SISI ADMIN: Profile Routes (Auth)
    // --------------------------------------------------------
    Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

});

// ============================================================
// 3. Fitur Autentikasi Global (Breeze/Jetstream)
// ============================================================
// Diletakkan di luar domain group agar rute /login, /register, dll 
// bisa diakses baik dari domain utama maupun subdomain tenant.
require __DIR__.'/auth.php';