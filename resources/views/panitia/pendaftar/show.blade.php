<x-panel-layout>
    <x-slot name="title">Detail & Verifikasi Berkas</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        
        <div class="flex items-center justify-between">
            <a href="{{ route('panitia.pendaftar.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-2">
                &larr; Kembali ke Daftar Pendaftar
            </a>
            <span class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-bold text-sm border border-gray-200 uppercase tracking-wide">
                {{ $registration->nomor_pendaftaran }}
            </span>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm">
    <h3 class="text-lg font-bold text-gray-800 border-b pb-4 mb-8">Biodata Pendaftar Lengkap</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-8 text-sm">
        
        <div class="flex flex-col justify-start mb-4">
            <p class="text-gray-400  text-[11px] font-bold uppercase tracking-widest">No. Pendaftaran</p>
            <p class="font-bold text-gray-900 text-base tracking-wide">{{ $registration->nomor_pendaftaran ?? '-' }}</p>
        </div>
        
        <div class="flex flex-col justify-start mb-4">
            <p class="text-gray-400 text-[11px] font-bold uppercase tracking-widest">Nama Lengkap</p>
            <p class="font-bold text-gray-900 text-base">{{ $registration->student->nama_lengkap ?? '-' }}</p>
        </div>

        <div class="flex flex-col justify-start mb-4">
            <p class="text-gray-400 text-[11px] font-bold uppercase tracking-widest">Jenis Kelamin</p>
            <p class="font-bold text-gray-900 text-base">
                {{ ($registration->student->jenis_kelamin ?? '-') === 'L' ? 'Laki-laki' : (($registration->student->jenis_kelamin ?? '-') === 'P' ? 'Perempuan' : $registration->student->jenis_kelamin ?? '-') }}
            </p>
        </div>
        
        <div class="flex flex-col justify-start mb-4">
            <p class="text-gray-400 text-[11px] font-bold uppercase tracking-widest">NIK (Nomor Induk Kependudukan)</p>
            <p class="font-bold text-gray-900 text-base tracking-wider">{{ $registration->student->nik ?? '-' }}</p>
        </div>

        <div class="flex flex-col justify-start mb-4">
            <p class="text-gray-400 text-[11px] font-bold uppercase tracking-widest">Tempat, Tanggal Lahir</p>
            <p class="font-bold text-gray-900 text-base">
                {{ $registration->student->tempat_lahir ?? '-' }}, 
                {{ isset($registration->student->tanggal_lahir) ? \Carbon\Carbon::parse($registration->student->tanggal_lahir)->format('d F Y') : '-' }}
            </p>
        </div>
        
        <div class="flex flex-col justify-start mb-4">
            <p class="text-gray-400 text-[11px] font-bold uppercase tracking-widest">Agama</p>
            <p class="font-bold text-gray-900 text-base">{{ $registration->student->agama ?? '-' }}</p>
        </div>

        <div class="flex flex-col justify-start mb-4">
            <p class="text-gray-400 text-[11px] font-bold uppercase tracking-widest">No. HP / WhatsApp</p>
            <p class="font-bold text-blue-600 font-mono text-base tracking-wide">{{ $registration->student->no_hp ?? '-' }}</p>
        </div>
        
        <div class="flex flex-col justify-start mb-4">
            <p class="text-gray-400 text-[11px] font-bold uppercase tracking-widest">Asal Sekolah</p>
            <p class="font-bold text-gray-900 text-base uppercase">{{ $registration->student->sekolah_asal ?? '-' }}</p>
        </div>

        <div class="flex flex-col justify-start mb-4">
            <p class="text-gray-400 text-[11px] font-bold uppercase tracking-widest">Jalur Pilihan</p>
            <p class="font-extrabold text-blue-700 text-base">{{ $registration->jalur->nama ?? '-' }}</p>
        </div>
        
        <div class="flex flex-col justify-start mb-4">
            <p class="text-gray-400 text-[11px] font-bold uppercase tracking-widest">Nilai Rata-Rata Rapor</p>
            <p class="font-bold text-gray-900 text-base">{{ $registration->student->nilai_rata_rata ?? '-' }}</p>
        </div>

        <div class="md:col-span-2 bg-gray-50 px-5 py-5 rounded-xl border border-gray-100 mt-4">
            <p class="text-gray-400 mb-2.5 text-[11px] font-bold uppercase tracking-widest">Alamat Lengkap Sesuai KK</p>
            <p class="font-bold text-gray-800 text-sm leading-relaxed tracking-wide uppercase">
                {{ $registration->student->alamat ?? '-' }}
            </p>
        </div>

        <div class="md:col-span-2 flex items-center justify-between border-t border-gray-100 pt-6 mt-4">
            <p class="text-gray-600 font-bold text-sm tracking-wide">Status Pendaftaran Saat Ini:</p>
            <span class="px-5 py-2.5 bg-yellow-50 text-yellow-800 rounded-lg font-black text-sm uppercase tracking-widest border border-yellow-200 shadow-sm">
                {{ str_replace('_', ' ', $registration->status) }}
            </span>
        </div>

    </div>
</div>

        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Pemeriksaan Dokumen Syarat</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-y border-gray-200 text-sm text-gray-600">
                            <th class="p-3 font-semibold">Nama Dokumen</th>
                            <th class="p-3 font-semibold text-center">Tinjau Berkas</th>
                            <th class="p-3 font-semibold text-center">Status</th>
                            <th class="p-3 font-semibold text-center">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registration->documents ?? [] as $doc)
                        <tr class="border-b border-gray-100">
                            <td class="p-3 font-medium text-gray-800">{{ $doc->jenis_dokumen }}</td>
                            <td class="p-3 text-center">
                                <a href="{{ $doc->cloudinary_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm font-semibold">
                                    Lihat File
                                </a>
                            </td>
                            <td class="p-3 text-center">
                                @if($doc->status_verifikasi === 'disetujui')
                                    <span class="text-green-600 font-bold text-sm">&#10004; Valid</span>
                                @elseif($doc->status_verifikasi === 'ditolak')
                                    <span class="text-red-600 font-bold text-sm">&#10006; Ditolak</span>
                                @else
                                    <span class="text-yellow-600 font-bold text-sm">Menunggu</span>
                                @endif
                            </td>
                            <td class="p-3 flex justify-center gap-2">
                            <form action="{{ route('panitia.dokumen.verify', $doc->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status_verifikasi" value="disetujui">
                                <button type="submit" class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded shadow transition">Setujui</button>
                            </form>

                            <button type="button" 
                                    onclick="document.getElementById('modalTolak-{{ $doc->id }}').showModal()" 
                                    class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-bold rounded shadow transition">
                                Tolak
                            </button>

                            <dialog id="modalTolak-{{ $doc->id }}" class="p-6 rounded-xl shadow-xl border border-gray-200 w-96 backdrop:bg-gray-800 backdrop:bg-opacity-50">
                                <form action="{{ route('panitia.dokumen.verify', $doc->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_verifikasi" value="ditolak">
                                    
                                    <h3 class="font-bold text-gray-800 mb-4">Catatan Penolakan</h3>
                                    <p class="text-xs text-gray-500 mb-2">Mengapa berkas ini ditolak?</p>
                                    
                                    <textarea name="catatan" rows="4" required 
                                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm p-2 mb-4"
                                        placeholder="Contoh: Dokumen kurang jelas..."></textarea>
                                    
                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="document.getElementById('modalTolak-{{ $doc->id }}').close()" 
                                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300">Batal</button>
                                        <button type="submit" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700">Kirim Penolakan</button>
                                    </div>
                                </form>
                            </dialog>
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500 italic">Siswa belum mengunggah dokumen apapun.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-panel-layout>