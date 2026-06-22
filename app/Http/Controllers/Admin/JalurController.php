<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JalurPendaftaran;
use Illuminate\Http\Request;

class JalurController extends Controller
{
    public function index()
    {
        $jalur = JalurPendaftaran::all();
        return view('admin.jalur.index', compact('jalur'));
    }

    public function create()
    {
        return view('admin.jalur.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kuota' => 'required|integer|min:1',
        ]);

        JalurPendaftaran::create($request->all());

        return redirect()->route('admin.jalur.index')->with('success', 'Jalur pendaftaran baru berhasil ditambahkan.');
    }

    public function edit(JalurPendaftaran $jalur)
    {
        return view('admin.jalur.edit', compact('jalur'));
    }

    public function update(Request $request, JalurPendaftaran $jalur)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kuota' => 'required|integer|min:1',
        ]);

        $jalur->update($request->all());

        return redirect()->route('admin.jalur.index')->with('success', 'Data jalur pendaftaran berhasil diperbarui.');
    }

    public function destroy(JalurPendaftaran $jalur)
    {
        // Proteksi: Jangan hapus jika sudah ada siswa yang mendaftar di jalur ini
        if ($jalur->registrations()->count() > 0) {
            return redirect()->route('admin.jalur.index')->with('error', 'Gagal dihapus! Jalur ini sudah memiliki pendaftar.');
        }

        $jalur->delete();
        return redirect()->route('admin.jalur.index')->with('success', 'Jalur pendaftaran berhasil dihapus.');
    }

    public function jalankanSeleksi()
    {
        $semuaJalur = JalurPendaftaran::all();

        foreach ($semuaJalur as $jalur) {
            // 1. Tarik semua siswa TERVERIFIKASI di jalur ini
            $pendaftar = \App\Models\Registration::where('jalur_id', $jalur->id)
                ->where('status', 'terverifikasi')
                ->with('student')
                ->get()
                // 2. Urutkan berdasarkan nilai rata-rata tertinggi ke terendah
                ->sortByDesc(function ($reg) {
                    return $reg->student->nilai_rata_rata;
                });

            // 3. Potong data berdasarkan Kuota Jalur
            $lulus = $pendaftar->take($jalur->kuota);
            $gagal = $pendaftar->skip($jalur->kuota);

            // 4. Ubah status secara massal
            foreach ($lulus as $reg) {
                $reg->update(['status' => 'diterima']);
            }
            foreach ($gagal as $reg) {
                $reg->update(['status' => 'tidak_diterima']);
            }
        }

        return redirect()->back()->with('success', 'Seleksi otomatis selesai! Status pendaftar telah diperbarui berdasarkan kuota dan nilai rata-rata.');
    }

    public function togglePengumuman(JalurPendaftaran $jalur)
    {
        // Membalikkan status (jika true jadi false, jika false jadi true)
        $jalur->update(['status_pengumuman' => !$jalur->status_pengumuman]);
        
        $statusText = $jalur->status_pengumuman ? 'DIBUKA' : 'DITUTUP';
        return redirect()->back()->with('success', "Pengumuman untuk jalur {$jalur->nama} berhasil {$statusText}.");
    }
}