<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use Illuminate\Http\Request;

class LansiaController extends Controller
{
    public function index()
    {
        $col = 'nama';
        $lansias = Lansia::orderBy($col)->get();
        return view('admin.lansia.index', ['lansias' => $lansias]);
    }

    public function create()
    {
        return view('admin.lansia.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:150',
            'umur' => 'required|integer|min:1|max:150',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required',
            'desa' => 'required|max:100',
            'kontak_keluarga' => 'nullable|max:20',
            'riwayat_penyakit' => 'nullable',
            'kondisi_kesehatan' => 'nullable|max:100',
            'status' => 'required|in:Stabil,Perlu pemantauan,Rujukan segera',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        Lansia::create($validated);

        return redirect()->route('admin.lansia.index')->with('success', 'Data lansia berhasil ditambahkan.');
    }

    public function edit(Lansia $lansia)
    {
        return view('admin.lansia.edit', ['lansia' => $lansia]);
    }

    public function update(Request $request, Lansia $lansia)
    {
        $validated = $request->validate([
            'nama' => 'required|max:150',
            'umur' => 'required|integer|min:1|max:150',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required',
            'desa' => 'required|max:100',
            'kontak_keluarga' => 'nullable|max:20',
            'riwayat_penyakit' => 'nullable',
            'kondisi_kesehatan' => 'nullable|max:100',
            'status' => 'required|in:Stabil,Perlu pemantauan,Rujukan segera',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        $lansia->update($validated);

        return redirect()->route('admin.lansia.index')->with('success', 'Data lansia berhasil diperbarui.');
    }

    public function destroy(Lansia $lansia)
    {
        $lansia->delete();

        return redirect()->route('admin.lansia.index')->with('success', 'Data lansia berhasil dihapus.');
    }
}
