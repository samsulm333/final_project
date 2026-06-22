<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JalurPendaftaran;
use App\Models\Student;
use App\Models\Registration;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Cloudinary\Cloudinary;
use Barryvdh\DomPDF\Facade\Pdf;



class RegistrationController extends Controller
{
    public function create()
    {
        // Pengecekan Lapisan 1: Blokir jika sudah mendaftar
        $student = Auth::user()->student;
        if ($student && \App\Models\Registration::where('student_id', $student->id)->exists()) {
            return redirect()->route('student.dashboard')->with('error', 'Anda sudah menyelesaikan pendaftaran. Sistem menolak pendaftaran ganda.');
        }

        $jalur = \App\Models\JalurPendaftaran::all();
        return view('student.register', compact('jalur'));
    }

    public function store(Request $request)
    {
        // Pengecekan Lapisan 2: Blokir eksekusi paksa (Bypass Prevention)
        $student = Auth::user()->student;
        if ($student && \App\Models\Registration::where('student_id', $student->id)->exists()) {
            return redirect()->route('student.dashboard')->with('error', 'Akses ilegal terdeteksi: Pendaftaran ganda diblokir oleh sistem keamanan.');
        }
      
        // 1. Validasi Input Ketat
        $request->validate([
            'nik' => 'required|numeric|digits:16|unique:students,nik',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'pekerjaan_ortu' => 'required|string',
            'sekolah_asal' => 'required|string',
            'nilai_rata_rata' => 'required|numeric|min:0|max:100',
            'jalur_id' => 'required|exists:jalur_pendaftarans,id',
            
            // Validasi File Sesuai Rubrik
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'kk' => 'required|mimes:pdf,jpg,png|max:5120',
            'ijazah' => 'required|mimes:pdf,jpg,png|max:5120',
            'rapor' => 'required|mimes:pdf,jpg,png|max:5120',
            'piagam' => 'nullable|mimes:pdf,jpg,png|max:5120', // Opsional, khusus jalur prestasi
        ]);

        // Gunakan DB Transaction agar jika upload gagal, data database tidak tersimpan (rollback)
        DB::beginTransaction();

        try {
            // 2. Simpan Data Siswa
            $student = Student::create([
                'user_id' => Auth::id(),
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'pekerjaan_ortu' => $request->pekerjaan_ortu,
                'sekolah_asal' => $request->sekolah_asal,
                'nilai_rata_rata' => $request->nilai_rata_rata,
            ]);

            // 3. Generate Nomor Pendaftaran Otomatis (Format: PPDB-TAHUN-ID)
            $nomor_pendaftaran = 'PPDB-' . date('Y') . '-' . str_pad($student->id, 4, '0', STR_PAD_LEFT);

            // 4. Buat Rekam Registrasi
            $registration = Registration::create([
                'student_id' => $student->id,
                'jalur_id' => $request->jalur_id,
                'nomor_pendaftaran' => $nomor_pendaftaran,
                'status' => 'menunggu_verifikasi',
            ]);

            // 5. Array Dokumen untuk di-Upload
            $dokumen_wajib = ['foto', 'kk', 'ijazah', 'rapor'];
            if ($request->hasFile('piagam')) {
                $dokumen_wajib[] = 'piagam';
            }

            // Eksekusi Upload ke Cloudinary dan Simpan Relasi Dokumen
            // Inisialisasi Cloudinary SDK Resmi
            $cld = new Cloudinary([
                'cloud' => [
                    'cloud_name' => 'dho5z7yoe', // Sesuai URL Anda
                    'api_key'    => '784976385429723', 
                    'api_secret' => '4njy5KNDt10GAPx0RymVXfJriUw'
                ]
            ]);

            // Eksekusi Upload
           // Eksekusi Upload ke Cloudinary dan Simpan Relasi Dokumen
            foreach ($dokumen_wajib as $jenis) {
                if ($request->hasFile($jenis)) {
                    $file = $request->file($jenis);
                    
                    // 1. Inisialisasi Manual Bypass SDK
                    $cloudinary = new Cloudinary([
                        'cloud' => [
                            'cloud_name' => 'dho5z7yoe',
                            'api_key'    => '784976385429723',
                            'api_secret' => '4njy5KNDt10GAPx0RymVXfJriUw',
                        ],
                    ]);

                    // 2. Upload File Langsung
                    $uploadResult = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                        'folder' => 'ppdb_dokumen/' . $nomor_pendaftaran
                    ]);

                    // 3. Simpan ke Database
                    \App\Models\Document::create([
                        'registration_id' => $registration->id,
                        'jenis_dokumen' => $jenis,
                        'cloudinary_url' => $uploadResult['secure_url'],
                        'cloudinary_public_id' => $uploadResult['public_id'],
                        'status_verifikasi' => 'menunggu',
                    ]);
                }
            }


            DB::commit();
            return redirect()->route('student.dashboard')->with('success', 'Pendaftaran berhasil disubmit dan dokumen telah diunggah.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memproses pendaftaran: ' . $e->getMessage());
        }
    }

    // public function store(Request $request)
    // {
    //     // 1. Validasi Data Diri & Akademik (Sesuaikan dengan aturan Anda)
    //     $request->validate([
    //         'nik' => 'required|numeric',
    //         'sekolah_asal' => 'required|string',
    //         'nilai_rata_rata' => 'required|numeric|min:0|max:100',
    //         'jalur_id' => 'required|exists:jalur_pendaftarans,id',
    //         'dokumen_foto' => 'required|file|mimes:jpg,jpeg,png|max:2048',
    //         'dokumen_kk' => 'required|file|mimes:pdf,jpg,jpeg|max:5120',
    //         'dokumen_ijazah' => 'required|file|mimes:pdf,jpg,jpeg|max:5120',
    //         'dokumen_rapor' => 'required|file|mimes:pdf,jpg,jpeg|max:5120',
    //         'dokumen_prestasi' => 'nullable|file|mimes:pdf,jpg,jpeg|max:5120',
    //     ]);

    //     \Illuminate\Support\Facades\DB::beginTransaction();

    //     try {
    //         // 2. Pembaruan Data Profil Student (Siswa)
    //         $student = \App\Models\Student::where('user_id', auth()->id())->first();
    //         $student->update([
    //             'nik' => $request->nik,
    //             'sekolah_asal' => $request->sekolah_asal,
    //             'nilai_rata_rata' => $request->nilai_rata_rata,
    //             // Tambahkan kolom lain seperti nama_ayah, jenis_kelamin, dll di sini
    //         ]);

    //         // 3. Penciptaan Baris Registrasi (Pendaftaran)
    //         $registration = \App\Models\Registration::create([
    //             'student_id' => $student->id,
    //             'jalur_id' => $request->jalur_id,
    //             'nomor_pendaftaran' => 'PPDB-' . date('Y') . '-' . str_pad($student->id, 4, '0', STR_PAD_LEFT),
    //             'status' => 'menunggu_verifikasi',
    //         ]);

    //         // 4. ALGORITMA PENYISIPAN DOKUMEN (Solusi dari Error Anda)
    //         // Kita petakan nama input HTML dengan nama resmi dokumennya
    //         $berkasDaftar = [
    //             'dokumen_foto' => 'Pas Foto 3x4',
    //             'dokumen_kk' => 'Kartu Keluarga',
    //             'dokumen_ijazah' => 'Ijazah / SKL',
    //             'dokumen_rapor' => 'Rapor Semester Terakhir',
    //             'dokumen_prestasi' => 'Piagam Prestasi',
    //         ];

    //         foreach ($berkasDaftar as $inputName => $namaResmi) {
    //             if ($request->hasFile($inputName)) {
    //                 $file = $request->file($inputName);
                    
    //                 // Asumsi integrasi Cloudinary (Sesuaikan sintaks jika Anda menggunakan package berbeda)
    //                 $uploadedFileUrl = cloudinary()->upload($file->getRealPath())->getSecurePath();

    //                 // Insert data sebagai BARIS BARU untuk setiap file
    //                 \App\Models\Document::create([
    //                     'registration_id' => $registration->id,
    //                     'nama_dokumen' => $namaResmi,
    //                     'file_path' => $uploadedFileUrl,
    //                     'status' => 'menunggu_verifikasi'
    //                 ]);
    //             }
    //         }

    //         \Illuminate\Support\Facades\DB::commit();

    //         // 5. Lempar kembali ke Dasbor dengan Notifikasi Global yang sudah kita buat
    //         return redirect()->route('student.dashboard')->with('success', 'Pendaftaran berhasil dikirim dan dokumen telah diunggah ke Cloudinary.');

    //     } catch (\Exception $e) {
    //         \Illuminate\Support\Facades\DB::rollBack();
    //         // Lempar error jika Cloudinary atau Database gagal
    //         return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
    //     }
    // }

    public function cetakBukti()
    {
        // Tarik data pendaftaran milik siswa yang sedang login
        $registration = Registration::where('student_id', Auth::user()->student->id)
                                    ->with(['student', 'jalur'])
                                    ->firstOrFail();

        // Render view HTML menjadi PDF (kertas A4, orientasi Portrait)
        $pdf = Pdf::loadView('student.pdf-bukti', compact('registration'))->setPaper('a4', 'portrait');
        
        // Perintah paksa browser untuk mengunduh file
        return $pdf->download('Bukti_Pendaftaran_' . $registration->nomor_pendaftaran . '.pdf');
    }
}