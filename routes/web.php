<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\RegistrationController;
use App\Http\Controllers\Panitia\VerificationController;
use App\Http\Controllers\Admin\JalurController;

Route::get('/', function () {
    return view('welcome');
})->name('home');



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

    // Rute Ekspor Laporan CSV
    Route::get('/export-pendaftar', [\App\Http\Controllers\Panitia\VerificationController::class, 'exportCsv'])->name('pendaftar.export');


    Route::get('/pendaftar/{registration}', [VerificationController::class, 'show'])->name('pendaftar.show');

    Route::patch('/dokumen/{document}/verify', [VerificationController::class, 'verifyDocument'])->name('dokumen.verify');

    
});

// Grup Rute Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dasbor Utama Admin
    Route::get('/dashboard', function () {
        // Mengambil statistik global untuk admin
        $totalSiswa = \App\Models\Student::count();
        $totalJalur = \App\Models\JalurPendaftaran::count();
        return view('admin.dashboard', compact('totalSiswa', 'totalJalur'));
    })->name('dashboard');


    // Rute Eksekusi Seleksi Otomatis
    Route::post('/jalankan-seleksi', [\App\Http\Controllers\Admin\JalurController::class, 'jalankanSeleksi'])->name('seleksi.otomatis');

    // Rute Buka/Tutup Pengumuman per Jalur
    Route::patch('/jalur/{jalur}/toggle-pengumuman', [\App\Http\Controllers\Admin\JalurController::class, 'togglePengumuman'])->name('jalur.toggle_pengumuman');

    
    // Manajemen Master Data: Jalur Pendaftaran
    Route::resource('jalur', JalurController::class)->except(['show']);

    

});

// Rute Profil Bawaan Breeze (Bisa diakses oleh semua role yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';