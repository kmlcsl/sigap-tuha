@extends('layouts.admin')
@section('header_title', 'Detail Program & Kegiatan')
@section('content')
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px;">
    <div>
        <h1 class="page-header__title"><i class="fas fa-project-diagram" style="color:var(--brand-500); margin-right:8px"></i> {{ $program->nama }}</h1>
        <p class="page-header__desc">Kelola detail program dan daftar kegiatan yang ada di dalamnya.</p>
    </div>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('admin.programs.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
        <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-outline"><i class="fas fa-pen"></i> Edit Program</a>
    </div>
</div>

<div class="card" style="margin-bottom:24px;">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-info-circle"></i> Deskripsi Program</h3>
    </div>
    <div style="padding: 20px; font-size: 14.5px; color: var(--text-secondary); line-height: 1.6;">
        {{ $program->deskripsi ?: 'Tidak ada deskripsi untuk program ini.' }}
    </div>
</div>

<div class="card">
    <div class="card__header" style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h3 class="card__title"><i class="fas fa-tasks"></i> Daftar Kegiatan</h3>
            <span style="font-size:13px; color:var(--text-tertiary);"><i class="fas fa-info-circle"></i> Kegiatan untuk program ini</span>
        </div>
        <a href="{{ route('admin.programs.kegiatans.create', $program) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Kegiatan</a>
    </div>

    @if($program->kegiatans->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-clipboard-list"></i></div>
            <div class="empty-state__title">Belum Ada Kegiatan</div>
            <div class="empty-state__desc">Program ini belum memiliki kegiatan. Klik tombol Tambah Kegiatan untuk memulai.</div>
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th><i class="fas fa-image" style="margin-right:4px"></i> Foto</th>
                        <th><i class="fas fa-tag" style="margin-right:4px"></i> Nama Kegiatan</th>
                        <th><i class="fas fa-align-left" style="margin-right:4px"></i> Deskripsi Singkat</th>
                        <th style="width:160px; text-align:center"><i class="fas fa-cogs" style="margin-right:4px"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($program->kegiatans as $i => $kegiatan)
                    <tr>
                        <td><span style="font-weight:600; color:var(--text-tertiary);">{{ $i + 1 }}</span></td>
                        <td>
                            @if($kegiatan->foto)
                                <img src="{{ asset('storage/' . $kegiatan->foto) }}" alt="{{ $kegiatan->nama }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: var(--radius-md); border: 1px solid var(--border-secondary);">
                            @else
                                <div style="width: 50px; height: 50px; border-radius: var(--radius-md); background: var(--gray-100); display: flex; align-items: center; justify-content: center; color: var(--text-tertiary);">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td><span style="font-weight:600; color:var(--text-primary);">{{ $kegiatan->nama }}</span></td>
                        <td style="color:var(--text-secondary); max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ Str::limit($kegiatan->deskripsi_lengkap, 50) ?: '-' }}
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; justify-content:center;">
                                <a href="{{ route('admin.programs.kegiatans.edit', [$program, $kegiatan]) }}" class="btn btn-outline btn-sm"><i class="fas fa-pen"></i> Edit</a>
                                <form action="{{ route('admin.programs.kegiatans.destroy', [$program, $kegiatan]) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?')">
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
