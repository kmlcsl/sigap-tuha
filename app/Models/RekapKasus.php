<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapKasus extends Model
{
    use HasFactory;
    
    protected $table = 'rekap_kasus';

    protected $fillable = [
        'jenis_kasus',
        'deskripsi_kasus',
        'nama_lansia',
        'tanggal_kejadian',
        'status_penanganan',
        'penanganan',
    ];
}
