<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use Illuminate\Http\Request;

class EdukasiController extends Controller
{
    public function index()
    {
        $col = 'order';
        $edukasis = Edukasi::orderBy($col)->get();
        return view('admin.edukasi.index', ['edukasis' => $edukasis]);
    }

    public function create()
    {
        return view('admin.edukasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'kategori' => 'required|in:BHD,Evakuasi,Pertolongan Pertama,Lainnya',
            'jenis' => 'required|in:Artikel,Video,SOP',
            'url_video' => 'nullable|url|max:500',
            'is_published' => 'boolean',
            'order' => 'integer',
        ]);

        Edukasi::create($validated);

        return redirect()->route('admin.edukasi.index')->with('success', 'Edukasi berhasil ditambahkan.');
    }

    public function edit(Edukasi $edukasi)
    {
        return view('admin.edukasi.edit', ['edukasi' => $edukasi]);
    }

    public function update(Request $request, Edukasi $edukasi)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'kategori' => 'required|in:BHD,Evakuasi,Pertolongan Pertama,Lainnya',
            'jenis' => 'required|in:Artikel,Video,SOP',
            'url_video' => 'nullable|url|max:500',
            'is_published' => 'boolean',
            'order' => 'integer',
        ]);

        $edukasi->update($validated);

        return redirect()->route('admin.edukasi.index')->with('success', 'Edukasi berhasil diperbarui.');
    }

    public function destroy(Edukasi $edukasi)
    {
        $edukasi->delete();

        return redirect()->route('admin.edukasi.index')->with('success', 'Edukasi berhasil dihapus.');
    }
}
