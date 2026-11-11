<?php

namespace App\Http\Controllers;

use App\Models\ObjekRetribusi;
use App\Models\Register;
use App\Models\TargetRetribusi;
use Illuminate\Http\Request;

class RealisasiController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        // Ambil semua objek retribusi beserta relasi target dan register di tahun terpilih
        $objekRetribusi = ObjekRetribusi::with([
            'targetRetribusis' => function ($q) use ($tahun){
                $q->where('tahun', $tahun);
            },
            'registers' => function ($q) use ($tahun){
                $q->whereYear('tanggal', $tahun);
            }
        ])->get();

        $rekapLra = [];
        $totalTargetSemua = 0;
        $totalRealisasiSemua = 0;

        foreach ($objekRetribusi as $item){
            $target = $item->targetRetribusis->first()?->jumlah_target ?? 0;
            $realisasi = $item->registers->sum('jumlah');

            $totalTargetSemua += $target;
            $totalRealisasiSemua += $realisasi;

            $rekapLra[] = [
                'kode_rekening' => $item->kode_rekening ?? '4.1.02.01.14.0001',
                'nama_objek' => $item->nama_objek,
                'kategori' => $item->kategori,
                'target' => $target,
                'realisasi' => $realisasi,
            ];
        }

        return view ('realisasi.index', compact(
            'rekapLra',
            'tahun',
            'totalTargetSemua',
            'totalRealisasiSemua'
        ));
    }
}
