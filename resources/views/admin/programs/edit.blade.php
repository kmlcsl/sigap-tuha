@extends('layouts.admin')
@section('header_title', 'Edit Program')

@section('content')

{{-- Page Header --}}
<div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
    <div>
        <h1 class="page-header__title">
            <i class="fas fa-pen-to-square" style="color:var(--brand-500); margin-right:10px; font-size:22px;"></i>
            Edit Program
        </h1>
        <p class="page-header__desc">Ubah informasi program: <strong>{{ $program->nama }}</strong></p>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('admin.programs.show', $program) }}" class="btn btn-outline btn-sm">
            <i class="fas fa-folder-open"></i> Lihat Kegiatan
        </a>
        <a href="{{ route('admin.programs.index') }}" class="btn btn-outline">
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

{{-- Info Bar --}}
<div style="padding:14px 20px; background:var(--brand-50); border:1px solid var(--brand-100); border-radius:var(--radius-lg); display:flex; align-items:center; gap:12px; margin-bottom:24px; flex-wrap:wrap;">
    <i class="fas fa-info-circle" style="color:var(--brand-500); font-size:18px; flex-shrink:0;"></i>
    <div style="flex:1; min-width:0;">
        <span style="font-size:13.5px; color:var(--text-secondary);">
            Program ini memiliki <strong>{{ $program->kegiatans->count() }}</strong> kegiatan.
            Mengubah nama program tidak akan memengaruhi kegiatan yang ada.
        </span>
    </div>
    <a href="{{ route('admin.programs.show', $program) }}" class="btn btn-primary btn-sm">
        <i class="fas fa-tasks"></i> Kelola Kegiatan
    </a>
</div>

<div style="max-width:860px;">
    <div class="card">
        <div class="card__header">
            <h3 class="card__title"><i class="fas fa-edit"></i> Form Edit Program</h3>
            <span style="font-size:12px; color:var(--text-tertiary);">
                <i class="far fa-clock"></i> Diperbarui: {{ $program->updated_at->format('d M Y, H:i') }}
            </span>
        </div>

        <form action="{{ route('admin.programs.update', $program) }}" method="POST" id="editForm">
            @csrf @method('PUT')

            {{-- Nama Program --}}
            <div class="form-group">
                <label for="nama">
                    <i class="fas fa-tag" style="margin-right:5px; color:var(--text-tertiary);"></i>
                    Nama Program <span class="required">*</span>
                </label>
                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-error @enderror"
                    value="{{ old('nama', $program->nama) }}" required maxlength="200"
                    placeholder="Contoh: Program Kesehatan Lansia">
                @error('nama')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="form-group">
                <label for="deskripsi">
                    <i class="fas fa-align-left" style="margin-right:5px; color:var(--text-tertiary);"></i>
                    Deskripsi Program
                </label>
                <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-error @enderror"
                    rows="5" maxlength="1000"
                    placeholder="Tuliskan deskripsi program...">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
                <div class="form-hint" style="display:flex; justify-content:space-between;">
                    <span>Opsional. Tampil di halaman detail program.</span>
                    <span id="charCount" style="font-weight:600; color:var(--text-tertiary);">{{ strlen(old('deskripsi', $program->deskripsi)) }} / 1000</span>
                </div>
            </div>

            <div style="border-top:1px solid var(--border-secondary); margin:24px 0;"></div>

            {{-- Actions --}}
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.programs.index') }}" class="btn btn-outline">
                    <i class="fas fa-times"></i> Batal
                </a>

                {{-- Danger Zone --}}
                <form action="{{ route('admin.programs.destroy', $program) }}" method="POST"
                    style="margin-left:auto;"
                    onsubmit="return confirm('Hapus program ini secara permanen beserta semua kegiatannya?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i> Hapus Program
                    </button>
                </form>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
const deskInput = document.getElementById('deskripsi');
const charCount = document.getElementById('charCount');

deskInput.addEventListener('input', () => {
    const len = deskInput.value.length;
    charCount.textContent = len + ' / 1000';
    charCount.style.color = len > 900 ? 'var(--danger-500)' : 'var(--text-tertiary)';
});

document.getElementById('editForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
});
</script>
@endsection
