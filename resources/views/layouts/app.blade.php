<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIBEN') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="flex min-h-screen">
        <aside id="sidebar" class="w-64 bg-emerald-950 text-white flex flex-col min-h-screen shadow-xl sticky top-0 h-screen z-10 transition-all duration-300 ease-in-out">

            <div class="p-5 border-b border-emerald-800/60 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div id="sidebar-brand" class="sidebar-text transition-opacity duration-200">
                        <h1 class="font-bold text-lg tracking-wider text-emerald-400 leading-tight">SIBEN</h1>
                        <p class="text-[10px] text-gray-400 uppercase tracking-tight">BENDAHARA PENERIMAAN</p>
                    </div>
                </div>

                <button id="btn-toggle" class="p-1.5 rounded-xl hover:bg-emerald-900 text-emerald-300 hover:text-white focus:outline-none shrink-0">
                    <svg id="toggle-icon" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition font-medium text-sm {{ request()->routeIs('dashboard') ? 'bg-emerald-700 text-white' : 'text-gray-300 hover:bg-emerald-900/50 hover:text-white' }}">
                    <span class="text-lg">📊</span>
                    <span class="sidebar-text transition-opacity duration-200">Dashboard</span>
                </a>

                <div class="sidebar-text pt-4 pb-2 px-4 text-[10px] font-bold tracking-wider text-emerald-500 uppercase">Modul Transaksi</div>

                <a href="{{ route('register.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-gray-300 hover:bg-emerald-900/50 hover:text-white transition font-medium text-sm {{ request()->routeIs('register.index') ? 'bg-emerald-700 text-white' : '' }}">
                    <span class="text-lg">📝</span>
                    <span class="sidebar-text transition-opacity duration-200">Register Pendapatan</span>
                </a>

                <a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-gray-300 hover:bg-emerald-900/50 hover:text-white transition font-medium text-sm">
                    <span class="text-lg">🎯</span>
                    <span class="sidebar-text transition-opacity duration-200">Target & Realisasi</span>
                </a>

                <a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-gray-300 hover:bg-emerald-900/50 hover:text-white transition font-medium text-sm">
                    <span class="text-lg">📈</span>
                    <span class="sidebar-text transition-opacity duration-200">Realisasi</span>
                </a>

                <div class="sidebar-text pt-4 pb-2 px-4 text-[10px] font-bold tracking-wider text-emerald-500 uppercase">Dokumen Penerimaan</div>

                <a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-gray-300 hover:bg-emerald-900/50 hover:text-white transition font-medium text-sm">
                    <span class="text-lg">📂</span>
                    <span class="sidebar-text transition-opacity duration-200">STBP</span>
                </a>

                <a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-gray-300 hover:bg-emerald-900/50 hover:text-white transition font-medium text-sm">
                    <span class="text-lg">🏦</span>
                    <span class="sidebar-text transition-opacity duration-200">STS</span>
                </a>

                <div class="sidebar-text pt-4 pb-2 px-4 text-[10px] font-bold tracking-wider text-emerald-500 uppercase">Laporan Kas</div>

                <a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-gray-300 hover:bg-emerald-900/50 hover:text-white transition font-medium text-sm">
                    <span class="text-lg">📖</span>
                    <span class="sidebar-text transition-opacity duration-200">Buku Kas Umum</span>
                </a>

                <a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-gray-300 hover:bg-emerald-900/50 hover:text-white transition font-medium text-sm">
                    <span class="text-lg">🗂️</span>
                    <span class="sidebar-text transition-opacity duration-200">LPJ Fungsional</span>
                </a>
            </nav>
        </aside>
        <main class="flex-1 min-w-0 flex flex-col h-screen overflow-y-auto">
            <header x-data="{ open: false }" class="bg-white shadow-sm border-b border-gray-100 px-8 py-3 flex items-center justify-between sticky top-0 z-20">

                <h2 class="font-bold text-gray-800 text-lg">
                    {{ $header ?? 'Beranda' }}
                </h2>
                <div class="flex items-center space-x-4 sm:space-x-6 flex-shrink-0">
                    <div class="flex items-center space-x-6">
                        <div class="text-xs text-gray-500 font-medium hidden sm:block">
                            Tahun Anggaran: <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-md font-bold">2026</span>
                        </div>

                        <div class="relative">
                            <button @click="open = !open" @click.outside="open = false" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="mr-1 font-semibold text-gray-700">{{ Auth::user()->name }}</div>
                                <svg class="fill-current h-4 w-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1  1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 rounded-xl shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 border border-gray-100 z-30"
                                style="display: none;">

                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-xs text-gray-400">Masuk sebagai:</p>
                                    <p class="text-xs font-bold text-gray-700 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <a href="{{ route('profile.edit') }}" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-50 focus:outline-none transition duration-150 ease-in-out">
                                    👤 Pengaturan Profil
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm leading-5 text-red-600 hover:bg-red-50 focus:outline-none transition duration-150 ease-in-out border-t border-gray-100 mt-1">
                                        🚪 Keluar Sistem
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

            </header>

            <div class="p-8 flex-1">
                {{ $slot }}
            </div>
        </main>

    </div>
    <div x-data="{ isLoggingOut: false }"
        x-show="isLoggingOut"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/65 backdrop-blur-sm"
        style="display: none;">
        <div class="bg-white p-6 rounded-2xl shadow-2xl flex flex-col items-center space-y-4 max-w-xs mx-4 border border-gray-100">
            <div class="relative flex items-center justify-center">
                <svg class="animate-spin h-12 w-12 text-rose-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#e2e8f0" stroke-width="4"></circle>
                    <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="absolute text-sm">🚪</span>
            </div>
            <div class="text-center">
                <h3 class="text-sm font-bold text-gray-900 tracking-wide">Keluar dari Sistem...</h3>
                <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">Sistem sedang mengamankan sesi dan membersihkan data login Anda.</p>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnToggle = document.getElementById('btn-toggle');
            const sidebar = document.getElementById('sidebar');
            const toggleIcon = document.getElementById('toggle-icon');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');

            btnToggle.addEventListener('click', function() {
                const isFullWidth = sidebar.classList.contains('w-64');

                if (isFullWidth) {
                    // Kecilkan sidebar
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-20');

                    // Sembunyikan semua teks & sub-header
                    sidebarTexts.forEach(el => el.classList.add('hidden'));

                    // Putar ikon panah menjadi menghadap kanan
                    toggleIcon.style.transform = 'rotate(180deg)';
                } else {
                    // Kembalikan ke ukuran normal
                    sidebar.classList.remove('w-20');
                    sidebar.classList.add('w-64');

                    // Tampilkan kembali semua teks
                    sidebarTexts.forEach(el => el.classList.remove('hidden'));

                    // Kembalikan rotasi ikon panah
                    toggleIcon.style.transform = 'rotate(0deg)';
                }
            });
        });
    </script>
</body>
</html>