<x-guest-layout>
    <x-slot name="left_content">
        <div class="flex flex-col items-center justify-center text-center">
            <img src="{{ asset('images/logo-bendahara.png') }}" alt="Logo Instansi" class="w-48 h-auto object-contain mb-6 drop-shadow-lg">
            <h2 class="text-2xl font-bold text-white tracking-wider uppercase">Dinas Lingkungan Hidup</h2>
            <p class="text-sm text-gray-400 mt-1 tracking-wide">Kabupaten Buleleng</p>
        </div>
    </x-slot>

    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Akun</h1>
        <p class="text-sm text-gray-600 mt-2">Buat akun operator Bendahara / Kasubag baru Anda di sini.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">✏️</span>
                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                    class="block w-full pl-11 pr-4 py-2.5 bg-blue-50/30 border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm text-sm" 
                    placeholder="Masukkan nama lengkap">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div class="mb-4">
            <label for="nip" class="block text-sm font-semibold text-gray-700 mb-1">Nomor Induk Pegawai (NIP)</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">👤</span>
                <input id="nip" type="text" name="nip" :value="old('nip')" required autocomplete="username"
                    class="block w-full pl-11 pr-4 py-2.5 bg-blue-50/30 border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm text-sm" 
                    placeholder="Masukkan NIP resmi Anda">
            </div>
            <x-input-error :messages="$errors->get('nip')" class="mt-1" />
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email Resmi</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">✉️</span>
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="email"
                    class="block w-full pl-11 pr-4 py-2.5 bg-blue-50/30 border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm text-sm" 
                    placeholder="contoh@buleleng.go.id">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">🔒</span>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="block w-full pl-11 pr-4 py-2.5 bg-blue-50/30 border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm text-sm" 
                    placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="mb-5">
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Ulangi Kata Sandi</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">🔄</span>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="block w-full pl-11 pr-4 py-2.5 bg-blue-50/30 border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm text-sm" 
                    placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="flex flex-col space-y-3">
            <button type="submit" 
                class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 text-sm tracking-wide">
                Daftar Akun Baru
            </button>
            
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800 hover:underline">
                    Sudah punya akun? Masuk Aplikasi
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>