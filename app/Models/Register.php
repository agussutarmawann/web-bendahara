<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;
    // Menentukan tabel yang diwakili oleh model ini
    protected $table = 'registers';

    // Kolom apa saja yang boleh diisi oleh user melalui form
    protected $fillable = [
        'tanggal',
        'wajib_retribusi',
        'kategori',
        'nomor_stbp',
        'jenis_penetapan',
        'jumlah',
        'nomor_sts_link',
    ];

    // Otomatis mengubah string tanggal menjadi objek Carbon agar mudah dimanipulasi
    protected $casts =[
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];
}
