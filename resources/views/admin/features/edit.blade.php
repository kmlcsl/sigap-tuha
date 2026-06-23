@extends('layouts.admin')
@section('header_title', 'Edit Fitur')

@section('styles')
<style>
.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
@media (max-width: 600px) {
    .form-grid-2 { grid-template-columns: 1fr; }
}
.page-header-row {
    display: flex; align-items:flex-start; justify-content:space-between;
    flex-wrap: wrap; gap: 16px; margin-bottom: 24px;
}
.color-swatches { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px; }
.color-swatch {
    width: 36px; height: 36px; border-radius: var(--radius-md);
    cursor: pointer; border: 3px solid transparent;
    transition: all .2s; display: flex; align-items: center;
    justify-content: center; color: #fff; font-size: 12px;
}
.color-swatch.active { border-color: var(--text-primary); transform: scale(1.15); }
</style>
@endsection

@section('content')

{{-- Page Header --}}
<div class="page-header-row">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-pen-to-square" style="color:var(--brand-500); margin-right:10px; font-size:22px;"></i>
            Edit Fitur
        </h1>
        <p class="page-header__desc">Memperbarui fitur: <strong>{{ $feature->title }}</strong></p>
    </div>
    <a href="{{ route('admin.features.index') }}" class="btn btn-outline">
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

<div style="max-width:800px;">
<form action="{{ route('admin.features.update', $feature) }}" method="POST" id="editFeatureForm" enctype="multipart/form-data">
@csrf @method('PUT')

    {{-- SECTION 1: Konten --}}
    <div class="card" style="margin-bottom:20px;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-pen"></i> Konten Fitur</h3>
            <span class="badge badge--brand"><i class="fas fa-hashtag" style="font-size:10px;"></i> ID: {{ $feature->id }}</span>
        </div>

        <div class="form-group">
            <label for="title">
                <i class="fas fa-heading" style="margin-right:5px; color:var(--text-tertiary);"></i>
                Judul Fitur <span class="required">*</span>
            </label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-error @enderror"
                value="{{ old('title', $feature->title) }}" required maxlength="100">
            @error('title')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
        </div>

        <div class="form-group" style="margin-bottom:0;">
            <label for="description">
                <i class="fas fa-align-left" style="margin-right:5px; color:var(--text-tertiary);"></i>
                Deskripsi Singkat
            </label>
            <textarea name="description" id="description" class="form-control @error('description') is-error @enderror"
                rows="3" maxlength="300">{{ old('description', $feature->description) }}</textarea>
            @error('description')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            <div class="form-hint" style="display:flex; justify-content:space-between;">
                <span>Opsional. Maks 300 karakter.</span>
                <span id="descCount" style="font-weight:600; color:var(--text-tertiary);">{{ strlen(old('description', $feature->description)) }} / 300</span>
            </div>
        </div>
    </div>

    {{-- SECTION 2: Tampilan --}}
    <div class="card" style="margin-bottom:20px;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-palette"></i> Tampilan & Urutan</h3>
        </div>

        <div class="form-grid-2">
            <div class="form-group">
                <label>
                    <i class="fas fa-palette" style="margin-right:5px; color:var(--text-tertiary);"></i>
                    Warna Aksen
                </label>
                <select name="color_class" id="colorSelect" class="form-control @error('color_class') is-error @enderror"
                    onchange="updateSwatch(this.value)">
                    <option value="blue"   {{ old('color_class', $feature->color_class) == 'blue'   ? 'selected' : '' }}>🔵 Biru (Brand)</option>
                    <option value="gold"   {{ old('color_class', $feature->color_class) == 'gold'   ? 'selected' : '' }}>🟡 Emas (Gold)</option>
                    <option value="red"    {{ old('color_class', $feature->color_class) == 'red'    ? 'selected' : '' }}>🔴 Merah (Danger)</option>
                    <option value="green"  {{ old('color_class', $feature->color_class) == 'green'  ? 'selected' : '' }}>🟢 Hijau (Success)</option>
                    <option value="purple" {{ old('color_class', $feature->color_class) == 'purple' ? 'selected' : '' }}>🟣 Ungu (Purple)</option>
                </select>
                @error('color_class')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                <div class="color-swatches">
                    <div class="color-swatch" data-val="blue"   style="background:linear-gradient(135deg,#3b6cf9,#1d37db);" onclick="pickColor('blue')"></div>
                    <div class="color-swatch" data-val="gold"   style="background:linear-gradient(135deg,#f59e0b,#b45309);" onclick="pickColor('gold')"></div>
                    <div class="color-swatch" data-val="red"    style="background:linear-gradient(135deg,#f04438,#b42318);" onclick="pickColor('red')"></div>
                    <div class="color-swatch" data-val="green"  style="background:linear-gradient(135deg,#12b76a,#027a48);" onclick="pickColor('green')"></div>
                    <div class="color-swatch" data-val="purple" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9);" onclick="pickColor('purple')"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="order">
                    <i class="fas fa-sort-numeric-down" style="margin-right:5px; color:var(--text-tertiary);"></i>
                    Urutan Tampil
                </label>
                <input type="number" name="order" id="order" class="form-control @error('order') is-error @enderror"
                    value="{{ old('order', $feature->order) }}" min="0" max="99">
                @error('order')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                <div class="form-hint">Angka lebih kecil tampil lebih dulu</div>
            </div>
        </div>

        {{-- Icon Image --}}
        <div class="form-group" style="margin-top:20px; margin-bottom:20px;">
            <label for="icon_image">
                <i class="fas fa-image" style="margin-right:5px; color:var(--text-tertiary);"></i>
                Upload Icon Image <span style="font-size:11px; color:var(--text-tertiary); font-weight:400;">(Opsional, diutamakan)</span>
            </label>
            @if($feature->icon_image)
                <div style="margin-bottom:12px; display:flex; align-items:center; gap:12px;">
                    <div style="width:48px; height:48px; background:#f1f5f9; border-radius:8px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                        <img src="{{ Storage::url($feature->icon_image) }}" alt="Current Icon" style="width:32px; height:32px; object-fit:contain;">
                    </div>
                    <span style="font-size:13px; color:var(--text-secondary);">Gambar saat ini. Unggah file baru untuk mengganti.</span>
                </div>
            @endif
            <input type="file" name="icon_image" id="icon_image" class="form-control @error('icon_image') is-error @enderror" accept="image/png,image/jpeg,image/svg+xml">
            @error('icon_image')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            <div class="form-hint">Format disarankan: PNG transparan hitam/putih. Jika diisi, akan otomatis menimpa Icon SVG dan warnanya akan tersinkronisasi.</div>
        </div>

        <div class="form-group" style="margin-bottom:0; margin-top:4px;">
            <label for="icon_svg">
                <i class="fas fa-code" style="margin-right:5px; color:var(--text-tertiary);"></i>
                Icon SVG <span style="font-size:11px; color:var(--text-tertiary); font-weight:400;">(Opsional)</span>
            </label>
            <textarea name="icon_svg" id="icon_svg" class="form-control @error('icon_svg') is-error @enderror"
                rows="3" style="font-family:'JetBrains Mono',monospace; font-size:12.5px;">{{ old('icon_svg', $feature->icon_svg) }}</textarea>
            @error('icon_svg')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            <div class="form-hint">Biarkan kosong untuk icon default. Gunakan SVG 24×24.</div>
        </div>
    </div>

</form>

    {{-- Actions --}}
    <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:24px;">
        <button type="submit" class="btn btn-primary" id="submitBtn" form="editFeatureForm">
            <i class="fas fa-save"></i> Simpan Perubahan
        </button>
        <a href="{{ route('admin.features.index') }}" class="btn btn-outline">
            <i class="fas fa-times"></i> Batal
        </a>
        {{-- Danger zone --}}
        <form action="{{ route('admin.features.destroy', $feature) }}" method="POST" style="margin-left:auto;"
            onsubmit="return confirm('Hapus fitur \'{{ addslashes($feature->title) }}\' secara permanen?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash-alt"></i> Hapus Fitur
            </button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
const gradients = {
    blue:   'linear-gradient(135deg,#3b6cf9,#1d37db)',
    gold:   'linear-gradient(135deg,#f59e0b,#b45309)',
    red:    'linear-gradient(135deg,#f04438,#b42318)',
    green:  'linear-gradient(135deg,#12b76a,#027a48)',
    purple: 'linear-gradient(135deg,#8b5cf6,#6d28d9)',
};
function pickColor(val) {
    document.getElementById('colorSelect').value = val;
    updateSwatch(val);
}
function updateSwatch(val) {
    document.querySelectorAll('.color-swatch').forEach(s => {
        const isActive = s.dataset.val === val;
        s.classList.toggle('active', isActive);
        s.innerHTML = isActive ? '<i class="fas fa-check"></i>' : '';
    });
}
updateSwatch(document.getElementById('colorSelect').value);

document.getElementById('description').addEventListener('input', function () {
    const len = this.value.length;
    document.getElementById('descCount').textContent = len + ' / 300';
    document.getElementById('descCount').style.color = len > 270 ? 'var(--danger-500)' : 'var(--text-tertiary)';
});

document.getElementById('editFeatureForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
});
</script>
@endsection
