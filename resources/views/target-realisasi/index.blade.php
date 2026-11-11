<x-app-layout>
    <x-slot name="header">
        Laporan Target & Realisasi Pendapatan
    </x-slot>

    <div class="pt-0 pb-3">
        <div class="max-w-full mx-auto space-y-4">

            <!-- HEADER FILTER DENGAN DESAIN COMPACT & RAPI -->
            <div class="p-5 bg-white shadow-sm border border-emerald-100 rounded-2xl flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-emerald-950 tracking-tight">
                        Target vs Realisasi PAD DLH
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Rekapitulasi pencapaian pendapatan daerah berdasarkan register transaksi harian.
                    </p>
                </div>

                <!-- Form Dropdown Tahun -->
                <form method="GET" action="{{ route('target-realisasi.index') }}" class="flex items-center gap-3 self-end md:self-auto">
                    <label for="tahun" class="text-xs font-bold text-emerald-950 uppercase tracking-wider">
                        Tahun Anggaran:
                    </label>
                    <select name="tahun" id="tahun" onchange="this.form.submit()"
                        class="border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-xs font-bold text-emerald-950 px-3 py-2 bg-emerald-50/50">
                        @for ($y = date('Y') - 2; $y <= date('Y') + 2; $y++)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </form>
            </div>

            @php
                // Hitung akumulasi total terlebih dahulu sebelum rendering HTML
                $totalTargetSemua = $rekapData->sum('total_target');
                $totalRealisasiSemua = $rekapData->sum('total_realisasi');
                $persenTotalSemua = $totalTargetSemua > 0 ? ($totalRealisasiSemua / $totalTargetSemua) * 100 : 0;
            @endphp

            <!-- Card Summary Kategori & Total Capaian (PASTI 3 KOLOM SEJAJAR) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <!-- 1. Card Kategori (Akan Merender 2 Card: Persampahan & Aset Daerah) -->
                @foreach ($rekapData->groupBy('kategori') as $kategori => $group)
                    @php
                        $targetKategori = $group->sum('total_target');
                        $realisasiKategori = $group->sum('total_realisasi');
                        $persenKategori = $targetKategori > 0 ? ($realisasiKategori / $targetKategori) * 100 : 0;
                    @endphp

                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-emerald-100 flex flex-col justify-between hover:shadow-md transition duration-200">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 border border-emerald-100 px-3 py-1 rounded-full inline-block">
                                {{ $kategori }}
                            </span>
                            <div class="mt-4 flex items-baseline justify-between gap-2">
                                <span class="text-xl lg:text-2xl font-black text-emerald-950">
                                    Rp {{ number_format($realisasiKategori, 0, ',', '.') }}
                                </span>
                                <span class="text-xs lg:text-sm font-extrabold font-mono bg-emerald-50 border border-emerald-100 px-3 py-1 rounded-full inline-block {{ $persenKategori >= 100 ? 'text-emerald-600' : ($persenKategori >= 50 ? 'text-amber-600' : 'text-rose-600') }}">
                                    {{ number_format($persenKategori, 2, ',', '.') }}%
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Target: Rp {{ number_format($targetKategori, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Progress Bar Visual -->
                        <div class="w-full bg-gray-100 rounded-full h-2.5 mt-4 overflow-hidden">
                            <div class="h-2.5 rounded-full transition-all duration-500 {{ $persenKategori >= 100 ? 'bg-emerald-500' : ($persenKategori >= 50 ? 'bg-amber-500' : 'bg-rose-500') }}"
                                style="width: {{ min($persenKategori, 100) }}%"></div>
                        </div>
                    </div>
                @endforeach

                <!-- 2. Card Ke-3: Total Keseluruhan PAD -->
                <div class="bg-gradient-to-r from-emerald-800 via-emerald-900 to-emerald-950 p-5 rounded-2xl shadow-lg border border-emerald-700/50 text-white flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-white bg-white/15 border border-white/20 px-3 py-1 rounded-full backdrop-blur-sm inline-block">
                            TOTAL CAPAIAN PAD (DLH)
                        </span>
                        <div class="mt-4 flex items-baseline justify-between gap-2">
                            <span class="text-xl lg:text-2xl font-black text-white">
                                Rp {{ number_format($totalRealisasiSemua, 0, ',', '.') }}
                            </span>
                            <span class="text-xs lg:text-sm font-extrabold font-mono text-emerald-300 border-emerald-100">
                                {{ number_format($persenTotalSemua, 2, ',', '.') }}%
                            </span>
                        </div>
                        <p class="text-xs text-emerald-200 mt-1">
                            Target Total: Rp {{ number_format($totalTargetSemua, 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Progress Bar Total -->
                    <div class="w-full bg-emerald-950/60 rounded-full h-2.5 mt-4 overflow-hidden border border-emerald-700/30">
                        <div class="h-2.5 rounded-full bg-emerald-400 transition-all duration-500"
                            style="width: {{ min($persenTotalSemua, 100) }}%"></div>
                    </div>
                </div>

            </div>

            <!-- Tabel Matriks Bulanan Sesuai Format Spreadsheet -->
            <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden">
                <div class="p-6 border-b border-emerald-50">
                    <h3 class="text-base font-bold text-emerald-950">Rekapitulasi Bulanan Per Objek Retribusi</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left text-gray-700 border-collapse">
                        <!-- Head Tabel Bertingkat -->
                        <thead class="text-xs font-bold uppercase bg-emerald-50/70 text-emerald-950 border-b border-emerald-200">
                            <tr>
                                <th rowspan="2" class="px-4 py-3 border-r border-emerald-200 text-center min-w-[100px]">Bulan</th>
                                @foreach ($rekapData as $item)
                                    <th colspan="3" class="px-4 py-2 border-r border-emerald-200 text-center bg-emerald-100/50">
                                        {{ $item['nama_objek'] }}
                                    </th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($rekapData as $item)
                                    <th class="px-3 py-2 border-r border-emerald-200 text-right font-semibold">Target</th>
                                    <th class="px-3 py-2 border-r border-emerald-200 text-right font-semibold">Realisasi</th>
                                    <th class="px-3 py-2 border-r border-emerald-200 text-center font-semibold">%</th>
                                @endforeach
                            </tr>
                        </thead>

                        <!-- Body Bulanan (Januari - Desember) -->
                        <tbody class="divide-y divide-gray-100">
                            @php
                                $namaBulan = [
                                    1 => 'JANUARI', 2 => 'FEBRUARI', 3 => 'MARET', 4 => 'APRIL',
                                    5 => 'MEI', 6 => 'JUNI', 7 => 'JULI', 8 => 'AGUSTUS',
                                    9 => 'SEPTEMBER', 10 => 'OKTOBER', 11 => 'NOPEMBER', 12 => 'DESEMBER',
                                ];
                            @endphp

                            @for ($b = 1; $b <= 12; $b++)
                                <tr class="hover:bg-emerald-50/30 transition">
                                    <td class="px-4 py-2.5 font-bold text-emerald-950 border-r border-gray-200">
                                        {{ $namaBulan[$b] }}
                                    </td>
                                    @foreach ($rekapData as $item)
                                        @php
                                            $t = $item['bulanan'][$b]['target'];
                                            $r = $item['bulanan'][$b]['realisasi'];
                                            $p = $item['bulanan'][$b]['persen'];
                                        @endphp
                                        <td class="px-3 py-2.5 text-right border-r border-gray-100">
                                            {{ $t > 0 ? number_format($t, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-3 py-2.5 text-right font-medium border-r border-gray-100 {{ $r > 0 ? 'text-emerald-950' : 'text-gray-400' }}">
                                            {{ $r > 0 ? number_format($r, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-3 py-2.5 text-center border-r border-gray-200 font-bold {{ $p >= 100 ? 'text-emerald-700' : ($p > 0 ? 'text-amber-600' : 'text-gray-400') }}">
                                            {{ $p > 0 ? number_format($p, 2, ',', '.') . '%' : '0,00%' }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endfor
                        </tbody>

                        <!-- Footer Total Jumlah -->
                        <tfoot class="bg-emerald-100/70 font-black text-emerald-950 border-t-2 border-emerald-300">
                            <tr>
                                <td class="px-4 py-3 border-r border-emerald-300 text-center uppercase">JUMLAH</td>
                                @foreach ($rekapData as $item)
                                    <td class="px-3 py-3 text-right border-r border-emerald-200">
                                        {{ number_format($item['total_target'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-3 text-right border-r border-emerald-200 text-emerald-900">
                                        {{ number_format($item['total_realisasi'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-3 text-center border-r border-emerald-300 text-emerald-800">
                                        {{ number_format($item['total_persen'], 2, ',', '.') }}%
                                    </td>
                                @endforeach
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
