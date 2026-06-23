<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $column = 'order';
        $features = Feature::query()->orderBy($column)->get();
        return view('beranda', ['features' => $features]);
    }

    public function profil()
    {
        $profil = \App\Models\Profil::first();
        return view('profil', compact('profil'));
    }

    public function kontak()
    {
        $kontak = \App\Models\Kontak::first();
        return view('kontak', compact('kontak'));
    }

    public function berita()
    {
        $beritas = \App\Models\Berita::where('status', 'published')->latest()->get();
        return view('berita', compact('beritas'));
    }

    public function beritaDetail($slug)
    {
        $berita = \App\Models\Berita::where('slug', $slug)->where('status', 'published')->firstOrFail();
        return view('berita_detail', compact('berita'));
    }

    public function lansia()
    {
        $lansias = \App\Models\Lansia::orderBy('nama')->get();
        return view('lansia.index', compact('lansias'));
    }

    public function bantuanDarurat()
    {
        $bantuan = \App\Models\BantuanDarurat::aktif()->get();
        return view('bantuan.index', compact('bantuan'));
    }

    public function edukasi()
    {
        $edukasi = \App\Models\Edukasi::where('is_published', true)->orderBy('order')->get();
        return view('edukasi.index', compact('edukasi'));
    }

    public function edukasiDetail($id)
    {
        $edukasi = \App\Models\Edukasi::where('is_published', true)
            ->where(function($query) use ($id) {
                $query->where('id', $id)->orWhere('slug', $id);
            })->firstOrFail();
        return view('edukasi.detail', compact('edukasi'));
    }

    public function relawan()
    {
        $organisasi = \App\Models\OrganisasiRelawan::aktif()->with('relawans')->get();
        return view('relawan.index', compact('organisasi'));
    }

    public function fitur($slug)
    {
        $features = Feature::all();
        $feature = $features->first(function ($item) use ($slug) {
            return \Illuminate\Support\Str::slug($item->title) === $slug;
        });

        if (!$feature) {
            $staticFeatures = [
                1 => [
                    'id' => 1,
                    'title' => 'Pendataan Lansia',
                    'description' => 'Data lansia selalu terupdate dan akurat',
                    'icon_svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><circle cx="8" cy="8" r="3"/><circle cx="16" cy="8" r="3"/><path d="M2 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/><path d="M14 14c3.3 0 6 2.7 6 6" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
                    'color_class' => 'blue',
                    'route' => 'lansia'
                ],
                2 => [
                    'id' => 2,
                    'title' => 'Bantuan Darurat',
                    'description' => 'Respon cepat saat situasi darurat',
                    'icon_svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5h6v2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M12 11v5M9.5 13.5h5" stroke="#fff" stroke-width="2"/></svg>',
                    'color_class' => 'gold',
                    'route' => 'bantuan'
                ],
                3 => [
                    'id' => 3,
                    'title' => 'Edukasi & Pelatihan',
                    'description' => 'Tingkatkan pengetahuan dan keterampilan',
                    'icon_svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 5c3-1.5 6-1.5 9 0v14c-3-1.5-6-1.5-9 0V5z"/><path d="M21 5c-3-1.5-6-1.5-9 0v14c3-1.5 6-1.5 9 0V5z"/></svg>',
                    'color_class' => 'red',
                    'route' => 'edukasi'
                ],
                4 => [
                    'id' => 4,
                    'title' => 'Relawan Siaga',
                    'description' => 'Relawan terlatih, masyarakat terlindungi',
                    'icon_svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><circle cx="7" cy="8" r="2.5"/><circle cx="17" cy="8" r="2.5"/><circle cx="12" cy="7" r="3"/><path d="M2 19c0-2.8 2.2-5 5-5M22 19c0-2.8-2.2-5-5-5M6 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/></svg>',
                    'color_class' => 'blue',
                    'route' => 'relawan'
                ],
                5 => [
                    'id' => 5,
                    'title' => 'Monitoring & Evaluasi',
                    'description' => 'Pantau kegiatan dan evaluasi berkelanjutan',
                    'icon_svg' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19V5M4 19h16"/><path d="M7 15l3-4 3 2 4-6"/></svg>',
                    'color_class' => 'gold',
                    'route' => 'login' // monitoring admin only
                ],
            ];

            $featureArray = collect($staticFeatures)->first(function ($item) use ($slug) {
                return \Illuminate\Support\Str::slug($item['title']) === $slug;
            });

            if (!$featureArray) {
                abort(404);
            }

            if (isset($featureArray['route'])) {
                return redirect()->route($featureArray['route']);
            }

            $feature = (object) $featureArray;
        }

        return view('fitur', ['feature' => $feature]);
    }
}
