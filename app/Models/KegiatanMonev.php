<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanMonev extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_monevs';
    protected $primaryKey = 'id_monev';

    protected $fillable = [
        'nama_user',
        'tanggal_lahir',
        'umur_user',
        'alamat_user',
        'no_hp',
        'nama_kegiatan',
        'keterangan_kegiatan',
        'pre_pemahaman_deskripsi',
        'post_pemahaman_deskripsi',
        'waktu_isi_pre',
        'waktu_isi_post',
    ];

    protected $casts = [
        'waktu_isi_pre' => 'datetime',
        'waktu_isi_post' => 'datetime',
        'tanggal_lahir' => 'date',
    ];

    public function jawabanSoal()
    {
        return $this->hasMany(JawabanSoalMonev::class, 'id_monev', 'id_monev');
    }
}
