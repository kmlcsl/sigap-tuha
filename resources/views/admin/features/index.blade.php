@extends('layouts.admin')

@section('header_title', 'Manajemen Fitur')

@section('content')
{{-- Page Header --}}
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px;">
    <div>
        <h1 class="page-header__title">Manajemen Fitur</h1>
        <p class="page-header__desc">Kelola fitur-fitur yang ditampilkan di halaman utama SIGAP TUHA.</p>
    </div>
    <a href="{{ route('admin.features.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Fitur
    </a>
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-list"></i> Daftar Fitur Halaman Utama</h3>
        <span style="font-size:13px; color:var(--text-tertiary);">
            <i class="fas fa-info-circle"></i> Total: {{ $features->count() }} fitur
        </span>
    </div>

    @if($features->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="far fa-folder-open"></i></div>
            <div class="empty-state__title">Belum Ada Fitur</div>
            <div class="empty-state__desc">Klik tombol "+ Tambah Fitur" untuk mulai menambahkan fitur ke halaman utama.</div>
            <a href="{{ route('admin.features.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Fitur Pertama
            </a>
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:60px;">
                            <i class="fas fa-sort-numeric-down" style="margin-right:4px;"></i> Urutan
                        </th>
                        <th><i class="fas fa-heading" style="margin-right:4px;"></i> Judul</th>
                        <th><i class="fas fa-align-left" style="margin-right:4px;"></i> Deskripsi</th>
                        <th style="width:100px;"><i class="fas fa-palette" style="margin-right:4px;"></i> Warna</th>
                        <th style="width:160px; text-align:center;"><i class="fas fa-cogs" style="margin-right:4px;"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($features as $feature)
                        <tr>
                            <td>
                                <span style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; background:var(--gray-50); border-radius:var(--radius-md); font-weight:700; font-size:13px; color:var(--text-primary);">
                                    {{ $feature->order }}
                                </span>
                            </td>
                            <td>
                                <span style="font-weight:600; color:var(--text-primary);">{{ $feature->title }}</span>
                            </td>
                            <td>
                                <span style="color:var(--text-secondary); font-size:13px;">
                                    {{ Str::limit($feature->description, 60) }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span class="color-dot" style="background:{{ $feature->color_class == 'blue' ? 'var(--brand-600)' : ($feature->color_class == 'gold' ? '#f59e0b' : '#ef4444') }};"></span>
                                    <span style="font-size:12.5px; font-weight:500; color:var(--text-secondary);">{{ ucfirst($feature->color_class) }}</span>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex; align-items:center; gap:6px; justify-content:center;">
                                    <a href="{{ route('admin.features.edit', $feature) }}" class="btn btn-outline btn-sm" title="Edit">
                                        <i class="fas fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.features.destroy', $feature) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus fitur ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
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
