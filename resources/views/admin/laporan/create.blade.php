@extends('layouts.admin')
@section('header_title', 'Tambah Laporan Darurat')
@section('content')
<div class="page-header">
    <h1 class="page-header__title">Tambah Laporan Darurat</h1>
    <p class="page-header__desc">Catat laporan darurat baru untuk lansia yang membutuhkan tindak lanjut.</p>
</div>
<div class="card" style="max-width:900px;">
    <div class="card__header"><h3 class="card__title"><i class="fas fa-file-medical"></i> Form Laporan Darurat</h3></div>
    <form action="{{ route('admin.laporan.store') }}" method="POST">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-user" style="margin-right:4px; color:var(--text-tertiary)"></i> Lansia <span class="required">*</span></label>
                <select name="lansia_id" class="form-control" required>
                    <option value="">-- Pilih Lansia --</option>
                    @foreach($lansias as $l)
                        <option value="{{ $l->id }}" {{ old('lansia_id')==$l->id?'selected':'' }}>{{ $l->nama }} ({{ $l->desa }})</option>
                    @endforeach
                </select>
                @error('lansia_id') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-user-tie" style="margin-right:4px; color:var(--text-tertiary)"></i> Nama Pelapor <span class="required">*</span></label>
                <input type="text" name="pelapor" class="form-control" value="{{ old('pelapor') }}" required placeholder="Nama relawan/pelapor">
                @error('pelapor') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label><i class="fas fa-stethoscope" style="margin-right:4px; color:var(--text-tertiary)"></i> Kondisi <span class="required">*</span></label>
            <textarea name="kondisi" class="form-control" required placeholder="Deskripsikan kondisi darurat...">{{ old('kondisi') }}</textarea>
            @error('kondisi') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label><i class="fas fa-map-marker-alt" style="margin-right:4px; color:var(--text-tertiary)"></i> Lokasi</label>
            <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" placeholder="Lokasi kejadian">
            @error('lokasi') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-bolt" style="margin-right:4px; color:var(--text-tertiary)"></i> Tingkat Urgensi <span class="required">*</span></label>
                <select name="tingkat_urgensi" class="form-control" required>
                    <option value="Rendah" {{ old('tingkat_urgensi')=='Rendah'?'selected':'' }}>Rendah</option>
                    <option value="Sedang" {{ old('tingkat_urgensi','Sedang')=='Sedang'?'selected':'' }}>Sedang</option>
                    <option value="Tinggi" {{ old('tingkat_urgensi')=='Tinggi'?'selected':'' }}>Tinggi</option>
                    <option value="Kritis" {{ old('tingkat_urgensi')=='Kritis'?'selected':'' }}>Kritis</option>
                </select>
            </div>
            <div class="form-group">
                <label><i class="fas fa-flag" style="margin-right:4px; color:var(--text-tertiary)"></i> Status <span class="required">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="Baru" {{ old('status','Baru')=='Baru'?'selected':'' }}>Baru</option>
                    <option value="Diproses" {{ old('status')=='Diproses'?'selected':'' }}>Diproses</option>
                    <option value="Ditangani" {{ old('status')=='Ditangani'?'selected':'' }}>Ditangani</option>
                    <option value="Selesai" {{ old('status')=='Selesai'?'selected':'' }}>Selesai</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label><i class="fas fa-clipboard" style="margin-right:4px; color:var(--text-tertiary)"></i> Catatan Tindakan</label>
            <textarea name="catatan_tindakan" class="form-control" placeholder="Catatan tindak lanjut...">{{ old('catatan_tindakan') }}</textarea>
        </div>
        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Laporan</button>
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
