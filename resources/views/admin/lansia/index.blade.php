@extends('layouts.admin')
@section('header_title', 'Pendataan Lansia')

@section('content')

{{-- ══════════════════════════════════════════════════════════
     PAGE HEADER
══════════════════════════════════════════════════════════ --}}
<div class="page-header" style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:16px;margin-bottom:24px;">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-users" style="color:var(--brand-500);margin-right:10px;font-size:22px;"></i>
            Pendataan Lansia
        </h1>
        <p class="page-header__desc">Rekap jumlah penduduk per kelompok usia per desa — Kabupaten Bireuen.</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
        <a href="{{ route('admin.lansia.export') }}"
           class="btn btn-success"
           style="background:linear-gradient(135deg,#059669,#047857);border:none;color:#fff;display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:var(--radius-md);font-weight:700;font-size:13.5px;text-decoration:none;box-shadow:0 3px 10px rgba(5,150,105,.3);transition:all .2s;"
           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 18px rgba(5,150,105,.4)';"
           onmouseout="this.style.transform='';this.style.boxShadow='0 3px 10px rgba(5,150,105,.3)';">
            <i class="fas fa-file-excel"></i> Cetak Hasil Excel
        </a>
        <a href="{{ route('admin.lansia.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Desa
        </a>
    </div>
</div>

{{-- Flash Message --}}
@if(session('success'))
    <div class="flash-message success" id="flashMsg">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button onclick="document.getElementById('flashMsg').remove()"
            style="margin-left:auto;background:none;border:none;cursor:pointer;color:inherit;opacity:.6;font-size:18px;">&times;</button>
    </div>
@endif

{{-- ══════════════════════════════════════════════════════════
     STATS CARDS
══════════════════════════════════════════════════════════ --}}
<div class="stats-grid" style="margin-bottom:24px;">
    @php
        $totalDesa   = $lansias->count();
        $grandPendudukL   = $totalPendudukL;
        $grandPendudukP   = $totalPendudukP;
        $grandPenduduk    = $grandPendudukL + $grandPendudukP;
        $grandLansiaTotal = $totalLansiaL + $totalLansiaP;
    @endphp

    <div class="stat-card brand">
        <div class="stat-card__top">
            <span class="stat-card__label">Desa</span>
            <div class="stat-card__icon brand"><i class="fas fa-map-marked-alt"></i></div>
        </div>
        <div class="stat-card__value">{{ $totalDesa }}</div>
        <div style="font-size:12px;color:var(--text-tertiary);margin-top:6px;">Wilayah terdaftar</div>
    </div>

    <div class="stat-card success">
        <div class="stat-card__top">
            <span class="stat-card__label">Total Penduduk</span>
            <div class="stat-card__icon success"><i class="fas fa-people-group"></i></div>
        </div>
        <div class="stat-card__value">{{ number_format($grandPenduduk) }}</div>
        <div style="font-size:12px;color:var(--text-tertiary);margin-top:6px;display:flex;gap:10px;">
            <span><i class="fas fa-mars" style="color:var(--brand-400);"></i> {{ number_format($grandPendudukL) }}</span>
            <span><i class="fas fa-venus" style="color:#be185d;"></i> {{ number_format($grandPendudukP) }}</span>
        </div>
    </div>

    <div class="stat-card warning">
        <div class="stat-card__top">
            <span class="stat-card__label">Total Lansia (60+)</span>
            <div class="stat-card__icon warning"><i class="fas fa-user-clock"></i></div>
        </div>
        <div class="stat-card__value">{{ number_format($grandLansiaTotal) }}</div>
        <div style="font-size:12px;color:var(--text-tertiary);margin-top:6px;display:flex;gap:10px;">
            <span><i class="fas fa-mars" style="color:var(--brand-400);"></i> {{ number_format($totalLansiaL) }}</span>
            <span><i class="fas fa-venus" style="color:#be185d;"></i> {{ number_format($totalLansiaP) }}</span>
        </div>
    </div>

    <div class="stat-card danger">
        <div class="stat-card__top">
            <span class="stat-card__label">Lansia Senior (>70)</span>
            <div class="stat-card__icon danger"><i class="fas fa-heart-pulse"></i></div>
        </div>
        <div class="stat-card__value">{{ number_format($lansias->sum('usia_70_plus_l') + $lansias->sum('usia_70_plus_p')) }}</div>
        <div style="font-size:12px;color:var(--text-tertiary);margin-top:6px;">
            <span><i class="fas fa-mars" style="color:var(--brand-400);"></i> {{ number_format($lansias->sum('usia_70_plus_l')) }}</span>
            <span style="margin-left:8px;"><i class="fas fa-venus" style="color:#be185d;"></i> {{ number_format($lansias->sum('usia_70_plus_p')) }}</span>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     SEARCH + TABLE CARD
══════════════════════════════════════════════════════════ --}}
<div class="card">
    <div class="card__header" style="flex-wrap:wrap;gap:12px;">
        <h3 class="card__title">
            <i class="fas fa-table-list"></i> Rekap Per Desa
            <span class="badge badge--brand" style="margin-left:8px;font-size:11px;" id="countBadge">{{ $lansias->count() }}</span>
        </h3>
        <div style="position:relative;">
            <i class="fas fa-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-placeholder);font-size:12px;pointer-events:none;"></i>
            <input type="text" id="quickSearch" oninput="applyFilter()" placeholder="Cari desa..."
                style="padding:7px 12px 7px 30px;border:1px solid var(--border-primary);border-radius:var(--radius-md);font-size:13px;font-family:inherit;background:var(--gray-50);color:var(--text-primary);width:200px;">
        </div>
    </div>

    @if($lansias->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon"><i class="fas fa-database"></i></div>
            <div class="empty-state__title">Belum Ada Data Desa</div>
            <div class="empty-state__desc">Tambahkan data rekap penduduk per desa untuk memulai.</div>
            <a href="{{ route('admin.lansia.create') }}" class="btn btn-primary" style="margin-top:4px;">
                <i class="fas fa-plus"></i> Tambah Data Pertama
            </a>
        </div>
    @else
        <div class="table-wrap" style="overflow-x:auto;">
            <table class="table" id="lansiaTable" style="min-width:900px;">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th><i class="fas fa-map-pin" style="margin-right:4px;"></i> Desa</th>
                        <th style="text-align:center;background:var(--brand-50);" colspan="3">Jumlah Penduduk</th>
                        <th style="text-align:center;background:#f0fdf4;" colspan="2">Lansia 60–69</th>
                        <th style="text-align:center;background:#fff7ed;" colspan="2">Lansia >70</th>
                        <th style="text-align:center;background:#fef2f2;" colspan="2">Total Lansia (60+)</th>
                        <th style="width:120px;text-align:center;"><i class="fas fa-cogs"></i></th>
                    </tr>
                    <tr style="font-size:11.5px;background:var(--gray-50);">
                        <th></th>
                        <th></th>
                        <th style="text-align:center;font-weight:600;color:var(--brand-600);">L</th>
                        <th style="text-align:center;font-weight:600;color:#be185d;">P</th>
                        <th style="text-align:center;font-weight:700;">Total</th>
                        <th style="text-align:center;font-weight:600;color:var(--brand-600);">L</th>
                        <th style="text-align:center;font-weight:600;color:#be185d;">P</th>
                        <th style="text-align:center;font-weight:600;color:var(--brand-600);">L</th>
                        <th style="text-align:center;font-weight:600;color:#be185d;">P</th>
                        <th style="text-align:center;font-weight:600;color:var(--brand-600);">L</th>
                        <th style="text-align:center;font-weight:600;color:#be185d;">P</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="lansiaTableBody">
                    @foreach($lansias as $i => $row)
                    <tr class="lansia-row" data-name="{{ strtolower($row->desa) }}">
                        <td><span style="font-weight:700;color:var(--text-tertiary);">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</span></td>
                        <td>
                            <div style="font-weight:700;color:var(--text-primary);font-size:14px;">
                                <i class="fas fa-location-dot" style="color:var(--brand-400);font-size:11px;margin-right:5px;"></i>
                                {{ $row->desa }}
                            </div>
                        </td>
                        <td style="text-align:center;color:var(--brand-700);font-weight:600;">{{ number_format($row->jumlah_penduduk_l) }}</td>
                        <td style="text-align:center;color:#be185d;font-weight:600;">{{ number_format($row->jumlah_penduduk_p) }}</td>
                        <td style="text-align:center;font-weight:800;font-size:15px;">{{ number_format($row->jumlah_penduduk_l + $row->jumlah_penduduk_p) }}</td>
                        <td style="text-align:center;color:var(--brand-600);">{{ number_format($row->usia_60_69_tahun_l) }}</td>
                        <td style="text-align:center;color:#be185d;">{{ number_format($row->usia_60_69_tahun_p) }}</td>
                        <td style="text-align:center;color:var(--brand-600);">{{ number_format($row->usia_70_plus_l) }}</td>
                        <td style="text-align:center;color:#be185d;">{{ number_format($row->usia_70_plus_p) }}</td>
                        <td style="text-align:center;color:var(--brand-600);font-weight:700;">{{ number_format($row->usia_60_69_tahun_l + $row->usia_70_plus_l) }}</td>
                        <td style="text-align:center;color:#be185d;font-weight:700;">{{ number_format($row->usia_60_69_tahun_p + $row->usia_70_plus_p) }}</td>
                        <td>
                            <div style="display:flex;gap:5px;justify-content:center;">
                                <a href="{{ route('admin.lansia.edit', $row) }}" class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.lansia.destroy', $row) }}" method="POST"
                                    onsubmit="return confirm('Hapus data desa {{ addslashes($row->desa) }}?')">
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
                {{-- Baris Total --}}
                <tfoot>
                    <tr style="background:var(--brand-950);color:#fff;font-weight:800;">
                        <td colspan="2" style="padding:12px 16px;font-size:13px;letter-spacing:.5px;">TOTAL</td>
                        <td style="text-align:center;">{{ number_format($totalPendudukL) }}</td>
                        <td style="text-align:center;">{{ number_format($totalPendudukP) }}</td>
                        <td style="text-align:center;font-size:15px;">{{ number_format($totalPendudukL + $totalPendudukP) }}</td>
                        <td style="text-align:center;">{{ number_format($lansias->sum('usia_60_69_tahun_l')) }}</td>
                        <td style="text-align:center;">{{ number_format($lansias->sum('usia_60_69_tahun_p')) }}</td>
                        <td style="text-align:center;">{{ number_format($lansias->sum('usia_70_plus_l')) }}</td>
                        <td style="text-align:center;">{{ number_format($lansias->sum('usia_70_plus_p')) }}</td>
                        <td style="text-align:center;">{{ number_format($totalLansiaL) }}</td>
                        <td style="text-align:center;">{{ number_format($totalLansiaP) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div id="noResults" style="display:none;text-align:center;padding:32px;color:var(--text-tertiary);">
            <i class="fas fa-search" style="font-size:32px;opacity:.4;margin-bottom:12px;"></i>
            <div style="font-weight:600;">Desa tidak ditemukan</div>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 4px 0;flex-wrap:wrap;gap:8px;">
            <span style="font-size:12.5px;color:var(--text-tertiary);" id="tableFooter">
                Menampilkan <strong>{{ $lansias->count() }}</strong> desa
            </span>
            <span style="font-size:12px;color:var(--text-tertiary);">
                Total penduduk: <strong>{{ number_format($totalPendudukL + $totalPendudukP) }}</strong>
                &nbsp;|&nbsp;
                Total lansia (60+): <strong>{{ number_format($totalLansiaL + $totalLansiaP) }}</strong>
            </span>
        </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
function applyFilter() {
    const q = (document.getElementById('quickSearch')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('.lansia-row');
    let visible = 0;

    rows.forEach(row => {
        const name = row.dataset.name || '';
        const show = !q || name.includes(q) || row.innerText.toLowerCase().includes(q);
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    const noResults = document.getElementById('noResults');
    const badge     = document.getElementById('countBadge');
    const footer    = document.getElementById('tableFooter');
    if (noResults) noResults.style.display = visible === 0 ? 'block' : 'none';
    if (badge)     badge.textContent = visible;
    if (footer)    footer.innerHTML  = 'Menampilkan <strong>' + visible + '</strong> desa';
}

// Auto dismiss flash
setTimeout(() => {
    const el = document.getElementById('flashMsg');
    if (el) { el.style.opacity='0'; el.style.transition='opacity .4s'; setTimeout(()=>el.remove(),400); }
}, 4000);
</script>
@endsection
