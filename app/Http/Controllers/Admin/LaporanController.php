<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\LaporanDarurat;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = LaporanDarurat::with('lansia')->latest()->get();
        return view('admin.laporan.index', ['laporans' => $laporans]);
    }

    public function create()
    {
        $col = 'nama';
        $lansias = Lansia::orderBy($col)->get();
        return view('admin.laporan.create', ['lansias' => $lansias]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lansia_id' => 'required|exists:lansias,id',
            'pelapor' => 'required|max:150',
            'kondisi' => 'required',
            'lokasi' => 'nullable|max:255',
            'tingkat_urgensi' => 'required|in:Rendah,Sedang,Tinggi,Kritis',
            'status' => 'required|in:Baru,Diproses,Ditangani,Selesai',
            'catatan_tindakan' => 'nullable',
        ]);

        LaporanDarurat::create($validated);

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan darurat berhasil ditambahkan.');
    }

    public function edit(LaporanDarurat $laporan)
    {
        $col = 'nama';
        $lansias = Lansia::orderBy($col)->get();
        return view('admin.laporan.edit', ['laporan' => $laporan, 'lansias' => $lansias]);
    }

    public function update(Request $request, LaporanDarurat $laporan)
    {
        $validated = $request->validate([
            'lansia_id' => 'required|exists:lansias,id',
            'pelapor' => 'required|max:150',
            'kondisi' => 'required',
            'lokasi' => 'nullable|max:255',
            'tingkat_urgensi' => 'required|in:Rendah,Sedang,Tinggi,Kritis',
            'status' => 'required|in:Baru,Diproses,Ditangani,Selesai',
            'catatan_tindakan' => 'nullable',
        ]);

        $laporan->update($validated);

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan darurat berhasil diperbarui.');
    }

    public function destroy(LaporanDarurat $laporan)
    {
        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan darurat berhasil dihapus.');
    }
}
