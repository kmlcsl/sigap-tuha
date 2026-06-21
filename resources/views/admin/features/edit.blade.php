@extends('layouts.admin')

@section('header_title', 'Edit Fitur')

@section('content')
{{-- Page Header --}}
<div class="page-header">
    <h1 class="page-header__title">Edit Fitur</h1>
    <p class="page-header__desc">Perbarui informasi fitur "{{ $feature->title }}" yang ditampilkan di halaman utama.</p>
</div>

<div class="card" style="max-width:800px;">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-pen-to-square"></i> Edit Data Fitur</h3>
        <span class="badge badge--brand">
            <i class="fas fa-hashtag" style="font-size:10px;"></i> ID: {{ $feature->id }}
        </span>
    </div>

    <form action="{{ route('admin.features.update', $feature) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label><i class="fas fa-heading" style="margin-right:4px; color:var(--text-tertiary);"></i> Judul Fitur <span class="required">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $feature->title) }}" required>
            @error('title')
                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-align-left" style="margin-right:4px; color:var(--text-tertiary);"></i> Deskripsi Singkat</label>
            <textarea name="description" class="form-control">{{ old('description', $feature->description) }}</textarea>
            @error('description')
                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-palette" style="margin-right:4px; color:var(--text-tertiary);"></i> Warna Aksen</label>
                <select name="color_class" class="form-control">
                    <option value="blue" {{ old('color_class', $feature->color_class) == 'blue' ? 'selected' : '' }}>🔵 Biru (Navy)</option>
                    <option value="gold" {{ old('color_class', $feature->color_class) == 'gold' ? 'selected' : '' }}>🟡 Emas (Gold)</option>
                    <option value="red" {{ old('color_class', $feature->color_class) == 'red' ? 'selected' : '' }}>🔴 Merah (Red)</option>
                </select>
                @error('color_class')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-sort-numeric-down" style="margin-right:4px; color:var(--text-tertiary);"></i> Urutan Tampil</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $feature->order) }}" min="0">
                <div class="form-hint"><i class="fas fa-info-circle"></i> Angka kecil ditampilkan lebih dulu.</div>
                @error('order')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label><i class="fas fa-code" style="margin-right:4px; color:var(--text-tertiary);"></i> Icon SVG (Opsional)</label>
            <textarea name="icon_svg" class="form-control" style="font-family: &quot;JetBrains Mono&quot;, monospace; font-size:13px;">{{ old('icon_svg', $feature->icon_svg) }}</textarea>
            <div class="form-hint"><i class="fas fa-info-circle"></i> Biarkan kosong untuk menggunakan icon default.</div>
            @error('icon_svg')
                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top:32px; display:flex; align-items:center; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Fitur
            </button>
            <a href="{{ route('admin.features.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
