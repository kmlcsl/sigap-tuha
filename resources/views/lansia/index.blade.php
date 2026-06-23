@extends('layouts.sigap')

@section('title', 'Pendataan Lansia — SIGAP TUHA')

@section('content')
<style>
/* ═══════════════════════════════════════════════════════════════
   Pendataan Lansia — Public Landing Page
   Modern glassmorphism · Animated chart bars · Modal popup
═══════════════════════════════════════════════════════════════ */

/* ── Stat Cards ── */
.pl-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 18px;
    margin-bottom: 32px;
}
.pl-stat {
    background: linear-gradient(145deg, rgba(255,255,255,.98), rgba(239,246,255,.95));
    border-radius: 20px;
    padding: 22px 20px;
    box-shadow: 0 4px 20px rgba(11,44,107,.08);
    border: 1px solid rgba(189,212,255,.5);
    border-top: 4px solid var(--sc, #1d4ed8);
    text-align: center;
    transition: transform .25s cubic-bezier(.34,1.56,.64,1), box-shadow .25s;
    cursor: default;
}
.pl-stat:hover { transform: translateY(-6px); box-shadow: 0 12px 32px rgba(11,44,107,.15); }
.pl-stat__num  { font-size: 40px; font-weight: 900; color: var(--sc); line-height: 1; }
.pl-stat__sub  { font-size: 11.5px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .5px; margin-top: 6px; }
.pl-stat__lp   { display: flex; justify-content: center; gap: 12px; margin-top: 8px; font-size: 12px; font-weight: 600; }
.lbl-l         { color: #1d4ed8; }
.lbl-p         { color: #be185d; }

/* ── Chart Card ── */
.pl-chart-card {
    background: linear-gradient(145deg, rgba(255,255,255,.98), rgba(239,246,255,.95));
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 4px 20px rgba(11,44,107,.08);
    border: 1px solid rgba(189,212,255,.5);
    margin-bottom: 32px;
}
.pl-chart-card__title {
    font-size: 16px;
    font-weight: 800;
    color: #0b2c6b;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.pl-chart-card__hint {
    font-size: 12.5px;
    color: #64748b;
    margin-bottom: 20px;
}
.chart-wrap { position: relative; height: 300px; }

/* ── Table Card ── */
.pl-table-card {
    background: linear-gradient(145deg, rgba(255,255,255,.98), rgba(239,246,255,.95));
    border-radius: 24px;
    box-shadow: 0 4px 20px rgba(11,44,107,.08);
    border: 1px solid rgba(189,212,255,.5);
    overflow-x: auto;
    margin-bottom: 32px;
}
.pl-table-card table  { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.pl-table-card thead tr { background: linear-gradient(90deg,#0b2c6b,#1d4ed8); color: #fff; }
.pl-table-card thead th { padding: 14px 16px; font-weight: 700; font-size: 12px; text-align: left; white-space: nowrap; letter-spacing: .3px; }
.pl-table-card tbody tr { border-bottom: 1px solid #e8f0ff; transition: background .15s; cursor: pointer; }
.pl-table-card tbody tr:hover { background: rgba(29,78,216,.06); }
.pl-table-card tbody td { padding: 13px 16px; color: #374151; vertical-align: middle; }
.pl-table-card tfoot tr { background: #0b2c6b; color: #fff; font-weight: 800; }
.pl-table-card tfoot td { padding: 13px 16px; }

/* ── Kecamatan link ── */
.kec-link {
    color: #1d4ed8;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all .15s;
}
.kec-link:hover { color: #1e40af; text-decoration: underline; text-underline-offset: 3px; }

/* ── Pill badge ── */
.pl-pill {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 999px;
    font-size: 11.5px; font-weight: 700;
}
.pl-pill.l  { background: #dbeafe; color: #1d4ed8; }
.pl-pill.p  { background: #fce7f3; color: #be185d; }
.pl-pill.tot{ background: #0b2c6b; color: #fff; }

/* ── Back button ── */
.pl-back {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 9px 18px;
    background: rgba(255,255,255,.9);
    color: #0b2c6b;
    border-radius: 14px;
    font-weight: 700; font-size: 13.5px;
    text-decoration: none;
    box-shadow: 0 2px 10px rgba(11,44,107,.1);
    border: 1px solid rgba(189,212,255,.5);
    transition: all .2s; margin-bottom: 24px;
}
.pl-back:hover { background: #1d4ed8; color: #fff; box-shadow: 0 4px 14px rgba(29,78,216,.3); }

/* ══════════════════════════════════════════
   MODAL POPUP
══════════════════════════════════════════ */
.modal-overlay {
    position: fixed; inset: 0;
    background: rgba(8,24,60,.65);
    backdrop-filter: blur(6px);
    z-index: 2000;
    display: none; align-items: center; justify-content: center;
    padding: 16px;
    animation: fadein .2s;
}
.modal-overlay.open { display: flex; }
@keyframes fadein { from { opacity:0; } to { opacity:1; } }

.modal-box {
    background: #fff;
    border-radius: 24px;
    max-width: 680px; width: 100%;
    max-height: 88vh; overflow-y: auto;
    box-shadow: 0 32px 80px rgba(11,44,107,.35);
    animation: slideUp .3s cubic-bezier(.34,1.56,.64,1);
}
@keyframes slideUp {
    from { opacity:0; transform: scale(.93) translateY(20px); }
    to   { opacity:1; transform: scale(1) translateY(0); }
}
.modal-header {
    background: linear-gradient(135deg,#0b2c6b,#1d4ed8);
    padding: 22px 26px; border-radius: 24px 24px 0 0;
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; z-index: 1;
}
.modal-header h3 { font-size: 17px; font-weight: 800; color: #fff; margin: 0; }
.modal-close {
    background: rgba(255,255,255,.18); border: none; color: #fff;
    width: 34px; height: 34px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; cursor: pointer; transition: background .15s;
}
.modal-close:hover { background: rgba(255,255,255,.3); }

.modal-body { padding: 26px; }

/* Tabel detail dalam modal */
.usia-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.usia-table thead tr { background: #eff6ff; }
.usia-table thead th {
    padding: 11px 14px; font-weight: 800; font-size: 11.5px;
    color: #1d4ed8; text-transform: uppercase; letter-spacing: .5px; text-align: left;
}
.usia-table thead th.r { text-align: right; }
.usia-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .12s; }
.usia-table tbody tr:hover td { background: #f8fbff; }
.usia-table tbody td { padding: 11px 14px; color: #374151; }
.usia-table tbody td.num { text-align: right; font-weight: 700; }
.usia-table tbody td.num-l { color: #1d4ed8; }
.usia-table tbody td.num-p { color: #be185d; }
.usia-table tbody td.num-tot { color: #0b2c6b; font-size: 15px; font-weight: 900; }
.usia-table tfoot tr { background: #0b2c6b; }
.usia-table tfoot td { padding: 12px 14px; color: #fff; font-weight: 800; font-size: 14px; text-align: right; }
.usia-table tfoot td:first-child { text-align: left; }

@media (max-width: 640px) {
    .pl-stats { grid-template-columns: 1fr 1fr; }
    .pl-stat__num { font-size: 30px; }
    .chart-wrap { height: 220px; }
    .modal-box { max-height: 92vh; }
    .usia-table { font-size: 12px; }
}
</style>

<div class="page-content">
    <div class="content-box" style="background:rgba(255,255,255,.97);max-width:100%;padding:40px 28px;">

        <a href="{{ route('beranda') }}" class="pl-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>

        {{-- ── Hero ────────────────────────────────────────────── --}}
        <div style="text-align:center;margin-bottom:36px;">
            <h1 style="font-size:30px;font-weight:900;color:#0b2c6b;margin:0 0 8px;">Pendataan Lansia</h1>
            <div style="width:60px;height:4px;background:linear-gradient(90deg,#1d4ed8,#7c3aed);border-radius:2px;margin:12px auto;"></div>
            <p style="color:#64748b;max-width:580px;margin:8px auto;font-size:14.5px;line-height:1.7;">
                Rekap data kependudukan per kelompok usia per kecamatan — diperbarui secara berkala oleh tim <strong>SIGAP TUHA</strong>.
                Klik nama kecamatan atau batang grafik untuk melihat detail lengkap.
            </p>
        </div>

        {{-- ── Stat Cards ──────────────────────────────────────── --}}
        @php
            $totalKec       = $lansias->count();
            $totalPendL     = $lansias->sum('jumlah_penduduk_l');
            $totalPendP     = $lansias->sum('jumlah_penduduk_p');
            $totalPend      = $totalPendL + $totalPendP;
            $totalLansiaL   = $lansias->sum('usia_60_69_tahun_l') + $lansias->sum('usia_70_plus_l');
            $totalLansiaP   = $lansias->sum('usia_60_69_tahun_p') + $lansias->sum('usia_70_plus_p');
            $totalLansia    = $totalLansiaL + $totalLansiaP;
            $totalSeniorL   = $lansias->sum('usia_70_plus_l');
            $totalSeniorP   = $lansias->sum('usia_70_plus_p');
        @endphp
        <div class="pl-stats">
            <div class="pl-stat" style="--sc:#1d4ed8;">
                <div class="pl-stat__num">{{ $totalKec }}</div>
                <div class="pl-stat__sub">Kecamatan</div>
            </div>
            <div class="pl-stat" style="--sc:#0891b2;">
                <div class="pl-stat__num">{{ number_format($totalPend) }}</div>
                <div class="pl-stat__sub">Total Penduduk</div>
                <div class="pl-stat__lp">
                    <span class="lbl-l"><i class="fas fa-mars"></i> {{ number_format($totalPendL) }}</span>
                    <span class="lbl-p"><i class="fas fa-venus"></i> {{ number_format($totalPendP) }}</span>
                </div>
            </div>
            <div class="pl-stat" style="--sc:#dc2626;">
                <div class="pl-stat__num">{{ number_format($totalLansia) }}</div>
                <div class="pl-stat__sub">Total Lansia (60+)</div>
                <div class="pl-stat__lp">
                    <span class="lbl-l"><i class="fas fa-mars"></i> {{ number_format($totalLansiaL) }}</span>
                    <span class="lbl-p"><i class="fas fa-venus"></i> {{ number_format($totalLansiaP) }}</span>
                </div>
            </div>
            <div class="pl-stat" style="--sc:#9f1239;">
                <div class="pl-stat__num">{{ number_format($totalSeniorL + $totalSeniorP) }}</div>
                <div class="pl-stat__sub">Lansia Senior (&gt;70 Thn)</div>
                <div class="pl-stat__lp">
                    <span class="lbl-l"><i class="fas fa-mars"></i> {{ number_format($totalSeniorL) }}</span>
                    <span class="lbl-p"><i class="fas fa-venus"></i> {{ number_format($totalSeniorP) }}</span>
                </div>
            </div>
        </div>

        {{-- ── Grafik ───────────────────────────────────────────── --}}
        <div class="pl-chart-card">
            <div class="pl-chart-card__title">
                <i class="fas fa-chart-bar" style="color:#1d4ed8;"></i>
                Distribusi Penduduk per Kecamatan
            </div>
            <div class="pl-chart-card__hint">
                <i class="fas fa-hand-pointer" style="color:#1d4ed8;"></i>
                Klik batang grafik untuk melihat detail seluruh kelompok usia kecamatan tersebut.
            </div>
            <div class="chart-wrap">
                <canvas id="chartKec"></canvas>
            </div>
        </div>

        {{-- ── Tabel Ringkasan ─────────────────────────────────── --}}
        <div style="margin-bottom:18px;">
            <div style="font-size:20px;font-weight:800;color:#0b2c6b;margin-bottom:4px;">
                <i class="fas fa-table" style="margin-right:6px;color:#1d4ed8;"></i>Ringkasan Per Kecamatan
            </div>
            <p style="color:#64748b;font-size:14px;margin:0;">
                Klik baris atau nama kecamatan untuk melihat <strong>detail lengkap seluruh kelompok usia (L, P, Total)</strong>.
            </p>
        </div>

        <div class="pl-table-card">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Kecamatan</th>
                        <th style="text-align:center;">Penduduk L</th>
                        <th style="text-align:center;">Penduduk P</th>
                        <th style="text-align:center;">Total Penduduk</th>
                        <th style="text-align:center;">Lansia (60+) L</th>
                        <th style="text-align:center;">Lansia (60+) P</th>
                        <th style="text-align:center;">Total Lansia</th>
                        <th style="text-align:center;width:100px;">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lansias as $i => $row)
                    @php
                        $lansiaL = $row->usia_60_69_tahun_l + $row->usia_70_plus_l;
                        $lansiaP = $row->usia_60_69_tahun_p + $row->usia_70_plus_p;
                        $detail  = json_encode($row->getDetailUsiaArray());
                    @endphp
                    <tr onclick="showModal('{{ addslashes($row->kecamatan) }}', {{ $detail }})" style="cursor:pointer;">
                        <td style="font-weight:700;color:#94a3b8;font-size:12px;">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</td>
                        <td>
                            <span class="kec-link">
                                <i class="fas fa-location-dot" style="font-size:11px;color:#1d4ed8;"></i>
                                {{ $row->kecamatan }}
                            </span>
                        </td>
                        <td style="text-align:center;"><span class="pl-pill l"><i class="fas fa-mars"></i> {{ number_format($row->jumlah_penduduk_l) }}</span></td>
                        <td style="text-align:center;"><span class="pl-pill p"><i class="fas fa-venus"></i> {{ number_format($row->jumlah_penduduk_p) }}</span></td>
                        <td style="text-align:center;font-weight:800;color:#0b2c6b;font-size:15px;">{{ number_format($row->jumlah_penduduk_l + $row->jumlah_penduduk_p) }}</td>
                        <td style="text-align:center;"><span class="pl-pill l">{{ number_format($lansiaL) }}</span></td>
                        <td style="text-align:center;"><span class="pl-pill p">{{ number_format($lansiaP) }}</span></td>
                        <td style="text-align:center;"><span class="pl-pill tot">{{ number_format($lansiaL + $lansiaP) }}</span></td>
                        <td style="text-align:center;">
                            <button onclick="event.stopPropagation();showLansiaModal('{{ addslashes($row->kecamatan) }}', {{ $detail }})"
                                style="background:linear-gradient(135deg,#1d4ed8,#0b2c6b);border:none;color:#fff;padding:6px 14px;border-radius:10px;font-size:12px;font-weight:700;cursor:pointer;transition:all .15s;"
                                onmouseover="this.style.transform='scale(1.05)'"
                                onmouseout="this.style.transform=''">
                                <i class="fas fa-search"></i> Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align:center;padding:48px;color:#94a3b8;">
                            <i class="fas fa-database" style="font-size:40px;margin-bottom:14px;display:block;opacity:.4;"></i>
                            Data belum tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($lansias->count())
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align:left;">TOTAL</td>
                        <td style="text-align:center;">{{ number_format($totalPendL) }}</td>
                        <td style="text-align:center;">{{ number_format($totalPendP) }}</td>
                        <td style="text-align:center;font-size:16px;">{{ number_format($totalPend) }}</td>
                        <td style="text-align:center;">{{ number_format($totalLansiaL) }}</td>
                        <td style="text-align:center;">{{ number_format($totalLansiaP) }}</td>
                        <td style="text-align:center;font-size:16px;">{{ number_format($totalLansia) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

    </div>{{-- /content-box --}}
</div>{{-- /page-content --}}

{{-- ═══════════════════════════════════════════
     MODAL DETAIL RENTANG USIA
═══════════════════════════════════════════ --}}
<div class="modal-overlay" id="modalOverlay">
    <div class="modal-box">
        <div class="modal-header">
            <h3 id="modalTitle">Detail Rentang Usia</h3>
            <button class="modal-close" onclick="closeLansiaModal()" aria-label="Tutup">×</button>
        </div>
        <div class="modal-body">
            <p style="font-size:13px;color:#64748b;margin-bottom:18px;">
                Rincian jumlah penduduk per kelompok usia — Laki-laki (L), Perempuan (P), dan Total.
            </p>
            <table class="usia-table">
                <thead>
                    <tr>
                        <th>Kelompok Usia</th>
                        <th class="r" style="color:#1d4ed8;">L</th>
                        <th class="r" style="color:#be185d;">P</th>
                        <th class="r" style="color:#0b2c6b;">Total</th>
                    </tr>
                </thead>
                <tbody id="modalBody"></tbody>
                <tfoot>
                    <tr>
                        <td id="modalTotalLabel" style="text-align:left;">Grand Total Penduduk</td>
                        <td id="modalTotalL"></td>
                        <td id="modalTotalP"></td>
                        <td id="modalTotalTot" style="font-size:17px;"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════
     SCRIPTS
═══════════════════════════════════════════ --}}
@php
$kecamatanJson = $lansias->map(function($r) {
    return [
        'kecamatan'  => $r->kecamatan,
        'penduduk_l' => $r->jumlah_penduduk_l,
        'penduduk_p' => $r->jumlah_penduduk_p,
        'detail'     => $r->getDetailUsiaArray(),
    ];
})->values()->toArray();
@endphp
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
// Pindahkan modal ke body agar tidak terperangkap z-index dari parent container
document.addEventListener('DOMContentLoaded', function() {
    document.body.appendChild(document.getElementById('modalOverlay'));
});

// ── Data dari Laravel ──────────────────────────────────────────
const kecamatanData = {!! json_encode($kecamatanJson) !!};

// ── Chart.js Bar Chart ─────────────────────────────────────────
(function() {
    const labels    = kecamatanData.map(d => d.kecamatan);
    const dataL     = kecamatanData.map(d => d.penduduk_l);
    const dataP     = kecamatanData.map(d => d.penduduk_p);

    const chart = new Chart(document.getElementById('chartKec'), {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Laki-laki',
                    data: dataL,
                    backgroundColor: 'rgba(29,78,216,.75)',
                    hoverBackgroundColor: 'rgba(29,78,216,1)',
                    borderRadius: { topLeft: 6, topRight: 6 },
                    borderSkipped: false,
                },
                {
                    label: 'Perempuan',
                    data: dataP,
                    backgroundColor: 'rgba(190,24,93,.65)',
                    hoverBackgroundColor: 'rgba(190,24,93,.9)',
                    borderRadius: { topLeft: 6, topRight: 6 },
                    borderSkipped: false,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    position: 'top',
                    labels: { font: { size: 12, weight: '600' }, usePointStyle: true, pointStyleWidth: 10 }
                },
                tooltip: {
                    backgroundColor: '#0b2c6b',
                    titleFont: { size: 13, weight: '700' },
                    bodyFont:  { size: 12 },
                    padding: 12,
                    callbacks: {
                        label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y.toLocaleString()} jiwa`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11, weight: '600' }, color: '#475467' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(11,44,107,.07)' },
                    ticks: {
                        font: { size: 11 },
                        callback: v => v.toLocaleString()
                    }
                }
            },
            onClick(_, elements) {
                if (!elements.length) return;
                const idx = elements[0].index;
                const row = kecamatanData[idx];
                showLansiaModal(row.kecamatan, row.detail);
            },
            onHover(event, elements) {
                event.native.target.style.cursor = elements.length ? 'pointer' : 'default';
            }
        }
    });
})();

// ── Modal Logic ────────────────────────────────────────────────
function showLansiaModal(kecamatan, detail) {
    document.getElementById('modalTitle').innerHTML = '<i class="fas fa-map-marker-alt" style="color:#ef4444;margin-right:6px;"></i>' + (kecamatan || 'Kecamatan');

    const tbody = document.getElementById('modalBody');
    tbody.innerHTML = '';

    let sumL = 0, sumP = 0, sumTot = 0;

    // Icons per row (menggunakan FontAwesome)
    const icons = [
        '<i class="fas fa-users" style="color:var(--brand-500);width:16px;text-align:center;"></i>', 
        '<i class="fas fa-baby" style="color:#5b21b6;width:16px;text-align:center;"></i>', 
        '<i class="fas fa-baby-carriage" style="color:#1d4ed8;width:16px;text-align:center;"></i>', 
        '<i class="fas fa-child" style="color:#0e7490;width:16px;text-align:center;"></i>', 
        '<i class="fas fa-child-reaching" style="color:#15803d;width:16px;text-align:center;"></i>', 
        '<i class="fas fa-person" style="color:#065f46;width:16px;text-align:center;"></i>', 
        '<i class="fas fa-person" style="color:#854d0e;width:16px;text-align:center;"></i>', 
        '<i class="fas fa-user" style="color:#9a3412;width:16px;text-align:center;"></i>', 
        '<i class="fas fa-user-tie" style="color:#b91c1c;width:16px;text-align:center;"></i>', 
        '<i class="fas fa-user-clock" style="color:#9d174d;width:16px;text-align:center;"></i>', 
        '<i class="fas fa-person-cane" style="color:#6b21a8;width:16px;text-align:center;"></i>'
    ];

    detail.forEach((row, i) => {
        const l   = row.l   ?? 0;
        const p   = row.p   ?? 0;
        const tot = row.total ?? (l + p);

        // Baris pertama (Jumlah Penduduk) tidak dimasukkan ke sum baris lain
        if (i > 0) { sumL += l; sumP += p; sumTot += tot; }

        const tr = document.createElement('tr');

        // Baris Jumlah Penduduk punya styling khusus
        if (i === 0) {
            tr.style.background = '#f8f9ff';
            tr.style.fontWeight = '700';
        }

        tr.innerHTML = `
            <td style="${i===0?'color:#0b2c6b;':''}">
                ${icons[i] || '<i class="fas fa-user"></i>'} ${row.label}
                ${i===0 ? '<span style="font-size:10.5px;color:#64748b;font-weight:400;margin-left:4px;">(data sensus)</span>' : ''}
            </td>
            <td class="num num-l" style="${i===0?'color:#1d4ed8;':''}">${l.toLocaleString()}</td>
            <td class="num num-p" style="${i===0?'color:#be185d;':''}">${p.toLocaleString()}</td>
            <td class="num num-tot" style="${i===0?'font-size:15px;':''}">${tot.toLocaleString()}</td>
        `;
        tbody.appendChild(tr);
    });

    // Footer total (seluruh kelompok usia, kecuali baris Jumlah Penduduk)
    document.getElementById('modalTotalLabel').textContent = 'Total Semua Kelompok Usia';
    document.getElementById('modalTotalL').textContent     = sumL.toLocaleString();
    document.getElementById('modalTotalP').textContent     = sumP.toLocaleString();
    document.getElementById('modalTotalTot').textContent   = sumTot.toLocaleString();

    document.getElementById('modalOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeLansiaModal() {
    document.getElementById('modalOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

// Tutup saat klik di luar modal box
document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeLansiaModal();
});
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLansiaModal(); });
</script>

@endsection
