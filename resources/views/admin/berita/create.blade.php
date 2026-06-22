@extends('layouts.admin')
@section('header_title', 'Tulis Berita Baru')

@section('styles')
<style>
/* ── Responsive Berita Create ── */
.page-header-row {
    display: flex; align-items: flex-start; justify-content: space-between;
    flex-wrap: wrap; gap: 16px; margin-bottom: 24px;
}
/* Two-column create layout */
.berita-create-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 24px;
    align-items: start;
}
.berita-create-layout__main { display: flex; flex-direction: column; gap: 20px; }
.berita-create-layout__side { display: flex; flex-direction: column; gap: 20px; }

/* Slug row */
.slug-row { display: flex; align-items: center; gap: 8px; }
.slug-row .slug-prefix { font-size: 13px; color: var(--text-tertiary); white-space: nowrap; flex-shrink: 0; }
.slug-row input { flex: 1; }

/* Image upload area */
.img-upload-area {
    height: 110px;
    border: 2px dashed var(--border-primary);
    border-radius: var(--radius-md);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
}
.img-upload-area:hover { border-color: var(--brand-400); background: var(--brand-50); }

/* Collapse to 1 col on tablet/mobile */
@media (max-width: 860px) {
    .berita-create-layout {
        grid-template-columns: 1fr;
    }
    .berita-create-layout__side {
        /* Side panel moves below on mobile */
        order: -1;
    }
}
</style>
@endsection

@section('content')

{{-- Page Header --}}
<div class="page-header-row">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-pen-nib" style="color:var(--warning-500); margin-right:10px; font-size:22px;"></i>
            Tulis Berita Baru
        </h1>
        <p class="page-header__desc">Buat dan publikasikan artikel berita ke halaman publik SIGAP TUHA.</p>
    </div>
    <a href="{{ route('admin.berita.index') }}" class="btn btn-outline">
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

<form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" id="beritaForm">
@csrf

<div class="berita-create-layout">

    {{-- MAIN --}}
    <div class="berita-create-layout__main">

        {{-- Judul & Slug --}}
        <div class="card">
            <div class="card__header">
                <h3 class="card__title"><i class="fas fa-heading"></i> Informasi Utama</h3>
            </div>

            <div class="form-group">
                <label for="judul"><i class="fas fa-heading" style="margin-right:5px; color:var(--text-tertiary);"></i> Judul Berita <span class="required">*</span></label>
                <input type="text" name="judul" id="judul" class="form-control @error('judul') is-error @enderror"
                    value="{{ old('judul') }}" required maxlength="255"
                    placeholder="Tulis judul yang menarik..." oninput="autoSlug(this.value)">
                @error('judul')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label for="slug"><i class="fas fa-link" style="margin-right:5px; color:var(--text-tertiary);"></i> URL Slug</label>
                <div class="slug-row">
                    <span class="slug-prefix">/berita/</span>
                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-error @enderror"
                        value="{{ old('slug') }}" placeholder="auto-slug-dari-judul">
                </div>
                @error('slug')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                <div class="form-hint">Auto-generate dari judul. Huruf kecil + tanda hubung saja.</div>
            </div>
        </div>

        {{-- Konten --}}
        <div class="card">
            <div class="card__header">
                <h3 class="card__title"><i class="fas fa-align-left"></i> Isi Berita</h3>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label for="konten">Konten / Isi Artikel <span class="required">*</span></label>
                <textarea name="konten" id="konten" class="form-control @error('konten') is-error @enderror"
                    rows="12" required placeholder="Tuliskan isi berita lengkap di sini...">{{ old('konten') }}</textarea>
                @error('konten')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                <div class="form-hint" style="display:flex; justify-content:space-between; margin-top:8px;">
                    <span>Mendukung teks biasa dengan baris baru</span>
                    <span id="wordCount" style="font-weight:600; color:var(--text-tertiary);">0 kata</span>
                </div>
            </div>
        </div>

    </div>

    {{-- SIDEBAR --}}
    <div class="berita-create-layout__side">

        {{-- Publish --}}
        <div class="card">
            <div class="card__header">
                <h3 class="card__title"><i class="fas fa-paper-plane"></i> Publikasi</h3>
            </div>

            <div class="form-group">
                <label for="status"><i class="fas fa-eye" style="margin-right:5px; color:var(--text-tertiary);"></i> Status</label>
                <select name="status" id="status" class="form-control @error('status') is-error @enderror">
                    <option value="published" {{ old('status','published')=='published' ? 'selected' : '' }}>🌐 Published</option>
                    <option value="draft" {{ old('status')=='draft' ? 'selected' : '' }}>📝 Draft</option>
                </select>
                @error('status')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            </div>

            <div style="border-top:1px solid var(--border-secondary); padding-top:14px; display:flex; flex-direction:column; gap:10px;">
                <button type="submit" class="btn btn-primary" id="submitBtn" style="width:100%; justify-content:center;">
                    <i class="fas fa-paper-plane"></i> Publikasikan
                </button>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-ghost" style="width:100%; justify-content:center;">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </div>

        {{-- Gambar --}}
        <div class="card">
            <div class="card__header">
                <h3 class="card__title"><i class="fas fa-image"></i> Gambar Sampul</h3>
            </div>

            <div id="imgPreviewWrap" style="display:none; margin-bottom:14px; border-radius:var(--radius-md); overflow:hidden; border:1px solid var(--border-secondary); aspect-ratio:16/9;">
                <img id="imgPreview" src="" alt="Preview" style="width:100%; height:100%; object-fit:cover;">
            </div>

            <div class="img-upload-area" id="imgPlaceholder" onclick="document.getElementById('gambar').click()">
                <i class="fas fa-cloud-upload-alt" style="font-size:24px; color:var(--text-placeholder); margin-bottom:6px;"></i>
                <span style="font-size:12.5px; color:var(--text-tertiary);">Klik untuk pilih gambar</span>
                <span style="font-size:11px; color:var(--text-placeholder); margin-top:2px;">JPG / PNG · Maks 2MB</span>
            </div>

            <input type="file" name="gambar" id="gambar" accept="image/*" style="display:none;" onchange="previewImage(this)">
            <button type="button" class="btn btn-outline btn-sm" style="width:100%; justify-content:center; margin-top:10px;" onclick="document.getElementById('gambar').click()">
                <i class="fas fa-folder-open"></i> Pilih Gambar
            </button>
            @error('gambar')<div class="form-error" style="margin-top:8px;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            <div class="form-hint" style="margin-top:8px; text-align:center;">Ideal: 1200×630 px (16:9)</div>
        </div>

    </div>
</div>

</form>

@endsection

@section('scripts')
<script>
function autoSlug(v) {
    document.getElementById('slug').value = v.toLowerCase()
        .replace(/[^a-z0-9\s-]/g,'').trim().replace(/\s+/g,'-').replace(/-+/g,'-');
}
function previewImage(input) {
    if (input.files && input.files[0]) {
        const r = new FileReader();
        r.onload = e => {
            document.getElementById('imgPreview').src = e.target.result;
            document.getElementById('imgPreviewWrap').style.display = 'block';
            document.getElementById('imgPlaceholder').style.display = 'none';
        };
        r.readAsDataURL(input.files[0]);
    }
}
document.getElementById('konten').addEventListener('input', function () {
    const w = this.value.trim().split(/\s+/).filter(x => x).length;
    document.getElementById('wordCount').textContent = w + ' kata';
});
document.getElementById('beritaForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
});
</script>
@endsection
