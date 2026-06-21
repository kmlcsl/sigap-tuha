@extends('layouts.admin')
@section('header_title', 'Tambah Program')
@section('content')
<div class="page-header"><h1 class="page-header__title">Tambah Program</h1><p class="page-header__desc">Buat program baru.</p></div>
<div class="card" style="max-width:700px;">
    <div class="card__header"><h3 class="card__title"><i class="fas fa-project-diagram"></i> Form Program</h3></div>
    <form action="{{ route('admin.programs.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label><i class="fas fa-tag" style="margin-right:4px; color:var(--text-tertiary)"></i> Nama Program <span class="required">*</span></label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Contoh: Kesehatan Lansia">
            @error('nama') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label><i class="fas fa-align-left" style="margin-right:4px; color:var(--text-tertiary)"></i> Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Penjelasan mengenai program ini...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Program</button>
            <a href="{{ route('admin.programs.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
