<x-guest-layout>
    <!-- 
        ===================================================================
        BAGIAN KIRI: CAROUSEL SLIDE (DIKIRIM KE SLOT LEFT_CONTENT DI LAYOUT)
        ===================================================================
    -->
    <x-slot name="left_content">
        <!-- 
            x-data: Menginisialisasi komponen Alpine.js.
            activeSlide: Menyimpan nomor slide yang sedang aktif (dimulai dari 1).
            init(): Fungsi otomatis berjalan saat halaman dimuat, mengatur perpindahan slide setiap 5 detik (5000ms).
        -->
        <div x-data="{ 
                activeSlide: 1, 
                init() { setInterval(() => { this.activeSlide = this.activeSlide === 1 ? 2 : 1 }, 5000) } 
             }"
            class="relative w-full max-w-lg mx-auto overflow-hidden">

            <!-- ================= SLIDE 1 ================= -->
            <!-- x-show: Gambar hanya tampil jika activeSlide bernilai 1 -->
            <!-- x-transition: Memberikan efek animasi pudar (fade) yang halus saat transisi gambar -->
            <div x-show="activeSlide === 1"
                x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="flex flex-col items-center justify-center text-center">

                <!-- Gambar Utama Slide 1 -->
                <img src="{{ asset('images/dlh.png') }}" alt="Logo Dinas" class="w-48 h-auto object-contain mb-6 drop-shadow-2xl">
                <!-- Teks Informasi Slide 1 -->
                <h2 class="text-2xl font-bold text-white tracking-wider uppercase">Dinas Lingkungan Hidup</h2>
                <p class="text-sm text-gray-400 mt-1 tracking-wide">Kabupaten Buleleng</p>
            </div>

            <!-- ================= SLIDE 2 ================= -->
            <!-- x-show: Gambar hanya tampil jika activeSlide bernilai 2 -->
            <div x-show="activeSlide === 2"
                x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="flex flex-col items-center justify-center text-center">

                <!-- Gambar Utama Slide 2 (Silakan sesuaikan nama file gambarnya nanti) -->
                <img src="{{ asset('images/dlh.png') }}" alt="Ilustrasi Keuangan" class="w-64 h-auto object-contain mb-6 drop-shadow-2xl">
                <!-- Teks Informasi Slide 2 -->
                <h2 class="text-2xl font-bold text-emerald-400 tracking-wider uppercase">Sistem Akuntabel</h2>
                <p class="text-sm text-gray-400 mt-1 tracking-wide">Pengelolaan Keuangan Daerah yang Transparan & Terintegrasi</p>
            </div>

            <!-- ================= INDIKATOR SLIDE (TITIK DI BAWAH) ================= -->
            <div class="flex justify-center space-x-2 mt-8">
                <!-- Tombol Indikator Slide 1: Berwarna hijau jika aktif, abu-abu jika tidak -->
                <!-- @click: Jika diklik akan langsung memindahkan slide aktif ke nomor 1 -->
                <button @click="activeSlide = 1"
                    :class="activeSlide === 1 ? 'bg-emerald-500 w-6' : 'bg-gray-600 w-2'"
                    class="h-2 rounded-full transition-all duration-300 focus:outline-none"></button>

                <!-- Tombol Indikator Slide 2: Berwarna hijau jika aktif, abu-abu jika tidak -->
                <button @click="activeSlide = 2"
                    :class="activeSlide === 2 ? 'bg-emerald-500 w-6' : 'bg-gray-600 w-2'"
                    class="h-2 rounded-full transition-all duration-300 focus:outline-none"></button>
            </div>
        </div>
    </x-slot>

    <!-- 
        ===================================================================
        BAGIAN KANAN: FORM LOGIN SIBEN (TETAP SAMA SEPERTI SEBELUMNYA)
        ===================================================================
    -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">SIBEN</h1>
        <p class="text-sm text-gray-600 mt-2">Mohon masukkan informasi akun Anda untuk mulai menggunakan aplikasi.</p>
    </div>

    <!-- Status Sesi (Menampilkan pesan jika ada error atau status keluar log) -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        <!-- @csrf: Keamanan wajib Laravel untuk mencegah serangan pembajakan form komputer luar -->
        @csrf

        <!-- Kotak Pilihan Tahun Anggaran -->
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun</label>
            <div class="flex items-center justify-between border border-gray-200 rounded-xl px-4 py-3 bg-gray-50/50">
                <div class="flex items-center space-x-3">
                    <span class="text-base">📅</span>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Tahun Anggaran 2026</p>
                        <p class="text-xs text-emerald-600 font-medium">● Tahun Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Akun / Email -->
        <div class="mb-5">
            <label for="nip" class="block text-sm font-semibold text-gray-700 mb-1">Nomor Induk Pegawai</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">👤</span>
                <input id="nip" type="nip" name="nip" :value="old('nip')" required autofocus
                    class="block w-full pl-11 pr-4 py-3 bg-blue-50/30 border border-gray-300 rounded-xl text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm text-sm"
                    placeholder="Masukkan NIP">
            </div>
            <!-- Menampilkan pesan error validasi email dari Laravel -->
            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
        </div>

        <!-- Input Kata Sandi -->
        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-700">Password</label>

            <div x-data="{ show: false }" class="relative mt-1">

                <input :type="show ? 'text' : 'password'"
                    name="password"
                    id="password"
                    required
                    placeholder="••••••••"
                    class="w-full rounded-xl border-gray-300 pr-11 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">

                <button type="button"
                    @click="show = !show"
                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-405 hover:text-emerald-600 transition-colors duration-150 focus:outline-none">

                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 21l-18-18" />
                    </svg>

                </button>
            </div>
        </div>

        <!-- Opsi Ingat Saya & Lupa Password -->
        <div class="flex items-center justify-between mb-6 mt-5">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                <span class="ms-2 text-xs text-gray-600 font-medium">Ingat Saya</span>
            </label>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800 hover:underline">
                Lupa Kata Sandi?
            </a>
            @endif
        </div>

        <!-- Tombol Eksekusi Masuk Form -->
        <div>
            <button type="submit"
                class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 text-sm tracking-wide">
                Masuk
            </button>
        </div>
    </form>
    <div x-data="{ isLoading: false }"
        x-on:submit.window="isLoading = true"
        x-show="isLoading"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/65 backdrop-blur-sm"
        style="display: none;">

        <div class="bg-white p-6 rounded-2xl shadow-2xl flex flex-col items-center space-y-4 max-w-xs mx-4 border border-gray-100">

            <div class="relative flex items-center justify-center">
                <svg class="animate-spin h-12 w-12 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#e2e8f0" stroke-width="4"></circle>
                    <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="absolute text-sm">🔒</span>
            </div>

            <div class="text-center">
                <h3 class="text-sm font-bold text-gray-900 tracking-wide">Memproses Akun...</h3>
                <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">Mohon tunggu, sistem sedang memvalidasi data Anda ke server.</p>
            </div>
        </div>
    </div>
</x-guest-layout>