<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKegiatanMonev extends Model
{
    use HasFactory;

    protected $table = 'master_kegiatan_monevs';
    protected $primaryKey = 'id_kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'foto',
        'is_active',
    ];

    public function soals()
    {
        return $this->hasMany(MasterSoalMonev::class, 'id_kegiatan', 'id_kegiatan');
    }
}
