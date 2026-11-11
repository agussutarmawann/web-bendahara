<x-app-layout>
    <x-slot name="header">
        Laporan Realisasi Anggaran (LRA)
    </x-slot>

    <div class="pt-0 pb-3">
        <div class="w-full space-y-4">

            <!-- FILTER TAHUN ANGGARAN & CETAK -->
            <div class="p-3.5 bg-white shadow-sm border border-emerald-100 rounded-xl flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h2 class="text-sm font-bold text-emerald-950 tracking-tight">
                        Rincian Laporan Realisasi Anggaran (LRA)
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Format resmi LRA Pendapatan berdasarkan klasifikasi Kode Rekening SIPD.
                    </p>
                </div>

                <form method="GET" action="{{ route('realisasi.index') }}" class="flex items-center gap-3">
                    <label for="tahun" class="text-xs font-bold text-emerald-950 uppercase tracking-wider">Tahun Anggaran:</label>
                    <select name="tahun" id="tahun" onchange="this.form.submit()" class="border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl shadow-sm text-xs font-bold text-emerald-950 px-3 py-1.5 bg-emerald-50/50">
                        @for($year = date('Y') - 2; $year <= date('Y') + 2; $year++)
                            <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>

                    <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-xl shadow-sm transition">
                        🖨️ Cetak LRA
                    </button>
                </form>
            </div>

            <!-- TABEL LRA BERJENJANG KODE REKENING -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 space-y-5">

                <!-- KOP LAPORAN SIPD -->
                <div class="text-center space-y-1 pb-4 border-b border-gray-200">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-700">PEMERINTAH KABUPATEN BULELENG</h3>
                    <h2 class="text-sm font-black uppercase tracking-wide text-emerald-950">RINCIAN LAPORAN REALISASI ANGGARAN PENDAPATAN DAN BELANJA DAERAH</h2>
                    <p class="text-xs font-bold text-gray-600">2.11.0.00.0.00.01.0000. - DINAS LINGKUNGAN HIDUP</p>
                    <p class="text-xs font-black text-emerald-800">TAHUN ANGGARAN {{ $tahun }}</p>
                </div>

                <!-- TABEL RINCIAN -->
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left text-gray-800 border-collapse border border-gray-300">
                        <thead class="bg-emerald-50/90 text-emerald-950 font-bold uppercase text-center border-b border-gray-300">
                            <tr>
                                <th class="px-3 py-2.5 border border-gray-300 w-36">Kode Rekening</th>
                                <th class="px-4 py-2.5 border border-gray-300">Uraian</th>
                                <th class="px-3 py-2.5 border border-gray-300 text-right w-44">Anggaran (Rp)</th>
                                <th class="px-3 py-2.5 border border-gray-300 text-right w-44">Realisasi (Rp)</th>
                                <th class="px-3 py-2.5 border border-gray-300 text-right w-44">Sisa Anggaran (Rp)</th>
                                <th class="px-3 py-2.5 border border-gray-300 text-center w-24">Persentase (%)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 font-mono">

                            <!-- LEVEL 1: AKUN 4 -->
                            <tr class="font-black bg-emerald-100/60 text-emerald-950">
                                <td class="px-3 py-2 border border-gray-300">4</td>
                                <td class="px-3 py-2 border border-gray-300 font-sans">PENDAPATAN DAERAH</td>
                                <td class="px-3 py-2 border border-gray-300 text-right">{{ number_format($totalTargetSemua, 2, ',', '.') }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-right">{{ number_format($totalRealisasiSemua, 2, ',', '.') }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-right">{{ number_format($totalTargetSemua - $totalRealisasiSemua, 2, ',', '.') }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-center">{{ number_format($totalTargetSemua > 0 ? ($totalRealisasiSemua / $totalTargetSemua) * 100 : 0, 2, ',', '.') }}%</td>
                            </tr>

                            <!-- LEVEL 2: AKUN 4.1 -->
                            <tr class="font-bold bg-emerald-50/40">
                                <td class="px-3 py-2 border border-gray-300">4.1</td>
                                <td class="px-3 py-2 border border-gray-300 font-sans pl-6">PENDAPATAN ASLI DAERAH</td>
                                <td class="px-3 py-2 border border-gray-300 text-right">{{ number_format($totalTargetSemua, 2, ',', '.') }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-right">{{ number_format($totalRealisasiSemua, 2, ',', '.') }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-right">{{ number_format($totalTargetSemua - $totalRealisasiSemua, 2, ',', '.') }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-center">{{ number_format($totalTargetSemua > 0 ? ($totalRealisasiSemua / $totalTargetSemua) * 100 : 0, 2, ',', '.') }}%</td>
                            </tr>

                            <!-- LEVEL 3: AKUN 4.1.02 -->
                            <tr class="font-bold bg-gray-50">
                                <td class="px-3 py-2 border border-gray-300">4.1.02</td>
                                <td class="px-3 py-2 border border-gray-300 font-sans pl-10">RETRIBUSI DAERAH</td>
                                <td class="px-3 py-2 border border-gray-300 text-right">{{ number_format($totalTargetSemua, 2, ',', '.') }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-right">{{ number_format($totalRealisasiSemua, 2, ',', '.') }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-right">{{ number_format($totalTargetSemua - $totalRealisasiSemua, 2, ',', '.') }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-center">{{ number_format($totalTargetSemua > 0 ? ($totalRealisasiSemua / $totalTargetSemua) * 100 : 0, 2, ',', '.') }}%</td>
                            </tr>

                            <!-- RINCIAN OBJEK RETRIBUSI -->
                            @foreach($rekapLra as $item)
                            @php
                                $sisa = $item['target'] - $item['realisasi'];
                                $persen = $item['target'] > 0 ? ($item['realisasi'] / $item['target']) * 100 : 0;
                            @endphp
                            <tr class="hover:bg-emerald-50/30 transition">
                                <td class="px-3 py-2 border border-gray-300 font-semibold">{{ $item['kode_rekening'] }}</td>
                                <td class="px-3 py-2 border border-gray-300 font-sans pl-14">{{ $item['nama_objek'] }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-right">{{ number_format($item['target'], 2, ',', '.') }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-right font-bold text-emerald-950">{{ number_format($item['realisasi'], 2, ',', '.') }}</td>
                                <td class="px-3 py-2 border border-gray-300 text-right {{ $sisa < 0 ? 'text-rose-600 font-bold' : '' }}">
                                    {{ number_format($sisa, 2, ',', '.') }}
                                </td>
                                <td class="px-3 py-2 border border-gray-300 text-center font-bold {{ $persen >= 100 ? 'text-emerald-700' : 'text-amber-600' }}">
                                    {{ number_format($persen, 2, ',', '.') }}%
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
