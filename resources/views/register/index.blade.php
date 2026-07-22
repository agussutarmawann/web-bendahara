<x-app-layout>
    <x-slot name="header">
        Register Pendapatan
    </x-slot>

    @if(session('success'))
    <div x-data="{ showSuccess: true }"
        x-show="showSuccess"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm">

        <div x-show="showSuccess"
            x-transition.scale.85
            class="bg-white p-6 rounded-2xl shadow-2xl flex flex-col items-center space-y-4 max-w-xs w-full mx-4 border border-emerald-100 text-center animate-fade-in">

            <div class="h-16 w-16 bg-emerald-50 rounded-full flex items-center justify-center border border-emerald-200 shadow-inner">
                <span class="text-3xl text-emerald-600 animate-bounce">✅</span>
            </div>

            <div>
                <h3 class="text-base font-bold text-gray-900 tracking-wide">
                    {{ Str::contains(session('success'), 'hapus') ? 'Berhasil Dihapus!' : 'Berhasil Disimpan!' }}
                </h3>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                    {{ session('success') }}
                </p>
            </div>

            <div class="w-full pt-2">
                <button @click="showSuccess = false"
                    class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-md transition-all duration-150 tracking-wider uppercase">
                    Mantap, Oke!
                </button>
            </div>
        </div>
    </div>
    @endif

    <div x-data="{ showDeleteModal: false, deleteUrl: '', isDeleting: false }" class="py-8">
        <div class="max-w-full mx-auto px-8 space-y-6">
            
            <div class="p-5 bg-white shadow-sm border border-emerald-100 rounded-2xl flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <form method="GET" action="{{ route('register.index') }}" class="flex items-center gap-3">
                    <label for="bulan" class="text-sm font-semibold text-emerald-950">Pilih Periode:</label>
                    <select name="bulan" id="bulan" onchange="this.form.submit()" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm">
                        @foreach([
                        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                        ] as $key => $namaBulan)
                        <option value="{{ $key }}" {{ $bulanAktif == $key ? 'selected' : '' }}>
                            {{ $namaBulan }}
                        </option>
                        @endforeach
                    </select>

                    <select name="tahun" id="tahun" onchange="this.form.submit()" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm">
                        @for($year = date('Y') - 2; $year <= date('Y') + 2; $year++)
                        <option value="{{ $year }}" {{ $tahunAktif == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                        @endfor
                    </select>

                    <a href="{{ route('register.print', ['bulan' => $bulanAktif, 'tahun' => $tahunAktif]) }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white shadow-sm border border-gray-200 font-medium text-sm rounded-2xl transition hover:bg-gray-50">
                        🖨️ Cetak Laporan
                    </a>
                </form>

                <a href="{{ route('register.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-850 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    ➕ Tambah Transaksi
                </a>
            </div>

            <div class="bg-white shadow-sm border border-emerald-100 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-emerald-950 uppercase bg-emerald-50/50 border-b border-emerald-100">
                            <tr>
                                <th scope="col" class="px-3 py-4 font-bold text-center">Tanggal</th>
                                <th scope="col" class="px-3 py-4 whitespace-nowrap font-bold text-center">Penyetor</th>
                                <th scope="col" class="px-3 py-4 font-bold text-center">Kategori</th>
                                <th scope="col" class="px-3 py-4 font-bold text-center">No. STBP</th>
                                <th scope="col" class="px-3 py-4 font-bold text-center">Pembayaran</th>
                                <th scope="col" class="px-3 py-4 whitespace-nowrap font-bold text-center">Jumlah Uang</th>
                                <th scope="col" class="px-3 py-4 font-bold text-center">STS</th>
                                <th scope="col" class="px-3 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50">
                            @forelse($registers as $data)
                            <tr class="hover:bg-emerald-50/20 transition">
                                <td class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap">
                                    {{ $data->tanggal->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-gray-900 whitespace-nowrap font-medium">
                                    {{ $data->wajib_retribusi }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $data->kategori }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-mono">
                                    {{ $data->nomor_stbp ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($data->jenis_penetapan === 'penetapan')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-emerald-100 text-emerald-800">
                                        Penetapan
                                    </span>
                                    @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-gray-100 text-gray-700">
                                        Tanpa Penetapan
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-emerald-950">
                                    Rp {{ number_format($data->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($data->nomor_sts_link)
                                    <span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full">
                                        ✅ STS: {{ $data->nomor_sts_link }}
                                    </span>
                                    @else
                                    <span class="text-xs font-bold text-yellow-700 bg-yellow-50 border border-yellow-200 px-2.5 py-1 rounded-full">
                                        ⏳ Belum Disetor
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('register.edit', $data->id) }}"
                                        class="inline-flex items-center text-amber-600 hover:text-amber-700 transition-colors">
                                        📝 Edit
                                    </a>
                                    <button type="button"
                                        @click="showDeleteModal = true; deleteUrl = '{{ route('register.destroy', $data->id) }}'; isDeleting = false;"
                                        class="text-rose-600 hover:text-rose-800 transition-colors">
                                        🗑️ Hapus
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-center text-gray-400 font-medium">
                                    Belum ada data transaksi harian di bulan ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-6 pt-4">
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-base font-bold text-emerald-950 uppercase tracking-wider mb-4 flex items-center gap-2">
                        📊 Rekapitulasi Pendapatan Periode Ini
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between transition hover:shadow-md">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Persampahan</p>
                            <h4 class="text-lg font-bold text-emerald-950 mt-1">Rp {{ number_format($totalSampah, 0, ',', '.') }}</h4>
                        </div>
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-xl shadow-inner">🗑️</div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between transition hover:shadow-md">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Aset Daerah</p>
                            <h4 class="text-lg font-bold text-emerald-950 mt-1">Rp {{ number_format($totalAset, 0, ',', '.') }}</h4>
                        </div>
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-xl shadow-inner">🏢</div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between transition hover:shadow-md">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Retribusi PDAM</p>
                            <h4 class="text-lg font-bold text-emerald-950 mt-1">Rp {{ number_format($totalPdam, 0, ',', '.') }}</h4>
                        </div>
                        <div class="w-10 h-10 bg-sky-50 rounded-xl flex items-center justify-center text-xl shadow-inner">🚰</div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between transition hover:shadow-md">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Retribusi TPA</p>
                            <h4 class="text-lg font-bold text-emerald-950 mt-1">Rp {{ number_format($totalTpa, 0, ',', '.') }}</h4>
                        </div>
                        <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-xl shadow-inner">🚛</div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-emerald-800 to-emerald-950 p-6 rounded-2xl shadow-md text-white flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-emerald-300 uppercase tracking-widest">Total Keseluruhan Pendapatan (Bulan Ini)</p>
                        <h2 class="text-3xl font-black mt-1 tracking-tight">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</h2>
                    </div>
                    <div class="text-4xl font-mono select-none font-bold">TOTAL</div>
                </div>
            </div>

        </div>

        <div x-show="showDeleteModal"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm"
            style="display: none;">

            <div @click.away="!isDeleting && (showDeleteModal = false)"
                class="bg-white p-6 rounded-2xl shadow-2xl max-w-sm w-full mx-4 border border-gray-100 text-center animate-fade-in">

                <div x-show="!isDeleting" class="h-14 w-14 bg-rose-50 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 border border-rose-100">
                    <span class="text-2xl">⚠️</span>
                </div>

                <div x-show="isDeleting" class="mx-auto mb-4 flex justify-center">
                    <svg class="animate-spin h-12 w-12 text-rose-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <h3 class="text-base font-bold text-gray-900" x-text="isDeleting ? 'Sedang Menghapus Data...' : 'Hapus Data Transaksi?'"></h3>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed" x-text="isDeleting ? 'Mohon tunggu sebentar, sistem sedang mengeluarkan data dari database SIBEN.' : 'Tindakan ini tidak dapat dibatalkan. Data yang dihapus akan hilang permanen dari sistem SIBEN.'"></p>

                <form :action="deleteUrl" method="POST" @submit="isDeleting = true" class="mt-5 flex space-x-3">
                    @csrf
                    @method('DELETE')
                    
                    <button type="button"
                        x-show="!isDeleting"
                        @click="showDeleteModal = false"
                        class="w-1/2 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl transition-colors">
                        Batal
                    </button>

                    <button type="submit"
                        :class="isDeleting ? 'w-full bg-rose-700 pointer-events-none cursor-not-allowed' : 'w-1/2 bg-rose-600 hover:bg-rose-700'"
                        class="py-2.5 text-white text-xs font-semibold rounded-xl shadow-md transition-colors flex items-center justify-center">
                        <span x-show="!isDeleting">Ya, Hapus!</span>
                        <span x-show="isDeleting">Menghapus...</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>