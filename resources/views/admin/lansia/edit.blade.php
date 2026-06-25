@extends('layouts.admin')
@section('header_title', 'Edit Data Desa')

@section('content')
<style>
/* ═══════════════════════════════════════════════════
   Form Pendataan Lansia — Edit
   Section warna berbeda · Tabel input kompak · Responsif
═══════════════════════════════════════════════════ */

.pl-form-wrap   { max-width: 960px; }

/* ── Section ── */
.pl-section {
    border-radius: var(--radius-xl);
    overflow: hidden;
    margin-bottom: 20px;
    box-shadow: var(--shadow-sm);
}
.pl-section__head {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 20px;
    font-size: 12.5px;
    font-weight: 800;
    letter-spacing: .6px;
    text-transform: uppercase;
}
.pl-section__body { padding: 20px 24px; }

/* Section warna berbeda */
.pl-section.blue   { border: 1.5px solid #bdd4ff; }
.pl-section.blue   .pl-section__head { background: linear-gradient(90deg,#1d4ed8,#3b6cf9); color:#fff; }
.pl-section.blue   .pl-section__body { background: #f0f5ff; }

.pl-section.slate  { border: 1.5px solid #cbd5e1; }
.pl-section.slate  .pl-section__head { background: linear-gradient(90deg,#334155,#475467); color:#fff; }
.pl-section.slate  .pl-section__body { background: #f8fafc; }

.pl-section.violet { border: 1.5px solid #ddd6fe; }
.pl-section.violet .pl-section__head { background: linear-gradient(90deg,#5b21b6,#7c3aed); color:#fff; }
.pl-section.violet .pl-section__body { background: #f5f3ff; }

/* ── Jumlah Penduduk 2-col ── */
.pl-penduduk {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
@media (max-width:500px) { .pl-penduduk { grid-template-columns: 1fr; } }

/* ── Tabel Rekap Usia ── */
.pl-usia-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13.5px;
}
.pl-usia-table thead tr {
    background: linear-gradient(90deg,#0b2c6b,#1d4ed8);
}
.pl-usia-table thead th {
    padding: 11px 14px;
    color: #fff;
    font-weight: 700;
    font-size: 12px;
    letter-spacing: .4px;
    text-align: left;
}
.pl-usia-table thead th.center { text-align: center; }
.pl-usia-table tbody tr {
    border-bottom: 1px solid #e2e8f0;
    transition: background .12s;
}
.pl-usia-table tbody tr:last-child { border-bottom: none; }
.pl-usia-table tbody tr:hover { background: rgba(29,78,216,.05); }
.pl-usia-table tbody tr:nth-child(even) { background: rgba(241,245,249,.7); }
.pl-usia-table tbody tr:nth-child(even):hover { background: rgba(29,78,216,.05); }

.pl-usia-table td {
    padding: 10px 14px;
    vertical-align: middle;
}
.pl-usia-table td.label {
    font-weight: 700;
    color: var(--text-primary);
    white-space: nowrap;
    width: 36%;
}
.pl-usia-table td.label span {
    display: inline-flex;
    align-items: center;
    gap: 7px;
}
.pl-usia-table td.label .kelompok-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 999px;
    white-space: nowrap;
}
.pl-usia-table td.input-cell { width: 32%; }
.pl-usia-table td.input-cell .input-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
}
.pl-usia-table td.input-cell .gender-icon {
    font-size: 13px;
    width: 22px;
    flex-shrink: 0;
    text-align: center;
}
.pl-usia-table td.input-cell input[type="number"] {
    flex: 1;
    padding: 7px 10px;
    border: 1.5px solid var(--border-primary);
    border-radius: var(--radius-md);
    font-size: 13.5px;
    font-family: inherit;
    font-weight: 600;
    color: var(--text-primary);
    background: #fff;
    transition: border-color .15s, box-shadow .15s;
    text-align: center;
    min-width: 0;
}
.pl-usia-table td.input-cell input[type="number"]:focus {
    outline: none;
}
.pl-usia-table td.input-cell input.is-l:focus { border-color: #3b6cf9; box-shadow: 0 0 0 3px rgba(59,108,249,.12); }
.pl-usia-table td.input-cell input.is-p:focus { border-color: #be185d; box-shadow: 0 0 0 3px rgba(190,24,93,.12); }

/* Responsif */
@media (max-width: 640px) {
    .pl-usia-table thead th:last-child { display: none; }
    .pl-usia-table td.input-cell:last-child { display: none; }
    .pl-usia-table td.label { width: 50%; }
    .pl-usia-table td.input-cell { width: 50%; }
    .pl-section__body { padding: 14px 12px; }
    .pl-form-wrap { max-width: 100%; }
}

.pl-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    flex-wrap: wrap;
    padding-top: 4px;
}
</style>

{{-- Breadcrumb --}}
<div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;font-size:13px;color:var(--text-tertiary);">
    <a href="{{ route('admin.lansia.index') }}" style="color:var(--brand-500);font-weight:600;text-decoration:none;">
        <i class="fas fa-users"></i> Pendataan Lansia
    </a>
    <i class="fas fa-chevron-right" style="font-size:10px;"></i>
    <span>Edit — {{ $lansia->desa }}</span>
</div>

<div class="pl-form-wrap">

    {{-- Card Header --}}
    <div class="card" style="padding:0;overflow:hidden;margin-bottom:20px;">
        <div style="background:linear-gradient(135deg,#1e40af,#3b6cf9);padding:22px 28px;color:#fff;">
            <h2 style="font-size:18px;font-weight:800;margin:0 0 4px;display:flex;align-items:center;gap:10px;">
                <i class="fas fa-pen-to-square"></i> Edit — {{ $lansia->desa }}
            </h2>
            <p style="margin:0;font-size:13px;opacity:.85;">Perbarui rekap jumlah penduduk per kelompok usia untuk desa ini.</p>
        </div>
    </div>

    <form action="{{ route('admin.lansia.update', $lansia) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Error summary --}}
        @if($errors->any())
        <div class="flash-message danger" style="margin-bottom:16px;">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <strong>Terdapat {{ $errors->count() }} kesalahan — periksa isian form.</strong>
                <ul style="margin:6px 0 0 18px;font-size:12.5px;line-height:1.8;">
                    @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- ── SECTION 1: Identitas Wilayah ─────────────────────── --}}
        <div class="pl-section blue">
            <div class="pl-section__head">
                <i class="fas fa-map-location-dot"></i> Identitas Wilayah
            </div>
            <div class="pl-section__body">
                <div class="form-group" style="max-width:420px;margin-bottom:0;">
                    <label class="form-label" for="desa">
                        Nama Desa <span style="color:var(--danger-500)">*</span>
                    </label>
                    <input type="text" id="desa" name="desa"
                        class="form-control @error('desa') is-error @enderror"
                        value="{{ old('desa', $lansia->desa) }}"
                        placeholder="Contoh: Desa Suka Makmur" required>
                    @error('desa')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- ── SECTION 2: Jumlah Penduduk ───────────────────────── --}}
        <div class="pl-section slate">
            <div class="pl-section__head">
                <i class="fas fa-people-group"></i> Jumlah Penduduk
            </div>
            <div class="pl-section__body">
                <div class="pl-penduduk">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">
                            <i class="fas fa-mars" style="color:var(--brand-500);"></i> Laki-laki (L)
                        </label>
                        <input type="number" name="jumlah_penduduk_l"
                            class="form-control @error('jumlah_penduduk_l') is-error @enderror"
                            value="{{ old('jumlah_penduduk_l', $lansia->jumlah_penduduk_l) }}" min="0" required>
                        @error('jumlah_penduduk_l')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">
                            <i class="fas fa-venus" style="color:#be185d;"></i> Perempuan (P)
                        </label>
                        <input type="number" name="jumlah_penduduk_p"
                            class="form-control @error('jumlah_penduduk_p') is-error @enderror"
                            value="{{ old('jumlah_penduduk_p', $lansia->jumlah_penduduk_p) }}" min="0" required>
                        @error('jumlah_penduduk_p')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ── SECTION 3: Rekap Per Kelompok Usia ───────────────── --}}
        @php
            $kelompok = [
                ['key'=>'bayi_baru_lahir',  'label'=>'Bayi Baru Lahir',  'icon'=>'fa-baby',          'badge_bg'=>'#ede9fe','badge_color'=>'#5b21b6'],
                ['key'=>'usia_0_11_bulan',  'label'=>'Usia 0–11 Bulan',  'icon'=>'fa-baby-carriage',  'badge_bg'=>'#dbeafe','badge_color'=>'#1d4ed8'],
                ['key'=>'usia_12_59_bulan', 'label'=>'Usia 12–59 Bulan', 'icon'=>'fa-child',          'badge_bg'=>'#cffafe','badge_color'=>'#0e7490'],
                ['key'=>'usia_60_72_bulan', 'label'=>'Usia 60–72 Bulan', 'icon'=>'fa-child-reaching', 'badge_bg'=>'#dcfce7','badge_color'=>'#15803d'],
                ['key'=>'usia_7_9_tahun',   'label'=>'Usia 7–9 Tahun',   'icon'=>'fa-person',         'badge_bg'=>'#d1fae5','badge_color'=>'#065f46'],
                ['key'=>'usia_10_12_tahun', 'label'=>'Usia 10–12 Tahun', 'icon'=>'fa-person',         'badge_bg'=>'#fef9c3','badge_color'=>'#854d0e'],
                ['key'=>'usia_13_14_tahun', 'label'=>'Usia 13–14 Tahun', 'icon'=>'fa-user',           'badge_bg'=>'#ffedd5','badge_color'=>'#9a3412'],
                ['key'=>'usia_15_59_tahun', 'label'=>'Usia 15–59 Tahun', 'icon'=>'fa-user-tie',        'badge_bg'=>'#fee2e2','badge_color'=>'#b91c1c'],
                ['key'=>'usia_60_69_tahun', 'label'=>'Usia 60–69 Tahun', 'icon'=>'fa-user-clock',      'badge_bg'=>'#fce7f3','badge_color'=>'#9d174d'],
                ['key'=>'usia_70_plus',     'label'=>'Usia &gt;70 Tahun', 'icon'=>'fa-person-cane',    'badge_bg'=>'#f3e8ff','badge_color'=>'#6b21a8'],
            ];
        @endphp

        <div class="pl-section violet">
            <div class="pl-section__head">
                <i class="fas fa-chart-bar"></i> Rekap Per Kelompok Usia
                <span style="font-size:11px;font-weight:500;opacity:.85;margin-left:4px;">(isi 0 jika tidak ada)</span>
            </div>
            <div class="pl-section__body" style="padding:0;">
                <div style="overflow-x:auto;">
                    <table class="pl-usia-table">
                        <thead>
                            <tr>
                                <th>Kelompok Usia</th>
                                <th class="center"><i class="fas fa-mars" style="margin-right:5px;"></i>Laki-laki (L)</th>
                                <th class="center"><i class="fas fa-venus" style="margin-right:5px;"></i>Perempuan (P)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelompok as $k)
                            <tr>
                                <td class="label">
                                    <span>
                                        <i class="fas {{ $k['icon'] }}" style="color:{{ $k['badge_color'] }};width:16px;text-align:center;"></i>
                                        <span class="kelompok-badge" style="background:{{ $k['badge_bg'] }};color:{{ $k['badge_color'] }};">
                                            {!! $k['label'] !!}
                                        </span>
                                    </span>
                                </td>
                                <td class="input-cell">
                                    <div class="input-wrap">
                                        <span class="gender-icon" style="color:var(--brand-600);">♂</span>
                                        <input type="number" name="{{ $k['key'] }}_l"
                                            class="is-l @error($k['key'].'_l') is-error @enderror"
                                            value="{{ old($k['key'].'_l', $lansia->{$k['key'].'_l'}) }}"
                                            min="0" required
                                            title="{{ $k['label'] }} - Laki-laki">
                                    </div>
                                    @error($k['key'].'_l')<div class="form-error" style="font-size:11px;margin-top:3px;">{{ $message }}</div>@enderror
                                </td>
                                <td class="input-cell">
                                    <div class="input-wrap">
                                        <span class="gender-icon" style="color:#be185d;">♀</span>
                                        <input type="number" name="{{ $k['key'] }}_p"
                                            class="is-p @error($k['key'].'_p') is-error @enderror"
                                            value="{{ old($k['key'].'_p', $lansia->{$k['key'].'_p'}) }}"
                                            min="0" required
                                            title="{{ $k['label'] }} - Perempuan">
                                    </div>
                                    @error($k['key'].'_p')<div class="form-error" style="font-size:11px;margin-top:3px;">{{ $message }}</div>@enderror
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ── SECTION 4: Data Titik Peta (Lansia Prioritas) ── --}}
        <div class="pl-section slate">
            <div class="pl-section__head" style="justify-content: space-between;">
                <div><i class="fas fa-map-location-dot"></i> Data Titik Peta (Lansia Prioritas)</div>
                <button type="button" class="btn btn-sm" onclick="addPrioritas()" style="background:#3b6cf9;color:#fff;border:none;padding:4px 10px;border-radius:4px;font-size:11px;font-weight:bold;cursor:pointer;">
                    <i class="fas fa-plus"></i> Tambah Lansia
                </button>
            </div>
            <div class="pl-section__body" style="padding:16px;">
                <p style="font-size:12px; color:var(--text-tertiary); margin-top:0; margin-bottom:12px;">
                    Tambahkan titik koordinat spesifik untuk lansia yang memiliki riwayat penyakit menonjol di desa ini.
                </p>
                <div id="prioritas-container">
                    @foreach($lansia->lansiaPrioritas as $index => $p)
                        <div class="prioritas-row" style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:12px; margin-bottom:10px; position:relative;">
                            <button type="button" onclick="this.closest('.prioritas-row').remove()" style="position:absolute; top:12px; right:12px; background:#ef4444; color:#fff; border:none; border-radius:4px; width:24px; height:24px; cursor:pointer;" title="Hapus">
                                <i class="fas fa-times"></i>
                            </button>
                            <input type="hidden" name="prioritas[{{ $index }}][id]" value="{{ $p->id }}">
                            
                            <div style="display:grid; grid-template-columns:1fr 80px; gap:10px; margin-bottom:10px;">
                                <div>
                                    <label style="font-size:11px; font-weight:600; color:var(--text-secondary); display:block; margin-bottom:4px;">Nama Lansia</label>
                                    <input type="text" name="prioritas[{{ $index }}][nama_lansia]" class="form-control" style="padding:6px 10px; font-size:13px;" value="{{ $p->nama_lansia }}" required>
                                </div>
                                <div>
                                    <label style="font-size:11px; font-weight:600; color:var(--text-secondary); display:block; margin-bottom:4px;">Usia</label>
                                    <input type="number" name="prioritas[{{ $index }}][umur]" class="form-control" style="padding:6px 10px; font-size:13px;" value="{{ $p->umur }}" required>
                                </div>
                            </div>

                            <div style="margin-bottom:10px;">
                                <label style="font-size:11px; font-weight:600; color:var(--text-secondary); display:block; margin-bottom:4px;">Riwayat Penyakit Dominan</label>
                                <input type="text" name="prioritas[{{ $index }}][riwayat_penyakit]" class="form-control" style="padding:6px 10px; font-size:13px;" value="{{ $p->riwayat_penyakit }}">
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                                <div>
                                    <label style="font-size:11px; font-weight:600; color:var(--text-secondary); display:block; margin-bottom:4px;">Latitude</label>
                                    <input type="text" name="prioritas[{{ $index }}][latitude]" class="form-control" style="padding:6px 10px; font-size:13px;" value="{{ $p->latitude }}">
                                </div>
                                <div>
                                    <label style="font-size:11px; font-weight:600; color:var(--text-secondary); display:block; margin-bottom:4px;">Longitude</label>
                                    <input type="text" name="prioritas[{{ $index }}][longitude]" class="form-control" style="padding:6px 10px; font-size:13px;" value="{{ $p->longitude }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <script>
            let pIndex = {{ $lansia->lansiaPrioritas->count() }};
            function addPrioritas() {
                const html = `
                    <div class="prioritas-row" style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:12px; margin-bottom:10px; position:relative;">
                        <button type="button" onclick="this.closest('.prioritas-row').remove()" style="position:absolute; top:12px; right:12px; background:#ef4444; color:#fff; border:none; border-radius:4px; width:24px; height:24px; cursor:pointer;" title="Hapus">
                            <i class="fas fa-times"></i>
                        </button>
                        
                        <div style="display:grid; grid-template-columns:1fr 80px; gap:10px; margin-bottom:10px;">
                            <div>
                                <label style="font-size:11px; font-weight:600; color:var(--text-secondary); display:block; margin-bottom:4px;">Nama Lansia</label>
                                <input type="text" name="prioritas[${pIndex}][nama_lansia]" class="form-control" style="padding:6px 10px; font-size:13px;" placeholder="Cth: Nenek Fatimah" required>
                            </div>
                            <div>
                                <label style="font-size:11px; font-weight:600; color:var(--text-secondary); display:block; margin-bottom:4px;">Usia</label>
                                <input type="number" name="prioritas[${pIndex}][umur]" class="form-control" style="padding:6px 10px; font-size:13px;" placeholder="Cth: 75" required>
                            </div>
                        </div>

                        <div style="margin-bottom:10px;">
                            <label style="font-size:11px; font-weight:600; color:var(--text-secondary); display:block; margin-bottom:4px;">Riwayat Penyakit Dominan</label>
                            <input type="text" name="prioritas[${pIndex}][riwayat_penyakit]" class="form-control" style="padding:6px 10px; font-size:13px;" placeholder="Cth: Hipertensi, Asam Urat">
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                            <div>
                                <label style="font-size:11px; font-weight:600; color:var(--text-secondary); display:block; margin-bottom:4px;">Latitude</label>
                                <input type="text" name="prioritas[${pIndex}][latitude]" class="form-control" style="padding:6px 10px; font-size:13px;" placeholder="Cth: 5.12345">
                            </div>
                            <div>
                                <label style="font-size:11px; font-weight:600; color:var(--text-secondary); display:block; margin-bottom:4px;">Longitude</label>
                                <input type="text" name="prioritas[${pIndex}][longitude]" class="form-control" style="padding:6px 10px; font-size:13px;" placeholder="Cth: 96.12345">
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('prioritas-container').insertAdjacentHTML('beforeend', html);
                pIndex++;
            }
        </script>

        {{-- ── Tombol Aksi ───────────────────────────────────────── --}}
        <div class="pl-actions">
            <a href="{{ route('admin.lansia.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Perbarui Data
            </button>
        </div>

    </form>
</div>

@endsection
