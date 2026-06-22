<x-panel-layout>
    <x-slot name="title">Tambah Master Jalur</x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.jalur.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">&larr; Kembali ke Daftar Jalur</a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Formulir Jalur Pendaftaran Baru</h3>
            </div>
            
            <form action="{{ route('admin.jalur.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Jalur Pendaftaran <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required placeholder="Contoh: Jalur Zonasi" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="kuota" class="block text-sm font-medium text-gray-700 mb-1">Kuota Penerimaan (Kursi) <span class="text-red-500">*</span></label>
                    <input type="number" name="kuota" id="kuota" value="{{ old('kuota') }}" required min="1" class="w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('kuota') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow transition">
                        Simpan Master Jalur
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-panel-layout>