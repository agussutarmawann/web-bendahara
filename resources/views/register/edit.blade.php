<x-app-layout>
    <div x-data="{ isSaving: false }">

        <form action="{{ route('register.update', $register->id) }}" method="POST" @submit="isSaving = true" class="space-y-5 max-w-lg mx-auto bg-white p-6 rounded-2xl shadow">
            @csrf
            @method('PUT') <h2 class="text-lg font-bold text-gray-900 border-b pb-2 border-gray-100">Edit Data Pendapatan</h2>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Transaksi</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $register->tanggal ? date_format(date_create($register->tanggal), 'Y-m-d') : '') }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Wajib Retribusi / Pembayar</label>
                <input type="text" name="wajib_retribusi" value="{{ old('wajib_retribusi', $register->wajib_retribusi) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori Retribusi</label>
                <select name="kategori" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="Persampahan" {{ $register->kategori == 'Persampahan' ? 'selected' : '' }}>Persampahan</option>
                    <option value="Aset" {{ $register->kategori == 'Aset' ? 'selected' : '' }}>Aset</option>
                    <option value="TPA" {{ $register->kategori == 'TPA' ? 'selected' : '' }}>TPA</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Pembayaran (Rp)</label>
                <input type="number" name="jumlah" value="{{ old('jumlah', $register->jumlah) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100 mt-6">

                <a href="{{ route('register.index') }}"
                    class="px-5 py-2.5 bg-gray-150 hover:bg-gray-200 text-gray-750 text-xs font-semibold rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Kembali
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm hover:shadow transition-all tracking-wide focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <div x-show="isSaving" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/65 backdrop-blur-sm" style="display: none;">
            <div class="bg-white p-6 rounded-2xl shadow-2xl flex flex-col items-center space-y-4 max-w-xs mx-4 border border-gray-100">
                <svg class="animate-spin h-12 w-12 text-emerald-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#e2e8f0" stroke-width="4"></circle>
                    <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-sm font-bold text-gray-900">Memperbarui Data...</span>
            </div>
        </div>

    </div>
</x-app-layout>