@extends('layouts.admin')
@section('header_title', 'Pengaturan Kontak')
@section('content')
<div class="page-header"><h1 class="page-header__title">Pengaturan Kontak</h1><p class="page-header__desc">Kelola informasi kontak, alamat, dan media sosial.</p></div>

@if(session('success'))
    <div class="alert alert-success" style="padding:16px; background:var(--success-50); color:var(--success-700); border-radius:var(--radius-md); margin-bottom:20px; font-weight:500;">
        <i class="fas fa-check-circle" style="margin-right:8px;"></i> {{ session('success') }}
    </div>
@endif

<div class="card" style="max-width:800px;">
    <div class="card__header"><h3 class="card__title"><i class="fas fa-envelope"></i> Form Kontak & Lokasi</h3></div>
    <form action="{{ route('admin.kontak.update') }}" method="POST">
        @csrf
        <div class="grid grid-2" style="gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-envelope" style="margin-right:4px; color:var(--text-tertiary)"></i> Alamat Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $kontak->email ?? '') }}" placeholder="contoh: info@sigaptuha.com">
                @error('email') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-phone" style="margin-right:4px; color:var(--text-tertiary)"></i> Nomor Telepon</label>
                <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $kontak->telepon ?? '') }}" placeholder="contoh: 08123456789">
                @error('telepon') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label><i class="fas fa-map-marker-alt" style="margin-right:4px; color:var(--text-tertiary)"></i> Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap organisasi...">{{ old('alamat', $kontak->alamat ?? '') }}</textarea>
            @error('alamat') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-map" style="margin-right:4px; color:var(--text-tertiary)"></i> Google Maps Embed URL</label>
            <input type="text" name="map_embed_url" class="form-control" value="{{ old('map_embed_url', $kontak->map_embed_url ?? '') }}" placeholder="URL dari iframe src Google Maps...">
            <small style="color:var(--text-secondary); margin-top:6px; display:block;">Masukkan nilai <code>src</code> dari kode embed Google Maps.</small>
            @error('map_embed_url') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <h4 style="margin:24px 0 16px; font-size:14px; font-weight:700; color:var(--text-primary); border-bottom:1px solid var(--border-secondary); padding-bottom:8px;">Media Sosial</h4>
        
        <div class="grid grid-2" style="gap:20px;">
            <div class="form-group">
                <label><i class="fab fa-facebook" style="margin-right:4px; color:#1877F2"></i> Facebook URL</label>
                <input type="text" name="facebook" class="form-control" value="{{ old('facebook', $kontak->facebook ?? '') }}" placeholder="https://facebook.com/...">
                @error('facebook') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label><i class="fab fa-instagram" style="margin-right:4px; color:#E4405F"></i> Instagram URL</label>
                <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $kontak->instagram ?? '') }}" placeholder="https://instagram.com/...">
                @error('instagram') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>

        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
