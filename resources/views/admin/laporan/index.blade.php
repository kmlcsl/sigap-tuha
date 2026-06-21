@extends('layouts.admin')
@section('header_title', 'Laporan Darurat')
@section('content')
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px;">
    <div>
        <h1 class="page-header__title">Laporan Darurat</h1>
        <p class="page-header__desc">Kelola dan pantau laporan darurat dari relawan lapangan.</p>
    </div>
    <a href="{{ route('admin.laporan.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Laporan</a>
</div>
<div class="card">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-list"></i> Daftar Laporan</h3>
        <span style="font-size:13px; color:var(--text-tertiary);"><i class="fas fa-info-circle"></i> Total: {{ $laporans->count() }} laporan</span>
    </div>
    @if($laporans->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-file-medical"></i></div>
            <div class="empty-state__title">Belum Ada Laporan</div>
            <div class="empty-state__desc">Belum ada laporan darurat yang masuk.</div>
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th><i class="fas fa-user" style="margin-right:4px"></i> Lansia</th>
                        <th><i class="fas fa-user-tie" style="margin-right:4px"></i> Pelapor</th>
                        <th><i class="fas fa-stethoscope" style="margin-right:4px"></i> Kondisi</th>
                        <th><i class="fas fa-bolt" style="margin-right:4px"></i> Urgensi</th>
                        <th><i class="fas fa-flag" style="margin-right:4px"></i> Status</th>
                        <th><i class="far fa-clock" style="margin-right:4px"></i> Waktu</th>
                        <th style="width:160px; text-align:center"><i class="fas fa-cogs" style="margin-right:4px"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporans as $i => $lap)
                    <tr>
                        <td><span style="font-weight:600; color:var(--text-tertiary);">{{ $i + 1 }}</span></td>
                        <td><span style="font-weight:600; color:var(--text-primary);">{{ $lap->lansia->nama ?? '-' }}</span></td>
                        <td>{{ $lap->pelapor }}</td>
                        <td><span style="font-size:13px;">{{ Str::limit($lap->kondisi, 40) }}</span></td>
                        <td>
                            @if($lap->tingkat_urgensi == 'Kritis')
                                <span class="badge badge--danger"><span class="badge__dot"></span> Kritis</span>
                            @elseif($lap->tingkat_urgensi == 'Tinggi')
                                <span class="badge badge--warning"><span class="badge__dot"></span> Tinggi</span>
                            @elseif($lap->tingkat_urgensi == 'Sedang')
                                <span class="badge badge--brand"><span class="badge__dot"></span> Sedang</span>
                            @else
                                <span class="badge badge--neutral"><span class="badge__dot"></span> Rendah</span>
                            @endif
                        </td>
                        <td>
                            @if($lap->status == 'Baru')
                                <span class="badge badge--danger"><span class="badge__dot"></span> Baru</span>
                            @elseif($lap->status == 'Diproses')
                                <span class="badge badge--warning"><span class="badge__dot"></span> Diproses</span>
                            @elseif($lap->status == 'Ditangani')
                                <span class="badge badge--brand"><span class="badge__dot"></span> Ditangani</span>
                            @else
                                <span class="badge badge--success"><span class="badge__dot"></span> Selesai</span>
                            @endif
                        </td>
                        <td style="font-size:12.5px; color:var(--text-tertiary);">{{ $lap->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div style="display:flex; gap:6px; justify-content:center;">
                                <a href="{{ route('admin.laporan.edit', $lap) }}" class="btn btn-outline btn-sm"><i class="fas fa-pen"></i> Edit</a>
                                <form action="{{ route('admin.laporan.destroy', $lap) }}" method="POST" onsubmit="return confirm('Yakin hapus laporan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
