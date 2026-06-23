<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'materi_pembahasan',
        'durasi_menit',
        'kategori',
        'jenis',
        'url_video',
        'is_published',
        'sertifikat_tersedia',
        'order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sertifikat_tersedia' => 'boolean',
        ];
    }

    /**
     * Extract YouTube video ID from various URL formats.
     */
    public function getYoutubeIdAttribute(): ?string
    {
        if (!$this->url_video) return null;

        $patterns = [
            '/youtu\.be\/([^#&?]*)/',
            '/youtube\.com\/watch\?v=([^#&?]*)/',
            '/youtube\.com\/embed\/([^#&?]*)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->url_video, $m)) {
                return $m[1];
            }
        }

        return null;
    }

    /**
     * Get the YouTube embed URL.
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (!$this->url_video) return null;
        return 'https://www.youtube.com/embed/' . $this->youtube_id . '?rel=0';
    }

    /**
     * Get the YouTube thumbnail URL.
     */
    public function getYoutubeThumbnailAttribute(): ?string
    {
        if (!$this->url_video) return null;
        return 'https://img.youtube.com/vi/' . $this->youtube_id . '/hqdefault.jpg';
    }
}
