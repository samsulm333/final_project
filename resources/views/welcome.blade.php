<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Online | SMA Digirock</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="font-black text-xl text-blue-700 tracking-tighter">SMA Digirock</div>
            <div class="hidden md:flex space-x-8 text-sm font-bold text-gray-600 items-center">
                <a href="#beranda" class="hover:text-blue-600 transition">Beranda</a>
                <a href="#jadwal" class="hover:text-blue-600 transition">Jadwal PPDB</a>
                <a href="#cek-status" class="hover:text-blue-600 transition">Cek Status</a>
                
                <div class="border-l border-gray-300 h-6 mx-2"></div>
                
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 transition">Login Akun</a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition shadow-sm">Daftar Akun Baru</a>
            </div>
        </div>
    </nav>

    <header id="beranda" class="bg-gradient-to-br from-blue-800 to-blue-600 py-20 text-white text-center relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 relative z-10">
            <span class="px-4 py-1.5 bg-blue-500/50 rounded-full text-xs font-bold uppercase tracking-widest mb-6 inline-block">Tahun Ajaran 2026/2027</span>
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">Portal Penerimaan<br>Peserta Didik Baru (PPDB)</h1>
            <p class="text-lg text-blue-100 mb-10 max-w-2xl mx-auto">Sistem pendaftaran daring terpadu SMA Digirock. Persiapkan dokumen Anda dan bergabunglah menjadi bagian dari generasi berprestasi.</p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-white text-blue-700 px-8 py-3.5 rounded-xl font-bold shadow-xl hover:bg-gray-50 hover:-translate-y-1 transition transform duration-200 text-lg">
                    Daftar Sekarang &rarr;
                </a>
            </div>
        </div>
    </header>

    <section id="jadwal" class="py-20 max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Jadwal & Tahapan Seleksi</h2>
            <p class="text-gray-500 mt-2">Pastikan Anda tidak melewati batas waktu yang telah ditentukan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm relative">
                <div class="w-10 h-10 bg-blue-600 text-white font-bold rounded-full flex items-center justify-center absolute -top-4 -left-4 shadow-lg border-4 border-white">1</div>
                <h3 class="font-bold text-lg text-gray-800 mb-1">Pendaftaran Akun</h3>
                <p class="text-blue-600 font-semibold text-sm mb-3">1 - 10 Juni 2026</p>
                <p class="text-gray-500 text-xs leading-relaxed">Pembuatan akun siswa, pengisian biodata dasar, dan pemilihan jalur pendaftaran.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm relative">
                <div class="w-10 h-10 bg-blue-600 text-white font-bold rounded-full flex items-center justify-center absolute -top-4 -left-4 shadow-lg border-4 border-white">2</div>
                <h3 class="font-bold text-lg text-gray-800 mb-1">Batas Upload Berkas</h3>
                <p class="text-blue-600 font-semibold text-sm mb-3">15 Juni 2026</p>
                <p class="text-gray-500 text-xs leading-relaxed">Batas akhir pengunggahan dokumen syarat (KK, Rapor, Ijazah, Foto) ke dalam sistem.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm relative">
                <div class="w-10 h-10 bg-blue-600 text-white font-bold rounded-full flex items-center justify-center absolute -top-4 -left-4 shadow-lg border-4 border-white">3</div>
                <h3 class="font-bold text-lg text-gray-800 mb-1">Verifikasi Panitia</h3>
                <p class="text-blue-600 font-semibold text-sm mb-3">16 - 20 Juni 2026</p>
                <p class="text-gray-500 text-xs leading-relaxed">Proses validasi dokumen fisik secara digital oleh panitia. Siswa wajib memantau dashboard.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border-gray-200 bg-blue-50 border shadow-inner relative">
                <div class="w-10 h-10 bg-green-500 text-white font-bold rounded-full flex items-center justify-center absolute -top-4 -left-4 shadow-lg border-4 border-white">4</div>
                <h3 class="font-bold text-lg text-gray-800 mb-1">Pengumuman Final</h3>
                <p class="text-green-600 font-bold text-sm mb-3">25 Juni 2026</p>
                <p class="text-gray-600 text-xs leading-relaxed">Pengumuman hasil seleksi PPDB dapat dilihat melalui portal ini atau akun masing-masing.</p>
            </div>
        </div>
    </section>

    <section id="cek-status" class="bg-white border-y border-gray-200 py-20">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Lacak Status Pendaftaran</h2>
            <p class="text-gray-500 text-sm mb-8">Masukkan nomor pendaftaran Anda (Contoh: PPDB-2026-0012) untuk melihat status verifikasi dokumen secara real-time.</p>
            
            <form action="{{ route('beranda') }}#cek-status" method="GET" class="flex flex-col sm:flex-row gap-3 justify-center mb-10">
                <input type="text" name="nomor_pendaftaran" 
                    value="{{ request('nomor_pendaftaran') }}" 
                    placeholder="Masukkan Nomor Pendaftaran..." required
                    class="w-full sm:w-96 px-5 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition font-mono uppercase">
                <button type="submit" class="bg-gray-800 text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-900 transition shadow-md whitespace-nowrap">
                    Cari Data
                </button>
                
                @if(request()->has('nomor_pendaftaran'))
                    <a href="{{ route('beranda') }}#cek-status" class="bg-red-100 text-red-600 px-4 py-3 rounded-xl font-bold hover:bg-red-200 transition text-center whitespace-nowrap">
                        &times; Reset
                    </a>
                @endif
            </form>

            @if(request()->has('nomor_pendaftaran'))
                @if($pesan_error)
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-6 text-center shadow-sm max-w-2xl mx-auto">
                        <span class="text-3xl mb-2 block">🔍</span>
                        <h4 class="text-lg font-bold text-red-700 mb-1">Pencarian Gagal</h4>
                        <p class="text-sm text-red-600">{{ $pesan_error }}</p>
                    </div>
                @elseif($hasil_pencarian)
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 text-left shadow-sm">
                        <h4 class="text-xs font-bold uppercase text-gray-400 mb-4 tracking-widest border-b pb-2">
                            Hasil Pencarian: <span class="text-blue-600">{{ $hasil_pencarian->nomor_pendaftaran }}</span>
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <p class="text-[11px] text-gray-500 uppercase font-semibold">Nama Pendaftar</p>
                                <p class="font-bold text-gray-900 text-base">
                                    {{ $hasil_pencarian->student->nama_lengkap }}
                                </p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-500 uppercase font-semibold">Jalur Masuk</p>
                                <p class="font-bold text-blue-700 text-base">{{ $hasil_pencarian->jalur->nama ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-500 uppercase font-semibold">Status Pendaftaran</p>
                                <span class="inline-block mt-1 px-4 py-1.5 bg-yellow-100 text-yellow-800 text-xs font-black rounded-lg uppercase tracking-wider shadow-sm border border-yellow-200">
                                    {{ str_replace('_', ' ', $hasil_pencarian->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 text-left shadow-sm">
                <h4 class="text-xs font-bold uppercase text-gray-400 mb-4 tracking-widest border-b pb-2">Hasil Pencarian: PPDB-2026-0012</h4> --}}
                {{-- <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-[11px] text-gray-500 uppercase font-semibold">Nama Pendaftar</p>
                        <p class="font-bold text-gray-900">Budi Santoso</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-500 uppercase font-semibold">Jalur Masuk</p>
                        <p class="font-bold text-blue-700">Zonasi</p>
                    </div>
                    <div>
                        <p class="text-[11px] text-gray-500 uppercase font-semibold">Status Saat Ini</p>
                        <span class="inline-block mt-1 px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-black rounded-md uppercase tracking-wider">
                            Menunggu Verifikasi
                        </span>
                    </div>
                </div> --}}
            {{-- </div> --}}
            </div>
    </section>

    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center md:text-left grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h4 class="font-bold text-lg mb-4">Panitia PPDB SMA Digirock</h4>
                <p class="text-gray-400 text-sm leading-relaxed">Jl. Pendidikan No. 123, Kota Administrasi.<br>Jam Layanan: Senin - Jumat (08.00 - 15.00)</p>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4">Kontak Bantuan</h4>
                <p class="text-gray-400 text-sm">Email: ppdb@SMADigirock.sch.id<br>WhatsApp: +62 812 3456 7890</p>
            </div>
        </div>
    </footer>

</body>
</html>