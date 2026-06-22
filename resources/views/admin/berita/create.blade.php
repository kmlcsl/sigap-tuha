@extends('layouts.admin')
@section('header_title', 'Tulis Berita')
@section('content')
<div class="page-header"><h1 class="page-header__title">Tulis Berita Baru</h1><p class="page-header__desc">Buat berita atau artikel baru.</p></div>
<div class="card" style="max-width:800px;">
    <div class="card__header"><h3 class="card__title"><i class="fas fa-pen"></i> Form Berita</h3></div>
    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label><i class="fas fa-heading" style="margin-right:4px; color:var(--text-tertiary)"></i> Judul Berita <span class="required">*</span></label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required placeholder="Masukkan judul berita...">
            @error('judul') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-image" style="margin-right:4px; color:var(--text-tertiary)"></i> Gambar Sampul</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
            <small style="color:var(--text-secondary); margin-top:6px; display:block;">Format: JPG, PNG, GIF. Maksimal 2MB.</small>
            @error('gambar') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-align-left" style="margin-right:4px; color:var(--text-tertiary)"></i> Konten Berita <span class="required">*</span></label>
            <textarea name="konten" class="form-control" rows="8" required placeholder="Tuliskan isi berita di sini...">{{ old('konten') }}</textarea>
            @error('konten') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-eye" style="margin-right:4px; color:var(--text-tertiary)"></i> Status</label>
            <select name="status" class="form-control">
                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published (Publikasikan)</option>
                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Simpan Sementara)</option>
            </select>
            @error('status') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Berita</button>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
