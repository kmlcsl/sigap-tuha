<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\Feature;
use App\Models\PendataanLansia;
use App\Models\LansiaPrioritas;
use App\Models\BantuanDarurat;

use App\Models\OrganisasiRelawan;
use App\Models\User;
use App\Models\PesanMasuk;

class DashboardController extends Controller
{
    public function index()
    {
        $featureCount = Feature::count();
        $desaCount = PendataanLansia::count();
        $lansiaPrioritasCount = LansiaPrioritas::count();
        $bantuanCount = BantuanDarurat::count();
        $relawanCount = OrganisasiRelawan::count();
        $edukasiCount = Edukasi::count();
        $userCount = User::count();
        
        $pesanTerbaru = PesanMasuk::latest()->take(5)->get();
        $pendataanLansiaTerbaru = PendataanLansia::latest()->take(5)->get();

        return view('admin.dashboard', [
            'featureCount' => $featureCount,
            'desaCount' => $desaCount,
            'lansiaPrioritasCount' => $lansiaPrioritasCount,
            'bantuanCount' => $bantuanCount,
            'relawanCount' => $relawanCount,
            'edukasiCount' => $edukasiCount,
            'userCount' => $userCount,
            'pesanTerbaru' => $pesanTerbaru,
            'pendataanLansiaTerbaru' => $pendataanLansiaTerbaru,
        ]);
    }
}
