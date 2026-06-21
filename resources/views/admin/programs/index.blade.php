@extends('layouts.admin')
@section('header_title', 'Manajemen Program')
@section('content')
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px;">
    <div>
        <h1 class="page-header__title">Manajemen Program</h1>
        <p class="page-header__desc">Kelola program dan kegiatan yang berjalan di SIGAP TUHA.</p>
    </div>
    <a href="{{ route('admin.programs.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Program</a>
</div>

<div class="card">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-project-diagram"></i> Daftar Program</h3>
        <span style="font-size:13px; color:var(--text-tertiary);"><i class="fas fa-info-circle"></i> Total: {{ $programs->count() }} program</span>
    </div>

    @if($programs->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-folder-open"></i></div>
            <div class="empty-state__title">Belum Ada Program</div>
            <div class="empty-state__desc">Tambahkan program utama terlebih dahulu.</div>
            <a href="{{ route('admin.programs.create') }}" class="btn btn-primary" style="margin-top:16px"><i class="fas fa-plus"></i> Buat Program</a>
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th><i class="fas fa-tag" style="margin-right:4px"></i> Nama Program</th>
                        <th><i class="fas fa-align-left" style="margin-right:4px"></i> Deskripsi</th>
                        <th style="text-align:center"><i class="fas fa-tasks" style="margin-right:4px"></i> Jumlah Kegiatan</th>
                        <th style="width:180px; text-align:center"><i class="fas fa-cogs" style="margin-right:4px"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programs as $i => $program)
                    <tr>
                        <td><span style="font-weight:600; color:var(--text-tertiary);">{{ $i + 1 }}</span></td>
                        <td><span style="font-weight:600; color:var(--text-primary);">{{ $program->nama }}</span></td>
                        <td style="color:var(--text-secondary); max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $program->deskripsi ?: '-' }}
                        </td>
                        <td style="text-align:center">
                            <span class="badge badge--brand"><i class="fas fa-list-ul" style="font-size:10px"></i> {{ $program->kegiatans_count }} Kegiatan</span>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; justify-content:center;">
                                <a href="{{ route('admin.programs.show', $program) }}" class="btn btn-primary btn-sm" title="Kelola Kegiatan"><i class="fas fa-folder-open"></i> Buka</a>
                                <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-outline btn-sm" title="Edit Program"><i class="fas fa-pen"></i></a>
                                <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Hapus program ini? Semua kegiatannya juga akan terhapus secara permanen.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash-alt"></i></button>
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
