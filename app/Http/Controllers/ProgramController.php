<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Kegiatan;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::with(['kegiatans' => function($q) {
            $q->take(3);
        }])->get();
        return view('program', ['programs' => $programs]);
    }

    public function getKegiatan(string $id)
    {
        $col = 'program_id';
        $kegiatans = Kegiatan::where($col, $id)->get()->map(function($kegiatan) {
            if ($kegiatan->foto) {
                $kegiatan->foto = asset('storage/' . $kegiatan->foto);
            }
            return $kegiatan;
        });
        return response()->json($kegiatans);
    }
}
