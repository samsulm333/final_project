<x-panel-layout>
    <x-slot name="title">Formulir Pendaftaran PPDB</x-slot>

    <div class="max-w-5xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('student.dashboard') }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">&larr; Kembali ke Dashboard</a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Pengisian Data Administratif & Berkas</h3>
                <p class="text-xs text-gray-500 mt-1">Formulir ini hanya dapat dikirim satu kali. Pastikan validitas data Anda sebelum menekan tombol kirim.</p>
            </div>
            
            <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-8" x-data="{ selectedJalur: '' }">
                @csrf
                
                <div>
                    <h4 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4">1. Data Diri Calon Siswa</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk Kependudukan (NIK) <span class="text-red-500">*</span></label>
                            <input type="number" name="nik" value="{{ old('nik') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap (Sesuai Ijazah) <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Agama <span class="text-red-500">*</span></label>
                            <select name="agama" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap (Sesuai KK) <span class="text-red-500">*</span></label>
                            <textarea name="alamat" rows="3" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('alamat') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP / WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4">2. Data Orang Tua / Wali</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Orang Tua (Utama) <span class="text-red-500">*</span></label>
                            <input type="text" name="pekerjaan_ortu" value="{{ old('pekerjaan_ortu') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4">3. Data Akademik & Pilihan Jalur</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sekolah Asal <span class="text-red-500">*</span></label>
                            <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nilai Rata-Rata Rapor (0-100) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" min="0" max="100" name="nilai_rata_rata" value="{{ old('nilai_rata_rata') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Jalur Pendaftaran <span class="text-red-500">*</span></label>
                            <select name="jalur_id" required @change="selectedJalur = $event.target.options[$event.target.selectedIndex].text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Jalur --</option>
                                @foreach($jalur as $j)
                                    <option value="{{ $j->id }}" {{ old('jalur_id') == $j->id ? 'selected' : '' }}>
                                        {{ $j->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4">4. Unggah Dokumen Syarat</h4>
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 mb-6 text-sm text-blue-800">
                        Pastikan ukuran file mematuhi batas maksimal agar proses unggah tidak mengalami kegagalan.
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <div class="p-4 border border-gray-200 rounded-lg bg-white">
                            <p class="font-bold text-gray-800 text-sm">Pas Foto 3x4 <span class="text-red-500">*</span></p>
                            <p class="text-xs text-gray-500 mb-2">Format: JPG/PNG. Maks: 2MB</p>
                            <input type="file" name="foto" accept=".jpg,.jpeg,.png" required class="block w-full text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <div class="p-4 border border-gray-200 rounded-lg bg-white">
                            <p class="font-bold text-gray-800 text-sm">Kartu Keluarga (KK) <span class="text-red-500">*</span></p>
                            <p class="text-xs text-gray-500 mb-2">Format: PDF/JPG. Maks: 5MB</p>
                            <input type="file" name="kk" accept=".pdf,.jpg,.jpeg" required class="block w-full text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <div class="p-4 border border-gray-200 rounded-lg bg-white">
                            <p class="font-bold text-gray-800 text-sm">Ijazah / Surat Keterangan Lulus <span class="text-red-500">*</span></p>
                            <p class="text-xs text-gray-500 mb-2">Format: PDF/JPG. Maks: 5MB</p>
                            <input type="file" name="ijazah" accept=".pdf,.jpg,.jpeg" required class="block w-full text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <div class="p-4 border border-gray-200 rounded-lg bg-white">
                            <p class="font-bold text-gray-800 text-sm">Rapor Semester Terakhir <span class="text-red-500">*</span></p>
                            <p class="text-xs text-gray-500 mb-2">Format: PDF/JPG. Maks: 5MB</p>
                            <input type="file" name="rapor" accept=".pdf,.jpg,.jpeg" required class="block w-full text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <div class="p-4 border border-blue-300 rounded-lg bg-blue-50 md:col-span-2" x-show="selectedJalur.toLowerCase().includes('prestasi')" style="display: none;">
                            <p class="font-bold text-blue-900 text-sm">Piagam / Sertifikat Prestasi <span class="text-red-500">*</span></p>
                            <p class="text-xs text-blue-700 mb-2">Wajib karena Anda memilih Jalur Prestasi. Format: PDF/JPG. Maks: 5MB</p>
                            <input type="file" name="piagam" accept=".pdf,.jpg,.jpeg" x-bind:required="selectedJalur.toLowerCase().includes('prestasi')" class="block w-full text-xs text-blue-800 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-white file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200 flex justify-end">
                    <button type="submit" onclick="return confirm('Peringatan: Formulir tidak dapat diedit setelah dikirim. Anda yakin semua data sudah benar?');" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg transition text-lg">
                        Simpan & Ajukan Pendaftaran &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-panel-layout>