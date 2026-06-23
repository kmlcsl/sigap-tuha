@extends('layouts.sigap')

@section('title', 'Pendataan Lansia — SIGAP TUHA')

@section('content')
<style>
/* ── Halaman Pendataan Lansia ── */
.lansia-page { padding: 0; }

/* Stat cards */
.lansia-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.lansia-stat-card {
    background: #E6E6E6;
    border-radius: 24px;
    padding: 22px 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border: 1px solid #c0c0c0;
    border-top: 4px solid var(--card-color, #1d4ed8);
    text-align: center;
    transition: transform .2s, box-shadow .2s;
}
.lansia-stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
.lansia-stat-card__value { font-size: 36px; font-weight: 800; color: var(--card-color, #1d4ed8); line-height: 1; margin-bottom: 6px; }
.lansia-stat-card__label { font-size: 12.5px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .5px; }

/* Chart container */
.chart-card {
    background: #E6E6E6;
    border-radius: 24px;
    padding: 24px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border: 1px solid #c0c0c0;
    margin-bottom: 32px;
}
.chart-card__title { font-size: 15px; font-weight: 700; color: var(--ink); margin-bottom: 16px; }

/* Table */
.lansia-table-card {
    background: #E6E6E6;
    border-radius: 24px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border: 1px solid #c0c0c0;
    overflow: hidden;
}
.lansia-table-card table { width: 100%; border-collapse: collapse; font-size: 14px; }
.lansia-table-card thead tr { background: rgba(0,0,0,0.05); color: var(--ink); border-bottom: 2px solid #c0c0c0; }
.lansia-table-card thead th { padding: 14px 16px; font-weight: 700; font-size: 13px; text-align: left; white-space: nowrap; }
.lansia-table-card tbody tr { border-bottom: 1px solid #d1d5db; transition: background .15s; }
.lansia-table-card tbody tr:hover { background: rgba(255,255,255,0.5); }
.lansia-table-card tbody td { padding: 13px 16px; color: var(--muted); vertical-align: middle; }

/* Klik desa */
.desa-link {
    color: #1d4ed8;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: color .15s;
    text-decoration: underline;
    text-underline-offset: 3px;
}
.desa-link:hover { color: #2563eb; }

/* Badge */
.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 600;
}
.badge-status.stabil { background: #dcfce7; color: #15803d; }
.badge-status.pantau { background: #fef9c3; color: #a16207; }
.badge-status.rujukan { background: #fee2e2; color: #dc2626; }

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(4px);
    z-index: 1000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
}
.modal-overlay.active { display: flex; }
.modal-box {
    background: #fff;
    border-radius: 20px;
    max-width: 620px;
    width: 100%;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 24px 64px rgba(0,0,0,0.25);
    animation: modalIn .25s ease;
}
@keyframes modalIn {
    from { opacity:0; transform: scale(.94) translateY(12px); }
    to   { opacity:1; transform: scale(1) translateY(0); }
}
.modal-header {
    background: #0b2c6b;
    color: #fff;
    padding: 20px 24px;
    border-radius: 20px 20px 0 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.modal-header h3 { font-size: 17px; font-weight: 700; margin: 0; }
.modal-close {
    background: rgba(255,255,255,0.2);
    border: none;
    color: #fff;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .15s;
}
.modal-close:hover { background: rgba(255,255,255,0.3); }
.modal-body { padding: 24px; }
.usia-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.usia-table th { background: #eff6ff; color: #1d4ed8; padding: 10px 14px; text-align: left; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }
.usia-table td { padding: 10px 14px; border-bottom: 1px solid #f1f5f9; color: #374151; }
.usia-table tr:last-child td { border-bottom: none; }
.usia-table tr:hover td { background: #f8faff; }
.usia-count { font-weight: 800; color: #0b2c6b; font-size: 16px; }

@media (max-width: 640px) {
    .lansia-stats { grid-template-columns: 1fr 1fr; }
    .lansia-table-card { overflow-x: auto; }
    .lansia-stat-card__value { font-size: 28px; }
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: #f1f5f9;
    color: var(--navy);
    border-radius: 12px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: 0.2s;
    margin-bottom: 20px;
}
.btn-back:hover {
    background: #e2e8f0;
    color: var(--blue);
}
</style>

<div class="page-content">
    <div class="content-box" style="background:rgba(255,255,255,0.95);max-width:100%;padding:40px 28px;">
        
        <a href="{{ route('beranda') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>

        <div style="margin-bottom: 30px; text-align: center;">
            <div style="font-size: 48px; color: #1d4ed8; margin-bottom: 16px;"><i class="fas fa-users"></i></div>
            <h2 style="font-size: 28px; font-weight: 800; color: var(--ink);">Pendataan Lansia</h2>
            <div style="width: 60px; height: 4px; background: #1d4ed8; border-radius: 2px; margin: 16px auto;"></div>
            <p style="color: var(--muted); max-width: 600px; margin: 10px auto;">Data penduduk sasaran. Rekap data lansia yang terdampak bencana, diperbarui secara berkala oleh tim SIGAP TUHA.</p>
        </div>

        {{-- STAT CARDS --}}
        <div class="lansia-stats">
            @php
                $totalAll    = $lansias->count();
                $stabil      = $lansias->where('status','Stabil')->count();
                $pantau      = $lansias->where('status','Perlu pemantauan')->count();
                $rujukan     = $lansias->where('status','Rujukan segera')->count();
                $desaCount   = $lansias->groupBy('desa')->count();
            @endphp
            <div class="lansia-stat-card" style="--card-color:#1d4ed8;">
                <div class="lansia-stat-card__value">{{ $totalAll }}</div>
                <div class="lansia-stat-card__label">Total Lansia</div>
            </div>
            <div class="lansia-stat-card" style="--card-color:#15803d;">
                <div class="lansia-stat-card__value">{{ $stabil }}</div>
                <div class="lansia-stat-card__label">Kondisi Stabil</div>
            </div>
            <div class="lansia-stat-card" style="--card-color:#a16207;">
                <div class="lansia-stat-card__value">{{ $pantau }}</div>
                <div class="lansia-stat-card__label">Perlu Pemantauan</div>
            </div>
            <div class="lansia-stat-card" style="--card-color:#dc2626;">
                <div class="lansia-stat-card__value">{{ $rujukan }}</div>
                <div class="lansia-stat-card__label">Rujukan Segera</div>
            </div>
            <div class="lansia-stat-card" style="--card-color:#7c3aed;">
                <div class="lansia-stat-card__value">{{ $desaCount }}</div>
                <div class="lansia-stat-card__label">Desa/Kecamatan</div>
            </div>
        </div>

        {{-- GRAFIK --}}
        <div class="chart-card">
            <div class="chart-card__title">
                <i class="fas fa-chart-bar" style="margin-right:6px; color:#1d4ed8;"></i>
                Jumlah Lansia per Desa / Kecamatan
            </div>
            <div style="position:relative;height:260px;">
                <canvas id="chartDesa"></canvas>
            </div>
        </div>

        {{-- TABEL PER DESA --}}
        <div style="margin-bottom: 20px;">
            <div style="font-size: 20px; font-weight: 800; color: var(--ink); margin-bottom: 6px;">
                <i class="fas fa-table" style="margin-right:6px; color:#1d4ed8;"></i> Data Ringkasan per Desa/Kecamatan
            </div>
            <p style="color: var(--muted); font-size: 14px;">Klik nama desa untuk melihat detail rentang usia penduduk</p>
        </div>

        @php
            $perDesa = $lansias->groupBy('desa');
        @endphp

        <div class="lansia-table-card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Desa / Kecamatan</th>
                        <th>Total Lansia</th>
                        <th>Stabil</th>
                        <th>Perlu Pantau</th>
                        <th>Rujukan</th>
                        <th>Detail Usia</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($perDesa as $desa => $group)
                    @php
                        $jml       = $group->count();
                        $jStabil   = $group->where('status','Stabil')->count();
                        $jPantau   = $group->where('status','Perlu pemantauan')->count();
                        $jRujukan  = $group->where('status','Rujukan segera')->count();

                        // Hitung per rentang usia (field umur = tahun)
                        $usia = [
                            'Bayi (< 1 tahun)'         => $group->where('umur', '<', 1)->count(),
                            'Balita (1–4 tahun)'        => $group->whereBetween('umur', [1, 4])->count(),
                            'Pra-sekolah (5–6 tahun)'   => $group->whereBetween('umur', [5, 6])->count(),
                            'SD Awal (7–9 tahun)'       => $group->whereBetween('umur', [7, 9])->count(),
                            'SD Akhir (10–12 tahun)'    => $group->whereBetween('umur', [10, 12])->count(),
                            'Remaja Awal (13–14 tahun)' => $group->whereBetween('umur', [13, 14])->count(),
                            'Dewasa (15–59 tahun)'      => $group->whereBetween('umur', [15, 59])->count(),
                            'Lansia Muda (60–69 tahun)' => $group->whereBetween('umur', [60, 69])->count(),
                            'Lansia Tua (≥ 70 tahun)'   => $group->where('umur', '>=', 70)->count(),
                        ];
                        $usiaJson = json_encode($usia);
                    @endphp
                    <tr>
                        <td style="font-weight:700;color:#64748b;">{{ $loop->iteration }}</td>
                        <td>
                            <span class="desa-link" onclick="showModal('{{ addslashes($desa) }}', {{ $usiaJson }})">
                                <i class="fas fa-map-marker-alt" style="margin-right:4px;"></i>
                                {{ $desa ?: 'Tidak Diketahui' }}
                            </span>
                        </td>
                        <td><strong>{{ $jml }}</strong> orang</td>
                        <td><span class="badge-status stabil">{{ $jStabil }}</span></td>
                        <td><span class="badge-status pantau">{{ $jPantau }}</span></td>
                        <td><span class="badge-status rujukan">{{ $jRujukan }}</span></td>
                        <td>
                            <button onclick="showModal('{{ addslashes($desa) }}', {{ $usiaJson }})"
                                style="background:rgba(255,255,255,0.7);border:1px solid #c0c0c0;color:#1d4ed8;padding:5px 12px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;transition:all .15s;"
                                onmouseover="this.style.background='#1d4ed8';this.style.color='#fff';"
                                onmouseout="this.style.background='rgba(255,255,255,0.7)';this.style.color='#1d4ed8';">
                                🔍 Lihat Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:40px;color:#64748b;">
                            <i class="fas fa-users" style="font-size:32px; margin-bottom:12px; opacity:0.5; display:block;"></i>
                            Belum ada data lansia tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL DETAIL RENTANG USIA --}}
<div class="modal-overlay" id="modalOverlay" onclick="closeModalOutside(event)">
    <div class="modal-box">
        <div class="modal-header">
            <h3 id="modalTitle">Detail Rentang Usia</h3>
            <button class="modal-close" onclick="closeModal()">×</button>
        </div>
        <div class="modal-body">
            <p style="font-size:13px;color:#64748b;margin-bottom:16px;">
                Detail jumlah penduduk berdasarkan kelompok usia di desa/kecamatan ini.
            </p>
            <table class="usia-table">
                <thead>
                    <tr>
                        <th>Kelompok Usia</th>
                        <th style="text-align:right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody id="modalBody"></tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ── Grafik Batang per Desa ──
(function() {
    const data = @json($perDesa->map(fn($g) => $g->count()));
    const labels = @json($perDesa->keys());
    const colors = labels.map((_, i) => `hsl(${220 + i * 18}, 75%, ${45 + i % 3 * 8}%)`);

    new Chart(document.getElementById('chartDesa'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Lansia',
                data: Object.values(data),
                backgroundColor: colors,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.parsed.y} orang` } }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#c0c0c0' } },
                x: { grid: { display: false } }
            }
        }
    });
})();

// ── Modal Logic ──
function showModal(desa, usiaData) {
    document.getElementById('modalTitle').textContent = '📍 Detail Usia — ' + (desa || 'Tidak Diketahui');
    const tbody = document.getElementById('modalBody');
    tbody.innerHTML = '';
    let total = 0;
    Object.entries(usiaData).forEach(([label, count]) => {
        total += count;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${label}</td>
            <td style="text-align:right;"><span class="usia-count">${count}</span> <small style="color:#94a3b8;">orang</small></td>
        `;
        tbody.appendChild(tr);
    });
    const trTotal = document.createElement('tr');
    trTotal.style.background = '#eff6ff';
    trTotal.innerHTML = `
        <td style="font-weight:800;color:#0b2c6b;">Total</td>
        <td style="text-align:right;font-weight:800;color:#0b2c6b;font-size:17px;">${total} <small style="color:#64748b;font-size:12px;">orang</small></td>
    `;
    tbody.appendChild(trTotal);
    document.getElementById('modalOverlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('modalOverlay').classList.remove('active');
    document.body.style.overflow = '';
}

function closeModalOutside(e) {
    if (e.target === document.getElementById('modalOverlay')) closeModal();
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
</script>
@endsection
