<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSoalMonev extends Model
{
    use HasFactory;

    protected $table = 'jawaban_soal_monevs';
    protected $primaryKey = 'id_jawaban';

    protected $fillable = [
        'id_monev',
        'jenis_test',
        'id_soal',
        'pilihan_jawaban',
    ];

    public function kegiatanMonev()
    {
        return $this->belongsTo(KegiatanMonev::class, 'id_monev', 'id_monev');
    }

    public function masterSoal()
    {
        return $this->belongsTo(MasterSoalMonev::class, 'id_soal');
    }
}
