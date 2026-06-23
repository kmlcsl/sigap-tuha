<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluasiPrePostTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'edukasi_id',
        'nama_pelatihan',
        'nama_peserta',
        'tanggal',
        'nilai_pre_test',
        'nilai_post_test',
        'keterangan',
    ];

    public function getPeningkatanAttribute()
    {
        return ($this->nilai_post_test ?? 0) - $this->nilai_pre_test;
    }
}
