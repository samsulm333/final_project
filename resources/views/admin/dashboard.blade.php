<x-panel-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dasbor Super Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-indigo-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Siswa Terdaftar</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalSiswa }}</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Jalur Pendaftaran Aktif</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalJalur }}</div>
                </div>
            </div>


            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500">
                <div class="p-6 text-gray-900 flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <h3 class="text-lg font-bold text-red-700">Tahap Akhir: Jalankan Seleksi Otomatis</h3>
                        <p class="text-gray-600 text-sm mt-1">Sistem akan meranking semua pendaftar berstatus "Terverifikasi" berdasarkan Nilai Rata-Rata dan memotongnya sesuai Kuota per Jalur.</p>
                    </div>
                    <form action="{{ route('admin.seleksi.otomatis') }}" method="POST" onsubmit="return confirm('PERINGATAN: Aksi ini akan mengubah status siswa menjadi Diterima/Tidak Diterima. Lanjutkan?');">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded shadow transition duration-150 uppercase tracking-wide">
                            &#9889; Eksekusi Seleksi Sekarang
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold mb-2">Manajemen Master Data</h3>
                        <p class="text-gray-600">Kelola kuota dan jalur pendaftaran sistem PPDB di sini.</p>
                    </div>
                    <a href="{{ route('admin.jalur.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                        Kelola Jalur Pendaftaran &rarr;
                    </a>
                </div>
            </div>


        </div>
    </div>
</x-panel-layout>