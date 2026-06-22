@extends('layouts.admin')
@section('header_title', 'Pengaturan Profil')
@section('content')
<div class="page-header"><h1 class="page-header__title">Profil Organisasi</h1><p class="page-header__desc">Kelola informasi profil, sejarah, visi, atau misi organisasi.</p></div>

@if(session('success'))
    <div class="alert alert-success" style="padding:16px; background:var(--success-50); color:var(--success-700); border-radius:var(--radius-md); margin-bottom:20px; font-weight:500;">
        <i class="fas fa-check-circle" style="margin-right:8px;"></i> {{ session('success') }}
    </div>
@endif

<div class="card" style="max-width:800px;">
    <div class="card__header"><h3 class="card__title"><i class="fas fa-id-card"></i> Form Profil</h3></div>
    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label><i class="fas fa-heading" style="margin-right:4px; color:var(--text-tertiary)"></i> Judul <span class="required">*</span></label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $profil->judul ?? '') }}" required placeholder="Contoh: Profil Karang Taruna">
            @error('judul') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-image" style="margin-right:4px; color:var(--text-tertiary)"></i> Gambar Profil</label>
            @if(isset($profil) && $profil->gambar)
                <div style="margin-bottom:12px;">
                    <img src="{{ asset($profil->gambar) }}" alt="Profil" style="max-width:200px; border-radius:var(--radius-sm); border:1px solid var(--border-secondary);">
                </div>
            @endif
            <input type="file" name="gambar" class="form-control" accept="image/*">
            <small style="color:var(--text-secondary); margin-top:6px; display:block;">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            @error('gambar') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-align-left" style="margin-right:4px; color:var(--text-tertiary)"></i> Konten Profil <span class="required">*</span></label>
            <textarea name="konten" class="form-control" rows="12" required placeholder="Tuliskan isi profil, sejarah, visi misi di sini...">{{ old('konten', $profil->konten ?? '') }}</textarea>
            @error('konten') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
