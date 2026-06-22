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

        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Biodata Pendaftar</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500 mb-1">Nama Lengkap</p>
                    <p class="font-bold text-gray-900">{{ $registration->student->nama_lengkap }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">NIK / NISN</p>
                    <p class="font-bold text-gray-900">{{ $registration->student->nik }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Asal Sekolah</p>
                    <p class="font-bold text-gray-900">{{ $registration->student->sekolah_asal }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Nilai Rata-Rata</p>
                    <p class="font-bold text-gray-900">{{ $registration->student->nilai_rata_rata }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Jalur Pilihan</p>
                    <p class="font-bold text-gray-900">{{ $registration->jalur->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Status Saat Ini</p>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full font-bold text-xs uppercase">
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
                            <td class="p-3 font-medium text-gray-800">{{ $doc->nama_dokumen }}</td>
                            <td class="p-3 text-center">
                                <a href="{{ $doc->file_path }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-sm font-semibold">
                                    Lihat File
                                </a>
                            </td>
                            <td class="p-3 text-center">
                                @if($doc->status === 'disetujui')
                                    <span class="text-green-600 font-bold text-sm">&#10004; Valid</span>
                                @elseif($doc->status === 'ditolak')
                                    <span class="text-red-600 font-bold text-sm">&#10006; Ditolak</span>
                                @else
                                    <span class="text-yellow-600 font-bold text-sm">Menunggu</span>
                                @endif
                            </td>
                            <td class="p-3 flex justify-center gap-2">
                                <form action="{{ route('panitia.dokumen.verify', $doc->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="disetujui">
                                    <button type="submit" class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded shadow transition">Setujui</button>
                                </form>
                                <form action="{{ route('panitia.dokumen.verify', $doc->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-bold rounded shadow transition">Tolak</button>
                                </form>
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