<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\ObjekRetribusi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Menampilkan data register berdasarkan bulan yang dipilih.
     */
    public function index(Request $request)
    {
        // 1. Ambil filter bulan dan tahun aktif dari request (default bulan & tahun saat ini)
        $bulanAktif = $request->input('bulan', Carbon::now()->format('m'));
        $tahunAktif = $request->input('tahun', Carbon::now()->format('Y'));

        // 2. Mengambil data register pada bulan dan tahun terpilih dengan relasi objekRetribusi
        $registers = Register::with('objekRetribusi')
            ->whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->orderBy('tanggal', 'asc')
            ->get();

        // 3. HITUNG AKUMULASI BERDASARKAN OBJEK RETRIBUSI SPESIFIK (Menggunakan Relasi)

        // Card 1: PKS (PKS Pihak Ketiga)
        $totalSampah = Register::whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->whereHas('objekRetribusi', function ($q) {
                $q->where('nama_objek', 'LIKE', '%PIHAK KETIGA%');
            })
            ->sum('jumlah');

        // Card 2: ASET DAERAH (RTH Bung Karno & Taman Kota)
        $totalAset = Register::whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->whereHas('objekRetribusi', function ($q) {
                $q->where('kategori', 'LIKE', '%ASET DAERAH%');
            })
            ->sum('jumlah');

        // Card 3: PDAM (Perumda Tirta Hita)
        $totalPdam = Register::whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->whereHas('objekRetribusi', function ($q) {
                $q->where('nama_objek', 'LIKE', '%TIRTA HITA%');
            })
            ->sum('jumlah');

        // Card 4: TPA BENGKALA (Berdasarkan relasi Objek atau Nama Penyetor)
        $totalTpa = Register::whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->where(function ($query) {
                $query->whereHas('objekRetribusi', function ($q) {
                    $q->where('nama_objek', 'LIKE', '%TPA%');
                })->orWhere('wajib_retribusi', 'LIKE', '%TPA%');
            })
            ->sum('jumlah');

        // Total Keseluruhan
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
        $tahunSekarang = Carbon::now()->format('Y');

        // 1. Cari data terakhir di database yang tahunnya berjalan
        $lastRegister = Register::whereYear('tanggal', $tahunSekarang)
            ->whereNotNull('nomor_stbp')
            ->where('nomor_stbp', '!=', '')
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;

        if ($lastRegister) {
            $parts = explode('/', $lastRegister->nomor_stbp);
            if (isset($parts[0]) && is_numeric($parts[0])) {
                $nextNumber = (int)$parts[0] + 1;
            }
        }

        $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $nomorStbpOtomatis = "{$formattedNumber}/TBP/DLH/{$tahunSekarang}";

        // 2. Ambil master data Objek Retribusi
        $objekRetribusis = ObjekRetribusi::orderBy('kategori')->orderBy('nama_objek')->get();

        return view('register.create', compact('nomorStbpOtomatis', 'objekRetribusis'));
    }

    /**
     * Menyimpan data harian baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi inputan dari form
        $validated = $request->validate([
            'tanggal'            => 'required|date',
            'wajib_retribusi'    => 'required|string|max:255',
            'objek_retribusi_id' => 'required|exists:objek_retribusis,id',
            'nomor_stbp'         => 'nullable|string|unique:registers,nomor_stbp',
            'jenis_penetapan'    => 'required|in:penetapan,tanpa_penetapan',
            'jumlah'             => 'required|numeric|min:0',
        ]);

        // 2. Otomatis isi kolom 'kategori' berdasarkan Objek Retribusi terpilih
        $objek = ObjekRetribusi::find($request->objek_retribusi_id);
        if ($objek) {
            $validated['kategori'] = $objek->kategori;
        }

        // 3. Simpan data ke database
        Register::create($validated);

        // 4. Redirect kembali ke halaman utama register dengan filter bulan & tahun transaksi
        return redirect()->route('register.index', [
            'bulan' => Carbon::parse($request->tanggal)->format('m'),
            'tahun' => Carbon::parse($request->tanggal)->format('Y'),
        ])->with('success', 'Data transaksi pendapatan harian berhasil disimpan!');
    }

    /**
     * Mencetak Laporan Register Pendapatan.
     */
    public function print(Request $request)
    {
        $bulanAktif = $request->input('bulan', date('m'));
        $tahunAktif = $request->input('tahun', date('Y'));

        $registers = Register::with('objekRetribusi')
            ->whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->orderBy('tanggal', 'asc')
            ->get();

        // 3. HITUNG AKUMULASI (Mengecek Relasi Objek DAN Nama Penyetor Manual)

        // Card 1: PKS / Persampahan Pihak Ketiga (Termasuk SMKN, Sekolah, Toko, PKS)
        $totalSampah = Register::whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->where(function ($q) {
                $q->whereHas('objekRetribusi', function ($sub) {
                    $sub->where('nama_objek', 'LIKE', '%PIHAK KETIGA%');
                })
                    // Jika objek_retribusi_id kosong, cek kategorinya atau nama penyetor
                    ->orWhere(function ($sub) {
                        $sub->where('kategori', 'LIKE', '%PERSAMPAHAN%')
                            ->where('wajib_retribusi', 'NOT LIKE', '%PDAM%')
                            ->where('wajib_retribusi', 'NOT LIKE', '%TIRTA HITA%')
                            ->where('wajib_retribusi', 'NOT LIKE', '%TPA%')
                            ->where('wajib_retribusi', 'NOT LIKE', '%BENGKALA%');
                    });
            })
            ->sum('jumlah');

        // Card 2: ASET DAERAH (TBK, TAMKOT, RTH Bung Karno, Taman Kota)
        $totalAset = Register::whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->where(function ($q) {
                $q->whereHas('objekRetribusi', function ($sub) {
                    $sub->where('kategori', 'LIKE', '%ASET DAERAH%');
                })
                    ->orWhere('kategori', 'LIKE', '%ASET DAERAH%')
                    ->orWhere('wajib_retribusi', 'LIKE', '%TBK%')
                    ->orWhere('wajib_retribusi', 'LIKE', '%TAMKOT%')
                    ->orWhere('wajib_retribusi', 'LIKE', '%RTH%');
            })
            ->sum('jumlah');

        // Card 3: PDAM (Perumda Tirta Hita / Penyetor PDAM)
        $totalPdam = Register::whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->where(function ($q) {
                $q->whereHas('objekRetribusi', function ($sub) {
                    $sub->where('nama_objek', 'LIKE', '%TIRTA HITA%');
                })
                    ->orWhere('wajib_retribusi', 'LIKE', '%PDAM%')
                    ->orWhere('wajib_retribusi', 'LIKE', '%TIRTA HITA%');
            })
            ->sum('jumlah');

        // Card 4: TPA BENGKALA
        $totalTpa = Register::whereMonth('tanggal', $bulanAktif)
            ->whereYear('tanggal', $tahunAktif)
            ->where(function ($q) {
                $q->whereHas('objekRetribusi', function ($sub) {
                    $sub->where('nama_objek', 'LIKE', '%TPA%');
                })
                    ->orWhere('wajib_retribusi', 'LIKE', '%TPA%')
                    ->orWhere('wajib_retribusi', 'LIKE', '%BENGKALA%');
            })
            ->sum('jumlah');

        // Total Keseluruhan
        $totalKeseluruhan = $totalSampah + $totalAset + $totalPdam + $totalTpa;

        $namaBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
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

    /**
     * Menampilkan Form Edit Data
     */
    public function edit(string $id)
    {
        $register = Register::findOrFail($id);
        $objekRetribusis = ObjekRetribusi::orderBy('kategori')->orderBy('nama_objek')->get();

        return view('register.edit', compact('register', 'objekRetribusis'));
    }

    /**
     * Memproses Pembaruan Data di Database
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal'            => 'required|date',
            'wajib_retribusi'    => 'required|string|max:255',
            'objek_retribusi_id' => 'required|exists:objek_retribusis,id',
            'jenis_penetapan'    => 'required|in:penetapan,tanpa_penetapan',
            'jumlah'             => 'required|numeric|min:0',
        ]);

        $register = Register::findOrFail($id);
        $objek = ObjekRetribusi::find($request->objek_retribusi_id);

        $register->update([
            'tanggal'            => $request->tanggal,
            'wajib_retribusi'    => $request->wajib_retribusi,
            'objek_retribusi_id' => $request->objek_retribusi_id,
            'kategori'           => $objek ? $objek->kategori : $register->kategori,
            'jenis_penetapan'    => $request->jenis_penetapan,
            'jumlah'             => $request->jumlah,
        ]);

        return redirect()->route('register.index', [
            'bulan' => Carbon::parse($request->tanggal)->format('m'),
            'tahun' => Carbon::parse($request->tanggal)->format('Y'),
        ])->with('success', 'Data transaksi berhasil diperbaharui!');
    }

    /**
     * Menghapus Data dari Database
     */
    public function destroy(string $id)
    {
        $register = Register::findOrFail($id);
        $register->delete();

        return redirect()->route('register.index')
            ->with('success', 'Data berhasil dihapus dari sistem!');
    }
}
