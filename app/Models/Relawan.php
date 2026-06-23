<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'organisasi_id',
        'nama_lengkap',
        'jabatan',
        'keahlian',
        'nomor_hp',
        'nomor_wa',
        'is_aktif',
        'keterangan',
    ];

    public function organisasiRelawan()
    {
        return $this->belongsTo(OrganisasiRelawan::class, 'organisasi_id');
    }
}
