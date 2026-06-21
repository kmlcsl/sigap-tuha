@extends('layouts.admin')
@section('header_title', 'Edit Data Lansia')
@section('content')
<div class="page-header">
    <h1 class="page-header__title">Edit Data Lansia</h1>
    <p class="page-header__desc">Perbarui data lansia "{{ $lansia->nama }}".</p>
</div>
<div class="card" style="max-width:900px;">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-user-edit"></i> Edit Data Lansia</h3>
        <span class="badge badge--brand"><i class="fas fa-hashtag" style="font-size:10px"></i> ID: {{ $lansia->id }}</span>
    </div>
    <form action="{{ route('admin.lansia.update', $lansia) }}" method="POST">
        @csrf @method('PUT')
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-user" style="margin-right:4px; color:var(--text-tertiary)"></i> Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $lansia->nama) }}" required>
                @error('nama') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-birthday-cake" style="margin-right:4px; color:var(--text-tertiary)"></i> Umur <span class="required">*</span></label>
                <input type="number" name="umur" class="form-control" value="{{ old('umur', $lansia->umur) }}" required min="1" max="150">
                @error('umur') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-venus-mars" style="margin-right:4px; color:var(--text-tertiary)"></i> Jenis Kelamin <span class="required">*</span></label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="L" {{ old('jenis_kelamin', $lansia->jenis_kelamin)=='L'?'selected':'' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $lansia->jenis_kelamin)=='P'?'selected':'' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-map-pin" style="margin-right:4px; color:var(--text-tertiary)"></i> Desa <span class="required">*</span></label>
                <input type="text" name="desa" class="form-control" value="{{ old('desa', $lansia->desa) }}" required>
                @error('desa') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label><i class="fas fa-map-marker-alt" style="margin-right:4px; color:var(--text-tertiary)"></i> Alamat Lengkap <span class="required">*</span></label>
            <textarea name="alamat" class="form-control" required>{{ old('alamat', $lansia->alamat) }}</textarea>
            @error('alamat') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-phone" style="margin-right:4px; color:var(--text-tertiary)"></i> Kontak Keluarga</label>
                <input type="text" name="kontak_keluarga" class="form-control" value="{{ old('kontak_keluarga', $lansia->kontak_keluarga) }}">
            </div>
            <div class="form-group">
                <label><i class="fas fa-heartbeat" style="margin-right:4px; color:var(--text-tertiary)"></i> Kondisi Kesehatan</label>
                <input type="text" name="kondisi_kesehatan" class="form-control" value="{{ old('kondisi_kesehatan', $lansia->kondisi_kesehatan) }}">
            </div>
        </div>
        <div class="form-group">
            <label><i class="fas fa-notes-medical" style="margin-right:4px; color:var(--text-tertiary)"></i> Riwayat Penyakit</label>
            <textarea name="riwayat_penyakit" class="form-control">{{ old('riwayat_penyakit', $lansia->riwayat_penyakit) }}</textarea>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-flag" style="margin-right:4px; color:var(--text-tertiary)"></i> Status <span class="required">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="Stabil" {{ old('status', $lansia->status)=='Stabil'?'selected':'' }}>Stabil</option>
                    <option value="Perlu pemantauan" {{ old('status', $lansia->status)=='Perlu pemantauan'?'selected':'' }}>Perlu Pemantauan</option>
                    <option value="Rujukan segera" {{ old('status', $lansia->status)=='Rujukan segera'?'selected':'' }}>Rujukan Segera</option>
                </select>
            </div>
            <div class="form-group">
                <label><i class="fas fa-map" style="margin-right:4px; color:var(--text-tertiary)"></i> Latitude</label>
                <input type="text" name="lat" class="form-control" value="{{ old('lat', $lansia->lat) }}">
            </div>
            <div class="form-group">
                <label><i class="fas fa-map" style="margin-right:4px; color:var(--text-tertiary)"></i> Longitude</label>
                <input type="text" name="lng" class="form-control" value="{{ old('lng', $lansia->lng) }}">
            </div>
        </div>
        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Data</button>
            <a href="{{ route('admin.lansia.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
