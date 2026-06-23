@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-header__title">Edit Anggota</h1>
        <p class="page-header__desc">Organisasi: {{ $organisasiRelawan->nama_organisasi }}</p>
    </div>
    <div>
        <a href="{{ route('admin.organisasi-relawan.relawan.index', $organisasiRelawan) }}" class="btn btn-outline btn-sm">Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card__header">
        <h3 class="card__title">Form Anggota</h3>
    </div>
    <div style="padding: 20px;">
        <form action="{{ route('admin.organisasi-relawan.relawan.update', [$organisasiRelawan, $relawan]) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 15px;">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" required maxlength="150" value="{{ $relawan->nama_lengkap }}">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Jabatan</label>
                <input type="text" name="jabatan" class="form-control" maxlength="100" value="{{ $relawan->jabatan }}">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Keahlian</label>
                <input type="text" name="keahlian" class="form-control" maxlength="200" placeholder="Contoh: Logistik, Medis, Dapur Umum" value="{{ $relawan->keahlian }}">
            </div>
            <div style="margin-bottom: 15px; display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <label>Nomor HP</label>
                    <input type="text" name="nomor_hp" class="form-control" maxlength="20" value="{{ $relawan->nomor_hp }}">
                </div>
                <div style="flex: 1;">
                    <label>Nomor WA</label>
                    <input type="text" name="nomor_wa" class="form-control" maxlength="20" value="{{ $relawan->nomor_wa }}">
                </div>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Keterangan Tambahan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ $relawan->keterangan }}</textarea>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" name="is_aktif" value="1" {{ $relawan->is_aktif ? 'checked' : '' }}>
                    <span>Status Aktif</span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
