<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LansiaPrioritas extends Model
{
    protected $table = 'lansia_prioritas';

    protected $fillable = [
        'pendataan_lansia_id',
        'nama_lansia',
        'umur',
        'riwayat_penyakit',
        'latitude',
        'longitude',
    ];

    public function desa()
    {
        return $this->belongsTo(PendataanLansia::class, 'pendataan_lansia_id');
    }
}
