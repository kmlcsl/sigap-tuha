<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'nama' => 'Pendataan Lansia Rentan',
                'deskripsi' => 'Program pendataan untuk memetakan lansia rentan di tingkat gampong dan kecamatan secara berkala.',
                'kegiatan_count' => 10,
            ],
            [
                'nama' => 'Sistem Peringatan Dini Khusus Lansia',
                'deskripsi' => 'Edukasi dan penyediaan alat bantu serta jalur komunikasi cepat untuk kondisi darurat khusus lansia.',
                'kegiatan_count' => 5,
            ],
            [
                'nama' => 'Pelatihan Relawan Pendamping',
                'deskripsi' => 'Memberikan pelatihan Bantuan Hidup Dasar (BHD) dan pertolongan pertama kepada pemuda Karang Taruna.',
                'kegiatan_count' => 8,
            ],
            [
                'nama' => 'Distribusi Bantuan Logistik Lansia',
                'deskripsi' => 'Penyaluran bantuan pangan, vitamin, dan kebutuhan dasar khusus bagi lansia kurang mampu atau terdampak bencana.',
                'kegiatan_count' => 4,
            ]
        ];

        foreach ($programs as $index => $progData) {
            $program = \App\Models\Program::create([
                'nama' => $progData['nama'],
                'deskripsi' => $progData['deskripsi']
            ]);

            for ($i = 1; $i <= $progData['kegiatan_count']; $i++) {
                \App\Models\Kegiatan::create([
                    'program_id' => $program->id,
                    'nama' => 'Kegiatan ' . $i . ' - ' . $program->nama,
                    'foto' => 'https://picsum.photos/seed/' . ($program->id * 10 + $i) . '/400/300',
                    'deskripsi_lengkap' => 'Ini adalah detail lengkap untuk Kegiatan ' . $i . ' dari program ' . $program->nama . '. Kegiatan ini bertujuan untuk meningkatkan kesejahteraan lansia.'
                ]);
            }
        }
    }
}
