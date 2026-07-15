<x-app-layout>
    
    <x-slot name="header">
        Ringkasan Dashboard Utama
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">   
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pendapatan</p>
                <h3 class="text-xl font-black text-gray-800 mt-1">Rp 0</h3>
                <p class="text-[10px] text-emerald-600 font-medium mt-1">↑ Diperbarui otomatis</p>
            </div>
            <div class="bg-emerald-100 text-emerald-800 text-2xl p-3 rounded-xl">💵</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Realisasi Berjalan</p>
                <h3 class="text-xl font-black text-gray-800 mt-1">Rp 0</h3>
                <p class="text-[10px] text-gray-500 font-medium mt-1">Target Capaian: 0%</p>
            </div>
            <div class="bg-blue-100 text-blue-800 text-2xl p-3 rounded-xl">🎯</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Saldo BKU</p>
                <h3 class="text-xl font-black text-amber-600 mt-1">Rp 0</h3>
                <p class="text-[10px] text-amber-600 font-medium mt-1">⚠️ Menunggu Validasi Kasubag</p>
            </div>
            <div class="bg-amber-100 text-amber-800 text-2xl p-3 rounded-xl">📖</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Dokumen LPJ</p>
                <h3 class="text-xl font-black text-gray-800 mt-1">0 LPJ</h3>
                <p class="text-[10px] text-gray-500 font-medium mt-1">Bulan Juli 2026</p>
            </div>
            <div class="bg-purple-100 text-purple-800 text-2xl p-3 rounded-xl">🗂️</div>
        </div>
    </div>  
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 text-base mb-2">Pemberitahuan Sistem SIBEN</h3>
        <p class="text-sm text-gray-600 leading-relaxed mb-4">
            Selamat datang di sistem manajemen bendahara. Berikut adalah ketentuan sinkronisasi otomatis yang aktif saat ini:
        </p>
        <ul class="space-y-2 text-xs text-gray-600 pl-4 list-disc font-medium">
            <li>Fitur pengisian <strong class="text-emerald-700">STS (Surat Tanda Setoran)</strong> tidak bisa diakses sebelum dokumen <strong class="text-emerald-700">STBP</strong> diterbitkan.</li>
            <li>Angka saldo pada <strong class="text-emerald-700">Buku Kas Umum (BKU)</strong> akan tetap bernilai <span class="text-red-600 font-bold">Rp 0</span> jika berkas belum divalidasi oleh akun <strong>Kasubag</strong>.</li>
        </ul>
    </div>

</x-app-layout>