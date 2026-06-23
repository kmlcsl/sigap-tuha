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
            'kecamatan'           => 'required|string|max:150',
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
            $query->where('kecamatan', 'like', '%' . $request->search . '%');
        }

        $lansias = $query->orderBy('kecamatan')->get();

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
        PendataanLansia::create($validated);

        return redirect()
            ->route('admin.lansia.index')
            ->with('success', 'Data kecamatan ' . $validated['kecamatan'] . ' berhasil ditambahkan.');
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
        $rules = $this->rules();
        // Unique kecamatan ignoring current record
        $rules['kecamatan'] = 'required|string|max:150|unique:pendataan_lansias,kecamatan,' . $lansia->id;

        $validated = $request->validate($rules);
        $lansia->update($validated);

        return redirect()
            ->route('admin.lansia.index')
            ->with('success', 'Data kecamatan ' . $lansia->kecamatan . ' berhasil diperbarui.');
    }

    public function destroy(PendataanLansia $lansia)
    {
        $nama = $lansia->kecamatan;
        $lansia->delete();

        return redirect()
            ->route('admin.lansia.index')
            ->with('success', 'Data kecamatan ' . $nama . ' berhasil dihapus.');
    }
}
