@extends('layouts.admin')
@section('header_title', 'Manajemen Program & Kegiatan')

@section('styles')
<style>
/* ── Responsive Programs Index ── */
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
@media (max-width: 640px) {
    .col-desc { display: none; }
    .col-count { display: none; }
    .page-header-row .btn-group { flex-direction: column; width: 100%; }
    .page-header-row .btn-group .btn { width: 100%; justify-content: center; }
    .table-filter-row { flex-direction: column; align-items: stretch; }
    .table-filter-row .table-search-wrap { width: 100%; }
}
</style>
@endsection

@section('content')

{{-- Page Header --}}
<div class="page-header-row">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-project-diagram" style="color:var(--brand-500); margin-right:10px; font-size:22px;"></i>
            Program & Kegiatan
        </h1>
        <p class="page-header__desc">Kelola program kerja beserta kegiatan-kegiatan yang ada di dalamnya.</p>
    </div>
    <div class="btn-group" style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Program
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
    $totalPrograms  = $programs->count();
    $totalKegiatans = $programs->sum(fn($p) => $p->kegiatans->count());
    $withKegiatan   = $programs->filter(fn($p) => $p->kegiatans->count() > 0)->count();
    $noKegiatan     = $programs->filter(fn($p) => $p->kegiatans->count() === 0)->count();
@endphp
<div class="stats-grid" style="grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); margin-bottom:24px;">
    <div class="stat-card brand">
        <div class="stat-card__top">
            <span class="stat-card__label">Total Program</span>
            <div class="stat-card__icon brand"><i class="fas fa-project-diagram"></i></div>
        </div>
        <div class="stat-card__value">{{ $totalPrograms }}</div>
        <div class="stat-card__change up"><i class="fas fa-check" style="font-size:10px;"></i> Aktif</div>
    </div>
    <div class="stat-card success">
        <div class="stat-card__top">
            <span class="stat-card__label">Total Kegiatan</span>
            <div class="stat-card__icon success"><i class="fas fa-tasks"></i></div>
        </div>
        <div class="stat-card__value">{{ $totalKegiatans }}</div>
        <div class="stat-card__change up"><i class="fas fa-list" style="font-size:10px;"></i> Kegiatan</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-card__top">
            <span class="stat-card__label">Ada Kegiatan</span>
            <div class="stat-card__icon warning"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="stat-card__value">{{ $withKegiatan }}</div>
        <div class="stat-card__change up"><i class="fas fa-layer-group" style="font-size:10px;"></i> Program</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-card__top">
            <span class="stat-card__label">Tanpa Kegiatan</span>
            <div class="stat-card__icon danger"><i class="fas fa-exclamation-circle"></i></div>
        </div>
        <div class="stat-card__value">{{ $noKegiatan }}</div>
        <div class="stat-card__change down"><i class="fas fa-times" style="font-size:10px;"></i> Kosong</div>
    </div>
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card__header" style="flex-wrap:wrap; gap:12px;">
        <h3 class="card__title">
            <i class="fas fa-list-ul"></i> Daftar Program
            <span class="badge badge--brand" style="margin-left:8px; font-size:11px;" id="countBadge">{{ $totalPrograms }}</span>
        </h3>
        <div class="table-filter-row">
            <div class="table-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="searchProgram" oninput="filterTable()" placeholder="Cari nama program..." class="table-search-input">
            </div>
        </div>
    </div>

    @if($programs->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-folder-open"></i></div>
            <div class="empty-state__title">Belum Ada Program</div>
            <div class="empty-state__desc">Buat program kerja pertama dan tambahkan kegiatan di dalamnya.</div>
            <a href="{{ route('admin.programs.create') }}" class="btn btn-primary" style="margin-top:4px;">
                <i class="fas fa-plus"></i> Tambah Program Pertama
            </a>
        </div>
    @else
        <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
            <table class="table" id="programTable" style="min-width:420px;">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th><i class="fas fa-project-diagram" style="margin-right:4px;"></i> Nama Program</th>
                        <th class="col-desc"><i class="fas fa-align-left" style="margin-right:4px;"></i> Deskripsi</th>
                        <th class="col-count" style="text-align:center; width:110px;"><i class="fas fa-tasks" style="margin-right:4px;"></i> Kegiatan</th>
                        <th style="width:140px; text-align:center;"><i class="fas fa-cogs" style="margin-right:4px;"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programs as $i => $program)
                    <tr class="program-row" data-name="{{ strtolower($program->nama) }}">
                        <td>
                            <div style="width:30px; height:30px; border-radius:var(--radius-md); background:linear-gradient(135deg,var(--brand-500),var(--brand-700)); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:12px;">
                                {{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:700; color:var(--text-primary); font-size:14px; margin-bottom:2px;">{{ $program->nama }}</div>
                            <div style="font-size:11.5px; color:var(--text-tertiary);">ID: #{{ $program->id }}</div>
                        </td>
                        <td class="col-desc" style="max-width:240px;">
                            <span style="font-size:13px; color:var(--text-secondary); display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                {{ Str::limit($program->deskripsi, 80) ?: '—' }}
                            </span>
                        </td>
                        <td class="col-count" style="text-align:center;">
                            @php $kCount = $program->kegiatans->count(); @endphp
                            <span class="badge {{ $kCount > 0 ? 'badge--success' : 'badge--neutral' }}">
                                <i class="fas fa-{{ $kCount > 0 ? 'check' : 'times' }}" style="font-size:9px;"></i>
                                {{ $kCount }} kegiatan
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:5px; justify-content:center; flex-wrap:wrap;">
                                <a href="{{ route('admin.programs.show', $program) }}" class="btn btn-ghost btn-sm" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.programs.destroy', $program) }}" method="POST"
                                    onsubmit="return confirm('Hapus program \'{{ addslashes($program->nama) }}\' beserta semua kegiatannya?')">
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
            <div style="font-weight:600;">Tidak ada program yang cocok</div>
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 4px 0; flex-wrap:wrap; gap:8px;">
            <span style="font-size:12.5px; color:var(--text-tertiary);" id="tableFooter">
                Menampilkan <strong>{{ $totalPrograms }}</strong> program · Total <strong>{{ $totalKegiatans }}</strong> kegiatan
            </span>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
function filterTable() {
    const searchVal = document.getElementById('searchProgram').value.toLowerCase();
    const rows = document.querySelectorAll('.program-row');
    let visible = 0;
    rows.forEach(row => {
        const match = !searchVal || (row.dataset.name || '').includes(searchVal) || row.innerText.toLowerCase().includes(searchVal);
        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    const noR   = document.getElementById('noResults');
    const badge = document.getElementById('countBadge');
    const footer = document.getElementById('tableFooter');
    if (noR)    noR.style.display  = visible === 0 ? 'block' : 'none';
    if (badge)  badge.textContent  = visible;
    if (footer) footer.innerHTML   = 'Menampilkan <strong>' + visible + '</strong> program';
}
setTimeout(() => {
    const el = document.getElementById('flashMsg');
    if (el) { el.style.opacity='0'; el.style.transition='opacity .4s'; setTimeout(()=>el.remove(),400); }
}, 4000);
</script>
@endsection
