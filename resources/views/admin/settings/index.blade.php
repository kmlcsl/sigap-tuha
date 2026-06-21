@extends('layouts.admin')
@section('header_title', 'Pengaturan')
@section('content')
<div class="page-header">
    <h1 class="page-header__title">Pengaturan Sistem</h1>
    <p class="page-header__desc">Informasi aplikasi dan konfigurasi sistem SIGAP TUHA.</p>
</div>

<div class="grid grid-2">
    {{-- Informasi Aplikasi --}}
    <div class="card">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-info-circle"></i> Informasi Aplikasi</h3>
        </div>
        <div style="display:flex; flex-direction:column; gap:16px;">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:var(--gray-50); border-radius:var(--radius-md);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-tag" style="color:var(--brand-500); font-size:14px;"></i>
                    <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Nama Aplikasi</span>
                </div>
                <span style="font-size:14px; font-weight:700; color:var(--text-primary);">{{ $app_name }}</span>
            </div>
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:var(--gray-50); border-radius:var(--radius-md);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-code-branch" style="color:var(--success-500); font-size:14px;"></i>
                    <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Versi Aplikasi</span>
                </div>
                <span class="badge badge--success">v{{ $app_version }}</span>
            </div>
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:var(--gray-50); border-radius:var(--radius-md);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fab fa-laravel" style="color:var(--danger-500); font-size:14px;"></i>
                    <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Laravel Version</span>
                </div>
                <span style="font-size:14px; font-weight:700; color:var(--text-primary); font-family:'JetBrains Mono', monospace; font-size:12.5px;">v{{ $laravel_version }}</span>
            </div>
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:var(--gray-50); border-radius:var(--radius-md);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fab fa-php" style="color:var(--brand-700); font-size:14px;"></i>
                    <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">PHP Version</span>
                </div>
                <span style="font-size:14px; font-weight:700; color:var(--text-primary); font-family:'JetBrains Mono', monospace; font-size:12.5px;">v{{ $php_version }}</span>
            </div>
        </div>
    </div>

    {{-- Environment --}}
    <div class="card">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-server"></i> Environment</h3>
        </div>
        <div style="display:flex; flex-direction:column; gap:16px;">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:var(--gray-50); border-radius:var(--radius-md);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-globe" style="color:var(--brand-500); font-size:14px;"></i>
                    <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Environment</span>
                </div>
                <span class="badge badge--warning">{{ app()->environment() }}</span>
            </div>
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:var(--gray-50); border-radius:var(--radius-md);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-bug" style="color:var(--warning-500); font-size:14px;"></i>
                    <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Debug Mode</span>
                </div>
                @if(config('app.debug'))
                    <span class="badge badge--warning"><span class="badge__dot"></span> Aktif</span>
                @else
                    <span class="badge badge--success"><span class="badge__dot"></span> Nonaktif</span>
                @endif
            </div>
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:var(--gray-50); border-radius:var(--radius-md);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-database" style="color:var(--success-500); font-size:14px;"></i>
                    <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Database Driver</span>
                </div>
                <span style="font-size:14px; font-weight:700; color:var(--text-primary); font-family:'JetBrains Mono', monospace; font-size:12.5px;">{{ config('database.default') }}</span>
            </div>
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:var(--gray-50); border-radius:var(--radius-md);">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-clock" style="color:var(--text-tertiary); font-size:14px;"></i>
                    <span style="font-size:13.5px; font-weight:500; color:var(--text-secondary);">Timezone</span>
                </div>
                <span style="font-size:14px; font-weight:700; color:var(--text-primary); font-family:'JetBrains Mono', monospace; font-size:12.5px;">{{ config('app.timezone') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
