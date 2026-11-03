<?php

namespace Database\Seeders;

use App\Models\ObjekRetribusi;
use App\Models\TargetRetribusi;
use Illuminate\Database\Seeder;

class TargetRetribusiSeeder extends Seeder
{
    public function run(): void
    {
        $tahun = 2026;
        $objekList = ObjekRetribusi::all();

        // Contoh nominal target bulanan default per objek
        $targetBulananMap = [
            'PERUMDA TIRTA HITA'                => 10000000,
            'PKS PIHAK KETIGA'                   => 5000000,
            'TPA BENGKALA'                        => 3000000,
            'RTH TAMAN BUNG KARNO'                      => 1500000,
            'RTH TAMAN KOTA'                          => 1000000,
        ];

        foreach ($objekList as $objek) {
            $nominal = $targetBulananMap[$objek->nama_objek] ?? 2000000;

            for ($bulan = 1; $bulan <= 12; $bulan++) {
                TargetRetribusi::updateOrCreate(
                    [
                        'objek_retribusi_id' => $objek->id,
                        'tahun'              => $tahun,
                        'bulan'              => $bulan,
                    ],
                    [
                        'nominal_target'     => $nominal,
                    ]
                );
            }
        }
    }
}
