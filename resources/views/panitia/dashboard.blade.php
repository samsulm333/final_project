<x-panel-layout>
    <x-slot name="title">Dashboard Panitia</x-slot>

    @php
        // Tarik agregasi data secara langsung
        $total = \App\Models\Registration::count();
        $baru = \App\Models\Registration::whereDate('created_at', \Carbon\Carbon::today())->count();
        $menunggu = \App\Models\Registration::where('status', 'menunggu_verifikasi')->count();
        $terverifikasi = \App\Models\Registration::where('status', 'terverifikasi')->count();
        $ditolak = \App\Models\Document::where('status_verifikasi', 'ditolak')->count();
        $terbaru = \App\Models\Registration::with(['student', 'jalur'])->latest()->take(5)->get();
    @endphp

    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition mb-8">
            <h3 class="text-blue-600 text-4xl font-bold mb-2">{{ $total }}</h3>
            <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Total Pendaftar</p>
        </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition">
            <h3 class="text-purple-600 text-4xl font-bold mb-2">{{ $baru }}</h3>
            <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Total Pendaftar Baru Hari Ini</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition">
            <h3 class="text-yellow-500 text-4xl font-bold mb-2">{{ $menunggu }}</h3>
            <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Total Menunggu Verifikasi</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition">
            <h3 class="text-green-500 text-4xl font-bold mb-2">{{ $terverifikasi }}</h3>
            <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Total Terverifikasi</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition">
            <h3 class="text-green-500 text-4xl font-bold mb-2">{{ $ditolak }}</h3>
            <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Total Dokumen Ditolak</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4 flex justify-between items-center">
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Pendaftar Terbaru</h3>
            <a href="{{ route('panitia.pendaftar.index') }}" class="text-xs text-blue-600 hover:text-blue-800 font-semibold">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 text-xs text-gray-500 uppercase tracking-wider">
                        <th class="p-4 font-medium">No. Pendaftaran</th>
                        <th class="p-4 font-medium">Nama</th>
                        <th class="p-4 font-medium">Jalur</th>
                        <th class="p-4 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @forelse($terbaru as $reg)
                    <tr class="border-b border-gray-50 hover:bg-gray-50">
                        <td class="p-4 font-bold text-gray-900">{{ $reg->nomor_pendaftaran }}</td>
                        <td class="p-4">{{ $reg->student->nama_lengkap }}</td>
                        <td class="p-4">{{ $reg->jalur->nama ?? '-' }}</td>
                        <td class="p-4">
                            @if($reg->status === 'menunggu_verifikasi')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-md font-semibold text-xs">Menunggu</span>
                            @elseif($reg->status === 'terverifikasi')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-md font-semibold text-xs">Terverifikasi</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md font-semibold text-xs">{{ ucfirst($reg->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500 italic">Belum ada pendaftar masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-panel-layout>