@extends('layouts.admin')
@section('header_title', 'Tambah Data Lansia')

@section('content')

{{-- Page Header --}}
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-user-plus" style="color:var(--success-500); margin-right:10px; font-size:22px;"></i>
            Tambah Data Lansia
        </h1>
        <p class="page-header__desc">Isi formulir berikut untuk mendaftarkan data lansia baru ke dalam sistem.</p>
    </div>
    <a href="{{ route('admin.lansia.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

@if($errors->any())
    <div class="flash-message error" style="margin-bottom:20px;">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <strong>Terdapat {{ $errors->count() }} kesalahan yang perlu diperbaiki:</strong>
            <ul style="margin-top:6px; padding-left:18px; font-size:13px;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    </div>
@endif

<form action="{{ route('admin.lansia.store') }}" method="POST" id="lansiaForm">
@csrf

{{-- SECTION 1: Data Pribadi --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-id-card"></i> Data Pribadi</h3>
        <span style="font-size:12px; color:var(--text-tertiary);"><span style="color:var(--danger-500);">*</span> Wajib diisi</span>
    </div>

    <div class="grid grid-2" style="gap:20px;">
        {{-- Nama --}}
        <div class="form-group" style="grid-column: 1 / -1;">
            <label for="nama"><i class="fas fa-user" style="margin-right:5px; color:var(--text-tertiary);"></i> Nama Lengkap <span class="required">*</span></label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-error @enderror"
                value="{{ old('nama') }}" required maxlength="200"
                placeholder="Nama lengkap sesuai KTP">
            @error('nama')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        {{-- Umur --}}
        <div class="form-group">
            <label for="umur"><i class="fas fa-birthday-cake" style="margin-right:5px; color:var(--text-tertiary);"></i> Umur <span class="required">*</span></label>
            <div style="position:relative;">
                <input type="number" name="umur" id="umur" class="form-control @error('umur') is-error @enderror"
                    value="{{ old('umur') }}" required min="50" max="150" placeholder="Contoh: 70">
                <span style="position:absolute; right:14px; top:50%; transform:translateY(-50%); font-size:13px; color:var(--text-tertiary); pointer-events:none;">tahun</span>
            </div>
            @error('umur')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            <div class="form-hint">Minimal 50 tahun (kategori lansia)</div>
        </div>

        {{-- Jenis Kelamin --}}
        <div class="form-group">
            <label for="jenis_kelamin"><i class="fas fa-venus-mars" style="margin-right:5px; color:var(--text-tertiary);"></i> Jenis Kelamin <span class="required">*</span></label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-error @enderror" required>
                <option value="">— Pilih Jenis Kelamin —</option>
                <option value="L" {{ old('jenis_kelamin')=='L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin')=='P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        {{-- Desa --}}
        <div class="form-group">
            <label for="desa"><i class="fas fa-map-pin" style="margin-right:5px; color:var(--text-tertiary);"></i> Desa <span class="required">*</span></label>
            <input type="text" name="desa" id="desa" class="form-control @error('desa') is-error @enderror"
                value="{{ old('desa') }}" required placeholder="Contoh: Pandrah Kandeh">
            @error('desa')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        {{-- Alamat --}}
        <div class="form-group" style="grid-column: 1 / -1;">
            <label for="alamat"><i class="fas fa-map-marker-alt" style="margin-right:5px; color:var(--text-tertiary);"></i> Alamat Lengkap <span class="required">*</span></label>
            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-error @enderror"
                rows="3" required placeholder="Alamat lengkap lansia, RT/RW, Dusun, Desa...">{{ old('alamat') }}</textarea>
            @error('alamat')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        {{-- Kontak Keluarga --}}
        <div class="form-group">
            <label for="kontak_keluarga"><i class="fas fa-phone" style="margin-right:5px; color:var(--text-tertiary);"></i> Kontak Keluarga</label>
            <input type="tel" name="kontak_keluarga" id="kontak_keluarga" class="form-control @error('kontak_keluarga') is-error @enderror"
                value="{{ old('kontak_keluarga') }}" placeholder="Contoh: 0812-3456-7890">
            @error('kontak_keluarga')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            <div class="form-hint">Nomor HP yang dapat dihubungi</div>
        </div>

        {{-- Status --}}
        <div class="form-group">
            <label for="status"><i class="fas fa-flag" style="margin-right:5px; color:var(--text-tertiary);"></i> Status Kesehatan <span class="required">*</span></label>
            <select name="status" id="status" class="form-control @error('status') is-error @enderror" required>
                <option value="Stabil" {{ old('status','Stabil')=='Stabil' ? 'selected' : '' }}>✅ Stabil</option>
                <option value="Perlu pemantauan" {{ old('status')=='Perlu pemantauan' ? 'selected' : '' }}>⚠️ Perlu Pemantauan</option>
                <option value="Rujukan segera" {{ old('status')=='Rujukan segera' ? 'selected' : '' }}>🚨 Rujukan Segera</option>
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

    <div class="grid grid-2" style="gap:20px;">
        <div class="form-group" style="grid-column: 1 / -1;">
            <label for="kondisi_kesehatan"><i class="fas fa-stethoscope" style="margin-right:5px; color:var(--text-tertiary);"></i> Kondisi Kesehatan Saat Ini</label>
            <input type="text" name="kondisi_kesehatan" id="kondisi_kesehatan"
                class="form-control @error('kondisi_kesehatan') is-error @enderror"
                value="{{ old('kondisi_kesehatan') }}"
                placeholder="Contoh: Hipertensi, Diabetes Melitus, Reumatik">
            @error('kondisi_kesehatan')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            <div class="form-hint">Pisahkan dengan koma jika lebih dari satu kondisi</div>
        </div>

        <div class="form-group" style="grid-column: 1 / -1;">
            <label for="riwayat_penyakit"><i class="fas fa-notes-medical" style="margin-right:5px; color:var(--text-tertiary);"></i> Riwayat Penyakit</label>
            <textarea name="riwayat_penyakit" id="riwayat_penyakit"
                class="form-control @error('riwayat_penyakit') is-error @enderror"
                rows="3" placeholder="Riwayat penyakit yang pernah diderita sebelumnya...">{{ old('riwayat_penyakit') }}</textarea>
            @error('riwayat_penyakit')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>
    </div>
</div>

{{-- SECTION 3: Koordinat Lokasi --}}
<div class="card" style="margin-bottom:24px;">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-map-marked-alt"></i> Koordinat Lokasi</h3>
        <span style="font-size:12px; color:var(--text-tertiary);">Opsional — untuk fitur peta sebaran</span>
    </div>

    <div style="padding:14px 16px; background:var(--info-50); border:1px solid #bfdbfe; border-radius:var(--radius-md); display:flex; align-items:flex-start; gap:10px; margin-bottom:20px;">
        <i class="fas fa-info-circle" style="color:var(--info-500); margin-top:2px; flex-shrink:0;"></i>
        <p style="font-size:13px; color:var(--text-secondary); margin:0; line-height:1.6;">
            Koordinat digunakan untuk menampilkan lokasi lansia di Peta Sebaran. 
            Buka <a href="https://maps.google.com" target="_blank" style="color:var(--brand-600); font-weight:600;">Google Maps</a>, 
            klik kanan pada lokasi, lalu salin koordinatnya.
        </p>
    </div>

    <div class="grid grid-2" style="gap:20px;">
        <div class="form-group">
            <label for="lat"><i class="fas fa-crosshairs" style="margin-right:5px; color:var(--text-tertiary);"></i> Latitude</label>
            <input type="text" name="lat" id="lat" class="form-control @error('lat') is-error @enderror"
                value="{{ old('lat') }}" placeholder="Contoh: 5.187234">
            @error('lat')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label for="lng"><i class="fas fa-crosshairs" style="margin-right:5px; color:var(--text-tertiary);"></i> Longitude</label>
            <input type="text" name="lng" id="lng" class="form-control @error('lng') is-error @enderror"
                value="{{ old('lng') }}" placeholder="Contoh: 97.234567">
            @error('lng')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>
    </div>
</div>

{{-- Form Actions --}}
<div style="display:flex; gap:12px; flex-wrap:wrap; padding:20px 0;">
    <button type="submit" class="btn btn-primary" id="submitBtn">
        <i class="fas fa-save"></i> Simpan Data Lansia
    </button>
    <button type="reset" class="btn btn-outline">
        <i class="fas fa-undo"></i> Reset Form
    </button>
    <a href="{{ route('admin.lansia.index') }}" class="btn btn-ghost">
        <i class="fas fa-times"></i> Batal
    </a>
</div>

</form>

@endsection

@section('scripts')
<script>
document.getElementById('lansiaForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
});
</script>
@endsection
