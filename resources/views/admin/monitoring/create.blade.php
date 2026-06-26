@extends('layouts.admin')
@section('header_title', 'Tambah Data Monev')

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
        <span>Tambah Data</span>
    </div>

    <div class="pl-form-wrap">
        <div class="card" style="padding:0;overflow:hidden;margin-bottom:20px;">
            <div style="background:linear-gradient(135deg,#0b2c6b,#1d4ed8);padding:22px 28px;color:#fff;">
                <h2 style="font-size:18px;font-weight:800;margin:0 0 4px;display:flex;align-items:center;gap:10px;">
                    <i class="fas fa-plus-circle"></i> Tambah Data Monev
                </h2>
                <p style="margin:0;font-size:13px;opacity:.85;">Input data partisipan dan hasil evaluasi pemahaman (Pre &
                    Post) secara manual.</p>
            </div>
        </div>

        <form action="{{ route('admin.monitoring.store') }}" method="POST">
            @csrf
            @if ($errors->any())
                <div class="flash-message danger" style="margin-bottom:16px;">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Terdapat {{ $errors->count() }} kesalahan — periksa isian form.</strong>
                        <ul style="margin:6px 0 0 18px;font-size:12.5px;line-height:1.8;">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- SECTION 1: Identitas User --}}
            <div class="pl-section blue">
                <div class="pl-section__head"><i class="fas fa-user"></i> Identitas User</div>
                <div class="pl-section__body">
                    <div class="pl-grid-2">
                        <div class="form-group mb-0">
                            <label class="form-label">Nama Lengkap <span style="color:var(--danger-500)">*</span></label>
                            <input type="text" name="nama_user" class="form-control" value="{{ old('nama_user') }}"
                                required>
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label">Tanggal Lahir <span style="color:var(--danger-500)">*</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                value="{{ old('tanggal_lahir') }}" required>
                        </div>
                    </div>
                    <div class="pl-grid-2" style="margin-bottom:0;">
                        <div class="form-group mb-0">
                            <label class="form-label">Nomor HP <span style="color:var(--danger-500)">*</span></label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label">Alamat Lengkap <span style="color:var(--danger-500)">*</span></label>
                            <textarea name="alamat_user" class="form-control" rows="2" required>{{ old('alamat_user') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: Kegiatan --}}
            <div class="pl-section slate">
                <div class="pl-section__head"><i class="fas fa-calendar-alt"></i> Informasi Kegiatan</div>
                <div class="pl-section__body">
                    <div class="form-group mb-0">
                        <label class="form-label">Nama Kegiatan <span style="color:var(--danger-500)">*</span></label>
                        <input type="text" name="nama_kegiatan" class="form-control" value="{{ old('nama_kegiatan') }}"
                            required>
                    </div>
                </div>
            </div>

            {{-- Jawaban Evaluasi dihilangkan karena diisi oleh User --}}

            <div class="pl-actions">
                <a href="{{ route('admin.monitoring.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i>
                    Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
            </div>
        </form>
    </div>
@endsection
