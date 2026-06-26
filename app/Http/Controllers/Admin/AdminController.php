<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\JalurPendaftaran;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 1. Menampilkan Halaman Dasbor Admin
    public function dashboard()
    {
        $stat_jalur = JalurPendaftaran::withCount('registrations')->get();
        $total_pendaftar = Registration::count();
        $terverifikasi = Registration::whereIn('status', ['terverifikasi', 'diterima', 'tidak_diterima'])->count();
        $menunggu_verifikasi = Registration::where('status', 'menunggu_verifikasi')->count();
        $diterima = Registration::where('status', 'diterima')->count();
        $tidak_diterima = Registration::where('status', 'tidak_diterima')->count();

       
        $grafik_harian = Registration::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('count(*) as jumlah'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'stat_jalur', 'total_pendaftar', 'terverifikasi', 
            'menunggu_verifikasi', 'diterima', 'tidak_diterima', 'grafik_harian'
        ));
    }

    // 2. Halaman Kendali Seleksi
    public function selectionIndex()
    {
        $jalur = JalurPendaftaran::all();
        $sudah_publish = Registration::whereIn('status', ['diterima', 'tidak_diterima'])->exists();

        return view('admin.selection', compact('jalur', 'sudah_publish'));
    }

    // 3. Algoritma Ranking Otomatis (Preview)
    public function runSelectionPreview()
    {
        $jalurs = JalurPendaftaran::all();
        $preview_data = [];

        foreach ($jalurs as $jalur) {
            // Ambil siswa yang sudah diverifikasi dan urutkan berdasarkan nilai rata-rata tertinggi
            $pendaftar = Registration::where('jalur_id', $jalur->id)
                ->where('status', 'terverifikasi')
                ->join('students', 'registrations.student_id', '=', 'students.id')
                ->orderBy('students.nilai_rata_rata', 'desc')
                ->select('registrations.*', 'students.nama_lengkap', 'students.nilai_rata_rata')
                ->get();

            $preview_data[$jalur->nama] = [
                'kuota' => $jalur->kuota,
                'lulus' => $pendaftar->take($jalur->kuota),
                'tidak_lulus' => $pendaftar->skip($jalur->kuota)
            ];
        }

        // Simpan sementara di session
        session(['preview_seleksi' => $preview_data]);

        return view('admin.selection-preview', compact('preview_data'));
    }

    // 4. Publikasikan Hasil Akhir ke Database
    public function publishResults()
    {
        $preview_data = session('preview_seleksi');

        if (!$preview_data) {
            return redirect()->route('admin.seleksi.index')->with('error', 'Sesi seleksi hilang. Silakan jalankan ulang.');
        }

        DB::beginTransaction();
        try {
            foreach ($preview_data as $nama_jalur => $data) {
                foreach ($data['lulus'] as $reg) {
                    Registration::where('id', $reg->id)->update(['status' => 'diterima']);
                }
                foreach ($data['tidak_lulus'] as $reg) {
                    Registration::where('id', $reg->id)->update(['status' => 'tidak_diterima']);
                }
            }
            DB::commit();
            session()->forget('preview_seleksi');

            return redirect()->route('admin.dashboard')->with('success', 'Hasil seleksi berhasil dipublikasikan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses seleksi: ' . $e->getMessage());
        }
    }

    
    // Membuka kunci / membatalkan hasil seleksi
    public function resetSelection()
    {
        DB::beginTransaction();
        try {
            // Tarik mundur semua siswa yang sudah terlanjur diseleksi
            // Kembalikan statusnya ke 'terverifikasi' (masuk kembali ke radar antrean seleksi)
            \App\Models\Registration::whereIn('status', ['diterima', 'tidak_diterima'])
                        ->update(['status' => 'terverifikasi']);

            DB::commit();

            return redirect()->back()->with('success', 'Kunci seleksi berhasil dibuka! Seluruh status kelulusan telah ditarik ulang, Anda dapat menjalankan mesin seleksi kembali.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuka kunci: ' . $e->getMessage());
        }
    }

    // 5. Ekspor Laporan Excel 
    public function exportExcel()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=Laporan_Siswa_Diterima.csv",
        ];

        $siswa_diterima = Registration::where('status', 'diterima')->with(['student', 'jalur'])->get();

        $callback = function() use ($siswa_diterima) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No. Pendaftaran', 'Nama', 'Jalur', 'Nilai Rata-Rata', 'Status']);

            foreach ($siswa_diterima as $row) {
                fputcsv($file, [
                    $row->nomor_pendaftaran,
                    $row->student->nama_lengkap ?? '-',
                    $row->jalur->nama ?? '-',
                    $row->student->nilai_rata_rata ?? '-',
                    'DITERIMA'
                ]);
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'Laporan_Siswa_Diterima.csv', $headers);
    }
}