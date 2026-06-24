<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PPDB SMA Digirock</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">

    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <a href="{{ route('beranda') }}" class="inline-block font-black text-3xl text-blue-700 tracking-tighter mb-2">
            SMA Digirock
        </a>
        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang Kembali</h2>
        {{-- <p class="mt-2 text-sm text-gray-600">
            Portal login terpadu untuk <span class="font-bold text-blue-600">Siswa, Panitia, & Admin</span>
        </p> --}}
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        
        <div class="mb-4 px-4 sm:px-0">
            <a href="{{ route('beranda') }}" class="text-sm text-gray-500 hover:text-blue-600 font-semibold inline-flex items-center gap-2 transition duration-150 ease-in-out">
                &larr; Kembali ke Beranda
            </a>
        </div>

    <div class="bg-white py-8 px-4 shadow-xl shadow-blue-900/5 sm:rounded-2xl sm:px-10 border border-gray-100">
        
        <div class="bg-white py-8 px-4 shadow-xl shadow-blue-900/5 sm:rounded-2xl sm:px-10 border border-gray-100">
            
            @if ($errors->any())
                <div class="mb-4 bg-red-50 p-4 rounded-xl border border-red-100">
                    <ul class="text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Alamat Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 sm:text-sm transition"
                        placeholder="contoh@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Kata Sandi</label>
                    <input id="password" name="password" type="password" required
                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 sm:text-sm transition"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                            Ingat saya
                        </label>
                    </div>

                    <div class="text-sm">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-bold text-blue-600 hover:text-blue-500 transition">
                                Lupa kata sandi?
                            </a>
                        @endif
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:-translate-y-0.5">
                        Masuk ke Dashboard
                    </button>
                </div>
            </form>

            <div class="mt-6 border-t border-gray-100 pt-6 text-center text-sm">
                <p class="text-gray-600">
                    Belum punya akun pendaftaran? 
                    <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-500 transition">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>