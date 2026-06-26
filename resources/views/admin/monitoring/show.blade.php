@extends('layouts.admin')
@section('header_title', 'Detail Data Monev')

@section('content')
    <style>
        .pl-form-wrap {
            max-width: 960px;
        }

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

        .pl-section__body {
            padding: 20px 24px;
        }

        .pl-section.blue {
            border: 1.5px solid #bdd4ff;
        }

        .pl-section.blue .pl-section__head {
            background: linear-gradient(90deg, #1d4ed8, #3b6cf9);
            color: #fff;
        }

        .pl-section.blue .pl-section__body {
            background: #f0f5ff;
        }

        .pl-section.slate {
            border: 1.5px solid #cbd5e1;
        }

        .pl-section.slate .pl-section__head {
            background: linear-gradient(90deg, #334155, #475467);
            color: #fff;
        }

        .pl-section.slate .pl-section__body {
            background: #f8fafc;
        }

        .pl-section.violet {
            border: 1.5px solid #ddd6fe;
        }

        .pl-section.violet .pl-section__head {
            background: linear-gradient(90deg, #5b21b6, #7c3aed);
            color: #fff;
        }

        .pl-section.violet .pl-section__body {
            background: #f5f3ff;
        }

        .pl-section.success {
            border: 1.5px solid #bbf7d0;
        }

        .pl-section.success .pl-section__head {
            background: linear-gradient(90deg, #15803d, #22c55e);
            color: #fff;
        }

        .pl-section.success .pl-section__body {
            background: #f0fdf4;
        }

        .form-control {
            border: 2px solid #94a3b8 !important;
        }

        .form-control:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
        }

        .pl-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        @media (max-width:600px) {
            .pl-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        .pl-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            flex-wrap: wrap;
            padding-top: 4px;
        }
    </style>

    <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;font-size:13px;color:var(--text-tertiary);">
        <a href="{{ route('admin.monitoring.index') }}" style="color:var(--brand-500);font-weight:600;text-decoration:none;">
            <i class="fas fa-clipboard-list"></i> Monitoring & Evaluasi
        </a>
        <i class="fas fa-chevron-right" style="font-size:10px;"></i>
        <span>Detail Data</span>
    </div>

    <div class="pl-form-wrap">
        <div class="card" style="padding:0;overflow:hidden;margin-bottom:20px;">
            <div style="background:linear-gradient(135deg,#0b2c6b,#1d4ed8);padding:22px 28px;color:#fff;">
                <h2 style="font-size:18px;font-weight:800;margin:0 0 4px;display:flex;align-items:center;gap:10px;">
                    <i class="fas fa-eye"></i> Detail Data Monev
                </h2>
                <p style="margin:0;font-size:13px;opacity:.85;">Melihat data partisipan dan hasil evaluasi pemahaman (Pre &
                    Post).</p>
            </div>
        </div>

        {{-- SECTION 1: Identitas User --}}
        <div class="pl-section blue">
            <div class="pl-section__head"><i class="fas fa-user"></i> Identitas User</div>
            <div class="pl-section__body">
                <div class="pl-grid-2">
                    <div class="form-group mb-0">
                        <label class="form-label">Nama Lengkap Partisipan <span style="color:red">*</span></label>
                        <input type="text" class="form-control" value="{{ $monev->nama_user }}" readonly
                            style="background:#f8fafc; cursor:not-allowed;">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Tanggal Lahir <span style="color:red">*</span></label>
                        <input type="date" class="form-control"
                            value="{{ $monev->tanggal_lahir ? $monev->tanggal_lahir->format('Y-m-d') : '' }}" readonly
                            style="background:#f8fafc; cursor:not-allowed;">
                    </div>
                </div>
                <div class="pl-grid-2" style="margin-bottom:0;">
                    <div class="form-group mb-0">
                        <label class="form-label">No. HP / WhatsApp <span style="color:red">*</span></label>
                        <input type="text" class="form-control" value="{{ $monev->no_hp }}" readonly
                            style="background:#f8fafc; cursor:not-allowed;">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Alamat Lengkap <span style="color:red">*</span></label>
                        <textarea class="form-control" rows="2" readonly style="background:#f8fafc; cursor:not-allowed;">{{ $monev->alamat_user }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: Kegiatan --}}
        <div class="pl-section slate">
            <div class="pl-section__head"><i class="fas fa-calendar-alt"></i> Informasi Kegiatan</div>
            <div class="pl-section__body">
                <div class="form-group mb-0">
                    <label class="form-label">Nama Kegiatan <span style="color:red">*</span></label>
                    <input type="text" class="form-control"
                        value="{{ $monev->kegiatanMaster ? $monev->kegiatanMaster->nama_kegiatan : $monev->nama_kegiatan }}"
                        readonly style="background:#f8fafc; cursor:not-allowed;">
                </div>
            </div>
        </div>

        @php
            $skala = ['SP', 'P', 'CP', 'KP', 'SKP'];
        @endphp

        {{-- SECTION 3: PRE-TEST --}}
        <div class="pl-section violet">
            <div class="pl-section__head"><i class="fas fa-file-signature"></i> Evaluasi Pre-Test</div>
            <div class="pl-section__body">
                <div style="margin-bottom: 20px;">
                    @foreach ($masterSoals->whereIn('jenis_test', ['PRE', 'BOTH'])->values() as $sIndex => $mSoal)
                        @php
                            $ans = $monev->jawabanSoal
                                ->where('jenis_test', 'PRE')
                                ->where('id_soal', $mSoal->id_soal)
                                ->first();
                            $val = $ans ? $ans->pilihan_jawaban : null;
                        @endphp
                        <div
                            style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                            <label
                                style="font-size:13.5px;font-weight:700;color:#1e293b;display:block;margin-bottom:12px;">S{{ $sIndex + 1 }}.
                                {{ $mSoal->pertanyaan }}</label>
                            <div style="display:flex;gap:12px;flex-wrap:wrap;">
                                @foreach ($skala as $s)
                                    <label
                                        style="font-size:13px;display:flex;align-items:center;justify-content:center;min-width:45px;padding:6px 12px;background:{{ $val == $s ? '#eff6ff' : '#f8fafc' }};border:1px solid {{ $val == $s ? '#bfdbfe' : '#cbd5e1' }};color:{{ $val == $s ? '#1d4ed8' : '#334155' }};border-radius:6px;cursor:not-allowed;transition:all 0.2s;font-weight:{{ $val == $s ? '700' : '400' }}; opacity: 0.8;">
                                        <input type="radio" disabled name="jawaban_pre[{{ $mSoal->id_soal }}]"
                                            value="{{ $s }}" {{ $val == $s ? 'checked' : '' }}
                                            style="margin-right:6px; cursor:not-allowed;"> {{ $s }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Deskripsi Pemahaman (Pre-Test)</label>
                    <textarea readonly class="form-control" rows="3" style="background:#f8fafc; cursor:not-allowed;">{{ $monev->pre_pemahaman_deskripsi }}</textarea>
                </div>
            </div>
        </div>

        {{-- SECTION 4: POST-TEST --}}
        <div class="pl-section success">
            <div class="pl-section__head"><i class="fas fa-check-double"></i> Evaluasi Post-Test</div>
            <div class="pl-section__body">
                <div style="margin-bottom: 20px;">
                    @foreach ($masterSoals->whereIn('jenis_test', ['POST', 'BOTH'])->values() as $sIndex => $mSoal)
                        @php
                            $ans = $monev->jawabanSoal
                                ->where('jenis_test', 'POST')
                                ->where('id_soal', $mSoal->id_soal)
                                ->first();
                            $val = $ans ? $ans->pilihan_jawaban : null;
                        @endphp
                        <div
                            style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                            <label
                                style="font-size:13.5px;font-weight:700;color:#1e293b;display:block;margin-bottom:12px;">S{{ $sIndex + 1 }}.
                                {{ $mSoal->pertanyaan }}</label>
                            <div style="display:flex;gap:12px;flex-wrap:wrap;">
                                @foreach ($skala as $s)
                                    <label
                                        style="font-size:13px;display:flex;align-items:center;justify-content:center;min-width:45px;padding:6px 12px;background:{{ $val == $s ? '#eff6ff' : '#f8fafc' }};border:1px solid {{ $val == $s ? '#bfdbfe' : '#cbd5e1' }};color:{{ $val == $s ? '#1d4ed8' : '#334155' }};border-radius:6px;cursor:not-allowed;transition:all 0.2s;font-weight:{{ $val == $s ? '700' : '400' }}; opacity: 0.8;">
                                        <input type="radio" disabled name="jawaban_post[{{ $mSoal->id_soal }}]"
                                            value="{{ $s }}" {{ $val == $s ? 'checked' : '' }}
                                            style="margin-right:6px; cursor:not-allowed;"> {{ $s }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Deskripsi Pemahaman (Post-Test)</label>
                    <textarea readonly class="form-control" rows="3" style="background:#f8fafc; cursor:not-allowed;">{{ $monev->post_pemahaman_deskripsi }}</textarea>
                </div>
            </div>
        </div>

        <div class="pl-actions">
            <a href="{{ route('admin.monitoring.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i>
                Kembali</a>
        </div>
    </div>
    </div>
@endsection
