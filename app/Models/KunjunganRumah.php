<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KunjunganRumah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lansia',
        'lansia_id',
        'nama_relawan',
        'tanggal_kunjungan',
        'kondisi_fisik',
        'kondisi_psikologis',
        'catatan',
        'tindak_lanjut',
    ];

    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }
}
