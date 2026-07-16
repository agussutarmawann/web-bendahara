<x-app-layout>
    <x-slot name="header">
        Register Pendapatan
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto px-8">

            <div class="mb-6">
                <a href="{{ route('register.index') }}" class="inline-flex items-center text-sm font-semibold text-emerald-700 hover:text-emerald-900 transition">
                    ⬅️ Kembali ke Tabel Register
                </a>
            </div>

            <div class="p-6 sm:p-8 bg-white shadow-sm border border-emerald-100 sm:rounded-2xl max-w-2xl">

                <header class="mb-6">
                    <h3 class="text-lg font-bold text-emerald-950">
                        {{ __('Formulir Pendapatan Harian') }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Silakan lengkapi data transaksi di bawah ini. Nomor STBP akan divalidasi agar tidak ganda.
                    </p>
                </header>

                <div x-data="{ isSaving: false }">
                    <form action="{{ route('register.store') }}" method="POST" @submit="isSaving = true" class="space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="tanggal" :value="__('Tanggal Transaksi')" class="text-emerald-950 font-semibold" />
                            <x-text-input id="tanggal" name="tanggal" type="date"
                                class="mt-1 block w-full"
                                :value="old('tanggal', date('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal')" />
                        </div>

                        <div>
                            <x-input-label for="wajib_retribusi" :value="__('Wajib Retribusi / Pembayar')" class="text-emerald-950 font-semibold" />
                            <x-text-input id="wajib_retribusi" name="wajib_retribusi" type="text"
                                class="mt-1 block w-full"
                                :value="old('wajib_retribusi')" required placeholder="Masukkan nama pembayar..." autocomplete="off" />
                            <x-input-error class="mt-2" :messages="$errors->get('wajib_retribusi')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="kategori" :value="__('Kategori Retribusi')" class="text-emerald-950 font-semibold" />
                                <select id="kategori" name="kategori" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm" required>
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    <option value="Pelayanan Persampahan" {{ old('kategori') == 'Pelayanan Persampahan' ? 'selected' : '' }}>🗑️ Pelayanan Persampahan</option>
                                    <option value="Pemanfaatan Aset Daerah" {{ old('kategori') == 'Pemanfaatan Aset Daerah' ? 'selected' : '' }}>🏢 Pemanfaatan Aset Daerah</option>
                                    <option value="PDAM" {{ old('kategori') == 'PDAM' ? 'selected' : '' }}>🚰 PDAM</option>
                                    <option value="TPA" {{ old('kategori') == 'TPA' ? 'selected' : '' }}>🚛 TPA</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('kategori')" />
                            </div>

                            <div>
                                <x-input-label for="jenis_penetapan" :value="__('Sifat Pembayaran')" class="text-emerald-950 font-semibold" />
                                <select id="jenis_penetapan" name="jenis_penetapan" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm" required>
                                    <option value="tanpa_penetapan" {{ old('jenis_penetapan') == 'tanpa_penetapan' ? 'selected' : '' }}>Tanpa Penetapan (Langsung)</option>
                                    <option value="penetapan" {{ old('jenis_penetapan') == 'penetapan' ? 'selected' : '' }}>Dengan Penetapan (SKP)</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('jenis_penetapan')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="nomor_stbp" :value="__('Nomor STBP (Otomatis)')" class="text-emerald-950 font-semibold" />
                            <input id="nomor_stbp" name="nomor_stbp" type="text"
                                class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm bg-emerald-50/50 border-emerald-100 text-emerald-900 font-mono font-bold"
                                value="{{ old('nomor_stbp', $nomorStbpOtomatis) }}" readonly required />
                            <p class="text-xs text-emerald-700 mt-1">Nomor ini dibuat otomatis oleh sistem untuk menjaga urutan penomoran tetap rapi.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('nomor_stbp')" />
                        </div>
                        <div>
                            <x-input-label for="jumlah" :value="__('Jumlah Pembayaran (Rp)')" class="text-emerald-950 font-semibold" />
                            <x-text-input id="jumlah" name="jumlah" type="number" step="0.01"
                                class="mt-1 block w-full font-bold text-emerald-950"
                                :value="old('jumlah')" required placeholder="Masukkan nominal angka saja, misal: 150000" />
                            <x-input-error class="mt-2" :messages="$errors->get('jumlah')" />
                        </div>
                        <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-xl">
                            Simpan Data
                        </button>
                    </form>
                    <div x-show="isSaving"
                        x-transition.opacity
                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/65 backdrop-blur-sm"
                        style="display: none;">

                        <div class="bg-white p-6 rounded-2xl shadow-2xl flex flex-col items-center space-y-4 max-w-xs mx-4 border border-gray-100">
                            <div class="relative flex items-center justify-center">
                                <svg class="animate-spin h-12 w-12 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#e2e8f0" stroke-width="4"></circle>
                                    <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="absolute text-sm">💾</span>
                            </div>
                            <div class="text-center">
                                <h3 class="text-sm font-bold text-gray-900 tracking-wide">Menyimpan Data...</h3>
                                <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">Mohon tunggu, sistem sedang merekam transaksi harian ke database.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>