<?php
namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Exports\PendaftarExport;
use Maatwebsite\Excel\Facades\Excel;

class VerificationController extends Controller
{
    // Menampilkan tabel daftar pendaftar
    public function index(Request $request)
    {
        $query = Registration::with(['student', 'jalur']);

        // Pencarian Berdasarkan Nama atau Nomor
        if ($request->has('search')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('nama_lengkap', 'ilike', '%' . $request->search . '%')
                  ->orWhere('nomor_pendaftaran', 'ilike', '%' . $request->search . '%');
            });
        }

        $registrations = $query->latest()->paginate(10);
        return view('panitia.pendaftar.index', compact('registrations'));
    }

    // Menampilkan halaman detail pendaftar dan preview dokumen
    public function show(Registration $registration)
    {
        $registration->load('documents', 'student', 'jalur');
        return view('panitia.pendaftar.show', compact('registration'));
    }

    // eksekus Setuju/Tolak dokumen
    public function verifyDocument(Request $request, Document $document)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|required_if:status_verifikasi,ditolak|string'
        ]);

        // 1. Perbarui status dokumen
        $document->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan' => $request->status_verifikasi === 'ditolak' ? $request->catatan : null
        ]);

        // 2. Analisis status keseluruhan pendaftaran
        $registration = $document->registration;
        $totalDokumen = $registration->documents()->count();
        $dokumenDisetujui = $registration->documents()->where('status_verifikasi', 'disetujui')->count();
        $dokumenDitolak = $registration->documents()->where('status_verifikasi', 'ditolak')->count();

        // Otomatisasi perubahan status
        if ($dokumenDitolak > 0) {
            // Biarkan status menunggu jika ada yang ditolak (agar siswa bisa perbaiki nanti)
        } elseif ($totalDokumen === $dokumenDisetujui && $totalDokumen > 0) {
            $registration->update(['status' => 'terverifikasi']);
        }

        return redirect()->back()->with('success', 'Status verifikasi dokumen berhasil disimpan.');
    }

    public function exportExcel()
    {
        $fileName = 'rekap_pendaftar_ppdb_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new PendaftarExport, $fileName);
    }
}