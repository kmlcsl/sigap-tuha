@extends('layouts.admin')
@section('header_title', 'Tambah Data Lansia')
@section('content')
<div class="page-header">
    <h1 class="page-header__title">Tambah Data Lansia</h1>
    <p class="page-header__desc">Isi formulir untuk menambahkan data lansia baru ke sistem.</p>
</div>
<div class="card" style="max-width:900px;">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-user-plus"></i> Form Data Lansia</h3>
    </div>
    <form action="{{ route('admin.lansia.store') }}" method="POST">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-user" style="margin-right:4px; color:var(--text-tertiary)"></i> Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Nama lengkap lansia">
                @error('nama') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-birthday-cake" style="margin-right:4px; color:var(--text-tertiary)"></i> Umur <span class="required">*</span></label>
                <input type="number" name="umur" class="form-control" value="{{ old('umur') }}" required min="1" max="150" placeholder="Umur">
                @error('umur') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-venus-mars" style="margin-right:4px; color:var(--text-tertiary)"></i> Jenis Kelamin <span class="required">*</span></label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin')=='L'?'selected':'' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin')=='P'?'selected':'' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-map-pin" style="margin-right:4px; color:var(--text-tertiary)"></i> Desa <span class="required">*</span></label>
                <input type="text" name="desa" class="form-control" value="{{ old('desa') }}" required placeholder="Nama desa">
                @error('desa') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label><i class="fas fa-map-marker-alt" style="margin-right:4px; color:var(--text-tertiary)"></i> Alamat Lengkap <span class="required">*</span></label>
            <textarea name="alamat" class="form-control" required placeholder="Alamat lengkap lansia">{{ old('alamat') }}</textarea>
            @error('alamat') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-phone" style="margin-right:4px; color:var(--text-tertiary)"></i> Kontak Keluarga</label>
                <input type="text" name="kontak_keluarga" class="form-control" value="{{ old('kontak_keluarga') }}" placeholder="No. HP keluarga">
                @error('kontak_keluarga') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-heartbeat" style="margin-right:4px; color:var(--text-tertiary)"></i> Kondisi Kesehatan</label>
                <input type="text" name="kondisi_kesehatan" class="form-control" value="{{ old('kondisi_kesehatan') }}" placeholder="Misal: Hipertensi, Reumatik">
                @error('kondisi_kesehatan') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label><i class="fas fa-notes-medical" style="margin-right:4px; color:var(--text-tertiary)"></i> Riwayat Penyakit</label>
            <textarea name="riwayat_penyakit" class="form-control" placeholder="Riwayat penyakit yang pernah diderita">{{ old('riwayat_penyakit') }}</textarea>
            @error('riwayat_penyakit') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-flag" style="margin-right:4px; color:var(--text-tertiary)"></i> Status <span class="required">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="Stabil" {{ old('status')=='Stabil'?'selected':'' }}>Stabil</option>
                    <option value="Perlu pemantauan" {{ old('status')=='Perlu pemantauan'?'selected':'' }}>Perlu Pemantauan</option>
                    <option value="Rujukan segera" {{ old('status')=='Rujukan segera'?'selected':'' }}>Rujukan Segera</option>
                </select>
                @error('status') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-map" style="margin-right:4px; color:var(--text-tertiary)"></i> Latitude</label>
                <input type="text" name="lat" class="form-control" value="{{ old('lat') }}" placeholder="Contoh: 5.1234">
            </div>
            <div class="form-group">
                <label><i class="fas fa-map" style="margin-right:4px; color:var(--text-tertiary)"></i> Longitude</label>
                <input type="text" name="lng" class="form-control" value="{{ old('lng') }}" placeholder="Contoh: 97.1234">
            </div>
        </div>
        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
            <a href="{{ route('admin.lansia.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
