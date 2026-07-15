<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Menampilkan data register berdasarkan bulan yang dipilih.
     */
    public function index(Request $request)
    {
        // Jika user tidak memilih bulan, default-kan ke bulan saat ini (misal: Juli 2026)
        $bulanAktif = $request->input('bulan', Carbon::now()->format('m'));
        $tahunAktif = $request->input('tahun', Carbon::now()->format('Y'));

        // Mengambil data register pada bulan dan tahun terpilih, urutkan berdasarkan tanggal
        $registers = Register::whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->orderBy('tanggal', 'asc')
            ->get();

        // 3. HITUNG AKUMULASI PER KATEGORI (Hanya untuk bulan & tahun yang aktif)
        $totalSampah = Register::whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->where('kategori', 'Pelayanan Persampahan')
            ->sum('jumlah');
        
        $totalAset = Register::whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->where('kategori', 'Pemanfaatan Aset Daerah')
            ->sum('jumlah');

        $totalPdam = Register::whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->where('kategori', 'PDAM')
            ->sum('jumlah');
        
        $totalTpa = Register::wheremonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->where('kategori', 'TPA')
            ->sum('jumlah');
        
        // Total keseluruhan gabungan 4 kategori
        $totalKeseluruhan = $totalSampah + $totalAset + $totalPdam + $totalTpa;

        // Mengirimkan data ke halaman view Blade
        return view('register.index', compact(
            'registers',
            'bulanAktif', 
            'tahunAktif',
            'totalSampah',
            'totalAset',
            'totalPdam',
            'totalTpa',
            'totalKeseluruhan',
        ));
    }

    /**
     * Menampilkan form untuk menginput data harian baru.
     */
    public function create()
    {
        // KUNCI UTAMA: Paksa menggunakan format 4 digit 'Y' (Y kapital) -> 2026
        $tahunSekarang = Carbon::now()->format('Y');

        // 1. Cari data terakhir di database yang tahunnya 2026
        $lastRegister = Register::whereYear('tanggal', $tahunSekarang)
            ->whereNotNull('nomor_stbp')
            ->where('nomor_stbp', '!=', '')
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1; // Default jika belum ada data di tahun 2026

        if ($lastRegister) {
            // Ambil bagian nomor urut paling depan sebelum tanda '/'
            $parts = explode('/', $lastRegister->nomor_stbp);
            if (isset($parts[0]) && is_numeric($parts[0])) {
                $nextNumber = (int)$parts[0] + 1;
            }
        }

        // 2. Format nomor urut menjadi 3 digit (misal: 1 menjadi "001")
        $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // 3. Gabungkan dengan format tahun 4 digit
        $nomorStbpOtomatis = "{$formattedNumber}/TBP/DLH/{$tahunSekarang}";

        return view('register.create', compact('nomorStbpOtomatis'));
    }

    /**
     * Menyimpan data harian baru ke database.
     */
    public function store(Request $request) //Variable
    {
        // Validasi inputan dari form
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'wajib_retribusi' => 'required|string|max:255',
            'kategori' => 'required|in:Pelayanan Persampahan,Pemanfaatan Aset Daerah,PDAM,TPA',
            'nomor_stbp' => 'nullable|string|unique:registers,nomor_stbp',
            'jenis_penetapan' => 'required|in:penetapan,tanpa_penetapan',
            'jumlah' => 'required|numeric|min:0,'
        ]);

        // Simpan data ke database
        Register::create($validated);

        // Redirect kembali ke halaman utama register dengan pesan sukses
        return redirect()->route('register.index', [
            'bulan' => Carbon::parse($request->tanggal)->format('m'),
            'tahun' => Carbon::parse($request->tanggal)->format('Y'),
        ])->with('success', 'Data Transaksi Harian Berhasil Disimpan!');
    }


    public function print(Request $request)
    {
        // 1. Ambil filter bulan dan tahun aktif dari request (default bulan & tahun ini)
        $bulanAktif = $request->input('bulan', date('m'));
        $tahunAktif = $request->input('tahun', date('Y'));

        // 2. Ambil data harian untuk dicetak
        $registers = Register::whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->orderBy('tanggal', 'asc')
            ->get();

        // 3. Hitung akumulasi untuk tabel rekapitulasi di halaman cetak
        $totalSampah = Register::whereMonth('tanggal', $bulanAktif)->whereYear('tanggal', $tahunAktif)->where('kategori', 'Pelayanan Persampahan')->sum('jumlah');
        $totalAset = Register::whereMonth('tanggal', $bulanAktif)->whereYear('tanggal', $tahunAktif)->where('kategori', 'Pemanfaatan Aset Daerah')->sum('jumlah');
        $totalPdam = Register::whereMonth('tanggal', $bulanAktif)->whereYear('tanggal', $tahunAktif)->where('kategori', 'PDAM')->sum('jumlah');
        $totalTpa = Register::whereMonth('tanggal', $bulanAktif)->whereYear('tanggal', $tahunAktif)->where('kategori', 'TPA')->sum('jumlah');
        $totalKeseluruhan = $totalSampah + $totalAset + $totalPdam + $totalTpa;

        // Array nama bulan untuk mempermudah penamaan judul laporan cetak
        $namaBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', 
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', 
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        $bulanTeks = $namaBulan[$bulanAktif] ?? 'Unknown';

        return view('register.print', compact(
            'registers',
            'bulanAktif',
            'tahunAktif',
            'bulanTeks',
            'totalSampah',
            'totalAset',
            'totalPdam',
            'totalTpa',
            'totalKeseluruhan',
        ));
    }
}
