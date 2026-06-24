<x-panel-layout>
    <x-slot name="title">Dashboard</x-slot>

    @php
        $student = Auth::user()->student;
        // Eager load relasi jalur dan documents agar pemanggilan data lebih efisien
        $registration = $student ? \App\Models\Registration::with(['jalur', 'documents'])->where('student_id', $student->id)->latest()->first() : null;
        
        // Komputasi status dokumen secara dinamis
        if ($registration) {
            $documents = $registration->documents;
            $totalDoc = $documents->count();
            $menungguDoc = $documents->where('status_verifikasi', 'menunggu')->count();
            $disetujuiDoc = $documents->where('status_verifikasi', 'disetujui')->count();
            $ditolakDoc = $documents->where('status_verifikasi', 'ditolak')->count();
        }
    @endphp

    <div class="max-w-5xl mx-auto space-y-6">
        
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h3 class="text-xl font-bold text-gray-800 mb-1">Halo, {{ Auth::user()->name }} </h3>
            <p class="text-gray-500 text-sm">Selamat datang di Dashboard PPDB Online.</p>
        </div>

        @if($registration)
            
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Nomor Pendaftaran</p>
                    <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ $registration->nomor_pendaftaran }}</h2>
                    
                    <div class="flex gap-8 mt-4">
                        <div>
                            <p class="text-xs text-gray-500">Jalur Pendaftaran</p>
                            <p class="font-semibold text-gray-800 text-sm">{{ $registration->jalur->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Nilai Rata-rata</p>
                            <p class="font-semibold text-gray-800 text-sm">{{ $student->nilai_rata_rata }}</p>
                        </div>
                    </div>
                </div>

                <div class="text-right flex flex-col items-end gap-3">
                    @if($registration->status === 'menunggu_verifikasi')
                        <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg font-bold text-sm border border-yellow-200 shadow-sm uppercase">Menunggu Verifikasi</span>
                    @elseif($registration->status === 'terverifikasi')
                        <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg font-bold text-sm border border-blue-200 shadow-sm uppercase">Terverifikasi</span>
                    @else
                        <span class="px-4 py-2 bg-gray-100 text-gray-800 rounded-lg font-bold text-sm border border-gray-200 shadow-sm uppercase">{{ str_replace('_', ' ', $registration->status) }}</span>
                    @endif
                    
                    <a href="{{ route('student.cetak_bukti') }}" class="text-xs text-red-600 hover:text-red-800 font-semibold underline underline-offset-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Unduh Bukti PDF
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <h4 class="font-bold text-gray-800 mb-4">Statistik Verifikasi Dokumen</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalDoc }}</h3>
                        <p class="text-xs text-gray-500 mt-1">Total Diunggah</p>
                    </div>
                    <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-100">
                        <h3 class="text-2xl font-bold text-yellow-700">{{ $menungguDoc }}</h3>
                        <p class="text-xs text-yellow-600 mt-1">Menunggu</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-lg border border-green-100">
                        <h3 class="text-2xl font-bold text-green-700">{{ $disetujuiDoc }}</h3>
                        <p class="text-xs text-green-600 mt-1">Disetujui</p>
                    </div>
                    <div class="p-4 bg-red-50 rounded-lg border border-red-100">
                        <h3 class="text-2xl font-bold text-red-700">{{ $ditolakDoc }}</h3>
                        <p class="text-xs text-red-600 mt-1">Ditolak</p>
                    </div>
                </div>
            </div>

            @if($ditolakDoc > 0)
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <h3 class="text-sm font-bold text-red-800">Tindakan Diperlukan: Ada Dokumen yang Ditolak</h3>
                        <p class="text-sm text-red-700 mt-1">Terdapat <strong>{{ $ditolakDoc }}</strong> dokumen yang ditolak oleh panitia. Silakan periksa status di bawah dan lakukan unggah ulang sesegera mungkin agar pendaftaran dapat diproses.</p>
                        </div>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                    <h4 class="font-bold text-gray-800 mb-4 border-b pb-2">Status Berkas Tersimpan</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                                    <th class="p-3 font-medium text-center">Jenis Dokumen</th>
                                    <th class="p-3 font-medium text-center">File Validasi</th>
                                    <th class="p-3 font-medium text-center">Status</th>
                                    <th class="p-3 font-medium text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-700">
                                @forelse($documents as $doc)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="p-3 font-semibold text-gray-800 uppercase text-center">{{ $doc->jenis_dokumen }}</td>
                                    <td class="p-3 text-center">
                                        <a href="{{ $doc->cloudinary_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-semibold underline text-xs">
                                            Lihat File
                                        </a>
                                    </td>
                               
                                    <td class="p-3 text-center align-top min-w-[140px] max-w-[160px]">
                                        @if($doc->status_verifikasi === 'disetujui' || $doc->status_verifikasi === 'valid')
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold uppercase whitespace-nowrap">
                                                 Disetujui
                                            </span>
                                        @elseif($doc->status_verifikasi === 'ditolak')
                                            <div class="flex flex-col items-center gap-1 text-center">
                                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold uppercase whitespace-nowrap">
                                                     Ditolak
                                                </span>
                                                @if($doc->catatan)
                                                    <p class="text-[10px] text-red-600 mt-1 leading-tight whitespace-normal break-words">
                                                        Catatan: {{ $doc->catatan }}
                                                    </p>
                                                @endif
                                            </div>
                                        @elseif($doc->status_verifikasi === 'menunggu')
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold uppercase whitespace-nowrap">
                                                Menunggu
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-3 text-center align-top">
                                    @if($doc->status_verifikasi === 'ditolak')
                                        <form action="{{ route('student.dokumen.reupload', $doc->id) }}" 
                                        method="POST" enctype="multipart/form-data" 
                                            class="flex flex-col  gap-2">
                                            @csrf
                                            @method('PATCH')
                                            
                                            <input type="file" name="file_dokumen" required accept=".pdf,.jpg,.jpeg,.png" 
                                                class="block text-[10px] text-gray-500 max-w-[180px]
                                                        file:mr-2 file:py-0.5 file:px-2 file:rounded file:border-0 
                                                        file:text-[10px] file:font-semibold file:bg-blue-50 
                                                        file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">

                                            <button type="submit" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold rounded shadow transition whitespace-nowrap">
                                                Upload Ulang
                                            </button>
                                        </form>
                                    @elseif($doc->status_verifikasi === 'disetujui')
                                        <span class="text-xs text-green-600 font-semibold italic flex items-center justify-center gap-1">
                                            &#10003; Dokumen Aman
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 italic">
                                            Tidak Ada Aksi
                                        </span>
                                    @endif
                                </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-500 italic">Data dokumen tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                    <h4 class="font-bold text-gray-800 mb-4 border-b pb-2">Biodata Terkirim</h4>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-xs text-gray-500">Nama Lengkap</p>
                            <p class="font-semibold text-gray-900">{{ $student->nama_lengkap }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">NIK</p>
                            <p class="font-semibold text-gray-900">{{ $student->nik }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Tempat, Tanggal Lahir</p>
                            <p class="font-semibold text-gray-900">{{ $student->tempat_lahir }}, {{ \Carbon\Carbon::parse($student->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Jenis Kelamin / Agama</p>
                            <p class="font-semibold text-gray-900">{{ $student->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }} / {{ $student->agama }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Asal Sekolah</p>
                            <p class="font-semibold text-gray-900">{{ $student->sekolah_asal }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Nama Orang Tua</p>
                            <p class="font-semibold text-gray-900">Ayah: {{ $student->nama_ayah }}<br>Ibu: {{ $student->nama_ibu }}</p>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="bg-red-50 rounded-xl border border-red-200 p-6 shadow-sm flex flex-col items-center justify-center py-12 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Anda Belum Mendaftar</h3>
                <p class="text-gray-500 text-sm mb-6 max-w-md">Silakan isi formulir biodata dan lengkapi dokumen Anda untuk mendapatkan nomor pendaftaran resmi.</p>
                <a href="{{ route('student.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">
                    Isi Formulir Sekarang
                </a>
            </div>
        @endif

    </div>
</x-panel-layout>