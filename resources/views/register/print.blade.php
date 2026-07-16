<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Register Pendapatan - {{ $bulanTeks }} {{ $tahunAktif }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; line-height: 1.4; padding: 20px; }
        .kop-surat { text-align: center; margin-bottom: 20px; border-bottom: 3px double #000; padding-bottom: 10px; }
        .kop-surat h2 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .kop-surat h3 { margin: 5px 0 0 0; font-size: 14px; text-transform: uppercase; font-weight: normal; }
        .judul-laporan { text-align: center; font-weight: bold; font-size: 13px; text-transform: uppercase; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; }
        th { padding: 8px; background-color: #f2f2f2; font-weight: bold; text-align: center; }
        td { padding: 6px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .ttd-container { width: 100%; margin-top: 40px; display: flex; justify-content: space-between; page-break-inside: avoid; }
        .ttd-box { width: 200px; text-align: center; }
        .ttd-space { height: 70px; }
        
        /* CSS khusus saat printer aktif */
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; background: #e2e8f0; padding: 10px; border-radius: 8px; display: flex; gap: 10px;">
        <button onclick="window.print()" style="background: #047857; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-weight: bold;">🖨️ Cetak Sekarang</button>
        <a href="{{ route('register.index', ['bulan' => $bulanAktif, 'tahun' => $tahunAktif]) }}" style="background: #475569; color: white; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 12px;">⬅️ Kembali ke Aplikasi</a>
    </div>

    <div class="kop-surat">
        <h2>DINAS LINGKUNGAN HIDUP</h2>
        <h3>PEMERINTAH KABUPATEN / KOTA SIBEN</h3>
    </div>

    <div class="judul-laporan">
        REGISTER PENDAPATAN HARIAN BENDAHARA PENERIMAAN<br>
        PERIODE BULAN: {{ $bulanTeks }} {{ $tahunAktif }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="25%">Wajib Retribusi / Pembayar</th>
                <th width="25%">Kategori</th>
                <th width="18%">Nomor STBP</th>
                <th width="15%">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registers as $index => $data)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $data->wajib_retribusi }}</td>
                    <td>{{ $data->kategori }}</td>
                    <td class="text-center font-bold">{{ $data->nomor_stbp ?? '-' }}</td>
                    <td class="text-right">{{ number_format($data->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="font-style: italic;">Tidak ada data transaksi pada periode ini.</td>
                </tr>
            @endforelse
            <tr class="font-bold" style="background-color: #f9f9f9;">
                <td colspan="5" class="text-right">TOTAL PENDAPATAN BULANAN:</td>
                <td class="text-right">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="width: 350px; margin-top: 20px; page-break-inside: avoid;">
        <p class="font-bold" style="margin-bottom: 5px;">Rekapitulasi Nominal Per Kategori:</p>
        <table>
            <tr>
                <td>🗑️ Pelayanan Persampahan</td>
                <td class="text-right font-bold">Rp {{ number_format($totalSampah, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>🏢 Pemanfaatan Aset Daerah</td>
                <td class="text-right font-bold">Rp {{ number_format($totalAset, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>🚰 Retribusi PDAM</td>
                <td class="text-right font-bold">Rp {{ number_format($totalPdam, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>🚛 Retribusi Pelayanan TPA</td>
                <td class="text-right font-bold">Rp {{ number_format($totalTpa, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="ttd-container">
        <div class="ttd-box">
            <p>Mengetahui,<br>Kepala Dinas Lingkungan Hidup</p>
            <div class="ttd-space"></div>
            <p class="font-bold" style="text-decoration: underline;"><u>I Gede Putra Aryana, S.Sos, M.A.P</u></p>
            <p style="margin-top: -10px;">NIP. 197005151993031010</p>
        </div>
        
        <div class="ttd-box">
            <p>Buleleng, {{ date('d') }} {{ $bulanTeks }} {{ $tahunAktif }}<br>Bendahara Penerimaan</p>
            <div class="ttd-space"></div>
            <p class="font-bold" style="text-decoration: underline;">Nyoman Riani</p>
            <p style="margin-top: -10px;">NIP. 196901112007012022</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>