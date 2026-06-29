@extends('layouts.admin')
@section('header_title', 'Monitoring & Evaluasi (Monev)')

@section('content')
    <div class="page-header"
        style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:16px;margin-bottom:24px;">
        <div>
            <h1 class="page-header__title">
                <i class="fas fa-clipboard-list" style="color:var(--brand-500);margin-right:10px;font-size:22px;"></i>
                Monitoring & Evaluasi
            </h1>
            <p class="page-header__desc">Rekapitulasi data evaluasi pemahaman (Pre-Test & Post-Test) dari kegiatan.</p>
        </div>
    </div>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="flash-message success" id="flashMsg">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button onclick="document.getElementById('flashMsg').remove()"
                style="margin-left:auto;background:none;border:none;cursor:pointer;color:inherit;opacity:.6;font-size:18px;">&times;</button>
        </div>
    @endif

    <style>
        @media (max-width: 768px) {
            .stats-grid {
                display: grid !important;
                grid-template-columns: 1fr 1fr !important;
            }

            .stats-grid .stat-card:nth-child(3) {
                grid-column: 1 / span 2 !important;
            }
        }
    </style>
    <div class="stats-grid" style="margin-bottom:16px;">
        @php
            $totalData = $monevs->count();
            $totalPre = $monevs->whereNotNull('waktu_isi_pre')->count();
            $totalPost = $monevs->whereNotNull('waktu_isi_post')->count();
        @endphp

        <div class="stat-card brand">
            <div class="stat-card__top">
                <span class="stat-card__label">Total Partisipan</span>
                <div class="stat-card__icon brand"><i class="fas fa-users"></i></div>
            </div>
            <div class="stat-card__value">{{ $totalData }}</div>
            <div style="font-size:12px;color:var(--text-tertiary);margin-top:6px;">Orang terdaftar</div>
        </div>

        <div class="stat-card warning">
            <div class="stat-card__top">
                <span class="stat-card__label">Mengisi Pre-Test</span>
                <div class="stat-card__icon warning"><i class="fas fa-file-signature"></i></div>
            </div>
            <div class="stat-card__value">{{ $totalPre }}</div>
            <div style="font-size:12px;color:var(--text-tertiary);margin-top:6px;">Sebelum kegiatan</div>
        </div>

        <div class="stat-card success">
            <div class="stat-card__top">
                <span class="stat-card__label">Mengisi Post-Test</span>
                <div class="stat-card__icon success"><i class="fas fa-check-double"></i></div>
            </div>
            <div class="stat-card__value">{{ $totalPost }}</div>
            <div style="font-size:12px;color:var(--text-tertiary);margin-top:6px;">Sesudah kegiatan</div>
        </div>
    </div>

    <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;margin-bottom:24px;">
        <a href="{{ route('admin.monitoring.kegiatan.index') }}" class="btn btn-primary"
            style="background:#2563eb;color:#fff;border:none;font-weight:600;padding:10px 18px;box-shadow:0 4px 6px rgba(37,99,235,0.2);">
            <i class="fas fa-calendar-check" style="margin-right:6px;"></i> Master Kegiatan
        </a>
    </div>

    <div class="card">
        <div class="card__header" style="flex-wrap:wrap;gap:12px;">
            <h3 class="card__title">
                <i class="fas fa-table-list"></i> Data Monev
                <span class="badge badge--brand" style="margin-left:8px;font-size:11px;"
                    id="countBadge">{{ $totalData }}</span>
            </h3>
            <div style="position:relative;">
                <i class="fas fa-search"
                    style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-placeholder);font-size:12px;pointer-events:none;"></i>
                <input type="text" id="quickSearch" oninput="applyFilter()" placeholder="Cari nama/kegiatan..."
                    style="padding:7px 12px 7px 30px;border:1px solid var(--border-primary);border-radius:var(--radius-md);font-size:13px;font-family:inherit;background:var(--gray-50);color:var(--text-primary);width:220px;">
            </div>
        </div>

        @if ($monevs->isEmpty())
            <div class="empty-state">
                <div class="empty-state__icon"><i class="fas fa-database"></i></div>
                <div class="empty-state__title">Belum Ada Data Monev</div>
                <div class="empty-state__desc">Belum ada partisipan yang mengisi evaluasi.</div>
            </div>
        @else
            <style>
                #monevTable th,
                #monevTable td {
                    border: 1px solid #cbd5e1 !important;
                    vertical-align: middle;
                }
            </style>
            <div class="table-wrap" style="overflow-x:auto;">
                <table class="table" id="monevTable" style="min-width:1400px; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width:40px;">#</th>
                            <th rowspan="2"><i class="fas fa-user" style="margin-right:4px;"></i> Identitas User</th>
                            <th rowspan="2"><i class="fas fa-calendar" style="margin-right:4px;"></i> Kegiatan & Waktu
                            </th>
                            <th style="text-align:center;background:var(--brand-50);" colspan="{{ $maxSoal }}">
                                Perbandingan Jawaban S1 - S{{ $maxSoal }} (PRE | POST)</th>
                            <th rowspan="2" style="width:250px;">Deskripsi Pemahaman (Pre & Post)</th>
                            <th rowspan="2" style="width:90px;text-align:center;"><i class="fas fa-cogs"></i></th>
                        </tr>
                        <tr style="font-size:11.5px;background:var(--gray-50);">
                            @for ($i = 1; $i <= $maxSoal; $i++)
                                <th style="text-align:center;font-weight:600;">S{{ $i }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monevs as $i => $row)
                            <tr class="monev-row"
                                data-name="{{ strtolower($row->nama_user . ' ' . $row->nama_kegiatan) }}">
                                <td><span
                                        style="font-weight:700;color:var(--text-tertiary);">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td>
                                    <div style="font-weight:700;color:var(--text-primary);font-size:14px;">
                                        {{ $row->nama_user }}
                                    </div>
                                    <div style="font-size:12px;color:var(--text-secondary);">
                                        {{ $row->umur_user }} Th | {{ $row->no_hp }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight:600;color:var(--brand-700);font-size:13px;">
                                        {{ $row->nama_kegiatan }}
                                    </div>
                                    <div style="font-size:11px;color:var(--text-secondary);margin-top:4px;">
                                        <strong>Pre:</strong>
                                        {{ $row->waktu_isi_pre ? $row->waktu_isi_pre->format('d/m/Y H:i') : '-' }}<br>
                                        <strong>Post:</strong>
                                        {{ $row->waktu_isi_post ? $row->waktu_isi_post->format('d/m/Y H:i') : '-' }}
                                    </div>
                                </td>
                                @php
                                    $kMaster = \App\Models\MasterKegiatanMonev::where('nama_kegiatan', $row->nama_kegiatan)->first();
                                    $rowSoals = $kMaster ? \App\Models\MasterSoalMonev::where('id_kegiatan', $kMaster->id_kegiatan)->orderBy('urutan')->get() : collect();
                                @endphp
                                @for ($i = 0; $i < $maxSoal; $i++)
                                    @php
                                        $mSoal = $rowSoals->get($i);
                                        if ($mSoal) {
                                            $map = [
                                                'SP' => 'Sangat Paham',
                                                'P' => 'Paham',
                                                'CP' => 'Cukup Paham',
                                                'KP' => 'Kurang Paham',
                                                'SKP' => 'Sangat Kurang Paham',
                                            ];
                                            $ansPre = $row->jawabanSoal
                                                ->where('jenis_test', 'PRE')
                                                ->where('id_soal', $mSoal->id_soal)
                                                ->first();
                                            $ansPost = $row->jawabanSoal
                                                ->where('jenis_test', 'POST')
                                                ->where('id_soal', $mSoal->id_soal)
                                                ->first();
                                            $valPre = $ansPre ? $ansPre->pilihan_jawaban : '-';
                                            $valPost = $ansPost ? $ansPost->pilihan_jawaban : '-';

                                            $fullPre = isset($map[$valPre]) ? $map[$valPre] : $valPre;
                                            $fullPost = isset($map[$valPost]) ? $map[$valPost] : $valPost;

                                            $colorPre = in_array($valPre, ['SP', 'P'])
                                                ? 'color:var(--success-700);'
                                                : (in_array($valPre, ['KP', 'SKP'])
                                                    ? 'color:var(--danger-700);'
                                                    : 'color:var(--text-secondary);');
                                            $colorPost = in_array($valPost, ['SP', 'P'])
                                                ? 'color:var(--success-700);font-weight:700;'
                                                : (in_array($valPost, ['KP', 'SKP'])
                                                    ? 'color:var(--danger-700);font-weight:700;'
                                                    : 'color:var(--text-primary);font-weight:700;');
                                        } else {
                                            $fullPre = '-';
                                            $fullPost = '-';
                                            $colorPre = 'color:var(--text-secondary);';
                                            $colorPost = 'color:var(--text-secondary);';
                                        }
                                    @endphp
                                    <td style="text-align:center;font-size:12px;white-space:nowrap;">
                                        @if($mSoal)
                                            <span style="{{ $colorPre }}">{{ $fullPre }}</span>
                                            <div style="border-top:1px dashed var(--border-primary);margin:2px 0;"></div>
                                            <span style="{{ $colorPost }}">{{ $fullPost }}</span>
                                        @else
                                            <span style="color:var(--text-secondary);">-</span>
                                        @endif
                                    </td>
                                @endfor
                                <td style="font-size:12px;">
                                    <div style="margin-bottom:6px;">
                                        <span style="font-weight:600;color:var(--brand-600);">Pre:</span>
                                        <span
                                            style="color:var(--text-secondary);">{{ Str::limit($row->pre_pemahaman_deskripsi, 80) ?: '-' }}</span>
                                    </div>
                                    <div>
                                        <span style="font-weight:600;color:var(--success-700);">Post:</span>
                                        <span
                                            style="color:var(--text-secondary);">{{ Str::limit($row->post_pemahaman_deskripsi, 80) ?: '-' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px;justify-content:flex-end;">
                                        <a href="{{ route('admin.monitoring.show', $row->id_monev) }}"
                                            class="btn btn-outline btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <form action="{{ route('admin.monitoring.destroy', $row->id_monev) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus data partisipan {{ addslashes($row->nama_user) }}?')">
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

            <div id="noResults" style="display:none;text-align:center;padding:32px;color:var(--text-tertiary);">
                <i class="fas fa-search" style="font-size:32px;opacity:.4;margin-bottom:12px;"></i>
                <div style="font-weight:600;">Data tidak ditemukan</div>
            </div>

            <div
                style="display:flex;align-items:center;justify-content:space-between;padding:14px 4px 0;flex-wrap:wrap;gap:8px;">
                <span style="font-size:12.5px;color:var(--text-tertiary);" id="tableFooter">
                    Menampilkan <strong>{{ $totalData }}</strong> data
                </span>
                <span style="font-size:11px;color:var(--text-tertiary);">
                    <strong>Keterangan:</strong> Atas (Pre-Test) | Bawah (Post-Test). SS: Sangat Setuju, S: Setuju, N:
                    Netral, TS: Tidak Setuju, STS: Sangat Tidak Setuju.
                </span>
            </div>
        @endif
    </div>

@endsection

@section('scripts')
    <script>
        function applyFilter() {
            const q = (document.getElementById('quickSearch')?.value || '').toLowerCase();
            const rows = document.querySelectorAll('.monev-row');
            let visible = 0;

            rows.forEach(row => {
                const name = row.dataset.name || '';
                const show = !q || name.includes(q) || row.innerText.toLowerCase().includes(q);
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            const noResults = document.getElementById('noResults');
            const badge = document.getElementById('countBadge');
            const footer = document.getElementById('tableFooter');
            if (noResults) noResults.style.display = visible === 0 ? 'block' : 'none';
            if (badge) badge.textContent = visible;
            if (footer) footer.innerHTML = 'Menampilkan <strong>' + visible + '</strong> data';
        }

        setTimeout(() => {
            const el = document.getElementById('flashMsg');
            if (el) {
                el.style.opacity = '0';
                el.style.transition = 'opacity .4s';
                setTimeout(() => el.remove(), 400);
            }
        }, 4000);
    </script>
@endsection
