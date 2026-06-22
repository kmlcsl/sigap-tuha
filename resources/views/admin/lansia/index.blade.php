@extends('layouts.admin')
@section('header_title', 'Data Lansia')

@section('content')

{{-- Page Header --}}
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-users" style="color:var(--brand-500); margin-right:10px; font-size:22px;"></i>
            Data Lansia
        </h1>
        <p class="page-header__desc">Kelola data penduduk lanjut usia di Kecamatan Pandrah Kabupaten Bireuen.</p>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <button onclick="toggleFilter()" class="btn btn-outline btn-sm" id="filterToggleBtn">
            <i class="fas fa-filter"></i> Filter
        </button>
        <a href="{{ route('admin.lansia.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Lansia
        </a>
    </div>
</div>

{{-- Flash Message --}}
@if(session('success'))
    <div class="flash-message success" id="flashMsg">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button onclick="document.getElementById('flashMsg').remove()" style="margin-left:auto; background:none; border:none; cursor:pointer; color:inherit; opacity:0.6; font-size:18px;">&times;</button>
    </div>
@endif

{{-- Stats Cards --}}
<div class="stats-grid" style="margin-bottom:24px;">
    @php
        $totalLansia = $lansias->count();
        $stabil      = $lansias->where('status', 'Stabil')->count();
        $pantau      = $lansias->where('status', 'Perlu pemantauan')->count();
        $rujuk       = $lansias->where('status', 'Rujukan segera')->count();
        $lakiLaki    = $lansias->where('jenis_kelamin', 'L')->count();
        $perempuan   = $lansias->where('jenis_kelamin', 'P')->count();
    @endphp
    <div class="stat-card brand">
        <div class="stat-card__top">
            <span class="stat-card__label">Total Lansia</span>
            <div class="stat-card__icon brand"><i class="fas fa-users"></i></div>
        </div>
        <div class="stat-card__value">{{ $totalLansia }}</div>
        <div style="font-size:12px; color:var(--text-tertiary); margin-top:6px; display:flex; gap:8px;">
            <span><i class="fas fa-mars" style="color:var(--brand-400);"></i> {{ $lakiLaki }} L</span>
            <span><i class="fas fa-venus" style="color:#be185d;"></i> {{ $perempuan }} P</span>
        </div>
    </div>
    <div class="stat-card success">
        <div class="stat-card__top">
            <span class="stat-card__label">Kondisi Stabil</span>
            <div class="stat-card__icon success"><i class="fas fa-heart"></i></div>
        </div>
        <div class="stat-card__value">{{ $stabil }}</div>
        <div class="stat-card__change up" style="margin-top:6px;"><i class="fas fa-check" style="font-size:10px"></i> Sehat & Stabil</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-card__top">
            <span class="stat-card__label">Perlu Pantau</span>
            <div class="stat-card__icon warning"><i class="fas fa-eye"></i></div>
        </div>
        <div class="stat-card__value">{{ $pantau }}</div>
        <div class="stat-card__change down" style="margin-top:6px;"><i class="fas fa-exclamation" style="font-size:10px"></i> Perlu Perhatian</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-card__top">
            <span class="stat-card__label">Rujukan Segera</span>
            <div class="stat-card__icon danger"><i class="fas fa-ambulance"></i></div>
        </div>
        <div class="stat-card__value">{{ $rujuk }}</div>
        <div class="stat-card__change down" style="margin-top:6px;"><i class="fas fa-exclamation-triangle" style="font-size:10px"></i> Kritis</div>
    </div>
</div>

{{-- Filter Panel (hidden by default) --}}
<div id="filterPanel" style="display:none; margin-bottom:20px;">
    <div class="card" style="padding:20px;">
        <div style="font-size:13px; font-weight:700; color:var(--text-primary); margin-bottom:14px;">
            <i class="fas fa-filter" style="color:var(--brand-500); margin-right:6px;"></i> Filter Data Lansia
        </div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:14px;">
            <div>
                <label style="font-size:12px; font-weight:600; color:var(--text-tertiary); display:block; margin-bottom:5px;">Status Kesehatan</label>
                <select id="filterStatus" onchange="applyFilter()" class="form-control" style="font-size:13px; padding:8px 12px;">
                    <option value="">Semua Status</option>
                    <option value="Stabil">Stabil</option>
                    <option value="Perlu pemantauan">Perlu Pemantauan</option>
                    <option value="Rujukan segera">Rujukan Segera</option>
                </select>
            </div>
            <div>
                <label style="font-size:12px; font-weight:600; color:var(--text-tertiary); display:block; margin-bottom:5px;">Jenis Kelamin</label>
                <select id="filterJK" onchange="applyFilter()" class="form-control" style="font-size:13px; padding:8px 12px;">
                    <option value="">Semua</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div>
                <label style="font-size:12px; font-weight:600; color:var(--text-tertiary); display:block; margin-bottom:5px;">Cari Nama / Desa</label>
                <input type="text" id="searchLansia" oninput="applyFilter()" class="form-control"
                    style="font-size:13px; padding:8px 12px;" placeholder="Ketik nama atau desa...">
            </div>
            <div style="display:flex; align-items:flex-end;">
                <button onclick="resetFilter()" class="btn btn-outline btn-sm" style="width:100%;">
                    <i class="fas fa-undo"></i> Reset Filter
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Main Table Card --}}
<div class="card">
    <div class="card__header" style="flex-wrap:wrap; gap:12px;">
        <h3 class="card__title">
            <i class="fas fa-list-ul"></i> Daftar Lansia
            <span class="badge badge--brand" style="margin-left:8px; font-size:11px;" id="countBadge">{{ $lansias->count() }}</span>
        </h3>
        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            <div style="position:relative;">
                <i class="fas fa-search" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:var(--text-placeholder); font-size:12px; pointer-events:none;"></i>
                <input type="text" id="quickSearch" oninput="applyFilter()" placeholder="Cari cepat..."
                    style="padding:7px 12px 7px 30px; border:1px solid var(--border-primary); border-radius:var(--radius-md); font-size:13px; font-family:inherit; background:var(--gray-50); color:var(--text-primary); width:200px;">
            </div>
        </div>
    </div>

    @if($lansias->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-user-plus"></i></div>
            <div class="empty-state__title">Belum Ada Data Lansia</div>
            <div class="empty-state__desc">Mulai tambahkan data lansia untuk dipantau.</div>
            <a href="{{ route('admin.lansia.create') }}" class="btn btn-primary" style="margin-top:4px;">
                <i class="fas fa-plus"></i> Tambah Data Pertama
            </a>
        </div>
    @else
        <div class="table-wrap">
            <table class="table" id="lansiaTable">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th><i class="fas fa-user" style="margin-right:4px;"></i> Nama Lengkap</th>
                        <th><i class="fas fa-birthday-cake" style="margin-right:4px;"></i> Umur</th>
                        <th><i class="fas fa-venus-mars" style="margin-right:4px;"></i> JK</th>
                        <th><i class="fas fa-map-pin" style="margin-right:4px;"></i> Desa</th>
                        <th><i class="fas fa-heartbeat" style="margin-right:4px;"></i> Kondisi</th>
                        <th><i class="fas fa-flag" style="margin-right:4px;"></i> Status</th>
                        <th style="width:150px; text-align:center;"><i class="fas fa-cogs" style="margin-right:4px;"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody id="lansiaTableBody">
                    @foreach($lansias as $i => $lansia)
                    <tr class="lansia-row"
                        data-status="{{ $lansia->status }}"
                        data-jk="{{ $lansia->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}"
                        data-name="{{ strtolower($lansia->nama) }} {{ strtolower($lansia->desa) }}">
                        <td><span style="font-weight:700; color:var(--text-tertiary);">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</span></td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:36px; height:36px; border-radius:var(--radius-full); background:{{ $lansia->jenis_kelamin=='L' ? 'var(--brand-100)' : '#fdf2f8' }}; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <i class="fas fa-{{ $lansia->jenis_kelamin=='L' ? 'mars' : 'venus' }}" style="color:{{ $lansia->jenis_kelamin=='L' ? 'var(--brand-600)' : '#be185d' }}; font-size:14px;"></i>
                                </div>
                                <div>
                                    <div style="font-weight:700; color:var(--text-primary); font-size:14px;">{{ $lansia->nama }}</div>
                                    @if($lansia->kontak_keluarga)
                                        <div style="font-size:11.5px; color:var(--text-tertiary);"><i class="fas fa-phone" style="font-size:10px;"></i> {{ $lansia->kontak_keluarga }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-weight:700; color:var(--text-primary);">{{ $lansia->umur }}</span>
                            <span style="font-size:12px; color:var(--text-tertiary);"> thn</span>
                        </td>
                        <td>
                            @if($lansia->jenis_kelamin == 'L')
                                <span class="badge badge--brand"><i class="fas fa-mars" style="font-size:10px;"></i> L</span>
                            @else
                                <span class="badge" style="background:#fdf2f8; color:#be185d;"><i class="fas fa-venus" style="font-size:10px;"></i> P</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:500; color:var(--text-primary); font-size:13.5px;">{{ $lansia->desa }}</div>
                        </td>
                        <td style="max-width:180px;">
                            <span style="font-size:13px; color:var(--text-secondary); display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                {{ $lansia->kondisi_kesehatan ?? '—' }}
                            </span>
                        </td>
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
                            <div style="display:flex; gap:5px; justify-content:center; flex-wrap:wrap;">
                                <a href="{{ route('admin.lansia.edit', $lansia) }}" class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.lansia.destroy', $lansia) }}" method="POST"
                                    onsubmit="return confirm('Hapus data lansia {{ addslashes($lansia->nama) }}?')">
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

        {{-- No Results --}}
        <div id="noResults" style="display:none; text-align:center; padding:32px; color:var(--text-tertiary);">
            <i class="fas fa-search" style="font-size:32px; opacity:.4; margin-bottom:12px;"></i>
            <div style="font-weight:600;">Tidak ada data yang cocok</div>
            <div style="font-size:13px; margin-top:4px;">Coba ubah kata kunci atau filter pencarian</div>
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 4px 0; flex-wrap:wrap; gap:8px;">
            <span style="font-size:12.5px; color:var(--text-tertiary);" id="tableFooter">
                Menampilkan <strong>{{ $lansias->count() }}</strong> data lansia
            </span>
            <div style="display:flex; gap:6px; font-size:12px; color:var(--text-tertiary); align-items:center; flex-wrap:wrap;">
                <span class="badge badge--success" style="font-size:11px;"><span class="badge__dot"></span> Stabil: {{ $stabil }}</span>
                <span class="badge badge--warning" style="font-size:11px;"><span class="badge__dot"></span> Pantau: {{ $pantau }}</span>
                <span class="badge badge--danger" style="font-size:11px;"><span class="badge__dot"></span> Rujukan: {{ $rujuk }}</span>
            </div>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
function toggleFilter() {
    const p = document.getElementById('filterPanel');
    const btn = document.getElementById('filterToggleBtn');
    const isHidden = p.style.display === 'none';
    p.style.display = isHidden ? 'block' : 'none';
    btn.innerHTML = isHidden ? '<i class="fas fa-times"></i> Tutup Filter' : '<i class="fas fa-filter"></i> Filter';
}

function applyFilter() {
    const status  = document.getElementById('filterStatus')?.value.toLowerCase() || '';
    const jk      = document.getElementById('filterJK')?.value.toLowerCase() || '';
    const search1 = (document.getElementById('searchLansia')?.value || '').toLowerCase();
    const search2 = (document.getElementById('quickSearch')?.value || '').toLowerCase();
    const search  = search1 || search2;

    const rows   = document.querySelectorAll('.lansia-row');
    let visible  = 0;

    rows.forEach(row => {
        const rowStatus = row.dataset.status?.toLowerCase() || '';
        const rowJK     = row.dataset.jk?.toLowerCase() || '';
        const rowName   = row.dataset.name || '';

        const matchStatus = !status || rowStatus.includes(status);
        const matchJK     = !jk || rowJK === jk;
        const matchSearch = !search || rowName.includes(search) || row.innerText.toLowerCase().includes(search);

        const show = matchStatus && matchJK && matchSearch;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    const noResults = document.getElementById('noResults');
    const badge = document.getElementById('countBadge');
    const footer = document.getElementById('tableFooter');
    if (noResults) noResults.style.display = visible === 0 ? 'block' : 'none';
    if (badge) badge.textContent = visible;
    if (footer) footer.innerHTML = 'Menampilkan <strong>' + visible + '</strong> data lansia';
}

function resetFilter() {
    ['filterStatus','filterJK','searchLansia','quickSearch'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    applyFilter();
}

// Auto dismiss flash
setTimeout(() => {
    const el = document.getElementById('flashMsg');
    if (el) { el.style.opacity='0'; el.style.transition='opacity .4s'; setTimeout(()=>el.remove(),400); }
}, 4000);
</script>
@endsection
