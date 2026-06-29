<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kontak;
use App\Models\PesanMasuk;

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
        
        $pesan_masuks = PesanMasuk::latest()->get();
        
        return view('admin.kontak.index', compact('kontak', 'pesan_masuks'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'alamat' => 'nullable|string',
            'email' => 'nullable|email',
            'telepon' => 'nullable|string',
        ]);

        $kontak = Kontak::first();
        $kontak->update($request->only([
            'alamat', 'email', 'telepon'
        ]));

        return redirect()->route('admin.kontak.index')->with('success', 'Kontak berhasil diperbarui!');
    }
    
    public function markAsRead($id)
    {
        $pesan = PesanMasuk::findOrFail($id);
        $pesan->update(['is_read' => true]);
        
        return redirect()->route('admin.kontak.index')->with('success', 'Status pesan berhasil diperbarui.');
    }
    
    public function destroyPesan($id)
    {
        $pesan = PesanMasuk::findOrFail($id);
        $pesan->delete();
        
        return redirect()->route('admin.kontak.index')->with('success', 'Pesan berhasil dihapus.');
    }
}
