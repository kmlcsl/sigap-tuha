@extends('layouts.admin')
@section('header_title', 'Manajemen Berita')
@section('content')
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px;">
    <div>
        <h1 class="page-header__title">Manajemen Berita</h1>
        <p class="page-header__desc">Kelola berita, artikel, dan informasi publikasi lainnya.</p>
    </div>
    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tulis Berita</a>
</div>

@if(session('success'))
    <div class="alert alert-success" style="padding:16px; background:var(--success-50); color:var(--success-700); border-radius:var(--radius-md); margin-bottom:20px; font-weight:500;">
        <i class="fas fa-check-circle" style="margin-right:8px;"></i> {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-newspaper"></i> Daftar Berita</h3>
        <span style="font-size:13px; color:var(--text-tertiary);"><i class="fas fa-info-circle"></i> Total: {{ $beritas->count() }} berita</span>
    </div>

    @if($beritas->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-newspaper"></i></div>
            <div class="empty-state__title">Belum Ada Berita</div>
            <div class="empty-state__desc">Terbitkan berita pertama untuk membagikan informasi.</div>
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary" style="margin-top:16px"><i class="fas fa-pen"></i> Tulis Sekarang</a>
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th style="width:100px; text-align:center;"><i class="fas fa-image"></i> Gambar</th>
                        <th><i class="fas fa-heading" style="margin-right:4px"></i> Judul</th>
                        <th style="text-align:center"><i class="fas fa-eye" style="margin-right:4px"></i> Status</th>
                        <th><i class="fas fa-clock" style="margin-right:4px"></i> Tanggal</th>
                        <th style="width:140px; text-align:center"><i class="fas fa-cogs" style="margin-right:4px"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($beritas as $i => $berita)
                    <tr>
                        <td><span style="font-weight:600; color:var(--text-tertiary);">{{ $i + 1 }}</span></td>
                        <td style="text-align:center">
                            @if($berita->gambar)
                                <img src="{{ asset($berita->gambar) }}" alt="{{ $berita->judul }}" style="width:60px; height:40px; object-fit:cover; border-radius:var(--radius-sm);">
                            @else
                                <div style="width:60px; height:40px; background:var(--gray-100); border-radius:var(--radius-sm); display:flex; align-items:center; justify-content:center; color:var(--gray-400); font-size:12px; margin:0 auto;"><i class="fas fa-image"></i></div>
                            @endif
                        </td>
                        <td><span style="font-weight:600; color:var(--text-primary);">{{ $berita->judul }}</span></td>
                        <td style="text-align:center">
                            @if($berita->status === 'published')
                                <span class="badge badge--success"><i class="fas fa-check"></i> Published</span>
                            @else
                                <span class="badge badge--warning"><i class="fas fa-file-alt"></i> Draft</span>
                            @endif
                        </td>
                        <td>
                            <span style="color:var(--text-secondary); font-size:13px;">{{ $berita->created_at->format('d M Y') }}</span>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; justify-content:center;">
                                <a href="{{ route('admin.berita.edit', $berita) }}" class="btn btn-outline btn-sm" title="Edit"><i class="fas fa-pen"></i></a>
                                <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST" onsubmit="return confirm('Hapus berita ini secara permanen?')">
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
