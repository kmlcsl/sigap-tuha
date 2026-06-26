<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSoalMonev extends Model
{
    use HasFactory;

    protected $table = 'master_soal_monevs';
    protected $primaryKey = 'id_soal';

    protected $fillable = [
        'id_kegiatan',
        'pertanyaan',
        'jenis_test',
        'urutan',
        'is_active',
    ];

    public function kegiatanMaster()
    {
        return $this->belongsTo(MasterKegiatanMonev::class, 'id_kegiatan', 'id_kegiatan');
    }

    public function jawabanSoal()
    {
        return $this->hasMany(JawabanSoalMonev::class, 'id_soal');
    }
}
