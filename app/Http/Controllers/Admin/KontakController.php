<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kontak;

class KontakController extends Controller
{
    public function index()
    {
        $kontak = Kontak::first();
        if (!$kontak) {
            $kontak = Kontak::create([
                'alamat' => 'Alamat belum diisi',
                'email' => 'email@example.com',
                'telepon' => '-',
            ]);
        }
        return view('admin.kontak.index', compact('kontak'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'alamat' => 'nullable|string',
            'email' => 'nullable|email',
            'telepon' => 'nullable|string',
            'map_embed_url' => 'nullable|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
        ]);

        $kontak = Kontak::first();
        $kontak->update($request->only([
            'alamat', 'email', 'telepon', 'map_embed_url', 'facebook', 'instagram'
        ]));

        return redirect()->route('admin.kontak.index')->with('success', 'Kontak berhasil diperbarui!');
    }
}
