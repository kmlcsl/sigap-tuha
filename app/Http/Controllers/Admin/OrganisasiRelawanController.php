<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganisasiRelawan;
use Illuminate\Http\Request;

class OrganisasiRelawanController extends Controller
{
    public function index()
    {
        $organisasiRelawans = OrganisasiRelawan::withCount('relawans')->orderBy('urutan')->get();
        return view('admin.organisasi_relawan.index', compact('organisasiRelawans'));
    }

    public function create()
    {
        return view('admin.organisasi_relawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_organisasi' => 'required|max:200',
            'singkatan' => 'nullable|max:20',
            'deskripsi' => 'required',
            'kontak_wa' => 'nullable|max:20',
            'kontak_telepon' => 'nullable|max:20',
            'email' => 'nullable|email',
            'bidang_keahlian' => 'nullable|max:200',
            'alamat' => 'nullable',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        OrganisasiRelawan::create($validated);

        return redirect()->route('admin.organisasi-relawan.index')->with('success', 'Organisasi Relawan berhasil ditambahkan.');
    }

    public function edit(OrganisasiRelawan $organisasiRelawan)
    {
        return view('admin.organisasi_relawan.edit', compact('organisasiRelawan'));
    }

    public function update(Request $request, OrganisasiRelawan $organisasiRelawan)
    {
        $validated = $request->validate([
            'nama_organisasi' => 'required|max:200',
            'singkatan' => 'nullable|max:20',
            'deskripsi' => 'required',
            'kontak_wa' => 'nullable|max:20',
            'kontak_telepon' => 'nullable|max:20',
            'email' => 'nullable|email',
            'bidang_keahlian' => 'nullable|max:200',
            'alamat' => 'nullable',
            'is_active' => 'boolean',
            'urutan' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $organisasiRelawan->update($validated);

        return redirect()->route('admin.organisasi-relawan.index')->with('success', 'Organisasi Relawan berhasil diperbarui.');
    }

    public function destroy(OrganisasiRelawan $organisasiRelawan)
    {
        $organisasiRelawan->delete();
        return redirect()->route('admin.organisasi-relawan.index')->with('success', 'Organisasi Relawan berhasil dihapus.');
    }
}
