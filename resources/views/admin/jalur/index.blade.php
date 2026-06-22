{{-- <x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Jalur Pendaftaran') }}
            </h2>
            <a href="{{ route('admin.jalur.create') }}" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded text-sm font-bold">
                + Tambah Jalur Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Jalur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kuota</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($jalur as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $item->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->kuota }} Siswa</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.jalur.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900 mr-4">Edit</a>
                                <form action="{{ route('admin.jalur.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jalur ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data jalur pendaftaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout> --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Jalur Pendaftaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">Berhasil</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 border-b pb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Daftar Jalur PPDB</h3>
                            <p class="text-sm text-gray-500">Atur kuota dan buka/tutup hasil pengumuman per jalur di sini.</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="{{ route('admin.jalur.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
                                + Tambah Jalur Baru
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-y-2 border-gray-200">
                                    <th class="p-3 text-sm font-semibold tracking-wide text-gray-700 text-center w-12">No</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-gray-700">Nama Jalur</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-gray-700">Kuota</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-gray-700 text-center">Status Pengumuman</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-gray-700 text-center">Aksi (Sakelar)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jalur as $index => $jalur)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-3 text-sm text-gray-700 text-center">{{ $index + 1 }}</td>
                                    <td class="p-3 text-sm font-bold text-gray-800">{{ $jalur->nama }}</td>
                                    <td class="p-3 text-sm text-gray-700">{{ $jalur->kuota }} Kursi</td>
                                    
                                    <td class="p-3 text-sm text-center">
                                        @if($jalur->status_pengumuman)
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold uppercase tracking-wider border border-green-300">
                                                &#128275; Terbuka
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold uppercase tracking-wider border border-gray-300">
                                                &#128274; Tertutup
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="p-3 text-sm flex justify-center gap-2">
                                        
                                        <form action="{{ route('admin.jalur.toggle_pengumuman', $jalur->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Anda yakin ingin mengubah status pengumuman jalur ini?');">
                                            @csrf
                                            @method('PATCH')
                                            @if($jalur->status_pengumuman)
                                                <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded shadow transition">
                                                    Tutup Akses
                                                </button>
                                            @else
                                                <button type="submit" class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold rounded shadow transition">
                                                    Buka Akses
                                                </button>
                                            @endif
                                        </form>

                                        <a href="{{ route('admin.jalur.edit', $jalur->id) }}" class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold rounded shadow transition">
                                            Edit
                                        </a>

                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-gray-500 italic">
                                        Belum ada master data jalur pendaftaran yang dibuat.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>