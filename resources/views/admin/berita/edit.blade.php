@extends('layouts.admin')
@section('header_title', 'Edit Berita')

@section('styles')
<style>
/* ── Responsive Berita Edit ── */
.page-header-row {
    display: flex; align-items: flex-start; justify-content: space-between;
    flex-wrap: wrap; gap: 16px; margin-bottom: 24px;
}
.berita-edit-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 24px;
    align-items: start;
}
.berita-edit-layout__main { display: flex; flex-direction: column; gap: 20px; }
.berita-edit-layout__side { display: flex; flex-direction: column; gap: 20px; }
.slug-row { display: flex; align-items: center; gap: 8px; }
.slug-row .slug-prefix { font-size: 13px; color: var(--text-tertiary); white-space: nowrap; flex-shrink: 0; }
.slug-row input { flex: 1; }
@media (max-width: 860px) {
    .berita-edit-layout { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')

{{-- Page Header --}}
<div class="page-header-row">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-pen-to-square" style="color:var(--brand-500); margin-right:10px; font-size:22px;"></i>
            Edit Berita
        </h1>
        <p class="page-header__desc">Memperbarui: <em>{{ Str::limit($berita->judul, 55) }}</em></p>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        @if($berita->slug)
            <a href="{{ route('berita.detail', $berita->slug) }}" class="btn btn-outline btn-sm" target="_blank">
                <i class="fas fa-external-link-alt"></i> Preview
            </a>
        @endif
        <a href="{{ route('admin.berita.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
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

<form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data" id="editBeritaForm">
@csrf @method('PUT')

<div class="berita-edit-layout">

    {{-- MAIN --}}
    <div class="berita-edit-layout__main">

        <div class="card">
            <div class="card__header">
                <h3 class="card__title"><i class="fas fa-heading"></i> Informasi Utama</h3>
                <span style="font-size:12px; color:var(--text-tertiary);">ID: #{{ $berita->id }}</span>
            </div>

            <div class="form-group">
                <label><i class="fas fa-heading" style="margin-right:5px; color:var(--text-tertiary);"></i> Judul Berita <span class="required">*</span></label>
                <input type="text" name="judul" class="form-control @error('judul') is-error @enderror"
                    value="{{ old('judul', $berita->judul) }}" required maxlength="255">
                @error('judul')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label><i class="fas fa-link" style="margin-right:5px; color:var(--text-tertiary);"></i> URL Slug</label>
                <div class="slug-row">
                    <span class="slug-prefix">/berita/</span>
                    <input type="text" name="slug" class="form-control @error('slug') is-error @enderror"
                        value="{{ old('slug', $berita->slug) }}">
                </div>
                @error('slug')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            </div>
        </div>

        <div class="card">
            <div class="card__header">
                <h3 class="card__title"><i class="fas fa-align-left"></i> Isi Berita</h3>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Konten / Isi Artikel <span class="required">*</span></label>
                <textarea name="konten" id="konten" class="form-control @error('konten') is-error @enderror"
                    rows="12" required>{{ old('konten', $berita->konten) }}</textarea>
                @error('konten')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                <div class="form-hint" style="display:flex; justify-content:space-between; margin-top:8px;">
                    <span>Terakhir diperbarui: {{ $berita->updated_at->diffForHumans() }}</span>
                    <span id="wordCount" style="font-weight:600; color:var(--text-tertiary);">0 kata</span>
                </div>
            </div>
        </div>

    </div>

    {{-- SIDEBAR --}}
    <div class="berita-edit-layout__side">

        {{-- Status --}}
        <div class="card">
            <div class="card__header">
                <h3 class="card__title"><i class="fas fa-cog"></i> Pengaturan</h3>
            </div>

            {{-- Current status --}}
            <div style="padding:10px 14px; border-radius:var(--radius-md); margin-bottom:14px; display:flex; align-items:center; gap:8px;
                background:{{ $berita->status=='published' ? 'var(--success-50)' : 'var(--warning-50)' }};
                border:1px solid {{ $berita->status=='published' ? '#a7f3d0' : '#fde68a' }};">
                <i class="fas fa-{{ $berita->status=='published' ? 'globe' : 'file-alt' }}"
                    style="color:{{ $berita->status=='published' ? 'var(--success-500)' : 'var(--warning-500)' }};"></i>
                <span style="font-size:13px; font-weight:600; color:var(--text-primary);">
                    {{ $berita->status=='published' ? 'Saat ini: Published' : 'Saat ini: Draft' }}
                </span>
            </div>

            <div class="form-group">
                <label><i class="fas fa-eye" style="margin-right:5px; color:var(--text-tertiary);"></i> Status</label>
                <select name="status" class="form-control @error('status') is-error @enderror">
                    <option value="published" {{ old('status',$berita->status)=='published' ? 'selected' : '' }}>🌐 Published</option>
                    <option value="draft" {{ old('status',$berita->status)=='draft' ? 'selected' : '' }}>📝 Draft</option>
                </select>
                @error('status')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            </div>

            <div style="border-top:1px solid var(--border-secondary); padding-top:14px; display:flex; flex-direction:column; gap:10px;">
                <button type="submit" class="btn btn-primary" id="submitBtn" style="width:100%; justify-content:center;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-outline" style="width:100%; justify-content:center;">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>

            {{-- Danger --}}
            <div style="margin-top:14px; padding:12px 14px; background:var(--danger-50); border-radius:var(--radius-md); border:1px solid #fecaca;">
                <div style="font-size:11px; font-weight:700; color:var(--danger-700); margin-bottom:8px; text-transform:uppercase; letter-spacing:.04em;">
                    <i class="fas fa-exclamation-triangle"></i> Hapus Berita
                </div>
                <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST"
                    onsubmit="return confirm('Hapus berita ini secara permanen?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" style="width:100%; justify-content:center;">
                        <i class="fas fa-trash-alt"></i> Hapus Permanen
                    </button>
                </form>
            </div>
        </div>

        {{-- Gambar --}}
        <div class="card">
            <div class="card__header">
                <h3 class="card__title"><i class="fas fa-image"></i> Gambar Sampul</h3>
            </div>

            @if($berita->gambar)
                <div style="margin-bottom:12px; border-radius:var(--radius-md); overflow:hidden; border:1px solid var(--border-secondary); aspect-ratio:16/9;">
                    <img id="currentImg" src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                        style="width:100%; height:100%; object-fit:cover;">
                </div>
            @else
                <div id="imgPreviewWrap" style="display:none; margin-bottom:12px; border-radius:var(--radius-md); overflow:hidden; border:1px solid var(--border-secondary); aspect-ratio:16/9;">
                    <img id="imgPreview" src="" alt="" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div id="imgPlaceholder" style="height:90px; border:2px dashed var(--border-primary); border-radius:var(--radius-md); display:flex; flex-direction:column; align-items:center; justify-content:center; margin-bottom:10px; cursor:pointer;"
                    onclick="document.getElementById('gambar').click()">
                    <i class="fas fa-cloud-upload-alt" style="font-size:20px; color:var(--text-placeholder); margin-bottom:5px;"></i>
                    <span style="font-size:12px; color:var(--text-tertiary);">Klik pilih gambar</span>
                </div>
            @endif

            <input type="file" name="gambar" id="gambar" accept="image/*" style="display:none;" onchange="previewImage(this)">
            <button type="button" class="btn btn-outline btn-sm" style="width:100%; justify-content:center;" onclick="document.getElementById('gambar').click()">
                <i class="fas fa-folder-open"></i> {{ $berita->gambar ? 'Ganti Gambar' : 'Pilih Gambar' }}
            </button>
            @error('gambar')<div class="form-error" style="margin-top:8px;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            <div class="form-hint" style="margin-top:8px; text-align:center;">Kosongkan jika tidak ingin mengubah</div>
        </div>

    </div>
</div>

</form>

@endsection

@section('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const r = new FileReader();
        r.onload = e => {
            const cur = document.getElementById('currentImg');
            if (cur) { cur.src = e.target.result; return; }
            document.getElementById('imgPreview').src = e.target.result;
            document.getElementById('imgPreviewWrap').style.display = 'block';
            document.getElementById('imgPlaceholder').style.display = 'none';
        };
        r.readAsDataURL(input.files[0]);
    }
}
const kontenEl = document.getElementById('konten');
function cW() {
    const w = kontenEl.value.trim().split(/\s+/).filter(x=>x).length;
    document.getElementById('wordCount').textContent = w + ' kata';
}
kontenEl.addEventListener('input', cW); cW();
document.getElementById('editBeritaForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
});
</script>
@endsection
