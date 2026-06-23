<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'judul'               => 'required|max:255',
            'slug'                => 'nullable|max:255|unique:edukasis,slug',
            'konten'              => 'required',
            'materi_pembahasan'   => 'nullable',
            'durasi_menit'        => 'nullable|integer|min:1',
            'kategori'            => 'required|in:BHD,Evakuasi,Pertolongan Pertama,Lainnya',
            'jenis'               => 'required|in:Artikel,Video,SOP',
            'url_video'           => 'nullable|url|max:500',
            'is_published'        => 'boolean',
            'sertifikat_tersedia' => 'boolean',
            'order'               => 'integer',
        ]);

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['judul']) . '-' . time();
        }

        $validated['sertifikat_tersedia'] = $request->boolean('sertifikat_tersedia');

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
            'judul'               => 'required|max:255',
            'slug'                => 'nullable|max:255|unique:edukasis,slug,' . $edukasi->id,
            'konten'              => 'required',
            'materi_pembahasan'   => 'nullable',
            'durasi_menit'        => 'nullable|integer|min:1',
            'kategori'            => 'required|in:BHD,Evakuasi,Pertolongan Pertama,Lainnya',
            'jenis'               => 'required|in:Artikel,Video,SOP',
            'url_video'           => 'nullable|url|max:500',
            'is_published'        => 'boolean',
            'sertifikat_tersedia' => 'boolean',
            'order'               => 'integer',
        ]);

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['judul']) . '-' . time();
        }

        $validated['sertifikat_tersedia'] = $request->boolean('sertifikat_tersedia');

        $edukasi->update($validated);

        return redirect()->route('admin.edukasi.index')->with('success', 'Edukasi berhasil diperbarui.');
    }

    public function destroy(Edukasi $edukasi)
    {
        $edukasi->delete();

        return redirect()->route('admin.edukasi.index')->with('success', 'Edukasi berhasil dihapus.');
    }
}
