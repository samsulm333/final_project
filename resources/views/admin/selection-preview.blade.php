<x-panel-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Pratinjau Hasil Seleksi Otomatis') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-5 rounded-r-xl shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0"><span class="text-yellow-400 text-xl">⚠️</span></div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-800 font-bold uppercase tracking-wider mb-1">Perhatian: Status Belum Tersimpan!</p>
                    <p class="text-xs text-yellow-700 font-medium leading-relaxed">
                        Data di bawah ini adalah hasil simulasi algoritma (Pratinjau). Silakan periksa kebenaran pemotongan kuota. Jika sudah sesuai, gulir ke paling bawah dan tekan tombol "Kunci & Publikasikan" untuk menyimpan kelulusan ke database.
                    </p>
                </div>
            </div>
        </div>

        @forelse($preview_data ?? [] as $nama_jalur => $data)
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-200">
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 pb-5 mb-6 gap-4">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">Kategori Seleksi</span>
                        <h3 class="text-2xl font-black text-gray-900">Jalur {{ $nama_jalur }}</h3>
                    </div>
                    <div class="text-right">
                        <span class="bg-blue-50 border border-blue-200 text-blue-800 text-sm font-black px-4 py-2 rounded-lg shadow-sm block">
                            Batas Kuota: {{ $data['kuota'] }} Kursi
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-green-50/30 rounded-xl p-4 border border-green-100">
                        <h4 class="font-black text-green-700 mb-4 flex justify-between items-center border-b border-green-200 pb-2">
                            <span>Siswa DITERIMA (Masuk Kuota)</span>
                            <span class="bg-green-600 text-white px-2 py-1 rounded text-xs">{{ count($data['lulus']) }} Siswa</span>
                        </h4>
                        
                        <div class="space-y-2 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($data['lulus'] as $index => $siswa)
                                <div class="bg-white border border-green-200 p-3 rounded-lg flex justify-between items-center shadow-sm">
                                    <div>
                                        <span class="font-bold text-gray-900 text-sm">{{ $index + 1 }}. {{ $siswa->nama_lengkap }}</span>
                                        <span class="block text-xs text-gray-500 font-mono mt-0.5">No: {{ $siswa->nomor_pendaftaran }}</span>
                                    </div>
                                    <span class="font-mono text-green-800 font-black bg-green-100 px-2 py-1 rounded text-xs border border-green-200">
                                        Nilai: {{ $siswa->nilai_rata_rata }}
                                    </span>
                                </div>
                            @empty
                                <div class="text-center p-4 text-green-600 text-xs font-bold italic">Belum ada siswa yang memenuhi syarat pada jalur ini.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-red-50/30 rounded-xl p-4 border border-red-100">
                        <h4 class="font-black text-red-700 mb-4 flex justify-between items-center border-b border-red-200 pb-2">
                            <span>TIDAK DITERIMA (Di Luar Kuota)</span>
                            <span class="bg-red-600 text-white px-2 py-1 rounded text-xs">{{ count($data['tidak_lulus']) }} Tergeser</span>
                        </h4>
                        
                        <div class="space-y-2 max-h-96 overflow-y-auto pr-2 custom-scrollbar opacity-80 hover:opacity-100 transition">
                            @forelse($data['tidak_lulus'] as $index => $siswa)
                                <div class="bg-white border border-red-200 p-3 rounded-lg flex justify-between items-center shadow-sm">
                                    <div>
                                        <span class="font-bold text-gray-700 text-sm">{{ $index + count($data['lulus']) + 1 }}. {{ $siswa->nama_lengkap }}</span>
                                    </div>
                                    <span class="font-mono text-red-800 font-black bg-red-100 px-2 py-1 rounded text-xs border border-red-200">
                                        Nilai: {{ $siswa->nilai_rata_rata }}
                                    </span>
                                </div>
                            @empty
                                <div class="text-center p-4 text-red-600 text-xs font-bold italic">Tidak ada siswa yang tereliminasi.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white p-10 rounded-2xl shadow-sm text-center border border-gray-200">
                <p class="text-gray-500 font-bold">Data simulasi tidak ditemukan. Pastikan ada pendaftar yang sudah diverifikasi.</p>
            </div>
        @endforelse

        @if(!empty($preview_data))
        <div class="bg-gray-900 p-8 rounded-2xl shadow-xl text-center relative overflow-hidden">
            <h3 class="text-xl font-black mb-2 text-white relative z-10">Konfirmasi Penguncian Hasil Seleksi</h3>
            <p class="text-gray-400 text-sm mb-8 relative z-10 max-w-2xl mx-auto">Tindakan ini bersifat final. Sistem akan secara massal mengubah status seluruh pendaftar di database menjadi "Diterima" atau "Tidak Diterima" persis seperti pada pratinjau di atas.</p>
            
            <form action="{{ route('admin.seleksi.publish') }}" method="POST" class="relative z-10">
                @csrf
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('admin.seleksi.index') }}" class="px-8 py-4 border border-gray-600 text-gray-300 font-bold rounded-xl hover:bg-gray-800 transition">
                        Batal & Kembali
                    </a>
                    <button type="submit" class="px-8 py-4 bg-red-600 text-white font-black rounded-xl hover:bg-red-700 transition shadow-lg shadow-red-600/30 tracking-wider">
                        🔒 KUNCI & PUBLIKASIKAN SEKARANG
                    </button>
                </div>
            </form>
        </div>
        @endif

    </div>
</x-panel-layout>