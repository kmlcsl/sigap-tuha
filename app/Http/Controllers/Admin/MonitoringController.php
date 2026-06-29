<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KegiatanMonev;
use App\Models\JawabanSoalMonev;
use App\Models\MasterSoalMonev;
use App\Models\MasterKegiatanMonev;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    public function index()
    {
        $monevs = KegiatanMonev::with('jawabanSoal')->orderBy('created_at', 'desc')->get();
        $maxSoal = 0;
        foreach ($monevs as $m) {
            $kMaster = MasterKegiatanMonev::where('nama_kegiatan', $m->nama_kegiatan)->first();
            if ($kMaster) {
                $c = MasterSoalMonev::where('id_kegiatan', $kMaster->id_kegiatan)->count();
                if ($c > $maxSoal) $maxSoal = $c;
            }
        }
        if ($maxSoal == 0) $maxSoal = 1;
        return view('admin.monitoring.index', compact('monevs', 'maxSoal'));
    }

    public function show(int $id_monev)
    {
        $monev = KegiatanMonev::with(['jawabanSoal.masterSoal'])->findOrFail($id_monev);
        $kMaster = MasterKegiatanMonev::where('nama_kegiatan', $monev->nama_kegiatan)->first();
        $id_keg = $kMaster ? $kMaster->id_kegiatan : 0;
        $masterSoals = MasterSoalMonev::where('is_active', true)->where('id_kegiatan', $id_keg)->orderBy('urutan')->get();
        $masterKegiatan = MasterKegiatanMonev::where('is_active', true)->get();
        return view('admin.monitoring.show', compact('monev', 'masterSoals', 'masterKegiatan'));
    }

    public function destroy(int $id_monev)
    {
        $monev = KegiatanMonev::findOrFail($id_monev);
        $monev->delete();
        return redirect()->route('admin.monitoring.index')->with('success', 'Data Monev berhasil dihapus.');
    }

    public function kegiatanIndex()
    {
        $kegiatans = MasterKegiatanMonev::orderBy('created_at', 'desc')->get();
        return view('admin.monitoring.kegiatan', compact('kegiatans'));
    }

    public function kegiatanStore(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        MasterKegiatanMonev::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.monitoring.kegiatan.index')->with('success', 'Kegiatan Monev berhasil ditambahkan.');
    }

    public function kegiatanUpdate(Request $request, int $id)
    {
        $kegiatan = MasterKegiatanMonev::findOrFail($id);
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kegiatan->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.monitoring.kegiatan.index')->with('success', 'Kegiatan Monev berhasil diupdate.');
    }

    public function kegiatanDestroy(int $id)
    {
        $kegiatan = MasterKegiatanMonev::findOrFail($id);
        $kegiatan->delete();
        return redirect()->route('admin.monitoring.kegiatan.index')->with('success', 'Kegiatan Monev berhasil dihapus.');
    }

    public function soalPerKegiatan(int $id_kegiatan)
    {
        $kegiatan = MasterKegiatanMonev::findOrFail($id_kegiatan);
        $soals = MasterSoalMonev::where('id_kegiatan', $id_kegiatan)->orderBy('urutan')->get();
        return view('admin.monitoring.soal', compact('kegiatan', 'soals'));
    }

    public function soalStore(Request $request)
    {
        $request->validate([
            'id_kegiatan' => 'required|exists:master_kegiatan_monevs,id_kegiatan',
            'pertanyaan' => 'required|string',
            'jenis_test' => 'required|in:PRE,POST,BOTH',
            'urutan' => 'required|integer',
            'is_active' => 'boolean'
        ]);

        MasterSoalMonev::create([
            'id_kegiatan' => $request->id_kegiatan,
            'pertanyaan' => $request->pertanyaan,
            'jenis_test' => $request->jenis_test,
            'urutan' => $request->urutan,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.monitoring.kegiatan.soal', $request->id_kegiatan)->with('success', 'Soal berhasil ditambahkan.');
    }

    public function soalUpdate(Request $request, int $id)
    {
        $soal = MasterSoalMonev::findOrFail($id);
        $request->validate([
            'pertanyaan' => 'required|string',
            'jenis_test' => 'required|in:PRE,POST,BOTH',
            'urutan' => 'required|integer',
        ]);

        $soal->update([
            'pertanyaan' => $request->pertanyaan,
            'jenis_test' => $request->jenis_test,
            'urutan' => $request->urutan,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.monitoring.kegiatan.soal', $soal->id_kegiatan)->with('success', 'Soal berhasil diupdate.');
    }

    public function soalDestroy(int $id)
    {
        $soal = MasterSoalMonev::findOrFail($id);
        $id_kegiatan = $soal->id_kegiatan;
        $soal->delete();
        return redirect()->route('admin.monitoring.kegiatan.soal', $id_kegiatan)->with('success', 'Soal berhasil dihapus.');
    }

    public function publicIndex()
    {
        $kegiatans = MasterKegiatanMonev::where('is_active', true)->get();
        $masterSoals = MasterSoalMonev::where('is_active', true)->orderBy('urutan')->get();
        return view('monev.index', compact('kegiatans', 'masterSoals'));
    }

    public function storePreTest(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat_user' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'nama_kegiatan' => 'required|string|max:255',
            'jawaban' => 'required|array',
            'pre_pemahaman_deskripsi' => 'nullable|string'
        ]);

        $umur = Carbon::parse($request->tanggal_lahir)->age;

        // Cek apakah user sudah pre-test untuk kegiatan ini
        $existing = KegiatanMonev::where('nama_user', $request->nama_user)
            ->where('no_hp', $request->no_hp)
            ->where('nama_kegiatan', $request->nama_kegiatan)
            ->first();

        if ($existing && $existing->waktu_isi_pre) {
            return redirect()->back()->with('error', 'Anda sudah mengisi Pre-Test untuk kegiatan ini.');
        }

        $monev = $existing ?: new KegiatanMonev();
        $monev->nama_user = $request->nama_user;
        $monev->tanggal_lahir = $request->tanggal_lahir;
        $monev->umur_user = $umur;
        $monev->alamat_user = $request->alamat_user;
        $monev->no_hp = $request->no_hp;
        $monev->nama_kegiatan = $request->nama_kegiatan;
        $monev->pre_pemahaman_deskripsi = $request->pre_pemahaman_deskripsi;
        $monev->waktu_isi_pre = now();
        $monev->save();

        foreach ($request->jawaban as $id_soal => $pilihan) {
            JawabanSoalMonev::updateOrCreate(
                ['id_monev' => $monev->id_monev, 'jenis_test' => 'PRE', 'id_soal' => $id_soal],
                ['pilihan_jawaban' => $pilihan]
            );
        }

        return redirect()->route('monev.index')->with('success', 'Pre-Test berhasil dikirim!');
    }

    public function storePostTest(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'nama_kegiatan' => 'required|string|max:255',
            'jawaban' => 'required|array',
            'post_pemahaman_deskripsi' => 'nullable|string'
        ]);

        // Cari data monev berdasarkan nama, hp, dan kegiatan
        $monev = KegiatanMonev::where('nama_user', $request->nama_user)
            ->where('no_hp', $request->no_hp)
            ->where('nama_kegiatan', $request->nama_kegiatan)
            ->first();

        if (!$monev) {
            return redirect()->back()->with('error', 'Data tidak ditemukan! Pastikan Nama, No HP, dan Kegiatan sama dengan saat mengisi Pre-Test.');
        }

        if ($monev->waktu_isi_post) {
            return redirect()->back()->with('error', 'Anda sudah mengisi Post-Test untuk kegiatan ini.');
        }

        $monev->update([
            'post_pemahaman_deskripsi' => $request->post_pemahaman_deskripsi,
            'waktu_isi_post' => now(),
        ]);

        foreach ($request->jawaban as $id_soal => $pilihan) {
            JawabanSoalMonev::create([
                'id_monev' => $monev->id_monev,
                'jenis_test' => 'POST',
                'id_soal' => $id_soal,
                'pilihan_jawaban' => $pilihan
            ]);
        }

        return redirect()->route('monev.index')->with('success', 'Post-Test berhasil dikirim! Terima kasih atas partisipasi Anda.');
    }
}
