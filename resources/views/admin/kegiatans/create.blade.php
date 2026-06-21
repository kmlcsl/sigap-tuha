@extends('layouts.admin')
@section('header_title', 'Tambah Kegiatan')
@section('content')
<div class="page-header">
    <h1 class="page-header__title">Tambah Kegiatan</h1>
    <p class="page-header__desc">Tambahkan kegiatan baru untuk Program <strong>{{ $program->nama }}</strong>.</p>
</div>
<div class="card" style="max-width:700px;">
    <div class="card__header"><h3 class="card__title"><i class="fas fa-tasks"></i> Form Kegiatan</h3></div>
    <form action="{{ route('admin.programs.kegiatans.store', $program) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group" style="background:var(--brand-50); padding:16px; border-radius:var(--radius-md); border:1px solid var(--brand-200); margin-bottom:24px;">
            <label style="color:var(--brand-700); margin-bottom:4px;"><i class="fas fa-info-circle" style="margin-right:4px;"></i> Info</label>
            <div style="font-size:13px; color:var(--brand-800);">Kegiatan ini akan otomatis ditambahkan ke dalam Program <strong>{{ $program->nama }}</strong>.</div>
        </div>

        <div class="form-group">
            <label><i class="fas fa-tag" style="margin-right:4px; color:var(--text-tertiary)"></i> Judul Kegiatan <span class="required">*</span></label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            @error('nama') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-image" style="margin-right:4px; color:var(--text-tertiary)"></i> Foto/Gambar Kegiatan</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <div class="form-hint"><i class="fas fa-info-circle"></i> Maksimal ukuran file 2MB (JPG, PNG, WEBP).</div>
            @error('foto') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-align-left" style="margin-right:4px; color:var(--text-tertiary)"></i> Deskripsi Lengkap</label>
            <textarea name="deskripsi_lengkap" class="form-control" rows="6">{{ old('deskripsi_lengkap') }}</textarea>
            @error('deskripsi_lengkap') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Kegiatan</button>
            <a href="{{ route('admin.programs.show', $program) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
