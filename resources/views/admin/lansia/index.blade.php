@extends('layouts.admin')

@section('header_title', 'Data Lansia')

@section('content')
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px;">
    <div>
        <h1 class="page-header__title">Data Lansia</h1>
        <p class="page-header__desc">Kelola data penduduk lanjut usia di Kecamatan Pandrah.</p>
    </div>
    <a href="{{ route('admin.lansia.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Lansia
    </a>
</div>

<div class="card">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-list"></i> Daftar Lansia</h3>
        <span style="font-size:13px; color:var(--text-tertiary);"><i class="fas fa-info-circle"></i> Total: {{ $lansias->count() }} data</span>
    </div>

    @if($lansias->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-user-plus"></i></div>
            <div class="empty-state__title">Belum Ada Data Lansia</div>
            <div class="empty-state__desc">Klik tombol "Tambah Lansia" untuk mulai menambahkan data.</div>
            <a href="{{ route('admin.lansia.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Data Pertama</a>
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th><i class="fas fa-user" style="margin-right:4px"></i> Nama</th>
                        <th><i class="fas fa-birthday-cake" style="margin-right:4px"></i> Umur</th>
                        <th><i class="fas fa-venus-mars" style="margin-right:4px"></i> JK</th>
                        <th><i class="fas fa-map-pin" style="margin-right:4px"></i> Desa</th>
                        <th><i class="fas fa-heartbeat" style="margin-right:4px"></i> Kondisi</th>
                        <th><i class="fas fa-flag" style="margin-right:4px"></i> Status</th>
                        <th style="width:160px; text-align:center"><i class="fas fa-cogs" style="margin-right:4px"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lansias as $i => $lansia)
                    <tr>
                        <td><span style="font-weight:600; color:var(--text-tertiary);">{{ $i + 1 }}</span></td>
                        <td><span style="font-weight:600; color:var(--text-primary);">{{ $lansia->nama }}</span></td>
                        <td>{{ $lansia->umur }} thn</td>
                        <td>
                            @if($lansia->jenis_kelamin == 'L')
                                <span class="badge badge--brand"><i class="fas fa-mars"></i> L</span>
                            @else
                                <span class="badge" style="background:#fdf2f8; color:#be185d;"><i class="fas fa-venus"></i> P</span>
                            @endif
                        </td>
                        <td>{{ $lansia->desa }}</td>
                        <td><span style="font-size:13px;">{{ $lansia->kondisi_kesehatan ?? '-' }}</span></td>
                        <td>
                            @if($lansia->status == 'Stabil')
                                <span class="badge badge--success"><span class="badge__dot"></span> Stabil</span>
                            @elseif($lansia->status == 'Perlu pemantauan')
                                <span class="badge badge--warning"><span class="badge__dot"></span> Pemantauan</span>
                            @else
                                <span class="badge badge--danger"><span class="badge__dot"></span> Rujukan</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; justify-content:center;">
                                <a href="{{ route('admin.lansia.edit', $lansia) }}" class="btn btn-outline btn-sm"><i class="fas fa-pen"></i> Edit</a>
                                <form action="{{ route('admin.lansia.destroy', $lansia) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
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
