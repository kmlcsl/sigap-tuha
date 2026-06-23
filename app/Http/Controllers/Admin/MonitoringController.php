<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PresensiPelatihan;
use App\Models\KunjunganRumah;
use App\Models\RekapKasus;
use App\Models\EvaluasiPrePostTest;
use App\Models\Edukasi;
use App\Models\Lansia;
use App\Models\Relawan;

class MonitoringController extends Controller
{
    public function index()
    {
        // Statistik kartu
        try {
            $relawanAktif = Relawan::where('is_aktif', true)->count();
        } catch (\Exception $e) {
            $relawanAktif = 0; // Model belum ada
        }
        $totalPelatihan = PresensiPelatihan::distinct('nama_pelatihan')->count('nama_pelatihan');
        $kunjunganRumah = KunjunganRumah::count();
        $kasusDitangani = RekapKasus::where('status_penanganan', 'Ditangani')->count();
        $totalKasus = RekapKasus::count();
        $rataPreTest = round(EvaluasiPrePostTest::avg('nilai_pre_test') ?? 0);
        $rataPostTest = round(EvaluasiPrePostTest::whereNotNull('nilai_post_test')->avg('nilai_post_test') ?? 0);
        
        // Grafik garis — kehadiran per bulan (12 bulan terakhir)
        $grafikBulan = collect();
        for ($i = 11; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $grafikBulan->push([
                'label' => $bulan->format('M Y'),
                'total' => PresensiPelatihan::where('hadir', true)
                    ->whereYear('tanggal', $bulan->year)
                    ->whereMonth('tanggal', $bulan->month)
                    ->count(),
            ]);
        }
        
        // Diagram donat — rekap kasus per jenis
        $rekapKasusDonut = RekapKasus::selectRaw('jenis_kasus, COUNT(*) as jumlah')
            ->groupBy('jenis_kasus')->get();
        
        // Data untuk tab (10 terbaru masing-masing)
        $presensiList = PresensiPelatihan::latest()->take(10)->get();
        $kunjunganList = KunjunganRumah::latest()->take(10)->get();
        $kasusList = RekapKasus::latest()->take(10)->get();
        $evaluasiList = EvaluasiPrePostTest::latest()->take(10)->get();
        $edukasiList = Edukasi::where('is_published', true)->orderBy('judul')->get();
        $lansiaList = Lansia::orderBy('nama')->get();
        
        return view('admin.monitoring.index', compact(
            'relawanAktif','totalPelatihan','kunjunganRumah','kasusDitangani','totalKasus',
            'rataPreTest','rataPostTest','grafikBulan','rekapKasusDonut',
            'presensiList','kunjunganList','kasusList','evaluasiList',
            'edukasiList','lansiaList'
        ));
    }

    public function storePresensi(Request $request)
    {
        $validated = $request->validate([
            'nama_pelatihan' => 'required|string|max:200',
            'tanggal' => 'required|date',
            'nama_peserta' => 'required|string|max:150',
            'edukasi_id' => 'nullable|exists:edukasis,id',
            'organisasi' => 'nullable|string|max:100',
            'hadir' => 'required|boolean',
            'keterangan' => 'nullable|string|max:200',
        ]);

        PresensiPelatihan::create($validated);

        return redirect()->back()->with('success', 'Data presensi pelatihan berhasil disimpan.');
    }

    public function storeKunjungan(Request $request)
    {
        $validated = $request->validate([
            'nama_lansia' => 'required|string|max:150',
            'lansia_id' => 'nullable|exists:lansias,id',
            'nama_relawan' => 'required|string|max:150',
            'tanggal_kunjungan' => 'required|date',
            'kondisi_fisik' => 'required|in:Baik,Cukup,Buruk',
            'kondisi_psikologis' => 'required|in:Stabil,Perlu Pendampingan,Krisis',
            'catatan' => 'nullable|string',
            'tindak_lanjut' => 'nullable|string',
        ]);

        KunjunganRumah::create($validated);

        return redirect()->back()->with('success', 'Data kunjungan rumah berhasil disimpan.');
    }

    public function storeKasus(Request $request)
    {
        $validated = $request->validate([
            'jenis_kasus' => 'required|in:Kesehatan,Bantuan Sosial,Psikologis,Evakuasi,Lainnya',
            'deskripsi_kasus' => 'required|string',
            'nama_lansia' => 'nullable|string|max:150',
            'tanggal_kejadian' => 'required|date',
            'status_penanganan' => 'required|in:Ditangani,Dalam Proses,Belum Ditangani',
            'penanganan' => 'nullable|string',
        ]);

        RekapKasus::create($validated);

        return redirect()->back()->with('success', 'Data rekap kasus berhasil disimpan.');
    }

    public function storeEvaluasi(Request $request)
    {
        $validated = $request->validate([
            'edukasi_id' => 'nullable|exists:edukasis,id',
            'nama_pelatihan' => 'required|string|max:200',
            'nama_peserta' => 'required|string|max:150',
            'tanggal' => 'required|date',
            'nilai_pre_test' => 'required|integer|min:0|max:100',
            'nilai_post_test' => 'nullable|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        EvaluasiPrePostTest::create($validated);

        return redirect()->back()->with('success', 'Data evaluasi pre/post test berhasil disimpan.');
    }
}
