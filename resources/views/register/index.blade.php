<x-app-layout>
    <x-slot name="header">
        Register Pendapatan
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto px-8 space-y-6">

            @if(session('success'))
            <div class="p-4 mb-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 font-semibold" role="alert">
                {{ session('success') }}
            </div>
            @endif

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
                </form>

                <a href="{{ route('register.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-850 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    ➕ Tambah Transaksi Harian
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
                                <th scope="col" class="px-3 py-4 font-bold text-center">Status STS</th>
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
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-400 font-medium">
                                    Belum ada data transaksi harian di bulan ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>