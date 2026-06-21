@extends('layouts.admin')
@section('header_title', 'Edit Kegiatan')
@section('content')
<div class="page-header">
    <h1 class="page-header__title">Edit Kegiatan</h1>
    <p class="page-header__desc">Edit kegiatan untuk Program <strong>{{ $program->nama }}</strong>.</p>
</div>
<div class="card" style="max-width:700px;">
    <div class="card__header"><h3 class="card__title"><i class="fas fa-pen"></i> Form Edit Kegiatan</h3></div>
    <form action="{{ route('admin.programs.kegiatans.update', [$program, $kegiatan]) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <div class="form-group">
            <label><i class="fas fa-tag" style="margin-right:4px; color:var(--text-tertiary)"></i> Judul Kegiatan <span class="required">*</span></label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $kegiatan->nama) }}" required>
            @error('nama') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-image" style="margin-right:4px; color:var(--text-tertiary)"></i> Foto/Gambar Kegiatan</label>
            
            @if($kegiatan->foto)
                <div style="margin-bottom: 12px;">
                    <img src="{{ asset('storage/' . $kegiatan->foto) }}" alt="Foto Lama" style="max-height: 120px; border-radius: var(--radius-md); border: 1px solid var(--border-secondary);">
                    <div style="font-size:12px; color:var(--text-tertiary); margin-top:4px;">Foto saat ini</div>
                </div>
            @endif

            <input type="file" name="foto" class="form-control" accept="image/*">
            <div class="form-hint"><i class="fas fa-info-circle"></i> Unggah foto baru untuk mengganti foto lama. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</div>
            @error('foto') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-align-left" style="margin-right:4px; color:var(--text-tertiary)"></i> Deskripsi Lengkap</label>
            <textarea name="deskripsi_lengkap" class="form-control" rows="6">{{ old('deskripsi_lengkap', $kegiatan->deskripsi_lengkap) }}</textarea>
            @error('deskripsi_lengkap') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Kegiatan</button>
            <a href="{{ route('admin.programs.show', $program) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
