<x-panel-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pusat Kendali Seleksi Akademik') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-10 text-center relative overflow-hidden">
            
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-50 rounded-full opacity-50 z-0"></div>
            
            <div class="relative z-10">
                <span class="text-6xl mb-6 block">⚙️</span>
                <h3 class="text-2xl font-black text-gray-900 mb-3">Sistem Kelola Kelulusan Otomatis</h3>
                <p class="text-gray-500 max-w-xl mx-auto mb-10 leading-relaxed text-sm">
                    Mesin pembagi otomatis akan menyortir seluruh pendaftar yang <span class="font-bold text-green-600">berkasnya sudah valid (Terverifikasi)</span> berdasarkan nilai rata-rata tertinggi, lalu menyesuaikannya secara presisi dengan pagu kuota di setiap jalur.
                </p>

                @if($sudah_publish ?? false)
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 text-amber-800 text-sm font-bold tracking-wide uppercase inline-block mb-4 shadow-sm">
                        🔒 Hasil Seleksi PPDB Telah Dikunci & Dipublikasikan
                    </div>
                    <p class="text-xs text-amber-600 mb-6 font-medium">Status kelulusan siswa sudah paten dan tidak dapat diubah lagi melalui antarmuka ini.</p>
                    
                    <form action="{{ route('admin.seleksi.reset') }}" method="POST" onsubmit="return confirm('PERINGATAN BAHAYA!\n\nApakah Anda yakin ingin membatalkan semua hasil seleksi?\nStatus kelulusan seluruh siswa akan ditarik kembali dan mereka tidak akan bisa melihat hasil pengumuman sampai Anda memublikasikannya ulang.');">
                        @csrf
                        <button type="submit" class="w-full md:w-2/3 mx-auto py-4 bg-white border-2 border-red-500 text-red-600 hover:bg-red-50 font-extrabold rounded-xl text-sm tracking-widest uppercase shadow-sm transition transform hover:-translate-y-1">
                            🔓 Buka Kunci & Tarik Hasil Kelulusan
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.seleksi.preview') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full md:w-2/3 mx-auto py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold rounded-xl text-sm tracking-widest uppercase shadow-xl shadow-indigo-600/30 transition transform hover:-translate-y-1">
                            🚀 Jalankan Pratinjau Algoritma
                        </button>
                    </form>
                    <p class="text-xs text-gray-400 mt-4 font-medium italic">* Jangan khawatir, menekan tombol ini belum mengubah data apapun. Anda akan melihat pratinjaunya terlebih dahulu.</p>
                @endif
            </div>
        </div>
    </div>
</x-panel-layout>