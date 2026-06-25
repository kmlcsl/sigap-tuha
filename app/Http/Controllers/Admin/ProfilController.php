<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profil;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = Profil::first();
        if (!$profil) {
            $profil = Profil::create([
                'judul' => 'Profil Karang Taruna',
                'konten' => 'Isi profil di sini...'
            ]);
        }
        return view('admin.profil.index', compact('profil'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $profil = Profil::first();

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
        ];

        if ($request->hasFile('gambar')) {
            if ($profil->gambar) {
                Storage::disk('public')->delete($profil->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('profil', 'public');
        }

        $profil->update($data);

        return redirect()->route('admin.profil.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
