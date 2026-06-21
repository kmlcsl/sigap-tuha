@extends('layouts.admin')
@section('header_title', 'Edit Laporan Darurat')
@section('content')
<div class="page-header">
    <h1 class="page-header__title">Edit Laporan Darurat</h1>
    <p class="page-header__desc">Perbarui status dan informasi laporan darurat.</p>
</div>
<div class="card" style="max-width:900px;">
    <div class="card__header">
        <h3 class="card__title"><i class="fas fa-edit"></i> Edit Laporan</h3>
        <span class="badge badge--brand"><i class="fas fa-hashtag" style="font-size:10px"></i> ID: {{ $laporan->id }}</span>
    </div>
    <form action="{{ route('admin.laporan.update', $laporan) }}" method="POST">
        @csrf @method('PUT')
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-user" style="margin-right:4px; color:var(--text-tertiary)"></i> Lansia <span class="required">*</span></label>
                <select name="lansia_id" class="form-control" required>
                    @foreach($lansias as $l)
                        <option value="{{ $l->id }}" {{ old('lansia_id', $laporan->lansia_id)==$l->id?'selected':'' }}>{{ $l->nama }} ({{ $l->desa }})</option>
                    @endforeach
                </select>
                @error('lansia_id') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label><i class="fas fa-user-tie" style="margin-right:4px; color:var(--text-tertiary)"></i> Nama Pelapor <span class="required">*</span></label>
                <input type="text" name="pelapor" class="form-control" value="{{ old('pelapor', $laporan->pelapor) }}" required>
                @error('pelapor') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>
        <div class="form-group">
            <label><i class="fas fa-stethoscope" style="margin-right:4px; color:var(--text-tertiary)"></i> Kondisi <span class="required">*</span></label>
            <textarea name="kondisi" class="form-control" required>{{ old('kondisi', $laporan->kondisi) }}</textarea>
            @error('kondisi') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label><i class="fas fa-map-marker-alt" style="margin-right:4px; color:var(--text-tertiary)"></i> Lokasi</label>
            <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $laporan->lokasi) }}">
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
                <label><i class="fas fa-bolt" style="margin-right:4px; color:var(--text-tertiary)"></i> Tingkat Urgensi <span class="required">*</span></label>
                <select name="tingkat_urgensi" class="form-control" required>
                    @foreach(['Rendah','Sedang','Tinggi','Kritis'] as $u)
                        <option value="{{ $u }}" {{ old('tingkat_urgensi', $laporan->tingkat_urgensi)==$u?'selected':'' }}>{{ $u }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label><i class="fas fa-flag" style="margin-right:4px; color:var(--text-tertiary)"></i> Status <span class="required">*</span></label>
                <select name="status" class="form-control" required>
                    @foreach(['Baru','Diproses','Ditangani','Selesai'] as $s)
                        <option value="{{ $s }}" {{ old('status', $laporan->status)==$s?'selected':'' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label><i class="fas fa-clipboard" style="margin-right:4px; color:var(--text-tertiary)"></i> Catatan Tindakan</label>
            <textarea name="catatan_tindakan" class="form-control">{{ old('catatan_tindakan', $laporan->catatan_tindakan) }}</textarea>
        </div>
        <div style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Laporan</button>
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
@endsection
