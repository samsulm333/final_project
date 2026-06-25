<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\RegistrationController;
use App\Http\Controllers\Panitia\VerificationController;
use App\Http\Controllers\Admin\JalurController;
use App\Http\Controllers\Admin\PanitiaController;

use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\Admin\AnnouncementController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rute beranda yang menangani form pencarian
Route::get('/', [WelcomeController::class, 'index'])->name('beranda');


// Grup Rute Siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('student.')->group(function () {
    Route::get('/dashboard', function () {
    // Menggunakan Facade Auth agar Intelephense bisa membacanya dengan jelas
    $student = \App\Models\Student::with('registration')
                ->where('user_id', \Illuminate\Support\Facades\Auth::id())
                ->first();
                    
        return view('student.dashboard', compact('student'));
    })->name('dashboard');

    Route::get('/daftar', [\App\Http\Controllers\Student\RegistrationController::class, 'create'])->name('create');

    Route::post('/daftar', [\App\Http\Controllers\Student\RegistrationController::class, 'store'])->name('store');

    // Rute Cetak Bukti PDF
    Route::get('/cetak-bukti', [\App\Http\Controllers\Student\RegistrationController::class, 'cetakBukti'])->name('cetak_bukti');

    Route::patch('/dokumen/{id}/reupload', [RegistrationController::class, 'reupload'])->name('dokumen.reupload');
});


// Grup Rute Panitia
Route::middleware(['auth', 'role:panitia'])->prefix('panitia')->name('panitia.')->group(function () {
    
    // Dasbor Panitia (Memuat UI & Statistik)
    Route::get('/dashboard', function () {
        $stats = [
            'total' => \App\Models\Registration::count(),
            'menunggu' => \App\Models\Registration::where('status', 'menunggu_verifikasi')->count(),
            'terverifikasi' => \App\Models\Registration::where('status', 'terverifikasi')->count(),
        ];
        return view('panitia.dashboard', compact('stats'));
    })->name('dashboard');

    // Manajemen Verifikasi (Tabel & Detail UI)
    Route::get('/pendaftar', [VerificationController::class, 'index'])->name('pendaftar.index');

    // Rute Ekspor Laporan Excel
    Route::get('/export-pendaftar', [\App\Http\Controllers\Panitia\VerificationController::class, 'exportExcel'])->name('pendaftar.export');


    Route::get('/pendaftar/{registration}', [VerificationController::class, 'show'])->name('pendaftar.show');

    Route::patch('/dokumen/{document}/verify', [VerificationController::class, 'verifyDocument'])->name('dokumen.verify');

    
});


// Grup Rute Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // 1. Dasbor Utama Admin (Dipindah ke Controller agar mampu memproses data statistik yang kompleks)
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // 2. Sistem Proses Seleksi Otomatis (Menggunakan fitur Preview sebelum Publish)
    Route::get('/seleksi', [AdminController::class, 'selectionIndex'])->name('seleksi.index');
    Route::post('/seleksi/preview', [AdminController::class, 'runSelectionPreview'])->name('seleksi.preview');
    Route::post('/seleksi/publish', [AdminController::class, 'publishResults'])->name('seleksi.publish');

    // Tambahkan baris ini untuk fitur Buka Kunci
    Route::post('/seleksi/reset', [AdminController::class, 'resetSelection'])->name('seleksi.reset');

    // 3. Ekspor Laporan Siswa Diterima
    Route::get('/laporan/ekspor', [AdminController::class, 'exportExcel'])->name('laporan.export');

    // 4. Manajemen Master Data: Jalur Pendaftaran (Rute Asli Anda Dipertahankan)
    Route::resource('jalur', JalurController::class)->except(['show']);
    Route::patch('/jalur/{jalur}/toggle-pengumuman', [JalurController::class, 'togglePengumuman'])->name('jalur.toggle_pengumuman');

    // 5. Manajemen Akun Panitia
    Route::resource('panitia', PanitiaController::class)->except(['show']);

    // 6. Manajemen Pengumuman Homepage
    Route::resource('pengumuman', AnnouncementController::class)->except(['show']);
});

// Rute Profil Bawaan Breeze (Bisa diakses oleh semua role yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';