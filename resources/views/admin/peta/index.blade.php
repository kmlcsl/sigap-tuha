@extends('layouts.admin')
@section('header_title', 'Peta Sebaran Lansia')
@section('content')
<div class="page-header">
    <h1 class="page-header__title">Peta Sebaran Lansia</h1>
    <p class="page-header__desc">Visualisasi lokasi lansia yang terdaftar dalam sistem.</p>
</div>

<div class="card">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-map-marked-alt"></i> Data Lokasi Lansia</h3>
        <span style="font-size:13px; color:var(--text-tertiary);"><i class="fas fa-info-circle"></i> {{ $lansias->count() }} lansia memiliki data koordinat</span>
    </div>

    @if($lansias->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-map"></i></div>
            <div class="empty-state__title">Belum Ada Data Lokasi</div>
            <div class="empty-state__desc">Belum ada lansia yang memiliki data koordinat (latitude/longitude). Tambahkan koordinat saat menginput data lansia.</div>
            <a href="{{ route('admin.lansia.index') }}" class="btn btn-primary"><i class="fas fa-users"></i> Lihat Data Lansia</a>
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th><i class="fas fa-user" style="margin-right:4px"></i> Nama</th>
                        <th><i class="fas fa-map-pin" style="margin-right:4px"></i> Desa</th>
                        <th><i class="fas fa-flag" style="margin-right:4px"></i> Status</th>
                        <th><i class="fas fa-map" style="margin-right:4px"></i> Latitude</th>
                        <th><i class="fas fa-map" style="margin-right:4px"></i> Longitude</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lansias as $i => $lansia)
                    <tr>
                        <td><span style="font-weight:600; color:var(--text-tertiary);">{{ $i + 1 }}</span></td>
                        <td><span style="font-weight:600; color:var(--text-primary);">{{ $lansia->nama }}</span></td>
                        <td>{{ $lansia->desa }}</td>
                        <td>
                            @if($lansia->status == 'Stabil')
                                <span class="badge badge--success"><span class="badge__dot"></span> Stabil</span>
                            @elseif($lansia->status == 'Perlu pemantauan')
                                <span class="badge badge--warning"><span class="badge__dot"></span> Pemantauan</span>
                            @else
                                <span class="badge badge--danger"><span class="badge__dot"></span> Rujukan</span>
                            @endif
                        </td>
                        <td style="font-family:'JetBrains Mono', monospace; font-size:12.5px;">{{ $lansia->lat }}</td>
                        <td style="font-family:'JetBrains Mono', monospace; font-size:12.5px;">{{ $lansia->lng }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
