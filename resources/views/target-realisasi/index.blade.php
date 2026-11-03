<x-app-layout>
    <x-slot name="header">
        Laporan Target & Realisasi Pendapatan
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Header & Filter Tahun -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-emerald-100">
                <div>
                    <h2 class="text-xl font-bold text-emerald-950">Target vs Realisasi PAD DLH</h2>
                    <p class="text-sm text-gray-600 mt-1">Rekapitulasi pencapaian pendapatan daerah berdasarkan register transaksi harian.</p>
                </div>

                <form method="GET" action="{{ route('target-realisasi.index') }}" class="flex items-center space-x-3">
                    <label for="tahun" class="text-sm font-semibold text-emerald-950">Tahun:</label>
                    <select name="tahun" id="tahun" onchange="this.form.submit()" class="border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-sm font-bold text-emerald-900">
                        @for ($t = date('Y'); $t >= date('Y') - 4; $t--)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endfor
                    </select>
                </form>
            </div>

            <!-- Card Summary Kategori (Bagian Ringkasan Uraian Bawah) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $totalTargetSemua = 0;
                    $totalRealisasiSemua = 0;
                @endphp

                @foreach($rekapData->groupBy('kategori') as $kategori => $group)
                    @php
                        $targetKategori = $group->sum('total_target');
                        $realisasiKategori = $group->sum('total_realisasi');
                        $persenKategori = $targetKategori > 0 ? ($realisasiKategori / $targetKategori) * 100 : 0;

                        $totalTargetSemua += $targetKategori;
                        $totalRealisasiSemua += $realisasiKategori;
                    @endphp

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                                {{ $kategori }}
                            </span>
                            <div class="mt-4 flex items-baseline justify-between">
                                <span class="text-2xl font-black text-emerald-950">Rp {{ number_format($realisasiKategori, 0, ',', '.') }}</span>
                                <span class="text-sm font-extrabold {{ $persenKategori >= 100 ? 'text-emerald-600' : ($persenKategori >= 50 ? 'text-amber-600' : 'text-rose-600') }}">
                                    {{ number_format($persenKategori, 2, ',', '.') }}%
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Target: Rp {{ number_format($targetKategori, 0, ',', '.') }}</p>
                        </div>

                        <!-- Progress Bar Visual -->
                        <div class="w-full bg-gray-100 rounded-full h-2.5 mt-4 overflow-hidden">
                            <div class="h-2.5 rounded-full {{ $persenKategori >= 100 ? 'bg-emerald-500' : ($persenKategori >= 50 ? 'bg-amber-500' : 'bg-rose-500') }}"
                                 style="width: {{ min($persenKategori, 100) }}%"></div>
                        </div>
                    </div>
                @endforeach

                <!-- Card Total Keseluruhan PAD -->
                @php
                    $persenTotalSemua = $totalTargetSemua > 0 ? ($totalRealisasiSemua / $totalTargetSemua) * 100 : 0;
                @endphp
                <div class="bg-emerald-900 text-white p-6 rounded-2xl shadow-md flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-200 bg-emerald-800 px-3 py-1 rounded-full">
                            TOTAL CAPAIAN PAD (DLH)
                        </span>
                        <div class="mt-4 flex items-baseline justify-between">
                            <span class="text-2xl font-black text-white">Rp {{ number_format($totalRealisasiSemua, 0, ',', '.') }}</span>
                            <span class="text-sm font-extrabold text-emerald-300">
                                {{ number_format($persenTotalSemua, 2, ',', '.') }}%
                            </span>
                        </div>
                        <p class="text-xs text-emerald-200 mt-1">Target Total: Rp {{ number_format($totalTargetSemua, 0, ',', '.') }}</p>
                    </div>

                    <div class="w-full bg-emerald-800 rounded-full h-2.5 mt-4 overflow-hidden">
                        <div class="h-2.5 rounded-full bg-emerald-400" style="width: {{ min($persenTotalSemua, 100) }}%"></div>
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
                                @foreach($rekapData as $item)
                                    <th colspan="3" class="px-4 py-2 border-r border-emerald-200 text-center bg-emerald-100/50">
                                        {{ $item['nama_objek'] }}
                                    </th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($rekapData as $item)
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
                                    9 => 'SEPTEMBER', 10 => 'OKTOBER', 11 => 'NOPEMBER', 12 => 'DESEMBER'
                                ];
                            @endphp

                            @for ($b = 1; $b <= 12; $b++)
                                <tr class="hover:bg-emerald-50/30 transition">
                                    <td class="px-4 py-2.5 font-bold text-emerald-950 border-r border-gray-200">
                                        {{ $namaBulan[$b] }}
                                    </td>
                                    @foreach($rekapData as $item)
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
                                @foreach($rekapData as $item)
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
