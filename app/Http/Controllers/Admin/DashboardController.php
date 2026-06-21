<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\Feature;
use App\Models\Lansia;
use App\Models\LaporanDarurat;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $statusCol = 'status';
        $featureCount = Feature::count();
        $lansiaCount = Lansia::count();
        $laporanCount = LaporanDarurat::where($statusCol, '!=', 'Selesai')->count();
        $edukasiCount = Edukasi::count();
        $userCount = User::count();
        $lansiaPerluPemantauan = Lansia::where($statusCol, 'Perlu pemantauan')->count();
        $lansiaRujukan = Lansia::where($statusCol, 'Rujukan segera')->count();
        $lansiaStabil = Lansia::where($statusCol, 'Stabil')->count();
        $laporanBaru = LaporanDarurat::where($statusCol, 'Baru')->count();

        return view('admin.dashboard', [
            'featureCount' => $featureCount,
            'lansiaCount' => $lansiaCount,
            'laporanCount' => $laporanCount,
            'edukasiCount' => $edukasiCount,
            'userCount' => $userCount,
            'lansiaPerluPemantauan' => $lansiaPerluPemantauan,
            'lansiaRujukan' => $lansiaRujukan,
            'lansiaStabil' => $lansiaStabil,
            'laporanBaru' => $laporanBaru,
        ]);
    }
}
