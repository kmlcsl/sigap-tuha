@extends('layouts.admin')
@section('header_title', 'Edit Materi Edukasi')
@section('content')
<div class="page-header"><h1 class="page-header__title">Edit Materi Edukasi</h1><p class="page-header__desc">Perbarui materi "{{ $edukasi->judul }}".</p></div>
<div class="card" style="max-width:900px;">
    <div class="card__header"><h3 class="card__title"><i class="fas fa-edit"></i> Edit Materi</h3><span class="badge badge--brand"><i class="fas fa-hashtag" style="font-size:10px"></i> ID: {{ $edukasi->id }}</span></div>
    <form action="{{ route('admin.edukasi.update', $edukasi) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label><i class="fas fa-heading" style="margin-right:4px; color:var(--text-tertiary)"></i> Judul Materi <span class="required">*</span></label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $edukasi->judul) }}" required>
            @error('judul') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label><i class="fas fa-align-left" style="margin-right:4px; color:var(--text-tertiary)"></i> Konten <span class="required">*</span></label>
            <textarea name="konten" class="form-control" style="min-height:160px;" required>{{ old('konten', $edukasi->konten) }}</textarea>
            @error('konten') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-tag" style="margin-right:4px; color:var(--text-tertiary)"></i> Kategori <span class="required">*</span></label>
                <select name="kategori" class="form-control" required>
                    @foreach(['BHD','Evakuasi','Pertolongan Pertama','Lainnya'] as $k)
                        <option value="{{ $k }}" {{ old('kategori', $edukasi->kategori)==$k?'selected':'' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label><i class="fas fa-file" style="margin-right:4px; color:var(--text-tertiary)"></i> Jenis <span class="required">*</span></label>
                <select name="jenis" class="form-control" required>
                    @foreach(['Artikel','Video','SOP'] as $j)
                        <option value="{{ $j }}" {{ old('jenis', $edukasi->jenis)==$j?'selected':'' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label><i class="fas fa-sort-numeric-down" style="margin-right:4px; color:var(--text-tertiary)"></i> Urutan</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $edukasi->order) }}" min="0">
            </div>
        </div>
        <div class="form-group">
            <label><i class="fas fa-video" style="margin-right:4px; color:var(--text-tertiary)"></i> URL Video</label>
            <input type="url" name="url_video" class="form-control" value="{{ old('url_video', $edukasi->url_video) }}">
        </div>
        <div class="form-group">
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $edukasi->is_published) ? 'checked' : '' }} style="width:18px; height:18px; accent-color:var(--brand-600);">
                <span><i class="fas fa-eye" style="margin-right:4px; color:var(--text-tertiary)"></i> Publikasikan</span>
            </label>
        </div>
        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Materi</button>
            <a href="{{ route('admin.edukasi.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
