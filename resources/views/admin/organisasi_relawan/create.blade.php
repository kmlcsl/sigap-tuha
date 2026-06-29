@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-header__title">Tambah Organisasi</h1>
        <p class="page-header__desc">Tambahkan organisasi relawan baru.</p>
    </div>
    <div>
        <a href="{{ route('admin.organisasi-relawan.index') }}" class="btn btn-outline btn-sm">Kembali</a>
    </div>
</div>

<div class="card" style="max-width:700px;">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-plus-circle"></i> Form Tambah Data</h3>
    </div>
    <form action="{{ route('admin.organisasi-relawan.store') }}" method="POST">
        @csrf
        <div style="padding: 24px;">
            <div class="form-group">
                <label><i class="fas fa-building" style="margin-right:4px; color:var(--text-tertiary)"></i> Nama Organisasi <span class="required">*</span></label>
                <input type="text" name="nama_organisasi" class="form-control" required maxlength="200" value="{{ old('nama_organisasi') }}">
            </div>
            <div class="form-group">
                <label><i class="fas fa-tag" style="margin-right:4px; color:var(--text-tertiary)"></i> Singkatan</label>
                <input type="text" name="singkatan" class="form-control" maxlength="20" value="{{ old('singkatan') }}">
            </div>
            <div class="form-group">
                <label><i class="fas fa-align-left" style="margin-right:4px; color:var(--text-tertiary)"></i> Deskripsi <span class="required">*</span></label>
                <textarea name="deskripsi" class="form-control" required rows="4">{{ old('deskripsi') }}</textarea>
            </div>
            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label><i class="fab fa-whatsapp" style="margin-right:4px; color:var(--text-tertiary)"></i> Kontak WA</label>
                    <input type="text" name="kontak_wa" class="form-control" maxlength="20" value="{{ old('kontak_wa') }}">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label><i class="fas fa-phone" style="margin-right:4px; color:var(--text-tertiary)"></i> Kontak Telepon</label>
                    <input type="text" name="kontak_telepon" class="form-control" maxlength="20" value="{{ old('kontak_telepon') }}">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label><i class="fas fa-envelope" style="margin-right:4px; color:var(--text-tertiary)"></i> Email</label>
                    <input type="email" name="email" class="form-control" maxlength="100" value="{{ old('email') }}">
                </div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-briefcase" style="margin-right:4px; color:var(--text-tertiary)"></i> Bidang Keahlian</label>
                <input type="text" name="bidang_keahlian" class="form-control" maxlength="200" placeholder="Contoh: Kesehatan, P3K, Evakuasi" value="{{ old('bidang_keahlian') }}">
            </div>

            <div class="form-group">
                <label><i class="fas fa-map-marker-alt" style="margin-right:4px; color:var(--text-tertiary)"></i> Alamat</label>
                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
            </div>
            <div class="form-group">
                <label><i class="fas fa-sort-numeric-down" style="margin-right:4px; color:var(--text-tertiary)"></i> Urutan (Opsional)</label>
                <input type="number" name="urutan" class="form-control" value="{{ old('urutan', 0) }}">
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                <label for="is_active" style="margin:0;">Status Aktif</label>
            </div>
            <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
            </div>
        </div>
    </form>
</div>
@endsection
