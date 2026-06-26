@extends('layouts.admin')

@section('header_title', 'Edit Bantuan Darurat')

@section('content')
    <style>
        .form-control {
            border: 2px solid #94a3b8 !important;
        }

        .form-control:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
        }
    </style>

    <div class="page-header">
        <div>
            <h1 class="page-header__title">Edit Bantuan Darurat</h1>
            <p class="page-header__desc">Ubah data instansi</p>
        </div>
        <div>
            <a href="{{ route('admin.bantuan-darurat.index') }}" class="btn btn-outline">Kembali</a>
        </div>
    </div>

    <div class="card" style="max-width:700px;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-edit"></i> Form Edit Data</h3>
        </div>
        <form action="{{ route('admin.bantuan-darurat.update', $bantuanDarurat) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="padding: 24px;">
                <div class="form-group">
                    <label><i class="fas fa-building" style="margin-right:4px; color:var(--text-tertiary)"></i> Nama
                        Instansi <span class="required">*</span></label>
                    <input type="text" name="nama_instansi" class="form-control"
                        value="{{ old('nama_instansi', $bantuanDarurat->nama_instansi) }}" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-tags" style="margin-right:4px; color:var(--text-tertiary)"></i> Jenis <span
                            class="required">*</span></label>
                    <select name="jenis" class="form-control" required>
                        <option value="Kepolisian" {{ $bantuanDarurat->jenis == 'Kepolisian' ? 'selected' : '' }}>Kepolisian
                        </option>
                        <option value="Damkar" {{ $bantuanDarurat->jenis == 'Damkar' ? 'selected' : '' }}>Damkar</option>
                        <option value="Basarnas" {{ $bantuanDarurat->jenis == 'Basarnas' ? 'selected' : '' }}>Basarnas
                        </option>
                        <option value="Rumah Sakit" {{ $bantuanDarurat->jenis == 'Rumah Sakit' ? 'selected' : '' }}>Rumah
                            Sakit</option>
                        <option value="Puskesmas" {{ $bantuanDarurat->jenis == 'Puskesmas' ? 'selected' : '' }}>Puskesmas
                        </option>
                        <option value="Lainnya" {{ $bantuanDarurat->jenis == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fab fa-whatsapp" style="margin-right:4px; color:var(--text-tertiary)"></i> Nomor WA
                        <span class="required">*</span></label>
                    <input type="text" name="nomor_wa" id="nomor_wa" class="form-control"
                        value="{{ old('nomor_wa', $bantuanDarurat->nomor_wa) }}" required>
                    <small style="color:var(--text-secondary)">Format: kode negara + nomor tanpa tanda +</small>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-link" style="margin-right:4px; color:var(--text-tertiary)"></i> Preview WA
                        Link</label>
                    <div style="display:flex; gap:10px; align-items:center;">
                        <input type="text" id="wa_preview" class="form-control" readonly
                            style="background:#f9fafb; flex:1;">
                        <a href="#" id="wa_preview_link" target="_blank" class="btn btn-outline btn-sm">Test</a>
                    </div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-align-left" style="margin-right:4px; color:var(--text-tertiary)"></i>
                        Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $bantuanDarurat->deskripsi) }}</textarea>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-sort-numeric-down" style="margin-right:4px; color:var(--text-tertiary)"></i>
                        Urutan</label>
                    <input type="number" name="urutan" class="form-control"
                        value="{{ old('urutan', $bantuanDarurat->urutan) }}">
                </div>
                <div class="form-group" style="display:flex; align-items:center; gap:10px;">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        {{ old('is_active', $bantuanDarurat->is_active) ? 'checked' : '' }}>
                    <label for="is_active" style="margin:0;">Aktif</label>
                </div>
                <div
                    style="margin-top:32px; display:flex; gap:10px; padding-top:20px; border-top:1px solid var(--border-secondary);">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('nomor_wa').addEventListener('input', function() {
            const link = 'https://wa.me/' + this.value;
            document.getElementById('wa_preview').value = link;
            document.getElementById('wa_preview_link').href = link;
        });

        if (document.getElementById('nomor_wa').value) {
            document.getElementById('nomor_wa').dispatchEvent(new Event('input'));
        }
    </script>
@endsection
