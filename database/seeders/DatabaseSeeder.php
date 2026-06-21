<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Feature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@sigaptuha.id'],
            [
                'name' => 'Admin SIGAP TUHA',
                'password' => Hash::make('password123'),
            ]
        );

        // Initial Features
        $initialFeatures = [
            [
                'title' => 'Pendataan Lansia',
                'description' => 'Data lansia selalu terupdate dan akurat',
                'color_class' => 'blue',
                'icon_svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><circle cx="8" cy="8" r="3"/><circle cx="16" cy="8" r="3"/><path d="M2 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/><path d="M14 14c3.3 0 6 2.7 6 6" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
                'order' => 1
            ],
            [
                'title' => 'Bantuan Darurat',
                'description' => 'Respon cepat saat situasi darurat',
                'color_class' => 'gold',
                'icon_svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5h6v2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M12 11v5M9.5 13.5h5" stroke="#fff" stroke-width="2"/></svg>',
                'order' => 2
            ],
            [
                'title' => 'Edukasi & Pelatihan',
                'description' => 'Tingkatkan pengetahuan dan keterampilan',
                'color_class' => 'red',
                'icon_svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 5c3-1.5 6-1.5 9 0v14c-3-1.5-6-1.5-9 0V5z"/><path d="M21 5c-3-1.5-6-1.5-9 0v14c3-1.5 6-1.5 9 0V5z"/></svg>',
                'order' => 3
            ],
            [
                'title' => 'Relawan Siaga',
                'description' => 'Relawan terlatih, masyarakat terlindungi',
                'color_class' => 'blue',
                'icon_svg' => '<svg viewBox="0 0 24 24" fill="currentColor"><circle cx="7" cy="8" r="2.5"/><circle cx="17" cy="8" r="2.5"/><circle cx="12" cy="7" r="3"/><path d="M2 19c0-2.8 2.2-5 5-5M22 19c0-2.8-2.2-5-5-5M6 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/></svg>',
                'order' => 4
            ],
            [
                'title' => 'Monitoring & Evaluasi',
                'description' => 'Pantau kegiatan dan evaluasi berkelanjutan',
                'color_class' => 'gold',
                'icon_svg' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19V5M4 19h16"/><path d="M7 15l3-4 3 2 4-6"/></svg>',
                'order' => 5
            ],
        ];

        foreach ($initialFeatures as $feat) {
            Feature::updateOrCreate(['title' => $feat['title']], $feat);
        }
    }
}
