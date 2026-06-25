<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendataanLansia;
use App\Exports\PendataanLansiaExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LansiaController extends Controller
{
    private function rules(): array
    {
        return [
            'desa'                => 'required|string|max:150',
            'jumlah_penduduk_l'   => 'required|integer|min:0',
            'jumlah_penduduk_p'   => 'required|integer|min:0',
            'bayi_baru_lahir_l'   => 'required|integer|min:0',
            'bayi_baru_lahir_p'   => 'required|integer|min:0',
            'usia_0_11_bulan_l'   => 'required|integer|min:0',
            'usia_0_11_bulan_p'   => 'required|integer|min:0',
            'usia_12_59_bulan_l'  => 'required|integer|min:0',
            'usia_12_59_bulan_p'  => 'required|integer|min:0',
            'usia_60_72_bulan_l'  => 'required|integer|min:0',
            'usia_60_72_bulan_p'  => 'required|integer|min:0',
            'usia_7_9_tahun_l'    => 'required|integer|min:0',
            'usia_7_9_tahun_p'    => 'required|integer|min:0',
            'usia_10_12_tahun_l'  => 'required|integer|min:0',
            'usia_10_12_tahun_p'  => 'required|integer|min:0',
            'usia_13_14_tahun_l'  => 'required|integer|min:0',
            'usia_13_14_tahun_p'  => 'required|integer|min:0',
            'usia_15_59_tahun_l'  => 'required|integer|min:0',
            'usia_15_59_tahun_p'  => 'required|integer|min:0',
            'usia_60_69_tahun_l'  => 'required|integer|min:0',
            'usia_60_69_tahun_p'  => 'required|integer|min:0',
            'usia_70_plus_l'      => 'required|integer|min:0',
            'usia_70_plus_p'      => 'required|integer|min:0',
        ];
    }

    public function index(Request $request)
    {
        $query = PendataanLansia::query();

        if ($request->filled('search')) {
            $query->where('desa', 'like', '%' . $request->search . '%');
        }

        $lansias = $query->orderBy('desa')->get();

        // Hitung total agregat untuk stats cards
        $totalPendudukL  = $lansias->sum('jumlah_penduduk_l');
        $totalPendudukP  = $lansias->sum('jumlah_penduduk_p');
        $totalLansiaL    = $lansias->sum('usia_60_69_tahun_l') + $lansias->sum('usia_70_plus_l');
        $totalLansiaP    = $lansias->sum('usia_60_69_tahun_p') + $lansias->sum('usia_70_plus_p');

        return view('admin.lansia.index', compact(
            'lansias',
            'totalPendudukL', 'totalPendudukP',
            'totalLansiaL', 'totalLansiaP'
        ));
    }

    public function export()
    {
        $filename = 'pendataan-lansia-' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new PendataanLansiaExport(), $filename);
    }

    public function create()
    {
        return view('admin.lansia.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $lansia = PendataanLansia::create($validated);

        $prioritasData = $request->input('prioritas', []);
        foreach ($prioritasData as $p) {
            if (!empty($p['nama_lansia'])) {
                $lansia->lansiaPrioritas()->create([
                    'nama_lansia'      => $p['nama_lansia'],
                    'umur'             => $p['umur'] ?? 0,
                    'riwayat_penyakit' => $p['riwayat_penyakit'],
                    'latitude'         => $p['latitude'],
                    'longitude'        => $p['longitude'],
                ]);
            }
        }

        return redirect()
            ->route('admin.lansia.index')
            ->with('success', 'Data desa ' . $validated['desa'] . ' berhasil ditambahkan.');
    }

    public function show(PendataanLansia $lansia)
    {
        return redirect()->route('admin.lansia.edit', $lansia);
    }

    public function edit(PendataanLansia $lansia)
    {
        return view('admin.lansia.edit', compact('lansia'));
    }

    public function update(Request $request, PendataanLansia $lansia)
    {
        $validated = $request->validate($this->rules());
        $lansia->update($validated);

        $prioritasData = $request->input('prioritas', []);
        
        $keepIds = collect($prioritasData)->pluck('id')->filter()->toArray();
        $lansia->lansiaPrioritas()->whereNotIn('id', $keepIds)->delete();

        foreach ($prioritasData as $p) {
            if (!empty($p['nama_lansia'])) {
                if (!empty($p['id'])) {
                    $lansia->lansiaPrioritas()->where('id', $p['id'])->update([
                        'nama_lansia'      => $p['nama_lansia'],
                        'umur'             => $p['umur'] ?? 0,
                        'riwayat_penyakit' => $p['riwayat_penyakit'],
                        'latitude'         => $p['latitude'],
                        'longitude'        => $p['longitude'],
                    ]);
                } else {
                    $lansia->lansiaPrioritas()->create([
                        'nama_lansia'      => $p['nama_lansia'],
                        'umur'             => $p['umur'] ?? 0,
                        'riwayat_penyakit' => $p['riwayat_penyakit'],
                        'latitude'         => $p['latitude'],
                        'longitude'        => $p['longitude'],
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.lansia.index')
            ->with('success', 'Data desa ' . $lansia->desa . ' berhasil diperbarui.');
    }

    public function destroy(PendataanLansia $lansia)
    {
        $nama = $lansia->desa;
        $lansia->delete();

        return redirect()
            ->route('admin.lansia.index')
            ->with('success', 'Data desa ' . $nama . ' berhasil dihapus.');
    }
}
