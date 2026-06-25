<x-panel-layout>
    <x-slot name="title">
       Dashboard Super Admin PPDB
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl border-l-4 border-blue-500 p-6 shadow-sm flex flex-col justify-between">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Total Pendaftar</p>
                <p class="text-4xl font-bold text-gray-900">{{ $total_pendaftar }} <span class="text-sm text-gray-400 font-normal">Siswa</span></p>
            </div>
            <div class="bg-white rounded-xl border-l-4 border-yellow-500 p-6 shadow-sm flex flex-col justify-between">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Antrean Verifikasi</p>
                <p class="text-4xl font-bold text-yellow-600">{{ $menunggu_verifikasi }} <span class="text-sm text-gray-400 font-normal">Berkas</span></p>
            </div>
            <div class="bg-white rounded-xl border-l-4 border-green-500 p-6 shadow-sm flex flex-col justify-between">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Selesai Verifikasi</p>
                <p class="text-4xl font-bold text-green-600">{{ $terverifikasi }} <span class="text-sm text-gray-400 font-normal">Siswa</span></p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Statistik Kuota Per Jalur</h3>
                <div class="space-y-5">
                    @forelse($stat_jalur as $j)
                        <div>
                            <div class="flex justify-between text-sm font-bold text-gray-700 mb-1">
                                <span>{{ $j->nama }}</span>
                                <span>{{ $j->registrations_count }} / {{ $j->kuota }} Kuota</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" 
                                     style="width: {{ $j->kuota > 0 ? min(($j->registrations_count / $j->kuota) * 100, 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 italic text-sm">Belum ada data jalur pendaftaran.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Pusat Kendali</h3>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.jalur.index') }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-700 text-sm">📍 Kelola Jalur Pendaftaran</span>
                        <span class="text-gray-400">&rarr;</span>
                    </a>
                    <a href="{{ route('admin.panitia.index') }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-700 text-sm">👥 Manajemen Akun Panitia</span>
                        <span class="text-gray-400">&rarr;</span>
                    </a>
                    <a href="{{ route('admin.pengumuman.index') }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-700 text-sm">📢 Buat Pengumuman Publik</span>
                        <span class="text-gray-400">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border-l-4 border-indigo-500 p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-bold text-indigo-700 mb-2">Mesin Seleksi Otomatis</h3>
                    <p class="text-sm text-gray-600 mb-6">Sistem akan memotong batas kuota kelulusan berdasarkan peringkat nilai rata-rata. Anda dapat melihat pratinjau (preview) terlebih dahulu sebelum mengunci hasil akhir.</p>
                </div>
                <a href="{{ route('admin.seleksi.index') }}" class="text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition shadow-md">
                    ⚙️ Buka Panel Seleksi
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border-l-4 border-emerald-500 p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-bold text-emerald-700 mb-2">Laporan Hasil Kelulusan</h3>
                    <div class="flex gap-4 mt-4 mb-6">
                        <div class="bg-emerald-50 px-4 py-2 rounded-lg border border-emerald-100">
                            <span class="block text-xs text-emerald-600 font-bold uppercase">Diterima</span>
                            <span class="text-2xl font-black text-emerald-700">{{ $diterima }}</span>
                        </div>
                        <div class="bg-red-50 px-4 py-2 rounded-lg border border-red-100">
                            <span class="block text-xs text-red-600 font-bold uppercase">Ditolak</span>
                            <span class="text-2xl font-black text-red-700">{{ $tidak_diterima }}</span>
                        </div>
                    </div>
                </div>
                @if($diterima > 0)
                    <a 
                    href="{{ route('admin.laporan.export') }}" 
                    class="text-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-lg transition shadow-md">
                        📥 Download Laporan (CSV)
                    </a>
                @else
                    <button disabled class="w-full text-center bg-gray-200 text-gray-500 font-bold py-3 px-4 rounded-lg cursor-not-allowed">
                        Data Lulus Belum Tersedia
                    </button>
                @endif
            </div>
        </div>

    </div>
</x-panel-layout>