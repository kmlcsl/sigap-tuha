<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganisasiRelawan;
use App\Models\Relawan;
use Illuminate\Http\Request;

class RelawanController extends Controller
{
    public function index(OrganisasiRelawan $organisasiRelawan)
    {
        $relawans = $organisasiRelawan->relawans()->latest()->get();
        return view('admin.relawan.index', compact('organisasiRelawan', 'relawans'));
    }

    public function create(OrganisasiRelawan $organisasiRelawan)
    {
        return view('admin.relawan.create', compact('organisasiRelawan'));
    }

    public function store(Request $request, OrganisasiRelawan $organisasiRelawan)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|max:150',
            'jabatan' => 'nullable|max:100',
            'keahlian' => 'nullable|max:200',
            'nomor_hp' => 'nullable|max:20',
            'nomor_wa' => 'nullable|max:20',
            'is_aktif' => 'boolean',
            'keterangan' => 'nullable',
        ]);

        $validated['is_aktif'] = $request->has('is_aktif');

        $organisasiRelawan->relawans()->create($validated);

        return redirect()->route('admin.organisasi-relawan.relawan.index', $organisasiRelawan)->with('success', 'Relawan berhasil ditambahkan.');
    }

    public function edit(OrganisasiRelawan $organisasiRelawan, Relawan $relawan)
    {
        return view('admin.relawan.edit', compact('organisasiRelawan', 'relawan'));
    }

    public function update(Request $request, OrganisasiRelawan $organisasiRelawan, Relawan $relawan)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|max:150',
            'jabatan' => 'nullable|max:100',
            'keahlian' => 'nullable|max:200',
            'nomor_hp' => 'nullable|max:20',
            'nomor_wa' => 'nullable|max:20',
            'is_aktif' => 'boolean',
            'keterangan' => 'nullable',
        ]);

        $validated['is_aktif'] = $request->has('is_aktif');

        $relawan->update($validated);

        return redirect()->route('admin.organisasi-relawan.relawan.index', $organisasiRelawan)->with('success', 'Relawan berhasil diperbarui.');
    }

    public function destroy(OrganisasiRelawan $organisasiRelawan, Relawan $relawan)
    {
        $relawan->delete();
        return redirect()->route('admin.organisasi-relawan.relawan.index', $organisasiRelawan)->with('success', 'Relawan berhasil dihapus.');
    }
}
