@extends('layouts.sigap')

@section('title', $berita->judul . ' - SIGAP TUHA')

@section('content')
    <div class="page-content" style="max-width: 800px; margin: 0 auto;">
        <div style="margin-bottom: 24px;">
            <a href="{{ route('berita') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-secondary); text-decoration: none; font-weight: 500; font-size: 14px; transition: color 0.2s;" onmouseover="this.style.color='var(--brand-600)'" onmouseout="this.style.color='var(--text-secondary)'">
                <i class="fas fa-arrow-left"></i> Kembali ke Berita
            </a>
        </div>

        <div class="content-box" style="padding: 0; overflow: hidden; border-radius: var(--radius-xl);">
            @if($berita->gambar)
                <img src="{{ asset($berita->gambar) }}" alt="{{ $berita->judul }}" style="width: 100%; max-height: 400px; object-fit: cover;">
            @endif

            <div style="padding: 32px;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px; color: var(--text-tertiary); font-size: 14px;">
                    <span><i class="fas fa-calendar-alt"></i> {{ $berita->created_at->format('d F Y') }}</span>
                    <span><i class="fas fa-user-edit"></i> Admin</span>
                </div>

                <h1 style="font-size: 32px; font-weight: 800; color: var(--text-primary); margin-bottom: 24px; line-height: 1.3;">
                    {{ $berita->judul }}
                </h1>

                <div class="article-content" style="line-height: 1.8; color: var(--text-secondary); font-size: 16px;">
                    {!! nl2br(e($berita->konten)) !!}
                </div>
            </div>
        </div>
    </div>
@endsection
