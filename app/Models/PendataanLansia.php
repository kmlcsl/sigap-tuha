<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendataanLansia extends Model
{
    protected $table = 'pendataan_lansias';

    protected $fillable = [
        'kecamatan',
        'jumlah_penduduk_l',
        'jumlah_penduduk_p',
        'bayi_baru_lahir_l',
        'bayi_baru_lahir_p',
        'usia_0_11_bulan_l',
        'usia_0_11_bulan_p',
        'usia_12_59_bulan_l',
        'usia_12_59_bulan_p',
        'usia_60_72_bulan_l',
        'usia_60_72_bulan_p',
        'usia_7_9_tahun_l',
        'usia_7_9_tahun_p',
        'usia_10_12_tahun_l',
        'usia_10_12_tahun_p',
        'usia_13_14_tahun_l',
        'usia_13_14_tahun_p',
        'usia_15_59_tahun_l',
        'usia_15_59_tahun_p',
        'usia_60_69_tahun_l',
        'usia_60_69_tahun_p',
        'usia_70_plus_l',
        'usia_70_plus_p',
    ];

    protected $casts = [
        'jumlah_penduduk_l'  => 'integer',
        'jumlah_penduduk_p'  => 'integer',
        'bayi_baru_lahir_l'  => 'integer',
        'bayi_baru_lahir_p'  => 'integer',
        'usia_0_11_bulan_l'  => 'integer',
        'usia_0_11_bulan_p'  => 'integer',
        'usia_12_59_bulan_l' => 'integer',
        'usia_12_59_bulan_p' => 'integer',
        'usia_60_72_bulan_l' => 'integer',
        'usia_60_72_bulan_p' => 'integer',
        'usia_7_9_tahun_l'   => 'integer',
        'usia_7_9_tahun_p'   => 'integer',
        'usia_10_12_tahun_l' => 'integer',
        'usia_10_12_tahun_p' => 'integer',
        'usia_13_14_tahun_l' => 'integer',
        'usia_13_14_tahun_p' => 'integer',
        'usia_15_59_tahun_l' => 'integer',
        'usia_15_59_tahun_p' => 'integer',
        'usia_60_69_tahun_l' => 'integer',
        'usia_60_69_tahun_p' => 'integer',
        'usia_70_plus_l'     => 'integer',
        'usia_70_plus_p'     => 'integer',
    ];

    /** Total laki-laki semua kelompok usia sasaran (bukan jumlah penduduk) */
    public function getTotalSasaranLAttribute(): int
    {
        return $this->bayi_baru_lahir_l
            + $this->usia_0_11_bulan_l
            + $this->usia_12_59_bulan_l
            + $this->usia_60_72_bulan_l
            + $this->usia_7_9_tahun_l
            + $this->usia_10_12_tahun_l
            + $this->usia_13_14_tahun_l
            + $this->usia_15_59_tahun_l
            + $this->usia_60_69_tahun_l
            + $this->usia_70_plus_l;
    }

    /** Total perempuan semua kelompok usia sasaran */
    public function getTotalSasaranPAttribute(): int
    {
        return $this->bayi_baru_lahir_p
            + $this->usia_0_11_bulan_p
            + $this->usia_12_59_bulan_p
            + $this->usia_60_72_bulan_p
            + $this->usia_7_9_tahun_p
            + $this->usia_10_12_tahun_p
            + $this->usia_13_14_tahun_p
            + $this->usia_15_59_tahun_p
            + $this->usia_60_69_tahun_p
            + $this->usia_70_plus_p;
    }

    /** Grand total jumlah penduduk (L+P) */
    public function getJumlahPendudukTotalAttribute(): int
    {
        return $this->jumlah_penduduk_l + $this->jumlah_penduduk_p;
    }

    /** Total lansia (60-69 + 70+) L */
    public function getTotalLansiaLAttribute(): int
    {
        return $this->usia_60_69_tahun_l + $this->usia_70_plus_l;
    }

    /** Total lansia (60-69 + 70+) P */
    public function getTotalLansiaPAttribute(): int
    {
        return $this->usia_60_69_tahun_p + $this->usia_70_plus_p;
    }

    /** Total lansia keseluruhan */
    public function getTotalLansiaTotalAttribute(): int
    {
        return $this->total_lansia_l + $this->total_lansia_p;
    }

    /**
     * Kembalikan array detail usia lengkap (L, P, Total) untuk keperluan modal/popup.
     */
    public function getDetailUsiaArray(): array
    {
        return [
            ['label' => 'Jumlah Penduduk',    'l' => $this->jumlah_penduduk_l,  'p' => $this->jumlah_penduduk_p,  'total' => $this->jumlah_penduduk_l + $this->jumlah_penduduk_p],
            ['label' => 'Bayi Baru Lahir',     'l' => $this->bayi_baru_lahir_l,  'p' => $this->bayi_baru_lahir_p,  'total' => $this->bayi_baru_lahir_l + $this->bayi_baru_lahir_p],
            ['label' => 'Usia 0–11 Bulan',     'l' => $this->usia_0_11_bulan_l,  'p' => $this->usia_0_11_bulan_p,  'total' => $this->usia_0_11_bulan_l + $this->usia_0_11_bulan_p],
            ['label' => 'Usia 12–59 Bulan',    'l' => $this->usia_12_59_bulan_l, 'p' => $this->usia_12_59_bulan_p, 'total' => $this->usia_12_59_bulan_l + $this->usia_12_59_bulan_p],
            ['label' => 'Usia 60–72 Bulan',    'l' => $this->usia_60_72_bulan_l, 'p' => $this->usia_60_72_bulan_p, 'total' => $this->usia_60_72_bulan_l + $this->usia_60_72_bulan_p],
            ['label' => 'Usia 7–9 Tahun',      'l' => $this->usia_7_9_tahun_l,   'p' => $this->usia_7_9_tahun_p,   'total' => $this->usia_7_9_tahun_l + $this->usia_7_9_tahun_p],
            ['label' => 'Usia 10–12 Tahun',    'l' => $this->usia_10_12_tahun_l, 'p' => $this->usia_10_12_tahun_p, 'total' => $this->usia_10_12_tahun_l + $this->usia_10_12_tahun_p],
            ['label' => 'Usia 13–14 Tahun',    'l' => $this->usia_13_14_tahun_l, 'p' => $this->usia_13_14_tahun_p, 'total' => $this->usia_13_14_tahun_l + $this->usia_13_14_tahun_p],
            ['label' => 'Usia 15–59 Tahun',    'l' => $this->usia_15_59_tahun_l, 'p' => $this->usia_15_59_tahun_p, 'total' => $this->usia_15_59_tahun_l + $this->usia_15_59_tahun_p],
            ['label' => 'Usia 60–69 Tahun',    'l' => $this->usia_60_69_tahun_l, 'p' => $this->usia_60_69_tahun_p, 'total' => $this->usia_60_69_tahun_l + $this->usia_60_69_tahun_p],
            ['label' => 'Usia >70 Tahun',      'l' => $this->usia_70_plus_l,     'p' => $this->usia_70_plus_p,     'total' => $this->usia_70_plus_l + $this->usia_70_plus_p],
        ];
    }
}
