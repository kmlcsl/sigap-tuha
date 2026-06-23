<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use Illuminate\Http\Request;

class LansiaController extends Controller
{
    public function index(Request $request)
    {
        $query = Lansia::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%$s%")
                  ->orWhere('desa', 'like', "%$s%")
                  ->orWhere('alamat', 'like', "%$s%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $lansias = $query->orderBy('nama')->get();

        return view('admin.lansia.index', ['lansias' => $lansias]);
    }

    public function export(Request $request)
    {
        $query = Lansia::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%$s%")
                  ->orWhere('desa', 'like', "%$s%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $lansias = $query->orderBy('nama')->get();

        $filename = 'data-lansia-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($lansias) {
            $handle = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            // Header row
            fputcsv($handle, ['No','Nama Lengkap','Umur','Jenis Kelamin','Alamat','Desa/Kecamatan','Kontak Keluarga','Kondisi Kesehatan','Riwayat Penyakit','Status Bantuan','Tanggal Didaftarkan']);

            foreach ($lansias as $i => $l) {
                fputcsv($handle, [
                    $i + 1,
                    $l->nama,
                    $l->umur . ' tahun',
                    $l->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                    $l->alamat,
                    $l->desa,
                    $l->kontak_keluarga ?? '-',
                    $l->kondisi_kesehatan ?? '-',
                    $l->riwayat_penyakit ?? '-',
                    $l->status,
                    $l->created_at->format('d/m/Y'),
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function create()
    {
        return view('admin.lansia.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'              => 'required|max:150',
            'umur'              => 'required|integer|min:1|max:150',
            'jenis_kelamin'     => 'required|in:L,P',
            'alamat'            => 'required',
            'desa'              => 'required|max:100',
            'kontak_keluarga'   => 'nullable|max:20',
            'riwayat_penyakit'  => 'nullable',
            'kondisi_kesehatan' => 'nullable|max:100',
            'status'            => 'required|in:Stabil,Perlu pemantauan,Rujukan segera',
            'lat'               => 'nullable|numeric',
            'lng'               => 'nullable|numeric',
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
            'nama'              => 'required|max:150',
            'umur'              => 'required|integer|min:1|max:150',
            'jenis_kelamin'     => 'required|in:L,P',
            'alamat'            => 'required',
            'desa'              => 'required|max:100',
            'kontak_keluarga'   => 'nullable|max:20',
            'riwayat_penyakit'  => 'nullable',
            'kondisi_kesehatan' => 'nullable|max:100',
            'status'            => 'required|in:Stabil,Perlu pemantauan,Rujukan segera',
            'lat'               => 'nullable|numeric',
            'lng'               => 'nullable|numeric',
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
