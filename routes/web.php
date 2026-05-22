<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramKerjaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ProfileController;

// 1. Gerbang Depan (Mengarahkan otomatis berdasarkan status login)
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect('/signin');
});

// 2. Gerbang Khusus Tamu (Belum Login) - Diproteksi agar tidak bisa diakses jika sudah login
Route::middleware('guest')->group(function () {
    Route::get('/signin', [AuthController::class, 'showLogin'])->name('signin');
    Route::get('/signup', [AuthController::class, 'showRegister'])->name('signup');
    Route::post('/signup', [AuthController::class, 'register'])->name('signup.post');
    Route::post('/signin', [AuthController::class, 'login'])->name('signin.post');
});

// 3. Tombol Keluar Aplikasi
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 4. GERBANG UTAMA SIPOVINUS (HANYA UNTUK YANG SUDAH LOGIN)
// Seluruh halaman menu utama WAJIB masuk ke dalam group ini agar session HTTPS tidak lepas!
Route::middleware('auth')->group(function () {

    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Program Kerja Pages & Export PDF
    Route::resource('program-kerja', ProgramKerjaController::class);
    Route::get('program-kerja/{id}/export-pdf', [ProgramKerjaController::class, 'exportPdf'])->name('program-kerja.export-pdf');

    // CRUD Task dalam scope Program Kerja
    Route::post('/program-kerja/{id}/task', [ProgramKerjaController::class, 'storeTask'])->name('task.store');
    Route::put('/task/{id}', [ProgramKerjaController::class, 'updateTask'])->name('task.update');
    Route::delete('/task/{id}', [ProgramKerjaController::class, 'destroyTask'])->name('task.destroy');

    // Manajemen Divisi (CRUD Menu)
    Route::get('/manajemen-divisi', [DivisionController::class, 'index'])->name('manajemen-divisi.index');
    Route::get('/manajemen-divisi/create', [DivisionController::class, 'create'])->name('manajemen-divisi.create');
    Route::post('/manajemen-divisi', [DivisionController::class, 'store'])->name('manajemen-divisi.store');
    Route::get('/manajemen-divisi/{id}/edit', [DivisionController::class, 'edit'])->name('manajemen-divisi.edit');
    Route::put('/manajemen-divisi/{id}', [DivisionController::class, 'update'])->name('manajemen-divisi.update');
    Route::delete('/manajemen-divisi/{id}', [DivisionController::class, 'destroy'])->name('manajemen-divisi.destroy');

    // Laporan Keuangan
    Route::get('/laporan-keuangan', [KeuanganController::class, 'index'])->name('laporan-keuangan.index');

    // Profile Pages
    Route::get('/profile', function () {
        return view('pages.profile', ['title' => 'Profile']);
    })->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Calendar
    Route::get('/calendar', function () {
        return view('pages.calender', ['title' => 'Calendar']);
    })->name('calendar');

});

// 5. Template UI Elements & Static Pages (Bisa diakses bebas/untuk testing template)
Route::get('/form-elements', function () { return view('pages.form.form-elements', ['title' => 'Form Elements']); })->name('form-elements');
Route::get('/basic-tables', function () { return view('pages.tables.basic-tables', ['title' => 'Basic Tables']); })->name('basic-tables');
Route::get('/blank', function () { return view('pages.blank', ['title' => 'Blank']); })->name('blank');
Route::get('/error-404', function () { return view('pages.errors.error-404', ['title' => 'Error 404']); })->name('error-404');
Route::get('/line-chart', function () { return view('pages.chart.line-chart', ['title' => 'Line Chart']); })->name('line-chart');
Route::get('/bar-chart', function () { return view('pages.chart.bar-chart', ['title' => 'Bar Chart']); })->name('bar-chart');
Route::get('/alerts', function () { return view('pages.ui-elements.alerts', ['title' => 'Alerts']); })->name('alerts');
Route::get('/avatars', function () { return view('pages.ui-elements.avatars', ['title' => 'Avatars']); })->name('avatars');
Route::get('/badge', function () { return view('pages.ui-elements.badges', ['title' => 'Badges']); })->name('badges');
Route::get('/buttons', function () { return view('pages.ui-elements.buttons', ['title' => 'Buttons']); })->name('badges');
Route::get('/image', function () { return view('pages.ui-elements.images', ['title' => 'Images']); })->name('images');
Route::get('/videos', function () { return view('pages.ui-elements.videos', ['title' => 'Videos']); })->name('videos');
