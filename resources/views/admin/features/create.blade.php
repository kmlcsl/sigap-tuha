@extends('layouts.admin')
@section('header_title', 'Tambah Fitur Baru')

@section('styles')
<style>
/* ── Responsive Form Grid ── */
.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.form-grid-full {
    grid-column: 1 / -1;
}
@media (max-width: 600px) {
    .form-grid-2 { grid-template-columns: 1fr; }
}

.page-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}

/* Color preview swatch */
.color-swatches { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px; }
.color-swatch {
    width: 36px; height: 36px;
    border-radius: var(--radius-md);
    cursor: pointer;
    border: 3px solid transparent;
    transition: all .2s;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 12px;
}
.color-swatch.active { border-color: var(--text-primary); transform: scale(1.15); }
</style>
@endsection

@section('content')

{{-- Page Header --}}
<div class="page-header-row">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-plus-circle" style="color:var(--success-500); margin-right:10px; font-size:22px;"></i>
            Tambah Fitur Baru
        </h1>
        <p class="page-header__desc">Buat kartu fitur baru yang akan tampil di halaman beranda SIGAP TUHA.</p>
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
<form action="{{ route('admin.features.store') }}" method="POST" id="featureForm">
@csrf

    {{-- SECTION 1: Konten Utama --}}
    <div class="card" style="margin-bottom:20px;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-pen"></i> Konten Fitur</h3>
            <span style="font-size:12px; color:var(--text-tertiary);"><span style="color:var(--danger-500);">*</span> Wajib diisi</span>
        </div>

        <div class="form-group">
            <label for="title">
                <i class="fas fa-heading" style="margin-right:5px; color:var(--text-tertiary);"></i>
                Judul Fitur <span class="required">*</span>
            </label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-error @enderror"
                value="{{ old('title') }}" required maxlength="100"
                placeholder="Contoh: Pendataan Lansia">
            @error('title')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            <div class="form-hint">Akan tampil sebagai judul kartu di halaman beranda</div>
        </div>

        <div class="form-group">
            <label for="description">
                <i class="fas fa-align-left" style="margin-right:5px; color:var(--text-tertiary);"></i>
                Deskripsi Singkat
            </label>
            <textarea name="description" id="description" class="form-control @error('description') is-error @enderror"
                rows="3" maxlength="300"
                placeholder="Jelaskan secara singkat tentang fitur ini...">{{ old('description') }}</textarea>
            @error('description')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            <div class="form-hint" style="display:flex; justify-content:space-between;">
                <span>Opsional. Maks 300 karakter.</span>
                <span id="descCount" style="font-weight:600; color:var(--text-tertiary);">0 / 300</span>
            </div>
        </div>
    </div>

    {{-- SECTION 2: Tampilan --}}
    <div class="card" style="margin-bottom:20px;">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-palette"></i> Tampilan & Urutan</h3>
        </div>

        <div class="form-grid-2">
            {{-- Warna --}}
            <div class="form-group">
                <label>
                    <i class="fas fa-palette" style="margin-right:5px; color:var(--text-tertiary);"></i>
                    Warna Aksen
                </label>
                <select name="color_class" id="colorSelect" class="form-control @error('color_class') is-error @enderror"
                    onchange="updateSwatch(this.value)">
                    <option value="blue"   {{ old('color_class','blue') == 'blue'   ? 'selected' : '' }}>🔵 Biru (Brand)</option>
                    <option value="gold"   {{ old('color_class') == 'gold'   ? 'selected' : '' }}>🟡 Emas (Gold)</option>
                    <option value="red"    {{ old('color_class') == 'red'    ? 'selected' : '' }}>🔴 Merah (Danger)</option>
                    <option value="green"  {{ old('color_class') == 'green'  ? 'selected' : '' }}>🟢 Hijau (Success)</option>
                    <option value="purple" {{ old('color_class') == 'purple' ? 'selected' : '' }}>🟣 Ungu (Purple)</option>
                </select>
                @error('color_class')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror

                {{-- Visual swatches --}}
                <div class="color-swatches" id="swatchRow">
                    <div class="color-swatch active" data-val="blue" style="background:linear-gradient(135deg,#3b6cf9,#1d37db);" onclick="pickColor('blue')"><i class="fas fa-check"></i></div>
                    <div class="color-swatch" data-val="gold" style="background:linear-gradient(135deg,#f59e0b,#b45309);" onclick="pickColor('gold')"></div>
                    <div class="color-swatch" data-val="red" style="background:linear-gradient(135deg,#f04438,#b42318);" onclick="pickColor('red')"></div>
                    <div class="color-swatch" data-val="green" style="background:linear-gradient(135deg,#12b76a,#027a48);" onclick="pickColor('green')"></div>
                    <div class="color-swatch" data-val="purple" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9);" onclick="pickColor('purple')"></div>
                </div>
            </div>

            {{-- Urutan --}}
            <div class="form-group">
                <label for="order">
                    <i class="fas fa-sort-numeric-down" style="margin-right:5px; color:var(--text-tertiary);"></i>
                    Urutan Tampil
                </label>
                <input type="number" name="order" id="order" class="form-control @error('order') is-error @enderror"
                    value="{{ old('order', $features->count() + 1) }}" min="0" max="99">
                @error('order')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
                <div class="form-hint"><i class="fas fa-info-circle" style="font-size:10px;"></i> Angka lebih kecil tampil lebih dulu</div>
            </div>
        </div>

        {{-- Icon SVG --}}
        <div class="form-group" style="margin-bottom:0;">
            <label for="icon_svg">
                <i class="fas fa-code" style="margin-right:5px; color:var(--text-tertiary);"></i>
                Icon SVG <span style="font-size:11px; color:var(--text-tertiary); font-weight:400;">(Opsional)</span>
            </label>
            <textarea name="icon_svg" id="icon_svg" class="form-control @error('icon_svg') is-error @enderror"
                rows="3" style="font-family:'JetBrains Mono', monospace; font-size:12.5px;"
                placeholder="<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; ...>...</svg>">{{ old('icon_svg') }}</textarea>
            @error('icon_svg')<div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>@enderror
            <div class="form-hint">Biarkan kosong untuk menggunakan icon bintang default. Gunakan SVG 24x24.</div>
        </div>
    </div>

    {{-- Preview --}}
    <div class="card" style="margin-bottom:24px; padding:20px;">
        <div style="font-size:12px; font-weight:600; color:var(--text-tertiary); text-transform:uppercase; letter-spacing:.06em; margin-bottom:14px;">
            <i class="fas fa-eye" style="margin-right:6px;"></i> Preview Kartu
        </div>
        <div id="previewCard" style="max-width:300px; background:var(--gray-50); border:1px solid var(--border-secondary); border-radius:var(--radius-xl); overflow:hidden;">
            <div id="previewHeader" style="height:6px; background:linear-gradient(135deg,#3b6cf9,#1d37db);"></div>
            <div style="padding:18px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                    <div id="previewIcon" style="width:44px; height:44px; border-radius:var(--radius-md); background:linear-gradient(135deg,#3b6cf9,#1d37db); display:flex; align-items:center; justify-content:center; color:#fff; font-size:18px;">
                        <i class="fas fa-star"></i>
                    </div>
                    <span style="font-size:11px; font-weight:700; color:var(--text-tertiary);">#1</span>
                </div>
                <div id="previewTitle" style="font-size:15px; font-weight:800; color:var(--text-primary); margin-bottom:6px;">Nama Fitur...</div>
                <div id="previewDesc" style="font-size:12.5px; color:var(--text-secondary); line-height:1.6;">Deskripsi fitur muncul di sini...</div>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div style="display:flex; gap:12px; flex-wrap:wrap; padding-bottom:8px;">
        <button type="submit" class="btn btn-primary" id="submitBtn">
            <i class="fas fa-save"></i> Simpan Fitur
        </button>
        <a href="{{ route('admin.features.index') }}" class="btn btn-outline">
            <i class="fas fa-times"></i> Batal
        </a>
    </div>

</form>
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
    const g = gradients[val] || gradients.blue;
    document.getElementById('previewHeader').style.background = g;
    document.getElementById('previewIcon').style.background   = g;
}

// Live preview
document.getElementById('title').addEventListener('input', function () {
    document.getElementById('previewTitle').textContent = this.value || 'Nama Fitur...';
});
document.getElementById('description').addEventListener('input', function () {
    document.getElementById('previewDesc').textContent = this.value || 'Deskripsi fitur muncul di sini...';
    const len = this.value.length;
    document.getElementById('descCount').textContent = len + ' / 300';
    document.getElementById('descCount').style.color = len > 270 ? 'var(--danger-500)' : 'var(--text-tertiary)';
});
document.getElementById('order').addEventListener('input', function () {
    document.getElementById('previewCard').querySelector('span').textContent = '#' + (this.value || '1');
});

// Init swatch
updateSwatch(document.getElementById('colorSelect').value);

// Prevent double submit
document.getElementById('featureForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
});
</script>
@endsection
