<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiPelatihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'edukasi_id',
        'nama_pelatihan',
        'tanggal',
        'nama_peserta',
        'organisasi',
        'hadir',
        'keterangan',
    ];

    public function edukasi()
    {
        return $this->belongsTo(Edukasi::class);
    }
}
