<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lansia;

class PetaController extends Controller
{
    public function index()
    {
        $colLat = 'lat';
        $colLng = 'lng';
        $lansias = Lansia::whereNotNull($colLat)->whereNotNull($colLng)->get();
        return view('admin.peta.index', ['lansias' => $lansias]);
    }
}
