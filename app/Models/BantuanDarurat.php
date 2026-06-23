<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BantuanDarurat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_instansi',
        'jenis',
        'nomor_wa',
        'deskripsi',
        'urutan',
        'urutan',
        'is_active',
    ];

    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }

    public function getWaLinkAttribute()
    {
        return 'https://wa.me/' . $this->nomor_wa . '?text=' . urlencode('Halo, saya membutuhkan bantuan. Saya menghubungi melalui aplikasi SIGAP TUHA.');
    }
}
