<x-panel-layout>
    <x-slot name="title">Daftar Calon Siswa</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- <form method="GET" action="{{ route('panitia.pendaftar.index') }}" class="mb-6 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama atau No. Pendaftaran..." class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 w-1/3">
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">Cari</button>
                </form> --}}
                
                <div class="mb-6 flex justify-between items-center gap-4">
                <form method="GET" action="{{ route('panitia.pendaftar.index') }}" class="flex gap-2 w-full md:w-1/2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama atau No. Pendaftaran..." class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 w-full">
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">Cari</button>
                </form>

                <a href="{{ route('panitia.pendaftar.export') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 shadow">
                    &#128190; Ekspor CSV
                </a>
            </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Daftar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jalur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($registrations as $reg)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $reg->nomor_pendaftaran }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reg->student->nama_lengkap }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reg->jalur->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($reg->status === 'menunggu_verifikasi')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                    @elseif($reg->status === 'terverifikasi')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Terverifikasi</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('panitia.pendaftar.show', $reg->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Periksa Berkas &rarr;</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data pendaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $registrations->links() }}
                </div>

            </div>
        </div>
    </div>
</x-panel-layout>