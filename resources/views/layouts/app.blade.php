<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-100 text-slate-800">
    <div class="flex min-h-screen" x-data="{
        searchQuery: '',
        filterMenu(title) {
            if (!this.searchQuery) return true;
            return title.toLowerCase().includes(this.searchQuery.toLowerCase());
        }
    }">

        <!-- SIDEBAR UTAMA GAYA SIPD -->
        <aside id="sidebar"
            class="w-72 bg-slate-200/95 border-r border-slate-200/80 flex flex-col min-h-screen sticky top-0 h-screen z-10 transition-all duration-300 ease-in-out p-3 shadow-[0_12px_24px_-4px_rgba(30,58,138,0.12)]">

            <!-- BRAND LOGO SIBEN -->
            <div id="sidebar-header" class="p-2.5 mb-2 flex items-center justify-between transition-all duration-300">
                <div class="flex items-center space-x-3 min-w-0">
                    <div
                        class="w-9 h-9 bg-emerald-700 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-md shadow-emerald-700/30 shrink-0">
                        D
                    </div>
                    <div id="sidebar-brand" class="sidebar-text transition-opacity duration-200 truncate">
                        <h1 class="font-black text-sm tracking-wider text-slate-800 leading-none">SIBEN</h1>
                        <p class="text-[8px] text-emerald-700 font-bold uppercase tracking-tight mt-0.5">DLH KAB.
                            BULELENG</p>
                    </div>
                </div>

                <button id="btn-toggle"
                    class="p-1 bg-white rounded-tl-lg rounded-tr rounded-bl rounded-br-lg hover:bg-slate-100 text-slate-500 hover:text-slate-800 focus:outline-none shrink-0 transition">
                    <svg id="toggle-icon" class="w-5 h-5 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- SEARCH MENU (CTRL K) -->
            <div class="sidebar-text mb-3 px-3">
                <div class="relative flex items-center">
                    <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-00 text-sm">
                        🔍
                    </div>
                    <input type="text" x-model="searchQuery" placeholder="Cari menu..."
                        class="w-full pl-8 pr-11 py-1.5 text-sm bg-white border border-slate-300/80 p-3 shadow-[0_10px_25px_-5px_rgba(0,0,0,0.16)] rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium placeholder-slate-400 transition">
                    <span
                        class="absolute right-2 px-1 py-0.5 text-[8px] font-bold text-slate-400 bg-slate-100 border border-slate-200 rounded-md">
                        Ctrl K
                    </span>
                </div>
            </div>

            <!-- LIST MENU UTAMA (CARD GROUPING) -->
            <nav class="flex-1 space-y-3.5 overflow-y-auto p-1 pr-3.5">

                <!-- KELOMPOK: MENU UTAMA -->
                <div :class="sidebarOpen ? 'p-3' : 'p-1.5'"
                    class="sidebar-card bg-white rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl border border-slate-300/80 shadow-[0_1px_2px_rgba(0,0,0,0.1),0_12px_24px_-4px_rgba(30,58,138,0.12)] space-y-1 transition-all duration-300">
                    <div
                        class="sidebar-text pl-3.5 pt-3 pr-2 pb-1 text-[11px] font-bold tracking-wider text-slate-400 uppercase"
                        :class="{ 'hidden' : !sidebarOpen }">
                        Menu Utama
                    </div>

                    <a href="{{ route('dashboard') }}" x-show="filterMenu('Dashboard')" title="Dashboard"
                        class="sidebar-link flex items-center justify-between px-2.5 py-1.5 rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl transition-all duration-200 font-semibold text-sm {{ request()->routeIs('dashboard') ? 'bg-emerald-800 text-white border border-slate-300 shadow-md shadow-emerald-700/30' : 'text-slate-600 border border-transparent hover:border-emerald-300 hover:bg-white hover:text-emerald-700 hover:shadow-[0_8px_20px_rgba(16,185,129,0.25)] ease-out hover:translate-x-1' }} ">
                        <div class="flex items-center space-x-2.5 min-w-0">
                            <span
                                class="w-7 h-7 rounded-tl-lg rounded-tr rounded-bl rounded-br-lg border shadow-md {{ request()->routeIs('dashboard') ? 'bg-white/15 border-white/30' : 'bg-white text-emerald-700 border border-slate-300' }} flex items-center justify-center text-sm shrink-0 transition">
                                🏠
                            </span>
                            <span class="sidebar-text truncate">Dashboard</span>
                        </div>
                        @if (request()->routeIs('dashboard'))
                        <span class="sidebar-text w-2 h-2 rounded-full bg-white animate-pulse shrink-0"></span>
                        @else
                        <span class="sidebar-text text-slate-300 text-sm">›</span>
                        @endif
                    </a>
                </div>

                <!-- KELOMPOK: MODUL TRANSAKSI (CARD GAYA SIPD ASLI) -->
                <div :class="sidebarOpen ? 'p-3' : 'p-1.5'"
                    class="sidebar-card bg-white rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl border border-slate-300/80 shadow-[0_1px_2px_rgba(0,0,0,0.1),0_12px_24px_-4px_rgba(30,58,138,0.12)] space-y-1 transition-all duration-300">

                    <!-- SUB-HEADER KELOMPOK -->
                    <div
                        class="sidebar-text pl-3.5 pr-2 pt-3 pb-1 text-[11px] font-bold tracking-wider text-slate-400 uppercase"
                        :class="{ 'hidden' : !sidebarOpen }">
                        Modul Transaksi
                    </div>

                    <!-- REGISTER PENDAPATAN -->
                    <a href="{{ route('register.index') }}" x-show="filterMenu('Register Pendapatan')"
                        title="Register Pendapatan"
                        class="sidebar-link flex items-center justify-between px-2.5 py-2 transition-all duration-200 font-semibold text-sm {{ request()->routeIs('register.*') ? 'bg-emerald-800 text-white rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl shadow-md shadow-emerald-700/30' : 'text-slate-600 border border-transparent rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl  hover:border-emerald-300 hover:bg-white hover:text-emerald-700 hover:shadow-[0_8px_20px_rgba(16,185,129,0.2)] ease-out hover:translate-x-1' }}">
                        <div class="flex items-center space-x-2.5 min-w-0">
                            <!-- WADAH IKON LENGKUNG SQUIRCLE -->
                            <span
                                class="w-7 h-7 rounded-tl-lg rounded-tr rounded-bl rounded-br-lg border shadow-md {{ request()->routeIs('register.*') ? 'bg-white/15 border-white/30' : 'bg-white text-emerald-700 border border-slate-300' }} flex items-center justify-center text-sm shrink-0 transition">
                                📝
                            </span>
                            <span class="sidebar-text truncate">Register Pendapatan</span>
                        </div>
                        @if (request()->routeIs('register.*'))
                        <span class="sidebar-text w-2 h-2 rounded-full bg-white animate-pulse shrink-0"></span>
                        @else
                        <span class="sidebar-text text-slate-300 text-sm">›</span>
                        @endif
                    </a>

                    <!-- TARGET & REALISASI -->
                    <a href="{{ route('target-realisasi.index') }}" x-show="filterMenu('Target & Realisasi')"
                        title="Target & Realisasi"
                        class="sidebar-link flex items-center justify-between px-2.5 py-2 transition-all duration-200 font-semibold text-sm {{ request()->routeIs('target-realisasi.*') ? 'bg-emerald-800 text-white rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl shadow-md shadow-emerald-700/30' : 'text-slate-600 border border-transparent rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl  hover:border-emerald-300 hover:bg-white hover:text-emerald-700 hover:shadow-[0_8px_20px_rgba(16,185,129,0.2)] ease-out hover:translate-x-1' }}">
                        <div class="flex items-center space-x-2.5 min-w-0">
                            <span
                                class="w-7 h-7 rounded-tl-lg rounded-tr rounded-bl rounded-br-lg shadow-md {{ request()->routeIs('target-realisasi.*') ? 'bg-white/15 border-white/30' : 'bg-white text-emerald-700 border border-slate-300' }} flex items-center justify-center text-sm shrink-0 transition">
                                🎯
                            </span>
                            <span class="sidebar-text truncate">Target & Realisasi</span>
                        </div>
                        @if (request()->routeIs('target-realisasi.*'))
                        <span class="sidebar-text w-2 h-2 rounded-full bg-white animate-pulse shrink-0"></span>
                        @else
                        <span class="sidebar-text text-slate-300 text-sm">›</span>
                        @endif
                    </a>

                    <!-- REALISASI (LRA) -->
                    <a href="{{ route('realisasi.index') }}" x-show="filterMenu('Realisasi')" title="Realisasi (LRA)"
                        class="sidebar-link flex items-center justify-between px-2.5 py-2 transition-all duration-200 font-semibold text-sm {{ request()->routeIs('realisasi.*') ? 'bg-emerald-800 text-white rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl shadow-md shadow-emerald-700/30' : 'text-slate-600 border border-transparent rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl hover:border-emerald-300 hover:bg-white hover:text-emerald-700 hover:shadow-[0_8px_20px_rgba(16,185,129,0.2)] ease-out hover:translate-x-1' }} ">
                        <div class="flex items-center space-x-2.5 min-w-0">
                            <span
                                class="w-7 h-7 stroke-[2] rounded-tl-lg rounded-tr rounded-bl rounded-br-lg  shadow-md  {{ request()->routeIs('realisasi.*') ? 'bg-white/15 border-white/30' : 'bg-white text-emerald-700 border border-slate-300' }} flex items-center justify-center text-sm shrink-0 transition">
                                📈
                            </span>
                            <span class="sidebar-text truncate">Realisasi (LRA)</span>
                        </div>
                        @if (request()->routeIs('realisasi.*'))
                        <span class="sidebar-text w-2 h-2 rounded-full bg-white animate-pulse shrink-0"></span>
                        @else
                        <span class="sidebar-text text-slate-300 text-sm">›</span>
                        @endif
                    </a>
                </div>

                <!-- KELOMPOK: DOKUMEN PENERIMAAN -->
                <div :class="sidebarOpen ? 'p-3' : 'p-1.5'"
                    class="sidebar-card bg-white rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl border border-slate-300/80 shadow-[0_1px_2px_rgba(0,0,0,0.1),0_12px_24px_-4px_rgba(30,58,138,0.12)] space-y-1 transition-all duration-300">
                    <div
                        class="sidebar-text pl-3.5 pr-2 pt-3 pb-1 text-[11px] font-bold tracking-wider text-slate-400 uppercase"
                        :class="{ 'hidden': !sidebarOpen }">
                        Dokumen Penerimaan
                    </div>

                    <a href="#" x-show="filterMenu('STBP')" title="STBP"
                        class="sidebar-link flex items-center justify-between px-2.5 py-2 transition-all duration-200 font-semibold text-sm {{ request()->routeIs('stbp.*') ? 'bg-emerald-800 text-white rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl shadow-md shadow-emerald-700/30' : 'text-slate-600 border border-transparent rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl hover:border-emerald-300 hover:bg-white hover:text-emerald-700 hover:shadow-[0_8px_20px_rgba(16,185,129,0.2)] ease-out hover:translate-x-1' }}">
                        <div class="flex items-center space-x-2.5 min-w-0">
                            <span
                                class="w-7 h-7 stroke[2] rounded-tl-lg rounded-tr rounded-bl rounded-br-lg border border-slate-300 shadow-md bg-white text-emerald-700 flex items-center justify-center text-sm shrink-0">
                                📂
                            </span>
                            <span class="sidebar-text truncate">STBP</span>
                        </div>
                        <span class="sidebar-text text-slate-300 text-sm">›</span>
                    </a>

                    <a href="#" x-show="filterMenu('STS')" title="STS"
                        class="sidebar-link flex items-center justify-between px-2.5 py-2 transition-all duration-200 font-semibold text-sm {{ request()->routeIs('sts.*') ? 'bg-emerald-800 text-white rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl shadow-md shadow-emerald-700/30' : 'text-slate-600 border border-transparent rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl hover:border-emerald-300 hover:bg-white hover:text-emerald-700 hover:shadow-[0_8px_20px_rgba(16,185,129,0.2)] ease-out hover:translate-x-1' }}">
                        <div class="flex items-center space-x-2.5 min-w-0">
                            <span
                                class="w-7 h-7 rounded-tl-lg rounded-tr rounded-bl rounded-br-lg border border-slate-300 shadow-md bg-white text-emerald-700 flex items-center justify-center text-sm shrink-0">
                                🏦
                            </span>
                            <span class="sidebar-text truncate">STS</span>
                        </div>
                        <span class="sidebar-text text-slate-300 text-sm">›</span>
                    </a>
                </div>

                <!-- KELOMPOK: LAPORAN KAS -->
                <div :class="sidebarOpen ? 'p-3' : 'p-1.5'"
                    class="sidebar-card bg-white rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl border border-slate-300/80 shadow-[0_1px_2px_rgba(0,0,0,0.1),0_12px_24px_-4px_rgba(30,58,138,0.12)] space-y-1 transition-all duration-300">

                    <!-- BERUBAH: Mengganti px-2.5 pt-0.5 menjadi pl-3.5 pr-2 pt-3 agar tinggi atas dan inden kiri sub-header sama persis -->
                    <div class="sidebar-text pl-3.5 pr-2 pt-3 pb-1 text-[11px] font-bold tracking-wider text-slate-400 uppercase"
                        :class="{ 'hidden': !sidebarOpen }">
                        Laporan Kas
                    </div>

                    <!-- BUKU KAS UMUM -->
                    <!-- BERUBAH: Menghapus :class dinamis padding & menyeragamkan langsung ke px-2.5 py-2 serta justify-between -->
                    <a href="#" x-show="filterMenu('Buku Kas Umum')" title="Buku Kas Umum"
                        class="sidebar-link flex items-center justify-between px-2.5 py-2 transition-all duration-200 font-semibold text-sm {{ request()->routeIs('bku.*') ? 'bg-emerald-800 text-white rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl shadow-md shadow-emerald-700/30' : 'text-slate-600 border border-transparent rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl hover:border-emerald-300 hover:bg-white hover:text-emerald-700 hover:shadow-[0_8px_20px_rgba(16,185,129,0.2)] ease-out hover:translate-x-1' }}">
                        <div class="flex items-center space-x-2.5 min-w-0">
                            <!-- BERUBAH: Menyederhanakan class border & shadow menjadi border border-slate-300 shadow-md bg-emerald-50 text-emerald-700 -->
                            <span class="w-7 h-7 rounded-tl-lg rounded-tr rounded-bl rounded-br-lg border border-slate-300 shadow-md bg-white text-emerald-700 flex items-center justify-center text-sm shrink-0">
                                📖
                            </span>
                            <!-- BERUBAH: Menghapus :class="{ 'hidden': !sidebarOpen }" agar mengandalkan class .sidebar-text bawaan -->
                            <span class="sidebar-text truncate">Buku Kas Umum</span>
                        </div>
                        <!-- BERUBAH: Menghapus :class="{ 'hidden': !sidebarOpen }" -->
                        <span class="sidebar-text text-slate-300 text-sm">›</span>
                    </a>

                    <!-- LPJ FUNGSIONAL -->
                    <!-- BERUBAH: Menghapus :class dinamis padding & menyeragamkan langsung ke px-2.5 py-2 serta justify-between -->
                    <a href="#" x-show="filterMenu('LPJ Fungsional')" title="LPJ Fungsional"
                        class="sidebar-link flex items-center justify-between px-2.5 py-2 transition-all duration-200 font-semibold text-sm {{ request()->routeIs('lpj.*') ? 'bg-emerald-800 text-white rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl shadow-md shadow-emerald-700/30' : 'text-slate-600 border border-transparent rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl hover:border-emerald-300 hover:bg-white hover:text-emerald-700 hover:shadow-[0_8px_20px_rgba(16,185,129,0.2)] ease-out hover:translate-x-1' }}">
                        <div class="flex items-center space-x-2.5 min-w-0">
                            <!-- BERUBAH: Menyederhanakan class border & shadow menjadi border border-slate-300 shadow-md bg-emerald-50 text-emerald-700 -->
                            <span class="w-7 h-7 rounded-tl-lg rounded-tr rounded-bl rounded-br-lg border border-slate-300 shadow-md bg-white text-emerald-700 flex items-center justify-center text-sm shrink-0">
                                🗂️
                            </span>
                            <!-- BERUBAH: Menghapus :class="{ 'hidden': !sidebarOpen }" -->
                            <span class="sidebar-text truncate">LPJ Fungsional</span>
                        </div>
                        <!-- BERUBAH: Menghapus :class="{ 'hidden': !sidebarOpen }" -->
                        <span class="sidebar-text text-slate-300 text-sm">›</span>
                    </a>
                </div>

            </nav>

            <!-- TOMBOL KELUAR -->
            <div class="pt-2 mt-auto">
                <div
                    class="sidebar-card bg-white rounded-tl-2xl rounded-tr rounded-bl rounded-br-2xl border border-rose-100/60 p-2 transition-all duration-300 ease-out hover:translate-x-1">
                    <button type="button" @click="$dispatch('trigger-logout')" title="Keluar"
                        class="sidebar-link w-full flex items-center space-x-2.5 px-2.5 py-1.5 rounded-tr rounded-bl rounded-br-2xl rounded-tl-2xl text-rose-600 border border-transparent hover:border-rose-200 hover:bg-rose-50/50 hover:shadow-[0_8px_20px_rgba(244,63,94,0.15)] font-bold text-sm transition-all duration-200">
                        <span
                            class="w-7 h-7 rounded-tl-lg rounded-tr rounded-bl rounded-br-lg bg-white shadow-md  text-rose-600 flex items-center justify-center text-sm shrink-0 border border-rose-100">
                            🚪
                        </span>
                        <span class="sidebar-text truncate">Keluar</span>
                    </button>
                </div>
            </div>
        </aside>

        <!-- AREA KONTEN UTAMA -->
        <main class="flex-1 min-w-0 flex flex-col h-screen overflow-y-auto">

            <!-- HEADER TOPSIDE -->
            <header x-data="{
                open: false,
                greeting: '',
                icon: '',
                displayText: '',
                fullText: '',
                textIndex: 0,
                typeIndex: 0,
                isDeleting: false,
                userName: '{{ Auth::user()->name }}',

                getGreeting() {
                    const hour = new Date().getHours();
                    if (hour >= 5 && hour < 11) {
                        this.icon = '☀️';
                        return 'Selamat Pagi';
                    } else if (hour >= 11 && hour < 15) {
                        this.icon = '🌤️';
                        return 'Selamat Siang';
                    } else if (hour >= 15 && hour < 18) {
                        this.icon = '🌇';
                        return 'Selamat Sore';
                    } else {
                        this.icon = '🌙';
                        return 'Selamat Malam';
                    }
                },

                typeLoop() {
                    this.greeting = this.getGreeting();

                    const phrases = [
                        `${this.greeting}, ${this.userName}!`,
                        'Sistem Informasi Bendahara Penerimaan'
                    ];

                    const currentPhrase = phrases[this.textIndex % phrases.length];

                    if (this.isDeleting) {
                        this.displayText = currentPhrase.substring(0, this.typeIndex - 1);
                        this.typeIndex--;
                    } else {
                        this.displayText = currentPhrase.substring(0, this.typeIndex + 1);
                        this.typeIndex++;
                    }

                    let typeSpeed = this.isDeleting ? 25 : 45;

                    if (!this.isDeleting && this.displayText === currentPhrase) {
                        typeSpeed = 3000;
                        this.isDeleting = true;
                    } else if (this.isDeleting && this.displayText === '') {
                        this.isDeleting = false;
                        this.textIndex++;
                        typeSpeed = 400;
                    }

                    setTimeout(() => this.typeLoop(), typeSpeed);
                }
            }" x-init="typeLoop()"
                class="bg-white shadow-sm border-b border-slate-200/80 px-6 py-3 flex items-center justify-between sticky top-0 z-20">

                <div class="flex items-center gap-2.5 min-h-[32px]">
                    <span x-text="icon" class="text-xl animate-bounce"></span>
                    <h2 class="font-bold text-base tracking-tight flex items-center">
                        <span x-text="displayText" class="text-emerald-950 font-black"></span>
                        <span class="inline-block w-0.5 h-4 bg-emerald-600 ml-1 animate-pulse"></span>
                    </h2>
                </div>

                <div class="flex items-center space-x-4 sm:space-x-6 flex-shrink-0">
                    <div class="flex items-center space-x-6">
                        <div class="text-sm text-slate-500 font-medium hidden sm:block">
                            Tahun Anggaran: <span
                                class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-md font-bold">2026</span>
                        </div>

                        <div class="relative">
                            <button @click="open = !open" @click.outside="open = false"
                                class="inline-flex items-center px-3 py-2 border border-slate-200 text-sm sm:text-sm leading-4 font-semibold rounded-xl text-slate-700 bg-white hover:bg-slate-50 focus:outline-none transition duration-150 shadow-sm">
                                <div class="mr-1 font-bold text-emerald-950">{{ Auth::user()->name }}</div>
                                <svg class="fill-current h-4 w-4 text-slate-400 transition-transform duration-200"
                                    :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 rounded-xl shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 border border-slate-100 z-30"
                                style="display: none;">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-sm text-slate-400">Masuk sebagai:</p>
                                    <p class="text-sm font-bold text-slate-700 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}"
                                    class="block w-full px-4 py-2 text-left text-sm leading-5 text-slate-700 hover:bg-slate-50 focus:outline-none transition duration-150 ease-in-out">
                                    👤 Pengaturan Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="button" @click="$dispatch('trigger-logout')"
                                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-rose-600 hover:bg-rose-50 focus:outline-none transition duration-150 ease-in-out border-t border-slate-100 mt-1">
                                        🚪 Keluar Sistem
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- KONTEN HALAMAN -->
            <div class="p-3 sm:p-4 flex-1 w-full min-w-0">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- MODAL LOGOUT POPUP -->
    <div x-data="{ isLoggingOut: false }"
        @trigger-logout.window="isLoggingOut = true; setTimeout(() => document.getElementById('logout-form').submit(), 600)"
        x-show="isLoggingOut" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/65 backdrop-blur-sm"
        style="display: none;">
        <div
            class="bg-white p-6 rounded-2xl shadow-2xl flex flex-col items-center space-y-4 max-w-xs mx-4 border border-slate-100">
            <div class="relative flex items-center justify-center">
                <svg class="animate-spin h-12 w-12 text-rose-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#e2e8f0"
                        stroke-width="4"></circle>
                    <path class="opacity-100" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="absolute text-sm">🚪</span>
            </div>
            <div class="text-center">
                <h3 class="text-sm font-bold text-slate-900 tracking-wide">Keluar dari Sistem...</h3>
                <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">Sistem sedang mengamankan sesi dan
                    membersihkan data login Anda.</p>
            </div>
        </div>
    </div>

    <!-- SCRIPT SIDEBAR TOGGLE -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnToggle = document.getElementById('btn-toggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarHeader = document.getElementById('sidebar-header');
            const sidebarBrandWrapper = sidebarHeader.querySelector('.flex.items-center');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const sidebarCards = document.querySelectorAll('.sidebar-card');
            const sidebarLinks = document.querySelectorAll('.sidebar-link');

            btnToggle.addEventListener('click', function() {
                const isFullWidth = sidebar.classList.contains('w-72');

                if (isFullWidth) {
                    sidebar.classList.remove('w-72', 'p-3');
                    sidebar.classList.add('w-20', 'p-2');

                    if (sidebarBrandWrapper) {
                        sidebarBrandWrapper.classList.add('hidden');
                    }

                    sidebarHeader.classList.remove('justify-between', 'p-2.5');
                    sidebarHeader.classList.add('justify-center', 'p-1.5');

                    sidebarCards.forEach(el => {
                        el.classList.remove('p-2');
                        el.classList.add('p-1', 'flex', 'flex-col', 'items-center');
                    });

                    sidebarLinks.forEach(el => {
                        el.classList.remove('justify-between', 'px-2.5');
                        el.classList.add('justify-center', 'px-1', 'w-full');
                    });

                    sidebarTexts.forEach(el => el.classList.add('hidden'));
                } else {
                    sidebar.classList.remove('w-20', 'p-2');
                    sidebar.classList.add('w-72', 'p-3');

                    if (sidebarBrandWrapper) {
                        sidebarBrandWrapper.classList.remove('hidden');
                    }

                    sidebarHeader.classList.remove('justify-center', 'p-1.5');
                    sidebarHeader.classList.add('justify-between', 'p-2.5');

                    sidebarCards.forEach(el => {
                        el.classList.remove('p-1', 'flex', 'flex-col', 'items-center');
                        el.classList.add('p-2');
                    });

                    sidebarLinks.forEach(el => {
                        el.classList.remove('justify-center', 'px-1');
                        el.classList.add('justify-between', 'px-2.5');
                    });

                    sidebarTexts.forEach(el => el.classList.remove('hidden'));
                }
            });
        });
    </script>
</body>

</html>
