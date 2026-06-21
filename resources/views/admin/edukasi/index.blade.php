@extends('layouts.admin')
@section('header_title', 'Edukasi BHD')
@section('content')
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px;">
    <div>
        <h1 class="page-header__title">Edukasi BHD</h1>
        <p class="page-header__desc">Kelola materi edukasi Bantuan Hidup Dasar dan panduan darurat.</p>
    </div>
    <a href="{{ route('admin.edukasi.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Materi</a>
</div>
<div class="card">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-book-open"></i> Daftar Materi Edukasi</h3>
        <span style="font-size:13px; color:var(--text-tertiary);"><i class="fas fa-info-circle"></i> Total: {{ $edukasis->count() }} materi</span>
    </div>
    @if($edukasis->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-graduation-cap"></i></div>
            <div class="empty-state__title">Belum Ada Materi</div>
            <div class="empty-state__desc">Tambahkan materi edukasi BHD pertama.</div>
            <a href="{{ route('admin.edukasi.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Materi</a>
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th><i class="fas fa-heading" style="margin-right:4px"></i> Judul</th>
                        <th><i class="fas fa-tag" style="margin-right:4px"></i> Kategori</th>
                        <th><i class="fas fa-file" style="margin-right:4px"></i> Jenis</th>
                        <th><i class="fas fa-eye" style="margin-right:4px"></i> Status</th>
                        <th style="width:160px; text-align:center"><i class="fas fa-cogs" style="margin-right:4px"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($edukasis as $i => $edu)
                    <tr>
                        <td><span style="font-weight:600; color:var(--text-tertiary);">{{ $i + 1 }}</span></td>
                        <td><span style="font-weight:600; color:var(--text-primary);">{{ $edu->judul }}</span></td>
                        <td><span class="badge badge--brand">{{ $edu->kategori }}</span></td>
                        <td>
                            @if($edu->jenis == 'Video')
                                <span class="badge badge--warning"><i class="fas fa-video" style="font-size:10px"></i> Video</span>
                            @elseif($edu->jenis == 'SOP')
                                <span class="badge badge--neutral"><i class="fas fa-file-pdf" style="font-size:10px"></i> SOP</span>
                            @else
                                <span class="badge badge--success"><i class="fas fa-file-alt" style="font-size:10px"></i> Artikel</span>
                            @endif
                        </td>
                        <td>
                            @if($edu->is_published)
                                <span class="badge badge--success"><span class="badge__dot"></span> Publik</span>
                            @else
                                <span class="badge badge--neutral"><span class="badge__dot"></span> Draft</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; justify-content:center;">
                                <a href="{{ route('admin.edukasi.edit', $edu) }}" class="btn btn-outline btn-sm"><i class="fas fa-pen"></i> Edit</a>
                                <form action="{{ route('admin.edukasi.destroy', $edu) }}" method="POST" onsubmit="return confirm('Yakin hapus materi ini?')">
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
