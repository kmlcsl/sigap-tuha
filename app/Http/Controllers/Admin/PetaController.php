<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LansiaPrioritas;

class PetaController extends Controller
{
    public function index()
    {
        $colLat = 'latitude';
        $colLng = 'longitude';
        $lansias = LansiaPrioritas::with('desa')->whereNotNull($colLat)->whereNotNull($colLng)->get();
        return view('admin.peta.index', ['lansias' => $lansias]);
    }
}
