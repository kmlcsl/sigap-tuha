@extends('layouts.admin')
@section('header_title', 'Edit Data Lansia')

@section('content')

{{-- Page Header --}}
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-user-edit" style="color:var(--brand-500); margin-right:10px; font-size:22px;"></i>
            Edit Data Lansia
        </h1>
        <p class="page-header__desc">Memperbarui data: <strong>{{ $lansia->nama }}</strong></p>
    </div>
    <a href="{{ route('admin.lansia.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@if($errors->any())
    <div class="flash-message error" style="margin-bottom:20px;">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <strong>Terdapat {{ $errors->count() }} kesalahan:</strong>
            <ul style="margin-top:6px; padding-left:18px; font-size:13px;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    </div>
@endif

{{-- Status Info Bar --}}
<div style="padding:14px 20px; border-radius:var(--radius-lg); display:flex; align-items:center; gap:12px; margin-bottom:20px; flex-wrap:wrap;
    background: {{ $lansia->status=='Stabil' ? 'var(--success-50)' : ($lansia->status=='Perlu pemantauan' ? 'var(--warning-50)' : 'var(--danger-50)') }};
    border: 1px solid {{ $lansia->status=='Stabil' ? '#a7f3d0' : ($lansia->status=='Perlu pemantauan' ? '#fde68a' : '#fecaca') }};">
    <i class="fas fa-{{ $lansia->status=='Stabil' ? 'check-circle' : ($lansia->status=='Perlu pemantauan' ? 'exclamation-triangle' : 'exclamation-circle') }}"
        style="font-size:20px; color:{{ $lansia->status=='Stabil' ? 'var(--success-500)' : ($lansia->status=='Perlu pemantauan' ? 'var(--warning-500)' : 'var(--danger-500)') }}; flex-shrink:0;"></i>
    <div style="flex:1; min-width:0;">
        <div style="font-weight:700; font-size:14px; color:var(--text-primary);">{{ $lansia->nama }}</div>
        <div style="font-size:13px; color:var(--text-secondary);">
            {{ $lansia->umur }} tahun &bull; {{ $lansia->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} &bull; {{ $lansia->desa }} &bull;
            Status: <strong>{{ $lansia->status }}</strong>
        </div>
    </div>
    <span class="badge {{ $lansia->status=='Stabil' ? 'badge--success' : ($lansia->status=='Perlu pemantauan' ? 'badge--warning' : 'badge--danger') }}">
        <span class="badge__dot"></span> {{ $lansia->status }}
    </span>
</div>

<form action="{{ route('admin.lansia.update', $lansia) }}" method="POST" id="editLansiaForm">
@csrf @method('PUT')

{{-- SECTION 1: Data Pribadi --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-id-card"></i> Data Pribadi</h3>
        <span style="font-size:12px; color:var(--text-tertiary);">ID: <strong>#{{ $lansia->id }}</strong></span>
    </div>

    <div class="grid grid-2" style="gap:20px;">
        <div class="form-group" style="grid-column: 1 / -1;">
            <label><i class="fas fa-user" style="margin-right:5px; color:var(--text-tertiary);"></i> Nama Lengkap <span class="required">*</span></label>
            <input type="text" name="nama" class="form-control @error('nama') is-error @enderror"
                value="{{ old('nama', $lansia->nama) }}" required maxlength="200">
            @error('nama')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-birthday-cake" style="margin-right:5px; color:var(--text-tertiary);"></i> Umur <span class="required">*</span></label>
            <div style="position:relative;">
                <input type="number" name="umur" class="form-control @error('umur') is-error @enderror"
                    value="{{ old('umur', $lansia->umur) }}" required min="50" max="150">
                <span style="position:absolute; right:14px; top:50%; transform:translateY(-50%); font-size:13px; color:var(--text-tertiary); pointer-events:none;">tahun</span>
            </div>
            @error('umur')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-venus-mars" style="margin-right:5px; color:var(--text-tertiary);"></i> Jenis Kelamin <span class="required">*</span></label>
            <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-error @enderror" required>
                <option value="L" {{ old('jenis_kelamin', $lansia->jenis_kelamin)=='L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin', $lansia->jenis_kelamin)=='P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-map-pin" style="margin-right:5px; color:var(--text-tertiary);"></i> Desa <span class="required">*</span></label>
            <input type="text" name="desa" class="form-control @error('desa') is-error @enderror"
                value="{{ old('desa', $lansia->desa) }}" required>
            @error('desa')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        <div class="form-group" style="grid-column: 1 / -1;">
            <label><i class="fas fa-map-marker-alt" style="margin-right:5px; color:var(--text-tertiary);"></i> Alamat Lengkap <span class="required">*</span></label>
            <textarea name="alamat" class="form-control @error('alamat') is-error @enderror" rows="3" required>{{ old('alamat', $lansia->alamat) }}</textarea>
            @error('alamat')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-phone" style="margin-right:5px; color:var(--text-tertiary);"></i> Kontak Keluarga</label>
            <input type="tel" name="kontak_keluarga" class="form-control @error('kontak_keluarga') is-error @enderror"
                value="{{ old('kontak_keluarga', $lansia->kontak_keluarga) }}" placeholder="Nomor HP keluarga">
            @error('kontak_keluarga')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label><i class="fas fa-flag" style="margin-right:5px; color:var(--text-tertiary);"></i> Status Kesehatan <span class="required">*</span></label>
            <select name="status" class="form-control @error('status') is-error @enderror" required>
                <option value="Stabil" {{ old('status', $lansia->status)=='Stabil' ? 'selected' : '' }}>✅ Stabil</option>
                <option value="Perlu pemantauan" {{ old('status', $lansia->status)=='Perlu pemantauan' ? 'selected' : '' }}>⚠️ Perlu Pemantauan</option>
                <option value="Rujukan segera" {{ old('status', $lansia->status)=='Rujukan segera' ? 'selected' : '' }}>🚨 Rujukan Segera</option>
            </select>
            @error('status')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>
    </div>
</div>

{{-- SECTION 2: Kondisi Kesehatan --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-heartbeat"></i> Kondisi Kesehatan</h3>
    </div>

    <div class="form-group">
        <label><i class="fas fa-stethoscope" style="margin-right:5px; color:var(--text-tertiary);"></i> Kondisi Kesehatan Saat Ini</label>
        <input type="text" name="kondisi_kesehatan" class="form-control @error('kondisi_kesehatan') is-error @enderror"
            value="{{ old('kondisi_kesehatan', $lansia->kondisi_kesehatan) }}"
            placeholder="Contoh: Hipertensi, Diabetes Melitus">
        @error('kondisi_kesehatan')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label><i class="fas fa-notes-medical" style="margin-right:5px; color:var(--text-tertiary);"></i> Riwayat Penyakit</label>
        <textarea name="riwayat_penyakit" class="form-control @error('riwayat_penyakit') is-error @enderror"
            rows="3" placeholder="Riwayat penyakit sebelumnya...">{{ old('riwayat_penyakit', $lansia->riwayat_penyakit) }}</textarea>
        @error('riwayat_penyakit')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
    </div>
</div>

{{-- SECTION 3: Koordinat --}}
<div class="card" style="margin-bottom:24px;">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-map-marked-alt"></i> Koordinat Lokasi</h3>
        <span style="font-size:12px; color:var(--text-tertiary);">Opsional</span>
    </div>

    <div class="grid grid-2" style="gap:20px;">
        <div class="form-group">
            <label><i class="fas fa-crosshairs" style="margin-right:5px; color:var(--text-tertiary);"></i> Latitude</label>
            <input type="text" name="lat" class="form-control @error('lat') is-error @enderror"
                value="{{ old('lat', $lansia->lat) }}" placeholder="Contoh: 5.187234">
            @error('lat')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label><i class="fas fa-crosshairs" style="margin-right:5px; color:var(--text-tertiary);"></i> Longitude</label>
            <input type="text" name="lng" class="form-control @error('lng') is-error @enderror"
                value="{{ old('lng', $lansia->lng) }}" placeholder="Contoh: 97.234567">
            @error('lng')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>
    </div>
</div>

{{-- Actions --}}
<div style="display:flex; gap:12px; flex-wrap:wrap; padding:4px 0 24px;">
    <button type="submit" class="btn btn-primary" id="submitBtn">
        <i class="fas fa-save"></i> Simpan Perubahan
    </button>
    <a href="{{ route('admin.lansia.index') }}" class="btn btn-outline">
        <i class="fas fa-times"></i> Batal
    </a>
    <form action="{{ route('admin.lansia.destroy', $lansia) }}" method="POST" style="margin-left:auto;"
        onsubmit="return confirm('Hapus data lansia {{ addslashes($lansia->nama) }} secara permanen?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash-alt"></i> Hapus Data
        </button>
    </form>
</div>

</form>
@endsection

@section('scripts')
<script>
document.getElementById('editLansiaForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
});
</script>
@endsection
