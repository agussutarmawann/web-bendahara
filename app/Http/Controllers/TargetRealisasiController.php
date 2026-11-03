<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\ObjekRetribusi;
use App\Models\TargetRetribusi;
use Illuminate\Http\Request;

class TargetRealisasiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil parameter tahun dari request (default tahun saat ini)
        $tahun = $request->get('tahun', date('Y'));

        // 2. Ambil seluruh master Objek Retribusi
        $objekList = ObjekRetribusi::orderBy('kategori')->orderBy('nama_objek')->get();

        $rekapData = [];

        // 3. Iterasi tiap Objek Retribusi untuk menyusun data matriks 12 bulan
        foreach ($objekList as $objek) {
            $bulanan = [];
            $totalTargetObjek = 0;
            $totalRealisasiObjek = 0;

            for ($bulan = 1; $bulan <= 12; $bulan++) {
                // Ambil Target Bulanan dari tabel target_retribusis
                $target = TargetRetribusi::where('objek_retribusi_id', $objek->id)
                    ->where('tahun', $tahun)
                    ->where('bulan', $bulan)
                    ->value('nominal_target') ?? 0;

                // Hitung Realisasi Bulanan dari tabel registers
                $realisasi = Register::where('objek_retribusi_id', $objek->id)
                    ->whereYear('tanggal', $tahun)
                    ->whereMonth('tanggal', $bulan)
                    ->sum('jumlah');

                // Hitung Persentase Capaian
                $persen = $target > 0 ? ($realisasi / $target) * 100 : 0;

                // Simpan ke struktur array bulanan yang dibutuhkan Blade
                $bulanan[$bulan] = [
                    'target'    => $target,
                    'realisasi' => $realisasi,
                    'persen'    => $persen,
                ];

                $totalTargetObjek += $target;
                $totalRealisasiObjek += $realisasi;
            }

            // Hitung Total Persentase Objek Setahun
            $totalPersenObjek = $totalTargetObjek > 0 ? ($totalRealisasiObjek / $totalTargetObjek) * 100 : 0;

            // Masukkan ke array utama
            $rekapData[] = [
                'nama_objek'      => $objek->nama_objek,
                'kategori'        => $objek->kategori,
                'bulanan'         => $bulanan,
                'total_target'    => $totalTargetObjek,
                'total_realisasi' => $totalRealisasiObjek,
                'total_persen'    => $totalPersenObjek,
            ];
        }

        // 4. UBAH ARRAY MENJADI COLLECTION AGAR METHOD ->groupBy() DI BLADE BISA JALAN
        $rekapData = collect($rekapData);

        // 5. Kirim variabel $rekapData dan $tahun ke View
        return view('target-realisasi.index', compact('rekapData', 'tahun'));
    }
}
