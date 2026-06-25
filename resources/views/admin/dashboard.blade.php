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
                    Kelola konten landing page, pantau data lansia, dan kelola laporan darurat dari satu tempat terpusat. Pastikan semua informasi selalu akurat dan terbaru.
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

{{-- Grid: Recent Activity + Status --}}
<div class="grid grid-2">
    {{-- Aktivitas Terbaru --}}
    <div class="card" style="background: #ffe4e6; border: none;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-history" style="color: #e11d48;"></i> Aktivitas Terbaru</h3>
            <span class="card__action">Lihat semua <i class="fas fa-arrow-right" style="font-size:10px;"></i></span>
        </div>
        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-item__icon" style="background:var(--brand-50); color:var(--brand-600);">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="activity-item__content">
                    <div class="activity-item__title">Data lansia baru ditambahkan</div>
                    <div class="activity-item__desc">Input data lansia dari Desa Pandrah Kandeh.</div>
                    <div class="activity-item__time"><i class="far fa-clock"></i> 10 menit lalu</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-item__icon" style="background:var(--danger-50); color:var(--danger-500);">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="activity-item__content">
                    <div class="activity-item__title">Laporan darurat baru</div>
                    <div class="activity-item__desc">Lansia dengan sesak napas menunggu tindak lanjut.</div>
                    <div class="activity-item__time"><i class="far fa-clock"></i> 30 menit lalu</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-item__icon" style="background:var(--success-50); color:var(--success-500);">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="activity-item__content">
                    <div class="activity-item__title">Kunjungan rumah dijadwalkan</div>
                    <div class="activity-item__desc">5 lansia prioritas dijadwalkan dikunjungi hari ini.</div>
                    <div class="activity-item__time"><i class="far fa-clock"></i> 1 jam lalu</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-item__icon" style="background:var(--info-50); color:var(--info-500);">
                    <i class="fas fa-book-medical"></i>
                </div>
                <div class="activity-item__content">
                    <div class="activity-item__title">Materi edukasi diperbarui</div>
                    <div class="activity-item__desc">BHD versi terbaru siap dipublikasikan.</div>
                    <div class="activity-item__time"><i class="far fa-clock"></i> 2 jam lalu</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Keamanan --}}
    <div class="card" style="background: #e0f2fe; border: none;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-shield-alt" style="color: #0284c7;"></i> Status Sistem</h3>
        </div>
        <div style="display:flex; flex-direction:column; gap:18px;">
            {{-- Status Item --}}
            <div style="display:flex; align-items:center; gap:14px;">
                <div style="width:40px; height:40px; border-radius:var(--radius-full); background:var(--success-50); display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-server" style="color:var(--success-500); font-size:14px;"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:13.5px; font-weight:600; color:var(--text-primary);">Server Status</div>
                    <div style="font-size:12px; color:var(--text-tertiary);">Semua sistem berjalan normal</div>
                </div>
                <span class="badge badge--success"><span class="badge__dot"></span> Online</span>
            </div>

            <div style="display:flex; align-items:center; gap:14px;">
                <div style="width:40px; height:40px; border-radius:var(--radius-full); background:var(--success-50); display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-database" style="color:var(--success-500); font-size:14px;"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:13.5px; font-weight:600; color:var(--text-primary);">Database</div>
                    <div style="font-size:12px; color:var(--text-tertiary);">MySQL 8+ terhubung</div>
                </div>
                <span class="badge badge--success"><span class="badge__dot"></span> Aktif</span>
            </div>

            <div style="display:flex; align-items:center; gap:14px;">
                <div style="width:40px; height:40px; border-radius:var(--radius-full); background:var(--success-50); display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-lock" style="color:var(--success-500); font-size:14px;"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:13.5px; font-weight:600; color:var(--text-primary);">Keamanan</div>
                    <div style="font-size:12px; color:var(--text-tertiary);">Middleware & autentikasi aktif</div>
                </div>
                <span class="badge badge--success"><span class="badge__dot"></span> Aman</span>
            </div>

            <div style="display:flex; align-items:center; gap:14px;">
                <div style="width:40px; height:40px; border-radius:var(--radius-full); background:var(--warning-50); display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-hdd" style="color:var(--warning-500); font-size:14px;"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:13.5px; font-weight:600; color:var(--text-primary);">Penyimpanan</div>
                    <div style="font-size:12px; color:var(--text-tertiary);">67% terpakai dari total</div>
                </div>
                <span class="badge badge--warning"><span class="badge__dot"></span> 67%</span>
            </div>

            {{-- Storage Bar --}}
            <div style="margin-top:4px;">
                <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                    <span style="font-size:12px; font-weight:600; color:var(--text-tertiary);">Kapasitas Storage</span>
                    <span style="font-size:12px; font-weight:700; color:var(--text-primary);">6.7 GB / 10 GB</span>
                </div>
                <div style="height:8px; background:var(--gray-100); border-radius:var(--radius-full); overflow:hidden;">
                    <div style="height:100%; width:67%; background:linear-gradient(90deg, var(--brand-500), var(--warning-500)); border-radius:var(--radius-full); transition: width 1s ease;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
