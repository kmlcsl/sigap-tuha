<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function create(Program $program)
    {
        return view('admin.kegiatans.create', ['program' => $program]);
    }

    public function store(Request $request, Program $program)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi_lengkap' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kegiatan', 'public');
        }

        $program->kegiatans()->create($validated);

        return redirect()->route('admin.programs.show', $program)->with('success', 'Kegiatan berhasil ditambahkan ke dalam program.');
    }

    public function edit(Program $program, Kegiatan $kegiatan)
    {
        return view('admin.kegiatans.edit', ['program' => $program, 'kegiatan' => $kegiatan]);
    }

    public function update(Request $request, Program $program, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi_lengkap' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($kegiatan->foto) {
                Storage::disk('public')->delete($kegiatan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('kegiatan', 'public');
        }

        $kegiatan->update($validated);

        return redirect()->route('admin.programs.show', $program)->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Program $program, Kegiatan $kegiatan)
    {
        if ($kegiatan->foto) {
            Storage::disk('public')->delete($kegiatan->foto);
        }
        $kegiatan->delete();

        return redirect()->route('admin.programs.show', $program)->with('success', 'Kegiatan berhasil dihapus.');
    }
}
