<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganisasiRelawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_organisasi',
        'singkatan',
        'deskripsi',
        'kontak_wa',
        'kontak_telepon',
        'email',
        'bidang_keahlian',
        'alamat',
        'is_active',
        'urutan',
    ];



    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }

    public function getWaLinkAttribute()
    {
        if ($this->kontak_wa) {
            $wa = preg_replace('/[^0-9]/', '', $this->kontak_wa);
            if (substr($wa, 0, 1) == '0') {
                $wa = '62' . substr($wa, 1);
            }
            return 'https://wa.me/' . $wa;
        }
        return null;
    }
}
