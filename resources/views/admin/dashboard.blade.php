@extends('layouts.admin')

@section('header_title', 'Dashboard Overview')

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <h1 class="page-header__title">Dashboard Overview</h1>
    <p class="page-header__desc">Selamat datang kembali! Berikut ringkasan data dan aktivitas terbaru SIGAP TUHA.</p>
</div>

{{-- Stats Cards --}}
<div class="stats-grid">
    <div class="stat-card brand">
        <div class="stat-card__top">
            <span class="stat-card__label">Total Fitur</span>
            <div class="stat-card__icon brand">
                <i class="fas fa-puzzle-piece"></i>
            </div>
        </div>
        <div class="stat-card__value">{{ $featureCount }}</div>
        <div class="stat-card__change up">
            <i class="fas fa-arrow-up" style="font-size:10px"></i> Aktif
        </div>
    </div>

    <div class="stat-card success">
        <div class="stat-card__top">
            <span class="stat-card__label">Desa Terdata</span>
            <div class="stat-card__icon success">
                <i class="fas fa-map-marked-alt"></i>
            </div>
        </div>
        <div class="stat-card__value">{{ $desaCount }}</div>
        <div class="stat-card__change up">
            <i class="fas fa-arrow-up" style="font-size:10px"></i> Aktif
        </div>
    </div>

    <div class="stat-card warning">
        <div class="stat-card__top">
            <span class="stat-card__label">Lansia Prioritas</span>
            <div class="stat-card__icon warning">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-card__value">{{ $lansiaPrioritasCount }}</div>
        <div class="stat-card__change up">
            <i class="fas fa-arrow-up" style="font-size:10px"></i> Aktif
        </div>
    </div>

    <div class="stat-card danger">
        <div class="stat-card__top">
            <span class="stat-card__label">Kontak Darurat</span>
            <div class="stat-card__icon danger">
                <i class="fas fa-phone-alt"></i>
            </div>
        </div>
        <div class="stat-card__value">{{ $bantuanCount }}</div>
        <div class="stat-card__change up">
            <i class="fas fa-arrow-up" style="font-size:10px"></i> Tersedia
        </div>
    </div>
</div>

{{-- Grid: Welcome + Quick Actions --}}
<div class="grid grid-2" style="margin-bottom: 28px;">
    {{-- Welcome Card --}}
    <div class="card" style="background: #ccfbf1; border: none;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-hand-sparkles" style="color: #0d9488;"></i> Selamat Datang</h3>
        </div>
        <div style="display:flex; gap:16px; align-items:flex-start;">
            <div style="width:52px; height:52px; border-radius:var(--radius-xl); background:linear-gradient(135deg, #0d9488, #0f766e); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-shield-alt" style="font-size:22px; color:#fff;"></i>
            </div>
            <div>
                <h4 style="font-size:16px; font-weight:700; color:var(--text-primary); margin-bottom:6px;">Panel Kontrol SIGAP TUHA</h4>
                <p style="font-size:13.5px; color:var(--text-secondary); line-height:1.7; margin-bottom:16px;">
                    Kelola konten landing page, pantau pendataan lansia, tanggapi pesan masuk, dan kelola kontak bantuan darurat dari satu tempat terpusat.
                </p>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <a href="{{ route('admin.features.index') }}" class="btn btn-primary btn-sm" style="background: #0f766e;">
                        <i class="fas fa-star"></i> Kelola Fitur
                    </a>
                    <a href="{{ route('beranda') }}" class="btn btn-outline btn-sm" target="_blank" style="border-color: #0d9488; color: #0f766e;">
                        <i class="fas fa-external-link-alt"></i> Lihat Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="card" style="background: #f3e8ff; border: none;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-chart-pie" style="color: #9333ea;"></i> Ringkasan Cepat</h3>
        </div>
        <div style="display:flex; flex-direction:column; gap:16px;">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 16px; background:var(--gray-50); border-radius:var(--radius-md);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-puzzle-piece" style="color:var(--success-500);"></i>
                    <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Total Fitur Aktif</span>
                </div>
                <span style="font-size:15px; font-weight:700; color:var(--text-primary);">{{ $featureCount }}</span>
            </div>
            <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 16px; background:var(--gray-50); border-radius:var(--radius-md);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-map" style="color:var(--warning-500);"></i>
                    <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Total Desa Terdata</span>
                </div>
                <span style="font-size:15px; font-weight:700; color:var(--text-primary);">{{ $desaCount }}</span>
            </div>
            <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 16px; background:var(--gray-50); border-radius:var(--radius-md);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-book-medical" style="color:var(--danger-500);"></i>
                    <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Modul Edukasi</span>
                </div>
                <span style="font-size:15px; font-weight:700; color:var(--text-primary);">{{ $edukasiCount }}</span>
            </div>
            <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 16px; background:var(--gray-50); border-radius:var(--radius-md);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-user-friends" style="color:var(--brand-500);"></i>
                    <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Organisasi Relawan</span>
                </div>
                <span style="font-size:15px; font-weight:700; color:var(--text-primary);">{{ $relawanCount }}</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-2">
    {{-- Pesan Masuk Terbaru --}}
    <div class="card" style="background: #ffe4e6; border: none;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-envelope" style="color: #e11d48;"></i> Pesan Masuk Terbaru</h3>
            <a href="{{ route('admin.kontak.index') }}" class="card__action" style="text-decoration:none; font-size:13px; font-weight:600; color:#e11d48;">Lihat semua <i class="fas fa-arrow-right" style="font-size:10px;"></i></a>
        </div>
        <div class="activity-list">
            @forelse($pesanTerbaru as $pesan)
            <div class="activity-item" style="padding: 16px; border-bottom: 1px solid rgba(0,0,0,0.05); {{ !$pesan->is_read ? 'background: rgba(225,29,72,0.05);' : '' }}">
                <div class="activity-item__icon" style="background:var(--brand-50); color:var(--brand-600); flex-shrink: 0;">
                    <i class="fas fa-user"></i>
                </div>
                <div class="activity-item__content" style="flex: 1;">
                    <div class="activity-item__title" style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span style="font-weight: 700; color: var(--text-primary);">{{ $pesan->nama_lengkap }}</span>
                        @if(!$pesan->is_read)
                            <span style="padding: 2px 6px; background: var(--danger-500); color: white; border-radius: 10px; font-size: 10px; font-weight: bold;">BARU</span>
                        @endif
                    </div>
                    <div class="activity-item__desc" style="font-size: 13px; color: var(--text-secondary); margin-bottom: 8px;">{{ Str::limit($pesan->isi_pesan, 80) }}</div>
                    <div class="activity-item__time" style="font-size: 11px; color: var(--text-tertiary);"><i class="far fa-clock"></i> {{ $pesan->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @empty
            <div style="padding: 24px; text-align: center; color: var(--text-placeholder); font-size: 14px;">Belum ada pesan masuk.</div>
            @endforelse
        </div>
    </div>

    {{-- Data Lansia Terbaru --}}
    <div class="card" style="background: #e0f2fe; border: none;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-users" style="color: #0284c7;"></i> Data Lansia Terbaru</h3>
            <a href="{{ route('admin.lansia.index') }}" class="card__action" style="text-decoration:none; font-size:13px; font-weight:600; color:#0284c7;">Lihat semua <i class="fas fa-arrow-right" style="font-size:10px;"></i></a>
        </div>
        <div class="activity-list">
            @forelse($pendataanLansiaTerbaru as $lansia)
            <div class="activity-item" style="padding: 16px; border-bottom: 1px solid rgba(0,0,0,0.05);">
                <div class="activity-item__icon" style="background:var(--info-50); color:var(--info-600); flex-shrink: 0;">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="activity-item__content" style="flex: 1;">
                    <div class="activity-item__title" style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span style="font-weight: 700; color: var(--text-primary);">Desa {{ $lansia->desa }}</span>
                    </div>
                    <div class="activity-item__desc" style="font-size: 13px; color: var(--text-secondary); margin-bottom: 8px;">
                        Total Penduduk: {{ $lansia->jumlah_penduduk_total }} jiwa<br>
                        Total Lansia: {{ $lansia->total_lansia_total }} jiwa
                    </div>
                    <div class="activity-item__time" style="font-size: 11px; color: var(--text-tertiary);"><i class="far fa-clock"></i> {{ $lansia->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @empty
            <div style="padding: 24px; text-align: center; color: var(--text-placeholder); font-size: 14px;">Belum ada data lansia.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
