@extends('layouts.admin')
@section('header_title', 'Laporan Darurat')

@section('content')

{{-- Page Header --}}
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-bell" style="color:var(--danger-500); margin-right:10px; font-size:22px;"></i>
            Laporan Darurat
        </h1>
        <p class="page-header__desc">Pantau dan kelola laporan kondisi darurat dari relawan lapangan secara real-time.</p>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <button onclick="toggleFilter()" class="btn btn-outline btn-sm" id="filterToggleBtn">
            <i class="fas fa-filter"></i> Filter
        </button>
        <a href="{{ route('admin.laporan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Laporan
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
    $total    = $laporans->count();
    $baru     = $laporans->where('status','Baru')->count();
    $proses   = $laporans->where('status','Diproses')->count();
    $selesai  = $laporans->where('status','Selesai')->count();
    $kritis   = $laporans->where('tingkat_urgensi','Kritis')->count();
@endphp
<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card brand">
        <div class="stat-card__top">
            <span class="stat-card__label">Total Laporan</span>
            <div class="stat-card__icon brand"><i class="fas fa-file-medical"></i></div>
        </div>
        <div class="stat-card__value">{{ $total }}</div>
        <div class="stat-card__change up"><i class="fas fa-list" style="font-size:10px"></i> Semua</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-card__top">
            <span class="stat-card__label">Baru / Belum Ditangani</span>
            <div class="stat-card__icon danger"><i class="fas fa-exclamation-circle"></i></div>
        </div>
        <div class="stat-card__value">{{ $baru }}</div>
        <div class="stat-card__change down"><i class="fas fa-bell" style="font-size:10px"></i> Segera Tangani</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-card__top">
            <span class="stat-card__label">Sedang Diproses</span>
            <div class="stat-card__icon warning"><i class="fas fa-spinner"></i></div>
        </div>
        <div class="stat-card__value">{{ $proses }}</div>
        <div class="stat-card__change up"><i class="fas fa-clock" style="font-size:10px"></i> On Progress</div>
    </div>
    <div class="stat-card success">
        <div class="stat-card__top">
            <span class="stat-card__label">Selesai</span>
            <div class="stat-card__icon success"><i class="fas fa-check-double"></i></div>
        </div>
        <div class="stat-card__value">{{ $selesai }}</div>
        <div class="stat-card__change up"><i class="fas fa-check" style="font-size:10px"></i> Tertangani</div>
    </div>
</div>

{{-- Alert: Laporan Kritis --}}
@if($kritis > 0)
<div style="padding:16px 20px; background:linear-gradient(135deg, #fef2f2, #fee2e2); border:1px solid #fecaca; border-left:4px solid var(--danger-500); border-radius:var(--radius-lg); display:flex; align-items:center; gap:14px; margin-bottom:20px; flex-wrap:wrap;">
    <div style="width:44px; height:44px; border-radius:var(--radius-full); background:var(--danger-500); display:flex; align-items:center; justify-content:center; flex-shrink:0; animation:pulse-dot 1.5s ease-in-out infinite;">
        <i class="fas fa-exclamation" style="color:#fff; font-size:20px;"></i>
    </div>
    <div style="flex:1; min-width:0;">
        <div style="font-weight:800; font-size:15px; color:var(--danger-700);">
            ⚠️ {{ $kritis }} Laporan Berstatus KRITIS
        </div>
        <div style="font-size:13px; color:var(--danger-700); opacity:.8; margin-top:2px;">
            Segera tangani laporan dengan tingkat urgensi kritis untuk keselamatan lansia.
        </div>
    </div>
    <button onclick="document.getElementById('filterUrgensi').value='Kritis'; applyFilter();"
        class="btn btn-danger btn-sm" style="flex-shrink:0;">
        <i class="fas fa-eye"></i> Lihat Laporan Kritis
    </button>
</div>
@endif

{{-- Filter Panel --}}
<div id="filterPanel" style="display:none; margin-bottom:20px;">
    <div class="card" style="padding:20px;">
        <div style="font-size:13px; font-weight:700; color:var(--text-primary); margin-bottom:14px;">
            <i class="fas fa-filter" style="color:var(--danger-500); margin-right:6px;"></i> Filter Laporan
        </div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:14px;">
            <div>
                <label style="font-size:12px; font-weight:600; color:var(--text-tertiary); display:block; margin-bottom:5px;">Status Laporan</label>
                <select id="filterStatus" onchange="applyFilter()" class="form-control" style="font-size:13px; padding:8px 12px;">
                    <option value="">Semua Status</option>
                    <option value="Baru">Baru</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Ditangani">Ditangani</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>
            <div>
                <label style="font-size:12px; font-weight:600; color:var(--text-tertiary); display:block; margin-bottom:5px;">Tingkat Urgensi</label>
                <select id="filterUrgensi" onchange="applyFilter()" class="form-control" style="font-size:13px; padding:8px 12px;">
                    <option value="">Semua Urgensi</option>
                    <option value="Kritis">Kritis</option>
                    <option value="Tinggi">Tinggi</option>
                    <option value="Sedang">Sedang</option>
                    <option value="Rendah">Rendah</option>
                </select>
            </div>
            <div>
                <label style="font-size:12px; font-weight:600; color:var(--text-tertiary); display:block; margin-bottom:5px;">Cari</label>
                <input type="text" id="searchLaporan" oninput="applyFilter()" class="form-control"
                    style="font-size:13px; padding:8px 12px;" placeholder="Nama lansia / pelapor...">
            </div>
            <div style="display:flex; align-items:flex-end;">
                <button onclick="resetFilter()" class="btn btn-outline btn-sm" style="width:100%;">
                    <i class="fas fa-undo"></i> Reset
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card__header" style="flex-wrap:wrap; gap:12px;">
        <h3 class="card__title">
            <i class="fas fa-list-ul"></i> Daftar Laporan
            <span class="badge badge--danger" style="margin-left:8px; font-size:11px;" id="countBadge">{{ $total }}</span>
        </h3>
        <div style="position:relative;">
            <i class="fas fa-search" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:var(--text-placeholder); font-size:12px; pointer-events:none;"></i>
            <input type="text" id="quickSearch" oninput="applyFilter()" placeholder="Cari cepat..."
                style="padding:7px 12px 7px 30px; border:1px solid var(--border-primary); border-radius:var(--radius-md); font-size:13px; font-family:inherit; background:var(--gray-50); color:var(--text-primary); width:220px;">
        </div>
    </div>

    @if($laporans->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-file-medical"></i></div>
            <div class="empty-state__title">Belum Ada Laporan Darurat</div>
            <div class="empty-state__desc">Sistem berjalan baik. Tidak ada laporan darurat saat ini.</div>
        </div>
    @else
        <div class="table-wrap">
            <table class="table" id="laporanTable">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th><i class="fas fa-user" style="margin-right:4px;"></i> Lansia</th>
                        <th><i class="fas fa-user-tie" style="margin-right:4px;"></i> Pelapor</th>
                        <th><i class="fas fa-stethoscope" style="margin-right:4px;"></i> Kondisi</th>
                        <th style="text-align:center;"><i class="fas fa-bolt" style="margin-right:4px;"></i> Urgensi</th>
                        <th style="text-align:center;"><i class="fas fa-flag" style="margin-right:4px;"></i> Status</th>
                        <th><i class="far fa-clock" style="margin-right:4px;"></i> Waktu</th>
                        <th style="width:160px; text-align:center;"><i class="fas fa-cogs" style="margin-right:4px;"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporans as $i => $lap)
                    <tr class="laporan-row"
                        data-status="{{ $lap->status }}"
                        data-urgensi="{{ $lap->tingkat_urgensi }}"
                        data-name="{{ strtolower($lap->lansia->nama ?? '') }} {{ strtolower($lap->pelapor) }}"
                        style="{{ $lap->status == 'Baru' && $lap->tingkat_urgensi == 'Kritis' ? 'background:rgba(254,202,202,.25);' : '' }}">
                        <td>
                            <span style="font-weight:700; color:var(--text-tertiary);">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <div style="font-weight:700; color:var(--text-primary); font-size:14px;">{{ $lap->lansia->nama ?? '—' }}</div>
                            @if($lap->lansia)
                                <div style="font-size:11.5px; color:var(--text-tertiary);">{{ $lap->lansia->desa ?? '' }}</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-size:13.5px; color:var(--text-secondary);">{{ $lap->pelapor }}</div>
                        </td>
                        <td style="max-width:200px;">
                            <span style="font-size:13px; color:var(--text-secondary); display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                {{ Str::limit($lap->kondisi, 60) }}
                            </span>
                        </td>
                        <td style="text-align:center;">
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
                        <td style="text-align:center;">
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
                        <td>
                            <div style="font-size:13px; color:var(--text-secondary); font-weight:500;">{{ $lap->created_at->format('d M Y') }}</div>
                            <div style="font-size:11.5px; color:var(--text-tertiary);">{{ $lap->created_at->format('H:i') }} &bull; {{ $lap->created_at->diffForHumans() }}</div>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; justify-content:center; flex-wrap:wrap;">
                                <a href="{{ route('admin.laporan.edit', $lap) }}" class="btn btn-outline btn-sm" title="Edit/Update Status">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('admin.laporan.destroy', $lap) }}" method="POST"
                                    onsubmit="return confirm('Hapus laporan ini?')">
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
            <div style="font-weight:600;">Tidak ada laporan yang cocok</div>
        </div>

        <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 4px 0; flex-wrap:wrap; gap:8px;">
            <span style="font-size:12.5px; color:var(--text-tertiary);" id="tableFooter">
                Menampilkan <strong>{{ $total }}</strong> laporan
            </span>
            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                <span class="badge badge--danger" style="font-size:11px;"><span class="badge__dot"></span> Baru: {{ $baru }}</span>
                <span class="badge badge--warning" style="font-size:11px;"><span class="badge__dot"></span> Proses: {{ $proses }}</span>
                <span class="badge badge--success" style="font-size:11px;"><span class="badge__dot"></span> Selesai: {{ $selesai }}</span>
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
    btn.innerHTML = isHidden ? '<i class="fas fa-times"></i> Tutup' : '<i class="fas fa-filter"></i> Filter';
}

function applyFilter() {
    const status  = document.getElementById('filterStatus')?.value || '';
    const urgensi = document.getElementById('filterUrgensi')?.value || '';
    const search1 = document.getElementById('searchLaporan')?.value.toLowerCase() || '';
    const search2 = document.getElementById('quickSearch')?.value.toLowerCase() || '';
    const search  = search1 || search2;

    const rows   = document.querySelectorAll('.laporan-row');
    let visible  = 0;

    rows.forEach(row => {
        const rowStatus  = row.dataset.status  || '';
        const rowUrgensi = row.dataset.urgensi || '';
        const rowName    = row.dataset.name    || '';

        const matchStatus  = !status  || rowStatus  === status;
        const matchUrgensi = !urgensi || rowUrgensi === urgensi;
        const matchSearch  = !search  || rowName.includes(search) || row.innerText.toLowerCase().includes(search);

        const show = matchStatus && matchUrgensi && matchSearch;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    const noR   = document.getElementById('noResults');
    const badge = document.getElementById('countBadge');
    const footer = document.getElementById('tableFooter');
    if (noR)    noR.style.display  = visible === 0 ? 'block' : 'none';
    if (badge)  badge.textContent  = visible;
    if (footer) footer.innerHTML   = 'Menampilkan <strong>' + visible + '</strong> laporan';
}

function resetFilter() {
    ['filterStatus','filterUrgensi','searchLaporan','quickSearch'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    applyFilter();
}

setTimeout(() => {
    const el = document.getElementById('flashMsg');
    if (el) { el.style.opacity='0'; el.style.transition='opacity .4s'; setTimeout(()=>el.remove(),400); }
}, 4000);
</script>
@endsection
