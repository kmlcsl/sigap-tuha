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

<div class="card">
    <div class="card__header">
        <h3 class="card__title">Form Organisasi</h3>
    </div>
    <div style="padding: 20px;">
        <form action="{{ route('admin.organisasi-relawan.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label>Nama Organisasi</label>
                <input type="text" name="nama_organisasi" class="form-control" required maxlength="200">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Singkatan</label>
                <input type="text" name="singkatan" class="form-control" maxlength="20">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" required rows="4"></textarea>
            </div>
            <div style="margin-bottom: 15px; display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label>Kontak WA</label>
                    <input type="text" name="kontak_wa" class="form-control" maxlength="20">
                </div>
                <div style="flex: 1;">
                    <label>Kontak Telepon</label>
                    <input type="text" name="kontak_telepon" class="form-control" maxlength="20">
                </div>
                <div style="flex: 1;">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" maxlength="100">
                </div>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Bidang Keahlian</label>
                <input type="text" name="bidang_keahlian" class="form-control" maxlength="200" placeholder="Contoh: Kesehatan, P3K, Evakuasi">
            </div>

            <div style="margin-bottom: 15px;">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3"></textarea>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Urutan (Opsional)</label>
                <input type="number" name="urutan" class="form-control" value="0">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span>Status Aktif</span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
