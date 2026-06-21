<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanDarurat extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laporan_darurats';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'lansia_id',
        'pelapor',
        'kondisi',
        'lokasi',
        'tingkat_urgensi',
        'status',
        'catatan_tindakan',
    ];

    /**
     * Get the lansia that owns the laporan darurat.
     */
    public function lansia(): BelongsTo
    {
        return $this->belongsTo(Lansia::class);
    }
}
