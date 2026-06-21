<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lansia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'umur',
        'jenis_kelamin',
        'alamat',
        'desa',
        'kontak_keluarga',
        'riwayat_penyakit',
        'kondisi_kesehatan',
        'status',
        'lat',
        'lng',
    ];

    /**
     * Get the laporan darurats for the lansia.
     */
    public function laporanDarurats(): HasMany
    {
        return $this->hasMany(LaporanDarurat::class);
    }
}
