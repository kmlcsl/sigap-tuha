<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BantuanDarurat;
use Illuminate\Http\Request;

class BantuanDaruratController extends Controller
{
    public function index()
    {
        $bantuanDarurats = BantuanDarurat::orderBy('urutan')->get();
        return view('admin.bantuan_darurat.index', compact('bantuanDarurats'));
    }

    public function create()
    {
        return view('admin.bantuan_darurat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|max:200',
            'jenis' => 'required|in:Kepolisian,Damkar,Basarnas,Rumah Sakit,Puskesmas,Lainnya',
            'nomor_wa' => 'required|max:20',
            'deskripsi' => 'nullable|max:1000',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        BantuanDarurat::create($validated);

        return redirect()->route('admin.bantuan-darurat.index')->with('success', 'Bantuan Darurat berhasil ditambahkan.');
    }

    public function edit(BantuanDarurat $bantuanDarurat)
    {
        return view('admin.bantuan_darurat.edit', compact('bantuanDarurat'));
    }

    public function update(Request $request, BantuanDarurat $bantuanDarurat)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|max:200',
            'jenis' => 'required|in:Kepolisian,Damkar,Basarnas,Rumah Sakit,Puskesmas,Lainnya',
            'nomor_wa' => 'required|max:20',
            'deskripsi' => 'nullable|max:1000',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $bantuanDarurat->update($validated);

        return redirect()->route('admin.bantuan-darurat.index')->with('success', 'Bantuan Darurat berhasil diperbarui.');
    }

    public function destroy(BantuanDarurat $bantuanDarurat)
    {
        $bantuanDarurat->delete();
        return redirect()->route('admin.bantuan-darurat.index')->with('success', 'Bantuan Darurat berhasil dihapus.');
    }

    public function toggleActive(BantuanDarurat $bantuanDarurat)
    {
        $bantuanDarurat->update(['is_active' => !$bantuanDarurat->is_active]);
        return redirect()->back()->with('success', 'Status Bantuan Darurat berhasil diubah.');
    }
}
