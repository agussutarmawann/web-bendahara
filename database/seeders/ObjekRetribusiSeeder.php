<?php

namespace Database\Seeders;

use App\Models\ObjekRetribusi;
use Illuminate\Database\Seeder;

class ObjekRetribusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori' => 'RETRIBUSI PELAYANAN PERSAMPAHAN /KEBERSIHAN',
                'nama_objek' => 'PERUMDA TIRTA HITA',
            ],
            [
                'kategori' => 'RETRIBUSI PELAYANAN PERSAMPAHAN /KEBERSIHAN',
                'nama_objek' => 'PKS PIHAK KETIGA',
            ],
            [
                'kategori' => 'RETRIBUSI PELAYANAN PERSAMPAHAN /KEBERSIHAN',
                'nama_objek' => 'TPA BENGKALA',
            ],
            [
                'kategori' => 'RETRIBUSI PEMANFAATAN ASET DAERAH',
                'nama_objek' => 'RTH TAMAN KOTA',
            ],
            [
                'kategori' => 'RETRIBUSI PEMANFAATAN ASET DAERAH',
                'nama_objek' => 'RTH TAMAN BUNG KARNO',
            ],
        ];
        foreach ($data as $item){
            ObjekRetribusi::create($item);
        }
    }
}
