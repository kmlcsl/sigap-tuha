@extends('layouts.admin')
@section('header_title', 'Edit Berita')
@section('content')
<div class="page-header"><h1 class="page-header__title">Edit Berita</h1><p class="page-header__desc">Perbarui informasi berita.</p></div>
<div class="card" style="max-width:800px;">
    <div class="card__header"><h3 class="card__title"><i class="fas fa-pen"></i> Form Edit Berita</h3></div>
    <form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-group">
            <label><i class="fas fa-heading" style="margin-right:4px; color:var(--text-tertiary)"></i> Judul Berita <span class="required">*</span></label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $berita->judul) }}" required placeholder="Masukkan judul berita...">
            @error('judul') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-image" style="margin-right:4px; color:var(--text-tertiary)"></i> Gambar Sampul</label>
            @if($berita->gambar)
                <div style="margin-bottom:12px;">
                    <img src="{{ asset($berita->gambar) }}" alt="{{ $berita->judul }}" style="max-width:200px; border-radius:var(--radius-sm); border:1px solid var(--border-secondary);">
                </div>
            @endif
            <input type="file" name="gambar" class="form-control" accept="image/*">
            <small style="color:var(--text-secondary); margin-top:6px; display:block;">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            @error('gambar') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-align-left" style="margin-right:4px; color:var(--text-tertiary)"></i> Konten Berita <span class="required">*</span></label>
            <textarea name="konten" class="form-control" rows="8" required placeholder="Tuliskan isi berita di sini...">{{ old('konten', $berita->konten) }}</textarea>
            @error('konten') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-eye" style="margin-right:4px; color:var(--text-tertiary)"></i> Status</label>
            <select name="status" class="form-control">
                <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>Published (Publikasikan)</option>
                <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft (Simpan Sementara)</option>
            </select>
            @error('status') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui Berita</button>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
