@extends('layouts.admin')
@section('header_title', 'Profil Organisasi')

@section('content')

{{-- Page Header --}}
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-id-card" style="color:var(--info-500); margin-right:10px; font-size:22px;"></i>
            Profil Organisasi
        </h1>
        <p class="page-header__desc">Kelola informasi profil, sejarah, visi, dan misi SIGAP TUHA.</p>
    </div>
    <a href="{{ route('profil') }}" class="btn btn-outline btn-sm" target="_blank">
        <i class="fas fa-external-link-alt"></i> Lihat Halaman Profil
    </a>
</div>

{{-- Flash --}}
@if(session('success'))
    <div class="flash-message success" id="flashMsg">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button onclick="document.getElementById('flashMsg').remove()" style="margin-left:auto; background:none; border:none; cursor:pointer; color:inherit; opacity:0.6; font-size:18px;">&times;</button>
    </div>
@endif
@if(session('error'))
    <div class="flash-message error" id="flashMsgErr">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button onclick="document.getElementById('flashMsgErr').remove()" style="margin-left:auto; background:none; border:none; cursor:pointer; color:inherit; opacity:0.6; font-size:18px;">&times;</button>
    </div>
@endif

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

<form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data" id="profilForm">
@csrf

<div class="profil-layout">

    {{-- LEFT: Main Form --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- Judul --}}
        <div class="card">
            <div class="card__header">
                <h3 class="card__title"><i class="fas fa-heading"></i> Informasi Utama</h3>
            </div>

            <div class="form-group">
                <label for="judul">
                    <i class="fas fa-tag" style="margin-right:5px; color:var(--text-tertiary);"></i>
                    Judul Profil <span class="required">*</span>
                </label>
                <input type="text" name="judul" id="judul" class="form-control @error('judul') is-error @enderror"
                    value="{{ old('judul', $profil->judul ?? '') }}" required maxlength="200"
                    placeholder="Contoh: Profil SIGAP TUHA">
                @error('judul')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                <div class="form-hint">Judul ini tampil sebagai heading halaman profil publik</div>
            </div>
        </div>

        {{-- Konten --}}
        <div class="card">
            <div class="card__header">
                <h3 class="card__title"><i class="fas fa-align-left"></i> Konten Profil</h3>
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <label for="konten">
                    <i class="fas fa-file-alt" style="margin-right:5px; color:var(--text-tertiary);"></i>
                    Isi / Konten Profil <span class="required">*</span>
                </label>
                <textarea name="konten" id="konten" class="form-control @error('konten') is-error @enderror"
                    rows="14" required
                    placeholder="Tuliskan profil organisasi, sejarah berdiri, visi misi, atau informasi penting lainnya di sini...">{{ old('konten', $profil->konten ?? '') }}</textarea>
                @error('konten')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                <div class="form-hint" style="display:flex; justify-content:space-between; margin-top:8px;">
                    <span><i class="fas fa-info-circle" style="font-size:10px;"></i> Mendukung format teks biasa</span>
                    <span id="wordCount" style="font-weight:600; color:var(--text-tertiary);">0 kata</span>
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT: Sidebar --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- Actions --}}
        <div class="card">
            <div class="card__header">
                <h3 class="card__title"><i class="fas fa-save"></i> Simpan</h3>
            </div>
            <div style="display:flex; flex-direction:column; gap:10px;">
                <button type="submit" class="btn btn-primary" id="submitBtn" style="width:100%; justify-content:center;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('profil') }}" class="btn btn-outline" target="_blank" style="width:100%; justify-content:center;">
                    <i class="fas fa-eye"></i> Preview Halaman
                </a>
            </div>

            @if(isset($profil) && $profil->updated_at)
                <div style="margin-top:16px; padding:12px; background:var(--gray-50); border-radius:var(--radius-md); text-align:center;">
                    <div style="font-size:11px; color:var(--text-tertiary); text-transform:uppercase; letter-spacing:.06em; margin-bottom:4px;">Terakhir Diperbarui</div>
                    <div style="font-size:13px; font-weight:600; color:var(--text-primary);">{{ $profil->updated_at->translatedFormat('d M Y') }}</div>
                    <div style="font-size:12px; color:var(--text-tertiary);">{{ $profil->updated_at->translatedFormat('H:i') }} WIB &bull; {{ $profil->updated_at->diffForHumans() }}</div>
                </div>
            @endif
        </div>

        {{-- Gambar Profil --}}
        <div class="card">
            <div class="card__header">
                <h3 class="card__title"><i class="fas fa-image"></i> Gambar Profil</h3>
            </div>

            {{-- Current Image --}}
            @if(isset($profil) && $profil->gambar)
                <div style="margin-bottom:14px; border-radius:var(--radius-lg); overflow:hidden; border:2px solid var(--border-secondary); aspect-ratio:16/9; position:relative;">
                    <img id="currentImg" src="{{ asset('storage/' . $profil->gambar) }}" alt="Gambar Profil"
                        style="width:100%; height:100%; object-fit:cover;">
                    <div style="position:absolute; bottom:0; left:0; right:0; padding:8px 12px; background:linear-gradient(0deg,rgba(0,0,0,.5),transparent); color:#fff; font-size:12px; font-weight:600;">
                        <i class="fas fa-check-circle" style="font-size:10px;"></i> Gambar saat ini
                    </div>
                </div>
            @else
                <div id="imgPreviewWrap" style="display:none; margin-bottom:14px; border-radius:var(--radius-lg); overflow:hidden; border:1px solid var(--border-secondary); aspect-ratio:16/9;">
                    <img id="imgPreview" src="" alt="Preview" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div id="imgPlaceholder" style="height:110px; border:2px dashed var(--border-primary); border-radius:var(--radius-lg); display:flex; flex-direction:column; align-items:center; justify-content:center; margin-bottom:12px; cursor:pointer; transition:border-color .2s;"
                    onclick="document.getElementById('gambar').click()"
                    onmouseover="this.style.borderColor='var(--brand-400)'"
                    onmouseout="this.style.borderColor='var(--border-primary)'">
                    <i class="fas fa-cloud-upload-alt" style="font-size:24px; color:var(--text-placeholder); margin-bottom:6px;"></i>
                    <span style="font-size:12.5px; color:var(--text-tertiary);">Klik untuk pilih gambar</span>
                    <span style="font-size:11px; color:var(--text-placeholder); margin-top:2px;">JPG, PNG · Maks 2MB</span>
                </div>
            @endif

            <input type="file" name="gambar" id="gambar" accept="image/*" style="display:none;" onchange="previewImage(this)">
            <button type="button" class="btn btn-outline btn-sm" style="width:100%; justify-content:center;" onclick="document.getElementById('gambar').click()">
                <i class="fas fa-folder-open"></i> {{ isset($profil) && $profil->gambar ? 'Ganti Gambar' : 'Pilih Gambar' }}
            </button>
            @error('gambar')<div class="form-error" style="margin-top:8px;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            <div class="form-hint" style="margin-top:8px; text-align:center;">Dimensi ideal: 1200×630 px (16:9)</div>
        </div>

        {{-- Info Box --}}
        <div style="padding:16px 18px; background:var(--info-50); border:1px solid #bfdbfe; border-radius:var(--radius-lg);">
            <div style="font-weight:700; font-size:13px; color:var(--text-primary); margin-bottom:8px;">
                <i class="fas fa-info-circle" style="color:var(--info-500); margin-right:6px;"></i> Panduan Pengisian
            </div>
            <ul style="font-size:12.5px; color:var(--text-secondary); line-height:1.8; padding-left:16px; margin:0;">
                <li>Judul tampil sebagai heading utama halaman profil</li>
                <li>Konten mendukung teks biasa dengan baris baru</li>
                <li>Gambar akan tampil di bagian atas halaman profil</li>
                <li>Perubahan langsung aktif setelah disimpan</li>
            </ul>
        </div>

    </div>
</div>

</form>

@endsection

@section('styles')
<style>
/* ── Responsive Profil Layout ── */
.page-header-row {
    display: flex; align-items: flex-start; justify-content: space-between;
    flex-wrap: wrap; gap: 16px; margin-bottom: 24px;
}
.profil-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 24px;
    align-items: start;
}
.profil-layout__main { display: flex; flex-direction: column; gap: 20px; }
.profil-layout__side { display: flex; flex-direction: column; gap: 20px; }

@media (max-width: 860px) {
    .profil-layout {
        grid-template-columns: 1fr;
    }
    .profil-layout__side {
        order: -1;
    }
}
</style>
@endsection

@section('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const cur = document.getElementById('currentImg');
            if (cur) { cur.src = e.target.result; return; }
            document.getElementById('imgPreview').src = e.target.result;
            document.getElementById('imgPreviewWrap').style.display = 'block';
            document.getElementById('imgPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

const kontenEl = document.getElementById('konten');
function countWords() {
    const words = kontenEl.value.trim().split(/\s+/).filter(w => w.length > 0).length;
    document.getElementById('wordCount').textContent = words + ' kata';
}
kontenEl.addEventListener('input', countWords);
countWords();

document.getElementById('profilForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
});

// Auto-dismiss flashes
setTimeout(() => {
    ['flashMsg','flashMsgErr'].forEach(id => {
        const el = document.getElementById(id);
        if (el) { el.style.opacity='0'; el.style.transition='opacity .4s'; setTimeout(()=>el.remove(),400); }
    });
}, 5000);
</script>
@endsection
