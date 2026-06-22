@extends('layouts.admin')
@section('header_title', 'Tambah Program Baru')

@section('content')

{{-- Page Header --}}
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-plus-circle" style="color:var(--success-500); margin-right:10px; font-size:22px;"></i>
            Tambah Program Baru
        </h1>
        <p class="page-header__desc">Buat program baru yang akan tampil di halaman publik SIGAP TUHA.</p>
    </div>
    <a href="{{ route('admin.programs.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

{{-- Error Summary --}}
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

<div class="grid grid-2" style="align-items:start; gap:24px;">
    {{-- Form Card --}}
    <div class="card" style="grid-column: 1 / -1; max-width:860px;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-project-diagram"></i> Formulir Program</h3>
            <span style="font-size:12px; color:var(--text-tertiary);"><i class="fas fa-asterisk" style="color:var(--danger-500);"></i> = Wajib diisi</span>
        </div>

        <form action="{{ route('admin.programs.store') }}" method="POST" id="programForm">
            @csrf

            {{-- Nama Program --}}
            <div class="form-group">
                <label for="nama">
                    <i class="fas fa-tag" style="margin-right:5px; color:var(--text-tertiary);"></i>
                    Nama Program <span class="required">*</span>
                </label>
                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-error @enderror"
                    value="{{ old('nama') }}" required maxlength="200"
                    placeholder="Contoh: Program Kesehatan Lansia Desa Pandrah">
                @error('nama')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
                <div class="form-hint"><i class="fas fa-info-circle" style="font-size:10px;"></i> Nama ini akan tampil di halaman publik. Maksimal 200 karakter.</div>
            </div>

            {{-- Deskripsi --}}
            <div class="form-group">
                <label for="deskripsi">
                    <i class="fas fa-align-left" style="margin-right:5px; color:var(--text-tertiary);"></i>
                    Deskripsi Program
                </label>
                <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-error @enderror"
                    rows="5" maxlength="1000"
                    placeholder="Tuliskan deskripsi singkat tentang program ini, tujuannya, dan manfaat yang diberikan kepada lansia...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
                <div class="form-hint" style="display:flex; justify-content:space-between;">
                    <span><i class="fas fa-info-circle" style="font-size:10px;"></i> Opsional. Tampil di halaman detail program.</span>
                    <span id="charCount" style="font-weight:600; color:var(--text-tertiary);">0 / 1000</span>
                </div>
            </div>

            {{-- Divider --}}
            <div style="border-top:1px solid var(--border-secondary); margin: 28px 0 24px;"></div>

            {{-- Preview Box --}}
            <div style="padding:16px 20px; background:var(--gray-50); border-radius:var(--radius-lg); border:1px dashed var(--border-primary); margin-bottom:24px;">
                <div style="font-size:12px; font-weight:600; color:var(--text-tertiary); text-transform:uppercase; letter-spacing:.06em; margin-bottom:10px;">
                    <i class="fas fa-eye" style="margin-right:5px;"></i> Preview
                </div>
                <div style="display:flex; align-items:flex-start; gap:14px;">
                    <div style="width:48px; height:48px; border-radius:var(--radius-lg); background:linear-gradient(135deg, var(--success-500), var(--brand-500)); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fas fa-project-diagram" style="color:#fff; font-size:18px;"></i>
                    </div>
                    <div>
                        <div id="previewNama" style="font-size:16px; font-weight:700; color:var(--text-primary);">Nama Program...</div>
                        <div id="previewDeskripsi" style="font-size:13.5px; color:var(--text-secondary); margin-top:4px; line-height:1.6;">Deskripsi program akan muncul di sini...</div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i> Simpan Program
                </button>
                <button type="reset" class="btn btn-outline" onclick="resetPreview()">
                    <i class="fas fa-undo"></i> Reset Form
                </button>
                <a href="{{ route('admin.programs.index') }}" class="btn btn-ghost">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Live preview
const namaInput   = document.getElementById('nama');
const deskInput   = document.getElementById('deskripsi');
const prevNama    = document.getElementById('previewNama');
const prevDesk    = document.getElementById('previewDeskripsi');
const charCount   = document.getElementById('charCount');

namaInput.addEventListener('input', () => {
    prevNama.textContent = namaInput.value || 'Nama Program...';
});

deskInput.addEventListener('input', () => {
    prevDesk.textContent = deskInput.value || 'Deskripsi program akan muncul di sini...';
    charCount.textContent = deskInput.value.length + ' / 1000';
    charCount.style.color = deskInput.value.length > 900 ? 'var(--danger-500)' : 'var(--text-tertiary)';
});

function resetPreview() {
    prevNama.textContent = 'Nama Program...';
    prevDesk.textContent = 'Deskripsi program akan muncul di sini...';
    charCount.textContent = '0 / 1000';
}

// Prevent double submit
document.getElementById('programForm').addEventListener('submit', function () {
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('submitBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
});
</script>
@endsection
