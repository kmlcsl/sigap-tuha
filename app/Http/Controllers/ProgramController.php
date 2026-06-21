<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        // For initial render, we can still load the first 3 kegiatans, or all.
        // Let's load the program and limit kegiatans to 3 in the view, then fetch rest via Axios.
        $programs = \App\Models\Program::with(['kegiatans' => function($q) {
            $q->take(3);
        }])->get();
        return view('program', ['programs' => $programs]);
    }

    public function getKegiatan(string $id)
    {
        $col = 'program_id';
        $kegiatans = \App\Models\Kegiatan::where($col, $id)->get()->map(function($kegiatan) {
            if ($kegiatan->foto) {
                $kegiatan->foto = asset('storage/' . $kegiatan->foto);
            }
            return $kegiatan;
        });
        return response()->json($kegiatans);
    }
}
