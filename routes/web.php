<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramKerjaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KeuanganController;




// dashboard pages
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect('/signin');
});



Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// program kerja pages
Route::resource('program-kerja', ProgramKerjaController::class);
Route::get('program-kerja/{id}/export-pdf', [ProgramKerjaController::class, 'exportPdf'])->name('program-kerja.export-pdf');

// CRUD Task dalam scope Program Kerja
Route::post('/program-kerja/{id}/task', [ProgramKerjaController::class, 'storeTask'])->name('task.store');
Route::put('/task/{id}', [ProgramKerjaController::class, 'updateTask'])->name('task.update');
Route::delete('/task/{id}', [ProgramKerjaController::class, 'destroyTask'])->name('task.destroy');


// calender pages
Route::get('/calendar', function () {
    return view('pages.calender', ['title' => 'Calendar']);
})->name('calendar');

// profile pages
Route::get('/profile', function () {
    return view('pages.profile', ['title' => 'Profile']);
})->name('profile');

// form pages
Route::get('/form-elements', function () {
    return view('pages.form.form-elements', ['title' => 'Form Elements']);
})->name('form-elements');

// tables pages
Route::get('/basic-tables', function () {
    return view('pages.tables.basic-tables', ['title' => 'Basic Tables']);
})->name('basic-tables');

// pages

Route::get('/blank', function () {
    return view('pages.blank', ['title' => 'Blank']);
})->name('blank');

// error pages
Route::get('/error-404', function () {
    return view('pages.errors.error-404', ['title' => 'Error 404']);
})->name('error-404');

// chart pages
Route::get('/line-chart', function () {
    return view('pages.chart.line-chart', ['title' => 'Line Chart']);
})->name('line-chart');

Route::get('/bar-chart', function () {
    return view('pages.chart.bar-chart', ['title' => 'Bar Chart']);
})->name('bar-chart');

// statis menu - Laporan Keuangan
Route::middleware('auth')->group(function () {
    Route::get('/laporan-keuangan', [KeuanganController::class, 'index'])->name('laporan-keuangan.index');
});


// statis menu - Manajemen Divisi
Route::get('/manajemen-divisi', function () {
    return view('pages.manajemen-divisi', ['title' => 'Manajemen Divisi']);
})->name('manajemen-divisi');





// authentication pages

Route::middleware('guest')->group(function () {
    Route::get('/signin', [AuthController::class, 'showLogin'])->name('signin');
    Route::get('/signup', [AuthController::class, 'showRegister'])->name('signup');

    Route::post('/signup', [AuthController::class, 'register'])->name('signup.post');
    Route::post('/signin', [AuthController::class, 'login'])->name('signin.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// dashboard (auth-only)
Route::middleware('auth')->group(function () {
    // Tambahkan route dashboard/protected di sini.
    // Catatan: route resource 'program-kerja' yang sudah ada di bawah
    // belum diproteksi. Jika ingin, pindahkan ke group ini.
});



// ui elements pages
Route::get('/alerts', function () {
    return view('pages.ui-elements.alerts', ['title' => 'Alerts']);
})->name('alerts');

Route::get('/avatars', function () {
    return view('pages.ui-elements.avatars', ['title' => 'Avatars']);
})->name('avatars');

Route::get('/badge', function () {
    return view('pages.ui-elements.badges', ['title' => 'Badges']);
})->name('badges');

Route::get('/buttons', function () {
    return view('pages.ui-elements.buttons', ['title' => 'Buttons']);
})->name('buttons');

Route::get('/image', function () {
    return view('pages.ui-elements.images', ['title' => 'Images']);
})->name('images');

Route::get('/videos', function () {
    return view('pages.ui-elements.videos', ['title' => 'Videos']);
})->name('videos');






















