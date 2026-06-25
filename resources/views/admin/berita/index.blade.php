@extends('layouts.admin')
@section('header_title', 'Manajemen Berita')

@section('styles')
<style>
.page-header-row {
    display: flex; align-items: flex-start; justify-content: space-between;
    flex-wrap: wrap; gap: 16px; margin-bottom: 24px;
}
.table-filter-row {
    display: flex; gap: 10px; flex-wrap: wrap; align-items: center;
}
.table-search-wrap { position: relative; min-width: 160px; flex: 1; }
.table-search-wrap i {
    position: absolute; left: 10px; top: 50%;
    transform: translateY(-50%); color: var(--text-placeholder); font-size: 12px; pointer-events: none;
}
.table-search-input {
    padding: 7px 12px 7px 30px;
    border: 1px solid var(--border-primary); border-radius: var(--radius-md);
    font-size: 13px; font-family: inherit;
    background: var(--gray-50); color: var(--text-primary); width: 100%;
}
/* Hide slug + date columns on small screens */
@media (max-width: 640px) {
    .col-date { display: none; }
    .col-slug { display: none; }
    .page-header-row .btn-group { flex-direction: column; width: 100%; }
    .page-header-row .btn-group .btn { width: 100%; justify-content: center; }
    .table-filter-row { flex-direction: column; align-items: stretch; }
    .table-filter-row select,
    .table-filter-row .table-search-wrap { width: 100%; }
}
</style>
@endsection

@section('content')

{{-- Page Header --}}
<div class="page-header-row">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-newspaper" style="color:var(--warning-500); margin-right:10px; font-size:22px;"></i>
            Manajemen Berita
        </h1>
        <p class="page-header__desc">Kelola berita, artikel, dan informasi publikasi untuk halaman publik.</p>
    </div>
    <div class="btn-group" style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('berita') }}" class="btn btn-outline btn-sm" target="_blank">
            <i class="fas fa-external-link-alt"></i> <span class="hide-xs">Halaman Berita</span>
        </a>
        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
            <i class="fas fa-pen-to-square"></i> Tulis Berita
        </a>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="flash-message success" id="flashMsg">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button onclick="document.getElementById('flashMsg').remove()" style="margin-left:auto; background:none; border:none; cursor:pointer; color:inherit; opacity:0.6; font-size:18px;">&times;</button>
    </div>
@endif

{{-- Stats --}}
@php
    $totalBerita = $beritas->count();
    $published   = $beritas->where('status','published')->count();
    $draft       = $beritas->where('status','draft')->count();
@endphp
<div class="stats-grid" style="grid-template-columns:repeat(3,1fr); margin-bottom:24px;">
    <div class="stat-card brand">
        <div class="stat-card__top">
            <span class="stat-card__label">Total Berita</span>
            <div class="stat-card__icon brand"><i class="fas fa-newspaper"></i></div>
        </div>
        <div class="stat-card__value">{{ $totalBerita }}</div>
        <div class="stat-card__change up"><i class="fas fa-file" style="font-size:10px;"></i> Semua</div>
    </div>
    <div class="stat-card success">
        <div class="stat-card__top">
            <span class="stat-card__label">Published</span>
            <div class="stat-card__icon success"><i class="fas fa-globe"></i></div>
        </div>
        <div class="stat-card__value">{{ $published }}</div>
        <div class="stat-card__change up"><i class="fas fa-check" style="font-size:10px;"></i> Live</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-card__top">
            <span class="stat-card__label">Draft</span>
            <div class="stat-card__icon warning"><i class="fas fa-file-alt"></i></div>
        </div>
        <div class="stat-card__value">{{ $draft }}</div>
        <div class="stat-card__change down"><i class="fas fa-clock" style="font-size:10px;"></i> Tersimpan</div>
    </div>
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card__header" style="flex-wrap:wrap; gap:12px;">
        <h3 class="card__title">
            <i class="fas fa-list-ul"></i> Daftar Artikel
            <span class="badge badge--brand" style="margin-left:8px; font-size:11px;" id="countBadge">{{ $totalBerita }}</span>
        </h3>
        <div class="table-filter-row">
            <select id="filterStatus" onchange="filterTable()" class="form-control" style="font-size:13px; padding:7px 10px; width:auto; min-width:130px;">
                <option value="">Semua Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
            <div class="table-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="searchBerita" oninput="filterTable()" placeholder="Cari judul..." class="table-search-input">
            </div>
        </div>
    </div>

    @if($beritas->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-newspaper"></i></div>
            <div class="empty-state__title">Belum Ada Berita</div>
            <div class="empty-state__desc">Mulai tulis berita pertama untuk dipublikasikan.</div>
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary" style="margin-top:4px;">
                <i class="fas fa-pen"></i> Tulis Berita Pertama
            </a>
        </div>
    @else
        <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
            <table class="table" id="beritaTable" style="min-width:480px;">
                <thead>
                    <tr>
                        <th style="width:42px;">#</th>
                        <th style="width:72px; text-align:center;"><i class="fas fa-image"></i></th>
                        <th><i class="fas fa-heading" style="margin-right:4px;"></i> Judul</th>
                        <th class="col-slug"><i class="fas fa-link" style="margin-right:4px;"></i> Slug</th>
                        <th style="text-align:center; width:120px;"><i class="fas fa-eye" style="margin-right:4px;"></i> Status</th>
                        <th class="col-date" style="width:100px;"><i class="fas fa-clock" style="margin-right:4px;"></i> Tanggal</th>
                        <th style="width:120px; text-align:center;"><i class="fas fa-cogs" style="margin-right:4px;"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($beritas as $i => $berita)
                    <tr class="berita-row" data-status="{{ $berita->status }}" data-title="{{ strtolower($berita->judul) }}">
                        <td><span style="font-weight:700; color:var(--text-tertiary);">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</span></td>
                        <td style="text-align:center;">
                            @if($berita->gambar)
                                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                                    style="width:58px; height:40px; object-fit:cover; border-radius:var(--radius-md); border:1px solid var(--border-secondary); display:block; margin:0 auto;">
                            @else
                                <div style="width:58px; height:40px; background:var(--gray-100); border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; color:var(--gray-300); margin:0 auto; border:1px dashed var(--border-primary);">
                                    <i class="fas fa-image" style="font-size:16px;"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:700; color:var(--text-primary); font-size:13.5px; margin-bottom:2px;">
                                {{ Str::limit($berita->judul, 55) }}
                            </div>
                        </td>
                        <td class="col-slug">
                            <span style="font-size:12px; color:var(--text-tertiary);">/{{ $berita->slug ?? '—' }}</span>
                        </td>
                        <td style="text-align:center;">
                            @if($berita->status === 'published')
                                <span class="badge badge--success"><span class="badge__dot"></span> Live</span>
                            @else
                                <span class="badge badge--warning"><span class="badge__dot"></span> Draft</span>
                            @endif
                        </td>
                        <td class="col-date" style="font-size:12.5px; color:var(--text-secondary);">
                            {{ $berita->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td>
                            <div style="display:flex; gap:5px; justify-content:center; flex-wrap:wrap;">
                                @if($berita->slug)
                                    <a href="{{ route('berita.detail', $berita->slug) }}" class="btn btn-ghost btn-sm" title="Preview" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin.berita.edit', $berita) }}" class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST"
                                    onsubmit="return confirm('Hapus berita ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="noResults" style="display:none; text-align:center; padding:32px; color:var(--text-tertiary);">
            <i class="fas fa-search" style="font-size:28px; opacity:.4; display:block; margin-bottom:10px;"></i>
            <div style="font-weight:600;">Tidak ada artikel yang cocok</div>
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 4px 0; flex-wrap:wrap; gap:8px;">
            <span style="font-size:12.5px; color:var(--text-tertiary);" id="tableFooter">
                Menampilkan <strong>{{ $totalBerita }}</strong> berita
            </span>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
function filterTable() {
    const statusFilter = document.getElementById('filterStatus').value;
    const searchVal    = document.getElementById('searchBerita').value.toLowerCase();
    const rows         = document.querySelectorAll('.berita-row');
    let visible = 0;
    rows.forEach(row => {
        const matchStatus = !statusFilter || (row.dataset.status || '') === statusFilter;
        const matchSearch = !searchVal   || (row.dataset.title || '').includes(searchVal) || row.innerText.toLowerCase().includes(searchVal);
        const show = matchStatus && matchSearch;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    const noR   = document.getElementById('noResults');
    const badge = document.getElementById('countBadge');
    const footer = document.getElementById('tableFooter');
    if (noR)    noR.style.display  = visible === 0 ? 'block' : 'none';
    if (badge)  badge.textContent  = visible;
    if (footer) footer.innerHTML   = 'Menampilkan <strong>' + visible + '</strong> berita';
}
setTimeout(() => {
    const el = document.getElementById('flashMsg');
    if (el) { el.style.opacity='0'; el.style.transition='opacity .4s'; setTimeout(()=>el.remove(),400); }
}, 4000);
</script>
@endsection
