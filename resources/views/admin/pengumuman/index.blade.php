<x-panel-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengumuman Beranda') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg font-bold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-fit">
                <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Buat Pengumuman</h3>
                <form action="{{ route('admin.pengumuman.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Judul Pengumuman</label>
                        <input type="text" name="judul" required 
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                               placeholder="Contoh: Info Wawancara Jalur Prestasi">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Isi Informasi</label>
                        <textarea name="konten" rows="5" required 
                                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                  placeholder="Tuliskan detail informasi di sini..."></textarea>
                    </div>
                    
                    <div class="flex items-center mt-2 p-3 bg-blue-50 rounded-lg border border-blue-100">
                        <input type="checkbox" name="is_published" id="is_published" value="1" 
                               class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer" checked>
                        <label for="is_published" class="ml-3 block text-sm font-bold text-blue-900 cursor-pointer">
                            Publikasikan Langsung ke Beranda
                        </label>
                    </div>
                    
                    <button type="submit" class="w-full bg-gray-800 text-white font-bold py-3 px-4 rounded-lg hover:bg-gray-900 transition shadow-md">
                        Simpan & Terbitkan
                    </button>
                </form>
            </div>

            <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">Riwayat Pengumuman</h3>
                
                <div class="space-y-4">
                    @forelse($announcements ?? [] as $ann)
                        <div class="border border-gray-200 p-5 rounded-xl flex flex-col sm:flex-row justify-between items-start gap-4 hover:bg-gray-50 transition shadow-sm">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-1">
                                    <h4 class="font-bold text-gray-900 text-lg">{{ $ann->judul }}</h4>
                                    @if($ann->is_published)
                                        <span class="px-2.5 py-0.5 bg-green-100 text-green-800 text-[10px] font-black uppercase rounded-full tracking-wider border border-green-200">Publik</span>
                                    @else
                                        <span class="px-2.5 py-0.5 bg-gray-200 text-gray-600 text-[10px] font-black uppercase rounded-full tracking-wider border border-gray-300">Draft</span>
                                    @endif
                                </div>
                                
                                <p class="text-xs text-blue-600 font-mono font-semibold mb-3">
                                    Diunggah pada: {{ $ann->created_at->format('d M Y, H:i') }} WIB
                                </p>
                                
                                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $ann->konten }}</p>
                            </div>
                            
                            <div class="shrink-0 pt-1">
                                <form action="{{ route('admin.pengumuman.destroy', $ann->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-200 rounded-lg text-xs font-bold transition shadow-sm whitespace-nowrap">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                            <span class="text-4xl block mb-3">📢</span>
                            <h4 class="text-base font-bold text-gray-700">Belum Ada Informasi</h4>
                            <p class="text-gray-500 text-sm mt-1">Gunakan form di sebelah kiri untuk mulai membuat pengumuman.</p>
                        </div>
                    @endforelse
                </div>
                
            </div>
        </div>
    </div>
</x-panel-layout>